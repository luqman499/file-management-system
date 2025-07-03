<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
           'department_id' => 'required|exists:departments,id',
           'office_id' => 'required|exists:offices,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|',
            'password' => 'required|string|min:8',
           'image' => 'nullable|image|max:2048',
            'cnic' => 'nullable|string|max:25',
            'contact' => 'nullable|string|max:15',
        ];
    }
}
