<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivationTokenModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class UserController extends BaseController
{
    public function createUser($user_data, $user_id)
    {
        $INACTIVE_USER = 0;
        $ACTIVE_USER = 1;
        $ROLE_CUSTOMER = 'customer';
        $user_model = model(UserModel::class);

        if (!$this->validateUserData($user_data)) {
            return;
        }

        // $user_existed = $user_model->getRowsByColumn('user_email', $user_data->contact->email);

        // if ($user_existed) {
        //     return;
        // }

        $data = [
            'user_id' => $user_id,
            'user_email' => $user_data->contact->email,
            'user_phone' => $user_data->contact->mobileNumber,
            'user_hashed_password' => password_hash($user_data->account->password, PASSWORD_DEFAULT),
            'user_first_name' => $user_data->firstName,
            'user_last_name' => $user_data->lastName,
            'user_role' => $ROLE_CUSTOMER,
            'user_active' => $ACTIVE_USER,
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

    public function getUserDataFromBookingForm()
    {
        $form = $this->request->getJsonVar('form', true);

        $response = [
            'errorMessages' => [],
            'result' => true,
            'user' => [],
        ];

        $user_data = [
            'email' => $form['email'],
            'password' => $form['password'],
        ];

        $validation = \Config\Services::validation();

        $validation->setRules([
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email must be a valid email address',
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password is required',
                ],
            ],
        ]);

        $input_validity = $validation->run($user_data);

        if (!$input_validity) {
            $response['errorMessages'] = array_values($validation->getErrors());
            $response['result'] = false;
            return $this->response->setJSON($response);
        }

        $user_model = model(UserModel::class);
        $user = $user_model->getUserById($user_data['email']);

        if (count($user) == 0) {
            array_push($response['errorMessages'], "Email not existed");
            $response['result'] = false;
            return $this->response->setJSON($response);
        }

        $user = $user[0];
        $hash = $user['userPassword'];

        if (!password_verify($user_data['password'], $hash)) {
            array_push($response['errorMessages'], "Email or password is incorrect");
            $response['result'] = false;
            return $this->response->setJSON($response);
        };

        $response['user']['firstName'] = $user['userFirstName'];
        $response['user']['lastName'] = $user['userLastName'];
        $response['user']['email'] = $user['userEmail'];
        $response['user']['phone'] = $user['userPhone'];
        $response['user']['accountId'] = $user['userId'];

        return $this->response->setJSON($response);
    }

    public function validateRegisterAccountEmail()
    {
        $email = $this->request->getJsonVar('email');

        $response = [
            'result' => null,
        ];

        $user_model = model(UserModel::class);

        $email_existed = $user_model->getRowsByColumn('user_email', $email);

        $response['result'] = $email_existed ? false : true;

        return $this->response->setJSON($response);
    }
}
