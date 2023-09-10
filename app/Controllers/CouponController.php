<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CouponModel;

use DateTime;
use DateTimeZone;

class CouponController extends BaseController
{
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
