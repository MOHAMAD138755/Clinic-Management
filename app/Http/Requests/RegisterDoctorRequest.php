<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->check() && session()->has(['phone','email','password']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.first_name' => ['required', 'string', 'min:3', 'max:30','regex:/^[a-zA-Z]+$/'],
            'data.last_name' => ['required', 'string', 'min:3', 'max:40','regex:/^[a-zA-Z]+$/'],
            'data.medical_system_number' => ['required', 'string' ,'digits:10' ,'regex:/^[0-9]+$/','unique:doctors,medical_system_number'],
            'data.profile' => ['required', 'file', 'mimes:jpeg,jpg,png', 'max:1024','image'],
        ];
    }
}
