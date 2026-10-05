<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CountyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->method() === 'PATCH') {
            return [
                'name' => 'nullable|string|min:3|max:255',
                'badge' => 'nullable|string|min:10|max:255',
            ];
        }

        return [
            'name' => 'required|string|min:3|max:255',
            'badge' => 'required|string|min:10|max:255',
        ];
    }
}
