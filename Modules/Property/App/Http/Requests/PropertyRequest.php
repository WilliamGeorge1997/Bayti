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
            'area' => 'sometimes|numeric',
            'floor' => 'sometimes|integer',
            'directions' => 'sometimes|string',
            'age' => 'sometimes|integer',
            'ownership_type' => 'sometimes|string',
            'bedrooms' => 'sometimes|integer',
            'living_rooms' => 'sometimes|integer',
            'bathrooms' => 'sometimes|integer',
            'width_ratio' => 'sometimes|numeric',
            'phone' => 'required|string',
            'whatsapp' => 'required|string',
            'video' => 'sometimes|url',
            'notes' => 'sometimes|string',
            'is_furnished' => 'sometimes|boolean',
            'is_installment' => 'sometimes|boolean',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:1024',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'sub_category_id' => 'Sub Category',
            'lat' => 'Latitude',
            'long' => 'Longitude',
            'city' => 'City',
            'address' => 'Address',
            'price' => 'Price',
            'area' => 'Area',
            'floor' => 'Floor',
            'directions' => 'Directions',
            'age' => 'Age',
            'ownership_type' => 'Ownership Type',
            'bedrooms' => 'Bedrooms',
            'living_rooms' => 'Living Rooms',
            'bathrooms' => 'Bathrooms',
            'width_ratio' => 'Width Ratio',
            'video' => 'Video',
            'notes' => 'Notes',
            'is_furnished' => 'Is Furnished',
            'is_installment' => 'Is Installment',
            'images' => 'Images',
            'images.*' => 'Image',
            'phone' => 'Phone Number',
            'whatsapp' => 'Whatsapp Number',
        ];
    }

    public function authorize(): bool
    {
        if (auth('client')->user()->properties()->count() >= 1) {
            throw new HttpResponseException(
                returnMessage(
                    false,
                    'لا يمكنك انشاء اكثر من اعلان واحد للعقارات',
                    null,
                    'forbidden'
                )
            );
        }
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