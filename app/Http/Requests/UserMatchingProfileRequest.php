<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserMatchingProfileRequest extends FormRequest
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
            'university' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'hobbies' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'education' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
            'gender' => 'required|string|max:25',
            'image' => 'required|image|max:2048',
        ];
    }
}
