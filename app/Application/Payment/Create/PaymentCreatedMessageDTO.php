<?php

declare(strict_types=1);

namespace App\Application\Payment\Create;

use App\Application\Shared\DTO\DTOAbstract;

class PaymentCreatedMessageDTO extends DTOAbstract
{
    public string $uuid;

    public string $cartUuid;

    public string $method;

    public ?string $card;

    public string $status;

    public string $createdAt;
}
