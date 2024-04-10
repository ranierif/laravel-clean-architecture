<?php

declare(strict_types=1);

namespace App\Application\DTO\Auth;

use App\Application\DTO\DTOAbstract;

class LoginOutputDTO extends DTOAbstract
{
    public string $token;
}
