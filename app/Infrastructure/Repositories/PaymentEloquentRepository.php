<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Payment\Entity\PaymentEntity;
use App\Domain\Payment\Repository\PaymentRepositoryInterface;
use App\Infrastructure\Models\Payment as PaymentModel;

class PaymentEloquentRepository extends RepositoryEloquentAbstract implements PaymentRepositoryInterface
{
    /**
     * @var PaymentModel
     */
    protected $model = PaymentModel::class;

    /**
     * @var PaymentEntity
     */
    protected $entity = PaymentEntity::class;
}
