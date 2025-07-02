<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModal extends Model
{

    protected $table = 'tbl_order_item';
    protected $primaryKey = 'item_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'order_id',
        'prod_id',
        'variant_id',
        'quantity',
        'prod_price',
        'sub_total',
        'mrp',
        'offer_price',
        'offer_type' , 
        'offer_details'

    ];
}