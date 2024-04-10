<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\User;

use App\Application\DTO\User\CreateUserInputDTO;
use App\Application\UseCases\User\CreateUserUseCase;
use App\Domain\Enums\HttpCode;
use App\Infrastructure\Exceptions\HttpException;
use App\Infrastructure\Helpers\BaseResponse;
use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Infrastructure\Http\Requests\User\CreateUserRequest;
use Throwable;

class CreateUserController extends Controller
{
    public function __construct(
        protected CreateUserUseCase $createUserUseCase
    ) {
    }

    /**
     * @throws HttpException
     */
    public function __invoke(CreateUserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $this->createUserUseCase
                ->execute(
                    new CreateUserInputDTO([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phoneNumber' => $data['phone_number'],
                        'password' => $data['password'],
                    ])
                );

            return BaseResponse::success(
                'User created successfully',
                HttpCode::CREATED
            );
        } catch (Throwable $throwable) {
            $errorMessage = $throwable->getMessage();
            $httpCode = $throwable->getCode() ?? HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
