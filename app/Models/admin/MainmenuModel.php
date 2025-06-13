<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class MainmenuModel extends Model
{

    protected $table = 'tbl_mainmenu';
    protected $primaryKey = 'menu_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'menu_name',
        'slug',
        'status',
    ];
}