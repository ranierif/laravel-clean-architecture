<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\Cart;

use App\Application\Cart\Pay\PayCartInputDTO;
use App\Application\Cart\Pay\PayCartUseCase;
use App\Domain\Shared\Enum\HttpCode;
use App\Infrastructure\Exceptions\HttpException;
use App\Infrastructure\Helpers\BaseResponse;
use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Infrastructure\Http\Requests\Cart\PayCartRequest;
use Throwable;

class PayCartController extends Controller
{
    public function __construct(
        protected PayCartUseCase $payCartUseCase
    ) {
    }

    /**
     * @throws HttpException
     */
    public function __invoke(PayCartRequest $request, string $uuid): JsonResponse
    {
        try {
            $data = $request->validated();

            $payment = $this->payCartUseCase
                ->execute(
                    new PayCartInputDTO([
                        'user_id' => $request->user()->id,
                        'cartUuid' => $uuid,
                        'method' => $data['method'],
                        'card' => $data['card'],
                    ])
                );

            return BaseResponse::successWithContent(
                'Payment created successfully',
                HttpCode::OK,
                $payment->toArray()
            );
        } catch (Throwable $throwable) {
            $errorMessage = $throwable->getMessage();
            $httpCode = $throwable->getCode() ?? HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
