<?php

declare(strict_types=1);

namespace App\Infrastructure\Broker\Producers\Kafka;

use App\Domain\Shared\Service\LoggerInterface;
use App\Infrastructure\Broker\TopicEnum;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Junges\Kafka\Producers\Builder;
use Throwable;

abstract class KafkaProducerAbstract
{
    protected TopicEnum $topic;

    public function __construct(
        protected Kafka $kafka,
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @throws Throwable
     */
    public function produce(array $data): void
    {
        try {
            $message = $this->createMessage($data);

            /** @var Builder $producer */
            $producer = Kafka::publish()
                ->onTopic($this->topic->value)
                ->withMessage($message);

            $producer->send(true);
        } catch (Throwable $throwable) {
            $this->logger
                ->error(
                    $throwable->getMessage(),
                    ['data' => $data]
                );

            throw $throwable;
        }
    }

    abstract public function createMessage(array $data): Message;

    public function header(): array
    {
        return [
            'dispatched_at' => Carbon::now()->format('c'),
            'idempotency_id' => Str::uuid()->toString(),
            'application_name' => config('app.name'),
        ];
    }
}
