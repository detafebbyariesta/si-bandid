-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Feb 2021 pada 11.35
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sibandid`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_apbdes`
--

CREATE TABLE `tb_apbdes` (
  `id_apbdes` int(11) NOT NULL,
  `apbdes` varchar(100) NOT NULL,
  `perdes` varchar(100) NOT NULL,
  `perkades` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_apbdes_perub`
--

CREATE TABLE `tb_apbdes_perub` (
  `id_apbdes_perub` int(11) NOT NULL,
  `apbdes_perub` varchar(100) NOT NULL,
  `perdes` varchar(100) NOT NULL,
  `perkades` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ba_kas`
--

CREATE TABLE `tb_ba_kas` (
  `id_ba_kas` int(11) NOT NULL,
  `ba_kas` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bulanan`
--

CREATE TABLE `tb_bulanan` (
  `id_bulanan` int(11) NOT NULL,
  `bulanan` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL,
  `bulan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_habis_pakai`
--

CREATE TABLE `tb_habis_pakai` (
  `id_habis_pakai` int(11) NOT NULL,
  `habis_pakai` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ippd`
--

CREATE TABLE `tb_ippd` (
  `id_ippd` int(11) NOT NULL,
  `ippd` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lain`
--

CREATE TABLE `tb_lain` (
  `id_lain_lain` int(11) NOT NULL,
  `lain_lain` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lkpj`
--

CREATE TABLE `tb_lkpj` (
  `id_lkpj` int(11) NOT NULL,
  `lkpj` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lppd`
--

CREATE TABLE `tb_lppd` (
  `id_lppd` int(11) NOT NULL,
  `lppd` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_omspan`
--

CREATE TABLE `tb_omspan` (
  `id_omspan` int(11) NOT NULL,
  `omspan` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_realisasi_add`
--

CREATE TABLE `tb_realisasi_add` (
  `id_realisasi_add` int(11) NOT NULL,
  `realisasi_add` varchar(100) NOT NULL,
  `foto_add_1` varchar(100) NOT NULL,
  `foto_add_2` varchar(100) NOT NULL,
  `foto_add_3` varchar(100) NOT NULL,
  `foto_add_4` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_realisasi_apbdes`
--

CREATE TABLE `tb_realisasi_apbdes` (
  `id_realisasi_apbdes` int(11) NOT NULL,
  `realisasi_apbdes` varchar(100) NOT NULL,
  `foto_apbdes_1` varchar(100) NOT NULL,
  `foto_apbdes_2` varchar(100) NOT NULL,
  `foto_apbdes_3` varchar(100) NOT NULL,
  `foto_apbdes_4` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_realisasi_apbdes_dana`
--

CREATE TABLE `tb_realisasi_apbdes_dana` (
  `id_realisasi_apbdes_dana` int(11) NOT NULL,
  `realisasi_apbdes_dana` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_realisasi_dd`
--

CREATE TABLE `tb_realisasi_dd` (
  `id_realisasi_dd` int(11) NOT NULL,
  `realisasi_dd` varchar(100) NOT NULL,
  `foto_dd_1` varchar(100) NOT NULL,
  `foto_dd_2` varchar(100) NOT NULL,
  `foto_dd_3` varchar(100) NOT NULL,
  `foto_dd_4` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_realisasi_pad`
--

CREATE TABLE `tb_realisasi_pad` (
  `id_realisasi_pad` int(11) NOT NULL,
  `realisasi_pad` varchar(100) NOT NULL,
  `foto_pad_1` varchar(100) NOT NULL,
  `foto_pad_2` varchar(100) NOT NULL,
  `foto_pad_3` varchar(100) NOT NULL,
  `foto_pad_4` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rekap_realisasi_apbdes`
--

CREATE TABLE `tb_rekap_realisasi_apbdes` (
  `id_rekap_realisasi_apbdes` int(11) NOT NULL,
  `rekap_realisasi_apbdes` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_retribusi`
--

CREATE TABLE `tb_retribusi` (
  `id_retribusi` int(11) NOT NULL,
  `retribusi` varchar(100) NOT NULL,
  `foto1` varchar(100) NOT NULL,
  `foto2` varchar(100) NOT NULL,
  `foto3` varchar(100) NOT NULL,
  `foto4` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rkpdes`
--

CREATE TABLE `tb_rkpdes` (
  `id_rkpdes` int(11) NOT NULL,
  `rkpdes` varchar(100) NOT NULL,
  `perdes` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rpd`
--

CREATE TABLE `tb_rpd` (
  `id_rpd` int(11) NOT NULL,
  `rpd` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rpjmdes`
--

CREATE TABLE `tb_rpjmdes` (
  `id_rpjmdes` int(11) NOT NULL,
  `rpjmdes` varchar(100) NOT NULL,
  `perdes` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sk`
--

CREATE TABLE `tb_sk` (
  `id_sk` int(11) NOT NULL,
  `sk` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_smt_1`
--

CREATE TABLE `tb_smt_1` (
  `id_smt_1` int(11) NOT NULL,
  `smt_1` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_smt_2`
--

CREATE TABLE `tb_smt_2` (
  `id_smt_2` int(11) NOT NULL,
  `smt_2` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tanggung_jawab`
--

CREATE TABLE `tb_tanggung_jawab` (
  `id_tanggung_jawab` int(11) NOT NULL,
  `tanggung_jawab` varchar(100) NOT NULL,
  `perdes` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tutup_kas`
--

CREATE TABLE `tb_tutup_kas` (
  `id_tutup_kas` int(11) NOT NULL,
  `tutup_kas` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `validasi` varchar(50) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `level` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `nama_user`, `level`) VALUES
(1, 'admin', '$2y$10$JGgb2FSaT22Dt99kuI691..pr7WaAl375lac3nAJSOhSK1BDBYi6q', 'Admin', 'admin'),
(2, 'user', '$2y$10$3G9/XDZqKJcOI0o9WDhMP.3wGUJYD3vndfgVI5A8mCNWeCaHehiTC', 'Mranggen', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_apbdes`
--
ALTER TABLE `tb_apbdes`
  ADD PRIMARY KEY (`id_apbdes`);

--
-- Indeks untuk tabel `tb_apbdes_perub`
--
ALTER TABLE `tb_apbdes_perub`
  ADD PRIMARY KEY (`id_apbdes_perub`);

--
-- Indeks untuk tabel `tb_ba_kas`
--
ALTER TABLE `tb_ba_kas`
  ADD PRIMARY KEY (`id_ba_kas`);

--
-- Indeks untuk tabel `tb_bulanan`
--
ALTER TABLE `tb_bulanan`
  ADD PRIMARY KEY (`id_bulanan`);

--
-- Indeks untuk tabel `tb_habis_pakai`
--
ALTER TABLE `tb_habis_pakai`
  ADD PRIMARY KEY (`id_habis_pakai`);

--
-- Indeks untuk tabel `tb_ippd`
--
ALTER TABLE `tb_ippd`
  ADD PRIMARY KEY (`id_ippd`);

--
-- Indeks untuk tabel `tb_lain`
--
ALTER TABLE `tb_lain`
  ADD PRIMARY KEY (`id_lain_lain`);

--
-- Indeks untuk tabel `tb_lkpj`
--
ALTER TABLE `tb_lkpj`
  ADD PRIMARY KEY (`id_lkpj`);

--
-- Indeks untuk tabel `tb_lppd`
--
ALTER TABLE `tb_lppd`
  ADD PRIMARY KEY (`id_lppd`);

--
-- Indeks untuk tabel `tb_omspan`
--
ALTER TABLE `tb_omspan`
  ADD PRIMARY KEY (`id_omspan`);

--
-- Indeks untuk tabel `tb_realisasi_add`
--
ALTER TABLE `tb_realisasi_add`
  ADD PRIMARY KEY (`id_realisasi_add`);

--
-- Indeks untuk tabel `tb_realisasi_apbdes`
--
ALTER TABLE `tb_realisasi_apbdes`
  ADD PRIMARY KEY (`id_realisasi_apbdes`);

--
-- Indeks untuk tabel `tb_realisasi_apbdes_dana`
--
ALTER TABLE `tb_realisasi_apbdes_dana`
  ADD PRIMARY KEY (`id_realisasi_apbdes_dana`);

--
-- Indeks untuk tabel `tb_realisasi_dd`
--
ALTER TABLE `tb_realisasi_dd`
  ADD PRIMARY KEY (`id_realisasi_dd`);

--
-- Indeks untuk tabel `tb_realisasi_pad`
--
ALTER TABLE `tb_realisasi_pad`
  ADD PRIMARY KEY (`id_realisasi_pad`);

--
-- Indeks untuk tabel `tb_rekap_realisasi_apbdes`
--
ALTER TABLE `tb_rekap_realisasi_apbdes`
  ADD PRIMARY KEY (`id_rekap_realisasi_apbdes`);

--
-- Indeks untuk tabel `tb_retribusi`
--
ALTER TABLE `tb_retribusi`
  ADD PRIMARY KEY (`id_retribusi`);

--
-- Indeks untuk tabel `tb_rkpdes`
--
ALTER TABLE `tb_rkpdes`
  ADD PRIMARY KEY (`id_rkpdes`);

--
-- Indeks untuk tabel `tb_rpd`
--
ALTER TABLE `tb_rpd`
  ADD PRIMARY KEY (`id_rpd`);

--
-- Indeks untuk tabel `tb_rpjmdes`
--
ALTER TABLE `tb_rpjmdes`
  ADD PRIMARY KEY (`id_rpjmdes`);

--
-- Indeks untuk tabel `tb_sk`
--
ALTER TABLE `tb_sk`
  ADD PRIMARY KEY (`id_sk`);

--
-- Indeks untuk tabel `tb_smt_1`
--
ALTER TABLE `tb_smt_1`
  ADD PRIMARY KEY (`id_smt_1`);

--
-- Indeks untuk tabel `tb_smt_2`
--
ALTER TABLE `tb_smt_2`
  ADD PRIMARY KEY (`id_smt_2`);

--
-- Indeks untuk tabel `tb_tanggung_jawab`
--
ALTER TABLE `tb_tanggung_jawab`
  ADD PRIMARY KEY (`id_tanggung_jawab`);

--
-- Indeks untuk tabel `tb_tutup_kas`
--
ALTER TABLE `tb_tutup_kas`
  ADD PRIMARY KEY (`id_tutup_kas`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_apbdes`
--
ALTER TABLE `tb_apbdes`
  MODIFY `id_apbdes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_apbdes_perub`
--
ALTER TABLE `tb_apbdes_perub`
  MODIFY `id_apbdes_perub` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_ba_kas`
--
ALTER TABLE `tb_ba_kas`
  MODIFY `id_ba_kas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_bulanan`
--
ALTER TABLE `tb_bulanan`
  MODIFY `id_bulanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_habis_pakai`
--
ALTER TABLE `tb_habis_pakai`
  MODIFY `id_habis_pakai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_ippd`
--
ALTER TABLE `tb_ippd`
  MODIFY `id_ippd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_lain`
--
ALTER TABLE `tb_lain`
  MODIFY `id_lain_lain` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_lkpj`
--
ALTER TABLE `tb_lkpj`
  MODIFY `id_lkpj` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_lppd`
--
ALTER TABLE `tb_lppd`
  MODIFY `id_lppd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_omspan`
--
ALTER TABLE `tb_omspan`
  MODIFY `id_omspan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_realisasi_add`
--
ALTER TABLE `tb_realisasi_add`
  MODIFY `id_realisasi_add` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_realisasi_apbdes`
--
ALTER TABLE `tb_realisasi_apbdes`
  MODIFY `id_realisasi_apbdes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_realisasi_apbdes_dana`
--
ALTER TABLE `tb_realisasi_apbdes_dana`
  MODIFY `id_realisasi_apbdes_dana` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_realisasi_dd`
--
ALTER TABLE `tb_realisasi_dd`
  MODIFY `id_realisasi_dd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_realisasi_pad`
--
ALTER TABLE `tb_realisasi_pad`
  MODIFY `id_realisasi_pad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_rekap_realisasi_apbdes`
--
ALTER TABLE `tb_rekap_realisasi_apbdes`
  MODIFY `id_rekap_realisasi_apbdes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_retribusi`
--
ALTER TABLE `tb_retribusi`
  MODIFY `id_retribusi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_rkpdes`
--
ALTER TABLE `tb_rkpdes`
  MODIFY `id_rkpdes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_rpd`
--
ALTER TABLE `tb_rpd`
  MODIFY `id_rpd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_rpjmdes`
--
ALTER TABLE `tb_rpjmdes`
  MODIFY `id_rpjmdes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_sk`
--
ALTER TABLE `tb_sk`
  MODIFY `id_sk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_smt_1`
--
ALTER TABLE `tb_smt_1`
  MODIFY `id_smt_1` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_smt_2`
--
ALTER TABLE `tb_smt_2`
  MODIFY `id_smt_2` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_tanggung_jawab`
--
ALTER TABLE `tb_tanggung_jawab`
  MODIFY `id_tanggung_jawab` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_tutup_kas`
--
ALTER TABLE `tb_tutup_kas`
  MODIFY `id_tutup_kas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
