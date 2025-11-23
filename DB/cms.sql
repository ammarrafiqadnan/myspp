-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2023 at 02:34 PM
-- Server version: 5.6.20
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spamenu`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `title` varchar(512) DEFAULT NULL,
  `content` text,
  `status` varchar(45) DEFAULT NULL,
  `unique_name` varchar(45) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `tarikh_mula` date DEFAULT NULL,
  `tarikh_tamat` date DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `title`, `content`, `status`, `unique_name`, `sort`, `tarikh_mula`, `tarikh_tamat`, `is_deleted`) VALUES
(1, 'Penafian', 'Kerajaan Malaysia tidak akan bertanggungjawab terhadap sebarang kehilangan atau kerugian yang disebabkan oleh penggunaan mana-mana maklumat yang diperolehi dari portal ini.\r\n', NULL, NULL, NULL, NULL, NULL, 0),
(2, 'Polisi Keselamatan', '<b>Perlindungan Data</b>\r\n\r\nTeknologi terkini termasuk penyulitan data adalah digunakan untuk melindungi data yang dikemukakan dan pematuhan kepada standard keselamatan yang ketat adalah terpakai untuk menghalang capaian yang tidak dibenarkan.\r\n\r\n<b>Keselamatan Storan</b>\r\n\r\nSemua storan elektronik dan penghantaran data peribadi akan dilindungi dan disimpan dengan menggunakan teknologi keselamatan yang sesuai.\r\n\r\n<b>DKICT SPP Versi 3.1</b>\r\n\r\nDKICT SPP Versi 3.1 menerangkan: \r\n\r\na) peraturan-peraturan yang MESTI DIBACA, DIFAHAMI dan DIPATUHI oleh semua pengguna SPP termasuk pihak ketiga yang membekalkan perkhidmatan ICT dan tiada pengecualian diberi.\r\n\r\nb)  tanggungjawab / peranan semua pengguna SPP dalam menggunakan aset ICT SPP termasuk pihak ketiga.\r\n\r\nMuat Turun\r\n', NULL, NULL, NULL, NULL, NULL, 0),
(3, 'Dasar Privasi', 'Halaman ini menerangkan dasar privasi yang merangkumi penggunaan dan perlindungan maklumat yang dikemukakan oleh pengunjung.\r\n\r\n<b>Maklumat yang Dikumpul</b>\r\n\r\nTiada maklumat peribadi akan dikumpul semasa anda melayari Portal ini kecuali maklumat yang dikemukakan oleh anda melalui e-mel.\r\n\r\n<b>Cookies</b>\r\n\r\nCookies yang dihasilkan oleh pelayan web hanya akan digunakan untuk mengumpul maklumat bagi mengenal pasti layaran anda yang akan datang. Cookies ini tidak akan merekodkan data secara kekal dan ia tidak juga disimpan di dalam pemacu keras komputer anda. Ia akan terus dipadam sebaik sahaja anda meninggalkan Portal ini.\r\n\r\n<b>Pautan kepada Laman Web yang Lain</b>\r\n\r\nPortal ini mempunyai pautan ke laman web agensi Kerajaan dan agensi bukan Kerajaan. Dasar privasi ini hanya terpakai untuk Portal ini sahaja. Perlu diingatkan bahawa laman web yang terdapat dalam pautan Portal ini mungkin mempunyai dasar privasi yang berbeza dan pengunjung dinasihatkan supaya meneliti dan memahami dasar privasi bagi setiap laman web yang dilayari.\r\n\r\n<b>Pindaan Dasar</b>\r\n\r\nSekiranya dasar privasi ini dipinda, pindaan akan dikemas kini di halaman ini. Dengan sering melayari halaman ini, anda akan dikemas kini dengan maklumat yang dikumpul, cara ia digunakan dan dalam keadaan tertentu, bagaimana maklumat dikongsi bersama pihak yang lain.\r\n', NULL, NULL, NULL, NULL, NULL, 0),
(4, 'SARAWAK : Hebahan Keputusan Temu Duga Bagi Pelantikan Tetap Guru Interim Diperaku Kementerian Pendidikan Malaysia Sebagai Pegawai Perkhidmatan Pendidikan Gred DG41 Tahun 2022', '<p>Semakan keputusan temu duga bagi pelantikan tetap Guru Interim yang diperaku oleh Kementerian Pendidikan Malaysia sebagai Pegawai Perkhidmatan Pendidikan Gred DG41 tahun 2022.\r\n\r\nCalon boleh membuat semakan keputusan temu duga di SINI.\r\n\r\nhttps://semakan.spp.gov.my/semakan/keputusan_temuduga_view.php\r\n\r\nTINDAKAN CALON BERJAYA SELANJUTNYA : \r\n\r\nCalon yang berjaya perlu memuat turun, menyimpan dan mencetak mencetak Surat Tawaran Lantikan dan Pakej Setuju Terima Tawaran (PSTT). Perlu diambil perhatian bahawa keputusan temu duga serta pautan untuk mencetak Surat Tawaran Lantikan dan PSTT hanya dipaparkan dalam tempoh enam (6) minggu sahaja daripada tarikh hebahan ini dibuat. Kegagalan mencetak surat tawaran sebelum tarikh yang dinyatakan akan menyebabkan tuan/puan tidak mempunyai salinan surat tawaran dan menyukarkan proses melapor diri.\r\n\r\nSurat Arahan melapor diri/penempatan akan dikeluarkan oleh Kementerian Pendidikan Malaysia kepada calon-calon yang berjaya.</p>', '1', 'news1', 5, NULL, NULL, 0),
(8, 'SEMENANJUNG: Hebahan Keputusan Temu Duga Graduan Pendidikan Ke Jawatan Pegawai Perkhidmatan Pendidikan Gred DG41 Untuk Pengambilan Tahun 2022', 'Calon boleh membuat semakan keputusan temu duga di SINI.\r\n\r\nBagi calon-calon opsyen Bahasa Inggeris, calon-calon yang tidak mempunyai kelayakan CEFR C1 atau MUET Band 5, boleh membuat semakan keputusan temu duga di SINI.\r\n\r\nTINDAKAN CALON SELANJUTNYA :\r\n\r\nCalon-calon yang berjaya hendaklah mencetak Surat Tawaran Lantikan dan Pakej Setuju Terima Tawaran (PSTT) sebelum 3 Mac 2023. Perlu diambil perhatian bahawa keputusan temu duga serta pautan untuk mencetak Surat Tawaran Lantikan dan PSTT hanya dipaparkan sehingga tarikh berkenaan sahaja. Kegagalan mencetak surat tawaran sebelum tarikh yang dinyatakan akan menyebabkan tuan/puan tidak mempunyai salinan surat tawaran dan menyukarkan proses melapor diri.\r\n\r\nSurat Arahan melapor diri/penempatan akan dikeluarkan oleh Kementerian Pendidikan Malaysia kepada calon-calon yang berjaya.\r\n\r\nSekiranya terdapat sebarang kesilapan alamat pada surat tawaran tersebut, calon dimohon untuk menghantar e-mel pemakluman kepada alamat guru@spp.gov. my.\r\n\r\nSila kemukakan alamat yang betul berserta nombor kad pengenalan dan nombor telefon untuk dihubungi dalam e-mel tersebut. SPP akan menghubungi calon apabila surat tawaran tersebut telah dikemas kini dan boleh dicetak semula.\r\n', '1', '', 3, '0000-00-00', '0000-00-00', 0),
(16, 'SABAH : Hebahan Keputusan Temu Duga Bagi Pelantikan Tetap Guru Sekolah Agama Bantuan Kerajaan (SABK) Yang Diperaku Oleh Kementerian Pendidikan Malaysia Sebagai Pegawai Perkhidmatan Pendidikan Gred DG41 Tahun 2022 ', '\r\n\r\nkeputusan td ppp 2\r\n\r\nSemakan keputusan temu duga bagi pelantikan tetap Guru Sekolah Agama Bantuan Kerajaan (SABK) yang diperaku oleh Kementerian Pendidikan Malaysia sebagai Pegawai Perkhidmatan Pendidikan Gred DG41 tahun 2022.\r\n\r\nCalon boleh membuat semakan keputusan temu duga di SINI.\r\n\r\nhttps://semakan.spp.gov.my/semakan/keputusan_temuduga_view.php\r\n\r\nTINDAKAN CALON SELANJUTNYA : \r\n\r\nCalon yang berjaya perlu memuat turun, menyimpan dan mencetak mencetak Surat Tawaran Lantikan dan Pakej Setuju Terima Tawaran (PSTT). Perlu diambil perhatian bahawa keputusan temu duga serta pautan untuk mencetak Surat Tawaran Lantikan dan PSTT hanya dipaparkan dalam tempoh enam (6) minggu sahaja daripada tarikh hebahan ini dibuat. Kegagalan mencetak surat tawaran sebelum tarikh yang dinyatakan akan menyebabkan tuan/puan tidak mempunyai salinan surat tawaran dan menyukarkan proses melapor diri.\r\n\r\nSurat Arahan melapor diri/penempatan akan dikeluarkan oleh Kementerian Pendidikan Malaysia kepada calon-calon yang berjaya.\r\n', '1', '', 2, '0000-00-00', '0000-00-00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
