<?php

namespace App\Infrastructure\Repositories;

use App\Domain\User\Entity\UserEntity as UserEntity;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Models\User as UserModel;

class UserEloquentRepository extends RepositoryEloquentAbstract implements UserRepositoryInterface
{
    /**
     * @var UserModel
     */
    protected $model = UserModel::class;

    /**
     * @var UserEntity
     */
    protected $entity = UserEntity::class;
}
