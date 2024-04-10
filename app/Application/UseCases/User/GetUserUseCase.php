<?php

namespace App\Application\UseCases\User;

use App\Application\DTO\User\GetUserInputDTO;
use App\Application\DTO\User\GetUserOutputDTO;
use App\Domain\Services\LoggerInterface;
use App\Domain\Services\UserService;
use Throwable;

class GetUserUseCase
{
    public function __construct(
        protected UserService $service,
        protected LoggerInterface $logger
    ) {
    }

    public function execute(GetUserInputDTO $input): GetUserOutputDTO
    {
        try {
            $user = $this->service
                ->findOneBy(
                    'id',
                    $input->userId
                );

            return new GetUserOutputDTO([
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'phone_number' => $user->getPhoneNumber(),
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
