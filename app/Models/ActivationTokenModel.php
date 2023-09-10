<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ActivationTokenModel extends Model
{
	protected $table = 'activation_tokens';
	protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

	protected $allowedFields = [
		'token',
        'user_id',
        'token_expired_at',
        'token_used_at',
        'token_type',
        'token_created_at',
        'token_updated_at',
	];

    public function saveActivationToken($data)
    {
        $create_query = $this->insert($data, false);

        return $create_query;
    }

    public function generateToken()
    {
        $token = bin2hex(random_bytes(32));
        $expired_at = Time::now('UTC')->addMinutes(2);

        $data = [
            'token' => $token,
            'expired_at' => $expired_at,
        ];

        return $data;
    }
}