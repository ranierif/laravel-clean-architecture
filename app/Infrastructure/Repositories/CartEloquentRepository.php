<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Cart\Entity\CartEntity;
use App\Domain\Cart\Repository\CartRepositoryInterface;
use App\Infrastructure\Models\Cart as CartModel;

class CartEloquentRepository extends RepositoryEloquentAbstract implements CartRepositoryInterface
{
    /**
     * @var CartModel
     */
    protected $model = CartModel::class;

    /**
     * @var CartEntity
     */
    protected $entity = CartEntity::class;
}
