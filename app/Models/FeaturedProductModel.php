<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table = 'tbl_featured_products';
    protected $primaryKey = 'featured_prod_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'sub_id',
        'image_url',
        'flag'
    ];
}