<?php

declare(strict_types=1);

namespace App\Application\Cart\Create;

use App\Application\Shared\DTO\DTOAbstract;

class CreateCartInputDTO extends DTOAbstract
{
    public int $userId;

    public array $items;
}
