<?php

namespace App\Domain\Payment\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PaymentNotCreatedException extends Exception
{
    protected $message = 'Não foi possível criar o pagamento';

    protected $code = Response::HTTP_BAD_REQUEST;
}
