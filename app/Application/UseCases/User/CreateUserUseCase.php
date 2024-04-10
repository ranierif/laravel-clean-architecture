<?php

declare(strict_types=1);

namespace App\Application\UseCases\User;

use App\Application\DTO\User\CreateUserInputDTO;
use App\Domain\Entities\UserEntity;
use App\Domain\Services\LoggerInterface;
use App\Domain\Services\UserService;
use Throwable;

class CreateUserUseCase
{
    public function __construct(
        protected UserService $service,
        protected LoggerInterface $logger
    ) {
    }

    public function execute(CreateUserInputDTO $input): void
    {
        try {
            $this->service->findEmailInUse($input->email);

            $entity = UserEntity::fromArray(
                $this->service->sanitize($input->toArray())
            );

            $this->service
                ->create(
                    $entity
                );
        } catch (Throwable $throwable) {
            $this->logger
                ->error(
                    $throwable->getMessage(),
                    ['input' => $input->toArray()]
                );

            throw $throwable;
        }
    }
}
