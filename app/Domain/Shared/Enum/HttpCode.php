<?php

namespace App\Domain\Shared\Enum;

final class HttpCode
{
    const OK = 200;

    const CREATED = 201;

    const ACCEPTED = 202;

    const NO_CONTENT = 204;

    const BAD_REQUEST = 400;

    const UNAUTHORIZED = 401;

    const FORBIDDEN = 403;

    const NOT_FOUND = 404;

    const METHOD_NOT_ALLOWED = 405;

    const INTERNAL_SERVER_ERROR = 500;
}
