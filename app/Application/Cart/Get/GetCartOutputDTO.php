<?php

declare(strict_types=1);

namespace App\Application\Cart\Get;

use App\Application\Shared\DTO\DTOAbstract;

class GetCartOutputDTO extends DTOAbstract
{
    public string $uuid;

    public array $items;

    public string $status;

    public string $createdAt;

    public ?string $approvedAt;
}
