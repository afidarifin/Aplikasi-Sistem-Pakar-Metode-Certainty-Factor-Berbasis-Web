-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 25 Okt 2023 pada 17.05
-- Versi server: 5.7.33
-- Versi PHP: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_phising`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gangguan`
--

CREATE TABLE `gangguan` (
  `id_gangguan` int(10) NOT NULL,
  `kode_gangguan` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `nama_gangguan` text CHARACTER SET utf8mb4 NOT NULL,
  `saran_gangguan` text CHARACTER SET utf8mb4 NOT NULL,
  `detail` text CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gangguan`
--

INSERT INTO `gangguan` (`id_gangguan`, `kode_gangguan`, `nama_gangguan`, `saran_gangguan`, `detail`) VALUES
(1, 'G001', 'Situs memiliki halaman login palsu yang sangat menyerupai halaman login  yang asli.', 'Memeriksa detail  susunan form login. Halaman fake login biasanya tidak ada validasi dan terkirim begitu saja.', 'Memeriksa detail  susunan form login. Halaman fake login biasanya tidak ada validasi dan terkirim begitu saja.'),
(2, 'G002', 'Situs memiliki banyak subdomain dan ketika diakses di browser otomatis terpotong pada address bar sehingga terkesan sebagai situs asli.', 'Perhatikan kembali URL / domain dari subdomain atau dapat mengecek ke situs resmi seperti PhishTank.', 'Perhatikan kembali URL / domain dari subdomain atau dapat mengecek ke situs resmi seperti PhishTank.'),
(3, 'G003', 'Situs memiliki domain  serupa dengan situs yang asli dengan cara membuat domain sedikit typo.', 'Perhatikan kembali keaslian URL / domain dari situs sebelum dikunjungi atau dapat mengecek ke situs resmi seperti PhishTank.', 'Perhatikan kembali keaslian URL / domain dari situs sebelum dikunjungi atau dapat mengecek ke situs resmi seperti PhishTank.'),
(4, 'G004', 'Situs tidak memiliki ikon gembok berwarna hijau pada address bar browser  yang berisi informasi sertifikat (SSL) situs.', 'Pastikan memeriksa detail validitas sertifikat SSL (Secure Socket Layer) menggunakan ikon gembok pada browser.', 'Pastikan memeriksa detail validitas sertifikat SSL (Secure Socket Layer) menggunakan ikon gembok pada browser.'),
(5, 'G005', 'Situs memiliki domain berisi karakter khusus seperti menggunakan karakter Cyrillic.', 'Memeriksa kembali nama domain dengan situs aslinya misal situs BCA yang asli adalah https://www.bca.co.id bukan https://www.Ьca.co.id', 'Memeriksa kembali nama domain dengan situs aslinya misal situs BCA yang asli adalah https://www.bca.co.id bukan https://www.Ьca.co.id'),
(6, 'G006', 'Situs memiliki nama domain berupa alamat IP yang aneh.', 'Pastikan untuk selalu mengunjungi situs dengan alamat nama domain yang yang umum seperti https://www.google.com dan sebagainya.', 'Pastikan untuk selalu mengunjungi situs dengan alamat nama domain yang yang umum seperti https://www.google.com dan sebagainya.'),
(7, 'G007', 'Situs berisi informasi bersifat mengancam yang mana jika pengguna tidak segera bertindak, maka diancam akan diambil tindakan hukum atau suspensi akun.', 'Pastikan untuk tidak mengklik situs yang berisi pesan atau informasi yang bersifat mengancam seperti “Akun Anda telah disuspen, klik di sini untuk memulihkan akun.”', 'Pastikan untuk tidak mengklik situs yang berisi pesan atau informasi yang bersifat mengancam seperti “Akun Anda telah disuspen, klik di sini untuk memulihkan akun.”'),
(8, 'G008', 'Situs tidak memiliki informasi seperti pemilik domain dan sebagainya yang terdaftar pada layanan WHOIS.', 'Sebelum mengunjungi situs, pastikan terlebih dahulu untuk mengecek identitas pemilik domain dengan menggunakan layanan WHOIS.', 'Sebelum mengunjungi situs, pastikan terlebih dahulu untuk mengecek identitas pemilik domain dengan menggunakan layanan WHOIS.'),
(9, 'G009', 'Situs meminta untuk memasukkan informasi pribadi yang sensitif seperti Username, Kata Sandi, PIN ATM, OTP, Nomor Kartu Kredit / Debit, dan Kode CVV.', 'Situs yang resmi tidak akan meminta informasi pribadi dengan sembarangan. Pastikan hanya mengisi informasi pribadi pada situs yang asli.', 'Situs yang resmi tidak akan meminta informasi pribadi dengan sembarangan. Pastikan hanya mengisi informasi pribadi pada situs yang asli.'),
(10, 'G010', 'Situs memiliki banyak link mati atau tidak dapat diakses oleh pengguna dan justru mengarah ke halaman yang tidak jelas.', 'Pastikan untuk memeriksa link pada situs yang sedang diakses apakah sudah sesuai dengan halaman yang dituju atau tidak.', 'Pastikan untuk memeriksa link pada situs yang sedang diakses apakah sudah sesuai dengan halaman yang dituju atau tidak.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int(10) NOT NULL,
  `kode_gejala` varchar(128) CHARACTER SET utf8mb4 NOT NULL,
  `nama_gejala` varchar(128) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `kode_gejala`, `nama_gejala`) VALUES
(1, 'K001', 'Fake Login'),
(2, 'K002', 'Banyak Subdomain'),
(3, 'K003', 'Domain Typo'),
(4, 'K004', 'Memiliki Sertifikat SSL (Secure Socket Layar) Tidak Resmi'),
(5, 'K005', 'Domain Berisi Karakter Khusus'),
(6, 'K006', 'Domain Berupa Alamat IP'),
(7, 'K007', 'Situs Memiliki Informasi Bersifat Mengancam'),
(8, 'K008', 'Domain Tidak Memiliki Informasi WHOIS'),
(9, 'K009', 'Situs Meminta Informasi Pribadi'),
(10, 'K010', 'Terdapat Banyak Link Mati Pada Situs');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kondisi`
--

CREATE TABLE `kondisi` (
  `id_kondisi` int(10) NOT NULL,
  `kondisi` varchar(30) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kondisi`
--

INSERT INTO `kondisi` (`id_kondisi`, `kondisi`) VALUES
(1, 'Sangat Yakin'),
(2, 'Yakin'),
(3, 'Cukup Yakin'),
(4, 'Sedikit Yakin'),
(5, 'Kurang Yakin'),
(6, 'Tidak Yakin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pakar`
--

CREATE TABLE `pakar` (
  `id` int(10) NOT NULL,
  `email` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `kata_sandi` varchar(256) CHARACTER SET utf8mb4 NOT NULL,
  `nama_lengkap` varchar(30) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pakar`
--

INSERT INTO `pakar` (`id`, `email`, `kata_sandi`, `nama_lengkap`) VALUES
(1, 'affinbara@gmail.com', '$2y$10$G8NpiGmP2kO4j5B8XrzD6OAZCOYt1T/22L8aZsLsHOopQ0rlfWXFu', 'Afid Arifin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengetahuan`
--

CREATE TABLE `pengetahuan` (
  `id_pengetahuan` int(10) NOT NULL,
  `kode_pengetahuan` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `id_gangguan` int(10) NOT NULL,
  `id_gejala` int(10) NOT NULL,
  `mb` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `md` varchar(6) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengetahuan`
--

INSERT INTO `pengetahuan` (`id_pengetahuan`, `kode_pengetahuan`, `id_gangguan`, `id_gejala`, `mb`, `md`) VALUES
(1, 'P001', 1, 1, '0.8', '0.2'),
(2, 'P002', 2, 2, '0.8', '0.2'),
(3, 'P003', 3, 3, '0.8', '0.2'),
(4, 'P004', 4, 4, '0.5', '0.5'),
(5, 'P005', 5, 5, '1.0', '0.0'),
(6, 'P006', 6, 6, '0.9', '0.1'),
(7, 'P007', 7, 7, '0.9', '0.1'),
(8, 'P008', 8, 8, '0.7', '0.3'),
(9, 'P009', 9, 9, '0.8', '0.2'),
(10, 'P010', 10, 10, '0.7', '0.3');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `gangguan`
--
ALTER TABLE `gangguan`
  ADD PRIMARY KEY (`id_gangguan`);

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indeks untuk tabel `kondisi`
--
ALTER TABLE `kondisi`
  ADD PRIMARY KEY (`id_kondisi`);

--
-- Indeks untuk tabel `pakar`
--
ALTER TABLE `pakar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengetahuan`
--
ALTER TABLE `pengetahuan`
  ADD PRIMARY KEY (`id_pengetahuan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `gangguan`
--
ALTER TABLE `gangguan`
  MODIFY `id_gangguan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kondisi`
--
ALTER TABLE `kondisi`
  MODIFY `id_kondisi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pakar`
--
ALTER TABLE `pakar`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengetahuan`
--
ALTER TABLE `pengetahuan`
  MODIFY `id_pengetahuan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
