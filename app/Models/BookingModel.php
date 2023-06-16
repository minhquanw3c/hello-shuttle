<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
	protected $table = 'bookings';
	protected $primaryKey = 'booking_id';

	protected $allowedFields = [
        'booking_id',
		'booking_data',
        'payment_link',
        'payment_status',
        'checkout_session_id',
        'booking_created_at',
        'booking_updated_at',
	];

    public function saveBooking($data)
    {
        $save_query = $this->insert($data, false);

        return $save_query;
    }

    public function getBookingById($booking_id)
    {
        $get_booking_query = $this->select([
            'bookings.booking_id AS bookingId',
            'bookings.payment_status AS bookingPaymentStatus',
            'bookings.checkout_session_id AS bookingCheckoutSessionId',
        ])
        ->where('booking_id', $booking_id)
        ->findAll();

        return $get_booking_query;
    }

    public function updateBookingById($booking_id, $data)
    {
        $update_query = $this->update(
            $booking_id,
            $data
        );

        return $update_query;
    }
}