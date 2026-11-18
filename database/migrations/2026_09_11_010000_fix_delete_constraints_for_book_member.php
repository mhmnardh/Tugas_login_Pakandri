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
            ->where('columns', ['buku_id']);
        $memberIndexes = collect(Schema::getIndexes('member'))
            ->filter(fn(array $index): bool => $index['unique'] && $index['columns'] === ['buku_id']);
        $memberColumn = collect(Schema::getColumns('member'))->firstWhere('name', 'buku_id');
        $memberHasNullDelete = $memberForeignKeys->contains(
            fn(array $foreignKey): bool => strtolower((string) $foreignKey['on_delete']) === 'set null'
        );

        if (! $memberColumn['nullable'] || $memberIndexes->isNotEmpty() || ! $memberHasNullDelete) {
            Schema::table('member', function (Blueprint $table) use ($memberForeignKeys, $memberIndexes): void {
                foreach ($memberForeignKeys as $foreignKey) {
                    $table->dropForeign($foreignKey['name'] ?: ['buku_id']);
                }

                foreach ($memberIndexes as $index) {
                    $table->dropUnique($index['name']);
                }

                $table->unsignedBigInteger('buku_id')->nullable()->change();
                $table->foreign('buku_id')->references('id')->on('buku')->nullOnDelete();
            });
        }

        $bookForeignKeys = collect(Schema::getForeignKeys('buku'))
            ->where('columns', ['kategori_id']);
        $bookColumn = collect(Schema::getColumns('buku'))->firstWhere('name', 'kategori_id');
        $bookHasNullDelete = $bookForeignKeys->contains(
            fn(array $foreignKey): bool => strtolower((string) $foreignKey['on_delete']) === 'set null'
        );

        if (! $bookColumn['nullable'] || ! $bookHasNullDelete) {
            Schema::table('buku', function (Blueprint $table) use ($bookForeignKeys): void {
                foreach ($bookForeignKeys as $foreignKey) {
                    $table->dropForeign($foreignKey['name'] ?: ['kategori_id']);
                }

                $table->unsignedBigInteger('kategori_id')->nullable()->change();
                $table->foreign('kategori_id')->references('id')->on('kategori')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $memberForeignKeys = collect(Schema::getForeignKeys('member'))
            ->where('columns', ['buku_id']);
        $memberIndexes = collect(Schema::getIndexes('member'))
            ->filter(fn(array $index): bool => $index['unique'] && $index['columns'] === ['buku_id']);

        Schema::table('member', function (Blueprint $table) use ($memberForeignKeys, $memberIndexes): void {
            foreach ($memberForeignKeys as $foreignKey) {
                $table->dropForeign($foreignKey['name'] ?: ['buku_id']);
            }

            $table->unsignedBigInteger('buku_id')->nullable(false)->change();

            if ($memberIndexes->isEmpty()) {
                $table->unique('buku_id');
            }

            $table->foreign('buku_id')->references('id')->on('buku')->cascadeOnDelete();
        });

        $bookForeignKeys = collect(Schema::getForeignKeys('buku'))
            ->where('columns', ['kategori_id']);

        Schema::table('buku', function (Blueprint $table) use ($bookForeignKeys): void {
            foreach ($bookForeignKeys as $foreignKey) {
                $table->dropForeign($foreignKey['name'] ?: ['kategori_id']);
            }

            $table->unsignedBigInteger('kategori_id')->nullable(false)->change();
            $table->foreign('kategori_id')->references('id')->on('kategori');
        });
    }
};
