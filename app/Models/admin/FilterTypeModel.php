<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class FilterTypeModel extends Model
{

    protected $table = 'tbl_filter_type';
    protected $primaryKey = 'type_id  ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'type_name',
        'status'
    ];
}