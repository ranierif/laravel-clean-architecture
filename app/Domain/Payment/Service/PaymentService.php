<?php

declare(strict_types=1);

namespace App\Domain\Payment\Service;

use App\Domain\Payment\Entity\PaymentEntity;
use App\Domain\Payment\Enum\PaymentStatusEnum;
use App\Domain\Payment\Exception\PaymentNotCreatedException;
use App\Domain\Payment\Exception\PaymentNotFoundException;
use App\Domain\Payment\Exception\PaymentNotUpdatedException;
use App\Domain\Payment\Exception\PaymentUnableToReceiveException;
use App\Domain\Payment\Repository\PaymentRepositoryInterface;

class PaymentService
{
    public function __construct(
        protected PaymentRepositoryInterface $repository
    ) {
    }

    public function sanitize(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'uuid' => $data['uuid'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'cart_uuid' => $data['cart_uuid'] ?? null,
            'method' => $data['method'] ?? null,
            'status' => $data['status'] ?? null,
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
