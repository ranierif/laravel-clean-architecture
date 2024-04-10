<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\UserEntity;
use App\Domain\Exceptions\User\EmailAlreadyInUseException;
use App\Domain\Exceptions\User\UserNotCreatedException;
use App\Domain\Exceptions\User\UserNotFoundException;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Arr;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {
    }

    public function sanitize(array $data): array
    {
        return [
            'id' => Arr::get($data, 'id'),
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),
            'phone_number' => Arr::get($data, 'phone_number'),
            'password' => Arr::get($data, 'password'),
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
