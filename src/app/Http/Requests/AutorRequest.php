<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Nome' => ['required', 'string', 'max:40'],
        ];
    }

    public function messages(): array
    {
        return [
            'Nome.required' => 'O nome do autor é obrigatório.',
            'Nome.max'      => 'O nome deve ter no máximo 40 caracteres.',
        ];
    }
}
