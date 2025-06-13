<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class SubcatModel extends Model
{

    protected $table = 'tbl_sub_category';
    protected $primaryKey = 'cat_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'submenu_id',
        'cat_name',
        'slug',
        'status',
    ];
}