<?php

declare(strict_types=1);

namespace App\Application\UseCases\Cart;

use App\Application\DTO\Cart\CreateCartInputDTO;
use App\Application\DTO\Cart\CreateCartOutputDTO;
use App\Application\Helpers\UuidGeneratorInterface;
use App\Domain\Cart\Entity\CartEntity;
use App\Domain\Cart\Enum\CartStatusEnum;
use App\Domain\Cart\Exception\CartNotCreatedException;
use App\Domain\Cart\Service\CartService;
use App\Domain\Shared\Service\LoggerInterface;
use Throwable;

class CreateCartUseCase
{
    public function __construct(
        protected CartService $service,
        protected LoggerInterface $logger,
        protected UuidGeneratorInterface $uuidGenerator
    ) {
    }

    /**
     * @throws CartNotCreatedException
     * @throws Throwable
     */
    public function execute(CreateCartInputDTO $input): CreateCartOutputDTO
    {
        try {
            $data = $input->toArray();
            $data['uuid'] = $this->uuidGenerator->generateUuid();
            $data['status'] = CartStatusEnum::PENDING->value;

            $cart = $this->service
                ->create(
                    CartEntity::fromArray($this->service->sanitize($data))
                );

            return new CreateCartOutputDTO([
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
