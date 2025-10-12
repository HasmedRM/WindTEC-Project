<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GdtRequest extends FormRequest
{
    /**
     * Determaxe if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<numeric, \Illumaxate\Contracts\Validation\ValidationRule|array<mixed>|numeric>
     */
    public function rules(): array
    {
        return [
            'cliente'                      => 'nullable|string|max:255',
            'operacao'                     => 'nullable|string|max:255',
            'equipamento'                  => 'nullable|string|max:255',
            'configuracao'                 => 'nullable|string|max:255',
            'altura_torre'                 => 'nullable|string|max:255',
            'comprimento_lanca'            => 'nullable|string|max:255',
            'comprimento_luffing_jib'      => 'nullable|string|max:255',
            'contrapeso'                   => 'nullable|string|max:255',
            'contrapeso_ballast'           => 'nullable|string|max:255',
            'cs_12m_atv'                   => 'nullable|string|max:255',
            'cs_14m_atv'                   => 'nullable|string|max:255',
            'p4_12m_atv'                   => 'nullable|string|max:255',
            'p4_14m_atv'                   => 'nullable|string|max:255',
            'p4_12m_dolly_atv'             => 'nullable|string|max:255',
            'p4_12m_dolly_gdt'             => 'nullable|string|max:255',
            'equipamento_auxiliar_atv'     => 'nullable|string|max:255',
            'cs_12m_gdt'                   => 'nullable|string|max:255',
            'cs_14m_gdt'                   => 'nullable|string|max:255',
            'p4_12m_gdt'                   => 'nullable|string|max:255',
            'p4_14m_gdt'                   => 'nullable|string|max:255',
            'equipamento_auxiliar_mtg'     => 'nullable|string|max:255',
            'cs_12m_mtg'                   => 'nullable|string|max:255',
            'observacoes'                  => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            '*.string' => 'O campo :attribute deve ser um texto válido.',
            '*.max'    => 'O campo :attribute não pode exceder o tamanho máximo.',
        ];
    }
}
