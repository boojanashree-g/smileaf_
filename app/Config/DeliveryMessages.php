<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class DeliveryMessages extends BaseConfig
{
    public array $messages = [
        'Order Pending'      => 'Payment not yet completed from the bank',
        'New'                => 'Your order has been placed.',
        'Pending'            => 'Your order is being processed and will be shipped soon.',
        'Shipped'            => 'Your order has been shipped and is on its way.',
        'Delivered'          => 'Your order has been delivered.',
        'Cancelled'          => 'Your order has been cancelled.',
        'Refund Created'     => 'The refund has been created and will be processed shortly.',
        'Refund Processed'   => 'Refund will be credited within 5-7 working days',
        'Refund Failed'      => 'Refund is Failed'
    ];
}
