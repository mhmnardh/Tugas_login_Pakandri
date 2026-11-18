---
description: "Gunakan saat membuat atau mengubah UI, warna, CSS, atau Blade di proyek perpustakaan."
---

# Tema Perpustakaan Indonesia

Gunakan bahasa visual landing page Home untuk semua halaman publik dan admin: hijau hutan, permukaan hijau gelap, teks krem, dan aksen emas. Jaga proporsi sekitar 60% latar, 30% permukaan, dan 10% aksen.

```css
:root {
    --primary: #315c48;
    --primary-dark: #102a21;
    --cream: #18251f;
    --gold: #c6a568;
    --text: #e8e6dc;
    --muted: #a6afa7;
    --surface: #20332a;
    --surface-light: #263b2f;
    --border: rgba(255, 255, 255, 0.1);
}
```

- Gunakan emas untuk CTA, link aktif, dan aksen; jangan menjadikan emas sebagai bidang latar besar.
- Jaga teks isi tetap kontras di atas permukaan; hindari opacity rendah untuk informasi penting.
- Hindari hitam murni dan putih murni sebagai latar luas.
- Gunakan Cormorant Garamond untuk judul dan Google Sans untuk isi.
- Definisikan warna di `resources/css/app.css`; hindari hardcode warna di Blade.

# Aturan Desain Perpustakaan Indonesia

Gunakan bahasa visual landing page Home untuk seluruh halaman publik dan admin: hijau hutan, permukaan hijau gelap, teks krem, dan aksen emas.

```css
:root {
    --primary: #315c48;
    --primary-dark: #102a21;
    --cream: #18251f;
    --gold: #c6a568;
    --text: #e8e6dc;
    --muted: #a6afa7;
    --surface: #20332a;
    --surface-light: #263b2f;
    --border: rgba(255, 255, 255, 0.1);
}
```

- Jaga teks isi tetap kontras di atas permukaan; hindari opacity rendah untuk informasi penting.
- Gunakan emas untuk CTA, link aktif, dan aksen; jangan menjadikan emas sebagai bidang latar besar.
- Hindari hitam murni dan putih murni sebagai latar luas.
- Gunakan Cormorant Garamond untuk judul dan Google Sans untuk isi.
- Definisikan warna di `resources/css/app.css`, bukan hardcode di Blade.
