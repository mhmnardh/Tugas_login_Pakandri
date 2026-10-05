<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockAndCategoryRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_category_keeps_books(): void
    {
        $kategori = Kategori::create(['nama_kategori' => 'Novel']);
        $buku = Buku::create([
            'kategori_id' => $kategori->id,
            'nama_buku' => 'Dilan 1990',
            'isbn' => '123456',
            'stok' => 2,
        ]);

        $this->delete(route('kategori.destroy', $kategori));

        $this->assertDatabaseHas('buku', [
            'id' => $buku->id,
            'kategori_id' => null,
        ]);
    }

    public function test_member_assignment_reduces_stock_and_blocks_habis_book(): void
    {
        $buku = Buku::create([
            'kategori_id' => Kategori::create(['nama_kategori' => 'Komputer'])->id,
            'nama_buku' => 'Laravel Dasar',
            'isbn' => 'ABC-001',
            'stok' => 2,
        ]);

        $response = $this->post(route('member.store'), [
            'buku_id' => $buku->id,
            'nama_member' => 'Andi',
            'email' => 'andi@example.com',
            'no_telepon' => '08123456789',
            'tanggal_lahir' => '2000-01-01',
        ]);

        $response->assertRedirect(route('member.index'));
        $this->assertSame(1, $buku->fresh()->stok);

        $response2 = $this->post(route('member.store'), [
            'buku_id' => $buku->id,
            'nama_member' => 'Budi',
            'email' => 'budi@example.com',
            'no_telepon' => '08123456788',
            'tanggal_lahir' => '2001-02-02',
        ]);

        $response2->assertRedirect(route('member.index'));
        $this->assertSame(0, $buku->fresh()->stok);

        $response3 = $this->from(route('member.create'))->post(route('member.store'), [
            'buku_id' => $buku->id,
            'nama_member' => 'Citra',
            'email' => 'citra@example.com',
            'no_telepon' => '08123456787',
            'tanggal_lahir' => '2002-03-03',
        ]);

        $response3->assertSessionHasErrors('buku_id');
    }

    public function test_member_deletion_restores_stock(): void
    {
        $buku = Buku::create([
            'kategori_id' => Kategori::create(['nama_kategori' => 'Teknik'])->id,
            'nama_buku' => 'PHP Mastery',
            'isbn' => 'XYZ-111',
            'stok' => 2,
        ]);

        $member = Member::create([
            'buku_id' => $buku->id,
            'nama_member' => 'Sari',
            'email' => 'sari@example.com',
            'no_telepon' => '08123456787',
            'tanggal_lahir' => '1999-03-03',
        ]);

        $this->assertSame(1, $buku->fresh()->stok);

        $this->delete(route('member.destroy', $member));

        $this->assertSame(2, $buku->fresh()->stok);
    }

    public function test_deleting_book_keeps_member_data(): void
    {
        $buku = Buku::create([
            'kategori_id' => Kategori::create(['nama_kategori' => 'Sains'])->id,
            'nama_buku' => 'Fisika Dasar',
            'isbn' => 'S-001',
            'stok' => 3,
        ]);

        $member = Member::create([
            'buku_id' => $buku->id,
            'nama_member' => 'Dewi',
            'email' => 'dewi@example.com',
            'no_telepon' => '08123456786',
            'tanggal_lahir' => '2000-04-04',
        ]);

        $this->delete(route('buku.destroy', $buku));

        $this->assertDatabaseHas('member', ['id' => $member->id, 'email' => 'dewi@example.com']);
    }
}
