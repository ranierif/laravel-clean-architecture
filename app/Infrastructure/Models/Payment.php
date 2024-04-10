<?php

namespace App\Infrastructure\Models;

use App\Domain\Payment\Enum\PaymentMethodEnum;
use App\Domain\Payment\Enum\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'uuid',
        'user_id',
        'cart_uuid',
        'status',
        'method',
        'approved_at',
    ];

    protected $casts = [
        'items' => 'array',
        'status' => PaymentStatusEnum::class,
        'method' => PaymentMethodEnum::class,
        'approved_at' => 'datetime',
    ];
}
