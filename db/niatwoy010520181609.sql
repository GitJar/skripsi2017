-- --------------------------------------------------------
-- Host:                         localhost
-- Versi server:                 10.2.3-MariaDB-log - mariadb.org binary distribution
-- OS Server:                    Win32
-- HeidiSQL Versi:               9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Membuang struktur basisdata untuk niatwoy
DROP DATABASE IF EXISTS `niatwoy`;
CREATE DATABASE IF NOT EXISTS `niatwoy` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `niatwoy`;

-- membuang struktur untuk table niatwoy.albaqarah
DROP TABLE IF EXISTS `albaqarah`;
CREATE TABLE IF NOT EXISTS `albaqarah` (
  `idAyat` int(11) NOT NULL,
  `Terjemahan` text NOT NULL,
  PRIMARY KEY (`idAyat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='terjemahan asli';

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table niatwoy.hasil_tfidf
DROP TABLE IF EXISTS `hasil_tfidf`;
CREATE TABLE IF NOT EXISTS `hasil_tfidf` (
  `idAyat` int(11) DEFAULT NULL,
  `hasil` float(11,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table niatwoy.katadasar
DROP TABLE IF EXISTS `katadasar`;
CREATE TABLE IF NOT EXISTS `katadasar` (
  `katadasar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='kumpulan kata dasar';

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table niatwoy.stopword
DROP TABLE IF EXISTS `stopword`;
CREATE TABLE IF NOT EXISTS `stopword` (
  `stopword` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='kumpulan stopword';

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table niatwoy.temp_filtering
DROP TABLE IF EXISTS `temp_filtering`;
CREATE TABLE IF NOT EXISTS `temp_filtering` (
  `idAyat` int(11) DEFAULT NULL,
  `Terjemahan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='jadi kecil, hapus tanda';

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table niatwoy.temp_stemming
DROP TABLE IF EXISTS `temp_stemming`;
CREATE TABLE IF NOT EXISTS `temp_stemming` (
  `idAyat` int(11) DEFAULT NULL,
  `Terjemahan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='stem kata dasar';

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table niatwoy.temp_term
DROP TABLE IF EXISTS `temp_term`;
CREATE TABLE IF NOT EXISTS `temp_term` (
  `kataTerjemahan` text COLLATE utf8_bin NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='pisah kata untuk tfidf';

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table niatwoy.temp_tokenizing
DROP TABLE IF EXISTS `temp_tokenizing`;
CREATE TABLE IF NOT EXISTS `temp_tokenizing` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `idAyat` int(4) NOT NULL DEFAULT 0,
  `kataTerjemahan` text COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4753 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='pisah kata untuk tfidf';

-- Pengeluaran data tidak dipilih.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
