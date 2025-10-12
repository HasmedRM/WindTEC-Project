<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equipamento' => ['nullable', 'string', 'max:255'],
            'frota' => ['nullable', 'string', 'max:255'],
            'configuracao' => ['nullable', 'string', 'max:255'],
            'contrapeso_superestrutura' => ['nullable', 'string', 'max:255'],
            'contrapeso_chassi_inferior' => ['nullable', 'string', 'max:255'],
            'contrapeso_ballast' => ['nullable', 'string', 'max:255'],
            'comprimento_lanca' => ['nullable', 'string', 'max:255'],
            'luffing_jib' => ['nullable', 'string', 'max:255'],
            'cs_12m' => ['nullable', 'string', 'max:255'],
            'cs_14m' => ['nullable', 'string', 'max:255'],
            'cd_16m' => ['nullable', 'string', 'max:255'],
            'p4_12m' => ['nullable', 'string', 'max:255'],
            'p4_14m' => ['nullable', 'string', 'max:255'],
            'p4_18m' => ['nullable', 'string', 'max:255'],
            'p4_12m_dolly' => ['nullable', 'string', 'max:255'],
            'p6_14m' => ['nullable', 'string', 'max:255'],
            'observacoes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
