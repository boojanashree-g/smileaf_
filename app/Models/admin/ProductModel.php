<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class ProductModel extends Model
{

    protected $table = 'tbl_products';
    protected $primaryKey = 'prod_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'prod_name',
        'menu_id',
        'submenu_id',
        'subcat_id',
        'url',
        'description',
        'product_usage',
        'main_image',
        'has_variant',
        'type_id',
        'shape_id',
        'size_id',

    ];
}