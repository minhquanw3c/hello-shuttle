<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CarModel;

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

    public function findAvailableCars($params)
    {
        $desiredDate = $params['date'];
        $desiredTime = $params['time'];

        $config_cars_builder = $this->db->table('config_cars c');
        $booking_schedules_builder_first = $this->db->table('booking_schedules r');
        $booking_schedules_builder_second = $this->db->table('booking_schedules rs');

        $cars_first_conditions = $booking_schedules_builder_first
            ->select('r.car_id')
            ->groupStart()
                ->orGroupStart()
                    ->where([
                        'r.estimated_complete_date IS NOT ' => NULL,
                        'r.estimated_complete_time IS NOT ' => NULL
                    ])
                    ->groupStart()
                        ->where('r.estimated_complete_date < ', $desiredDate)
                        ->orGroupStart()
                            ->where([
                                'r.estimated_complete_date = ' => $desiredDate,
                                'r.estimated_complete_time <= ' => $desiredTime
                            ])
                        ->groupEnd()
                    ->groupEnd()
                ->groupEnd()
                ->orGroupStart()
                    ->where('r.scheduled_date > ', $desiredDate)
                    ->orGroupStart()
                        ->where([
                            'r.scheduled_date = ' => $desiredDate,
                            'r.scheduled_time >= ' => $desiredTime
                        ])
                    ->groupEnd()
                ->groupEnd()
                ->orGroupStart()
                    ->where([
                        'r.estimated_complete_date IS ' => NULL,
                        'r.estimated_complete_time IS ' => NULL
                    ])
                ->groupEnd()
            ->groupEnd()
            ->where('r.schedule_active', 1)
            //->getCompiledSelect();
            ->get()
            ->getResult();

        $cars = $config_cars_builder
            ->select('c.car_id')
            ->distinct()
            ->groupStart()
                ->whereNotIn(
                    'c.car_id',
                    $cars_first_conditions
                )
                ->whereNotIn(
                    'c.car_id',
                    $booking_schedules_builder_second
                        ->select('rs.car_id')
                        ->groupBy('rs.car_id')
                        ->having('COUNT(*) >= ', 'c.car_quantity')
                        ->get()
                        ->getResult()
                )
            ->groupEnd()
            ->getCompiledSelect();
            //->get()
            //->getResult();

        return $cars;
    }
}