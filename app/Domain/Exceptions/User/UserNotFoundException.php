<?php

namespace App\Domain\Exceptions\User;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends Exception
{
    protected $message = 'Não foi possível localizar o usuário';

    protected $code = Response::HTTP_NOT_FOUND;
}
