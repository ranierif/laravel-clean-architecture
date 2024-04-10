<?php

namespace App\Infrastructure\Broker\Consumers\Kafka;

use App\Infrastructure\Broker\TopicEnum;
use Junges\Kafka\Contracts\ConsumerMessage;

class PaymentCartConsumer extends KafkaConsumerAbstract
{
    protected string $topic = TopicEnum::PAYMENT_CART_CREATE->value;

    protected $signature = 'payment-cart-creation:consume';

    protected $description = 'Consume payments from carts messages';

    public function processMessage(ConsumerMessage $message): void
    {
        // Just for test
    }
}
