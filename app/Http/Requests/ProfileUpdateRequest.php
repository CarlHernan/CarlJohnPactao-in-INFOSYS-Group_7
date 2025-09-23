<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $email = is_string($this->input('email')) ? trim($this->input('email')) : $this->input('email');
            $this->merge([
                'email' => ($email === '' ? null : $email),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                // Ensure we ignore the actual primary key column (user_id) when checking uniqueness
                Rule::unique('users', 'email')->ignore($this->user()->getKey(), $this->user()->getKeyName()),
            ],
        ];
    }
}
