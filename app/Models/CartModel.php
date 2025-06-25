<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{

    protected $table = 'tbl_user_cart';
    protected $primaryKey = 'cart_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'prod_id',
        'quantity',
        'prod_price',
        'total_price',
        'pack_qty',
    ];
}