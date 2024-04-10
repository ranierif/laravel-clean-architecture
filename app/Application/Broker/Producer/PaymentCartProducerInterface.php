<?php

declare(strict_types=1);

namespace App\Application\Broker\Producer;

interface PaymentCartProducerInterface
{
    public function produce(array $data): void;
}
