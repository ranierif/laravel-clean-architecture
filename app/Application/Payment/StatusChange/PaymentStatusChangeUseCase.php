<?php

namespace App\Application\Payment\StatusChange;

use App\Domain\Payment\Enum\PaymentStatusEnum;
use App\Domain\Payment\Exception\PaymentNotFoundException;
use App\Domain\Payment\Exception\PaymentNotUpdatedException;
use App\Domain\Payment\Service\PaymentService;
use App\Domain\Shared\Service\LoggerInterface;
use Throwable;

class PaymentStatusChangeUseCase
{
    public function __construct(
        protected PaymentService $service,
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @throws PaymentNotUpdatedException
     * @throws PaymentNotFoundException
     * @throws Throwable
     */
    public function execute(PaymentStatusChangeInputDTO $input): void
    {
        try {
            $payment = $this->service
                ->findOneBy(
                    'uuid',
                    $input->uuid
                );

            $status = PaymentStatusEnum::from($input->status)->value;

            $payment->setStatus($status);
            $this->service->updateOne($payment, [
                'status' => $status,
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
