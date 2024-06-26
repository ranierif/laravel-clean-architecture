<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\Cart;

use App\Application\Cart\Get\GetCartInputDTO;
use App\Application\Cart\Get\GetCartUseCase;
use App\Domain\Shared\Enum\HttpCode;
use App\Infrastructure\Exceptions\HttpException;
use App\Infrastructure\Helpers\BaseResponse;
use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class GetCartController extends Controller
{
    public function __construct(
        protected GetCartUseCase $getCartUseCase
    ) {
    }

    /**
     * @throws HttpException
     */
    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        try {
            $cart = $this->getCartUseCase
                ->execute(
                    new GetCartInputDTO([
                        'uuid' => $uuid,
                        'user_id' => $request->user()->id,
                    ])
                );

            return BaseResponse::successWithContent(
                'Get cart successfully',
                HttpCode::OK,
                $cart->toArray()
            );
        } catch (Throwable $throwable) {
            $errorMessage = $throwable->getMessage();
            $httpCode = $throwable->getCode() ?? HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
