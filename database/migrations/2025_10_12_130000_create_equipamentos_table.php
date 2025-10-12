<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('equipamentos')) {
            Schema::create('equipamentos', function (Blueprint $table) {
                $table->id();
                $table->string('equipamento')->nullable();
                $table->string('frota')->nullable();
                $table->string('configuracao')->nullable();
                $table->string('contrapeso_superestrutura')->nullable();
                $table->string('contrapeso_chassi_inferior')->nullable();
                $table->string('contrapeso_ballast')->nullable();
                $table->string('comprimento_lanca')->nullable();
                $table->string('luffing_jib')->nullable();
                $table->string('cs_12m')->nullable();
                $table->string('cs_14m')->nullable();
                $table->string('cd_16m')->nullable();
                $table->string('p4_12m')->nullable();
                $table->string('p4_14m')->nullable();
                $table->string('p4_18m')->nullable();
                $table->string('p4_12m_dolly')->nullable();
                $table->string('p6_14m')->nullable();
                $table->text('observacoes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};
