<?php

namespace App\Infrastructure\Models;

use App\Domain\Enums\CartStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'uuid',
        'user_id',
        'items',
        'status',
        'approved_at',
    ];

    protected $casts = [
        'items' => 'array',
        'status' => CartStatusEnum::class,
        'approved_at' => 'datetime',
    ];
}
