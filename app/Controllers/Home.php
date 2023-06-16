<?php

namespace App\Controllers;
use App\Models\ConfigModel;
use App\Models\BookingModel;

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

        return $this->response->setJSON($response);
    }

    public function cancelBooking()
    {

    }

    public function sendBookingReceiptEmail($data)
    {
        $sender = 'minhquanw3c@gmail.com';
        $recipient = $booking_data->customer->contact->email;
        $email_subject = 'Receipt for booking No. ';
        $message = view('templates/receipt', array('sender' => $sender, 'recipient' => $recipient));

        $email = \Config\Services::email();

        $email->setFrom($sender);
        $email->setTo($recipient);
        $email->setSubject($email_subject);
        $email->setMessage($message);

        $send_email_result = $email->send();

        if ($send_email_result == true) {
            $response['result'] = true;
            $response['message'] = 'Email sent successfully.';
        } else {
            $response['result'] = false;
            $response['message'] = 'There are errors during sending email.';
            $response['errorStack'] = $email->printDebugger(['headers']);
        }
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
            'payment_status' => 'pmst-paid',
            'checkout_session_id' => $session_checkout_id,
            'booking_updated_at' => Time::now('UTC'),
        ];

        $update_booking_result = $booking_model->updateBookingById($booking_id, $update_booking_data);

        $response = [
            'bookingId' => $booking_id,
            'result' => $update_booking_result,
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
