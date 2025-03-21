<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'role' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Заполните имя',
            'name.string' => 'Неверный формат имени пользователя',
            'email.required' => 'Заполните Email',
            'email.string' => 'Неверная почта',
            'email.email' => 'Неверная почта',
            'email.unique' => 'Пользователь с таким Email уже существует',
        ];
    }
}
