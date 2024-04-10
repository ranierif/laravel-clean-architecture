<?php

declare(strict_types=1);

namespace App\Infrastructure\Broker\Consumers\Kafka;

use App\Domain\Services\LoggerInterface;
use Illuminate\Console\Command;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;
use Junges\Kafka\Facades\Kafka;
use Throwable;

abstract class KafkaConsumerAbstract extends Command
{
    protected string $topic;

    protected $signature;

    protected $description;

    public function __construct(
        protected Kafka $kafka,
        protected LoggerInterface $logger
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $consumer = Kafka::consumer([$this->topic])
                ->withAutoCommit()
                ->withDlq()
                ->withHandler(function (ConsumerMessage $message, MessageConsumer $consumer) {
                    $this->info('Received message: '.json_encode($message->getBody()));
                    $this->saveLog($message);
                    $this->processMessage($message);
                })
                ->build();

            $consumer->consume();
        } catch (Throwable $throwable) {
            $this->logger
                ->error(
                    sprintf('%s-%s', $this->topic, 'handle-message'),
                    [
                        'exception' => get_class($throwable),
                        'message' => $throwable->getMessage(),
                    ]
                );

            $this->error($throwable->getMessage());
        }
    }

    abstract public function processMessage(ConsumerMessage $message): void;

    private function saveLog(ConsumerMessage $message): void
    {
        $this->logger->info(
            sprintf('%s-%s', $this->topic, 'message'),
            [
                'body' => $message->getBody(),
                'headers' => $message->getHeaders(),
                'partition' => $message->getPartition(),
                'key' => $message->getKey(),
                'topic' => $message->getTopicName(),
            ]
        );
    }
}
