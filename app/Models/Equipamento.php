<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipamento',
        'frota',
        'configuracao',
        'contrapeso_superestrutura',
        'contrapeso_chassi_inferior',
        'contrapeso_ballast',
        'comprimento_lanca',
        'luffing_jib',
        'cs_12m',
        'cs_14m',
        'cd_16m',
        'p4_12m',
        'p4_14m',
        'p4_18m',
        'p4_12m_dolly',
        'p6_14m',
        'observacoes',
    ];
}
