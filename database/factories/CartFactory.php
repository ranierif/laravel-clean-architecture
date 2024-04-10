<?php

namespace Database\Factories;

use App\Domain\Cart\Enum\CartStatusEnum;
use App\Infrastructure\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'user_id' => fake()->unique()->safeEmail(),
            'items' => [
                [
                    'reference' => 'product_1',
                    'quantity' => 1,
                ],
            ],
            'status' => CartStatusEnum::PENDING->value,
        ];
    }
}
