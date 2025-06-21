-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2025 at 03:48 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewa_motor_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `motorcycles`
--

CREATE TABLE `motorcycles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `rental_price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motorcycles`
--

INSERT INTO `motorcycles` (`id`, `name`, `description`, `rental_price`, `image_path`, `is_available`, `created_at`, `updated_at`) VALUES
(2, 'Yamaha NMAX', 'Yamaha NMAX 155 adalah motor matic premium dengan performa bertenaga dan desain elegan yang cocok untuk perjalanan jarak jauh maupun harian. Dilengkapi dengan fitur modern seperti Smart Key System, ABS (Anti-lock Braking System), dan panel digital, motor ini memberikan kenyamanan dan keamanan maksimal saat berkendara. Posisi duduk yang santai serta bagasi luas membuatnya sangat ideal untuk berdua ataupun solo trip.', 120000.00, 'assets/img/68498f85a044c_nmax-2024-696x464.jpg', 1, '2025-06-11 09:38:32', '2025-06-13 06:20:42'),
(3, 'Kawasaki Ninja 250', 'Kawasaki Ninja 250 adalah motor sport legendaris dengan desain agresif dan performa tinggi. Ditenagai mesin 250cc 2-silinder yang responsif, motor ini cocok untuk kamu yang suka kecepatan dan ingin tampil sporty di jalan. Dilengkapi dengan panel digital, sistem pendingin cair, dan riding position yang ergonomis, Ninja 250 menawarkan pengalaman berkendara yang bertenaga namun tetap nyaman.', 200000.00, 'assets/img/68498fb91455e_3501826023.jpeg', 0, '2025-06-11 09:38:32', '2025-06-13 06:24:45'),
(4, 'Vespa Sprint', 'Vespa Sprint adalah skuter bergaya klasik modern yang stylish dan ikonik. Dilengkapi dengan mesin 150cc i-Get yang responsif dan sistem pengereman ABS, Vespa Sprint cocok untuk kamu yang ingin tampil beda dan berkendara dengan nyaman. Bodinya ringan namun kokoh, cocok untuk city ride maupun jalan-jalan santai. Vespa ini bukan cuma kendaraan—tapi juga gaya hidup.', 150000.00, 'assets/img/68499f937c4ff_piaggio-vespa-sprint-150-s-edition-perfect-condition-2022-murmerr-nihh-PLNIU4QN.jpg', 1, '2025-06-11 09:38:32', '2025-06-13 06:22:43'),
(11, 'Honda Vario 125', 'Honda Vario 125 hadir dengan desain sporty dan elegan, cocok untuk kebutuhan harian maupun perjalanan wisata. Dilengkapi dengan fitur-fitur modern seperti lampu LED, panel digital, dan sistem ISS (Idling Stop System) untuk efisiensi bahan bakar. Motor ini juga memiliki bagasi luas yang muat helm dan barang bawaan, menjadikannya pilihan ideal untuk kenyamanan dan kepraktisan selama perjalanan.', 100000.00, 'assets/img/684bc1b043359_6278f1d2e8646.jpg', 1, '2025-06-13 06:14:08', '2025-06-14 00:30:11'),
(12, 'Supra X 125', 'Honda Supra X 125 dikenal sebagai motor bebek tangguh, irit, dan nyaman untuk berbagai kebutuhan. Cocok untuk pemakaian harian, perjalanan antar kota, maupun membawa barang bawaan. Dilengkapi dengan mesin 125cc yang responsif, serta bagasi praktis untuk menyimpan perlengkapan pribadi. Pilihan tepat bagi Anda yang mencari motor handal dan efisien.', 80000.00, 'assets/img/684bc276cd349_jual_honda_supra_x_125_tahun_2_1704630019_ddbea27c_progressive.jpg', 0, '2025-06-13 06:17:26', '2025-06-13 07:02:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `motorcycle_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `rental_start_date` date NOT NULL,
  `rental_end_date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('request','approved','rejected','completed','cancelled') DEFAULT 'request',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `motorcycle_id`, `customer_name`, `customer_email`, `customer_phone`, `rental_start_date`, `rental_end_date`, `total_price`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(2, 4, 'Ridho Wijaya', 'Ridho@gmail.com', '08186552489', '2025-06-14', '2025-06-14', 150000.00, 'completed', NULL, '2025-06-13 02:29:59', '2025-06-13 03:28:10'),
(3, 12, 'Daffa Alde', 'Daffa@gmail.com', '08715992199', '2025-06-16', '2025-06-20', 400000.00, 'approved', NULL, '2025-06-13 07:00:19', '2025-06-13 07:02:03'),
(4, 11, 'Juan', 'juan@gmail.com', '08817288428', '2025-06-17', '2025-06-19', 300000.00, 'completed', NULL, '2025-06-14 00:29:33', '2025-06-14 00:30:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','staff') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$TTEX.3T77gvQcRnfp0CsYedOMRdDKHuxNgOemdlpZFPCBsdG2E6CS', 'admin@sewamotor.com', 'admin', '2025-06-11 09:38:32'),
(2, 'bakti', '$2y$10$PaVFyNvcSWgex0ZJcYpPeO5uMiKd8vVMhmh6XSpXAsezNy6m4ZIA6', 'bakti@gmail.com', 'staff', '2025-06-12 05:28:45'),
(3, 'staff', '$2y$10$iDpuddwJfRHSO6SkqyKPiuIZY.kYFAhCOJ8KZqlq2sTSpC1gIeKs2', 'staff@gmail.com', 'staff', '2025-06-13 02:24:01');

-- --------------------------------------------------------

--
-- Table structure for table `website_profile`
--

CREATE TABLE `website_profile` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text DEFAULT NULL,
  `last_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_profile`
--

INSERT INTO `website_profile` (`id`, `title`, `content`, `last_updated_at`) VALUES
(1, 'Tentang Kami', 'Sewa Motor Online adalah penyedia jasa sewa motor terpercaya dan terkemuka yang berlokasi di Depok, Jawa Barat. Berangkat dari visi untuk memberikan kemudahan mobilitas kepada masyarakat, kami hadir dengan komitmen kuat untuk menyediakan pengalaman peminjaman motor yang tidak hanya aman dan nyaman, tetapi juga fleksibel dan dengan harga yang sangat terjangkau.\r\n\r\nKami memahami kebutuhan Anda yang beragam, baik itu untuk keperluan harian seperti aktivitas perkuliahan atau pekerjaan, perjalanan bisnis singkat, maupun untuk menjelajahi keindahan kota Bandung dan sekitarnya saat liburan. Oleh karena itu, kami menyediakan beragam pilihan motor berkualitas terbaik, mulai dari skuter matic yang lincah dan irit bahan bakar hingga motor sport yang bertenaga, semuanya terawat dengan standar tinggi dan siap mengantarkan Anda ke tujuan.\r\n\r\nSetiap unit motor di Sewa Motor Online melalui proses perawatan rutin dan pemeriksaan menyeluruh oleh teknisi berpengalaman sebelum disewakan kepada pelanggan. Kami memastikan semua aspek keamanan, kebersihan, dan performa motor terjamin, demi kenyamanan dan keselamatan maksimal bagi setiap pelanggan kami. Kami percaya bahwa kepuasan pelanggan adalah prioritas utama, sehingga kami selalu berusaha memberikan pelayanan yang prima, mulai dari proses pemesanan online yang mudah dan cepat hingga dukungan purna sewa yang responsif.\r\n\r\nDengan sistem pemesanan online yang intuitif dan dukungan pelanggan yang selalu siap sedia, Sewa Motor Online siap menjadi mitra perjalanan Anda. Kami bangga dapat melayani Anda dan menjadi bagian dari setiap momen perjalanan Anda di jalan, memastikan Anda memiliki pengalaman sewa motor yang menyenangkan dan bebas khawatir. Jadikan setiap perjalanan Anda lebih mudah dan efisien bersama kami.\r\nUntuk informasi lebih lanjut, pertanyaan, atau bantuan, jangan ragu untuk menghubungi kami melalui: \r\n\r\nEmail: sewamotoronline@gmail.com\r\nTelepon: 0812-3456-7890\r\nAlamat: Stasiun Bandung, Jl. Kebon Kawung, Pasir Kaliki, Kec. Cicendo, Kota Bandung, Jawa Barat 40171', '2025-06-14 00:23:35'),
(2, 'Kebijakan Privasi', 'Kami di Sewa Motor Online sangat menghargai dan berkomitmen penuh untuk melindungi privasi setiap pengguna website kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengelola, dan melindungi informasi pribadi yang Anda berikan kepada kami saat menggunakan layanan penyewaan motor kami.\r\n\r\n1. Informasi yang Kami Kumpulkan\r\nKami mengumpulkan informasi pribadi yang Anda berikan secara sukarela saat Anda menggunakan layanan kami, termasuk namun tidak terbatas pada:\r\n\r\nInformasi Kontak: Nama lengkap, alamat email, nomor telepon, dan alamat fisik (jika diperlukan untuk pengiriman/pengambilan motor).\r\n\r\nInformasi Pesanan: Detail motor yang disewa, tanggal dan durasi sewa, serta total pembayaran.\r\n\r\nInformasi Teknis: Data penggunaan website (seperti IP address, jenis browser, halaman yang dikunjungi) yang dikumpulkan secara otomatis melalui teknologi seperti cookies untuk meningkatkan pengalaman pengguna dan menganalisis kinerja website.\r\n\r\n2. Bagaimana Kami Menggunakan Informasi Anda\r\nInformasi pribadi Anda kami gunakan untuk tujuan-tujuan berikut:\r\n\r\nPemrosesan Pesanan: Untuk memproses, mengkonfirmasi, dan mengelola pesanan penyewaan motor Anda.\r\n\r\nKomunikasi Layanan: Untuk menghubungi Anda terkait status pesanan, pertanyaan, atau informasi penting lainnya mengenai layanan kami (termasuk melalui WhatsApp, jika Anda memberikan nomor telepon).\r\n\r\nPeningkatan Layanan: Untuk menganalisis tren penggunaan website dan memahami bagaimana pengguna berinteraksi dengan layanan kami, sehingga kami dapat terus meningkatkan kualitas website dan penawaran kami.\r\n\r\nKeamanan: Untuk mendeteksi dan mencegah aktivitas penipuan atau penyalahgunaan layanan kami.\r\n\r\n3. Perlindungan dan Penyimpanan Data\r\nKami menerapkan langkah-langkah keamanan fisik, elektronik, dan manajerial yang wajar untuk melindungi informasi pribadi Anda dari akses tidak sah, penggunaan, pengungkapan, perubahan, atau penghancuran. Informasi Anda disimpan di server yang aman dan hanya dapat diakses oleh personel yang berwenang. Kami menjaga kerahasiaan data Anda sesuai dengan standar perlindungan data yang berlaku.\r\n\r\n4. Pembagian Informasi dengan Pihak Ketiga\r\nKami tidak akan menjual, menyewakan, atau memperdagangkan informasi pribadi Anda kepada pihak ketiga tanpa persetujuan eksplisit Anda, kecuali dalam situasi berikut:\r\n\r\nPenyedia Layanan: Kami dapat berbagi informasi dengan penyedia layanan pihak ketiga yang bekerja atas nama kami untuk mendukung operasional bisnis (misalnya, layanan hosting, analisis data). Pihak ketiga ini terikat oleh perjanjian kerahasiaan dan hanya diizinkan menggunakan informasi Anda sesuai instruksi kami.\r\n\r\nKewajiban Hukum: Jika diwajibkan oleh hukum atau proses hukum yang berlaku, kami dapat mengungkapkan informasi Anda kepada pihak berwenang.\r\n\r\n5. Hak-hak Anda\r\nAnda memiliki hak untuk:\r\n\r\nMengakses informasi pribadi yang kami miliki tentang Anda.\r\n\r\nMeminta koreksi atas informasi yang tidak akurat atau tidak lengkap.\r\n\r\nMeminta penghapusan informasi pribadi Anda dalam kondisi tertentu.\r\n\r\nUntuk menjalankan hak-hak ini, silakan hubungi kami melalui informasi kontak yang tersedia di website.\r\n\r\n6. Perubahan pada Kebijakan Privasi Ini\r\nKami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Setiap perubahan akan dipublikasikan di halaman ini. Kami mendorong Anda untuk meninjau kebijakan ini secara berkala untuk tetap mendapatkan informasi terbaru tentang bagaimana kami melindungi informasi Anda.\r\n\r\nDengan menggunakan website kami, Anda menyetujui pengumpulan dan penggunaan informasi sebagaimana dijelaskan dalam Kebijakan Privasi ini.\r\n\r\nTerima kasih atas kepercayaan Anda kepada Sewa Motor Online.', '2025-06-14 00:24:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `motorcycles`
--
ALTER TABLE `motorcycles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motorcycle_id` (`motorcycle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `website_profile`
--
ALTER TABLE `website_profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `motorcycles`
--
ALTER TABLE `motorcycles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `website_profile`
--
ALTER TABLE `website_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`motorcycle_id`) REFERENCES `motorcycles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
