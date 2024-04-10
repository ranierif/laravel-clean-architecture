<?php

declare(strict_types=1);

namespace App\Application\User\Get;

use App\Application\Shared\DTO\DTOAbstract;

class GetUserInputDTO extends DTOAbstract
{
    public int $userId;
}
