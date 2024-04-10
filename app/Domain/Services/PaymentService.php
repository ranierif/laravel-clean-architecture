<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\PaymentEntity;
use App\Domain\Enums\PaymentStatusEnum;
use App\Domain\Exceptions\Payment\PaymentNotCreatedException;
use App\Domain\Exceptions\Payment\PaymentNotFoundException;
use App\Domain\Exceptions\Payment\PaymentNotUpdatedException;
use App\Domain\Exceptions\Payment\PaymentUnableToReceiveException;
use App\Domain\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\Arr;

class PaymentService
{
    public function __construct(
        protected PaymentRepositoryInterface $repository
    ) {
    }

    public function sanitize(array $data): array
    {
        return [
            'id' => Arr::get($data, 'id'),
            'uuid' => Arr::get($data, 'uuid'),
            'user_id' => Arr::get($data, 'user_id'),
            'cart_uuid' => Arr::get($data, 'cart_uuid'),
            'method' => Arr::get($data, 'method'),
            'status' => Arr::get($data, 'status'),
        ];
    }

    /**
     * @throws PaymentNotCreatedException
     */
    public function create(PaymentEntity $payment): PaymentEntity
    {
        try {
            return $this->repository->create($payment);
        } catch (\Throwable $throwable) {
            throw new PaymentNotCreatedException();
        }
    }

    /**
     * @throws PaymentNotFoundException
     */
    public function findOneBy(string $field, mixed $value): PaymentEntity
    {
        $payment = $this->repository->findOneBy($field, $value);

        if (! $payment instanceof PaymentEntity) {
            throw new PaymentNotFoundException();
        }

        return $payment;
    }

    /**
     * @throws PaymentNotUpdatedException
     */
    public function updateOne(PaymentEntity $payment, ?array $fields = null): PaymentEntity
    {
        try {
            if ($this->repository->updateOne($payment, $fields)) {
                return $payment;
            }
        } catch (\Throwable $throwable) {
            throw new PaymentNotUpdatedException();
        }
    }

    /**
     * @throws PaymentUnableToReceiveException
     */
    public function shouldCanReceivePayment(string $cartUuid): void
    {
        $payment = $this->repository->findOneBy('cart_uuid', $cartUuid);

        if (
            $payment instanceof PaymentEntity
            && $payment->getStatus() === PaymentStatusEnum::PENDING->value
        ) {
            throw new PaymentUnableToReceiveException();
        }
    }
}
