<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'full_name'    => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'password'     => ['nullable', 'string', 'min:8', 'confirmed','regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*]).+$/'],
            'address'      => ['required', 'string', 'max:500'],
            'phone_number' => ['required', 'string', 'max:20'],
            'role'         => ['required', 'string', 'in:admin,user,guest'],
        ];
    }
}
