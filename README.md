# Coffee Pivot — POS Web Application

Aplikasi Point of Sale berbasis web untuk kafe, dibangun dengan Laravel 12, Blade, dan MySQL.

## Fitur Utama

- **Pengunjung (via QR Code)**: Lihat menu, tambah ke keranjang, checkout, bayar tunai atau e-wallet (Midtrans), lacak status pesanan, beri rating, panggil pelayan
- **Admin**: Dashboard real-time, monitor pesanan, kelola menu/kategori/meja/promo, riwayat pesanan, cetak nota, kelola feedback dan waiter calls

## Tech Stack

- Laravel 12
- Blade Templates
- MySQL
- Midtrans Sandbox (e-wallet payment)
- simplesoftwareio/simple-qrcode

## Setup

### 1. Install dependencies

```bash
composer install
```

### 2. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dan sesuaikan:
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coffee_pivot
DB_USERNAME=root
DB_PASSWORD=

MIDTRANS_SERVER_KEY=SB-Mid-server-fs2Uwa4E28QfhlJ0HTDvn7iu
MIDTRANS_CLIENT_KEY=SB-Mid-client-Xrc-R20NGzfbTdVA
MIDTRANS_MERCHANT_ID=G553896145
```

### 3. Buat database

```sql
CREATE DATABASE coffee_pivot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Migrasi dan seed data

```bash
php artisan migrate --seed
```

### 5. Storage link

```bash
php artisan storage:link
```

### 6. Jalankan server

```bash
php artisan serve
```

## Akses

| URL | Keterangan |
|-----|-----------|
| `http://localhost:8000/admin/login` | Login admin |
| `http://localhost:8000/admin/tables` | Lihat QR code meja |
| `http://localhost:8000/order/{qr_token}` | Halaman menu pelanggan |

## Kredensial Admin

| Field | Value |
|-------|-------|
| Email | `admin@coffee.com` |
| Password | `password` |

## Data Seeder

- **5 Kategori**: Kopi, Non-Kopi, Makanan, Snack, Minuman Dingin
- **15 Menu** tersebar di semua kategori
- **10 Meja** (nomor 1–10) dengan QR token unik
- **2 Promo**: `HEMAT10` (10% off), `GRATIS5K` (Rp 5.000 off)

## Alur Penggunaan

1. Admin buka `/admin/tables` → klik "QR Code" pada meja → cetak QR
2. Pelanggan scan QR → diarahkan ke `/order/{qr_token}`
3. Pelanggan pilih menu, atur jumlah, tambah ke keranjang
4. Checkout: isi nama, pilih metode bayar (Tunai/E-Wallet), opsional kode promo
5. Jika E-Wallet → redirect ke Midtrans Snap
6. Jika Tunai → pesanan dibuat, bayar ke kasir
7. Admin monitor di `/admin/orders/monitor` (auto-refresh 10 detik)
8. Admin update status: Menunggu → Diproses → Selesai
9. Setelah selesai, pelanggan bisa beri rating di halaman status

## Midtrans Webhook

Untuk testing lokal, gunakan ngrok atau expose URL publik:
```
POST /payment/notification
```
Daftarkan URL ini di dashboard Midtrans Sandbox sebagai notification URL.

## Struktur Folder Views

```
resources/views/
├── layouts/
│   ├── admin.blade.php
│   └── customer.blade.php
├── admin/
│   ├── auth/ (login, forgot-password, reset-password)
│   ├── dashboard.blade.php
│   ├── orders/ (index, monitor, show, print)
│   ├── menus/ (index, create, edit)
│   ├── categories/ (index, create, edit)
│   ├── tables/ (index, create, edit, qr)
│   ├── promos/ (index, create, edit)
│   ├── feedback/ (index)
│   └── waiter-calls/ (index)
└── customer/
    ├── menu.blade.php
    ├── menu-detail.blade.php
    ├── checkout.blade.php
    ├── status.blade.php
    └── feedback.blade.php
```
