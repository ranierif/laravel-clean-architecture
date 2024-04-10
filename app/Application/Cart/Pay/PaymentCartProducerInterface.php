<?php

declare(strict_types=1);

namespace App\Application\Cart\Pay;

interface PaymentCartProducerInterface
{
    public function produce(array $data): void;
}
