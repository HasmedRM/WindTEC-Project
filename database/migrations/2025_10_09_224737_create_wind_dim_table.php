<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wind_dim', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('cliente');
            $table->foreignId('altura_torre_id')->constrained('altura_torre');
            $table->foreignId('operacao_id')->constrained('operacao');
            $table->foreignId('equipamento_id')->constrained('equipamento');
            $table->foreignId('configuracao_id')->constrained('configuracao');
            $table->foreignId('comprimento_lanca_id')->constrained('comprimento_lanca');
            $table->foreignId('comprimento_luffing_jib_id')->constrained('comprimento_luffing_jib');
            $table->foreignId('contrapeso_id')->constrained('contrapeso');
            $table->foreignId('contrapeso_ballast_id')->constrained('contrapeso_ballast');
            $table->foreignId('cs_12m_gdt_id')->constrained('cs_12m_gdt');
            $table->foreignId('cs_14m_gdt_id')->constrained('cs_14m_gdt');
            $table->foreignId('p4_12m_gdt_id')->constrained('p4_12m_gdt');
            $table->foreignId('p4_14m_gdt_id')->constrained('p4_14m_gdt');
            $table->foreignId('p4_14m_dolly_gdt_id')->constrained('p4_14m_dolly_gdt');
            $table->foreignId('equipamento_auxiliar_atv_id')->constrained('equipamento_auxiliar_atv');
            $table->foreignId('cs_12m_atv_id')->constrained('cs_12m_atv');
            $table->foreignId('cs_14m_atv_id')->constrained('cs_14m_atv');
            $table->foreignId('p4_12m_atv_id')->constrained('p4_12m_atv');
            $table->foreignId('p4_14m_atv_id')->constrained('p4_14m_atv');
            $table->foreignId('p4_14m_dolly_atv_id')->constrained('p4_14m_dolly_atv');
            $table->foreignId('equipamento_auxiliar_mtg_id')->constrained('equipamento_auxiliar_mtg');
            $table->foreignId('cs_12m_mtg_id')->constrained('cs_12m_mtg');
            $table->foreignId('obs_mtg_id')->constrained('obs_mtg');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wind_dim');
    }
};
