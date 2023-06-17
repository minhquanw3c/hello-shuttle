<?php

namespace App\Controllers;
use App\Models\ConfigModel;
use App\Models\BookingModel;
use \TCPDF as TCPDF;

use CodeIgniter\I18n\Time;

class Home extends BaseController
{
    public function index()
    {
        $booking_id = now() . random_string();

        $data = [
            'bookingId' => $booking_id,
        ];

        return view('frontend/form', $data);
    }

    public function getConfigList()
    {
        $config_model = model(ConfigModel::class);

        $config_list = $config_model->getConfigList();

        $response = [
            'result' => 'success',
            'configs' => $config_list,
        ];

        return $this->response->setJSON($response);
    }

    public function getAvailableCarsList()
    {
        $booking_data = $this->request->getVar('form');

        $scheduled_cars_model = model(ScheduledCarsModel::class);

        $one_way_cars = [];
        $round_trip_cars = [];

        $booking_date = $booking_data->oneWayTrip->pickup->date;
        $one_way_cars = $scheduled_cars_model->getAvailableCarsForDate($booking_date);

        if ($booking_data->tripType == 'round-trip') {
            $round_trip_booking_date = $booking_data->roundTrip->pickup->date;

            $round_trip_cars = $scheduled_cars_model->getAvailableCarsForDate($round_trip_booking_date);
        }

        $response = [
            'result' => 'success',
            'oneWayCars' => $one_way_cars,
            'roundTripCars' => $round_trip_cars,
        ];

        return $this->response->setJSON($response);
    }

    public function saveBooking()
    {
        $booking_data = $this->request->getVar('form');
        $booking_id = $booking_data->bookingId;

        $booking_model = model(BookingModel::class);

        $payment_data = [
            'bookingId' => $booking_id,
            'totalPrice' => $booking_data->bookingRequirements->review->prices->total,
        ];

        $payment_link = $this->testStripePayment($payment_data);

        $data = [
            'booking_id' => $booking_id,
            'booking_data' => json_encode($booking_data->bookingRequirements),
            'payment_link' => $payment_link,
            'payment_status' => 'pmst-pending',
            'checkout_session_id' => 'n/a',
            'booking_created_at' => Time::now('UTC'),
            'booking_updated_at' => Time::now('UTC'),
        ];

        $save_booking_query = $booking_model->saveBooking($data);

        $response = [
            'result' => $save_booking_query,
            'paymentLink' => $payment_link
        ];

        $payment_data = [
            'bookingId' => $booking_id,
            'customer' => $booking_data->bookingRequirements->review->customer,
            'paymentLink' => $payment_link,
            'total' => $booking_data->bookingRequirements->review->prices->total,
            'bookingCreatedAt' => Time::now('UTC'),
        ];

        $send_payment_link = $this->sendBookingPaymentLinkEmail((object) $payment_data);

        $response['sendPaymentLinkEmail'] = $send_payment_link;

        return $this->response->setJSON($response);
    }

    public function cancelBooking()
    {

    }

    public function sendBookingPaymentLinkEmail($payment_data)
    {
        $config_model = model(ConfigModel::class);

        $config = $config_model->getEmailSender();
        $sender = $config['configValue'];

        $recipient = $payment_data->customer->contact->email;

        $email_subject = 'Stripe payment link for booking: ' . $payment_data->bookingId;

        $message = view('templates/mail/booking_payment_link', array('paymentData' => $payment_data));

        $email = \Config\Services::email();

        $email->setFrom($sender);
        $email->setTo($recipient);
        $email->setSubject($email_subject);
        $email->setMessage($message);

        $send_email_result = $email->send();

        $response['result'] = $send_email_result;
        $response['message'] = $send_email_result ? 'Email sent successfully.' : 'There are errors during sending email.';

        return $response;
    }

    public function generateBookingReceipt($pdf_template, $booking_id)
    {
        // Create a new PDF instance
        $pdf = new TCPDF('P', 'mm', 'LETTER', true, 'UTF-8');

        // Set document information
        $pdf->SetCreator('Your Name');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Sample PDF');
        $pdf->SetSubject('Generating PDF using TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, sample');

        // Set default font settings
        $pdf->SetFont('helvetica', '', 12);

        

        // Add a page
        $pdf->AddPage();

        // Set the HTML content as the PDF content
        $pdf->writeHTML($pdf_template, true, false, true, false, '');

        // Specify the path to the folder where you want to save the PDF
        $savePath = WRITEPATH . '/receipts/pdf/';

        // Generate a unique filename for the PDF
        $filename = $booking_id . '.pdf';

        // Save the PDF to the specified folder
        $pdf->Output($savePath . $filename, 'F');

    }

    public function sendBookingReceiptEmail($booking_data, $booking_id)
    {
        $config_model = model(ConfigModel::class);

        $config = $config_model->getEmailSender();
        $sender = $config['configValue'];

        $recipient = $booking_data->review->customer->contact->email;

        $email_subject = 'Receipt for booking: ' . $booking_id;

        $message = view('templates/mail/booking_receipt', array('bookingData' => $booking_data));
        $pdf_content = view('templates/pdf/booking_info', array('bookingData' => $booking_data), ['debug' => false]);
        // $pdf_content = "hello world";

        $this->generateBookingReceipt($pdf_content, $booking_id);

        $receiptsPath = WRITEPATH . 'receipts/' .$booking_id;

        $email = \Config\Services::email();

        $email->setFrom($sender);
        $email->setTo($recipient);
        $email->setSubject($email_subject);
        $email->setMessage($message);
        $email->attach($receiptsPath);

        $send_email_result = $email->send();

        $response['result'] = $send_email_result;
        $response['message'] = $send_email_result ? 'Email sent successfully.' : 'There are errors during sending email.';

        return $response;
    }

    public function confirmBookingPayment()
    {
        $booking_id = filter_var($this->request->getVar('booking_id'), FILTER_SANITIZE_STRING);
        $session_checkout_id = filter_var($this->request->getVar('session_id'), FILTER_SANITIZE_STRING);

        $booking_model = model(BookingModel::class);

        $booking = $booking_model->getBookingById($booking_id);

        if (count($booking) == 0) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Not found');
        }

        $booking = $booking[0];

        if ($booking['bookingPaymentStatus'] != 'pmst-pending') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Not found');
        }

        $update_booking_data = [
            // 'payment_status' => 'pmst-paid',
            'checkout_session_id' => $session_checkout_id,
            'booking_updated_at' => Time::now('UTC'),
        ];

        $update_booking_result = $booking_model->updateBookingById($booking_id, $update_booking_data);

        $receipt_data = json_decode($booking['bookingData']);

        $send_receipt = $this->sendBookingReceiptEmail($receipt_data, $booking_id);

        $response = [
            'bookingId' => $booking_id,
            'result' => $update_booking_result,
            'sendBookingReceipt' => $send_receipt,
        ];

        return view('templates/confirmation');
    }

    public function testStripePayment($booking_data)
    {
        require_once(APPPATH . 'Libraries/stripe/init.php');

        $booking_id = $booking_data['bookingId'];
        $payment_successful_redirect_url = base_url('/');

        $stripe = new \Stripe\StripeClient('sk_test_51N5oaiL3WCB4PP1wjgWKk5DIYSyCBHDV9YcnNqFaozUV8qoDeHyqeH6CQ2tgq7VlF7EYckPUYlQ72H64bj7wmtjC00LuWcpiNA');

        $product = $stripe->products->create([
            'name' => 'Car booking No ' . $booking_id,
        ]);

        $price = $stripe->prices->create([
            'unit_amount' => $booking_data['totalPrice'],
            'currency' => 'usd',
            'product' => $product->id,
        ]);

        $payment_link = $stripe->paymentLinks->create([
            'line_items' => [
                [
                    'price' => $price->id,
                    'quantity' => 1,
                ]
            ],
            'after_completion' => [
                'type' => 'redirect',
                'redirect' => [
                    'url' => $payment_successful_redirect_url . '/confirmation?session_id={CHECKOUT_SESSION_ID}&booking_id=' . $booking_id
                ]
            ],
        ]);

        // $checkout_session = $stripe->checkout->sessions->create([
        //     'line_items' => [
        //         [
        //             'price' => $price->id,
        //             'quantity' => 1,
        //         ]
        //     ],
        //     'success_url' => 'https://www.dannythedesigner.com?session_id={CHECKOUT_SESSION_ID}&booking_id=' . $booking_id,
        //     'mode' => 'payment',
        // ]);

        $response = [
            'product' => $product,
            'price' => $price,
            'paymentLink' => $payment_link,
            // 'checkoutSession' => $checkout_session,
        ];

        // return $this->response->setJSON($response);
        return $payment_link->url;
    }

    public function testClickSend()
    {
        require_once(APPPATH . 'Libraries/clicksend/vendor/autoload.php');

        // Configure HTTP basic authorization: BasicAuth
        $config = \ClickSend\Configuration::getDefaultConfiguration()
                ->setUsername('minhquanw3c@gmail.com')
                ->setPassword('8B772285-1D5B-166A-E5E8-2D41A1E7BF5C');

        $apiInstance = new \ClickSend\Api\SMSApi(new \GuzzleHttp\Client(),$config);
        $msg = new \ClickSend\Model\SmsMessage();
        $msg->setBody("the message is not received from my mobile phone"); 
        $msg->setTo("0941610700");
        $msg->setSource("sdk");
        
        // \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model
        $sms_messages = new \ClickSend\Model\SmsMessageCollection(); 
        // $sms_messages->setMessages([$msg]);
        
        try {
            $result = $apiInstance->smsSendPost($sms_messages);
            return $this->response->setJSON($result);
        } catch (Exception $e) {
            echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
        }
    }
}
