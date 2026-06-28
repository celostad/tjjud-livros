<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssuntoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Descricao' => ['required', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'Descricao.required' => 'A descrição do assunto é obrigatória.',
            'Descricao.max'      => 'A descrição deve ter no máximo 20 caracteres.',
        ];
    }
}
