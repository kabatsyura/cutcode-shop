<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns', 'exists:users,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Введите валидный email',
            'email.exists' => 'Пользователь с таким email не найден',
        ];
    }
}
