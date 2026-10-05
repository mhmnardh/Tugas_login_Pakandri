<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('DROP INDEX IF EXISTS member_buku_id_unique');
            $uniqueExists = false;
            $foreignExists = collect(DB::select('PRAGMA foreign_key_list(member)'))
                ->contains(fn ($foreign) => $foreign->from === 'buku_id' && $foreign->table === 'buku');
        } else {
            $uniqueExists = collect(DB::select(
                "SHOW INDEX FROM member WHERE Key_name = 'member_buku_id_unique'"
            ))->isNotEmpty();
            $foreignExists = collect(DB::select(
                "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = 'member'
                   AND COLUMN_NAME = 'buku_id'
                   AND REFERENCED_TABLE_NAME IS NOT NULL"
            ))->isNotEmpty();

            if ($foreignExists || $uniqueExists) {
                Schema::table('member', function (Blueprint $table) use ($foreignExists, $uniqueExists) {
                    if ($foreignExists) {
                        $table->dropForeign(['buku_id']);
                    }

                    if ($uniqueExists) {
                        $table->dropUnique(['buku_id']);
                    }
                });
            }
        }

        Schema::table('member', function (Blueprint $table) {
            $table->unsignedBigInteger('buku_id')->nullable()->change();
            $table->foreign('buku_id')->references('id')->on('buku')->nullOnDelete();
        });

        $kategoriForeignExists = DB::connection()->getDriverName() === 'sqlite'
            || collect(DB::select(
                "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = 'buku'
                   AND COLUMN_NAME = 'kategori_id'
                   AND REFERENCED_TABLE_NAME IS NOT NULL"
            ))->isNotEmpty();

        Schema::table('buku', function (Blueprint $table) use ($kategoriForeignExists) {
            if ($kategoriForeignExists) {
                $table->dropForeign(['kategori_id']);
            }

            $table->unsignedBigInteger('kategori_id')->nullable()->change();
            $table->foreign('kategori_id')->references('id')->on('kategori')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->dropForeign(['buku_id']);
            $table->unsignedBigInteger('buku_id')->nullable(false)->change();
        });

        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('DROP INDEX IF EXISTS member_buku_id_unique');
        } else {
            Schema::table('member', function (Blueprint $table) {
                $table->unique('buku_id');
            });
        }

        Schema::table('buku', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->unsignedBigInteger('kategori_id')->nullable(false)->change();
            $table->foreign('kategori_id')->references('id')->on('kategori');
        });
    }
};
