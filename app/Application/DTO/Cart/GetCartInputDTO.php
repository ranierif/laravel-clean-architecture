<?php

declare(strict_types=1);

namespace App\Application\DTO\Cart;

use App\Application\DTO\DTOAbstract;

class GetCartInputDTO extends DTOAbstract
{
    public string $uuid;

    public int $userId;
}
