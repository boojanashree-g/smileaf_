<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class BannerModel extends Model
{

    protected $table = 'tbl_banner';
    protected $primaryKey = 'banner_id';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'banner_title',
        'banner_desc1',
        'banner_desc2',
        'banner_image',
        'banner_link'
    ];
}
