<?php

namespace App\Domain\Cart\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class CartNotCreatedException extends Exception
{
    protected $message = 'Não foi possível criar o carrinho';

    protected $code = Response::HTTP_BAD_REQUEST;
}
