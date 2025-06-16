<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class VariantModel extends Model
{

    protected $table = 'tbl_variants';
    protected $primaryKey = 'variant_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'prod_id',
        'pack_qty',
        'mrp',
        'offer_type',
        'offer_details',
        'offer_price',
        'stock_status',
        'quantity',
        'weight'
    ];
}