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
            $table->string('p4_12m_dolly_gdt')->nullable()->after('p4_12m_gdt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guindastes', function (Blueprint $table) {
            $table->dropColumn('p4_12m_dolly_gdt');
        });
    }
};
