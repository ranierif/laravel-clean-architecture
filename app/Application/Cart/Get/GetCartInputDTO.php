<?php

declare(strict_types=1);

namespace App\Application\Cart\Get;

use App\Application\Shared\DTO\DTOAbstract;

class GetCartInputDTO extends DTOAbstract
{
    public string $uuid;

    public int $userId;
}
