<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,business_advertiser,private_advertiser',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('Name is required'),
            'name.string' => __('Name must be a string'),
            'name.max' => __('Name is too long'),
            'email.required' => __('Email is required'),
            'email.string' => __('Email must be a string'),
            'email.email' => __('Email must be a valid email'),
            'email.max' => __('Email is too long'),
            'email.unique' => __('Email is already taken'),
            'password.required' => __('Password is required'),
            'password.string' => __('Password must be a string'),
            'password.min' => __('Password must be at least 8 characters'),
            'password.confirmed' => __('Passwords do not match'),
            'role.required' => __('Role is required'),
            'role.string' => __('Role must be a string'),
            'role.in' => __('Role must be user, business_advertiser, or private_advertiser'),
        ];
    }
}
