<?php

namespace App\Infrastructure\Http\Controllers\Cart;

use App\Application\DTO\Cart\CreateCartInputDTO;
use App\Application\UseCases\Cart\CreateCartUseCase;
use App\Domain\Enums\HttpCode;
use App\Infrastructure\Exceptions\HttpException;
use App\Infrastructure\Helpers\BaseResponse;
use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Infrastructure\Http\Requests\Cart\CreateCartRequest;
use Throwable;

class CreateCartController extends Controller
{
    public function __construct(
        protected CreateCartUseCase $createCartUseCase
    ) {
    }

    /**
     * @throws HttpException
     */
    public function __invoke(CreateCartRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $cart = $this->createCartUseCase
                ->execute(
                    new CreateCartInputDTO([
                        'user_id' => $request->user()->id,
                        'items' => $data['items'],
                    ])
                );

            return BaseResponse::successWithContent(
                'Cart created successfully',
                HttpCode::CREATED,
                $cart->toArray()
            );
        } catch (Throwable $throwable) {
            $errorMessage = $throwable->getMessage();
            $httpCode = $throwable->getCode() ?? HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
