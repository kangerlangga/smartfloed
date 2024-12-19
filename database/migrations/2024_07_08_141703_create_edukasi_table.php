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
        Schema::create('edukasi', function (Blueprint $table) {
            $table->string('id_edukasi')->primary();
            $table->string('id_detail')->unique();
            $table->string('judul_edukasi');
            $table->longText('isi_edukasi');
            $table->string('foto_edukasi');
            $table->string('penulis_edukasi');
            $table->string('visib_edukasi');
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
        Schema::dropIfExists('edukasi');
    }
};
