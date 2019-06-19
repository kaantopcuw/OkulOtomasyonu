-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamaný: 22 May 2019, 04:33:59
-- Sunucu sürümü: 5.7.26-0ubuntu0.18.04.1
-- PHP Sürümü: 7.2.17-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin5 */;

--
-- Veritabaný: `myo_ders`
--
CREATE DATABASE IF NOT EXISTS `myo_ders` DEFAULT CHARACTER SET latin5 COLLATE latin5_turkish_ci;
USE `myo_ders`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapýsý `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `lesson_name` text NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `lessons`
--

INSERT INTO `lessons` (`id`, `lesson_name`, `teacher_id`) VALUES
(1, 'Matematik', 2),
(2, 'Türkçe', 3),
(3, 'Kimya', 4),
(4, 'Ýngilizce', 5),
(6, 'Almanca', 2),
(7, 'Bilgisayar', 10);

-- --------------------------------------------------------

--
-- Tablo için tablo yapýsý `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `number` text NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `students`
--

INSERT INTO `students` (`id`, `number`, `name`) VALUES
(1, '1024', 'ali uzun'),
(2, '1050', 'mehmet ustuner'),
(3, '1045', 'ismail çalýþkan'),
(4, '1780', 'tuðba tosun'),
(5, '1155', 'kýsmet kýlýkýrýk'),
(6, '1213', 'mahmut taþ'),
(7, '1454', 'kaan yürek'),
(8, '1377', 'umutcan baþkan'),
(9, '2282', 'ayþegül zorlu'),
(10, '2181', 'nur kocabaþ'),
(11, '1949', 'nurun nisa yýlmaz');

-- --------------------------------------------------------

--
-- Tablo için tablo yapýsý `student_taking_lasson`
--

CREATE TABLE `student_taking_lasson` (
  `students_id` int(11) NOT NULL,
  `lessons_id` int(11) NOT NULL,
  `vize_note` int(11) DEFAULT NULL,
  `final_note` int(11) DEFAULT NULL,
  `letter_note` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `student_taking_lasson`
--

INSERT INTO `student_taking_lasson` (`students_id`, `lessons_id`, `vize_note`, `final_note`, `letter_note`) VALUES
(1, 1, 50, NULL, NULL),
(2, 1, NULL, NULL, NULL),
(1, 2, 60, NULL, NULL),
(2, 2, 44, NULL, ''),
(3, 2, 28, 25, NULL),
(4, 3, 25, 55, NULL),
(2, 3, 25, 5, NULL),
(4, 1, NULL, NULL, NULL),
(3, 1, NULL, NULL, NULL),
(7, 1, NULL, NULL, NULL),
(9, 2, 55, NULL, NULL),
(7, 2, 2, NULL, NULL),
(11, 2, 58, 99, NULL),
(4, 2, NULL, NULL, NULL),
(8, 2, NULL, NULL, NULL),
(9, 3, 55, 78, 'BB'),
(4, 6, NULL, NULL, NULL),
(5, 6, NULL, NULL, NULL),
(8, 6, NULL, NULL, NULL),
(4, 7, NULL, NULL, NULL),
(9, 7, NULL, NULL, NULL),
(10, 7, NULL, NULL, NULL),
(6, 6, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapýsý `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL COMMENT 'isim',
  `username` varchar(20) NOT NULL COMMENT 'kullanci adi',
  `password` varchar(20) NOT NULL COMMENT 'sifre',
  `auth` tinyint(4) NOT NULL COMMENT 'yetki-> 0: yetkili 1: diger'
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `auth`) VALUES
(1, 'admin', 'admin', '11111', 0),
(2, 'Ali Kaba', 'user1', '11111', 1),
(3, 'Murat Þimþek', 'user2', '11111', 1),
(4, 'Mine Kara', 'user3', '11111', 1),
(5, 'Orhan Pamuk', 'user4', '11111', 1),
(10, 'Kaan Baþkan', 'user5', '11111', 1);

--
-- Dökümü yapýlmýþ tablolar için indeksler
--

--
-- Tablo için indeksler `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Tablo için indeksler `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `student_taking_lasson`
--
ALTER TABLE `student_taking_lasson`
  ADD KEY `students_id` (`students_id`),
  ADD KEY `lessons_id` (`lessons_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapýlmýþ tablolar için AUTO_INCREMENT deðeri
--

--
-- Tablo için AUTO_INCREMENT deðeri `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Tablo için AUTO_INCREMENT deðeri `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Tablo için AUTO_INCREMENT deðeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Dökümü yapýlmýþ tablolar için kýsýtlamalar
--

--
-- Tablo kýsýtlamalarý `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kýsýtlamalarý `student_taking_lasson`
--
ALTER TABLE `student_taking_lasson`
  ADD CONSTRAINT `student_taking_lasson_ibfk_1` FOREIGN KEY (`students_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_taking_lasson_ibfk_2` FOREIGN KEY (`lessons_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
