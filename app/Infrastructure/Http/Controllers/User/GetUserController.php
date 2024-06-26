<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\User;

use App\Application\User\Get\GetUserInputDTO;
use App\Application\User\Get\GetUserUseCase;
use App\Domain\Shared\Enum\HttpCode;
use App\Infrastructure\Exceptions\HttpException;
use App\Infrastructure\Helpers\BaseResponse;
use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class GetUserController extends Controller
{
    public function __construct(
        protected GetUserUseCase $getUserUseCase
    ) {
    }

    /**
     * @throws HttpException
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $user = $this->getUserUseCase
                ->execute(
                    new GetUserInputDTO([
                        'userId' => $request->user()->id,
                    ])
                );

            return BaseResponse::successWithContent(
                'Get user successfully',
                HttpCode::OK,
                $user->toArray()
            );
        } catch (Throwable $throwable) {
            $errorMessage = $throwable->getMessage();
            $httpCode = $throwable->getCode() ?? HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
