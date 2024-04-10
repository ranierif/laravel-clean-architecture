<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Entity\UserEntity;
use App\Domain\User\Exception\EmailAlreadyInUseException;
use App\Domain\User\Exception\UserNotCreatedException;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Repository\UserRepositoryInterface;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {
    }

    public function sanitize(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'password' => $data['password'] ?? null,
        ];
    }

    /**
     * @throws UserNotCreatedException
     */
    public function create(UserEntity $user): UserEntity
    {
        try {
            return $this->repository->create($user);
        } catch (\Throwable $throwable) {
            throw new UserNotCreatedException();
        }
    }

    /**
     * @throws UserNotFoundException
     */
    public function findOneBy(string $field, mixed $value): UserEntity
    {
        $user = $this->repository->findOneBy($field, $value);

        if (! $user instanceof UserEntity) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @throws EmailAlreadyInUseException
     */
    public function findEmailInUse(string $email): void
    {
        $user = $this->repository->findOneBy('email', $email);

        if ($user instanceof UserEntity) {
            throw new EmailAlreadyInUseException();
        }
    }
}
