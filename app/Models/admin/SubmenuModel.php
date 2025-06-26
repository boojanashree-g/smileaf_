<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class SubmenuModel extends Model
{

    protected $table = 'tbl_submenu';
    protected $primaryKey = 'sub_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'menu_id',
        'submenu',
        'gst',
        'image_url',
        'slug',
        'status',
    ];
}