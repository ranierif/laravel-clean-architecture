<?php

declare(strict_types=1);

namespace App\Infrastructure\Broker\Consumers\Kafka;

use App\Application\Payment\StatusChange\PaymentStatusChangeInputDTO;
use App\Application\Payment\StatusChange\PaymentStatusChangeUseCase;
use App\Domain\Shared\Service\LoggerInterface;
use App\Infrastructure\Broker\TopicEnum;
use Illuminate\Support\Arr;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Facades\Kafka;
use Throwable;

class PaymentStatusChangeConsumer extends KafkaConsumerAbstract
{
    protected string $topic = TopicEnum::PAYMENT_STATUS_CHANGE->value;

    protected $signature = 'payment-status-change:consume';

    protected $description = 'Consume payments status change messages';

    public function __construct(
        protected Kafka $kafka,
        protected LoggerInterface $logger,
        protected PaymentStatusChangeUseCase $paymentStatusChangeUseCase
    ) {
        parent::__construct($kafka, $logger);
    }

    public function processMessage(ConsumerMessage $message): void
    {
        try {
            $message = $message->getBody();
            $paymentStatusChangeInputDTO = new PaymentStatusChangeInputDTO([
                'uuid' => Arr::get($message, 'uuid'),
                'status' => Arr::get($message, 'status'),
            ]);

            $this->paymentStatusChangeUseCase
                ->execute(
                    $paymentStatusChangeInputDTO
                );
        } catch (Throwable $throwable) {
            $this->logger
                ->error(
                    sprintf('%s-%s', $this->topic, 'process-message'),
                    [
                        'exception' => get_class($throwable),
                        'message' => $throwable->getMessage(),
                    ]
                );

            $this->error($throwable->getMessage());

            throw $throwable;
        }
    }
}
