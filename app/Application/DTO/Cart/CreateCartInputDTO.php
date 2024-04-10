<?php

declare(strict_types=1);

namespace App\Application\DTO\Cart;

use App\Application\DTO\DTOAbstract;

class CreateCartInputDTO extends DTOAbstract
{
    public int $userId;

    public array $items;
}
