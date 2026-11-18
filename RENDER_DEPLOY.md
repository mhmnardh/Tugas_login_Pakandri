# Deploy ke Render

Panduan ini untuk Render menggunakan Docker dan PostgreSQL.

## 1. Push repository

Pastikan file berikut ikut masuk ke GitHub:

- `Dockerfile`
- `.dockerignore`
- `render.yaml`
- `composer.json` dan `composer.lock`
- `package.json`
- `resources/`, `public/`, `app/`, `database/`, `config/`

Jangan commit `.env`, `vendor/`, `node_modules/`, `public/build/`, atau `public/storage`.

## 2. Buat Blueprint

Di dashboard Render:

1. Pilih **New > Blueprint**.
2. Pilih repository GitHub ini.
3. Render membaca `render.yaml` dan menyiapkan PostgreSQL serta Web Service Docker.
4. Isi nilai `APP_URL` setelah URL Render tersedia.
5. Isi `ADMIN_EMAIL` dan `ADMIN_PASSWORD` untuk akun administrator pertama.

Dockerfile menjalankan Vite saat build dan melayani Laravel lewat Apache pada port dari environment `PORT`.

## 3. Environment variables

Variabel utama sudah dibuat dari `render.yaml`:

- `APP_KEY`: dibuat otomatis oleh Render.
- `DB_URL`: diambil otomatis dari database PostgreSQL.
- `DB_CONNECTION=pgsql`.
- `SESSION_DRIVER=database`.
- `CACHE_STORE=database`.
- `QUEUE_CONNECTION=database`.
- `LOG_CHANNEL=stderr`.
- `FILESYSTEM_DISK=public`.
- `ADMIN_EMAIL` dan `ADMIN_PASSWORD`: wajib diisi sebelum menjalankan seeder.

Set `APP_URL` ke URL publik, misalnya:

```text
https://perpus-muhaimin.onrender.com
```

## 4. Migrasi

`render.yaml` menjalankan migration otomatis lewat Pre-Deploy Command:

```bash
php artisan migrate --force
```

Untuk membuat akun admin pertama, buka Shell pada Web Service Render lalu jalankan:

```bash
php artisan db:seed --force
```

Seeder tidak membutuhkan kredensial bawaan saat `APP_ENV=production`; akun dibuat dari `ADMIN_EMAIL` dan `ADMIN_PASSWORD`.

## 5. Penyimpanan upload

Blueprint memasang persistent disk pada:

```text
/var/www/html/storage/app/public
```

Persistent disk menjaga foto buku dan member tetap ada saat deploy atau restart. Jangan hapus atau ganti mount path karena controller menyimpan file ke disk `public`.

## 6. Periksa deployment

Setelah deploy:

1. Buka `/up` untuk health check.
2. Buka `/login`.
3. Login dengan `ADMIN_EMAIL` dan `ADMIN_PASSWORD`.
4. Upload foto buku dan member.
5. Pastikan URL foto dimulai dengan `/storage/` dan tampil kembali setelah redeploy.

Untuk reset image atau rebuild manual, tekan **Manual Deploy > Clear build cache & deploy** pada Render.
