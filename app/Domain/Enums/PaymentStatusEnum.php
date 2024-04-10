<?php

namespace App\Domain\Enums;

enum PaymentStatusEnum: string
{
    case PENDING = 'PENDING';
    case PROCESSING = 'PROCESSING';
    case PAID = 'PAID';
    case FAILED = 'FAILED';
}
