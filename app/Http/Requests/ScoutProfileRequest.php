<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoutProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isScout();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'organization' => ['required', 'string', 'max:150'],
            'role_title' => ['nullable', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:100'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
            'phone' => ['nullable', 'string', 'max:50'],
            'license_number' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
