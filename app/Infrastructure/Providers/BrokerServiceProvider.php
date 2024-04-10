<?php

namespace App\Infrastructure\Providers;

use App\Application\Broker\Producer\PaymentCartProducerInterface;
use App\Infrastructure\Broker\Producers\Kafka\PaymentCartProducer;
use Illuminate\Support\ServiceProvider;

class BrokerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentCartProducerInterface::class, PaymentCartProducer::class);
    }
}
