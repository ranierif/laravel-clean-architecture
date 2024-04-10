<?php

namespace App\Domain\Payment\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PaymentNotFoundException extends Exception
{
    protected $message = 'Pagamento não encontrado';

    protected $code = Response::HTTP_NOT_FOUND;
}
