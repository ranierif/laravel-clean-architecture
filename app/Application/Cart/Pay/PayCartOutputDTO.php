<?php

declare(strict_types=1);

namespace App\Application\Cart\Pay;

use App\Application\Shared\DTO\DTOAbstract;

class PayCartOutputDTO extends DTOAbstract
{
    public string $uuid;

    public string $method;

    public string $status;
}
