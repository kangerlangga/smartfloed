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
        Schema::create('lokasi', function (Blueprint $table) {
            $table->string('id_lokasi')->primary();
            $table->string('nama_lokasi');
            $table->string('latlng_lokasi');
            $table->string('ketinggian_lokasi');
            $table->string('status_lokasi');
            $table->string('sensor_lokasi');
            $table->string('foto_lokasi');
            $table->string('visib_lokasi');
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
        Schema::dropIfExists('lokasi');
    }
};
