<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;

trait ValidateJsonResponse
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
