<?php

namespace App\Application\UseCases\Payment;

use App\Application\DTO\Payment\PaymentStatusChangeInputDTO;
use App\Domain\Enums\PaymentStatusEnum;
use App\Domain\Services\LoggerInterface;
use App\Domain\Services\PaymentService;
use Throwable;

class PaymentStatusChangeUseCase
{
    public function __construct(
        protected PaymentService $service,
        protected LoggerInterface $logger
    ) {
    }

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
