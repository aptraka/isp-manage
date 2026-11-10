# ISP Customer Management

Panduan instalasi dan menjalankan aplikasi ISP Customer Management
berbasis Laravel.

## 1. Cara Instalasi Aplikasi

Pastikan perangkat sudah terpasang:

- PHP 8.5 atau versi yang kompatibel dengan Laravel 13.
- Composer.
- MySQL atau MariaDB.
- XAMPP (opsional, untuk menjalankan PHP dan MySQL secara lokal).

Langkah instalasi:

1.  Download atau clone source code project.

2.  Buka terminal/Command Prompt pada folder project.

3.  Install seluruh dependency Laravel dengan perintah:

    ```bash
    composer install
    ```

4.  Buat file `.env` dari file contoh:

    **Windows:**

    ```bat
    copy .env.example .env
    ```

    **Linux/macOS:**

    ```bash
    cp .env.example .env
    ```

5.  Generate application key:

    ```bash
    php artisan key:generate
    ```

## 2. Konfigurasi Environment

1.  Buat database baru melalui phpMyAdmin atau MySQL. Contoh nama
    database: `isp_manage`.

2.  Buka file `.env` yang berada di folder utama project.

3.  Sesuaikan konfigurasi aplikasi dan database berikut:

    ```env
    APP_NAME="ISP Customer Management"
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://127.0.0.1:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=isp_manage
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  Isi `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai
    konfigurasi MySQL di perangkat Anda.

5.  Simpan file `.env`.

Catatan: `APP_KEY` akan terisi setelah menjalankan perintah
`php artisan key:generate` pada langkah instalasi.

## 3. Cara Menjalankan Migration

Pastikan layanan MySQL sudah berjalan dan database sudah dibuat.
Jalankan perintah berikut dari folder project:

```bash
php artisan migrate
```

Perintah tersebut akan membuat seluruh tabel yang dibutuhkan aplikasi
berdasarkan file migration.

Jika ingin mengulang migration dari awal, gunakan perintah berikut:

```bash
php artisan migrate:fresh
```

**Perhatian:** `migrate:fresh` akan menghapus seluruh tabel beserta data
di dalamnya. Gunakan hanya pada lingkungan development.

## 4. Cara Menjalankan Seeder

Untuk mengisi database dengan akun awal dan data contoh, jalankan:

```bash
php artisan db:seed
```

Untuk menjalankan migration sekaligus seeder dari database kosong,
gunakan:

```bash
php artisan migrate:fresh --seed
```

**Perhatian:** Perintah `migrate:fresh --seed` menghapus seluruh tabel
dan data yang sudah ada, kemudian membuat ulang tabel dan mengisi data
seed.

Akun awal yang dibuat oleh seeder:

Role Email Password

---

Admin `admin@isp.com` `Admin12345!`
Staff `staff@isp.com` `Staff12345!`

Ganti password akun contoh setelah berhasil login jika aplikasi akan
digunakan di luar lingkungan pengembangan.

## 5. Cara Menjalankan Aplikasi

Jalankan server development Laravel:

```bash
php artisan serve
```

Buka aplikasi melalui browser:

```text
http://127.0.0.1:8000
```

Login menggunakan salah satu akun awal yang telah dibuat oleh seeder.

### Menjalankan tanpa Vite

Aplikasi menggunakan Blade dan file CSS/JavaScript yang disimpan
langsung di folder `public`, sehingga tidak perlu menjalankan
`npm install`, `npm run dev`, atau `npm run build`.

Pastikan file aset tersedia:

```text
public/
├── css/
│   └── app.css
└── js/
    └── app.js
```

Pastikan layout Blade memanggil file tersebut menggunakan `asset()`,
misalnya:

```blade
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>
```

Jika aplikasi tidak dapat diakses setelah konfigurasi berubah, bersihkan
cache Laravel:

```bash
php artisan optimize:clear
```
