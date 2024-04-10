<?php

namespace App\Domain\Exceptions\Payment;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PaymentUnableToReceiveException extends Exception
{
    protected $message = 'Já existe um pagamento em andamento';

    protected $code = Response::HTTP_BAD_REQUEST;
}
