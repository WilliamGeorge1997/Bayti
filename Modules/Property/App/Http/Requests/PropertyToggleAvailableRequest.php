<?php

namespace Modules\Property\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class PropertyToggleAvailableRequest extends FormRequest
{
    private $property;
    /**
     * Get the validation rules that apply to the request.
     */
    public function prepareForValidation()
    {
        $this->property = $this->route('property');
    }
    public function rules(): array
    {
        $property = $this->property;
        if ($property->is_available == 1) {
            return [
                'unavailable_comment' => 'required|string',
                'is_sold' => 'required|boolean',
            ];
        }
        return [
        ];
    }

    public function attributes(): array
    {
        return [
            'unavailable_comment' => 'Unavailable Comment',
            'is_sold' => 'Is Sold',
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $property = $this->property;

        if (auth('client')->id() !== $property->client_id) {
            throw new HttpResponseException(
                returnMessage(
                    false,
                    'لا يمكنك تعديل هذا العقار',
                    null,
                    'forbidden'
                )
            );
        }

        if ($property->is_sold == 1) {
            throw new HttpResponseException(
                returnMessage(
                    false,
                    'لا يمكنك تعديل عقار تم بيعه',
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
