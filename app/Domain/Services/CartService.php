<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\CartEntity;
use App\Domain\Exceptions\Cart\CartNotCreatedException;
use App\Domain\Exceptions\Cart\CartNotFoundException;
use App\Domain\Repositories\CartRepositoryInterface;
use Illuminate\Support\Arr;

class CartService
{
    public function __construct(
        protected CartRepositoryInterface $repository
    ) {
    }

    public function sanitize(array $data): array
    {
        return [
            'id' => Arr::get($data, 'id'),
            'uuid' => Arr::get($data, 'uuid'),
            'user_id' => Arr::get($data, 'user_id'),
            'items' => Arr::get($data, 'items', []),
            'status' => Arr::get($data, 'status'),
        ];
    }

    /**
     * @throws CartNotCreatedException
     */
    public function create(CartEntity $cart): CartEntity
    {
        try {
            return $this->repository->create($cart);
        } catch (\Throwable $throwable) {
            throw new CartNotCreatedException();
        }
    }

    /**
     * @throws CartNotFoundException
     */
    public function getCartFromUser(string $uuid, int $userId): CartEntity
    {
        $cart = $this->repository->findOneWhere([
            'uuid' => $uuid,
            'user_id' => $userId,
        ]);

        if (! $cart instanceof CartEntity) {
            throw new CartNotFoundException();
        }

        return $cart;
    }
}
