<?php

namespace Infrastructure\Http\Requests\Cart;

use App\Domain\Enums\PaymentMethodEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PayCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'method' => [
                'required',
                'string',
                Rule::enum(PaymentMethodEnum::class),
            ],
            'card' => [
                'required_if:method,'.PaymentMethodEnum::CREDIT_CARD->value,
                'array',
            ],
            'card.number' => [
                'required_with:card',
                'string',
            ],
            'card.holder' => [
                'required_with:card',
                'string',
            ],
            'card.cvv' => [
                'required_with:card',
                'string',
            ],
            'card.expiration' => [
                'required_with:card',
                'date_format:m/y',
            ],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
            ], 422));
    }
}
