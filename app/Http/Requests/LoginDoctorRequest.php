<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.phone' => ['required', 'string', 'digits:11', 'regex:/^09[0-9]{9}$/'],
            'data.password' => ['required', 'string'],
            'data.remember' => ['sometimes', 'boolean'],
            'data.email' => ['required', 'email', 'string','regex:/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[A-Za-z]{2,}$/'],
        ];
    }
}
