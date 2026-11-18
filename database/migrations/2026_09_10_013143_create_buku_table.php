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
        if (! Schema::hasTable('buku')) {
            Schema::create('buku', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kategori_id')->nullable();
                $table->string('nama_buku');
                $table->string('isbn');
                $table->integer('stok');
                $table->string('foto_buku')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
