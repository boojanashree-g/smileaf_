<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class FilterSizeModel extends Model
{

    protected $table = 'tbl_filter_size';
    protected $primaryKey = 'size_id  ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'size_name',
        'status'
    ];
}