<?php

declare(strict_types=1);

namespace App\Application\UseCases\Cart;

use App\Application\Broker\Producer\PaymentCartProducerInterface;
use App\Application\DTO\Cart\PayCartInputDTO;
use App\Application\DTO\Cart\PayCartOutputDTO;
use App\Application\DTO\Payment\PaymentCreatedMessageDTO;
use App\Application\Helpers\UuidGeneratorInterface;
use App\Domain\Entities\PaymentEntity;
use App\Domain\Enums\PaymentStatusEnum;
use App\Domain\Exceptions\Cart\CartNotFoundException;
use App\Domain\Exceptions\Payment\PaymentNotCreatedException;
use App\Domain\Exceptions\Payment\PaymentUnableToReceiveException;
use App\Domain\Helpers\CryptographyInterface;
use App\Domain\Services\CartService;
use App\Domain\Services\LoggerInterface;
use App\Domain\Services\PaymentService;
use Throwable;

class PayCartUseCase
{
    public function __construct(
        protected CartService $cartService,
        protected PaymentService $paymentService,
        protected LoggerInterface $logger,
        protected PaymentCartProducerInterface $paymentCartProducer,
        protected CryptographyInterface $cryptography,
        protected UuidGeneratorInterface $uuidGenerator
    ) {
    }

    /**
     * @throws PaymentUnableToReceiveException
     * @throws PaymentNotCreatedException
     * @throws Throwable
     * @throws CartNotFoundException
     */
    public function execute(PayCartInputDTO $input): PayCartOutputDTO
    {
        try {
            $this->cartService
                ->getCartFromUser(
                    $input->cartUuid,
                    $input->userId,
                );

            $this->paymentService
                ->shouldCanReceivePayment(
                    $input->cartUuid
                );

            $data = $input->toArray();
            $data['uuid'] = $this->uuidGenerator->generateUuid();
            $data['status'] = PaymentStatusEnum::PENDING->value;

            $payment = $this->paymentService->create(
                PaymentEntity::fromArray($this->paymentService->sanitize($data))
            );

            $message = new PaymentCreatedMessageDTO([
                'uuid' => $payment->getUuid(),
                'cart_uuid' => $payment->getCartUuid(),
                'method' => $payment->getMethod(),
                'card' => ! empty($input->card) ? $this->cryptography->create(json_encode($input->card)) : null,
                'status' => $payment->getStatus(),
                'created_at' => $payment->getCreatedAt()->format('Y-m-d H:i'),
            ]);

            $this->paymentCartProducer->produce($message->toArray());

            return new PayCartOutputDTO([
                'uuid' => $payment->getUuid(),
                'method' => $payment->getMethod(),
                'status' => $payment->getStatus(),
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
