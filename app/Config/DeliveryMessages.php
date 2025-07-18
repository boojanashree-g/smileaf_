<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class DeliveryMessages extends BaseConfig
{
    public array $messages = [
        'Order Pending' => 'Payment not yet completed from the bank',
        'New' => 'Your order has been placed.',
        'Pending' => 'Your payment is still pending. We will process your order once the payment is confirmed.',
        'Shipped' => 'Your order has been shipped and is on its way.',
        'Delivered' => 'Your order has been delivered.',
        'Cancelled' => 'Your order has been cancelled.',
        'Refund Created' => 'The refund has been created and will be processed shortly.',
        'Refund Processed' => 'Refund will be credited within 5-7 working days',
        'Refund Failed' => 'Refund is Failed',
        'Null' => 'Payment failed. Order not processed.',
        'Cancel Modal' => 'Transaction cancelled by user before payment confirmation',
        'Returned' => 'Items have been returned. Your refund will be processed shortly.'
    ];
}
