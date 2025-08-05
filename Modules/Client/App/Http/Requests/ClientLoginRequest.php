<?php

namespace Modules\Client\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Client\App\Models\Client;
use Illuminate\Support\Facades\Hash;

class ClientLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required'],
            'password' => ['required'],
            'country_code' => ['required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'phone' => 'Phone Number',
            'password' => 'Password',
            'fcm_token' => 'FCM Token',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $phone = $this->input('phone');
            $country_code = $this->input('country_code');
            $password = $this->input('password');
            $client = Client::where('phone', $phone)
                ->where('country_code', $country_code)
                ->first();
            if (!$client) {
                $phoneExists = Client::where('phone', $phone)->exists();
                if ($phoneExists) {
                    $validator->errors()->add('country_code', 'رمز البلد غير صحيح.');
                } else {
                    $validator->errors()->add('phone', 'رقم الهاتف هذا غير مسجل.');
                }
            } else {
                if (!Hash::check($password, $client->password)) {
                    $validator->errors()->add('password', 'كلمة المرور غير صحيحة.');
                }
            }
        });
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
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
