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
            'description' => 'sometimes|string',
            'sub_category_id' => 'sometimes|exists:sub_categories,id',
            'lat' => 'sometimes|numeric',
            'long' => 'sometimes|numeric',
            'country' => 'sometimes|string',
            'city' => 'sometimes|string',
            'address' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'type' => 'sometimes|string',
            'area' => 'sometimes|numeric',
            'floor' => 'sometimes|integer',
            'directions' => 'sometimes|string',
            'age' => 'sometimes|integer',
            'ownership_type' => 'sometimes|string|in:طابو اخضر,حكم محكمة,غير ذلك',
            'bedrooms' => 'sometimes|integer',
            'living_rooms' => 'sometimes|integer',
            'bathrooms' => 'sometimes|integer',
            'facades' => 'sometimes|integer',
            'scale' => 'sometimes|numeric',
            'pools' => 'sometimes|integer',
            'salons' => 'sometimes|integer',
            'total_area' => 'sometimes|numeric',
            'fruit_trees' => 'sometimes|integer',
            'water_wells' => 'sometimes|integer',
            'video' => 'sometimes|url',
            'phone' => 'sometimes|string',
            'whatsapp' => 'sometimes|string',
            'notes' => 'sometimes|string',
            'rental_period' => 'sometimes|string|in:شهري,يومي,سنوي,الكل',
            'finishing_status' => 'sometimes|string|in:جاهز للسكن,بحاجة إلى اكساء',
            'is_furnished' => 'sometimes|boolean',
            'is_installment' => 'sometimes|boolean',
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:1024',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'Type',
            'description' => 'Description',
            'sub_category_id' => 'Sub Category',
            'lat' => 'Latitude',
            'long' => 'Longitude',
            'country' => 'Country',
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
            'facades' => 'Facades',
            'scale' => 'Scale',
            'pools' => 'Pools',
            'salons' => 'Salons',
            'total_area' => 'Total Area',
            'fruit_trees' => 'Fruit Trees',
            'water_wells' => 'Water Wells',
            'finishing_status' => 'Finishing Status',
            'video' => 'Video',
            'notes' => 'Notes',
            'is_furnished' => 'Is Furnished',
            'is_installment' => 'Is Installment',
            'images' => 'Images',
            'images.*' => 'Image',
            'phone' => 'Phone',
            'whatsapp' => 'Whatsapp',
            'rental_period' => 'Rental Period',
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