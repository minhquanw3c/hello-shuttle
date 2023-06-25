<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
	protected $table = 'coupons';
	protected $primaryKey = 'coupon_id';

	protected $allowedFields = [
        'coupon_id',
		'coupon_code',
        'discount_amount',
        'is_percentage',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
	];

    public function createCoupon($data)
    {
        $save_query = $this->insert($data, false);

        return $save_query;
    }

    public function getCoupons()
    {
        $get_coupons_query = $this->select([
            'coupons.coupon_id AS couponId',
            'coupons.coupon_code AS couponCode',
            'coupons.discount_amount AS couponDiscountAmount',
            'coupons.is_percentage AS couponIsPercentage',
            'coupons.start_date AS couponStartDate',
            'coupons.end_date AS couponEndDate',
        ])
        ->findAll();

        return $get_coupons_query;
    }

    public function getCoupon($coupon_code)
    {
        $get_coupon_query = $this->select([
            'coupons.coupon_id AS couponId',
            'coupons.coupon_code AS couponCode',
            'coupons.discount_amount AS couponDiscountAmount',
            'coupons.is_percentage AS couponIsPercentage',
            'coupons.start_date AS couponStartDate',
            'coupons.end_date AS couponEndDate',
        ])
        ->where('coupon_code', $coupon_code)
        ->findAll();

        return $get_coupon_query;
    }

    public function updateCouponById($coupon_id, $data)
    {
        $update_query = $this->update(
            $coupon_id,
            $data
        );

        return $update_query;
    }
}