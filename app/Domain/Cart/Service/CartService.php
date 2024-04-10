<?php

declare(strict_types=1);

namespace App\Domain\Cart\Service;

use App\Domain\Cart\Entity\CartEntity;
use App\Domain\Cart\Exception\CartNotCreatedException;
use App\Domain\Cart\Exception\CartNotFoundException;
use App\Domain\Cart\Repository\CartRepositoryInterface;

class CartService
{
    public function __construct(
        protected CartRepositoryInterface $repository
    ) {
    }

    public function sanitize(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'uuid' => $data['uuid'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'items' => $data['items'] ?? [],
            'status' => $data['status'] ?? null,
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
