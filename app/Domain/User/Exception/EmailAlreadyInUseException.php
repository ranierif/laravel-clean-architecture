<?php

namespace App\Domain\User\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class EmailAlreadyInUseException extends Exception
{
    protected $message = 'O e-mail já esta sendo utilizado';

    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
}
