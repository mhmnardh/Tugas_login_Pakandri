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
        $memberForeignKeys = collect(Schema::getForeignKeys('member'))
            ->filter(fn(array $foreignKey): bool => $foreignKey['columns'] === ['buku_id']);
        $memberUniqueIndex = collect(Schema::getIndexes('member'))
            ->first(fn(array $index): bool => $index['unique'] && $index['columns'] === ['buku_id']);

        Schema::table('member', function (Blueprint $table) use ($memberForeignKeys, $memberUniqueIndex) {
            foreach ($memberForeignKeys as $foreignKey) {
                $table->dropForeign($foreignKey['name'] ?: ['buku_id']);
            }

            if ($memberUniqueIndex) {
                $table->dropUnique($memberUniqueIndex['name'] ?: ['buku_id']);
            }

            $table->unsignedBigInteger('buku_id')->nullable()->change();
        });

        Schema::table('member', function (Blueprint $table) {
            $table->foreign('buku_id')->references('id')->on('buku')->nullOnDelete();
        });

        $bookForeignKeys = collect(Schema::getForeignKeys('buku'))
            ->filter(fn(array $foreignKey): bool => $foreignKey['columns'] === ['kategori_id']);

        Schema::table('buku', function (Blueprint $table) use ($bookForeignKeys) {
            foreach ($bookForeignKeys as $foreignKey) {
                $table->dropForeign($foreignKey['name'] ?: ['kategori_id']);
            }

            $table->unsignedBigInteger('kategori_id')->nullable()->change();
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->foreign('kategori_id')->references('id')->on('kategori')->nullOnDelete();
        });
    }

    public function down(): void
    {
        $memberForeignKeys = collect(Schema::getForeignKeys('member'))
            ->filter(fn(array $foreignKey): bool => $foreignKey['columns'] === ['buku_id']);

        Schema::table('member', function (Blueprint $table) use ($memberForeignKeys) {
            foreach ($memberForeignKeys as $foreignKey) {
                $table->dropForeign($foreignKey['name'] ?: ['buku_id']);
            }

            $table->unsignedBigInteger('buku_id')->nullable(false)->change();
        });

        Schema::table('member', function (Blueprint $table) {
            $table->foreign('buku_id')->references('id')->on('buku')->cascadeOnDelete();
        });

        $bookForeignKeys = collect(Schema::getForeignKeys('buku'))
            ->filter(fn(array $foreignKey): bool => $foreignKey['columns'] === ['kategori_id']);

        Schema::table('buku', function (Blueprint $table) use ($bookForeignKeys) {
            foreach ($bookForeignKeys as $foreignKey) {
                $table->dropForeign($foreignKey['name'] ?: ['kategori_id']);
            }

            $table->unsignedBigInteger('kategori_id')->nullable()->change();
        });
    }
};
