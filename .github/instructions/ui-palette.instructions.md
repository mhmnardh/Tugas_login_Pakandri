# Aturan Desain dan Palet Warna

Gunakan tema **Soft Slate**: gelap menengah, bukan hitam pekat. Pertahankan proporsi 60-30-10 untuk latar, panel, dan aksen.

```css
:root {
    --bg-primary: #343b43;
    --bg-secondary: #414a54;
    --text-primary: #f1f3f5;
    --text-secondary: #c2cad1;
    --text-secondary-strong: #d5dce3;
    --border-color: #56616d;
    --accent-primary: #89aec9;
    --accent-hover: #a3c1d5;
    --accent-hover-strong: #b8d0e0;
    --accent-foreground: #27333d;
    --status-success: #9bbca3;
    --status-danger: #d68c80;
}
```

- Gunakan `--text-secondary-strong` untuk teks kecil di panel.
- Gunakan `--accent-foreground` pada tombol berwarna aksen.
- Jaga rasio kontras teks normal minimal 4.5:1 dan hindari opacity rendah untuk isi teks.
- Jangan gunakan hitam murni atau putih murni sebagai latar luas.
- Simpan warna pada CSS variables di `resources/css/app.css`; hindari warna hardcode di Blade.

# Aturan Font Teks

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap');
</style>
