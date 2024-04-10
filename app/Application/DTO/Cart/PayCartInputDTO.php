<?php

declare(strict_types=1);

namespace App\Application\DTO\Cart;

use App\Application\DTO\DTOAbstract;

class PayCartInputDTO extends DTOAbstract
{
    public int $userId;

    public string $cartUuid;

    public string $method;

    public ?array $card;
}
