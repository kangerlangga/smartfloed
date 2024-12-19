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
        Schema::create('infografis', function (Blueprint $table) {
            $table->string('id_infografis')->primary();
            $table->string('judul_infografis');
            $table->string('sumber_infografis');
            $table->string('foto_infografis');
            $table->string('visib_infografis');
            $table->string('created_by');
            $table->string('modified_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infografis');
    }
};
