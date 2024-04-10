<?php

namespace Database\Factories;

use App\Domain\Enums\PaymentMethodEnum;
use App\Domain\Enums\PaymentStatusEnum;
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
