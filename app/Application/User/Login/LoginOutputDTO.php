<?php

declare(strict_types=1);

namespace App\Application\User\Login;

use App\Application\Shared\DTO\DTOAbstract;

class LoginOutputDTO extends DTOAbstract
{
    public string $token;
}
