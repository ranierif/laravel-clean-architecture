<?php

namespace App\Application\User\Get;

use App\Domain\Shared\Service\LoggerInterface;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Service\UserService;
use Throwable;

class GetUserUseCase
{
    public function __construct(
        protected UserService $service,
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @throws Throwable
     * @throws UserNotFoundException
     */
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
