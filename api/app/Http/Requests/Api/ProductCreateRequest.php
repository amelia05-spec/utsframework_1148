<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductCreateRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:products,name'],
            'description' => ['string'],
            'price' => ['required', 'integer', 'min:0'],
            'image' => ['required', 'image', 'max:2048', 'mimes:jpeg,png,jpg,gif,svg'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'expired_at' => ['required', 'date']
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): never
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'pesan_error' => $validator->errors()
        ], 400));
    }
}
