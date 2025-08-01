<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModal extends Model
{

    protected $table = 'tbl_orders';
    protected $primaryKey = 'order_id ';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'order_no',
        'bill_no',
        'bill_date',
        'razerpay_payment_id',
        'razerpay_order_id',
        'razerpay_signature',
        'user_id',
        'courier_charge',
        'sub_total',
        'total_amt',
        'courier_type',
        'add_id',
        'order_status',
        'payment_method',
        'bank_ref_num',
        'order_date',
        'process_date',
        'shipped_date',
        'delivery_date',
        'courier_partner',
        'tracking_id',
        'coupon_code',
        'payment_status',
        'delivery_status',
        'delivery_message',
        'cancel_reason',
        'cancel_status',
        'refund_id',
        'refund_amt',
        'payment_cancel_reason',
        'gst',
        'sgst',
        'cgst',
        'is_returned',
        'is_discount',
        'discount_amt',
        'main_total',
        'main_courier_charge'
    ];
}