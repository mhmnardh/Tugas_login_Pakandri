<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('member')->restrictOnDelete();
            $table->foreignId('buku_id')->nullable()->constrained('buku')->nullOnDelete();
            $table->date('tanggal_pinjam')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->string('status')->default('dipinjam');
            $table->timestamps();
        });

        DB::table('member')
            ->whereNotNull('buku_id')
            ->orderBy('id')
            ->get(['id', 'buku_id'])
            ->each(function (object $member): void {
                DB::table('peminjaman')->insert([
                    'member_id' => $member->id,
                    'buku_id' => $member->buku_id,
                    'status' => 'dipinjam',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');

        Schema::table('member', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
