<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Titulo'        => ['required', 'string', 'max:40'],
            'Editora'       => ['required', 'string', 'max:40'],
            'Edicao'        => ['required', 'integer', 'min:1'],
            'AnoPublicacao' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
            'Valor'         => ['required', 'numeric', 'min:0'],
            'autores'       => ['required', 'array', 'min:1'],
            'autores.*'     => ['integer', 'exists:Autor,CodAu'],
            'assuntos'      => ['nullable', 'array'],
            'assuntos.*'    => ['integer', 'exists:Assunto,codAs'],
        ];
    }

    public function messages(): array
    {
        return [
            'Titulo.required'           => 'O título é obrigatório.',
            'Titulo.max'                => 'O título deve ter no máximo 40 caracteres.',
            'Editora.required'          => 'A editora é obrigatória.',
            'Editora.max'               => 'A editora deve ter no máximo 40 caracteres.',
            'Edicao.required'           => 'A edição é obrigatória.',
            'Edicao.integer'            => 'A edição deve ser um número inteiro.',
            'Edicao.min'                => 'A edição deve ser maior que zero.',
            'AnoPublicacao.required'    => 'O ano de publicação é obrigatório.',
            'AnoPublicacao.size'        => 'O ano deve ter exatamente 4 dígitos.',
            'AnoPublicacao.regex'       => 'O ano deve conter apenas números.',
            'Valor.required'            => 'O valor é obrigatório.',
            'Valor.numeric'             => 'O valor deve ser numérico.',
            'Valor.min'                 => 'O valor não pode ser negativo.',
            'autores.required'          => 'Selecione ao menos um autor.',
            'autores.min'               => 'Selecione ao menos um autor.',
            'autores.*.exists'          => 'Autor inválido selecionado.',
            'assuntos.*.exists'         => 'Assunto inválido selecionado.',
        ];
    }
}
