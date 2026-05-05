# PEMAKAIAN — Pivot Caffe POS

Dokumen ini menjelaskan cara menjalankan, menggunakan, dan memahami sistem POS Pivot Caffe secara lengkap — termasuk setup di Laragon dan XAMPP.

---

## Tech Stack

| Komponen | Detail |
|---|---|
| Framework | Laravel 12.58 |
| Bahasa | PHP 8.3 |
| Database | MySQL 8.0 |
| Template | Blade (tanpa Vue/React/Alpine) |
| Payment | Midtrans Sandbox |
| QR Code | simplesoftwareio/simple-qrcode |
| Session | File-based, expire 60 menit |

---

## Cara Menjalankan di Laragon

Laragon adalah cara termudah karena otomatis mendeteksi folder project.

### 1. Letakkan project
Salin folder project ke:
```
C:\laragon\www\pivot-coffe\
```

### 2. Jalankan Laragon
Buka Laragon → klik **Start All**. Pastikan Apache/Nginx dan MySQL berstatus hijau.

### 3. Install dependencies
Buka terminal di folder project (klik kanan di folder → Terminal):
```bash
composer install
```

### 4. Konfigurasi environment
```bash
cp .env.example .env
php artisan key:generate
```

Isi `.env` bagian database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coffee_pivot
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat database
Buka **phpMyAdmin** di `http://localhost/phpmyadmin`, lalu buat database baru:
```sql
CREATE DATABASE coffee_pivot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Atau lewat HeidiSQL yang sudah include di Laragon.

### 6. Migrasi dan seed data
```bash
php artisan migrate --seed
```

### 7. Buat symlink storage
```bash
php artisan storage:link
```

### 8. Akses aplikasi
Laragon otomatis membuat virtual host. Akses di:
```
http://pivot-coffe.test
```
Jika virtual host belum aktif, gunakan:
```
http://localhost/pivot-coffe/public
```

---

## Cara Menjalankan di XAMPP

### 1. Letakkan project
Salin folder project ke:
```
C:\xampp\htdocs\pivot-coffe\
```

### 2. Jalankan XAMPP
Buka **XAMPP Control Panel** → klik **Start** pada **Apache** dan **MySQL**.

### 3. Install dependencies
Buka Command Prompt, masuk ke folder project:
```bash
cd C:\xampp\htdocs\pivot-coffe
composer install
```

### 4. Konfigurasi environment
```bash
copy .env.example .env
php artisan key:generate
```

Isi `.env` bagian database (XAMPP default tidak pakai password):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coffee_pivot
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat database
Buka **phpMyAdmin** di `http://localhost/phpmyadmin`:
- Klik tab **Database**
- Isi nama: `coffee_pivot`
- Pilih collation: `utf8mb4_unicode_ci`
- Klik **Create**

### 6. Migrasi dan seed data
```bash
php artisan migrate --seed
```

### 7. Buat symlink storage
```bash
php artisan storage:link
```

### 8. Akses aplikasi

**Opsi A — Lewat subfolder (langsung):**
```
http://localhost/pivot-coffe/public
```

**Opsi B — Pakai `php artisan serve` (lebih mudah):**
```bash
php artisan serve
```
Lalu buka:
```
http://127.0.0.1:8000
```

> Catatan: Jika pakai `php artisan serve`, pastikan PHP sudah ada di PATH. Di XAMPP, PHP ada di `C:\xampp\php\`. Tambahkan ke Environment Variables jika belum.

---

## Cara Run dengan `php artisan serve`

Ini cara paling simpel untuk development, bisa dipakai di Laragon maupun XAMPP:

```bash
# Masuk ke folder project
cd C:\laragon\www\pivot-coffe
# atau
cd C:\xampp\htdocs\pivot-coffe

# Jalankan server
php artisan serve
```

Output:
```
INFO  Server running on [http://127.0.0.1:8000].
```

Buka browser ke `http://127.0.0.1:8000`. Server berjalan selama terminal tidak ditutup.

Untuk port berbeda:
```bash
php artisan serve --port=8080
```

---

## Kredensial Default

| Field | Value |
|---|---|
| URL Admin | `/admin/login` |
| Email | `admin@coffee.com` |
| Password | `password` |
| Role | Super Admin |

---

## User Role

Sistem memiliki **dua jenis pengguna** yang sepenuhnya terpisah.

### Admin (login required)

Tabel `admins` — terpisah dari tabel `users` Laravel. Menggunakan custom guard `admin`.

**3 level role:**

| Role | Keterangan |
|---|---|
| `superadmin` | Akses penuh termasuk manajemen user |
| `admin` | Akses operasional harian |
| `kasir` | Akses terbatas |

**Fitur admin:**

| Halaman | URL | Keterangan |
|---|---|---|
| Dashboard | `/admin/dashboard` | Statistik, pemasukan, peringkat menu, auto-refresh 10 detik |
| Monitor Pesanan | `/admin/orders/monitor` | Pesanan aktif real-time, konfirmasi bayar tunai |
| Riwayat Pesanan | `/admin/orders` | Semua pesanan, filter tanggal |
| Detail Pesanan | `/admin/orders/{id}` | Detail + update status |
| Cetak Nota | `/admin/orders/{id}/print` | Print-friendly |
| Menu | `/admin/menus` | CRUD menu + card terlaris per kategori |
| Kategori | `/admin/categories` | CRUD kategori |
| Meja | `/admin/tables` | CRUD meja + status meja real-time + generate & cetak QR |
| Promo | `/admin/promos` | CRUD kode diskon |
| Feedback | `/admin/feedback` | Rating dari pelanggan |
| Waiter Calls | `/admin/waiter-calls` | Panggilan pelayan |
| Manajemen User | `/admin/users` | Tambah/edit/hapus akun admin |

### Customer (tanpa login)

Akses via scan QR code di meja. URL format: `/order/{qr_token}`

| Fitur | Keterangan |
|---|---|
| Lihat menu | Grid menu, filter kategori, search |
| Keranjang | Popup di topbar, update qty real-time |
| Checkout | Nama, catatan, pilih promo, pilih metode bayar |
| Status pesanan | Auto-refresh 10 detik |
| Batalkan pesanan | Hanya saat status `menunggu` |
| Beri rating | Setelah pesanan `selesai` |
| Panggil pelayan | Tombol FAB pojok kanan bawah |

---

## Alur Pembayaran

### Tunai
```
Order dibuat → menunggu + pending
Admin klik "Konfirmasi Bayar" → paid + diproses (otomatis)
Admin klik "Selesai" → selesai
```

### E-Wallet (Manual — Midtrans dinonaktifkan)
```
Order dibuat → menunggu + pending
Customer tunjukkan bukti transfer ke kasir
Admin klik "Konfirmasi Bayar E-Wallet" → paid + diproses (otomatis)
Admin klik "Selesai" → selesai
```

> Midtrans payment gateway di-comment di kode (`CheckoutController.php`).
> Untuk mengaktifkan kembali, uncomment method `processEwallet`.

---

## Status Pesanan & Pembayaran

| `order_status` | Artinya |
|---|---|
| `menunggu` | Order baru, belum ada konfirmasi bayar |
| `diproses` | Sudah bayar, sedang disiapkan |
| `selesai` | Sudah diantar ke meja |
| `dibatalkan` | Dibatalkan oleh customer atau admin |

| `payment_status` | Artinya |
|---|---|
| `pending` | Belum dibayar |
| `paid` | Lunas |
| `failed` | Gagal/expired |

---

## Session

- Driver: `file` — disimpan di `storage/framework/sessions/`
- Lifetime: **60 menit** tidak aktif → expired otomatis
- Setiap HP/browser punya session sendiri — tidak tercampur antar pelanggan
- Cart disimpan dengan key `cart_{table_id}` — per meja, per device

---

## Struktur Database

| Tabel | Isi |
|---|---|
| `admins` | Akun admin + role |
| `cafe_tables` | Data meja + qr_token permanen |
| `categories` | Kategori menu |
| `menus` | Item menu (harga, gambar, ketersediaan) |
| `promos` | Kode diskon (persen/nominal) |
| `orders` | Transaksi pesanan |
| `order_items` | Detail item per pesanan |
| `feedback` | Rating & komentar pelanggan |
| `waiter_calls` | Log panggilan pelayan |

---

## Fitur Real-time

| Halaman | Interval | Tujuan |
|---|---|---|
| `/admin/dashboard` | 10 detik | Stat cards + waiter calls |
| `/admin/orders/monitor` | 10 detik | Pesanan baru masuk |
| `/admin/waiter-calls` | 10 detik | Panggilan baru |
| `/order/status/{id}` | 10 detik | Update status untuk customer |

---

## Midtrans Sandbox

Kredensial yang dipakai (sandbox — tidak ada uang sungguhan):
```
Merchant ID  : G553896145
Client Key   : SB-Mid-client-Xrc-R20NGzfbTdVA
Server Key   : SB-Mid-server-fs2Uwa4E28QfhlJ0HTDvn7iu
```

**Test pembayaran e-wallet:**
1. Pilih E-Wallet saat checkout
2. Redirect ke halaman Midtrans Snap
3. Pilih GoPay / simulator
4. Klik Bayar
5. Webhook otomatis update status ke `paid + diproses`

**Untuk production:**
```env
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_SERVER_KEY=<server_key_production>
MIDTRANS_CLIENT_KEY=<client_key_production>
```

---

## Setup ngrok untuk Midtrans Webhook

Midtrans butuh URL publik untuk mengirim notifikasi pembayaran. Gunakan ngrok sebagai tunnel.

### Langkah-langkah

**1. Jalankan Laravel:**
```bash
php artisan serve
```

**2. Buka terminal baru, jalankan ngrok:**
```bash
ngrok http 8000
```

Output ngrok menampilkan URL seperti:
```
Forwarding  https://1488-xxx.ngrok-free.app -> http://localhost:8000
```

**3. Daftarkan URL webhook di Midtrans:**
- Login ke [https://dashboard.sandbox.midtrans.com](https://dashboard.sandbox.midtrans.com)
- Settings → Configuration
- Isi **Payment Notification URL**:
```
https://1488-xxx.ngrok-free.app/payment/notification
```
- Klik Update

**4. `.env` tidak perlu diubah** — `APP_URL` tetap `http://127.0.0.1:8000`. Sistem otomatis deteksi request dari ngrok lewat header `X-Forwarded-Proto` dan generate URL yang benar.

### Pembagian akses

| Siapa | URL | Keterangan |
|---|---|---|
| Admin | `http://127.0.0.1:8000/admin` | Lewat localhost, http biasa |
| Customer (HP lain) | `https://ngrok-url/order/{token}` | Lewat ngrok tunnel |
| Midtrans webhook | `https://ngrok-url/payment/notification` | Otomatis dari Midtrans |

### Catatan penting
- Setiap kali ngrok dijalankan ulang, URL berubah → harus update lagi di Midtrans Dashboard
- Jangan tutup terminal ngrok selama testing e-wallet
- Admin tetap bisa pakai `http://127.0.0.1:8000` tanpa masalah meski ngrok aktif — tidak ada redirect ke https
- `APP_URL` di `.env` tetap `http://127.0.0.1:8000`, tidak perlu diubah ke URL ngrok

---

## Manajemen User Admin

Buka `/admin/users` untuk tambah, edit, atau hapus akun admin lewat UI.

Atau lewat Tinker:
```bash
php artisan tinker
```
```php
App\Models\Admin::create([
    'name'     => 'Nama Admin',
    'email'    => 'email@domain.com',
    'role'     => 'admin', // superadmin / admin / kasir
    'password' => bcrypt('password123'),
]);
```

---

## Dashboard — Fitur Pemasukan

Dashboard menampilkan ringkasan pemasukan dengan filter:
- **Hari Ini** — transaksi hari ini saja
- **7 Hari** — 7 hari terakhir
- **30 Hari** — default
- **Custom** — pilih rentang tanggal sendiri

Pemasukan hanya dihitung dari order dengan `payment_status = paid`.

---

## Reset Data (Development)

```bash
php artisan migrate:fresh --seed
```

> Menghapus semua data dan mengisi ulang dari awal. Jangan jalankan di production.

---

## Troubleshooting

**Gambar menu tidak muncul**
```bash
php artisan storage:link
```

**Error 500 / halaman blank**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan optimize:clear
```
Cek juga file `.env` sudah ada dan `APP_KEY` sudah terisi.

**Session tidak tersimpan**
Pastikan folder `storage/framework/sessions/` bisa ditulis (permission 775).

**`php artisan` tidak dikenali di XAMPP**
Tambahkan PHP ke PATH Windows:
- Buka System Properties → Environment Variables
- Edit variabel `Path`
- Tambahkan `C:\xampp\php\`
- Restart terminal

**QR Code tidak muncul**
```bash
composer require simplesoftwareio/simple-qrcode
```

**Composer tidak dikenali**
Download installer dari [getcomposer.org](https://getcomposer.org) dan install ulang.

**Port 8000 sudah dipakai**
```bash
php artisan serve --port=8080
```

**Webhook Midtrans tidak diterima saat development**

Jalankan ngrok di terminal terpisah:
```bash
ngrok http 8000
```
Daftarkan URL ngrok di Midtrans Dashboard → Settings → Configuration → Payment Notification URL.
`APP_URL` di `.env` tidak perlu diubah, tetap `http://127.0.0.1:8000`.
