<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class ImageModel extends Model
{

    protected $table = 'tbl_images';
    protected $primaryKey = 'image_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'prod_id',
        'image_path',

    ];
}