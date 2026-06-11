<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'developer' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'release_date' => ['required', 'date'],
            'img_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,avif', 'max:2048'],
        ];
    }
}
