<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class FilterShapeModel extends Model
{

    protected $table = 'tbl_filter_shapes';
    protected $primaryKey = 'shape_id   ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'shape_name',
        'status'
    ];
}