<?php

namespace App\Infrastructure\Broker;

enum TopicEnum: string
{
    case PAYMENT_CART_CREATE = 'payment-cart-creation';
    case PAYMENT_STATUS_CHANGE = 'payment-status-change';
}
