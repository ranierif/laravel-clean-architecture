<?php

declare(strict_types=1);

namespace App\Application\User\Login;

use App\Application\Shared\DTO\DTOAbstract;

class LoginInputDTO extends DTOAbstract
{
    public string $email;

    public string $password;
}
