<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

use Ramsey\Uuid\Uuid;
use CodeIgniter\I18n\Time;

class CustomerController extends BaseController
{
    public function createCustomer($customer_data)
    {
        $customer_model = model(CustomerModel::class);
        $customer_uuid = null;

        if (!$this->validateCustomerData($customer_data)) {
            return $customer_uuid;
        }

        $customer_uuid = $this->generateCustomerUUID();

        $data = [
            'customer_id' => $customer_uuid,
            'first_name' => $customer_data->firstName,
            'last_name' => $customer_data->lastName,
            'phone' => $customer_data->contact->mobileNumber,
            'email' => $customer_data->contact->email,
            'register_account' => $customer_data->registerAccount,
            'created_at' => Time::now('UTC'),
            'updated_at' => Time::now('UTC'),
        ];

        $result = $customer_model->createCustomer($data);

        return $result ? $customer_uuid : null;
    }

    private function generateCustomerUUID()
    {
        $customer_uuid = Uuid::uuid4()->toString();

        return $customer_uuid;
    }

    public function validateCustomerData($customer_data)
    {
        return true;
    }
}
