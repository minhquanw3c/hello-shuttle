<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivationTokenModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class UserController extends BaseController
{
    public function createUser($user_data)
    {
        $INACTIVE_USER = 0;
        $ROLE_CUSTOMER = 'customer';
        $user_model = model(UserModel::class);

        if (!$this->validateUserData($user_data)) {
            return;
        }

        $user_existed = $user_model->getRowsByColumn('user_email', $user_data->contact->email);

        if ($user_existed) {
            return;
        }

        $data = [
            'user_email' => $user_data->contact->email,
            'user_hashed_password' => password_hash($user_data->account->password, PASSWORD_DEFAULT),
            'user_first_name' => $user_data->firstName,
            'user_last_name' => $user_data->lastName,
            'user_role' => $ROLE_CUSTOMER,
            'user_active' => $INACTIVE_USER,
            'user_created_at' => Time::now('UTC'),
            'user_updated_at' => Time::now('UTC'),
        ];

        $result = $user_model->createUser($data);

        return $result;
    }

    public function validateUserData($user_data)
    {
        return true;
    }

    public function generateAccountActivationLink($user_id)
    {
        $token_model = model(ActivationTokenModel::class);

        $token_data = $token_model->generateToken();

        $activation_data = [
            'user_id' => $user_id,
            'token' => $token_data['token'],
            'token_type' => 'account-activation',
            'token_expired_at' => $token_data['expired_at'],
            'token_used_at' => null,
            'token_created_at' => Time::now('UTC'),
            'token_updated_at' => Time::now('UTC'),
        ];

        $token_model->saveActivationToken($activation_data);

        $url = base_url('/auth/acount-activation?token=' . $token_data['token'] . '&user_id=' . $user_id);

        $email_handler = new EmailController();

        $mail_data = [
            'recipient' => $user_id,
            'subject' => 'Hello Shuttle account activation',
            'message' => 'Click on this link to activate your account: ' . $url,
        ];

        $email_handler->sendEmail((object) $mail_data);

        return $url;
    }
}
