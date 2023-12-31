<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method == 'POST' || $method == 'PUT') return [
            'title' => ['required', 'string', 'min:4', 'max:30'],
            'content' => ['required', 'string', 'min:4', 'max:10000'],
            'color' => ['required', 'max:15', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i']
        ];
    }
}
