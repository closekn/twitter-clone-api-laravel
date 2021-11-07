<?php

namespace App\Http\Requests\Tweet;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|max:140',
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
