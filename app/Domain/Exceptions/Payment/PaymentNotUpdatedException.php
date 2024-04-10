<?php

namespace App\Domain\Exceptions\Payment;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PaymentNotUpdatedException extends Exception
{
    protected $message = 'Não foi possível atualizar o pagamento';

    protected $code = Response::HTTP_BAD_REQUEST;
}
