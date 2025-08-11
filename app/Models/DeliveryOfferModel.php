<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryOfferModel extends Model
{

    protected $table = 'tbl_delivery_offer';
    protected $primaryKey = 'delivery_id '; 
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'offer_amount   ',
      
    ];
}