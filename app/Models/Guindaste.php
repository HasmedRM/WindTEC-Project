<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guindaste extends Model
{
    protected $fillable = [
        'cliente',
        'altura_torre',
        'operacao',
        'equipamento',
        'configuracao',
        'comprimento_lanca',
        'comprimento_luffing_jib',
        'contrapeso',
        'contrapeso_ballast',
        'cs_12m_atv',
        'cs_14m_atv',
        'p4_12m_atv',
        'p4_14m_atv',
        'p4_12m_dolly_atv',
        'equipamento_auxiliar_atv',
        'cs_12m_gdt',
        'cs_14m_gdt',
    'p4_12m_gdt',
    'p4_14m_gdt',
    'p4_12m_dolly_gdt',
        'equipamento_auxiliar_mtg',
        'cs_12m_mtg',
        'observacoes',
    ];
}
