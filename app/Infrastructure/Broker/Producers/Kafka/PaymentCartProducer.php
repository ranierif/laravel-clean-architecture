<?php

declare(strict_types=1);

namespace App\Infrastructure\Broker\Producers\Kafka;

use App\Application\Broker\Producer\PaymentCartProducerInterface;
use App\Infrastructure\Broker\TopicEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Junges\Kafka\Message\Message;

class PaymentCartProducer extends KafkaProducerAbstract implements PaymentCartProducerInterface
{
    protected TopicEnum $topic = TopicEnum::PAYMENT_CART_CREATE;

    public function createMessage(array $data): Message
    {
        $key = Arr::get($data, 'uuid', Str::uuid()->toString());

        return new Message(
            headers: $this->header(),
            body: $data,
            key: $key
        );
    }
}
