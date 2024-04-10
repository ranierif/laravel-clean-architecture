<?php

declare(strict_types=1);

namespace App\Application\Cart\Pay;

use App\Application\Shared\DTO\DTOAbstract;

class PayCartInputDTO extends DTOAbstract
{
    public int $userId;

    public string $cartUuid;

    public string $method;

    public ?array $card;
}
