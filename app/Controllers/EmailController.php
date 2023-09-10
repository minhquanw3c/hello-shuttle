<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class EmailController extends BaseController
{
    public function sendEmail($data)
    {
        $config_model = model(ConfigModel::class);

        $config = $config_model->getEmailSender();
        $sender = $config['configValue'];

        $email = \Config\Services::email();

        $email->setFrom($sender);
        $email->setTo($data->recipient);
        $email->setSubject($data->subject);
        $email->setMessage($data->message);

        $send_email_result = $email->send(false);

        return $send_email_result;
    }
}