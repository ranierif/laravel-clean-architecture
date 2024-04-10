<?php

declare(strict_types=1);

namespace App\Application\Cart\Create;

use App\Application\Shared\DTO\DTOAbstract;

class CreateCartOutputDTO extends DTOAbstract
{
    public string $uuid;

    public array $items;

    public string $status;

    public string $createdAt;

    public ?string $approvedAt;
}
