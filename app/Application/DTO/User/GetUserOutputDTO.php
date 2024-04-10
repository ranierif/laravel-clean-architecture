<?php

declare(strict_types=1);

namespace App\Application\DTO\User;

use App\Application\DTO\DTOAbstract;

class GetUserOutputDTO extends DTOAbstract
{
    public int $id;

    public string $name;

    public string $email;

    public string $phoneNumber;
}
