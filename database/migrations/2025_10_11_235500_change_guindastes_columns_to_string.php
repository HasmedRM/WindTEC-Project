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
        Schema::table('guindastes', function (Blueprint $table) {
            // Convert numeric columns to string. Requires doctrine/dbal to run the change().
            $table->string('cliente')->nullable()->change();
            $table->string('altura_torre')->nullable()->change();
            $table->string('operacao')->nullable()->change();
            $table->string('equipamento')->nullable()->change();
            $table->string('configuracao')->nullable()->change();
            $table->string('comprimento_lanca')->nullable()->change();
            $table->string('comprimento_luffing_jib')->nullable()->change();
            $table->string('contrapeso')->nullable()->change();
            $table->string('contrapeso_ballast')->nullable()->change();

            $table->string('cs_12m_atv')->nullable()->change();
            $table->string('cs_14m_atv')->nullable()->change();
            $table->string('p4_12m_atv')->nullable()->change();
            $table->string('p4_14m_atv')->nullable()->change();
            $table->string('p4_12m_dolly_atv')->nullable()->change();
            $table->string('equipamento_auxiliar_atv')->nullable()->change();

            $table->string('cs_12m_gdt')->nullable()->change();
            $table->string('cs_14m_gdt')->nullable()->change();
            $table->string('p4_12m_gdt')->nullable()->change();
            $table->string('p4_14m_gdt')->nullable()->change();
            $table->string('equipamento_auxiliar_mtg')->nullable()->change();
            $table->string('cs_12m_mtg')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guindastes', function (Blueprint $table) {
            $table->unsignedBigInteger('cliente')->nullable()->change();
            $table->unsignedBigInteger('altura_torre')->nullable()->change();
            $table->unsignedBigInteger('operacao')->nullable()->change();
            $table->unsignedBigInteger('equipamento')->nullable()->change();
            $table->unsignedBigInteger('configuracao')->nullable()->change();
            $table->unsignedBigInteger('comprimento_lanca')->nullable()->change();
            $table->unsignedBigInteger('comprimento_luffing_jib')->nullable()->change();
            $table->unsignedBigInteger('contrapeso')->nullable()->change();
            $table->unsignedBigInteger('contrapeso_ballast')->nullable()->change();

            $table->unsignedBigInteger('cs_12m_atv')->nullable()->change();
            $table->unsignedBigInteger('cs_14m_atv')->nullable()->change();
            $table->unsignedBigInteger('p4_12m_atv')->nullable()->change();
            $table->unsignedBigInteger('p4_14m_atv')->nullable()->change();
            $table->unsignedBigInteger('p4_12m_dolly_atv')->nullable()->change();
            $table->unsignedBigInteger('equipamento_auxiliar_atv')->nullable()->change();

            $table->unsignedBigInteger('cs_12m_gdt')->nullable()->change();
            $table->unsignedBigInteger('cs_14m_gdt')->nullable()->change();
            $table->unsignedBigInteger('p4_12m_gdt')->nullable()->change();
            $table->unsignedBigInteger('p4_14m_gdt')->nullable()->change();
            $table->unsignedBigInteger('equipamento_auxiliar_mtg')->nullable()->change();
            $table->unsignedBigInteger('cs_12m_mtg')->nullable()->change();
        });
    }
};
