<?php

namespace App\Domain\Exceptions\Cart;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class CartNotFoundException extends Exception
{
    protected $message = 'Não foi possível encontrar o carrinho';

    protected $code = Response::HTTP_NOT_FOUND;
}
