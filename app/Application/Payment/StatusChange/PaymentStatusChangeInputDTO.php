<?php

declare(strict_types=1);

namespace App\Application\Payment\StatusChange;

use App\Application\Shared\DTO\DTOAbstract;

class PaymentStatusChangeInputDTO extends DTOAbstract
{
    public string $uuid;

    public string $status;
}
