<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PasswordManagerController extends BaseController
{
    public function verifyPasswordPairMatch($provided_password, $hased_password)
    {
        return password_verify($provided_password, base64_decode($hased_password));
    }
}