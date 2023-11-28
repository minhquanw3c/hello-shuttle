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
        $config_cars_builder_extra = $this->db->table('config_cars c');
        $booking_schedules_builder_first = $this->db->table('booking_schedules r');
        $booking_schedules_builder_second = $this->db->table('booking_schedules rs');

        $conflicting_cars = $booking_schedules_builder_first
            ->select('r.car_id')
            ->distinct()
            ->groupStart()
                ->orGroupStart()
                    ->where([
                        'r.estimated_complete_date IS NOT' => NULL,
                        'r.estimated_complete_time IS NOT' => NULL
                    ])
                    ->groupStart()
                        ->where('r.estimated_complete_date <', $desiredDate)
                        ->orGroupStart()
                            ->where([
                                'r.estimated_complete_date =' => $desiredDate,
                                'r.estimated_complete_time <=' => $desiredTime
                            ])
                        ->groupEnd()
                    ->groupEnd()
                ->groupEnd()
                ->orGroupStart()
                    ->where('r.scheduled_date >', $desiredDate)
                    ->orGroupStart()
                        ->where([
                            'r.scheduled_date =' => $desiredDate,
                            'r.scheduled_time >=' => $desiredTime
                        ])
                    ->groupEnd()
                ->groupEnd()
                ->orGroupStart()
                    ->where([
                        'r.estimated_complete_date IS' => NULL,
                        'r.estimated_complete_time IS' => NULL
                    ])
                ->groupEnd()
            ->groupEnd()
            ->where('r.schedule_active', 1)
            //->getCompiledSelect();
            ->get()
            ->getResultObject();
        
        if (count($conflicting_cars) > 0) {
            $conflicting_cars = array_map(
                function($car) {
                    return $car->car_id;
                },
                $conflicting_cars
            );
        }

        $cars_config = $config_cars_builder->select(['c.car_id', 'c.car_quantity'])->where('c.car_active', 1)->get()->getResultObject();
        $exceeding_quantity_cars = [];

        if (count($cars_config) > 0) {
            $temp_car_id = null;

            foreach ($cars_config as $config) {
                $temp_car_id = $booking_schedules_builder_second
                    ->select('rs.car_id')
                    ->where('rs.schedule_active', 1)
                    ->groupBy('rs.car_id')
                    ->having('COUNT(*) >', intval($config->car_quantity))
                    ->get()
                    ->getResultObject();

                if (count($temp_car_id) > 0) {
                    array_push($exceeding_quantity_cars, $temp_car_id[0]->car_id);
                }

                $temp_car_id = null;
            }

            // $exceeding_quantity_cars = array_unique($exceeding_quantity_cars);
        }

        $unavailable_cars = array_merge($conflicting_cars, $exceeding_quantity_cars);

        $available_cars = $config_cars_builder_extra
                    ->select([
                        'c.car_id AS carId',
                        'c.car_name AS carName',
                        'c.car_image AS carImage',
                        'c.car_seats_capacity AS carSeats',
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
                    ->join('config_cars_price', 'config_cars_price.car_id = c.car_id')
                    ->where('c.car_active', 1)
                    ->where('config_cars_price.max_passengers >=', $params['passengers'])
                    ->get()
                    ->getResultObject();

        foreach ($available_cars as $car) {
            in_array($car->carId, $unavailable_cars) ? $car->available = false : $car->available = true;
        }

        $response = [
            'conflictingCars' => $conflicting_cars,
            'carsConfig' => $cars_config,
            'exceedingQuantityCars' => $exceeding_quantity_cars,
            'unavailableCars' => $unavailable_cars,
            'availableCars' => $available_cars,
        ];

        return $response;
    }
    
    public function findAvailableCarsTwo($params)
    {
        $date = $params['date'];
        $time = $params['time'];
        $passengers = $params['passengers'];

        $sql_query = "SELECT c.car_id AS carId, 1 AS available, c.car_active AS carActive,
        c.car_name AS carName,
        c.car_image AS carImage,
        c.car_seats_capacity AS carSeats,
        --
        ccp.open_door_price AS openDoorPrice,
        --
        ccp.first_miles AS firstMiles,
        ccp.first_miles_price AS firstMilesPrice,
        ccp.first_miles_price_active AS firstMilesPriceActive,
        --
        ccp.second_miles AS secondMiles,
        ccp.second_miles_price AS secondMilesPrice,
        ccp.second_miles_price_active AS secondMilesPriceActive,
        --
        ccp.third_miles AS thirdMiles,
        ccp.third_miles_price AS thirdMilesPrice,
        ccp.third_miles_price_active AS thirdMilesPriceActive,
        --
        ccp.admin_fee_type AS adminFeeType,
        ccp.admin_fee_limit_miles AS adminFeeLimitMiles,
        ccp.admin_fee_percentage AS adminFeePercentage,
        ccp.admin_fee_fixed_amount AS adminFeeFixedAmount,
        ccp.admin_fee_active AS adminFeeActive,
        --
        ccp.pickup_fee_type AS pickupFeeType,
        ccp.pickup_fee_limit_miles AS pickupFeeLimitMiles,
        ccp.pickup_fee_percentage AS pickupFeePercentage,
        ccp.pickup_fee_fixed_amount AS pickupFeeFixedAmount,
        ccp.pickup_fee_active AS pickupFeeActive,
        --
        ccp.max_luggages AS maxLuggages,
        ccp.free_luggages_quantity AS freeLuggagesQuantity,
        ccp.extra_luggages_price AS extraLuggagesPrice,
        --
        ccp.max_passengers AS maxPassengers,
        ccp.free_passengers_quantity AS freePassengersQuantity,
        ccp.extra_passengers_price AS extraPassengersPrice
        FROM config_cars c
        JOIN config_cars_price ccp ON ccp.car_id = c.car_id
        WHERE c.car_id NOT IN (
            SELECT r.car_id
            FROM booking_schedules r
            WHERE (
                -- Check if the reservation has an estimated complete date and time, and it ends before the desired date and time
                (r.estimated_complete_date IS NOT NULL AND r.estimated_complete_time IS NOT NULL AND 
                    (
                        r.estimated_complete_date < ? OR
                        (r.estimated_complete_date = ? AND r.estimated_complete_time <= ?)
                    )
                ) OR (
                    -- Check if the reservation has a scheduled date and time, and it starts after the desired date and time
                    r.scheduled_date > ? OR
                    (r.scheduled_date = ? AND r.scheduled_time >= ?)
                ) OR (
                    -- Check for open-ended reservations (where estimated_complete_date and estimated_complete_time are both NULL)
                    r.estimated_complete_date IS NULL AND r.estimated_complete_time IS NULL
                )
            ) AND r.schedule_active = 1  -- Only active bookings are considered
        ) AND c.car_id NOT IN (
            SELECT r.car_id
            FROM booking_schedules r
            GROUP BY r.car_id
            HAVING COUNT(*) >= c.car_quantity
        ) AND ccp.max_passengers >= ? AND c.car_active = 1";

        return $this->db->query($sql_query, [$date, $date, $time, $date, $date, $time, $passengers])->getResult();
    }

}