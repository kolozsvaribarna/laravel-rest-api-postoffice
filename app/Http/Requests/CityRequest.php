<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
                'zip_code' => 'nullable|numeric',
                'county_id' => 'nullable|numeric|exists:counties,id',
                'population' => 'nullable|numeric',
            ];
        }

        return ([
            'name' => 'required|string|min:3|max:255',
            'zip_code' => 'required|numeric',
            'county_id' => 'required|numeric|exists:counties,id',
            'population' => 'required|numeric',
        ]);
    }
}
