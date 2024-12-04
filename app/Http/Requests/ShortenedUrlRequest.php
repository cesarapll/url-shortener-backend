<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;



/**
 * @OA\Schema(
 *     schema="ShortenedUrlRequest",
 *     type="object",
 *     title="ShortenedUrlRequest",
 *     description="Create shortened URL request schema",
 *     required={"original_url"},
 *     @OA\Property(property="original_url", type="string", format="url", example="https://laravel.com/")
 * )
 */
class ShortenedUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'original_url' => 'required|url'
        ];
    }

    public function messages()
    {
        return [
            'original_url.required' => 'El URL original es requerido',
            'original_url.url' => 'El URL original no tiene el formato correcto'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'El URL original no es válido',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
