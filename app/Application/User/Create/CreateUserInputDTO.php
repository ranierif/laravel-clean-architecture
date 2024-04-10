<?php

declare(strict_types=1);

namespace App\Application\User\Create;

use App\Application\Shared\DTO\DTOAbstract;

class CreateUserInputDTO extends DTOAbstract
{
    public string $name;

    public string $email;

    public string $phoneNumber;

    public string $password;
}
