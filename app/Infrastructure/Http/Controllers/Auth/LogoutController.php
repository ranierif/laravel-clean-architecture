<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\Auth;

use App\Application\User\Logout\LogoutUseCase;
use App\Domain\Shared\Enum\HttpCode;
use App\Infrastructure\Exceptions\HttpException;
use App\Infrastructure\Helpers\BaseResponse;
use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class LogoutController extends Controller
{
    public function __construct(
        protected LogoutUseCase $logoutUseCase
    ) {
    }

    /**
     * @throws HttpException
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->logoutUseCase->execute();

            return BaseResponse::success(
                'Successfully logged out',
                HttpCode::OK
            );
        } catch (Throwable $throwable) {
            $errorMessage = $throwable->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
