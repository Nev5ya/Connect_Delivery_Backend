<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        'name' => "string",
        'email' => "string",
        'password' => "string",
        'password_confirmation' => "string"
    ])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user()->id,
            'password' => 'required|confirmed|string|min:3',
            'password_confirmation' => 'required|string|min:3'
        ];
    }

    /**
     * Get the custom validation attributes that apply the request.
     * @return array
     */
    #[ArrayShape(['currentPassword' => "string"])]
    public function attributes(): array
    {
        return [
            'currentPassword' => 'Текущий пароль'
        ];
    }
}
