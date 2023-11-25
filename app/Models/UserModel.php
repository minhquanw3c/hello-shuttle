<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false;

	protected $allowedFields = [
        'user_id',
		'user_email',
        'user_hashed_password',
        'user_phone',
        'user_first_name',
        'user_last_name',
        'user_role',
        'user_active',
        'user_created_at',
        'user_updated_at',
	];

    public function createUser($data)
    {
        $create_user_query = $this->insert($data, false);

        return $create_user_query;
    }

    public function getUserById($user_id)
    {
        $get_user_query = $this->select([
            'users.user_id AS userId',
            'users.user_email AS userEmail',
            'users.user_phone AS userPhone',
            'users.user_hashed_password AS userPassword',
            'users.user_first_name AS userFirstName',
            'users.user_last_name AS userLastName',
        ])
        ->where([
            'users.user_active' => 1,
            'users.user_email' => $user_id,
        ])
        ->findAll();

        return $get_user_query;
    }

    public function getRowsByColumn($column_id, $check_value = null)
    {
        if ($check_value) {
            $result = $this
                        ->select($column_id)
                        ->where($column_id, $check_value)
                        ->get()
                        ->getNumRows();
        } else {
            $result = $this
                        ->select($column_id)
                        ->get();
        }

        return $result;
    }
}