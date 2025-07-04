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
        Schema::create('m_artikel', function (Blueprint $table) {
            $table->id('id_artikel');
            $table->unsignedBigInteger('id_jenis')->index;
            $table->string('judul');
            $table->text('isi_Artikel');
            $table->string('gambar')->nullable();

            $table->foreign('id_jenis')->references('id_jenis')->on('m_jenis_artikel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('m_artikel');
    }
};
