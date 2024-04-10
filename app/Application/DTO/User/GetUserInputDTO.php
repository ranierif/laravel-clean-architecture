<?php

declare(strict_types=1);

namespace App\Application\DTO\User;

use App\Application\DTO\DTOAbstract;

class GetUserInputDTO extends DTOAbstract
{
    public int $userId;
}
