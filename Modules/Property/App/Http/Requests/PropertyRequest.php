<?php

namespace Modules\Property\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class PropertyRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'city' => 'required|string',
            'address' => 'required|string',
            'price' => 'required|numeric',
            'area' => 'required|numeric',
            'floor' => 'required|integer',
            'directions' => 'required|string',
            'age' => 'required|integer',
            'ownership_type' => 'required|string',
            'bedrooms' => 'required|integer',
            'living_rooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'width_ratio' => 'required|numeric',
            'video' => 'sometimes|url',
            'notes' => 'sometimes|string',
            'is_furnished' => 'sometimes|boolean',
            'is_installment' => 'sometimes|boolean',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:1024',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            returnValidationMessage(
                false,
                trans('validation.rules_failed'),
                $validator->errors()->messages(),
                'unprocessable_entity'
            )
        );
    }
}