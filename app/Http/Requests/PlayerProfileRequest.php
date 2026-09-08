<?php

namespace App\Http\Requests;

use App\Models\PlayerProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlayerProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isPlayer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'position' => ['required', 'string', Rule::in(PlayerProfile::POSITIONS)],
            'date_of_birth' => ['required', 'date', 'before:today', 'after:1950-01-01'],
            'location' => ['required', 'string', 'max:100'],
            'preferred_foot' => ['nullable', 'string', Rule::in(PlayerProfile::PREFERRED_FEET)],
            'height' => ['nullable', 'integer', 'min:120', 'max:250'],
            'weight' => ['nullable', 'integer', 'min:30', 'max:200'],
            'current_club' => ['nullable', 'string', 'max:150'],
            'football_experience' => ['nullable', 'string', 'max:2000'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:50'],
        ];
    }
}
