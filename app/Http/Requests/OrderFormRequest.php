<?php

namespace App\Http\Requests;

use Domain\Order\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class OrderFormRequest extends FormRequest
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
            'customer.first_name' => ['required'],
            'customer.last_name' => ['required'],
            'customer.email' => ['required', 'email:dns'],
            'customer.phone' => ['required', new PhoneRule()],
            'customer.city' => ['sometimes'],
            'customer.adress' => ['sometimes'],
            'create_account' => ['boolean'],
            'password' => request()->boolean('create_account') ? ['required', 'confirmed', Password::default()] : ['sometimes'],
            'delivery_type_id' => ['required', 'exists:delivery_types,id'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
        ];
    }
}
