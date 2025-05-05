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
        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->string('id_referensi');
            $table->string('path');
            $table->string('type');
            $table->string('context'); // contoh: 'magang', 'sekolah', 'admin'
        
            // Index untuk mempercepat query berdasarkan referensi dan context
            $table->index(['id_referensi', 'context', 'type']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto');
    }
};
