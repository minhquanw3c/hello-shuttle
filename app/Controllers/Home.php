<?php

namespace App\Controllers;

use App\Models\ConfigModel;
use App\Models\BookingModel;
use \TCPDF as TCPDF;
use Ramsey\Uuid\Uuid;

use CodeIgniter\I18n\Time;
use DateTime;
use DateTimeZone;

class Home extends BaseController
{
    public function index()
    {
        $booking_id = now() . random_string('alnum', 10);

        $data = [
            'bookingId' => $booking_id,
            'enviroment' => $_SERVER['CI_ENVIRONMENT'],
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

        $booking_schedule_model = model(BookingScheduleModel::class);

        $one_way_cars = [];
        $round_trip_cars = [];

        $booking_date = $booking_data->oneWayTrip->pickup->date;
        $one_way_cars = $booking_schedule_model->getAvailableCarsForDate($booking_date);

        if ($booking_data->tripType == 'round-trip') {
            $round_trip_booking_date = $booking_data->roundTrip->pickup->date;

            $round_trip_cars = $booking_schedule_model->getAvailableCarsForDate($round_trip_booking_date);
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
        $customer_model = model(CustomerModel::class);

        $customer_uuid = Uuid::uuid4()->toString();

        $customer_data = [
            'customer_id' => $customer_uuid,
            'first_name' => $booking_data->bookingRequirements->review->customer->firstName,
            'last_name' => $booking_data->bookingRequirements->review->customer->lastName,
            'phone' => $booking_data->bookingRequirements->review->customer->contact->mobileNumber,
            'email' => $booking_data->bookingRequirements->review->customer->contact->email,
            'created_at' => Time::now('UTC'),
            'updated_at' => Time::now('UTC'),
        ];

        $customer_model->createCustomer($customer_data);

        $payment_data = [
            'bookingId' => $booking_id,
            'totalPrice' => $booking_data->bookingRequirements->review->prices->total,
        ];

        $payment_link_data = (object) $this->testStripePayment($payment_data);
        $payment_link = $payment_link_data->url;
        $payment_link_id = $payment_link_data->id;

        $data = [
            'booking_id' => $booking_id,
            'booking_data' => json_encode($booking_data->bookingRequirements),
            'payment_link' => $payment_link,
            'payment_link_id' => $payment_link_id,
            'payment_status' => 'pmst-pending',
            'booking_status' => 'bk-sts-prsng',
            'checkout_session_id' => 'n/a',
            'booking_created_at' => Time::now('UTC'),
            'booking_updated_at' => Time::now('UTC'),
            'booked_by_customer' => $customer_uuid,
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

    private function checkBookingIsRefunded($checkout_id)
    {
        require_once(APPPATH . 'Libraries/stripe/init.php');

        $refunded = true;

        $config_model = model(ConfigModel::class);
        $stripe_payment_key = $config_model->getConfigById('cfg-stripe-key')[0]['configValue'];

        $stripe = new \Stripe\StripeClient($stripe_payment_key);

        $checkout_session_data = $stripe->checkout->sessions->retrieve(
            $checkout_id,
            []
        );

        $payment_intent = $checkout_session_data->payment_intent;

        $payment_intent_object = $stripe->paymentIntents->retrieve(
            $payment_intent,
            []
        );

        $latest_charge = $payment_intent_object->latest_charge;

        $charge_object = $stripe->charges->retrieve(
            $latest_charge,
            []
        );

        return $charge_object->refunded == true ? $refunded : !$refunded;
    }

    public function cancelBooking()
    {
        $booking_id = filter_var($this->request->getVar('booking_id'), FILTER_SANITIZE_STRING);
        $cancel_session_id = filter_var($this->request->getVar('cancel_session_id'), FILTER_SANITIZE_STRING);

        $booking_model = model(BookingModel::class);

        $booking = $booking_model->getBookingById($booking_id);

        if (count($booking) == 0) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Not found');
        }

        $booking = (object) $booking[0];
        $booking_data = json_decode($booking->bookingData);

        if (!($booking->bookingPaymentStatus == 'pmst-paid')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Not found');
        }

        if (!($booking->bookingStatusId == 'bk-sts-prsng')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Not found');
        }

        $is_booking_already_refunded = $this->checkBookingIsRefunded($booking->bookingCheckoutSessionId);

        if ($is_booking_already_refunded) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Not found');
        }

        $config_model = model(ConfigModel::class);
        $valid_full_refund_hours = $config_model->getConfigById('cfg-rfd-tm')[0]['configValue'];
        $invalid_full_refund_percentage = $config_model->getConfigById('cfg-ivld-frd')[0]['configValue'];

        $has_purchased_booking_insurance = [
            'one-way' => $this->checkPurchasedInsurance($booking_data->chooseOptions->oneWayTrip->protection),
            'round-trip' => $this->checkPurchasedInsurance($booking_data->chooseOptions->roundTrip->protection),
        ];

        $cancel_booking_request_time = Time::now('UTC');

        $is_full_refund_eligible = [
            'one-way' => $this->checkEligibleRefundTime(
                $cancel_booking_request_time,
                $booking->bookingCreatedAt,
                $valid_full_refund_hours,
            ),
            'round-trip' => $this->checkEligibleRefundTime(
                $cancel_booking_request_time,
                $booking->bookingCreatedAt,
                $valid_full_refund_hours,
            ),
        ];

        $refund_amount_one_way = 0.00;
        $refund_amount_round_trip = 0.00;

        if ($has_purchased_booking_insurance['one-way'] || $is_full_refund_eligible['one-way']) {
            $refund_amount_one_way = $booking_data->review->prices->oneWayTrip;
        } else {
            $refund_amount_one_way = $booking_data->review->prices->oneWayTrip * ($invalid_full_refund_percentage / 100);
        }

        if ($booking_data->reservation->tripType == 'round-trip') {
            if ($has_purchased_booking_insurance['round-trip'] || $is_full_refund_eligible['round-trip']) {
                $refund_amount_round_trip = $booking_data->review->prices->roundTrip;
            } else {
                $refund_amount_round_trip = $booking_data->review->prices->roundTrip * ($invalid_full_refund_percentage / 100);
            }
        }

        $refund_amount_one_way = round($refund_amount_one_way, 2);
        $refund_amount_round_trip = round($refund_amount_round_trip, 2);
        $discount_amount = round($booking_data->review->prices->discountAmount, 2);

        $total_refund_amount = (($refund_amount_one_way + $refund_amount_round_trip) - $discount_amount) * 100;

        $refund_result = $this->refundBooking($booking->bookingCheckoutSessionId, $total_refund_amount);

        $update_booking_status = $booking_model->updateBookingById(
            $booking_id,
            [
                'booking_status' => 'bk-sts-cnl',
                'payment_status' => 'pmst-refunded',
                'booking_updated_at' => Time::now('UTC'),
            ]
        );

        $notify_email_result = $this->notifyCustomerRefundStatus($booking_data->review->customer->contact->email, $booking_id);

        $response = [
            'result' => $refund_result,
            'sendRefundEmail' => $notify_email_result,
            'refund' => $refund_result,
            'updateBooking' => $update_booking_status,
        ];

        return view('templates/confirmation', $response);
    }

    private function notifyCustomerRefundStatus($recipient, $booking_id)
    {
        $config_model = model(ConfigModel::class);
        $booking_model = model(BookingModel::class);

        $config = $config_model->getEmailSender();
        $sender = $config['configValue'];

        $booking_ref_no = $booking_model->getColumnValueByKeys($booking_id, 'booking_ref_no');

        $email_subject = 'Refund for booking: ' . $booking_ref_no;

        $message = view('templates/mail/refund_confirmation');

        $email = \Config\Services::email();

        $email->setFrom($sender);
        $email->setTo($recipient);
        $email->setSubject($email_subject);
        $email->setMessage($message);

        $send_email_result = $email->send(false);

        $response['result'] = $send_email_result;
        $response['message'] = $send_email_result ? 'Email sent successfully.' : $email->printDebugger();

        return $response;
    }

    private function refundBooking($checkout_id, $refund_amount)
    {
        require_once(APPPATH . 'Libraries/stripe/init.php');

        $config_model = model(ConfigModel::class);
        $stripe_payment_key = $config_model->getConfigById('cfg-stripe-key')[0]['configValue'];

        $stripe = new \Stripe\StripeClient($stripe_payment_key);

        $checkout_session_data = $stripe->checkout->sessions->retrieve(
            $checkout_id,
            []
        );

        $payment_intent = $checkout_session_data->payment_intent;

        $refund_result = $stripe->refunds->create([
            'payment_intent' => $payment_intent,
            'amount' => $refund_amount,
        ]);

        return $refund_result->status == 'succeeded' ? true : false;
    }

    private function checkEligibleRefundTime($request_time, $booking_created_time, $valid_hours)
    {
        $is_eligible = true;

        $dateString1 = $booking_created_time;
        $dateString2 = $request_time;
        $durationInMinutes = $valid_hours * 60;

        $dateTime1 = new DateTime($dateString1);
        $dateTime2 = new DateTime($dateString2);

        $interval = $dateTime1->diff($dateTime2);
        $duration = ($interval->h * 60) + $interval->i; // Calculate duration in minutes

        if ($duration > $durationInMinutes) {
            $is_eligible = false;
        }

        return $is_eligible;
    }

    private function checkPurchasedInsurance($trip_data)
    {
        $purchased_insurance = false;

        foreach ($trip_data as $option) {
            if ($option->configId == 'bk-insurance') {
                $purchased_insurance = true;
            }
        }

        return $purchased_insurance;
    }

    public function sendBookingPaymentLinkEmail($payment_data)
    {
        $config_model = model(ConfigModel::class);
        $booking_model = model(BookingModel::class);

        $config = $config_model->getEmailSender();
        $sender = $config['configValue'];

        $recipient = $payment_data->customer->contact->email;

        $booking_ref_no = $booking_model->getColumnValueByKeys($payment_data->bookingId, 'booking_ref_no');
        $payment_data->bookingRefNo = $booking_ref_no;

        $email_subject = 'Stripe payment link for booking: ' . $booking_ref_no;

        $message = view('templates/mail/booking_payment_link', array('paymentData' => $payment_data));

        $email = \Config\Services::email();

        $email->setFrom($sender);
        $email->setTo($recipient);
        $email->setSubject($email_subject);
        $email->setMessage($message);

        $send_email_result = $email->send(false);

        $response['result'] = $send_email_result;
        $response['message'] = $send_email_result ? $email->printDebugger() : $email->printDebugger();

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

    private function generateBookingCancelLink($booking_id)
    {
        $string_length = 20;
        $cancel_session_id = random_string('alnum', $string_length);

        $cancel_booking_link = base_url('/cancel?booking_id=' . $booking_id . '&cancel_session_id=' . $cancel_session_id);

        $booking_model = model(BookingModel::class);

        $save_booking_cancel_session = $booking_model->updateBookingById(
            $booking_id,
            [
                'cancel_session_id' => $cancel_session_id,
            ]
        );

        return $cancel_booking_link;
    }

    public function sendBookingReceiptEmail($booking_data, $booking_id)
    {
        $config_model = model(ConfigModel::class);
        $booking_model = model(BookingModel::class);

        $config = $config_model->getEmailSender();
        $sender = $config['configValue'];

        $recipient = $booking_data->review->customer->contact->email;
        $booking_ref_no = $booking_model->getColumnValueByKeys($booking_id, 'booking_ref_no');

        $email_subject = $booking_ref_no . ' Congratulations! Your trip has been successfully booked!';

        $cancel_booking_link = $this->generateBookingCancelLink($booking_id);

        $message = view('templates/mail/booking_receipt', array('cancelBookingLink' => $cancel_booking_link, 'bookingData' => $booking_data));
        $pdf_content = view('templates/pdf/booking_info', array('bookingData' => $booking_data), ['debug' => false]);

        $this->generateBookingReceipt($pdf_content, $booking_id);

        $receiptsPath = WRITEPATH . 'receipts/pdf/' . $booking_id . '.pdf';

        $email = \Config\Services::email();

        $email->setFrom($sender);
        $email->setTo($recipient);
        $email->setSubject($email_subject);
        $email->setMessage($message);
        $email->attach($receiptsPath);

        $send_email_result = $email->send(false);

        $response['result'] = $send_email_result;
        $response['message'] = $send_email_result ? $email->printDebugger() : $email->printDebugger();

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

        // TO-DO
        // Check if Strip checkout session id is valid, and payment_status is paid

        $this->disablePaymentLink($booking['bookingPaymentLinkId']);

        $update_booking_data = [
            'payment_status' => 'pmst-paid',
            'checkout_session_id' => $session_checkout_id,
            'booking_updated_at' => Time::now('UTC'),
        ];

        $update_booking_result = $booking_model->updateBookingById($booking_id, $update_booking_data);

        $booking_schedule_model = model(BookingScheduleModel::class);

        $receipt_data = json_decode($booking['bookingData']);

        $trip_type = $receipt_data->reservation->tripType;

        $one_way_car_id = $receipt_data->selectCar->oneWayTrip->vehicle->carId;
        $one_way_car_booked_date = $receipt_data->reservation->oneWayTrip->pickup->date;

        $booking_schedules = [
            [
                'booking_id' => $booking_id,
                'car_id' => $one_way_car_id,
                'scheduled_date' => $one_way_car_booked_date,
            ]
        ];

        if ($trip_type == 'round-trip') {
            $round_trip_car_id = $receipt_data->selectCar->roundTrip->vehicle->carId;
            $round_trip_car_booked_date = $receipt_data->reservation->roundTrip->pickup->date;

            array_push($booking_schedules, [
                'booking_id' => $booking_id,
                'car_id' => $round_trip_car_id,
                'scheduled_date' => $round_trip_car_booked_date,
            ]);
        }

        $create_booking_schedule_result = $booking_schedule_model->createBookingSchedule($booking_schedules);

        $send_receipt = $this->sendBookingReceiptEmail($receipt_data, $booking_id);

        $response = [
            'bookingId' => $booking_id,
            'result' => $update_booking_result,
            'sendBookingReceipt' => $send_receipt,
            'createBookingSchedule' => $create_booking_schedule_result,
        ];

        return view('templates/confirmation', $response);
    }

    private function disablePaymentLink($payment_link_id)
    {
        require_once(APPPATH . 'Libraries/stripe/init.php');

        $config_model = model(ConfigModel::class);
        $stripe_payment_key = $config_model->getConfigById('cfg-stripe-key')[0]['configValue'];

        $stripe = new \Stripe\StripeClient($stripe_payment_key);

        $stripe->paymentLinks->update(
            $payment_link_id,
            ['active' => false]
        );
    }

    public function testStripePayment($booking_data)
    {
        require_once(APPPATH . 'Libraries/stripe/init.php');

        $booking_id = $booking_data['bookingId'];
        $payment_successful_redirect_url = base_url('/');

        $config_model = model(ConfigModel::class);
        $stripe_payment_key = $config_model->getConfigById('cfg-stripe-key')[0]['configValue'];

        $stripe = new \Stripe\StripeClient($stripe_payment_key);

        $product = $stripe->products->create([
            'name' => 'Car booking No ' . $booking_id,
        ]);

        $price = $stripe->prices->create([
            'unit_amount' => $booking_data['totalPrice'] * 100,
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
        return [
            'url' => $payment_link->url,
            'id' => $payment_link->id,
        ];
    }

    public function testClickSend()
    {
        require_once(APPPATH . 'Libraries/clicksend/vendor/autoload.php');

        // Configure HTTP basic authorization: BasicAuth
        $config = \ClickSend\Configuration::getDefaultConfiguration()
            ->setUsername('minhquanw3c@gmail.com')
            ->setPassword('8B772285-1D5B-166A-E5E8-2D41A1E7BF5C');

        $apiInstance = new \ClickSend\Api\SMSApi(new \GuzzleHttp\Client(), $config);
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
        } catch (\Exception $e) {
            echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function validateCoupon()
    {
        $response = [
            'result' => false,
            'message' => 'Invalid coupon'
        ];

        $coupon_in_request = $this->request->getVar('couponCode');

        $coupon_model = model(CouponModel::class);
        $coupon_in_db = $coupon_model->getCoupon($coupon_in_request);

        if (count($coupon_in_db) == 0) {
            return $this->response->setJSON($response);
        }

        $coupon = (object) $coupon_in_db[0];
        $current_date = new DateTime('now', new DateTimeZone('UTC'));
        $current_date = $current_date->format('Y-m-d');
        $current_date = new DateTime($current_date, new DateTimeZone('UTC'));

        $coupon_start_date = new DateTime($coupon->couponStartDate, new DateTimeZone('UTC'));
        $coupon_end_date = new DateTime($coupon->couponEndDate, new DateTimeZone('UTC'));

        if (!($current_date >= $coupon_start_date && $current_date <= $coupon_end_date)) {
            return $this->response->setJSON($response);
        }

        $response['result'] = true;
        $response['message'] = 'Coupon applied successfully';
        $response['coupon'] = $coupon;

        return $this->response->setJSON($response);
    }
}
