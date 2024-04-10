<?php

declare(strict_types=1);

namespace App\Application\DTO\Auth;

use App\Application\DTO\DTOAbstract;

class LoginInputDTO extends DTOAbstract
{
    public string $email;

    public string $password;
}
