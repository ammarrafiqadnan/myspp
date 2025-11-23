-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2024 at 02:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spp_calon`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon`
--

CREATE TABLE `archive_calon` (
  `id_pemohon` varchar(20) NOT NULL,
  `ICNo` varchar(12) NOT NULL,
  `jenis_id` char(1) NOT NULL,
  `nama_penuh` varchar(100) NOT NULL,
  `dob` datetime DEFAULT NULL,
  `addr1` varchar(100) DEFAULT NULL,
  `addr2` varchar(100) DEFAULT NULL,
  `addr3` varchar(100) DEFAULT NULL,
  `poskod` varchar(5) DEFAULT NULL,
  `bandar` varchar(30) DEFAULT NULL,
  `negeri` varchar(30) DEFAULT NULL,
  `no_depan` varchar(3) DEFAULT NULL,
  `no_tel` varchar(30) DEFAULT NULL,
  `e_mail` varchar(100) DEFAULT NULL,
  `negeri_lahir_pemohon` varchar(30) DEFAULT NULL,
  `negeri_lahir_ibu` varchar(30) DEFAULT NULL,
  `negeri_lahir_bapa` varchar(30) DEFAULT NULL,
  `jantina` char(1) DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `keturunan` varchar(20) DEFAULT NULL,
  `warganegara` varchar(30) DEFAULT NULL,
  `lesen_kenderaan` varchar(30) DEFAULT NULL,
  `taraf_kawin` char(1) DEFAULT NULL,
  `ketinggian` double(5,2) DEFAULT NULL,
  `berat` decimal(5,2) DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `bmi` double DEFAULT NULL,
  `masih_khidmat` char(1) DEFAULT NULL,
  `srp_tahun` smallint(4) DEFAULT NULL,
  `srp_jenis_sijil` varchar(20) DEFAULT NULL,
  `srp_pangkat` varchar(20) DEFAULT NULL,
  `spm_tahun_1` smallint(4) DEFAULT NULL,
  `spm_jenis_sijil_1` varchar(20) DEFAULT NULL,
  `spm_pangkat_1` varchar(20) DEFAULT NULL,
  `spm_lisan_1` varchar(20) DEFAULT NULL,
  `spm_tahun_2` smallint(4) DEFAULT NULL,
  `spm_jenis_sijil_2` varchar(20) DEFAULT NULL,
  `spm_pangkat_2` varchar(20) DEFAULT NULL,
  `spm_lisan_2` varchar(2) DEFAULT NULL,
  `xm_tambahan_flag` char(1) DEFAULT NULL,
  `stp_tahun_1` smallint(4) DEFAULT NULL,
  `stp_jenis_1` varchar(20) DEFAULT NULL,
  `stp_pangkat_1` varchar(20) DEFAULT NULL,
  `stp_tahun_2` smallint(4) DEFAULT NULL,
  `stp_jenis_2` varchar(20) DEFAULT NULL,
  `stp_pangkat_2` varchar(20) DEFAULT NULL,
  `stam_tahun_1` smallint(4) DEFAULT NULL,
  `stam_jenis_1` varchar(20) DEFAULT NULL,
  `stam_pangkat_1` varchar(20) DEFAULT NULL,
  `stam_tahun_2` smallint(4) DEFAULT NULL,
  `stam_jenis_2` varchar(20) DEFAULT NULL,
  `stam_pangkat_2` varchar(20) DEFAULT NULL,
  `ipt_flag` char(1) DEFAULT NULL,
  `professional_1` varchar(50) DEFAULT NULL,
  `professional_d_1` datetime DEFAULT NULL,
  `professional_no_ahli_1` varchar(20) DEFAULT NULL,
  `professional_2` varchar(50) DEFAULT NULL,
  `professional_d_2` datetime DEFAULT NULL,
  `professional_no_ahli_2` varchar(20) DEFAULT NULL,
  `professional_3` varchar(50) DEFAULT NULL,
  `professional_d_3` datetime DEFAULT NULL,
  `professional_no_ahli_3` varchar(20) DEFAULT NULL,
  `iktisas_1` varchar(50) DEFAULT NULL,
  `iktisas_d_1` datetime DEFAULT NULL,
  `iktisas_2` varchar(50) DEFAULT NULL,
  `iktisas_d_2` datetime DEFAULT NULL,
  `iktisas_3` varchar(50) DEFAULT NULL,
  `iktisas_d_3` datetime DEFAULT NULL,
  `sukan_flag` char(1) DEFAULT NULL,
  `persatuan_flag` char(1) DEFAULT NULL,
  `reka_cipta_flag` char(1) DEFAULT NULL,
  `khas_flag` char(1) DEFAULT NULL,
  `bantuan` varchar(30) DEFAULT NULL,
  `no_rujukan_bantuan` varchar(20) DEFAULT NULL,
  `oku` varchar(30) DEFAULT NULL,
  `no_rujukan_oku` varchar(20) DEFAULT NULL,
  `bakat1` varchar(50) DEFAULT NULL,
  `bakat2` varchar(50) DEFAULT NULL,
  `bakat3` varchar(50) DEFAULT NULL,
  `bahasa_lain1` varchar(50) DEFAULT NULL,
  `penguasaan_bahasa1` varchar(20) DEFAULT NULL,
  `bahasa_lain2` varchar(50) DEFAULT NULL,
  `penguasaan_bahasa2` varchar(20) DEFAULT NULL,
  `bahasa_lain3` varchar(50) DEFAULT NULL,
  `penguasaan_bahasa3` varchar(20) DEFAULT NULL,
  `kategori_tentera_polis` varchar(20) DEFAULT NULL,
  `pencen` varchar(20) DEFAULT NULL,
  `pengakuan` char(1) DEFAULT NULL,
  `tarikh_akuan` datetime DEFAULT NULL,
  `status_pemohon` char(1) DEFAULT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL,
  `flag_checkmyid` varchar(1) DEFAULT NULL,
  `flag_mobile` char(1) DEFAULT NULL,
  `flag_matrikulasi` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_bakat_bahasa`
--

CREATE TABLE `archive_calon_bakat_bahasa` (
  `id_pemohon` varchar(20) NOT NULL,
  `seqno` smallint(3) DEFAULT 0,
  `bakat_bahasa` varchar(30) NOT NULL DEFAULT '',
  `penguasaan` varchar(20) DEFAULT NULL,
  `bakat_bahasa_ind` char(1) NOT NULL DEFAULT 'B' COMMENT 'B - Bakat, L - Bahasa',
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_bakat_detail`
--

CREATE TABLE `archive_calon_bakat_detail` (
  `id_pemohon` varchar(20) NOT NULL,
  `bakat_detail` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_emel_reminder`
--

CREATE TABLE `archive_calon_emel_reminder` (
  `id_pemohon` varchar(20) NOT NULL,
  `emel_no` smallint(6) DEFAULT NULL,
  `dt_emel1` date DEFAULT NULL,
  `dt_emel2` date DEFAULT NULL,
  `dt_emel3` date DEFAULT NULL,
  `dt_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_gambar`
--

CREATE TABLE `archive_calon_gambar` (
  `id_pemohon` varchar(32) NOT NULL,
  `gambar` varchar(64) DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  `update_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_harta`
--

CREATE TABLE `archive_calon_harta` (
  `id_pemohon` varchar(12) NOT NULL,
  `harta` varchar(5) NOT NULL,
  `id_cipta` varchar(30) DEFAULT NULL,
  `d_cipta` timestamp NULL DEFAULT current_timestamp(),
  `d_ubahsuai` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_ipt`
--

CREATE TABLE `archive_calon_ipt` (
  `id_pemohon` varchar(20) NOT NULL,
  `bil_keputusan` smallint(1) NOT NULL DEFAULT 0,
  `tahun` smallint(4) NOT NULL DEFAULT 0,
  `peringkat` varchar(30) NOT NULL DEFAULT '',
  `cgpa` double(5,2) DEFAULT NULL,
  `inst_keluar_sijil` varchar(30) DEFAULT NULL,
  `inst_francais` varchar(30) DEFAULT NULL COMMENT 'Y - spm biasa, T - peperiksaan tambahan',
  `bidang` varchar(30) DEFAULT NULL,
  `pengkhususan` varchar(30) DEFAULT NULL,
  `biasiswa` varchar(30) DEFAULT NULL,
  `muet` varchar(6) DEFAULT NULL,
  `muet_tahun` varchar(4) DEFAULT NULL,
  `muet_gred` int(11) DEFAULT NULL,
  `tkh_senate` date DEFAULT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_jawatan_dipohon`
--

CREATE TABLE `archive_calon_jawatan_dipohon` (
  `id_pemohon` varchar(20) NOT NULL,
  `kod_jaw_skim` int(11) DEFAULT NULL,
  `kod_peringkat` smallint(6) DEFAULT NULL,
  `kod_jawatan` varchar(20) NOT NULL DEFAULT '',
  `peringkat` varchar(20) NOT NULL DEFAULT '',
  `d_mohon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seq_no` smallint(6) DEFAULT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL,
  `d_iklan` datetime DEFAULT NULL,
  `d_iklan_tamat` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_ko_khas`
--

CREATE TABLE `archive_calon_ko_khas` (
  `id_pemohon` varchar(20) NOT NULL,
  `pencapaian` varchar(60) NOT NULL DEFAULT '',
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_ko_persatuan`
--

CREATE TABLE `archive_calon_ko_persatuan` (
  `id_pemohon` varchar(20) NOT NULL,
  `persatuan` varchar(60) NOT NULL DEFAULT '',
  `jawatan` varchar(30) NOT NULL DEFAULT '',
  `peringkat` varchar(20) NOT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_ko_plkn`
--

CREATE TABLE `archive_calon_ko_plkn` (
  `id_pemohon` varchar(20) NOT NULL,
  `plkn` varchar(5) NOT NULL,
  `id_cipta` varchar(30) DEFAULT NULL,
  `d_cipta` timestamp NULL DEFAULT current_timestamp(),
  `d_ubahsuai` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_ko_rekacipta`
--

CREATE TABLE `archive_calon_ko_rekacipta` (
  `id_pemohon` varchar(20) NOT NULL,
  `rekacipta` varchar(60) NOT NULL DEFAULT '',
  `sumbangan` varchar(20) NOT NULL DEFAULT '',
  `peringkat` varchar(20) DEFAULT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_ko_sukan`
--

CREATE TABLE `archive_calon_ko_sukan` (
  `id_pemohon` varchar(20) NOT NULL,
  `sukan` varchar(30) NOT NULL DEFAULT '',
  `peringkat` varchar(20) NOT NULL DEFAULT '',
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_masih_khidmat`
--

CREATE TABLE `archive_calon_masih_khidmat` (
  `id_pemohon` varchar(20) DEFAULT NULL,
  `jenis_perkhidmatan` varchar(20) DEFAULT NULL,
  `taraf_jawatan` varchar(20) DEFAULT NULL,
  `d_lantikan_jpa` date DEFAULT NULL,
  `d_lantikan_kontrak` date DEFAULT NULL,
  `skim_sekarang` varchar(20) DEFAULT NULL,
  `skim_sekarang_jika_tiada` varchar(50) DEFAULT NULL,
  `d_lantikan_khidmat_sekarang` date DEFAULT NULL,
  `d_sah_khidmat_sekarang` date DEFAULT NULL,
  `gred_jawatan_sekarang` varchar(20) DEFAULT NULL,
  `tpt_bertugas` varchar(20) DEFAULT NULL,
  `tpt_bertugas_jika_tiada` varchar(50) DEFAULT NULL,
  `negeri_tpt_bertugas` varchar(30) DEFAULT NULL,
  `d_lulus_kpsl` date DEFAULT NULL,
  `jenis_xm` varchar(20) DEFAULT NULL,
  `jenis_xm_jika_tiada` varchar(50) DEFAULT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_matrik`
--

CREATE TABLE `archive_calon_matrik` (
  `ID` bigint(20) NOT NULL,
  `id_pemohon` varchar(20) DEFAULT NULL,
  `tahun` smallint(4) DEFAULT NULL,
  `no_matrik` varchar(15) DEFAULT NULL,
  `jenis_sijil` varchar(5) DEFAULT NULL,
  `jurusan` varchar(2) DEFAULT NULL,
  `sesi` varchar(10) DEFAULT NULL,
  `semester` varchar(2) DEFAULT NULL,
  `kolej` varchar(2) DEFAULT NULL,
  `kod_subjek` varchar(5) DEFAULT NULL,
  `gred` varchar(2) DEFAULT NULL,
  `pngk` smallint(6) DEFAULT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_polis_ban_oku`
--

CREATE TABLE `archive_calon_polis_ban_oku` (
  `id_pemohon` varchar(20) NOT NULL,
  `kategori` varchar(30) NOT NULL DEFAULT '',
  `pangkat` varchar(30) DEFAULT NULL,
  `rujukan_ganjaran` varchar(20) DEFAULT NULL,
  `ind` char(1) NOT NULL DEFAULT '' COMMENT 'P - Polis, B - Bantuan dan O - OKU',
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_pro_iktisas`
--

CREATE TABLE `archive_calon_pro_iktisas` (
  `id_pemohon` varchar(20) NOT NULL,
  `sijil` varchar(50) NOT NULL DEFAULT '',
  `d_sijil` date DEFAULT NULL,
  `no_ahli` varchar(20) DEFAULT NULL,
  `ind` char(1) NOT NULL DEFAULT '' COMMENT 'P - Prefesional, I - Iktisas',
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_pusat_temuduga`
--

CREATE TABLE `archive_calon_pusat_temuduga` (
  `id_pemohon` varchar(20) NOT NULL,
  `kod_jawatan` varchar(20) NOT NULL DEFAULT '',
  `d_mohon` datetime DEFAULT NULL,
  `peringkat` varchar(20) DEFAULT NULL,
  `pusat_temuduga_old` varchar(30) DEFAULT NULL,
  `pusat_temuduga` varchar(6) DEFAULT NULL,
  `sesi_temuduga` varchar(20) DEFAULT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_sijil`
--

CREATE TABLE `archive_calon_sijil` (
  `id_pemohon` varchar(32) NOT NULL,
  `jenis_sijil` varchar(12) NOT NULL,
  `sijil_nama` varchar(64) DEFAULT NULL,
  `sijil_size` double DEFAULT NULL,
  `sijil_type` varchar(64) DEFAULT NULL,
  `dt_create` datetime DEFAULT NULL,
  `dt_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_spm`
--

CREATE TABLE `archive_calon_spm` (
  `spm_id` varchar(32) DEFAULT NULL,
  `id_pemohon` varchar(20) NOT NULL,
  `tahun` smallint(4) NOT NULL DEFAULT 0,
  `matapelajaran` varchar(30) NOT NULL DEFAULT '',
  `jenis_sijil` varchar(20) DEFAULT NULL,
  `gred` varchar(10) DEFAULT NULL,
  `jenis_xm` char(1) NOT NULL DEFAULT '' COMMENT '1 - spm biasa, T - peperiksaan tambahan',
  `ujian_lisan` char(1) DEFAULT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_srp`
--

CREATE TABLE `archive_calon_srp` (
  `srp_id` varchar(32) DEFAULT NULL,
  `id_pemohon` varchar(20) NOT NULL,
  `tahun` smallint(4) NOT NULL DEFAULT 0,
  `matapelajaran` varchar(30) NOT NULL DEFAULT '',
  `jenis_sijil` varchar(20) NOT NULL,
  `gred` varchar(10) DEFAULT NULL,
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_stp_stam`
--

CREATE TABLE `archive_calon_stp_stam` (
  `stp_id` varchar(32) DEFAULT NULL,
  `id_pemohon` varchar(20) NOT NULL,
  `tahun` smallint(4) NOT NULL DEFAULT 0,
  `matapelajaran` varchar(30) NOT NULL DEFAULT '',
  `jenis_sijil` varchar(20) DEFAULT NULL,
  `gred` varchar(15) DEFAULT NULL,
  `jenis_xm` varchar(2) NOT NULL COMMENT 'B - stpm biasa, A - peperiksaan STAM',
  `d_cipta` datetime DEFAULT NULL,
  `d_kemaskini` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_svm`
--

CREATE TABLE `archive_calon_svm` (
  `id` int(11) NOT NULL,
  `id_pemohon` varchar(20) NOT NULL,
  `tahun` smallint(6) NOT NULL,
  `jenis_sijil` varchar(4) DEFAULT NULL,
  `nama_sijil` varchar(4) DEFAULT NULL,
  `gred_bm` varchar(4) DEFAULT NULL,
  `svm_pngk` decimal(3,2) NOT NULL,
  `svm_pngkv` decimal(3,2) NOT NULL,
  `create_dt` datetime DEFAULT NULL,
  `updated_dt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_tambahan_lain`
--

CREATE TABLE `archive_calon_tambahan_lain` (
  `id_pemohon` varchar(20) NOT NULL,
  `tatatertib` varchar(5) NOT NULL,
  `tkh_hukum` varchar(10) NOT NULL,
  `id_cipta` varchar(30) DEFAULT NULL,
  `d_cipta` timestamp NULL DEFAULT current_timestamp(),
  `d_ubahsuai` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_tarikh`
--

CREATE TABLE `archive_calon_tarikh` (
  `id` int(11) NOT NULL,
  `id_pemohon` varchar(32) NOT NULL,
  `tkh_upd_biodata` datetime DEFAULT NULL,
  `tkh_upd_akademik` datetime DEFAULT NULL,
  `tkh_upd_koko` datetime DEFAULT NULL,
  `tkh_upd_awam` datetime DEFAULT NULL,
  `tkh_upd_tambahan` datetime DEFAULT NULL,
  `tkh_upd_jawatan` datetime DEFAULT NULL,
  `tkh_upd_perakuan` datetime DEFAULT NULL,
  `pengakuan` varchar(2) DEFAULT NULL,
  `tarikh_akuan` datetime DEFAULT NULL,
  `status_pemohon` varchar(2) DEFAULT NULL,
  `tarikh_luput` date DEFAULT NULL,
  `tkh_espp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_calon_tarikh_sejarah`
--

CREATE TABLE `archive_calon_tarikh_sejarah` (
  `id` int(11) NOT NULL,
  `id_pemohon` varchar(32) NOT NULL,
  `tkh_upd_biodata` datetime DEFAULT NULL,
  `tkh_upd_akademik` datetime DEFAULT NULL,
  `tkh_upd_koko` datetime DEFAULT NULL,
  `tkh_upd_awam` datetime DEFAULT NULL,
  `tkh_upd_tambahan` datetime DEFAULT NULL,
  `tkh_upd_jawatan` datetime DEFAULT NULL,
  `tkh_upd_perakuan` datetime DEFAULT NULL,
  `pengakuan` varchar(2) DEFAULT NULL,
  `tarikh_akuan` datetime DEFAULT NULL,
  `tarikh_luput` date DEFAULT NULL,
  `status_pemohon` varchar(2) DEFAULT NULL,
  `jawatan1` int(11) DEFAULT NULL,
  `jawatan2` int(11) DEFAULT NULL,
  `jawatan3` int(11) DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `myid`
--

CREATE TABLE `archive_myid` (
  `ICNo` varchar(14) NOT NULL DEFAULT '',
  `ic_ind` char(1) NOT NULL DEFAULT '',
  `MyID` varchar(14) DEFAULT NULL,
  `id_pemohon` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `addr1` varchar(100) DEFAULT NULL,
  `addr2` varchar(100) DEFAULT NULL,
  `addr3` varchar(100) DEFAULT NULL,
  `poskod` varchar(5) DEFAULT NULL,
  `bandar` varchar(30) DEFAULT NULL,
  `negeri` varchar(30) DEFAULT NULL,
  `nodepan` varchar(3) DEFAULT NULL,
  `notel` varchar(30) DEFAULT NULL,
  `emel` varchar(100) NOT NULL,
  `katalaluan` varchar(50) DEFAULT NULL,
  `kod_keselamatan` varchar(20) DEFAULT NULL,
  `ip_addr` varchar(20) DEFAULT NULL,
  `d_create` datetime DEFAULT NULL,
  `d_upd` datetime DEFAULT NULL,
  `status` char(2) DEFAULT NULL,
  `stage` smallint(2) DEFAULT 0 COMMENT '0 - peringkat permulaan',
  `rmrk` varchar(50) DEFAULT NULL,
  `neg_keselamatan` varchar(2) DEFAULT NULL,
  `daftar_flag` int(2) NOT NULL DEFAULT 0,
  `bil_lupa` int(2) DEFAULT NULL,
  `bil_cuba_pwd` int(2) DEFAULT NULL,
  `tmp_pwd_flag` varchar(20) DEFAULT NULL,
  `tkh_daftar` datetime DEFAULT NULL,
  `tkh_lupa` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive_calon`
--
ALTER TABLE `archive_calon`
  ADD PRIMARY KEY (`id_pemohon`),
  ADD KEY `idx6` (`ICNo`),
  ADD KEY `idx8` (`pengakuan`,`status_pemohon`),
  ADD KEY `idx2` (`xm_tambahan_flag`) USING BTREE,
  ADD KEY `idx3` (`spm_tahun_1`,`spm_tahun_2`) USING BTREE,
  ADD KEY `idx4` (`stp_tahun_1`,`stp_tahun_2`) USING BTREE,
  ADD KEY `idx5` (`stam_tahun_1`,`stam_tahun_2`) USING BTREE,
  ADD KEY `idx7` (`srp_tahun`) USING BTREE,
  ADD KEY `idx9` (`tarikh_akuan`) USING BTREE;

--
-- Indexes for table `archive_calon_bakat_bahasa`
--
ALTER TABLE `archive_calon_bakat_bahasa`
  ADD PRIMARY KEY (`id_pemohon`,`bakat_bahasa`,`bakat_bahasa_ind`);

--
-- Indexes for table `archive_calon_bakat_detail`
--
ALTER TABLE `archive_calon_bakat_detail`
  ADD PRIMARY KEY (`id_pemohon`,`bakat_detail`);

--
-- Indexes for table `archive_calon_emel_reminder`
--
ALTER TABLE `archive_calon_emel_reminder`
  ADD PRIMARY KEY (`id_pemohon`);

--
-- Indexes for table `archive_calon_gambar`
--
ALTER TABLE `archive_calon_gambar`
  ADD PRIMARY KEY (`id_pemohon`);

--
-- Indexes for table `archive_calon_harta`
--
ALTER TABLE `archive_calon_harta`
  ADD PRIMARY KEY (`id_pemohon`);

--
-- Indexes for table `archive_calon_ipt`
--
ALTER TABLE `archive_calon_ipt`
  ADD PRIMARY KEY (`id_pemohon`,`bil_keputusan`,`tahun`,`peringkat`);

--
-- Indexes for table `archive_calon_jawatan_dipohon`
--
ALTER TABLE `archive_calon_jawatan_dipohon`
  ADD PRIMARY KEY (`id_pemohon`,`d_mohon`,`peringkat`,`kod_jawatan`),
  ADD KEY `idx1` (`id_pemohon`,`peringkat`,`kod_jawatan`),
  ADD KEY `idx2` (`id_pemohon`,`peringkat`),
  ADD KEY `idx3` (`id_pemohon`,`kod_jawatan`),
  ADD KEY `idx4` (`kod_jawatan`),
  ADD KEY `idx5` (`d_mohon`),
  ADD KEY `seq_no` (`seq_no`),
  ADD KEY `kod_jaw_skim` (`kod_jaw_skim`),
  ADD KEY `kod_peringkat` (`kod_peringkat`);

--
-- Indexes for table `archive_calon_ko_khas`
--
ALTER TABLE `archive_calon_ko_khas`
  ADD PRIMARY KEY (`id_pemohon`,`pencapaian`);

--
-- Indexes for table `archive_calon_ko_persatuan`
--
ALTER TABLE `archive_calon_ko_persatuan`
  ADD PRIMARY KEY (`id_pemohon`,`persatuan`,`jawatan`,`peringkat`) USING BTREE;

--
-- Indexes for table `archive_calon_ko_plkn`
--
ALTER TABLE `archive_calon_ko_plkn`
  ADD PRIMARY KEY (`id_pemohon`);

--
-- Indexes for table `archive_calon_ko_rekacipta`
--
ALTER TABLE `archive_calon_ko_rekacipta`
  ADD PRIMARY KEY (`id_pemohon`,`rekacipta`,`sumbangan`);

--
-- Indexes for table `archive_calon_ko_sukan`
--
ALTER TABLE `archive_calon_ko_sukan`
  ADD PRIMARY KEY (`id_pemohon`,`sukan`,`peringkat`);

--
-- Indexes for table `archive_calon_masih_khidmat`
--
ALTER TABLE `archive_calon_masih_khidmat`
  ADD KEY `idx1` (`id_pemohon`);

--
-- Indexes for table `archive_calon_matrik`
--
ALTER TABLE `archive_calon_matrik`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `archive_calon_polis_ban_oku`
--
ALTER TABLE `archive_calon_polis_ban_oku`
  ADD PRIMARY KEY (`id_pemohon`,`ind`,`kategori`);

--
-- Indexes for table `archive_calon_pro_iktisas`
--
ALTER TABLE `archive_calon_pro_iktisas`
  ADD PRIMARY KEY (`id_pemohon`,`sijil`,`ind`);

--
-- Indexes for table `archive_calon_pusat_temuduga`
--
ALTER TABLE `archive_calon_pusat_temuduga`
  ADD PRIMARY KEY (`id_pemohon`,`kod_jawatan`),
  ADD KEY `idx1` (`id_pemohon`),
  ADD KEY `idx2` (`kod_jawatan`),
  ADD KEY `idx3` (`d_mohon`);

--
-- Indexes for table `archive_calon_sijil`
--
ALTER TABLE `archive_calon_sijil`
  ADD PRIMARY KEY (`id_pemohon`,`jenis_sijil`);

--
-- Indexes for table `archive_calon_spm`
--
ALTER TABLE `archive_calon_spm`
  ADD PRIMARY KEY (`id_pemohon`,`tahun`,`matapelajaran`,`jenis_xm`),
  ADD KEY `spm_id` (`spm_id`);

--
-- Indexes for table `archive_calon_srp`
--
ALTER TABLE `archive_calon_srp`
  ADD PRIMARY KEY (`id_pemohon`,`tahun`,`matapelajaran`,`jenis_sijil`) USING BTREE,
  ADD KEY `srp_id` (`srp_id`);

--
-- Indexes for table `archive_calon_stp_stam`
--
ALTER TABLE `archive_calon_stp_stam`
  ADD PRIMARY KEY (`id_pemohon`,`tahun`,`matapelajaran`,`jenis_xm`);

--
-- Indexes for table `archive_calon_svm`
--
ALTER TABLE `archive_calon_svm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pemohon` (`id_pemohon`),
  ADD KEY `tahun` (`tahun`);

--
-- Indexes for table `archive_calon_tambahan_lain`
--
ALTER TABLE `archive_calon_tambahan_lain`
  ADD PRIMARY KEY (`id_pemohon`,`tatatertib`,`tkh_hukum`);

--
-- Indexes for table `archive_calon_tarikh`
--
ALTER TABLE `archive_calon_tarikh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pemohon` (`id_pemohon`);

--
-- Indexes for table `archive_calon_tarikh_sejarah`
--
ALTER TABLE `archive_calon_tarikh_sejarah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pemohon` (`id_pemohon`);

--
-- Indexes for table `myid`
--
ALTER TABLE `archive_myid`
  ADD PRIMARY KEY (`ICNo`,`ic_ind`,`emel`) USING BTREE,
  ADD UNIQUE KEY `idx4` (`id_pemohon`),
  ADD KEY `idx1` (`rmrk`),
  ADD KEY `idx2` (`MyID`,`emel`),
  ADD KEY `idx3` (`MyID`,`stage`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive_calon_matrik`
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
