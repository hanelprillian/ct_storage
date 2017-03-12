-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 27, 2014 at 06:10 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ct_storage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings_extensions`
--

CREATE TABLE IF NOT EXISTS `admin_settings_extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ext_name` varchar(50) DEFAULT '0',
  `ext_mime_type` varchar(225) DEFAULT '0',
  `status` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `admin_settings_extensions`
--

INSERT INTO `admin_settings_extensions` (`id`, `ext_name`, `ext_mime_type`, `status`) VALUES
(2, 'png', 'image/png', '1'),
(3, 'jpe', 'image/jpeg', '1'),
(4, 'jpeg', 'image/jpeg', '1'),
(5, 'jpg', 'image/jpeg', '1'),
(6, 'gif', 'image/gif', '1'),
(7, 'bmp', 'image/bmp', '1'),
(8, 'ico', 'image/vnd.microsoft.icon', '1'),
(9, 'tiff', 'image/tiff', '1'),
(10, 'tif', 'image/tiff', '1'),
(11, 'svg', 'image/svg+xml', '1'),
(12, 'svgz', 'image/svg+xml', '1'),
(13, 'zip', 'application/zip', '1'),
(14, 'rar', 'application/octet-stream', '1'),
(15, 'exe', 'application/x-msdownload', '1'),
(16, 'msi', 'application/x-msdownload', '1'),
(17, 'cab', 'application/vnd.ms-cab-compressed', '1'),
(18, 'pdf', 'application/pdf', '1'),
(19, 'psd', 'image/vnd.adobe.photoshop', '1'),
(20, 'ai', 'application/postscript', '1'),
(21, 'eps', 'application/postscript', '1'),
(22, 'ps', 'application/postscript', '1'),
(23, 'doc', 'application/msword', '1'),
(24, 'docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '1'),
(25, 'rtf', 'application/rtf', '1'),
(26, 'xls', 'application/vnd.ms-excel', '1'),
(27, 'ppt', 'application/vnd.ms-powerpoint', '1');

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings_users_bandwith`
--

CREATE TABLE IF NOT EXISTS `admin_settings_users_bandwith` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `space_for_users` bigint(20) DEFAULT NULL,
  `size_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin_settings_users_bandwith`
--

INSERT INTO `admin_settings_users_bandwith` (`id`, `space_for_users`, `size_by`) VALUES
(1, 1024, 'MB');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `ip_address` varchar(50) DEFAULT NULL,
  `total` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`ip_address`, `total`) VALUES
('202.62.16.72', 0),
('124.137.210.48', 0),
('39.215.204.168', 0),
('::1', 0),
('::1', 0),
('39.217.105.153', 0),
('202.62.16.72', 0),
('124.137.210.48', 0),
('39.215.204.168', 0),
('::1', 0),
('202.62.16.72', 0),
('124.137.210.48', 0),
('39.215.204.168', 0),
('::1', 0),
('66.249.80.63', 0),
('202.62.16.72', 0),
('124.137.210.48', 0),
('39.215.204.168', 0),
('114.4.21.197', 0),
('110.138.66.48', 0),
('202.152.202.70', 0),
('202.152.204.193', 0),
('202.62.16.38', 0),
('202.152.204.158', 0),
('202.62.16.72', 0),
('124.137.210.48', 0),
('39.215.204.168', 0),
('::1', 0),
('36.75.106.60', 0),
('202.152.205.6', 0),
('202.62.16.72', 0),
('124.137.210.48', 0),
('39.215.204.168', 0),
('::1', 0),
('114.79.55.132', 0),
('202.152.204.206', 0),
('114.79.13.184', 3),
('112.215.66.70', 0),
('112.215.66.68', 0),
('112.215.66.73', 0),
('202.152.205.125', 0),
('202.152.204.24', 0),
('202.152.205.151', 0),
('192.168.222.1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings_`
--

CREATE TABLE IF NOT EXISTS `settings_` (
  `bandwith_per_user` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sharing_subscriber`
--

CREATE TABLE IF NOT EXISTS `sharing_subscriber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_subscriber` int(11) DEFAULT NULL,
  `folder_name` varchar(200) DEFAULT NULL,
  `folder_sharing` varchar(200) DEFAULT NULL,
  `root_user` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `permission` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `sharing_subscriber`
--

INSERT INTO `sharing_subscriber` (`id`, `id_user`, `id_subscriber`, `folder_name`, `folder_sharing`, `root_user`, `status`, `permission`) VALUES
(19, 50, 51, 'dokumen osis', 'dokumen osis/', 'hanel', 1, 'r'),
(21, 50, 52, 'kas', 'kas/kas/', 'hanel', 1, 'r'),
(23, 51, 52, 'testing', 'testing/', 'user2', 1, 'r'),
(24, 52, 50, 'akakka', 'akakka/', 'user3', 1, 'r'),
(25, 50, 52, 'DOKUMEN KEUANGAN', 'DOKUMEN KEUANGAN/', 'hanel', 1, 'r'),
(26, 50, 52, 'dokumen CT', 'dokumen CT/', 'hanel', 0, 'r'),
(27, 50, 36, 'TEST SHARING FOLDER', 'TEST SHARING FOLDER/', 'hanel', 0, 'r');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `fullname` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `address` text,
  `photo` varchar(225) DEFAULT NULL,
  `role` varchar(225) DEFAULT NULL,
  `root_file` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `address`, `photo`, `role`, `root_file`) VALUES
(1, 'admin', 'a5542ba4d359ae1a0f7794b51559e436', 'Admin Website', 'admin@admin.com', 'CT', 'img/1926943_856570084405949_2348895608329975969_n.jpg', '1', NULL),
(78, 'test', 'f1f616168eb8426fff7d05744d217583', 'Hanel', 'hahahah@dadsa.com', '', 'img/1926943_856570084405949_2348895608329975969_n.jpg', '2', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `user_public_links`
--

CREATE TABLE IF NOT EXISTS `user_public_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `ref_code` varchar(50) DEFAULT NULL,
  `file_name` text,
  `file_path` text,
  `user_path` text,
  `date` date DEFAULT NULL,
  `downloaded` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user_public_links`
--

INSERT INTO `user_public_links` (`id`, `id_user`, `ref_code`, `file_name`, `file_path`, `user_path`, `date`, `downloaded`) VALUES
(1, 63, '647ffb5201', 'BdvoGlDCMAAK11A.jpg', 'root_storage_file/users/user3/', 'user3', '2014-03-04', 1),
(2, 63, 'e6ee73b574', '.jpg', 'root_storage_file/users/user3/', 'user3', '2014-03-04', 0),
(12, 78, '41c4f7d55b', 'zukimac_by_vinceliuice-d7mqbmc.zip', 'root_storage_file/users/test/', 'test', '2014-10-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_recent_activity`
--

CREATE TABLE IF NOT EXISTS `user_recent_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `name` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=591 ;

--
-- Dumping data for table `user_recent_activity`
--

INSERT INTO `user_recent_activity` (`id`, `id_user`, `date`, `action`, `type`, `name`) VALUES
(5, 50, '2014-02-28 04:32:53', 'Copy', 'File', '<u>Connectivity Pro baru 1.rar</u> to <u>blabla/</u>'),
(6, 50, '2014-02-28 04:36:48', 'Rename', 'Folder', '<u>root_storage_file/users/hanel/blabla/</u> to <u>HANEL//</u>'),
(7, 50, '2014-02-28 04:38:48', 'Rename', 'Folder', '<u>HANEL/</u> to <u>HANEL PRILLIAN/</u>'),
(8, 50, '2014-02-28 04:42:38', 'Copy', 'Folder', '<u>HANEL PRILLIAN/</u> to <u>HANEL PRILLIAN/barubaru/kasssssasasa/</u>'),
(9, 50, '2014-02-28 06:44:41', 'Delete', 'File', '<u>root_storage_file/users/hanel/cengo.jpg</u>'),
(10, 50, '2014-02-28 06:46:01', 'Delete', 'File', '<u>dasboard.jpg</u>'),
(11, 50, '2014-02-28 06:49:03', 'Delete', 'File', '<u>wew.zip</u> from <u>root_storage_file/users/hanel/</u>'),
(12, 50, '2014-02-28 06:51:08', 'Delete', 'File', '<b>wew.rar</b> from <b>hanel/</b>'),
(13, 50, '2014-02-28 06:52:57', 'Delete', 'File', '<b>Connectivity Pro baru 1.rar</b> from <b>hanel/HANEL PRILLIAN/</b>'),
(14, 50, '2014-02-28 06:57:05', 'Delete', 'Folder', '<b>root_storage_file/users/hanel/kasusa/</b> from <b>root_storage_file/users/hanel/kasusa/</b>'),
(15, 50, '2014-02-28 06:59:48', 'Delete', 'Folder', '<b>kaskusad</b> from <b>root_storage_file/users/hanel/kaskusad/</b>'),
(16, 50, '2014-02-28 07:07:55', 'Delete', 'Folder', '<b>kas</b> from <b></b>'),
(17, 50, '2014-02-28 07:08:39', 'Delete', 'Folder', '<b>wew</b> from <b></b>'),
(18, 50, '2014-02-28 07:11:28', 'Delete', 'Folder', '<b>fsdfdsfsd</b> from <b>/</b>'),
(19, 50, '2014-02-28 07:11:48', 'Delete', 'Folder', '<b>HANEL PRILLIAN/barubaru</b> from <b>/</b>'),
(20, 50, '2014-02-28 07:13:21', 'Delete', 'Folder', '<b>test</b> from <b>HANEL PRILLIAN//</b>'),
(21, 50, '2014-02-28 07:14:51', 'Delete', 'Folder', '<b>fdsfdsfsdfds</b> from <b>hanel/HANEL PRILLIAN//</b>'),
(22, 50, '2014-02-28 07:15:59', 'Delete', 'Folder', '<b>dsdsds</b> from <b>hanel/HANEL PRILLIAN/DOKUMEN ORGANISASI</b>'),
(23, 50, '2014-02-28 07:16:27', 'Delete', 'Folder', '<b>dsdsdsfdsf</b> from <b>hanel</b>'),
(24, 50, '2014-02-28 07:17:31', 'Delete', 'Folder', '<b>fksdfjdskfjsd</b> from <b>hanel//</b>'),
(25, 50, '2014-02-28 07:19:17', 'Delete', 'Folder', '<b>gfdgfdgd</b> from <b>hanel/</b>'),
(26, 50, '2014-02-28 07:19:44', 'Delete', 'Folder', '<b>gfdgfdgfdgdfgfd</b> from <b>hanel/HANEL PRILLIAN/DOKUMEN ORGANISASI/</b>'),
(27, 50, '2014-02-28 07:23:10', 'Rename', 'File', '<u>2Fast2FuriousBrianOConnersSkylineR34GTRBlueLight.jpg</u> to <u>suka gua.jpg/</u>'),
(28, 50, '2014-02-28 07:24:09', 'Rename', 'File', '<b>214bca81cd7f9a35abbe4566768f9035.jpeg</b> to <b>Yang baru.jpeg</b>'),
(29, 50, '2014-02-28 07:26:06', 'Rename', 'Folder', '<b>HANEL PRILLIAN/</b> to <b>HANEL PRILLIAN 2/</b>'),
(30, 50, '2014-02-28 07:27:48', 'Copy', 'Folder', '<u>DOKUMEN KEUANGAN/</u> to <u>HANEL PRILLIAN 2/</u>'),
(31, 50, '2014-02-28 07:28:35', 'Copy', 'Folder', '<b>DOKUMEN KEUANGAN/</b> to <b>HANEL PRILLIAN 2/DOKUMEN ORGANISASI/</b>'),
(32, 50, '2014-02-28 07:31:22', 'Create', 'Folder', '<b>kasih gak tau</b> in <b>root_storage_file/users/hanel//</b>'),
(33, 50, '2014-02-28 07:31:52', 'Create', 'Folder', '<b>wewww</b> in <b>root_storage_file/users/hanel/kasih gak tau//</b>'),
(34, 50, '2014-02-28 07:33:12', 'Create', 'Folder', '<b>fdfdfdfd</b> in <b>root_storage_file/users/hanel/</b>'),
(35, 50, '2014-02-28 07:34:06', 'Create', 'Folder', '<b>ddddd</b> in <b>hanel/</b>'),
(36, 50, '2014-02-28 07:34:53', 'Create', 'Folder', '<b>dsdsdsdsadsada</b> in <b>/</b>'),
(37, 50, '2014-02-28 07:35:45', 'Create', 'Folder', '<b>fsdfdssd</b> in <b>(Your Root)/</b>'),
(38, 50, '2014-02-28 07:37:40', 'Delete', 'Folder', '<b>dsdsdsdsadsada</b> from <b>(Your Root)/</b>'),
(39, 50, '2014-02-28 07:38:00', 'Create', 'Folder', '<b>fff</b> in <b>(Your Root)/DOKUMEN ORGANISASI/</b>'),
(40, 50, '2014-02-28 07:38:06', 'Delete', 'Folder', '<b>fff</b> from <b>(Your Root)/DOKUMEN ORGANISASI/</b>'),
(41, 50, '2014-02-28 07:39:14', 'Copy', 'File', '<u>BdvrnARCEAE0GqU.jpg</u> to <u>(Your Root)/DOKUMEN ORGANISASI/</u>'),
(42, 50, '2014-02-28 07:39:57', 'Copy', 'File', '<b>Yang baru.jpeg</b> to <b>(Your Root)/kasih gak tau/wewww/</b>'),
(43, 50, '2014-02-28 07:41:20', 'Delete', 'File', '<b>Yang baru.jpeg</b> from <b>(Your Root)/kasih gak tau/wewww/</b>'),
(44, 50, '2014-02-28 07:43:12', 'Copy', 'Folder', '<b>ddddd/</b> to <b>(Your Root)/DOKUMEN KEUANGAN/</b>'),
(45, 50, '2014-02-28 07:44:43', 'Create', 'Folder', '<b>tas</b> in <b>(Your Root)/ddddd/</b>'),
(46, 50, '2014-02-28 07:46:26', 'Delete', 'File', '<b>29083_122411307774856_792013_n.jpg</b> from <b>(Your Root)/</b>'),
(47, 50, '2014-02-28 07:49:21', 'Delete', 'Folder', '<b>ddddd</b> from <b>(Your Root)/</b>'),
(48, 50, '2014-02-28 07:49:21', 'Delete', 'Folder', '<b>fdfdfdfd</b> from <b>(Your Root)/</b>'),
(49, 50, '2014-02-28 07:49:21', 'Delete', 'Folder', '<b>fsdfdssd</b> from <b>(Your Root)/</b>'),
(50, 50, '2014-02-28 07:49:44', 'Delete', 'Folder', '<b>ddddd</b> from <b>(Your Root)/DOKUMEN KEUANGAN/</b>'),
(51, 50, '2014-02-28 07:49:44', 'Delete', 'Folder', '<b>kassss</b> from <b>(Your Root)/DOKUMEN KEUANGAN/</b>'),
(52, 50, '2014-02-28 07:51:40', 'Delete', 'File', '<b>Connectivity Pro baru 1.rar</b> from <b>(Your Root)/</b>'),
(53, 50, '2014-02-28 07:51:40', 'Delete', 'File', '<b>Pencatatan transaksi baran1.docx</b> from <b>(Your Root)/</b>'),
(54, 50, '2014-02-28 07:51:40', 'Delete', 'File', '<b>raport-online.zip</b> from <b>(Your Root)/</b>'),
(55, 50, '2014-02-28 07:51:40', 'Delete', 'File', '<b>suka gua.jpg</b> from <b>(Your Root)/</b>'),
(56, 50, '2014-02-28 07:51:40', 'Delete', 'File', '<b>Yang baru.jpeg</b> from <b>(Your Root)/</b>'),
(57, 50, '2014-02-28 07:52:09', 'Delete', 'File', '<b>Pencatatan transaksi baran1.docx</b> from <b>(Your Root)/DOKUMEN KEUANGAN/</b>'),
(58, 50, '2014-02-28 07:57:46', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b>root_storage_file/users/hanel/BdvrnARCEAE0GqU.jpg/</b>'),
(59, 50, '2014-02-28 08:00:13', 'Upload', 'File', '<b>wew.zip</b> to <b>/</b>'),
(60, 50, '2014-02-28 08:01:15', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b>BdvqKKyCYAA2A13.jpg/</b>'),
(61, 50, '2014-02-28 08:03:02', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b>(Your Root)//</b>'),
(62, 50, '2014-02-28 08:03:54', 'Upload', 'File', '<b>2-Fast-2-Furious-Brian-OConners-Skyline-R34-GT-R-Blue-Light.jpg</b> to <b>(Your Root)//</b>'),
(63, 50, '2014-02-28 08:04:52', 'Delete', 'File', '<b>2-Fast-2-Furious-Brian-OConners-Skyline-R34-GT-R-Blue-Light.jpg</b> from <b>(Your Root)/</b>'),
(64, 50, '2014-02-28 08:04:52', 'Delete', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> from <b>(Your Root)/</b>'),
(65, 50, '2014-02-28 08:04:52', 'Delete', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> from <b>(Your Root)/</b>'),
(66, 50, '2014-02-28 08:04:52', 'Delete', 'File', '<b>wew.zip</b> from <b>(Your Root)/</b>'),
(67, 50, '2014-02-28 08:05:02', 'Upload', 'File', '<b>2-Fast-2-Furious-Brian-OConners-Skyline-R34-GT-R-Blue-Light.jpg</b> to <b>(Your Root)/</b>'),
(68, 50, '2014-02-28 08:05:49', 'Upload', 'File', '<b>tugas wawancara kwh.docx</b> to <b>(Your Root)/DOKUMEN KEUANGAN/</b>'),
(69, 50, '2014-02-28 08:06:44', 'Upload', 'File', '<b>tugas wawancara kwh.docx</b> to <b>(Your Root)/</b>'),
(70, 50, '2014-02-28 08:06:44', 'Upload', 'File', '<b>tugas jakom hanel.docx</b> to <b>(Your Root)/</b>'),
(71, 50, '2014-02-28 08:06:44', 'Upload', 'File', '<b>Pola Pengembangan.docx</b> to <b>(Your Root)/</b>'),
(72, 50, '2014-02-28 08:17:05', 'Create', 'Public Link', '<b>2-Fast-2-Furious-Brian-OConners-Skyline-R34-GT-R-Blue-Light.jpg</b>'),
(73, 50, '2014-02-28 08:21:24', 'Create', 'Folder', '<b>LATIHAN</b> in <b>(Your Root)/</b>'),
(74, 50, '2014-02-28 08:30:12', 'Delete', 'File', '<b>2-Fast-2-Furious-Brian-OConners-Skyline-R34-GT-R-Blue-Light.jpg</b> from <b><i class="fa fa-file"></i>/</b>'),
(75, 50, '2014-02-28 08:30:57', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b> <i class="fa fa-home"></i> /</b>'),
(76, 50, '2014-02-28 08:34:58', 'Create', 'Folder', '<b>HARI 2014</b> in <b> <i class="fa fa-home"></i> /DOKUMEN KEUANGAN/</b>'),
(77, 50, '2014-02-28 08:35:41', 'Delete', 'Folder', '<b>HARI 2014</b> from <b> <i class="fa fa-home"></i> /DOKUMEN KEUANGAN/</b>'),
(78, 50, '2014-02-28 08:36:50', 'Delete', 'File', '<b>Pola Pengembangan.docx</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(79, 50, '2014-02-28 08:40:28', 'Copy', 'Folder', '<b>LATIHAN/</b> to <b> <i class="fa fa-home"></i>(Home) /DOKUMEN KEUANGAN/</b>'),
(80, 50, '2014-02-28 08:40:37', 'Delete', 'Folder', '<b>LATIHAN</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(81, 50, '2014-02-28 08:40:46', 'Rename', 'Folder', '<b>kasih gak tau/</b> to <b>kasih gak tau ya/</b>'),
(82, 50, '2014-02-28 08:43:45', 'Delete', 'Public Link', '<b></b>'),
(83, 50, '2014-02-28 08:45:12', 'Delete', 'Public Link', '<b></b>'),
(84, 50, '2014-02-28 08:46:30', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(85, 50, '2014-02-28 08:46:45', 'Delete', 'Public Link', '<b></b>'),
(86, 50, '2014-02-28 08:48:11', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(87, 50, '2014-02-28 08:48:22', 'Delete', 'Public Link', '<b></b>'),
(88, 50, '2014-02-28 08:49:49', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(89, 50, '2014-02-28 08:49:56', 'Delete', 'Public Link', '<b>4a4b185708</b>'),
(90, 50, '2014-02-28 08:50:55', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(91, 50, '2014-02-28 08:51:03', 'Create', 'Public Link', '<b>tugas jakom hanel.docx</b>'),
(92, 50, '2014-02-28 08:51:11', 'Create', 'Public Link', '<b>tugas wawancara kwh.docx</b>'),
(93, 50, '2014-02-28 08:52:27', 'Delete', 'Public Link', '<b></b>'),
(94, 50, '2014-02-28 08:54:50', 'Delete', 'Public Link', ''),
(95, 50, '2014-02-28 13:28:06', 'Delete', 'Public Link', ''),
(96, 50, '2014-02-28 13:28:26', 'Delete', 'Folder', '<b>kasih gak tau ya</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(97, 50, '2014-02-28 13:39:57', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(98, 50, '2014-02-28 13:40:14', 'Delete', 'Public Link', '<b></b>'),
(99, 50, '2014-02-28 13:41:12', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(100, 50, '2014-02-28 13:41:24', 'Delete', 'Public Link', '<b></b>'),
(101, 50, '2014-02-28 13:44:17', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(102, 50, '2014-02-28 13:44:40', 'Delete', 'Public Link', '<b>31</b>'),
(103, 50, '2014-02-28 13:45:22', 'Create', 'Public Link', '<b>tugas jakom hanel.docx</b>'),
(104, 50, '2014-02-28 13:45:23', 'Create', 'Public Link', '<b>tugas wawancara kwh.docx</b>'),
(105, 50, '2014-02-28 13:45:24', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(106, 50, '2014-02-28 13:45:40', 'Delete', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(107, 50, '2014-02-28 13:45:52', 'Delete', 'Public Link', '<b>tugas wawancara kwh.docx</b>'),
(108, 50, '2014-02-28 13:45:55', 'Delete', 'Public Link', '<b>tugas jakom hanel.docx</b>'),
(109, 50, '2014-02-28 14:12:41', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(110, 50, '2014-02-28 14:12:44', 'Create', 'Public Link', '<b>tugas wawancara kwh.docx</b>'),
(111, 50, '2014-02-28 14:12:52', 'Delete', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(112, 50, '2014-02-28 14:13:09', 'Delete', 'Public Link', '<b>tugas wawancara kwh.docx</b>'),
(113, 50, '2014-02-28 15:12:26', 'Create', 'Folder', '<b>DOKUMEN KEUANGAN</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(114, 50, '2014-02-28 15:48:22', 'Share', 'Folder', '<b>DOKUMEN ORGANISASI</b> to user email account <b>user3@user3.com</b>'),
(115, 50, '2014-02-28 15:52:27', 'Share', 'Folder', '<b>hhe</b> to user email account <b>user3@user3.com</b>'),
(117, 50, '2014-03-01 13:28:08', 'Share', 'Folder', '<b>LATIHAN</b> to user email account <b>user3@user3.com</b>'),
(118, 50, '2014-03-01 13:39:29', 'Stop Share', 'Folder', '<b>LATIHAN</b> from user email account <b>hanelprillian@rocketmail.com</b>'),
(119, 50, '2014-03-01 13:40:25', 'Stop Share', 'Folder', '<b>hhe</b> from user email account <b>user3@user3.com</b>'),
(120, 50, '2014-03-02 08:32:21', 'Stop Share', 'Folder', '<b>DOKUMEN ORGANISASI</b> from user email account <b>user3@user3.com</b>'),
(121, 50, '2014-03-02 08:32:54', 'Share', 'Folder', '<b>HANEL PRILLIAN 2</b> to user email account <b>user3@user3.com</b>'),
(122, 50, '2014-03-02 08:47:21', 'Create', 'Public Link', '<b>Connectivity Pro.rar</b>'),
(131, 50, '2014-03-02 14:06:58', 'Upload', 'File', '<b>184431_530731346952143_1778134281_n.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /DOKUMEN KEUANGAN/</b>'),
(132, 50, '2014-03-02 14:06:58', 'Upload', 'File', '<b>541774_530730296952248_1980336907_n.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /DOKUMEN KEUANGAN/</b>'),
(133, 50, '2014-03-02 14:06:58', 'Upload', 'File', '<b>cengo.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /DOKUMEN KEUANGAN/</b>'),
(139, 50, '2014-03-03 02:53:41', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(140, 50, '2014-03-03 02:53:41', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(141, 50, '2014-03-03 02:53:41', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(142, 50, '2014-03-03 02:53:41', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(143, 50, '2014-03-03 02:53:41', 'Upload', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(144, 50, '2014-03-03 02:53:41', 'Upload', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(145, 50, '2014-03-03 02:53:41', 'Upload', 'File', '<b>wew.zip</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(146, 50, '2014-03-03 03:06:46', 'Delete', 'Folder', '<b>dokumen osis</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(147, 50, '2014-03-03 03:07:32', 'Create', 'Folder', '<b>DOKUMEN HANEL</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(148, 50, '2014-03-03 03:09:51', 'Stop Share', 'Folder', '<b>DOKUMEN KEUANGAN</b> from user email account <b>user3@user3.com</b>'),
(149, 50, '2014-03-03 03:09:54', 'Stop Share', 'Folder', '<b>HANEL PRILLIAN 2</b> from user email account <b>user3@user3.com</b>'),
(153, 63, '2014-03-04 14:48:07', 'Create', 'Folder', '<b>Test</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(154, 63, '2014-03-04 14:51:21', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(155, 63, '2014-03-04 14:51:21', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(156, 63, '2014-03-04 14:51:22', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(157, 63, '2014-03-04 14:51:22', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(158, 63, '2014-03-04 14:51:22', 'Upload', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(159, 63, '2014-03-04 14:53:17', 'Upload', 'File', '<b>2072-P1-SPK-Rekayasa Perangkat Lunak (1).docx</b> to <b> <i class="fa fa-home"></i>(Home) /Test/</b>'),
(160, 63, '2014-03-04 14:54:42', 'Create', 'Public Link', '<b>BdvoGlDCMAAK11A.jpg</b>'),
(161, 63, '2014-03-04 14:57:19', 'Rename', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b>.jpg</b>'),
(162, 63, '2014-03-04 14:57:35', 'Create', 'Public Link', '<b>.jpg</b>'),
(163, 63, '2014-03-04 14:58:25', 'Rename', 'File', '<b>.jpg</b> to <b>.jpg</b>'),
(164, 63, '2014-03-04 14:58:32', 'Rename', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b>.jpg</b>'),
(165, 63, '2014-03-04 14:58:41', 'Rename', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b>.jpg</b>'),
(166, 63, '2014-03-04 14:59:35', 'Create', 'Folder', '<b>kakka</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(167, 63, '2014-03-04 14:59:41', 'Rename', 'Folder', '<b>kakka/</b> to <b>/</b>'),
(168, 63, '2014-03-04 14:59:49', 'Rename', 'Folder', '<b>kakka/</b> to <b>/</b>'),
(169, 63, '2014-03-04 15:02:55', 'Rename', 'File', '<b>.jpg</b> to <b>&amp;lt;a href=&amp;quot;www.facebook.com&amp;quot;&amp;gt;yoy&amp;lt;a&amp;gt;.jpg</b>'),
(170, 63, '2014-03-04 15:03:20', 'Rename', 'File', '<b>.jpg</b> to <b>&amp;lt;b&amp;gt;awww&amp;lt;b&amp;gt;.jpg</b>'),
(171, 63, '2014-03-04 15:04:05', 'Create', 'Folder', '<b>&amp;lt;b&amp;gt;awww&amp;lt;b&amp;gt;</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(172, 63, '2014-03-04 15:04:26', 'Create', 'Folder', '<b>&amp;amp;lt;b&amp;amp;gt;awww&amp;amp;lt;b&amp;amp;gt;</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(173, 63, '2014-03-04 15:06:05', 'Delete', 'File', '<b></b> from <b> <i class="fa fa-home"></i>(Home) /&lt;b&gt;awww&lt;b&gt;/</b>'),
(174, 63, '2014-03-04 15:06:11', 'Delete', 'Folder', '<b>kakka</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(175, 63, '2014-03-04 15:07:00', 'Delete', 'File', '<b>&lt;b&gt;awww&lt;b&gt;.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(176, 63, '2014-03-04 15:07:13', 'Delete', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(177, 63, '2014-03-04 15:14:02', 'Delete', 'Folder', '<b>&amp;lt;b&amp;gt;awww&amp;lt;b&amp;gt;</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(178, 63, '2014-03-04 15:14:05', 'Share', 'Folder', '<b></b> to user email account <b>hanelprillian@rocketmail.com</b>'),
(179, 63, '2014-03-04 15:14:14', 'Stop Share', 'Folder', '<b></b> from user email account <b>hanelprillian@rocketmail.com</b>'),
(180, 63, '2014-03-04 15:19:39', 'Copy', 'Folder', '<b>Test/</b> to <b> <i class="fa fa-home"></i>(Home) /Test/</b>'),
(181, 63, '2014-03-04 15:41:32', 'Delete', 'File', '<b>&lt;b&gt;awww&lt;b&gt;.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(182, 50, '2014-03-04 07:53:40', 'Create', 'Public Link', '<b>BdxXCcyCQAA-bj9.jpg</b>'),
(183, 50, '2014-03-04 07:54:03', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b></b>'),
(184, 50, '2014-03-04 07:54:21', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b></b>'),
(185, 50, '2014-03-04 07:54:27', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b></b>'),
(186, 50, '2014-03-04 07:55:23', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(187, 50, '2014-03-04 07:55:31', 'Delete', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(188, 50, '2014-03-04 07:55:44', 'Delete', 'File', '<b>Connectivity Pro.rar</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(189, 50, '2014-03-04 07:56:01', 'Copy', 'File', '<b>tugas wawancara kwh.docx</b> to <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(190, 50, '2014-03-04 07:56:07', 'Create', 'Public Link', '<b>tugas wawancara kwh.docx</b>'),
(191, 50, '2014-03-04 07:56:23', 'Delete', 'File', '<b>tugas wawancara kwh.docx</b> from <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(192, 50, '2014-03-04 07:57:09', 'Create', 'Folder', '<b>kaskus</b> in <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(193, 50, '2014-03-04 07:57:36', 'Share', 'Folder', '<b>kaskus</b> to user email account <b>user3@user3.com</b>'),
(194, 50, '2014-03-04 07:58:07', 'Rename', 'Folder', '<b>kaskisddd/kaskus/</b> to <b>kaskuss/</b>'),
(195, 50, '2014-03-04 07:58:10', 'Rename', 'Folder', '<b>kaskisddd/kaskus/</b> to <b>kaskuss/</b>'),
(196, 50, '2014-03-04 07:58:21', 'Delete', 'Folder', '<b>kaskuss</b> from <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(197, 50, '2014-03-04 07:58:41', 'Delete', 'Public Link', '<b>tugas wawancara kwh.docx</b>'),
(198, 50, '2014-03-04 07:58:59', 'Copy', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(199, 50, '2014-03-04 07:59:05', 'Create', 'Public Link', '<b>wew.rar</b>'),
(200, 50, '2014-03-04 08:01:03', 'Delete', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(201, 50, '2014-03-04 08:01:19', 'Delete', 'File', '<b>wew.rar</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(202, 50, '2014-03-04 08:01:41', 'Delete', 'File', '<b>wew.rar</b> from <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(203, 50, '2014-03-04 08:03:35', 'Copy', 'File', '<b>wew.zip</b> to <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(204, 50, '2014-03-04 08:03:46', 'Delete', 'Public Link', '<b>wew.rar</b>'),
(205, 50, '2014-03-04 08:03:58', 'Create', 'Public Link', '<b>tugas wawancara kwh.docx</b>'),
(206, 50, '2014-03-04 08:04:12', 'Create', 'Public Link', '<b>wew.zip</b>'),
(207, 50, '2014-03-04 08:04:31', 'Delete', 'File', '<b>wew.zip</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(208, 50, '2014-03-04 08:04:43', 'Delete', 'File', '<b>tugas wawancara kwh.docx</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(209, 50, '2014-03-04 08:05:06', 'Delete', 'File', '<b>wew.zip</b> from <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(210, 50, '2014-03-04 08:05:16', 'Delete', 'Public Link', '<b>wew.zip</b>'),
(211, 50, '2014-03-04 08:07:00', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(212, 50, '2014-03-04 08:07:00', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(213, 50, '2014-03-04 08:07:00', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(214, 50, '2014-03-04 08:07:00', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(215, 50, '2014-03-04 08:07:00', 'Upload', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(216, 50, '2014-03-04 08:07:00', 'Upload', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(217, 50, '2014-03-04 08:07:00', 'Upload', 'File', '<b>wew.zip</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(218, 50, '2014-03-04 08:07:26', 'Create', 'Public Link', '<b>BdvoGlDCMAAK11A.jpg</b>'),
(219, 50, '2014-03-04 08:13:46', 'Delete', 'Folder', '<b>hanel234</b> from <b> <i class="fa fa-home"></i>(Home) /wewewew/</b>'),
(220, 50, '2014-03-04 08:14:08', 'Copy', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(221, 50, '2014-03-04 08:14:15', 'Create', 'Public Link', '<b>wew.rar</b>'),
(222, 50, '2014-03-04 08:17:50', 'Delete', 'File', '<b>wew.rar</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(223, 50, '2014-03-04 08:18:07', 'Delete', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(224, 50, '2014-03-04 08:18:24', 'Delete', 'File', '<b>wew.rar</b> from <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(225, 50, '2014-03-04 08:20:59', 'Copy', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(226, 50, '2014-03-04 08:21:13', 'Copy', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /kaskisddd/</b>'),
(227, 50, '2014-03-04 08:21:22', 'Create', 'Public Link', '<b>BdvoGlDCMAAK11A_2.jpg</b>'),
(228, 50, '2014-03-04 08:21:24', 'Create', 'Public Link', '<b>BdvqKKyCYAA2A13.jpg</b>'),
(229, 50, '2014-03-04 08:21:44', 'Create', 'Public Link', '<b>BdvoGlDCMAAK11A_2.jpg</b>'),
(230, 50, '2014-03-04 08:21:45', 'Create', 'Public Link', '<b>BdvqKKyCYAA2A13.jpg</b>'),
(231, 50, '2014-03-04 08:21:46', 'Create', 'Public Link', '<b>BdvrnARCEAE0GqU.jpg</b>'),
(232, 50, '2014-03-04 08:25:25', 'Create', 'Folder', '<b>fjdsfdhfgjdfkgd</b> in <b> <i class="fa fa-home"></i>(Home) /wewewew/</b>'),
(233, 50, '2014-03-04 08:26:23', 'Copy', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /wewewew/</b>'),
(234, 50, '2014-03-04 08:26:33', 'Delete', 'Folder', '<b>wewewew</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(235, 50, '2014-03-04 08:34:04', 'Delete', 'Folder', '<b>kaskisddd</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(236, 50, '2014-03-04 08:34:44', 'Delete', 'Public Link', '<b>BdvqKKyCYAA2A13.jpg</b>'),
(237, 50, '2014-03-04 08:34:48', 'Delete', 'Public Link', '<b>BdvoGlDCMAAK11A_2.jpg</b>'),
(238, 50, '2014-03-04 08:35:14', 'Create', 'Folder', '<b>hehe</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(239, 50, '2014-03-04 08:35:22', 'Create', 'Folder', '<b>hehe</b> in <b> <i class="fa fa-home"></i>(Home) /hehe/</b>'),
(240, 50, '2014-03-04 08:35:36', 'Share', 'Folder', '<b>hehe</b> to user email account <b>user3@user3.com</b>'),
(241, 50, '2014-03-04 08:35:54', 'Delete', 'Folder', '<b>hehe</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(242, 50, '2014-03-04 08:36:14', 'Stop Share', 'Folder', '<b>hehe</b> from user email account <b>user3@user3.com</b>'),
(243, 50, '2014-03-04 08:43:59', 'Create', 'Folder', '<b>wewew</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(244, 50, '2014-03-04 08:44:08', 'Create', 'Folder', '<b>ahaha</b> in <b> <i class="fa fa-home"></i>(Home) /wewew/</b>'),
(245, 50, '2014-03-04 08:44:30', 'Share', 'Folder', '<b>ahaha</b> to user email account <b>user3@user3.com</b>'),
(246, 50, '2014-03-04 09:38:24', 'Delete', 'Folder', '<b>wewew</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(247, 50, '2014-03-04 09:51:30', 'Create', 'Folder', '<b>fsdfsdfsdfds</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(248, 50, '2014-03-04 09:51:34', 'Create', 'Folder', '<b>gdfgfdgdf</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(249, 50, '2014-03-04 09:51:41', 'Create', 'Folder', '<b>dsdfdsfgd</b> in <b> <i class="fa fa-home"></i>(Home) /fsdfsdfsdfds/</b>'),
(250, 50, '2014-03-04 09:51:56', 'Share', 'Folder', '<b>dsdfdsfgd</b> to user email account <b>user3@user3.com</b>'),
(251, 50, '2014-03-04 09:52:11', 'Share', 'Folder', '<b>gdfgfdgdf</b> to user email account <b>user3@user3.com</b>'),
(252, 50, '2014-03-04 09:52:31', 'Delete', 'Folder', '<b>fsdfsdfsdfds</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(253, 50, '2014-03-04 09:52:31', 'Delete', 'Folder', '<b>gdfgfdgdf</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(254, 50, '2014-03-04 09:52:31', 'Delete', 'Folder', '<b>gdfgfdgdf</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(255, 50, '2014-03-04 09:52:31', 'Delete', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(256, 50, '2014-03-04 09:52:31', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(257, 50, '2014-03-04 09:52:31', 'Delete', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(258, 50, '2014-03-04 09:52:31', 'Delete', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(259, 50, '2014-03-04 09:52:31', 'Delete', 'File', '<b>wew.zip</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(260, 50, '2014-03-04 09:54:51', 'Create', 'Folder', '<b>wew</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(261, 50, '2014-03-04 09:54:56', 'Create', 'Folder', '<b>dsdsds</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(262, 50, '2014-03-04 09:55:02', 'Create', 'Folder', '<b>fdsfgfd</b> in <b> <i class="fa fa-home"></i>(Home) /dsdsds/</b>'),
(263, 50, '2014-03-04 09:55:19', 'Share', 'Folder', '<b>fdsfgfd</b> to user email account <b>user3@user3.com</b>'),
(264, 50, '2014-03-04 09:55:41', 'Share', 'Folder', '<b>wew</b> to user email account <b>user3@user3.com</b>'),
(265, 50, '2014-03-04 09:56:03', 'Delete', 'Folder', '<b>dsdsds</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(266, 50, '2014-03-04 09:56:19', 'Delete', 'Folder', '<b>wew</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(267, 50, '2014-03-04 10:05:44', 'Create', 'Folder', '<b>gfgfgf</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(268, 50, '2014-03-04 10:09:10', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /gfgfgf/</b>'),
(269, 50, '2014-03-04 10:09:10', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /gfgfgf/</b>'),
(270, 50, '2014-03-04 10:09:10', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /gfgfgf/</b>'),
(271, 50, '2014-03-04 10:09:10', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /gfgfgf/</b>'),
(272, 50, '2014-03-04 10:09:10', 'Upload', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /gfgfgf/</b>'),
(273, 50, '2014-03-04 10:09:10', 'Upload', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /gfgfgf/</b>'),
(274, 50, '2014-03-04 10:09:11', 'Upload', 'File', '<b>wew.zip</b> to <b> <i class="fa fa-home"></i>(Home) /gfgfgf/</b>'),
(282, 50, '2014-03-04 10:16:58', 'Share', 'Folder', '<b>gfgfgf</b> to user email account <b>user3@user3.com</b>'),
(283, 50, '2014-03-04 10:17:13', 'Create', 'Public Link', '<b>wew.zip</b>'),
(284, 50, '2014-03-04 10:17:14', 'Create', 'Public Link', '<b>wew.rar</b>'),
(285, 50, '2014-03-04 10:17:16', 'Create', 'Public Link', '<b>BdxXCcyCQAA-bj9.jpg</b>'),
(286, 50, '2014-03-04 10:17:17', 'Create', 'Public Link', '<b>BdvrnARCEAE0GqU.jpg</b>'),
(287, 50, '2014-03-04 10:17:18', 'Create', 'Public Link', '<b>BdvqKKyCYAA2A13.jpg</b>'),
(288, 50, '2014-03-04 10:17:19', 'Create', 'Public Link', '<b>BdvoGlDCMAAK11A_2.jpg</b>'),
(289, 50, '2014-03-04 10:17:20', 'Create', 'Public Link', '<b>BdvoGlDCMAAK11A.jpg</b>'),
(290, 50, '2014-03-04 10:17:53', 'Delete', 'Folder', '<b>gfgfgf</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(291, 50, '2014-03-04 10:17:53', 'Delete', 'Folder', '<b>gfgfgf</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(292, 50, '2014-03-04 10:18:58', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(293, 50, '2014-03-04 10:23:21', 'Create', 'Public Link', '<b>BdvoGlDCMAAK11A_2.jpg</b>'),
(294, 50, '2014-03-04 10:32:49', 'Create', 'Folder', '<b>ewew</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(295, 50, '2014-03-04 10:32:50', 'Create', 'Folder', '<b>ewew</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(296, 50, '2014-03-04 10:32:59', 'Copy', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /ewew/</b>'),
(297, 50, '2014-03-04 10:33:44', 'Rename', 'File', '<b>ewew/BdvoGlDCMAAK11A_2.jpg</b> to <b>BdvoGlDCMAAK11A_2fdfdfd.jpg</b>'),
(298, 50, '2014-03-04 12:43:53', 'Delete', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(299, 50, '2014-03-04 12:52:02', 'Create', 'Public Link', '<b>BdvoGlDCMAAK11A_2fdfdfd.jpg</b>'),
(300, 50, '2014-03-04 13:03:02', 'Rename', 'File', '<b>BdvoGlDCMAAK11A_2fdfdfd.jpg</b> to <b>hanel.jpg</b>'),
(301, 50, '2014-03-04 13:18:13', 'Create', 'Folder', '<b>kaskus</b> in <b> <i class="fa fa-home"></i>(Home) /ewew/</b>'),
(302, 50, '2014-03-04 13:18:40', 'Share', 'Folder', '<b>kaskus</b> to user email account <b>user3@user3.com</b>'),
(303, 50, '2014-03-04 13:20:24', 'Rename', 'Folder', '<b>ewew/</b> to <b>hanana/</b>'),
(304, 50, '2014-03-04 13:24:16', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(305, 50, '2014-03-04 13:24:16', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(306, 50, '2014-03-04 13:24:16', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(307, 50, '2014-03-04 13:24:16', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(308, 50, '2014-03-04 13:24:16', 'Upload', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(309, 50, '2014-03-04 13:24:16', 'Upload', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(310, 50, '2014-03-04 13:24:16', 'Upload', 'File', '<b>wew.zip</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(311, 50, '2014-03-04 13:24:22', 'Create', 'Public Link', '<b>BdvoGlDCMAAK11A.jpg</b>'),
(312, 50, '2014-03-04 13:24:35', 'Rename', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b>foto pantai.jpg</b>'),
(313, 50, '2014-03-04 13:56:20', 'Rename', 'File', '<b>hanel.jpg</b> to <b>hanel kedua.jpg</b>'),
(314, 50, '2014-03-04 15:22:03', 'Delete', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(315, 50, '2014-03-04 15:22:24', 'Rename', 'Folder', '<b>hanana/</b> to <b>/</b>'),
(316, 50, '2014-03-04 15:22:38', 'Rename', 'Folder', '<b>hanana/</b> to <b>&amp;lt;a&amp;gt;dadaad&amp;lt;a&amp;gt;/</b>'),
(317, 50, '2014-03-04 15:23:04', 'Rename', 'Folder', '<b><a>dadaad<a>/</b> to <b>&amp;lt;a&amp;gt;dadaad&amp;lt;a&amp;gt;/</b>'),
(318, 50, '2014-03-04 15:23:28', 'Rename', 'Folder', '<b><a>dadaad<a>/</b> to <b>&amp;lt;a&amp;gt;dadaad&amp;lt;a&amp;gt;/</b>'),
(319, 50, '2014-03-04 15:24:01', 'Rename', 'Folder', '<b><a>dadaad<a>/</b> to <b>&amp;lt;a&amp;gt;dadaad&amp;lt;a&amp;gt;/</b>'),
(320, 50, '2014-03-04 15:24:39', 'Rename', 'Folder', '<b><a>dadaad<a>/</b> to <b>&lt;a&gt;dadaad&lt;a&gt;/</b>'),
(321, 50, '2014-03-04 15:25:03', 'Rename', 'Folder', '<b><a>dadaad<a>/</b> to <b><a>dadaad<a>/</b>'),
(322, 50, '2014-03-04 15:25:40', 'Rename', 'Folder', '<b><a>dadaad<a>/</b> to <b><a>dadaad<a>sss/</b>'),
(323, 50, '2014-03-04 15:25:48', 'Rename', 'Folder', '<b><a>dadaad<a>/</b> to <b>wewewe/</b>'),
(324, 50, '2014-03-04 15:26:04', 'Create', 'Folder', '<b>fdsfdsfs</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(325, 50, '2014-03-04 15:26:31', 'Rename', 'Folder', '<b>fdsfdsfs/</b> to <b><a>dadaad<a>/</b>'),
(326, 50, '2014-03-04 15:27:01', 'Rename', 'Folder', '<b>fdsfdsfs/</b> to <b>&lt;a&gt;dadaad&lt;a&gt;/</b>'),
(327, 50, '2014-03-04 15:36:40', 'Create', 'Folder', '<b>ikkjk</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(328, 50, '2014-03-04 15:37:22', 'Rename', 'Folder', '<b>ikkjk/</b> to <b>dadaad/</b>'),
(329, 50, '2014-03-04 15:37:42', 'Rename', 'Folder', '<b>dadaad/</b> to <b>dadaadhanelganteng/</b>'),
(330, 50, '2014-03-04 15:41:44', 'Create', 'Folder', '<b>dadaad</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(331, 50, '2014-03-04 16:50:45', 'Create', 'Folder', '<b>alaladkka</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(332, 50, '2014-03-04 16:50:56', 'Copy', 'Folder', '<b>alaladkka/</b> to <b> <i class="fa fa-home"></i>(Home) /alaladkka/</b>'),
(344, 50, '2014-03-04 17:37:22', 'Share', 'Folder', '<b>dadaadhanelganteng</b> to user email account <b>user3@user3.com</b>'),
(345, 65, '2014-03-04 17:59:17', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(346, 65, '2014-03-04 17:59:17', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(347, 65, '2014-03-04 17:59:17', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(348, 65, '2014-03-04 17:59:17', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(349, 65, '2014-03-04 17:59:17', 'Upload', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(350, 65, '2014-03-04 17:59:17', 'Upload', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(351, 65, '2014-03-04 17:59:17', 'Upload', 'File', '<b>wew.zip</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(352, 65, '2014-03-05 02:55:54', 'Delete', 'Folder', '<b>please</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(353, 65, '2014-03-05 03:18:10', 'Rename', 'Folder', '<b>root_storage_file/users/hanel/dadaadhanelganteng/kasus/</b> to <b>kasus 2/</b>'),
(354, 65, '2014-03-05 03:18:27', 'Rename', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b>gambar jahanambul.jpg</b>'),
(355, 65, '2014-03-05 03:19:03', 'Delete', 'File', '<b>gambar jahanambul.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(356, 65, '2014-03-05 03:19:58', 'Delete', 'Folder', '<b>kasus 2</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(357, 65, '2014-03-05 03:22:07', 'Rename', 'Folder', '<b>root_storage_file/users/hanel/dadaadhanelganteng/test 3/wew/</b> to <b>wew anel/</b>'),
(358, 65, '2014-03-05 03:22:53', 'Rename', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b>yang mana ini.jpg</b>'),
(359, 65, '2014-03-05 03:50:35', 'Delete', 'File', '<b>wew.rar</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(360, 65, '2014-03-05 03:50:46', 'Delete', 'Folder', '<b>test 3</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(361, 65, '2014-03-05 03:55:59', 'Delete', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(362, 65, '2014-03-05 03:56:27', 'Delete', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(363, 65, '2014-03-05 03:58:40', 'Delete', 'File', '<b>wew.rar</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(364, 65, '2014-03-05 04:00:17', 'Delete', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(365, 65, '2014-03-05 04:02:14', 'Delete', 'File', '<b>wew.zip</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(366, 65, '2014-03-05 04:02:52', 'Delete', 'File', '<b>wew.zip</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(367, 65, '2014-03-05 04:03:00', 'Delete', 'File', '<b>wew.rar</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(368, 65, '2014-03-05 04:04:43', 'Delete', 'Folder', '<b>ngok</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(369, 65, '2014-03-05 04:07:09', 'Delete', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(370, 65, '2014-03-05 04:07:16', 'Delete', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(371, 65, '2014-03-05 04:08:27', 'Delete', 'Folder', '<b>dsdsds</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(372, 65, '2014-03-05 04:08:33', 'Delete', 'Folder', '<b>gfgfgf</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(373, 65, '2014-03-05 04:08:40', 'Delete', 'Folder', '<b>wewewe</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(374, 65, '2014-03-05 04:08:47', 'Delete', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(375, 65, '2014-03-05 04:09:53', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(376, 65, '2014-03-05 04:09:54', 'Delete', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/kaskuskaskus/</b>'),
(377, 65, '2014-03-05 04:13:08', 'Delete', 'Folder', '<b>kaskuskaskus</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(378, 65, '2014-03-05 04:13:08', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(379, 65, '2014-03-05 04:13:08', 'Delete', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(380, 65, '2014-03-05 04:13:08', 'Delete', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(381, 65, '2014-03-05 04:13:08', 'Delete', 'File', '<b>wew.zip</b> from <b>root_storage_file/users/hanel/dadaadhanelganteng/</b>'),
(382, 50, '2014-03-05 04:15:39', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /dadaadhanelganteng/</b>'),
(383, 50, '2014-03-05 04:15:39', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /dadaadhanelganteng/</b>'),
(384, 50, '2014-03-05 04:15:39', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /dadaadhanelganteng/</b>'),
(385, 50, '2014-03-05 04:15:39', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /dadaadhanelganteng/</b>'),
(386, 50, '2014-03-05 04:15:39', 'Upload', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /dadaadhanelganteng/</b>'),
(387, 50, '2014-03-05 04:15:39', 'Upload', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /dadaadhanelganteng/</b>'),
(388, 50, '2014-03-05 04:15:39', 'Upload', 'File', '<b>wew.zip</b> to <b> <i class="fa fa-home"></i>(Home) /dadaadhanelganteng/</b>'),
(389, 50, '2014-03-05 04:30:52', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(390, 50, '2014-03-05 04:30:52', 'Delete', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(391, 50, '2014-03-05 04:30:52', 'Delete', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(392, 50, '2014-03-05 04:30:52', 'Delete', 'File', '<b>foto pantai.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(393, 50, '2014-03-05 04:30:52', 'Delete', 'File', '<b>wew.rar</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(394, 50, '2014-03-05 04:30:52', 'Delete', 'File', '<b>wew.zip</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(395, 50, '2014-03-05 04:32:12', 'Delete', 'Folder', '<b>dadaadhanelganteng</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(396, 50, '2014-03-05 04:32:12', 'Delete', 'Folder', '<b>dadaadhanelganteng</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(397, 50, '2014-03-05 04:32:38', 'Delete', 'File', '<b>alaladkka</b> from <b> <i class="fa fa-home"></i>(Home) /dadaad/</b>'),
(398, 50, '2014-03-05 04:34:38', 'Share', 'Folder', '<b>alaladkka</b> to user email account <b>user3@user3.com</b>'),
(399, 50, '2014-03-05 04:35:09', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /alaladkka/</b>'),
(400, 50, '2014-03-05 04:35:09', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /alaladkka/</b>'),
(401, 50, '2014-03-05 04:35:09', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /alaladkka/</b>'),
(402, 50, '2014-03-05 04:35:09', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /alaladkka/</b>'),
(403, 50, '2014-03-05 04:35:09', 'Upload', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /alaladkka/</b>'),
(404, 50, '2014-03-05 04:35:09', 'Upload', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /alaladkka/</b>'),
(405, 50, '2014-03-05 04:35:09', 'Upload', 'File', '<b>wew.zip</b> to <b> <i class="fa fa-home"></i>(Home) /alaladkka/</b>'),
(406, 65, '2014-03-05 04:36:13', 'Delete', 'File', '<b>wew.rar</b> from <b>root_storage_file/users/hanel/alaladkka/</b>'),
(407, 65, '2014-03-05 04:36:19', 'Delete', 'Folder', '<b>alaladkka</b> from <b>root_storage_file/users/hanel/</b>'),
(408, 65, '2014-03-05 04:36:29', 'Rename', 'Folder', '<b>root_storage_file/users/hanel/alaladkka/fdsfsf/</b> to <b>kedua/</b>'),
(409, 65, '2014-03-05 04:36:40', 'Rename', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b>ketiga.jpg</b>'),
(410, 65, '2014-03-05 04:36:48', 'Delete', 'Folder', '<b>kedua</b> from <b>root_storage_file/users/hanel/alaladkka/</b>'),
(411, 65, '2014-03-05 04:36:48', 'Delete', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> from <b>root_storage_file/users/hanel/alaladkka/</b>'),
(412, 65, '2014-03-05 04:36:48', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b>root_storage_file/users/hanel/alaladkka/</b>'),
(413, 65, '2014-03-05 04:36:48', 'Delete', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> from <b>root_storage_file/users/hanel/alaladkka/</b>'),
(414, 65, '2014-03-05 04:36:48', 'Delete', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> from <b>root_storage_file/users/hanel/alaladkka/</b>'),
(415, 65, '2014-03-05 04:36:48', 'Delete', 'File', '<b>ketiga.jpg</b> from <b>root_storage_file/users/hanel/alaladkka/</b>'),
(416, 65, '2014-03-05 04:36:48', 'Delete', 'File', '<b>wew.zip</b> from <b>root_storage_file/users/hanel/alaladkka/</b>'),
(417, 50, '2014-03-05 04:55:20', 'Upload', 'File', '<b>hanel.php.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(418, 50, '2014-03-05 04:55:41', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(419, 50, '2014-03-05 04:55:41', 'Upload', 'File', '<b>hanel.php.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(420, 50, '2014-03-05 04:55:57', 'Upload', 'File', '<b>hanel.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(421, 50, '2014-03-05 05:04:31', 'Copy', 'Folder', '<b>alaladkka/</b> to <b>root_storage_file/users/user3/</b>'),
(422, 50, '2014-03-05 05:31:10', 'Create', 'Folder', '<b>ghghjg</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(423, 50, '2014-03-05 05:34:15', 'Delete', 'File', '<b></b> from <b>/alaladkka/</b>'),
(424, 50, '2014-03-05 05:34:15', 'Delete', 'File', '<b></b> from <b>/dadaad/</b>'),
(425, 50, '2014-03-05 05:36:38', 'Delete', 'File', '<b></b> from <b>/ghghjg/</b>'),
(426, 50, '2014-03-05 05:36:46', 'Delete', 'File', '<b></b> from <b>/ghghjg/</b>'),
(427, 50, '2014-03-05 05:37:54', 'Delete', 'Folder', '<b>ghghjg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(428, 50, '2014-03-05 05:39:25', 'Create', 'Folder', '<b>ddfd</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(429, 50, '2014-03-05 05:39:27', 'Create', 'Folder', '<b>ddfd</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(430, 50, '2014-03-05 05:39:34', 'Delete', 'File', '<b></b> from <b>/alaladkka/</b>'),
(431, 50, '2014-03-05 05:39:41', 'Delete', 'File', '<b></b> from <b>/alaladkka/</b>'),
(432, 50, '2014-03-05 05:40:35', 'Delete', 'File', '<b></b> from <b>/ddfd/</b>'),
(433, 50, '2014-03-05 05:42:00', 'Delete', 'Folder', '<b>ddfd</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(434, 50, '2014-03-05 05:42:08', 'Create', 'Folder', '<b>fgdhgkjlj</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(435, 50, '2014-03-05 05:42:16', 'Delete', 'Folder', '<b>alaladkka</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(436, 50, '2014-03-05 05:42:16', 'Delete', 'Folder', '<b>alaladkka</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(437, 50, '2014-03-05 05:42:16', 'Delete', 'Folder', '<b>fgdhgkjlj</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(438, 50, '2014-03-05 05:45:08', 'Share', 'Folder', '<b>dadaad</b> to user email account <b>user3@user3.com</b>'),
(439, 50, '2014-03-05 05:47:55', 'Delete', 'File', '<b></b> from <b> <i class="fa fa-home"></i>(Home) dadaad/</b>'),
(440, 50, '2014-03-05 05:48:16', 'Delete', 'Folder', '<b>dadaad</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(441, 50, '2014-03-05 05:48:16', 'Delete', 'Folder', '<b>dadaad</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(442, 50, '2014-03-05 05:49:42', 'Create', 'Folder', '<b>dfdsfgfhjkjl</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(443, 50, '2014-03-05 05:50:05', 'Share', 'Folder', '<b>dfdsfgfhjkjl</b> to user email account <b>user3@user3.com</b>'),
(444, 50, '2014-03-05 05:50:17', 'Create', 'Folder', '<b>hgfhfghgfhfg</b> in <b> <i class="fa fa-home"></i>(Home) /dfdsfgfhjkjl/</b>'),
(445, 50, '2014-03-05 05:50:48', 'Share', 'Folder', '<b>hgfhfghgfhfg</b> to user email account <b>user3@user3.com</b>'),
(446, 50, '2014-03-05 05:51:07', 'Delete', 'Folder', '<b>dfdsfgfhjkjl</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(447, 50, '2014-03-05 05:51:07', 'Delete', 'Folder', '<b>dfdsfgfhjkjl</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(448, 50, '2014-03-05 05:53:46', 'Create', 'Folder', '<b>fgkfhjgkggkffjdf</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(449, 65, '2014-03-05 06:01:55', 'Create', 'Folder', '<b>jkjlkgfgf</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(450, 65, '2014-03-05 06:02:01', 'Delete', 'Folder', '<b>jkjlkgfgf</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(451, 50, '2014-03-05 06:02:24', 'Delete', 'Folder', '<b>fgkfhjgkggkffjdf</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(452, 50, '2014-03-05 06:02:39', 'Create', 'Folder', '<b>fghj</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(453, 50, '2014-03-05 06:02:46', 'Create', 'Folder', '<b>dgfdgfdgdfg</b> in <b> <i class="fa fa-home"></i>(Home) /fghj/</b>'),
(454, 50, '2014-03-05 06:02:52', 'Delete', 'Folder', '<b>dgfdgfdgdfg</b> from <b> <i class="fa fa-home"></i>(Home) /fghj/</b>'),
(455, 50, '2014-03-05 06:08:44', 'Create', 'Folder', '<b>ddsdsd</b> in <b> <i class="fa fa-home"></i>(Home) /fghj/</b>'),
(456, 50, '2014-03-05 06:12:25', 'Rename', 'Folder', '<b>/fghj/</b> to <b>fghjffff/</b>'),
(457, 50, '2014-03-05 06:12:34', 'Rename', 'Folder', '<b>/fghj/</b> to <b>fghjffffffffffffff/</b>'),
(458, 50, '2014-03-05 06:16:21', 'Rename', 'Folder', '<b>/fghj/</b> to <b>fghjttyytytyt/</b>'),
(459, 65, '2014-03-05 09:07:18', 'Rename', 'Folder', '<b>/alaladkka/</b> to <b>alaladkka kasus/</b>'),
(460, 65, '2014-03-05 09:08:17', 'Rename', 'Folder', '<b>alaladkka/</b> to <b>alaladkka manna/</b>'),
(461, 65, '2014-03-05 09:08:27', 'Copy', 'Folder', '<b>alaladkka manna/</b> to <b> <i class="fa fa-home"></i>(Home) /alaladkka manna/</b>'),
(462, 65, '2014-03-05 09:09:16', 'Delete', 'Folder', '<b>alaladkka manna</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(463, 65, '2014-03-05 09:09:29', 'Delete', 'Folder', '<b>alaladkka manna</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(464, 65, '2014-03-05 09:09:29', 'Delete', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(465, 65, '2014-03-05 09:09:29', 'Delete', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(466, 65, '2014-03-05 09:09:29', 'Delete', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(467, 65, '2014-03-05 09:09:29', 'Delete', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(468, 65, '2014-03-05 09:09:29', 'Delete', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(469, 65, '2014-03-05 09:09:29', 'Delete', 'File', '<b>wew.rar</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(470, 65, '2014-03-05 09:09:29', 'Delete', 'File', '<b>wew.zip</b> from <b> <i class="fa fa-home"></i>(Home) /</b>'),
(471, 65, '2014-03-05 09:09:46', 'Create', 'Folder', '<b>wew</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(472, 65, '2014-03-05 09:10:11', 'Share', 'Folder', '<b>wew</b> to user email account <b>hanelprillian@rocketmail.com</b>'),
(473, 50, '2014-03-05 09:11:32', 'Rename', 'Folder', '<b>fghj/</b> to <b>fghj wew wew wew/</b>');
INSERT INTO `user_recent_activity` (`id`, `id_user`, `date`, `action`, `type`, `name`) VALUES
(474, 65, '2014-03-05 09:13:27', 'Upload', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /wew/</b>'),
(475, 65, '2014-03-05 09:13:27', 'Upload', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /wew/</b>'),
(476, 65, '2014-03-05 09:13:27', 'Upload', 'File', '<b>BdvqKKyCYAA2A13.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /wew/</b>'),
(477, 65, '2014-03-05 09:13:27', 'Upload', 'File', '<b>BdvrnARCEAE0GqU.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /wew/</b>'),
(478, 65, '2014-03-05 09:13:27', 'Upload', 'File', '<b>BdxXCcyCQAA-bj9.jpg</b> to <b> <i class="fa fa-home"></i>(Home) /wew/</b>'),
(479, 65, '2014-03-05 09:13:27', 'Upload', 'File', '<b>wew.rar</b> to <b> <i class="fa fa-home"></i>(Home) /wew/</b>'),
(480, 65, '2014-03-05 09:13:27', 'Upload', 'File', '<b>wew.zip</b> to <b> <i class="fa fa-home"></i>(Home) /wew/</b>'),
(481, 50, '2014-03-05 09:14:33', 'Rename', 'Folder', '<b>root_storage_file/users/user3/wew/Blaaaa/gfdgfdgdf/</b> to <b>gfdgfdgdf akakkak/</b>'),
(482, 50, '2014-03-05 09:14:56', 'Delete', 'Folder', '<b>Blaaaa</b> from <b>root_storage_file/users/user3/wew/</b>'),
(483, 50, '2014-03-05 09:15:05', 'Rename', 'File', '<b>BdvoGlDCMAAK11A.jpg</b> to <b>GANTENG.jpg</b>'),
(484, 50, '2014-03-05 09:15:32', 'Delete', 'File', '<b>GANTENG.jpg</b> from <b>root_storage_file/users/user3/wew/</b>'),
(485, 50, '2014-03-05 09:23:32', 'Copy', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b>root_storage_file/users/user3/wew/fdsfdsfsd/</b>'),
(486, 50, '2014-03-05 09:24:38', 'Rename', 'File', '<b>BdvoGlDCMAAK11A_2.jpg</b> to <b>BdvoGlDCMAAK11A_2 dddd.jpg</b>'),
(487, 50, '2014-03-05 09:26:48', 'Copy', 'Folder', '<b>kaskus/</b> to <b>root_storage_file/users/user3/wew/fdsfdsfsd/</b>'),
(488, 50, '2014-03-05 09:27:01', 'Rename', 'Folder', '<b>root_storage_file/users/user3/wew/fdsfdsfsd/kaskus/</b> to <b>kaskus baru/</b>'),
(489, 50, '2014-03-05 09:27:13', 'Create', 'Folder', '<b>fsdfdf</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(490, 50, '2014-03-05 09:27:22', 'Rename', 'Folder', '<b>fsdfdf/</b> to <b>Yang baru/</b>'),
(491, 50, '2014-03-05 09:27:33', 'Copy', 'Folder', '<b>Yang baru/</b> to <b> <i class="fa fa-home"></i>(Home) /fghj wew wew wew/</b>'),
(492, 50, '2014-03-05 09:29:20', 'Delete', 'Folder', '<b>Yang baru</b> from <b> <i class="fa fa-home"></i>(Home) /fghj wew wew wew/</b>'),
(493, 50, '2014-03-05 09:29:32', 'Rename', 'Folder', '<b>fghj wew wew wew/ddsdsd/</b> to <b>ddsdsd wew/</b>'),
(585, 78, '2014-10-27 06:30:32', 'Create', 'Folder', '<b>Hanel Ganteng</b> in <b> <i class="fa fa-home"></i>(Home) /</b>'),
(586, 78, '2014-10-27 06:34:30', 'Upload', 'File', '<b>zukimac_by_vinceliuice-d7mqbmc.zip</b> to <b> <i class="fa fa-home"></i>(Home) /Hanel Ganteng/</b>'),
(587, 78, '2014-10-27 06:34:42', 'Upload', 'File', '<b>zukimac_by_vinceliuice-d7mqbmc.zip</b> to <b> <i class="fa fa-home"></i>(Home) /Hanel Ganteng/</b>'),
(588, 78, '2014-10-27 06:38:48', 'Copy', 'File', '<b>zukimac_by_vinceliuice-d7mqbmc.zip</b> to <b> <i class="fa fa-home"></i>(Home) /Hanel Ganteng/</b>'),
(589, 78, '2014-10-27 06:38:54', 'Copy', 'File', '<b>zukimac_by_vinceliuice-d7mqbmc.zip</b> to <b> <i class="fa fa-home"></i>(Home) /</b>'),
(590, 78, '2014-10-27 06:39:10', 'Create', 'Public Link', '<b>zukimac_by_vinceliuice-d7mqbmc.zip</b>');

-- --------------------------------------------------------

--
-- Table structure for table `user_sharing_subscriber`
--

CREATE TABLE IF NOT EXISTS `user_sharing_subscriber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_subscriber` int(11) DEFAULT NULL,
  `folder_name` varchar(200) DEFAULT NULL,
  `folder_sharing` varchar(200) DEFAULT NULL,
  `root_user` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `permission` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `user_sharing_subscriber`
--

INSERT INTO `user_sharing_subscriber` (`id`, `id_user`, `id_subscriber`, `folder_name`, `folder_sharing`, `root_user`, `status`, `permission`) VALUES
(23, 51, 52, 'testing', 'testing/', 'user2', 1, 'r'),
(31, 65, 50, 'wew', 'wew/', 'user3', 1, 'rw'),
(42, 58, 50, 'LATIHAN', 'LATIHAN/', 'user3', 1, 'r');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
