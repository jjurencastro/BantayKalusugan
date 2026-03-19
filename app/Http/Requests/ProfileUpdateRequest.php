<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Support\DateInput;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'date_of_birth' => DateInput::normalize($this->input('date_of_birth')),
        ]);
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
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
        ];
    }
}
