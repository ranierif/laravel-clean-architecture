<?php

namespace App\Domain\Cart\Enum;

enum CartStatusEnum: string
{
    case PENDING = 'PENDING';
    case APPROVED = 'APPROVED';
    case FAILED = 'FAILED';
}
