<?php

namespace App\Domain\Payment\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PaymentUnableToReceiveException extends Exception
{
    protected $message = 'Já existe um pagamento em andamento';

    protected $code = Response::HTTP_BAD_REQUEST;
}
