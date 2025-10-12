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
        Schema::create('guindastes', function (Blueprint $table) {
            $table->id();

            // Use unsignedBigInteger to match typical foreign key ids; keep nullable to be permissive.
            $table->unsignedBigInteger('cliente')->nullable()->index();
            $table->unsignedBigInteger('altura_torre')->nullable()->index();
            $table->unsignedBigInteger('operacao')->nullable()->index();
            $table->unsignedBigInteger('equipamento')->nullable()->index();
            $table->unsignedBigInteger('configuracao')->nullable()->index();
            $table->unsignedBigInteger('comprimento_lanca')->nullable()->index();
            $table->unsignedBigInteger('comprimento_luffing_jib')->nullable()->index();
            $table->unsignedBigInteger('contrapeso')->nullable()->index();
            $table->unsignedBigInteger('contrapeso_ballast')->nullable()->index();

            $table->unsignedBigInteger('cs_12m_atv')->nullable()->index();
            $table->unsignedBigInteger('cs_14m_atv')->nullable()->index();
            $table->unsignedBigInteger('p4_12m_atv')->nullable()->index();
            $table->unsignedBigInteger('p4_14m_atv')->nullable()->index();
            $table->unsignedBigInteger('p4_12m_dolly_atv')->nullable()->index();
            $table->unsignedBigInteger('equipamento_auxiliar_atv')->nullable()->index();

            $table->unsignedBigInteger('cs_12m_gdt')->nullable()->index();
            $table->unsignedBigInteger('cs_14m_gdt')->nullable()->index();
            $table->unsignedBigInteger('p4_12m_gdt')->nullable()->index();
            $table->unsignedBigInteger('p4_14m_gdt')->nullable()->index();
            $table->unsignedBigInteger('equipamento_auxiliar_mtg')->nullable()->index();
            $table->unsignedBigInteger('cs_12m_mtg')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guindastes');
    }
};
