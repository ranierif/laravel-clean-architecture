<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\Auth;

use App\Application\DTO\Auth\LoginInputDTO;
use App\Application\UseCases\Auth\LoginUseCase;
use App\Domain\Shared\Enum\HttpCode;
use App\Infrastructure\Exceptions\HttpException;
use App\Infrastructure\Helpers\BaseResponse;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class LoginController extends Controller
{
    public function __construct(
        protected LoginUseCase $loginUseCase
    ) {
    }

    /**
     * @throws HttpException
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $output = $this->loginUseCase
                ->execute(
                    new LoginInputDTO([
                        'email' => $data['email'],
                        'password' => $data['password'],
                    ])
                );

            return BaseResponse::successWithContent(
                'Authenticated',
                HttpCode::OK,
                $output->toArray()
            );
        } catch (Throwable $throwable) {
            $errorMessage = $throwable->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidCredentialsError = $errorMessage === 'Invalid credentials';

            if ($isInvalidCredentialsError) {
                $httpCode = HttpCode::UNAUTHORIZED;
            }

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
