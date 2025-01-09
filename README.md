# 🛵 RosantiBike Motorent Web App

RosantiBike Motorent adalah aplikasi web berbasis Laravel yang dirancang untuk menyewakan sepeda motor secara efisien. Proyek ini dirancang untuk membantu pelanggan dan penyedia rental motor mengelola pemesanan dengan mudah.

---

## 📋 Persyaratan
Sebelum memulai, pastikan Anda telah menginstal:

- [PHP](https://www.php.net/downloads) (versi 7.4 atau lebih baru)
- [Composer](https://getcomposer.org/)
- [Laravel](https://laravel.com/docs/installation) (versi terbaru disarankan)
- [Node.js](https://nodejs.org/) dan npm/yarn
- Server database seperti MySQL

---

## 🚀 Langkah Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi web:

1. Clone repository ini:
   ```bash
   git clone https://github.com/reysilvaa/rosantibike-motorent.git
   ```

2. Masuk ke folder proyek:
   ```bash
   cd rosantibike-motorent
   ```

3. Install dependensi PHP menggunakan Composer:
   ```bash
   composer install
   ```

4. Salin file konfigurasi `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```

5. Atur file `.env` dengan konfigurasi database Anda.

6. Generate JWT secret key:
   ```bash
   php artisan jwt:secret
   ```

7. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```

8. Buat symbolic link untuk storage:
   ```bash
   php artisan storage:link
   ```

9. Install dependensi front-end:
   ```bash
   npm install
   ```

10. Compile aset front-end:
   ```bash
   npm run dev
   ```

11. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

   Aplikasi akan tersedia di `http://localhost:8000`.

---

## 📂 Struktur Proyek

```
rosantibike-motorent/
├── app/                 # Logika backend Laravel
├── public/              # Aset publik
├── resources/           # File front-end (Blade, JS, CSS)
├── routes/              # File rute aplikasi
├── database/            # Migrasi dan seeder database
├── .env                 # Konfigurasi lingkungan
├── composer.json        # Konfigurasi dependensi PHP
└── README.md            # Dokumentasi proyek
```

---

## 🛠️ Teknologi yang Digunakan

- **Laravel**: Framework PHP untuk backend
- **JWT (JSON Web Token)**: Untuk autentikasi API
- **Blade**: Template engine untuk tampilan
- **Bootstrap**: Framework CSS untuk desain responsif
- **MySQL**: Database relasional

---

## 💡 Fitur Utama

- Pemesanan motor secara online
- Manajemen data pelanggan dan kendaraan
- Sistem notifikasi untuk admin melalui email (gmail)
- Laporan transaksi
- Automatisasi pengecekan booking (tidak dapat membooking motor yang sama pada tanggal yang sudah terbooking)
- Autentikasi API dengan JWT

---

## 📸 Tangkapan Layar

**Beranda:**
_(Tambahkan tangkapan layar aplikasi di sini)_

---

## 🤝 Kontribusi
Kami menyambut kontribusi untuk meningkatkan aplikasi ini! Berikut langkah-langkah untuk berkontribusi:

1. Fork repository ini.
2. Buat branch untuk fitur baru:
   ```bash
   git checkout -b fitur-baru
   ```
3. Commit perubahan Anda:
   ```bash
   git commit -m "Menambahkan fitur baru"
   ```
4. Push ke branch Anda:
   ```bash
   git push origin fitur-baru
   ```
5. Ajukan pull request.

---

## 📧 Kontak

Jika Anda memiliki pertanyaan atau saran, silakan hubungi:
- **Nama**: Reynald Silva
- **Email**: reynaldsilva123@gmail.com
- **GitHub**: [reysilvaa](https://github.com/reysilvaa)

---

## 📜 Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

### Selamat Menyewa Motor 🚀!

