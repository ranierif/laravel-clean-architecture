<?php

declare(strict_types=1);

namespace App\Application\DTO\Payment;

use App\Application\DTO\DTOAbstract;

class PaymentStatusChangeInputDTO extends DTOAbstract
{
    public string $uuid;

    public string $status;
}
