<?php

namespace App\Domain\Enums;

enum CartStatusEnum: string
{
    case PENDING = 'PENDING';
    case APPROVED = 'APPROVED';
    case FAILED = 'FAILED';
}
