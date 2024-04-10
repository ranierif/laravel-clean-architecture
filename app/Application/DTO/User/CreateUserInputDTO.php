<?php

declare(strict_types=1);

namespace App\Application\DTO\User;

use App\Application\DTO\DTOAbstract;

class CreateUserInputDTO extends DTOAbstract
{
    public string $name;

    public string $email;

    public string $phoneNumber;

    public string $password;
}
