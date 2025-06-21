# 🏍️ Aplikasi Sewa Motor Berbasis Website 🛵

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/Database-MySQL-orange.svg)](https://www.mysql.com/)
[![Bootstrap 5](https://img.shields.io/badge/Frontend-Bootstrap_5-purple.svg)](https://getbootstrap.com/)
[![SweetAlert2](https://img.shields.io/badge/JS-SweetAlert2-brightgreen.svg)](https://sweetalert2.github.io/)

---

## ✨ Deskripsi Proyek

**Aplikasi Sewa Motor Berbasis Website** ini adalah sebuah platform digital komprehensif yang dirancang untuk mempermudah proses peminjaman motor, baik dari sisi pengguna (pelanggan) maupun pengelola (Admin/Staff). Dibangun dengan fokus pada efisiensi, keamanan, dan *user experience*, aplikasi ini memungkinkan manajemen *Work Order* (WO) online yang terstruktur serta menyediakan katalog interaktif untuk calon penyewa.

Proyek ini menjadi bukti implementasi kebutuhan fungsional dan non-fungsional dalam pengembangan *web* yang solid, ideal untuk demonstrasi kompetensi.

---

## 🚀 Fitur-Fitur Unggulan

### A. Area Pengguna Publik (Frontend)

* **Katalog Motor Interaktif**: Jelajahi daftar motor yang tersedia dengan detail gambar, deskripsi, dan harga sewa. Diurutkan otomatis dari harga termurah untuk memudahkan pilihan Anda.

* **Halaman Detail Motor**: Dapatkan informasi mendalam setiap unit motor, lengkap dengan deskripsi detail dan gambar yang jernih.

* **Pemesanan Online Mudah**: Lakukan pemesanan motor pilihan Anda melalui formulir intuitif, cukup dengan mengisi data diri dan tanggal sewa. Konfirmasi pesanan akan segera Anda terima via WhatsApp!

* **Informasi Website Dinamis**: Akses halaman "Tentang Kami", "Kebijakan Privasi", "Kontak Kami", dan info penting lainnya yang kontennya selalu terbarui langsung dari panel admin. Navigasi otomatis menyesuaikan.

* **Antarmuka Bersih & Responsif**: Nikmati pengalaman *browsing* yang mulus di perangkat apa pun, tanpa distraksi link admin.

### B. Area Admin & Staff (Backend - Panel Admin)

* **Sistem Autentikasi Kuat**: Login aman dengan *username* dan *password* yang ter-*hash*. Dukungan peran `admin` dan `staff`.

* **Kontrol Akses Berlapis (RBAC)**:
    * **Admin**: Kendali penuh atas seluruh aspek aplikasi (Katalog, Pesanan, Profil Website, Laporan).
    * **Staff**: Akses terfokus pada Manajemen Katalog dan Pesanan, dengan *interface* yang disesuaikan secara otomatis.

* **Manajemen Katalog Motor Efisien**: Tambah, edit, dan hapus data motor dengan mudah. Input harga otomatis terformat untuk akurasi data.

* **Manajemen Pesanan Komprehensif**: Lacak dan kelola semua pesanan pelanggan, ubah status pesanan (Request, Approved, Rejected, Completed, Cancelled). Sistem cerdas ini bahkan otomatis memperbarui status ketersediaan motor!

* **Kelola Profil Website (Admin Only)**: Perbarui konten statis seperti "Tentang Kami" atau "Kebijakan Privasi" secara dinamis tanpa menyentuh kode.

* **Fitur Pelaporan Powerful (Admin Only)**: Hasilkan laporan daftar pesanan berdasarkan rentang tanggal tertentu, lengkap dengan nomor urut yang rapi untuk pencetakan.

* **Pengalaman Admin yang Modern**: Halaman login admin didesain ulang dengan sentuhan visual yang menarik dan profesional.

---

## 🛠️ Teknologi yang Digunakan

* **Bahasa Pemrograman**: **PHP** (Native), **HTML5**, **CSS3**, **JavaScript**
* **Database**: **MySQL** (dijalankan via MariaDB di XAMPP)
* **Web Server**: **Apache** (dijalankan via XAMPP)
* **Lingkungan Pengembangan**: **XAMPP**
* **Code Editor**: Visual Studio Code (direkomendasikan)
* **Library & Framework**:
    * **Bootstrap 5**: Untuk *responsive design* dan komponen UI.
    * **SweetAlert2**: Untuk *pop-up* konfirmasi yang cantik dan interaktif.
    * **Google Fonts**: Memperkaya tipografi.
    * **PDO (PHP Data Objects)**: Untuk interaksi *database* yang aman dan terstruktur.

---

## 📦 Struktur Proyek

```
sewa_motor_app/
├── public/                     # Direktori utama yang diakses web server (document root)
│   ├── index.php             # Halaman publik: Katalog motor & form pemesanan
│   ├── page.php              # Halaman generik untuk menampilkan konten profil dinamis
│   ├── motor_detail.php      # Halaman detail spesifik untuk setiap motor
│   ├── assets/
│   │   ├── css/style.css     # Kustomisasi CSS untuk tampilan unik
│   │   ├── js/script.js      # Kustomisasi JavaScript untuk interaktivitas
│   │   └── img/              # Lokasi gambar-gambar motor dan aset visual lainnya (login_bg.jpg)
│   └── admin/                  # Area khusus untuk panel administrasi
│       ├── index.php         # Halaman login admin/staff
│       ├── dashboard.php     # Dashboard utama setelah login
│       ├── logout.php        # Skrip untuk mengakhiri sesi pengguna
│       ├── motorcycles/      # Modul manajemen katalog motor
│       │   ├── index.php     # Daftar motor, aksi edit/hapus
│       │   ├── add.php       # Form tambah motor baru
│       │   └── edit.php      # Form edit motor
│       ├── orders/           # Modul manajemen pesanan
│       │   ├── index.php     # Daftar pesanan, aksi ubah status
│       │   └── view.php      # (Opsional) Tampilan detail pesanan
│       ├── profile/          # Modul manajemen profil website
│       │   ├── index.php     # Daftar profil, aksi edit/hapus
│       │   ├── add.php       # Form tambah profil baru
│       │   └── edit.php      # Form edit profil
│       └── reports/          # Modul pelaporan
│           └── index.php     # Filter & tampilan laporan pesanan
├── app/                        # Direktori inti logika aplikasi (tidak diakses langsung oleh publik)
│   ├── config/
│   │   └── database.php      # Konfigurasi koneksi database
│   ├── models/                 # Model: Kelas-kelas yang berinteraksi dengan database (CRUD)
│   │   ├── User.php          # Model untuk tabel 'users'
│   │   ├── Motorcycle.php    # Model untuk tabel 'motorcycles'
│   │   ├── Order.php         # Model untuk tabel 'orders'
│   │   └── WebsiteProfile.php # Model untuk tabel 'website_profile'
│   └── core/                   # Kelas dan fungsi inti/pembantu
│       ├── functions.php     # Kumpulan fungsi helper (misal: redirect, cek login)
│       └── Database.php      # Kelas manajemen koneksi PDO database
```

## ⚙️ Instalasi & Cara Menjalankan Aplikasi

Ikuti langkah-langkah mudah ini untuk menjalankan **Aplikasi Sewa Motor Berbasis Website** di lingkungan pengembangan lokal Anda:

1.  **Prasyarat**:
    * Pastikan Anda telah menginstal **XAMPP** di sistem operasi Anda.
    * Pastikan modul **Apache** dan **MySQL** di XAMPP Control Panel Anda berjalan (**Status: Running**).

2.  **Kloning Repositori**:
    * Buka terminal/CMD Anda, navigasikan ke direktori `htdocs` XAMPP (misal: `C:\xampp\htdocs\`).
    * Kloning repositori GitHub ini ke dalam direktori tersebut:
        ```bash
        git clone [https://github.com/YourGitHubUsername/sewa_motor_app.git](https://github.com/YourGitHubUsername/sewa_motor_app.git)
        ```
        *(Ganti `https://github.com/YourGitHubUsername/sewa_motor_app.git` dengan URL repositori Anda)*

3.  **Setup Database**:
    * Buka peramban web Anda dan akses **phpMyAdmin** (biasanya di `http://localhost/phpmyadmin/`).
    * Buat database baru dengan nama: `sewa_motor_db`
    * Pilih database `sewa_motor_db` yang baru Anda buat.
    * Buka tab "SQL" dan **jalankan seluruh perintah SQL dari file `database.sql`** yang ada di direktori utama proyek Anda (`sewa_motor_app/database.sql`). Ini akan membuat semua tabel dan mengisi data awal.

4.  **Konfigurasi Aplikasi**:
    * Buka file `sewa_motor_app/app/config/database.php`.
    * Pastikan kredensial koneksi database sudah sesuai dengan pengaturan MySQL XAMPP Anda (umumnya `DB_USER`:'root', `DB_PASS`:''):
        ```php
        <?php
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');     // Sesuaikan dengan username MySQL Anda
        define('DB_PASS', '');         // Sesuaikan dengan password MySQL Anda (biasanya kosong untuk XAMPP)
        define('DB_NAME', 'sewa_motor_db');
        ?>
        ```

5.  **Siapkan Gambar Motor**:
    * Pastikan Anda memiliki file gambar untuk motor yang terdaftar di database (misal: `honda_beat.jpg`, `yamaha_nmax.jpg`, dll.) dan juga gambar latar belakang login (`login_bg.jpg`). Letakkan semua gambar ini di folder: `sewa_motor_app/public/assets/img/`.

6.  **Akses Aplikasi**:
    * Buka peramban web pilihan Anda (Chrome, Firefox, Edge, dll.).
    * Akses halaman utama (publik): `http://localhost/sewa_motor_app/public/`
    * Akses panel admin: `http://localhost/sewa_motor_app/public/admin/`

> ✅ Anda siap menguji Aplikasi Sewa Motor Berbasis Website!

---

## 🔑 Kredensial Default (Untuk Pengujian)

* **Admin**:
    * Username: `admin`
    * Password: `admin123`
* **Staff**:
    * Username: `staff1`
    * Password: `staffpass`

---

## 📁 Fitur-Fitur Aplikasi

* **Manajemen Katalog Motor**: Menambah, melihat, mengedit, dan menghapus (Admin saja) data motor.
* **Manajemen Pesanan**: Melacak, mengubah status (Request, Approved, Completed, dll.), dan mengelola pesanan pelanggan.
* **Manajemen Profil Website**: Mengelola konten dinamis seperti "Tentang Kami" atau "Kebijakan Privasi" (Admin saja).
* **Sistem Pelaporan**: Menghasilkan laporan pesanan berdasarkan rentang tanggal tertentu (Admin saja).
* **Kontrol Akses Berbasis Peran (RBAC)**: Membedakan hak akses antara Admin dan Staff.
* **Pemesanan Online**: Form pemesanan yang mudah digunakan dengan konfirmasi instan.
* **Responsif & User-Friendly**: Desain yang menyesuaikan di berbagai perangkat dan interaksi yang intuitif.

---

## 📝 Catatan Penting

* **Encoding File**: Pastikan semua file PHP memiliki encoding UTF-8 tanpa Byte Order Mark (BOM) untuk mencegah masalah output yang tidak disengaja.
* **Keamanan Produksi**: Untuk lingkungan produksi, sangat direkomendasikan untuk mengubah kredensial database default dan mengimplementasikan protokol HTTPS.
* **Tujuan Proyek**: Aplikasi ini dibangun sebagai sarana pembelajaran dan demonstrasi kompetensi dalam pengembangan web.

> Built for learning purposes and personal development. Feel free to fork, star, or contribute! 🌟

---

### File `database.sql` (Contoh isi untuk langkah 3 Instalasi)

Simpan kode SQL ini di dalam file bernama `database.sql` di direktori utama proyek Anda (`sewa_motor_app/database.sql`).

```sql
-- Database: sewa_motor_db

-- 1. Tabel users (untuk admin yang akan login)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Simpan hash password untuk keamanan!
    email VARCHAR(100) UNIQUE,
    role ENUM('admin', 'staff') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabel motorcycles (untuk daftar motor yang disewakan)
CREATE TABLE motorcycles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    rental_price DECIMAL(10, 2) NOT NULL,
    image_path VARCHAR(255),
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 3. Tabel orders (untuk menyimpan detail pesanan dari pelanggan)
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    motorcycle_id INT NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20),
    rental_start_date DATE NOT NULL,
    rental_end_date DATE NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('request', 'approved', 'rejected', 'completed', 'cancelled') DEFAULT 'request',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (motorcycle_id) REFERENCES motorcycles(id) ON DELETE CASCADE
);

-- 4. Tabel website_profile (untuk mengelola konten statis seperti 'Tentang Kami')
CREATE TABLE website_profile (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL UNIQUE,
    content TEXT,
    last_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- INSERT DATA AWAL (Opsional, untuk pengujian)
-- Admin: username='admin', password='admin123' (sudah di-hash)
-- Staff: username='staff1', password='staffpass' (sudah di-hash)
INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$10$t3B8S5c/T7t1b.8.r0oEw.o/s0F2X/s1N5y2x8t5U0V7W9L5Q.s8.', 'admin@sewamotor.com', 'admin'),
('staff1', '$2y$10$t3B8S5c/T7t1b.8.r0oEw.o/s0F2X/s1N5y2x8t5U0V7W9L5Q.s8.', 'staff1@sewamotor.com', 'staff'); -- Contoh hash password 'admin123' atau 'staffpass'

INSERT INTO motorcycles (name, description, rental_price, image_path, is_available) VALUES
('Honda Beat', 'Motor matic irit, sangat cocok untuk mobilitas harian di Depok dan sekitarnya. Ringan dan lincah.', 75000.00, 'assets/img/honda_beat.jpg', TRUE),
('Yamaha NMAX', 'Skuter premium, nyaman untuk perjalanan jarak menengah atau luar kota.', 120000.00, 'assets/img/yamaha_nmax.jpg', TRUE),
('Kawasaki Ninja 250', 'Sport bike performa tinggi, cocok untuk penyuka kecepatan.', 250000.00, 'assets/img/kawasaki_ninja.jpg', FALSE),
('Vespa Sprint', 'Skuter klasik modern dengan gaya ikonik dan kenyamanan berkendara yang menyenangkan. Cocok untuk bergaya di kota.', 150000.00, 'assets/img/vespa_sprint.jpg', TRUE),
('Honda Vario 125', 'Motor matic yang sangat cocok untuk di bawa kemana saja. Ringan, lincah dan gesit.', 80000.00, 'assets/img/honda_vario_125.jpg', TRUE),
('Honda Supra X 125', 'Motor bebek tangguh, irit, dan nyaman untuk mobilitas harian.', 80000.00, 'assets/img/honda_supra_x_125.jpg', TRUE);

INSERT INTO website_profile (title, content) VALUES
('Tentang Kami', 'Sewa Motor Online adalah penyedia jasa sewa motor terpercaya dan terkemuka yang berlokasi di Depok, Jawa Barat. Berangkat dari visi untuk memberikan kemudahan mobilitas kepada masyarakat, kami hadir dengan komitmen kuat untuk menyediakan pengalaman peminjaman motor yang tidak hanya aman dan nyaman, tetapi juga fleksibel dan dengan harga yang sangat terjangkau. Kami memahami kebutuhan Anda yang beragam, baik itu untuk keperluan harian seperti aktivitas perkuliahan atau pekerjaan, perjalanan bisnis singkat, maupun untuk menjelajahi keindahan kota Depok dan sekitarnya saat liburan. Oleh karena itu, kami menyediakan beragam pilihan motor berkualitas terbaik, mulai dari skuter matic yang lincah dan irit bahan bakar hingga motor sport yang bertenaga, semuanya terawat dengan standar tinggi dan siap mengantarkan Anda ke tujuan. Setiap unit motor di Sewa Motor Online melalui proses perawatan rutin dan pemeriksaan menyeluruh oleh teknisi berpengalaman sebelum disewakan kepada pelanggan. Kami memastikan semua aspek keamanan, kebersihan, dan performa motor terjamin, demi kenyamanan dan keselamatan maksimal bagi setiap pelanggan kami. Kami percaya bahwa kepuasan pelanggan adalah prioritas utama, sehingga kami selalu berusaha memberikan pelayanan yang prima, mulai dari proses pemesanan online yang mudah dan cepat hingga dukungan purna sewa yang responsif. Dengan sistem pemesanan online yang intuitif dan dukungan pelanggan yang selalu siap sedia, Sewa Motor Online siap menjadi mitra perjalanan Anda. Kami bangga dapat melayani Anda dan menjadi bagian dari setiap momen perjalanan Anda di jalan, memastikan Anda memiliki pengalaman sewa motor yang menyenangkan dan bebas khawatir. Jadikan setiap perjalanan Anda lebih mudah dan efisien bersama kami.'),
('Kebijakan Privasi', 'Kami di Sewa Motor Online sangat menghargai dan berkomitmen penuh untuk melindungi privasi setiap pengguna website kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengelola, dan melindungi informasi pribadi yang Anda berikan kepada kami saat menggunakan layanan penyewaan motor kami.\n\n**1. Informasi yang Kami Kumpulkan**\nKami mengumpulkan informasi pribadi yang Anda berikan secara sukarela saat Anda menggunakan layanan kami, termasuk namun tidak terbatas pada:\n* **Informasi Kontak:** Nama lengkap, alamat email, nomor telepon, dan alamat fisik (jika diperlukan untuk pengiriman/pengambilan motor).\n* **Informasi Pesanan:** Detail motor yang disewa, tanggal dan durasi sewa, serta total pembayaran.\n* **Informasi Teknis:** Data penggunaan website (seperti IP address, jenis browser, halaman yang dikunjungi) yang dikumpulkan secara otomatis melalui teknologi seperti *cookies* untuk meningkatkan pengalaman pengguna dan menganalisis kinerja website.\n\n**2. Bagaimana Kami Menggunakan Informasi Anda**\nInformasi pribadi Anda kami gunakan untuk tujuan-tujuan berikut:\n* **Pemrosesan Pesanan:** Untuk memproses, mengkonfirmasi, dan mengelola pesanan penyewaan motor Anda.\n* **Komunikasi Layanan:** Untuk menghubungi Anda terkait status pesanan, pertanyaan, atau informasi penting lainnya mengenai layanan kami (termasuk melalui WhatsApp, jika Anda memberikan nomor telepon).\n* **Peningkatan Layanan:** Untuk menganalisis tren penggunaan website dan memahami bagaimana pengguna berinteraksi dengan layanan kami, sehingga kami dapat terus meningkatkan kualitas website dan penawaran kami.\n* **Keamanan:** Untuk mendeteksi dan mencegah aktivitas penipuan atau penyalahgunaan layanan kami.\n\n**3. Perlindungan dan Penyimpanan Data**\nKami menerapkan langkah-langkah keamanan fisik, elektronik, dan manajerial yang wajar untuk melindungi informasi pribadi Anda dari akses tidak sah, penggunaan, pengungkapan, perubahan, atau penghancuran. Informasi Anda disimpan di server yang aman dan hanya dapat diakses oleh personel yang berwenang. Kami menjaga kerahasiaan data Anda sesuai dengan standar perlindungan data yang berlaku.\n\n**4. Pembagian Informasi dengan Pihak Ketiga**\nKami tidak akan menjual, menyewakan, atau memperdagangkan informasi pribadi Anda kepada pihak ketiga tanpa persetujuan eksplisit Anda, kecuali dalam situasi berikut:\n* **Penyedia Layanan:** Kami dapat berbagi informasi dengan penyedia layanan pihak ketiga yang bekerja atas nama kami untuk mendukung operasional bisnis (misalnya, layanan hosting, analisis data). Pihak ketiga ini terikat oleh perjanjian kerahasiaan dan hanya diizinkan menggunakan informasi Anda sesuai instruksi kami.\n* **Kewajiban Hukum:** Jika diwajibkan oleh hukum atau proses hukum yang berlaku, kami dapat mengungkapkan informasi Anda kepada pihak berwenang.\n\n**5. Hak-hak Anda**\nAnda memiliki hak untuk:\n* Mengakses informasi pribadi yang kami miliki tentang Anda.\n* Meminta koreksi atas informasi yang tidak akurat atau tidak lengkap.\n* Meminta penghapusan informasi pribadi Anda dalam kondisi tertentu.\n\nUntuk menjalankan hak-hak ini, silakan hubungi kami melalui informasi kontak yang tersedia di website.\n\n**6. Perubahan pada Kebijakan Privasi Ini**\nKami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Setiap perubahan akan dipublikasikan di halaman ini. Kami mendorong Anda untuk meninjau kebijakan ini secara berkala untuk tetap mendapatkan informasi terbaru tentang bagaimana kami melindungi informasi Anda.\n\nDengan menggunakan website kami, Anda menyetujui pengumpulan dan penggunaan informasi sebagaimana dijelaskan dalam Kebijakan Privasi ini.\n\nTerima kasih atas kepercayaan Anda kepada Sewa Motor Online.'),
   ('Kontak Kami', 'Untuk informasi lebih lanjut, pertanyaan, atau bantuan terkait layanan Sewa Motor Online, jangan ragu untuk menghubungi tim dukungan kami. Kami siap melayani Anda di jam operasional.\n\n**Alamat:** Jl. Raya Margonda No. 100, Depok, Jawa Barat, Indonesia\n**Email:** info@sewamotoronline.com\n**Telepon:** 0812-3456-7890\n\nKami akan berusaha merespons semua pertanyaan Anda sesegera mungkin. Kepuasan Anda adalah prioritas kami.');
   
   ```

   * **Penting**: Pastikan Anda memiliki file gambar yang disebutkan di atas (`honda_beat.jpg`, `yamaha_nmax.jpg`, dll.) di folder `sewa_motor_app/public/assets/img/`.

4. **Konfigurasi Koneksi Database PHP**:

   * Buka file `app/config/database.php`.

   * Pastikan kredensial koneksi database sudah sesuai dengan pengaturan MySQL Anda (biasanya `root` tanpa *password* untuk XAMPP default):

     ```
     <?php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');     // Sesuaikan dengan username MySQL Anda
     define('DB_PASS', '');         // Sesuaikan dengan password MySQL Anda (biasanya kosong untuk XAMPP)
     define('DB_NAME', 'sewa_motor_db');
     ?>
     
     ```

## 👤 Author

**Anugerah Bakti Prasisto**  
<h3 align="left">Connect with me:</h3>
<p align="left">
<a href="https://twitter.com/zonehell1" target="blank"><img align="center" src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/twitter.svg" alt="zonehell1" height="30" width="40" /></a>
<a href="https://www.linkedin.com/in/anugerah-bakti-prasisto-04422122b/" target="blank"><img align="center" src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/linked-in-alt.svg" alt="anugerah bakti prasisto" height="30" width="40" /></a>
<a href="https://www.facebook.com/profile.php?id=100006615318141&locale=id_ID" target="blank"><img align="center" src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/facebook.svg" alt="anugrah bakti" height="30" width="40" /></a>
<a href="https://www.instagram.com/bakti_011/" target="blank"><img align="center" src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/instagram.svg" alt="baktiprasisto" height="30" width="40" /></a>
<a href="https://www.youtube.com/@baktiprasisto" target="blank"><img align="center" src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/youtube.svg" alt="4ia16_anugerah bakti prasisto" height="30" width="40" /></a>
</p>


---
