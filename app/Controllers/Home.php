<?php

namespace App\Controllers;

use App\Models\ConfigModel;
use App\Models\BookingModel;
use App\Models\BookingScheduleModel;
use \TCPDF as TCPDF;

use CodeIgniter\I18n\Time;
use DateTime;

class Home extends BaseController
{
    public function index()
    {
        $booking_id = now() . random_string('alnum', 10);

        $policy_file_path = base_url('/static/contents/policy.json');
        // $policy_file = file_get_contents($policy_file_path);
        // $policies = json_decode($policy_file, true);

        $data = [
            'bookingId' => $booking_id,
            'enviroment' => $_SERVER['CI_ENVIRONMENT'],
            'dashboardUrl' => $this->getResourcesURLs('dashboard'),
            // 'policies' => $policies['policies'],
            'policies' => []
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
        $one_way_cars_data = [];
        $round_trip_cars = [];
        $round_trip_cars_data = [];

        $one_way_cars_payload = [
            'date' => $booking_data->oneWayTrip->pickup->date,
            'time' => $booking_data->oneWayTrip->pickup->time,
            'passengers' => $booking_data->oneWayTrip->passengers,
            'luggages' => $booking_data->oneWayTrip->luggages,
        ];

        $one_way_cars = $booking_schedule_model->findAvailableCarsTwo($one_way_cars_payload);
        // $one_way_cars = $one_way_cars_data['availableCars'];

        if ($booking_data->tripType == 'round-trip') {
            $round_trip_cars_payload = [
                'date' => $booking_data->roundTrip->pickup->date,
                'time' => $booking_data->roundTrip->pickup->time,
                'passengers' => $booking_data->roundTrip->passengers,
                'luggages' => $booking_data->roundTrip->luggages,
            ];

            $round_trip_cars = $booking_schedule_model->findAvailableCarsTwo($round_trip_cars_payload);
            // $round_trip_cars = $round_trip_cars_data['availableCars'];
        }

        $response = [
            'result' => 'success',
            'oneWayCarsData' => $one_way_cars_data,
            'oneWayCars' => $one_way_cars,
            'roundTripCarsData' => $round_trip_cars_data,
            'roundTripCars' => $round_trip_cars,
        ];

        return $this->response->setJSON($response);
    }

    public function saveBooking()
    {
        $booking_data = $this->request->getJsonVar('form');
        $booking_id = $booking_data->bookingId;
        $customer_uuid = null;

        $booking_model = model(BookingModel::class);

        $customer_data = $booking_data->bookingRequirements->review->customer;
        $login_data = $booking_data->loginForm;

        $customer_handler = new CustomerController();
        $user_handler = new UserController();

        if ($login_data->hasRegistered) {
            $customer_uuid = $booking_data->accountId;

            if (!$customer_handler->checkCustomerExisted($customer_uuid)) {
                $customer_handler->createCustomer($customer_data, $booking_data->accountId);
            }
        } else {
            $customer_uuid = $customer_handler->createCustomer($customer_data);

            if ($customer_data->registerAccount) {
                $user_successfully_created = $user_handler->createUser($customer_data, $customer_uuid);

                if ($user_successfully_created) {
                    $user_handler->generateAccountActivationLink($customer_data->contact->email);
                }
            }
        }

        $payment_data = [
            'bookingId' => $booking_id,
            'totalPrice' => $booking_data->bookingRequirements->review->prices->total,
        ];

        $payment_link_data = (object) $this->testStripePayment($payment_data);
        $payment_link = $payment_link_data->url;
        $payment_link_id = $payment_link_data->id;
        $string_length = 20;
        $cancel_session_id = random_string('alnum', $string_length);

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
            'cancel_session_id' => $cancel_session_id,
        ];

        $save_booking_query = $booking_model->saveBooking($data);

        $create_booking_schedule = $this->createBookingSchedule($booking_data->bookingRequirements, $booking_id);

        $response = [
            'result' => $save_booking_query,
            'paymentLink' => $payment_link,
            'bookingSchedules' => $create_booking_schedule,
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

    public function calculateTripRefundAmount($booking_data, $trip_type)
    {
        $config_model = model(ConfigModel::class);
        $valid_full_refund_hours = $config_model->getConfigById('cfg-rfd-tm')[0]['configValue'];
        $invalid_full_refund_percentage = $config_model->getConfigById('cfg-ivld-frd')[0]['configValue'];

        $has_purchased_booking_insurance = $this->checkPurchasedInsurance($booking_data->chooseOptions->{$trip_type}->protection);

        $cancel_booking_request_time = Time::now('UTC');
        $refund_amount = 0.00;

        $is_full_refund_eligible = $this->checkEligibleRefundTime(
            $cancel_booking_request_time,
            $booking_data->bookingCreatedAt,
            $valid_full_refund_hours
        );

        if ($has_purchased_booking_insurance) {
            $protection_plan = $booking_data->chooseOptions->{$trip_type}->protection[0];
            $protection_price = floatval($protection_plan->configValue) * $protection_plan->quantity;

            $refund_amount = floatval($booking_data->review->prices->{$trip_type}) - $protection_price;
        } else if ($is_full_refund_eligible) {
            $refund_amount = floatval($booking_data->review->prices->{$trip_type});
        } else {
            $refund_amount = floatval($booking_data->review->prices->{$trip_type}) * ($invalid_full_refund_percentage / 100);
        }

        return round($refund_amount, 2);
    }

    public function cancelBookingGateway()
    {
        $request_method = $this->request->getMethod(true);

        if ($request_method === 'GET') {
            $booking_id = filter_var($this->request->getVar('booking_id'), FILTER_SANITIZE_STRING);
            $cancel_session_id = filter_var($this->request->getVar('cancel_session_id'), FILTER_SANITIZE_STRING);
        } else if ($request_method === 'POST') {
            $booking_id = filter_var($this->request->getJSONVar('booking_id'), FILTER_SANITIZE_STRING);
            $cancel_session_id = filter_var($this->request->getJSONVar('cancel_session_id'), FILTER_SANITIZE_STRING);
        }

        $cancel_result = $this->cancelBooking($booking_id, $cancel_session_id);

        if ($request_method === 'GET') {
            return $cancel_result['result'] === true ?
                view('templates/cancel_booking', ['dashboardUrl' => $this->getResourcesURLs('dashboard')]) :
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Not found');
        } else if ($request_method === 'POST') {
            return $this->response->setJSON($cancel_result);
        }
    }

    public function cancelBooking($booking_id, $cancel_session_id)
    {
        $response = [
            'result' => false,
            'message' => 'Error occurred'
        ];

        $booking_model = model(BookingModel::class);

        $booking = $booking_model->getBookingById($booking_id);

        if (count($booking) == 0) {
            return $response;
        }

        $booking = (object) $booking[0];

        if (!(strcmp($cancel_session_id, $booking->bookingCancelId) === 0)) {
            return $response;
        }

        $booking_data = json_decode($booking->bookingData);

        if (!($booking->bookingStatusId == 'bk-sts-prsng')) {
            return $response;
        }

        if ($booking->bookingPaymentStatus === 'pmst-paid') {
            $is_booking_already_refunded = $this->checkBookingIsRefunded($booking->bookingCheckoutSessionId);

            if ($is_booking_already_refunded) {
                return $response;
            }

            $booking_data->bookingCreatedAt = $booking->bookingCreatedAt;

            $refund_amount_one_way = $this->calculateTripRefundAmount($booking_data, 'oneWayTrip');
            $refund_amount_round_trip = $this->calculateTripRefundAmount($booking_data, 'roundTrip');
            $discount_amount = round($booking_data->review->prices->discountAmount, 2);
            $stripe_decimal_converter = 100;

            $total_refund_amount = (($refund_amount_one_way + $refund_amount_round_trip) - $discount_amount) * $stripe_decimal_converter;

            $refund_result = $this->refundBooking($booking->bookingCheckoutSessionId, $total_refund_amount);

            $update_booking_status = $booking_model->updateBookingById(
                $booking_id,
                [
                    'payment_status' => 'pmst-refunded',
                    'booking_updated_at' => Time::now('UTC'),
                ]
            );

            $notify_email_result = $this->notifyCustomerRefundStatus($booking_data->review->customer->contact->email, $booking_id, true);

            $response = [
                'result' => $refund_result,
                'sendRefundEmail' => $notify_email_result,
                'refund' => $refund_result,
                'updateBooking' => $update_booking_status,
            ];
        }

        if ($booking->bookingPaymentStatus === 'pmst-pending') {
            $update_booking_status = $booking_model->updateBookingById(
                $booking_id,
                [
                    'payment_status' => 'pmst-cancelled',
                    'booking_updated_at' => Time::now('UTC'),
                ]
            );

            $notify_email_result = $this->notifyCustomerRefundStatus($booking_data->review->customer->contact->email, $booking_id, false);

            $response = [
                'sendRefundEmail' => $notify_email_result,
                'updateBooking' => $update_booking_status,
                'dashboardUrl' => $this->getResourcesURLs('dashboard'),
            ];
        }

        $booking_model->updateBookingById(
            $booking_id,
            [
                'booking_status' => 'bk-sts-cnl',
                'booking_updated_at' => Time::now('UTC'),
            ]
        );

        $this->disablePaymentLink($booking->bookingPaymentLinkId);
        $this->removeBookingSchedules($booking_id);

        $response = [
            'result' => true,
            'message' => 'Booking cancelled successfully',
        ];

        return $response;
    }

    private function notifyCustomerRefundStatus($recipient, $booking_id, $is_payment_paid)
    {
        $config_model = model(ConfigModel::class);
        $booking_model = model(BookingModel::class);

        $config = $config_model->getEmailSender();
        $sender = $config['configValue'];

        $booking_ref_no = $booking_model->getColumnValueByKeys($booking_id, 'booking_ref_no');

        $email_subject = $is_payment_paid ? 'Refund for booking: ' . $booking_ref_no : 'Cancel confirmation for booking: ' . $booking_ref_no;

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
                break;
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

    public function generateBookingReceipt($pdf_template, $booking_ref_no)
    {
        // Create a new PDF instance
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

        // Set document information
        $pdf->SetCreator('Hello Shuttle');
        $pdf->SetAuthor('Hello Shuttle Billing Department');
        $pdf->SetTitle('Hello Shuttle - Booking receipt on ' . now());
        $pdf->SetSubject('Booking receipt');
        $pdf->SetKeywords('Hello Shuttle, Booking receipt, Car rental');

        // Set default font settings
        $pdf->SetFont('helvetica', '', 10);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Add a page
        $pdf->AddPage();

        // Set the HTML content as the PDF content
        $pdf->writeHTML($pdf_template, true, false, true, false, '');

        // Specify the path to the folder where you want to save the PDF
        $savePath = WRITEPATH . '/receipts/pdf/';

        // Generate a unique filename for the PDF
        $filename = 'helloshuttle-receipt-' . $booking_ref_no . '.pdf';

        // Save the PDF to the specified folder
        $pdf->Output($savePath . $filename, 'F');

        return $filename;
    }

    private function generateBookingCancelLink($booking_id, $cancel_session_id)
    {
        $cancel_booking_link = base_url('/cancel?booking_id=' . $booking_id . '&cancel_session_id=' . $cancel_session_id);

        return $cancel_booking_link;
    }

    public function generateSampleBookingReceipt()
    {
        $booking_model = model(BookingModel::class);
        $latest_booking = $booking_model->asObject()->select('*')->join('payment_status', 'payment_status.payment_status_id = bookings.payment_status')->orderBy('booking_ref_no', 'desc')->first();

        if (!$latest_booking) {
            return view('templates/page_not_found', ['dashboardUrl' => $this->getResourcesURLs('dashboard')]);
        }

        $latest_booking_data = json_decode($latest_booking->booking_data);
        $latest_booking_data->bookedAt = $latest_booking->booking_created_at;
        $latest_booking_data->bookingRefNo = $latest_booking->booking_ref_no;
        $latest_booking_data->paymentStatus = $latest_booking->payment_status_desc;

        $pdf_template = view('templates/pdf/booking_receipt/test_receipt_layout', ['bookingData' => $latest_booking_data, 'bookingRefNo' => $latest_booking_data->bookingRefNo]);

        // Create a new PDF instance
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

        // Set document information
        $pdf->SetCreator('Hello Shuttle');
        $pdf->SetAuthor('Hello Shuttle Billing Department');
        $pdf->SetTitle('Hello Shuttle - Booking receipt on ' . now());
        $pdf->SetSubject('Booking receipt');
        $pdf->SetKeywords('Hello Shuttle, Booking receipt, Car rental');

        // Set default font settings
        $pdf->SetFont('helvetica', '', 10);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // $pdf->Image($hello_shuttle_logo, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add a page
        $pdf->AddPage();

        // Set the HTML content as the PDF content
        $pdf->writeHTML($pdf_template, true, false, true, false, '');

        // Specify the path to the folder where you want to save the PDF
        $savePath = WRITEPATH . '/receipts/pdf/';

        // Generate a unique filename for the PDF
        $filename = 'test-receipt-' . now() . '.pdf';

        // Save the PDF to the specified folder
        $pdf->Output($savePath . $filename, 'F');

        $file_path = $savePath . $filename;

        // Set the appropriate headers for PDF content
        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->response->setHeader("Content-Length", filesize($file_path));

        // Read and output the PDF file
        return readfile($file_path);
    }

    public function sendBookingReceiptEmail($booking_data, $booking_id)
    {
        # $config_model = model(ConfigModel::class);
        $booking_model = model(BookingModel::class);

        // $config = $config_model->getEmailSender();
        // $sender = $config['configValue'];

        $recipient = $booking_data->review->customer->contact->email;
        $booking_ref_no = $booking_model->getColumnValueByKeys($booking_id, 'booking_ref_no');

        $email_subject = $booking_ref_no . ' Congratulations! Your trip has been successfully booked!';

        $cancel_session_id = $booking_model->getColumnValueByKeys($booking_id, 'cancel_session_id');
        $cancel_booking_link = $this->generateBookingCancelLink($booking_id, $cancel_session_id);

        $message = view('templates/mail/booking_receipt', array(
            'cancelBookingLink' => $cancel_booking_link,
            'bookingData' => $booking_data,
        ));

        $pdf_content = view(
            'templates/pdf/booking_receipt/test_receipt_layout',
            array(
                'bookingData' => $booking_data,
                'bookingRefNo' => $booking_ref_no,
            ),
            ['debug' => false]
        );

        $pdf_receipt_name = $this->generateBookingReceipt($pdf_content, $booking_ref_no);

        $receiptsPath = WRITEPATH . 'receipts/pdf/' . $pdf_receipt_name;

        $email = \Config\Services::email();

        $email->setFrom(isset($_SERVER["CI_ENVIRONMENT"]) && $_SERVER["CI_ENVIRONMENT"] === "production"
            ? $_SERVER["PROD_MAIL_USER"]
            : $_SERVER["LOCALHOST_MAIL_USER"]);
        $email->setTo($recipient);
        $email->setSubject($email_subject);
        $email->setMessage($message);
        $email->attach($receiptsPath);

        $send_email_result = $email->send(false);

        $response['result'] = $send_email_result;
        $response['message'] = $send_email_result ? $email->printDebugger() : $email->printDebugger();

        return $response;
    }

    private function removeBookingSchedules($booking_id)
    {
        $booking_schedule_model = model(BookingScheduleModel::class);

        $remove_booking_schedule_result = $booking_schedule_model->removeBookingSchedule($booking_id);

        return $remove_booking_schedule_result;
    }

    private function createBookingSchedule($receipt_data, $booking_id)
    {
        $ACTIVE_SCHEDULE = 1;
        $booking_schedule_model = model(BookingScheduleModel::class);

        $trip_type = $receipt_data->reservation->tripType;

        $one_way_car_id = $receipt_data->selectCar->oneWayTrip->vehicle->carId;
        $one_way_car_booked_date = $receipt_data->reservation->oneWayTrip->pickup->date;
        $one_way_car_booked_time = $receipt_data->reservation->oneWayTrip->pickup->time;

        $booking_schedules = [
            [
                'booking_id' => $booking_id,
                'car_id' => $one_way_car_id,
                'scheduled_date' => $one_way_car_booked_date,
                'scheduled_time' => $one_way_car_booked_time,
                'schedule_active' => $ACTIVE_SCHEDULE,
            ]
        ];

        if ($trip_type == 'round-trip') {
            $round_trip_car_id = $receipt_data->selectCar->roundTrip->vehicle->carId;
            $round_trip_car_booked_date = $receipt_data->reservation->roundTrip->pickup->date;
            $round_trip_car_booked_time = $receipt_data->reservation->roundTrip->pickup->time;

            array_push($booking_schedules, [
                'booking_id' => $booking_id,
                'car_id' => $round_trip_car_id,
                'scheduled_date' => $round_trip_car_booked_date,
                'scheduled_time' => $round_trip_car_booked_time,
                'schedule_active' => $ACTIVE_SCHEDULE,
            ]);
        }

        $create_booking_schedule_result = $booking_schedule_model->createBookingSchedule($booking_schedules);

        return $create_booking_schedule_result;
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
        $receipt_data = json_decode($booking['bookingData']);
        $receipt_data->bookedAt = $booking['bookingCreatedAt'];
        $receipt_data->bookingRefNo = $booking['bookingRefNo'];
        $receipt_data->paymentStatus = $booking['paymentStatusDesc'];

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

        $send_receipt = $this->sendBookingReceiptEmail($receipt_data, $booking_id);

        $response = [
            'bookingId' => $booking_id,
            'result' => $update_booking_result,
            'sendBookingReceipt' => $send_receipt,
            'dashboardUrl' => $this->getResourcesURLs('dashboard'),
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
            'name' => 'Payment for booking No: ' . $booking_id,
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

    public function getPrivacyAndPolicy()
    {
        $policy_file_path = base_url('/static/contents/policy.json');
        $terms_file_path = base_url('/static/contents/terms.json');

        $policy_file = file_get_contents($policy_file_path);
        $term_file = file_get_contents($terms_file_path);

        $policies = json_decode($policy_file, true);
        $terms = json_decode($term_file, true);

        $data = [
            'dashboardUrl' => $this->getResourcesURLs('dashboard'),
            'policies' => $policies['policies'],
            'terms' => $terms['terms'],
        ];

        return view('frontend/privacy_policy', $data);
    }

    public function getResourcesURLs($resource_type)
    {
        $current_env = strtolower($_SERVER['CI_ENVIRONMENT']);

        $resources = (object) [];

        $resources->form = $current_env === 'production' ? $_SERVER['PROD_FORM_DOMAIN'] : 'http://localhost/projects/hello-shuttle/public/';
        $resources->dashboard = $current_env === 'production' ? $_SERVER['PROD_DASHBOARD_DOMAIN'] : 'http://localhost/projects/hello-shuttle-dashboard/public/';

        return $resources->{$resource_type};
    }
}
