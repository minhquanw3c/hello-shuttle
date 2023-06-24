<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
	protected $table = 'customers';
	protected $primaryKey = 'customer_id';

	protected $allowedFields = [
        'customer_id',
		'first_name',
        'last_name',
        'phone',
        'email',
        'is_registered',
        'username',
        'password',
        'created_at',
        'updated_at',
	];

    public function createCustomer($data)
    {
        $save_query = $this->insert($data, false);

        return $save_query;
    }

    // public function getBookingById($booking_id)
    // {
    //     $get_booking_query = $this->select([
    //         'bookings.booking_id AS bookingId',
    //         'bookings.booking_data AS bookingData',
    //         'bookings.booking_status AS bookingStatusId',
    //         'bookings.payment_link_id AS bookingPaymentLinkId',
    //         'bookings.payment_status AS bookingPaymentStatus',
    //         'bookings.checkout_session_id AS bookingCheckoutSessionId',
    //         'bookings.booking_created_at AS bookingCreatedAt',
    //     ])
    //     ->where('booking_id', $booking_id)
    //     ->findAll();

    //     return $get_booking_query;
    // }

    // public function updateBookingById($booking_id, $data)
    // {
    //     $update_query = $this->update(
    //         $booking_id,
    //         $data
    //     );

    //     return $update_query;
    // }
}