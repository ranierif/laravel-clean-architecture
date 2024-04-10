<?php

declare(strict_types=1);

namespace App\Application\DTO\Cart;

use App\Application\DTO\DTOAbstract;

class PayCartOutputDTO extends DTOAbstract
{
    public string $uuid;

    public string $method;

    public string $status;
}
