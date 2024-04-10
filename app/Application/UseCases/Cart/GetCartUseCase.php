<?php

declare(strict_types=1);

namespace App\Application\UseCases\Cart;

use App\Application\DTO\Cart\GetCartInputDTO;
use App\Application\DTO\Cart\GetCartOutputDTO;
use App\Domain\Services\CartService;
use App\Domain\Services\LoggerInterface;
use Throwable;

class GetCartUseCase
{
    public function __construct(
        protected CartService $service,
        protected LoggerInterface $logger
    ) {
    }

    public function execute(GetCartInputDTO $input): GetCartOutputDTO
    {
        try {
            $cart = $this->service
                ->getCartFromUser(
                    $input->uuid,
                    $input->userId,
                );

            return new GetCartOutputDTO([
                'uuid' => $cart->getUuid(),
                'items' => $cart->getItems(),
                'status' => $cart->getStatus(),
                'created_at' => $cart->getCreatedAt()->format('Y-m-d H:i'),
                'approved_at' => $cart->getApprovedAt()?->format('Y-m-d H:i'),
            ]);
        } catch (Throwable $throwable) {
            $this->logger
                ->error(
                    $throwable->getMessage(),
                    ['data' => $input->toArray()]
                );

            throw $throwable;
        }
    }
}
