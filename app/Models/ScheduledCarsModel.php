<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduledCarsModel extends Model
{
	protected $table = 'scheduled_cars';
	protected $primaryKey = 'booking_id';

	protected $allowedFields = [
		'car_id',
        'scheduled_date',
	];

    public function getAvailableCarsForDate($date)
    {
        $get_list_query = $this->select([
            'config_cars.car_id AS carId',
            'config_cars.car_name AS carName',
            'config_cars.car_quantity - COUNT(scheduled_cars.booking_id) AS availableCars',
            'config_cars.car_start_price AS carStartPrice',
            'config_cars.car_image AS carImage',
        ])
        ->join('config_cars', 'config_cars.car_id = scheduled_cars.car_id AND scheduled_cars.scheduled_date = "' . $date . '"', 'right')
        ->groupBy('config_cars.car_id')
        // ->having('availableCars > 0')
        ->findAll();

        return $get_list_query;
    }
}