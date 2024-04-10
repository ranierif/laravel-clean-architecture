<?php

declare(strict_types=1);

namespace App\Application\DTO\Cart;

use App\Application\DTO\DTOAbstract;

class CreateCartOutputDTO extends DTOAbstract
{
    public string $uuid;

    public array $items;

    public string $status;

    public string $createdAt;

    public ?string $approvedAt;
}
