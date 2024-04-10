<?php

namespace Database\Factories;

use App\Domain\Payment\Enum\PaymentMethodEnum;
use App\Domain\Payment\Enum\PaymentStatusEnum;
use App\Infrastructure\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'user_id' => fake()->unique()->safeEmail(),
            'cart_uuid' => fake()->unique()->safeEmail(),
            'status' => PaymentStatusEnum::PENDING->value,
            'method' => PaymentMethodEnum::CREDIT_CARD->value,
        ];
    }
}
