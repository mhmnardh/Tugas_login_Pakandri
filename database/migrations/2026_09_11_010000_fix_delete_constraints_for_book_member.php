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
        if (DB::connection()->getDriverName() !== 'sqlite') {
            $uniqueExists = collect(DB::select("SHOW INDEX FROM member WHERE Key_name = 'member_buku_id_unique'"))->isNotEmpty();
            $foreignExists = collect(DB::select(
                "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'member' AND COLUMN_NAME = 'buku_id' AND REFERENCED_TABLE_NAME IS NOT NULL"
            ))->isNotEmpty();

            if ($foreignExists) {
                Schema::table('member', function (Blueprint $table) {
                    $table->dropForeign(['buku_id']);
                });
            }

            if ($uniqueExists) {
                Schema::table('member', function (Blueprint $table) {
                    $table->dropUnique(['buku_id']);
                });
            }
        }

        Schema::table('member', function (Blueprint $table) {
            $table->unsignedBigInteger('buku_id')->nullable()->change();
        });

        if (DB::connection()->getDriverName() !== 'sqlite') {
            Schema::table('member', function (Blueprint $table) {
                $table->foreign('buku_id')->references('id')->on('buku')->nullOnDelete();
            });
        }

        if (DB::connection()->getDriverName() !== 'sqlite') {
            $kategoriForeignExists = collect(DB::select(
                "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'buku' AND COLUMN_NAME = 'kategori_id' AND REFERENCED_TABLE_NAME IS NOT NULL"
            ))->isNotEmpty();

            if ($kategoriForeignExists) {
                Schema::table('buku', function (Blueprint $table) {
                    $table->dropForeign(['kategori_id']);
                });
            }
        }

        Schema::table('buku', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_id')->nullable()->change();
        });

        if (DB::connection()->getDriverName() !== 'sqlite') {
            Schema::table('buku', function (Blueprint $table) {
                $table->foreign('kategori_id')->references('id')->on('kategori')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'sqlite') {
            Schema::table('member', function (Blueprint $table) {
                $table->dropForeign(['buku_id']);
            });
        }

        Schema::table('member', function (Blueprint $table) {
            $table->unsignedBigInteger('buku_id')->nullable(false)->change();
        });

        if (DB::connection()->getDriverName() !== 'sqlite') {
            $uniqueExists = collect(DB::select("SHOW INDEX FROM member WHERE Key_name = 'member_buku_id_unique'"))->isNotEmpty();
            if (! $uniqueExists) {
                Schema::table('member', function (Blueprint $table) {
                    $table->unique('buku_id');
                });
            }
        }

        if (DB::connection()->getDriverName() !== 'sqlite') {
            Schema::table('buku', function (Blueprint $table) {
                $table->dropForeign(['kategori_id']);
            });
        }

        Schema::table('buku', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_id')->nullable(false)->change();
        });

        if (DB::connection()->getDriverName() !== 'sqlite') {
            Schema::table('buku', function (Blueprint $table) {
                $table->foreign('kategori_id')->references('id')->on('kategori');
            });
        }
    }
};
