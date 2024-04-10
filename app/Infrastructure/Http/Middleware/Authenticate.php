<?php

namespace App\Infrastructure\Http\Middleware;

use App\Application\User\CheckAuthentication\CheckAuthenticationUseCase;
use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    public function __construct(
        protected CheckAuthenticationUseCase $checkAuthenticationUseCase
    ) {
    }

    public function handle(Request $request, Closure $next)
    {
        $this->checkAuthenticationUseCase->execute();

        return $next($request);
    }
}
