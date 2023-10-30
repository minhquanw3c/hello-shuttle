<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingScheduleModel extends Model
{
	protected $table = 'booking_schedules';
	protected $primaryKey = 'booking_id';
    protected $useAutoIncrement = false;

	protected $allowedFields = [
        'schedule_id',
        'booking_id',
		'car_id',
        'scheduled_date',
        'scheduled_time',
        'estimated_complete_date',
        'estimated_complete_time',
        'schedule_active',
	];

    public function getAvailableCarsForDate($params)
    {
        $get_list_query = $this->select([
            'config_cars.car_id AS carId',
            'config_cars.car_name AS carName',
            'config_cars.car_quantity - COUNT(booking_schedules.booking_id) AS availableCars',
            'config_cars.car_image AS carImage',
            'config_cars.car_seats_capacity AS carSeats',
            //----
            'config_cars_price.open_door_price AS openDoorPrice',
            //----
            'config_cars_price.first_miles AS firstMiles',
            'config_cars_price.first_miles_price AS firstMilesPrice',
            'config_cars_price.first_miles_price_active AS firstMilesPriceActive',
            //----
            'config_cars_price.second_miles AS secondMiles',
            'config_cars_price.second_miles_price AS secondMilesPrice',
            'config_cars_price.second_miles_price_active AS secondMilesPriceActive',
            //----
            'config_cars_price.third_miles AS thirdMiles',
            'config_cars_price.third_miles_price AS thirdMilesPrice',
            'config_cars_price.third_miles_price_active AS thirdMilesPriceActive',
            //----
            'config_cars_price.admin_fee_type AS adminFeeType',
            'config_cars_price.admin_fee_limit_miles AS adminFeeLimitMiles',
            'config_cars_price.admin_fee_percentage AS adminFeePercentage',
            'config_cars_price.admin_fee_fixed_amount AS adminFeeFixedAmount',
            'config_cars_price.admin_fee_active AS adminFeeActive',
            //----
            'config_cars_price.pickup_fee_type AS pickupFeeType',
            'config_cars_price.pickup_fee_limit_miles AS pickupFeeLimitMiles',
            'config_cars_price.pickup_fee_percentage AS pickupFeePercentage',
            'config_cars_price.pickup_fee_fixed_amount AS pickupFeeFixedAmount',
            'config_cars_price.pickup_fee_active AS pickupFeeActive',
            //----
            'config_cars_price.max_luggages AS maxLuggages',
            'config_cars_price.free_luggages_quantity AS freeLuggagesQuantity',
            'config_cars_price.extra_luggages_price AS extraLuggagesPrice',
            //---
            'config_cars_price.max_passengers AS maxPassengers',
            'config_cars_price.free_passengers_quantity AS freePassengersQuantity',
            'config_cars_price.extra_passengers_price AS extraPassengersPrice',
        ])
        ->join('config_cars', 'config_cars.car_id = booking_schedules.car_id AND booking_schedules.scheduled_date = "' . $params['date'] . '"', 'right')
        ->join('config_cars_price', 'config_cars_price.car_id = config_cars.car_id')
        // Checking passengers and luggages quantity
        // ->where('config_cars_price.max_luggages >=', $params['luggages'])
        ->where('config_cars_price.max_passengers >=', $params['passengers'])
        ->groupBy('config_cars.car_id')
        ->findAll();

        // log_message('info', 'SQL query to get available cars: ', array());

        return $get_list_query;
    }

    public function createBookingSchedule($booking_schedules)
    {
        $create_schedules_query = $this->insertBatch($booking_schedules);

        return $create_schedules_query;
    }

    public function removeBookingSchedule($booking_id)
    {
        $INACTIVE_SCHEDULE = 0;

        $remove_schedules_query = $this->update($booking_id, ['schedule_active' => $INACTIVE_SCHEDULE]);

        return $remove_schedules_query;
    }
}