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
        Schema::create('m_galeri', function (Blueprint $table) {
            $table->id('id_galeri');
            $table->string('nama_galeri');
            $table->date('tanggal_upload');
            $table->string('upload_gambar');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_galeri');
    }
};
