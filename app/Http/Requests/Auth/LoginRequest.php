<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:32',
            'password' => 'required|min:8'
        ];
    }

    /**
     * @param Validator $validator
     *
     * @return Response
     */
    protected function failedValidation(Validator $validator): Response
    {
        $res = response()->json([
            'result' => false,
            'errors' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST);

        throw new HttpResponseException($res);
    }
}
