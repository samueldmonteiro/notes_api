<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        $error = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(
                [
                    'message' => (new ValidationException($validator))->getMessage(),
                    'error' => $error
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );

        parent::failedValidation($validator);
    }
}
