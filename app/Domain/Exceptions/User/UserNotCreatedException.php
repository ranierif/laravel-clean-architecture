<?php

namespace App\Domain\Exceptions\User;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserNotCreatedException extends Exception
{
    protected $message = 'Não foi possível finalizar o cadastro';

    protected $code = Response::HTTP_BAD_REQUEST;
}
