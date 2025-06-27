<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'username',
        'number',
        'email',
        'password',
        'otp',
        'otp_expiry',
        'is_verified',
        'flag'

    ];
}