-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2016 at 07:08 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gocgod`
--

-- --------------------------------------------------------

--
-- Table structure for table `about__us`
--

CREATE TABLE IF NOT EXISTS `about__us` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `about__us`
--

INSERT INTO `about__us` (`id`, `name`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Baby', 'Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk  ', '0811139318', '2016-06-08 11:43:37', '2016-05-23 20:52:22');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `description1` varchar(50) NOT NULL,
  `description2` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `name`, `alias`, `description1`, `description2`, `price`, `picture`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SOYA MILK', 'Susu Kacang', 'Terbuat dari kacang kedelai pilihan', 'Tanpa bahan pengawet dan pemanis buatan!', 60000, 'slide-2.png', '2016-06-09 03:51:10', '0000-00-00 00:00:00', NULL),
(2, 'FRUIT PUNCH', 'Aneka Buah', 'Dibuat dari aneka macam buah-buahan segar', 'seperti melon, semangka, jeruk, biji selasih', 75000, 'slide-1.png', '2016-06-09 11:00:09', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faq__question`
--

CREATE TABLE IF NOT EXISTS `faq__question` (
`question_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq__question`
--

INSERT INTO `faq__question` (`question_id`, `question`, `answer`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'halo', 'bandung', '2016-05-10 10:18:51', '2016-05-10 03:18:51', NULL),
(5, 'ab', 'asdfsadfasdfasdf', '2016-05-24 03:31:09', '2016-05-23 20:30:57', NULL),
(6, 'a', '1213', '2016-05-24 03:31:20', '2016-05-13 00:56:34', NULL),
(8, 'tes', 'tes', '2016-05-23 20:34:14', '2016-05-23 20:34:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master__admin`
--

CREATE TABLE IF NOT EXISTS `master__admin` (
`id` int(11) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `city_id` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `super` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__admin`
--

INSERT INTO `master__admin` (`id`, `password`, `name`, `address`, `city_id`, `date_of_birth`, `email`, `phone`, `super`, `created_at`, `updated_at`, `deleted_at`, `remember_token`) VALUES
(1, '$2y$10$PdIxuztGnzEqYOyw7MWNK.laBG7qzwkeDWv4I6VXIj3NOKzAYaH0C', 'kevin', 'abc', 12, '2016-06-01', 'tes@tes.com', '123', 1, '2016-06-12 12:39:50', '2016-06-12 05:39:50', NULL, 'uZ7Pvf6DLcskWZBVaunvfhgzPM6UKPdPVNdWZEw3ZkUCltjixbOGG2ZwWUHX'),
(6, '$2y$10$GdTJv/4VWklLKWcAxcIbFu.UPUBUsaSdhY8DQ7NKnuj0ASL3qAvhS', 'af', 'sadf', 1, '2016-06-08', 'a@a.com', '12345', 0, '2016-06-08 11:51:04', '2016-06-08 04:51:04', NULL, 'Z3U1c9vL8pFbCBzAEaFmtr8mFHb3I3IK5xjJiA1ND14uSPavXfnjElDlv7SA');

-- --------------------------------------------------------

--
-- Table structure for table `master__admin_information`
--

CREATE TABLE IF NOT EXISTS `master__admin_information` (
  `admin_id` int(11) NOT NULL,
  `information` text NOT NULL,
`information_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__admin_information`
--

INSERT INTO `master__admin_information` (`admin_id`, `information`, `information_id`, `created_at`, `updated_at`) VALUES
(1, 'adfafd', 1, '2016-06-03 11:07:20', '2016-06-03 04:07:20'),
(6, 'adfafd', 4, '2016-06-03 04:00:27', '2016-06-03 04:00:27');

-- --------------------------------------------------------

--
-- Table structure for table `master__agent_rating`
--

CREATE TABLE IF NOT EXISTS `master__agent_rating` (
  `agent_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approval` int(11) NOT NULL DEFAULT '0',
`rating_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__agent_rating`
--

INSERT INTO `master__agent_rating` (`agent_id`, `customer_id`, `rating`, `comment`, `approval`, `rating_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 4, 1, 'abc', 0, 1, '2016-06-08 09:41:46', '2016-06-08 02:41:46', '2016-06-08 02:41:46'),
(5, 3, 5, 'bbbbb', 0, 2, '2016-06-08 08:41:51', '2016-06-08 01:41:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master__bank`
--

CREATE TABLE IF NOT EXISTS `master__bank` (
`bank_id` int(11) NOT NULL,
  `bank_name` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__bank`
--

INSERT INTO `master__bank` (`bank_id`, `bank_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BCA', '2016-06-08 10:15:57', '2016-06-08 03:15:57', NULL),
(2, 'MANDIRI', '2016-06-08 05:16:47', '0000-00-00 00:00:00', NULL),
(3, 'DANAMON', '2016-06-08 05:16:47', '0000-00-00 00:00:00', NULL),
(4, 'BNI', '2016-06-08 05:16:47', '0000-00-00 00:00:00', NULL),
(5, 'BRI', '2016-06-08 05:16:47', '0000-00-00 00:00:00', NULL),
(6, 'CIMB', '2016-06-08 05:16:47', '0000-00-00 00:00:00', NULL),
(7, 'PERMATA', '2016-06-08 05:16:47', '0000-00-00 00:00:00', NULL),
(8, 'MEGA', '2016-06-08 05:16:47', '0000-00-00 00:00:00', NULL),
(9, 'OCBC', '2016-06-08 05:16:47', '0000-00-00 00:00:00', NULL),
(10, '123', '2016-06-08 10:08:46', '2016-06-08 03:08:46', '2016-06-08 03:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `master__city`
--

CREATE TABLE IF NOT EXISTS `master__city` (
`city_id` int(11) NOT NULL,
  `city_name` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__city`
--

INSERT INTO `master__city` (`city_id`, `city_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'jakarta', '2016-05-24 03:46:28', '2016-05-23 20:46:28', NULL),
(3, 'bandung', '2016-05-24 03:44:49', '2016-05-23 20:44:34', '0000-00-00 00:00:00'),
(10, '1', '2016-06-02 11:24:19', '2016-05-23 20:49:18', '0000-00-00 00:00:00'),
(11, 'bandung', '2016-06-02 04:24:44', '2016-06-02 04:24:44', NULL),
(12, 'tegal', '2016-06-03 00:32:41', '2016-06-03 00:32:41', NULL),
(13, 'tegal', '2016-06-03 07:33:18', '2016-06-03 00:33:18', '2016-06-03 00:33:18'),
(14, 'Korea', '2016-06-07 04:19:31', '2016-06-07 04:19:31', NULL),
(15, 'Jepang', '2016-06-07 21:45:03', '2016-06-07 21:45:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master__cut_off_date`
--

CREATE TABLE IF NOT EXISTS `master__cut_off_date` (
`id` int(11) NOT NULL,
  `cut_off` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__cut_off_date`
--

INSERT INTO `master__cut_off_date` (`id`, `cut_off`, `created_at`, `updated_at`) VALUES
(1, 3, '2016-06-06 06:30:45', '2016-06-05 23:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `master__member`
--

CREATE TABLE IF NOT EXISTS `master__member` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `city_id` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `status_user` int(11) NOT NULL DEFAULT '1',
  `verification` int(11) NOT NULL DEFAULT '0',
  `balance` int(11) DEFAULT NULL,
  `bank_account` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(255) NOT NULL,
  `bank_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__member`
--

INSERT INTO `master__member` (`id`, `name`, `address`, `city_id`, `date_of_birth`, `email`, `phone`, `password`, `status_user`, `verification`, `balance`, `bank_account`, `created_at`, `updated_at`, `remember_token`, `bank_id`) VALUES
(3, 'af', '', 1, '0000-00-00', 'a@a.com', '', '$2y$10$DPAva0yvL3bjqvvoCi/5hea.I1kL5UFasYOtl9/oKKxJmNzfvCcbW', 0, 0, 0, '', '2016-06-12 13:41:43', '2016-06-10 04:56:45', '7Lv4cAnlpo9qUzyLcceBAFlbv9elVBXHOX1qxBy9gySEvRAxeAXk7B3YWLpU', NULL),
(4, 'b', '', 1, '0000-00-00', 'b@b.com', '', '$2y$10$V.FqluggCpwDaWNJyhfqluFomZ2PVA2Hm0wCBg01fFJp33PphpDuK', 1, 0, 0, '123123', '2016-06-08 11:24:44', '2016-06-08 04:24:44', 'vvJ7IZeTastukAp9uqeJe7iufJHZpp1KgHacuM5sXk76RVgMsAqp8UXw2XYm', 4),
(5, 'Aurelia', 'Komplek pakuwon blok N no 10', 14, '2016-02-17', 'aureliarianto@aurelia.com', '08999940888', '$2y$10$7p0b4onetwj/TgIoXJ1LZ.G.ijd2KSx9daM0Pc0g.CSs228LsKMw2', 0, 0, 80000, '6557788', '2016-06-12 16:51:59', '2016-06-12 09:51:59', '8SdY0azai4UyXbMHsaJr6L95h8kTUQh76lRqapjtNENQQaqOFkkHzvho8oqL', 4),
(6, 'Rianto', 'komplek pakuwon blok apa aja', 1, '2016-06-30', 'rianto@rianto.com', '0812981098', '$2y$10$2YlV2rYohCI3aukWpkawTul5zERrS1uiXkTGHnxWF0naMP2G1yoKu', 1, 0, NULL, NULL, '2016-06-08 03:38:46', '2016-06-07 20:38:46', 'ZQF6hi1pl1QfJVlqqkjX21GgUjX2eLy29MGbXslkwZo690ntHOczco18L7OO', NULL),
(7, 'Lia', 'komplek pakuwon blok apa aja', 1, '2016-06-16', 'lia@lia.com', '1', '$2y$10$MNNb.j.K/0JqabgAQplqLeZxuwdOB3VygzeDVZjkUZV0uFiHW7CtW', 1, 0, NULL, NULL, '2016-06-13 04:25:02', '2016-06-12 21:25:02', 'pdonyHTlw9gIFPkmSXmeP2gNC1oheMnxnzkNhONPFDrvIj1fpjhRkII12Zno', NULL),
(8, 'a', 'a', 15, '2016-06-30', 'niko95kus@yahoo.com', '1', '$2y$10$WUk22rUr2PkxrrgRDNQZZORGkB25HOSfkb.h/YJy014reBhuWzTgi', 1, 0, NULL, NULL, '2016-06-09 03:16:08', '2016-06-07 21:45:26', '1aFfSDgxMCNCxvJzhCLZd65Jn6RqH0SA9gb9k8XW2aslwuCJgnVElV3lS6hE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master__req_agent`
--

CREATE TABLE IF NOT EXISTS `master__req_agent` (
`reqagent_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `status_confirm` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bank_account` varchar(100) NOT NULL,
  `member_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__req_agent`
--

INSERT INTO `master__req_agent` (`reqagent_id`, `bank_id`, `status_confirm`, `created_at`, `updated_at`, `bank_account`, `member_id`, `deleted_at`) VALUES
(1, 4, 0, '2016-06-08 09:44:33', '2016-06-08 02:44:21', '123123', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master__tx_balance`
--

CREATE TABLE IF NOT EXISTS `master__tx_balance` (
`balance_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `amountMoney` int(11) NOT NULL,
  `balance_type` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_id` int(11) DEFAULT NULL,
  `statusTransfer` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__tx_balance`
--

INSERT INTO `master__tx_balance` (`balance_id`, `agent_id`, `amountMoney`, `balance_type`, `created_at`, `updated_at`, `order_id`, `statusTransfer`) VALUES
(1, 5, 100000, 1, '2016-06-07 05:15:14', '0000-00-00 00:00:00', NULL, NULL),
(2, 5, 50000, 1, '2016-06-07 05:25:56', '0000-00-00 00:00:00', NULL, NULL),
(3, 5, 150000, 0, '2016-06-07 08:12:12', '0000-00-00 00:00:00', NULL, 1),
(4, 5, 20000, 0, '2016-06-10 10:59:55', '2016-06-10 03:59:55', NULL, 1),
(5, 5, 10000, 0, '2016-06-10 11:19:37', '2016-06-10 04:19:37', NULL, 1),
(6, 5, 20000, 0, '2016-06-07 02:42:29', '2016-06-07 02:42:29', NULL, 0),
(7, 5, 80000, 0, '2016-06-07 02:57:35', '2016-06-07 02:57:35', NULL, 0),
(8, 5, 80000, 0, '2016-06-07 02:58:14', '2016-06-07 02:58:14', NULL, 0),
(9, 5, 20000, 0, '2016-06-10 10:52:36', '2016-06-10 03:52:36', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password__resets`
--

CREATE TABLE IF NOT EXISTS `password__resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password__resets`
--

INSERT INTO `password__resets` (`email`, `token`, `created_at`) VALUES
('a@a.com', '2dd2eb01f84668896fb9f383e36644ce1400a6909cf2a62928bba0e2336da380', '2016-06-02 03:34:34'),
('aureliarianto@aurelia.com', '15c0b762d982fe5c2cb8a694d1ce6e6766861a8edc4bac97206a75d0daaa5519', '2016-06-12 05:08:39'),
('niko95kus@yahoo.com', 'a9377a120e263a6eb89dbd1a65b6e80be1e5a03e465ba8e3d191a938d1e2ac56', '2016-06-08 20:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `product__category`
--

CREATE TABLE IF NOT EXISTS `product__category` (
`category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product__category`
--

INSERT INTO `product__category` (`category_id`, `category_name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'minuman', '', '2016-05-13 08:55:19', '2016-05-13 01:55:19', NULL),
(2, 'makanan', '', '2016-05-19 10:04:35', '2016-05-19 03:04:35', NULL),
(3, 'qqqqq', '', '2016-05-20 09:25:16', '2016-05-20 02:25:16', '2016-05-20 02:25:16');

-- --------------------------------------------------------

--
-- Table structure for table `product__testimonial`
--

CREATE TABLE IF NOT EXISTS `product__testimonial` (
`testimonial_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `testimonial` varchar(500) NOT NULL,
  `approval` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product__testimonial`
--

INSERT INTO `product__testimonial` (`testimonial_id`, `id`, `varian_id`, `testimonial`, `approval`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 1, 'aaa', 0, '2016-05-24 05:48:15', '2016-05-20 02:05:52', NULL),
(2, 3, 1, 'bbb', 0, '2016-05-24 05:48:18', '2016-05-23 22:47:45', NULL),
(3, 4, 1, 'ccc', 1, '2016-05-24 05:47:56', '2016-05-23 22:47:56', NULL),
(4, 5, 2, 'asd', 1, '2016-05-20 09:06:07', '2016-05-20 02:05:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product__varian`
--

CREATE TABLE IF NOT EXISTS `product__varian` (
`varian_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `varian_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `weight` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product__varian`
--

INSERT INTO `product__varian` (`varian_id`, `category_id`, `varian_name`, `price`, `qty`, `picture`, `description`, `weight`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Soya Milk', 60000, 10, 'soya_milk.jpg', 'Soya milk terbuat dari kacang kedelai pilihan , minuman bergizi dan berprotein sangat tinggi\r\nTanpa bahan pengawet! Dan pemanis buatan\r\nSangat cocok untuk anak-anak, dewasa, dan org tua . Kualitas terjamin!', 2, '2016-05-02 02:26:12', '0000-00-00 00:00:00', NULL),
(2, 1, 'Cin Cau', 60000, 10, 'cin_cau.jpg', 'Manfaat air cin cau cukup beragam sudah biasa di gunakan dalam pengobatan tradisional untuk obat batuk, tekanan darah tinggi, diare, sembelit, menurunkan demam , mengobati panas dalam, menjaga sistem pencernaan , mengatasi perut kembung .\r\nAir cin cau hitam juga sangat membantu bagi anda yg sedang menjalani program diet .', 2, '2016-06-09 11:06:08', '2016-06-09 04:06:08', NULL),
(3, 1, 'Honey Pine', 75000, 10, 'honey_pine.jpg', 'Sari buah nanas ini sangat bermanfaat buat kecantikan karna di buat tanpa bahan pengawet dan gula, bener2 murni dan fress \r\nManfaat sari buat nanas \r\n1. Menjaga kesehatan mata\r\n2. Meningkatkan imunitas\r\n3. Membantu pencernaan\r\n5. Mencegah hipertensi\r\n6. Meredakan mual\r\n7. Menguatkan tulang\r\n8. Memperbaiki kulit kaki\r\n9. Melembabkan kulit\r\n10. Mencerna kandungan lemak pada makanan Yang kita makan', 2, '2016-04-21 11:10:39', '0000-00-00 00:00:00', NULL),
(4, 1, 'Guava', 75000, 10, 'guava.jpg', 'Guava adalah sari buah jambu pilihan , yg di proses secara higienis tanpa bahan pengawet dan gula, rasanya benar2 alami seperti makan buah aslinya \r\nManfaat sari guava diantaranya yaitu \r\n1. Mengandung vitamin C yg sangat di butuhkan Oleh tubuh \r\n2. Mengandung serat alami \r\n3.Melancarkan pencernaan seperti susah BAB, Sembelit serta menbuang zat-zat berbahaya di Dalam usus\r\n4.Membuat kulit lebih cerah dan lembut', 2, '2016-04-21 11:10:39', '0000-00-00 00:00:00', NULL),
(5, 1, 'Fruit Punch', 75000, 10, 'fruit_punch.jpg', 'Fruit Punch Aneka Buah adalah minuman yang dibuat dari aneka macam buah-buahan segar seperti melon, semangka, jeruk, biji selasih dan air soda. Buah-buahan memanglah sangat dianjurkan untuk dikonsumsi tubuh karena memiliki sejuta manfaat yang beragam bagi kesehatan. Seperti buah semangka yang memiliki manfaat menjaga kesehatan jantung, mata dan tulang, menangkal radikal bebas, meningkatkan sistem kekebalan tubuh, membantu meningkatkan aliran urine dan mengurangi lemak pada tubuh. Selain semangka, biji selasih yang turut digunakan sebagai bahan pelengkpnya juga memiliki manfaat bagi tubuh antara lain dapat mengobati radang lambung, menyembuhkan sakit gigi, baik untuk menghaluskan kulit wajah, sebagai obat sakit kepala dan lain sebagainya.', 2, '2016-04-21 11:13:34', '0000-00-00 00:00:00', NULL),
(6, 1, 'Sirsak', 60000, 10, 'sirsak.jpg', '\r\nManfaat jus sirsak sangat luar biasa bagi kesehatan seperti untuk diet, kulit, kanker, dan banyak lagi yang harus Anda ketahui. Buah sirsak merupakan jenis buah yang banyak disukai karena rasanya yang nikmat dan menyegarkan. Selain rasanya yang nikmat dan segar, buah sirsak mengandung manfaat yang sangat berkhasiat dalam mengatasi berbagai masalah kesehatan. Buah sirsak dapat dikonsumsi langsung buahnya atau dijadikan minuman jus yang lebih mudah diserap tubuh, sehingga sangat baik untuk saluran pencernaan.\r\n\r\n', 1, '2016-04-21 11:13:34', '0000-00-00 00:00:00', NULL),
(7, 1, 'Kacang Hijau', 60000, 10, 'kacang_hijau.jpg', 'Manfaat sari kacang hijau \r\n1.Meningkatkan penyerapan nutrisi\r\n2. Mencegah penyakit jantung & stroke\r\n3.Membersihkan pencernaan\r\n4.Mengatasi anemia\r\n5.Menjaga berat badan\r\n6.Membantu pertumbuhan sel organ, otot & otak\r\nTampa bahan pengawet !!!!', 2, '2016-04-21 11:16:07', '0000-00-00 00:00:00', NULL),
(8, 1, 'Liang Teh', 75000, 10, 'liang_teh.jpg', '\r\nLiang teh merupakan minuman yang mempunyai manfaat serta khasiat yang banyak bagi kesehatan tubuh. Selain itu, liang teh mempunyai rasa yang enak dan banyak digemari oleh semua kalangan baik anak – anak, remaja dan orang tua. Liang teh merupakan jenis minuman yang dapat disajikan dalam keadaan hangat maupun dingin. Kandungan didalamnya dapat meredakan panas dalam dan mengatasi masalah sistem pencernaan tubuh. Minuman herbal yang berasal dari China ini memiliki jenis warna dan rasa yang sangat bervariatif sesuai dengan jenis tanaman yang digunakan sebagai bahan pembuat liang teh.\r\n\r\n', 2, '2016-04-21 11:16:07', '0000-00-00 00:00:00', NULL),
(9, 1, 'Lime Watz', 75000, 10, 'lime_watz.jpg', 'Membantu menurunkan berat badan\r\nSari lemon kerap disertakan dalam diet penurunan berat badan. Biasanya, sari lemon dicampurkan dengan air hangat dan madu. Tak hanya sehat, lemon juga rendah kalori, bahkan termasuk yang terendah di antara buah citrus lainnya. Sekitar 100 g lemon hanya mengandung 29 kalori. Lemon pun bebas kolesterol, lemak jenuh, dan memiliki indeks glikemik rendah. Lemon juga kaya serat pangan sehingga baik dikonsumsi Anda yang ingin memangkas berat badan.\r\nLime Watz itu campuran Lemon , madu , kiwi dan Semangka kuning.', 2, '2016-04-21 11:17:42', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction__order`
--

CREATE TABLE IF NOT EXISTS `transaction__order` (
`order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_payment` int(11) NOT NULL DEFAULT '0',
  `ship_address` varchar(500) NOT NULL,
  `ship_city_id` int(11) NOT NULL,
  `status_confirmed` int(11) NOT NULL DEFAULT '0',
  `status_shipping` int(11) NOT NULL DEFAULT '0',
  `shipping_date` date NOT NULL,
  `group_id` int(11) NOT NULL,
  `shipping_fee` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `who` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction__order`
--

INSERT INTO `transaction__order` (`order_id`, `customer_id`, `agent_id`, `order_date`, `status_payment`, `ship_address`, `ship_city_id`, `status_confirmed`, `status_shipping`, `shipping_date`, `group_id`, `shipping_fee`, `total`, `created_at`, `updated_at`, `who`) VALUES
(1, 7, 3, '2016-06-02 00:00:00', 1, 'sunrise', 1, 0, 0, '2016-06-19', 1, 10000, 10, '2016-06-12 19:09:34', '2016-06-12 11:25:44', 'single'),
(2, 4, 5, '2016-06-03 00:00:00', 1, 'green garden', 3, 0, 1, '2016-06-01', 2, 0, 20, '2016-06-12 16:34:23', '2016-06-12 09:34:23', 'subscribe'),
(3, 7, 3, '2016-06-16 00:00:00', 1, 'abc', 1, 0, 0, '2016-06-29', 3, 5000, 135000, '2016-06-13 04:49:57', '2016-06-12 21:49:57', 'single'),
(4, 7, 3, '2016-06-13 11:26:09', 0, 'komplek pakuwon blok apa aja', 1, 0, 0, '2016-06-16', 4, 10000, 145000, '2016-06-13 04:32:46', '2016-06-12 21:32:26', 'single');

-- --------------------------------------------------------

--
-- Table structure for table `transaction__order_detail`
--

CREATE TABLE IF NOT EXISTS `transaction__order_detail` (
  `order_id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `varian_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction__order_detail`
--

INSERT INTO `transaction__order_detail` (`order_id`, `varian_id`, `varian_price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 2, 60000, 2, '2016-05-24 10:20:11', '0000-00-00 00:00:00'),
(2, 2, 60000, 5, '2016-06-09 08:16:09', '0000-00-00 00:00:00'),
(2, 4, 75000, 2, '2016-06-09 08:10:55', '0000-00-00 00:00:00'),
(3, 2, 60000, 1, '2016-06-09 09:55:41', '0000-00-00 00:00:00'),
(3, 7, 75000, 1, '2016-06-09 09:55:41', '0000-00-00 00:00:00'),
(4, 2, 60000, 1, '2016-06-12 21:26:10', '2016-06-12 21:26:10'),
(4, 3, 75000, 1, '2016-06-12 21:26:10', '2016-06-12 21:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `transaction__sample_detail`
--

CREATE TABLE IF NOT EXISTS `transaction__sample_detail` (
  `request_id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction__sample_detail`
--

INSERT INTO `transaction__sample_detail` (`request_id`, `varian_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2016-05-24 10:15:00', '2016-05-10 17:00:00'),
(4, 1, 10, '2016-05-24 04:49:32', '0000-00-00 00:00:00'),
(4, 2, 3, '2016-05-24 04:49:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction__sample_request`
--

CREATE TABLE IF NOT EXISTS `transaction__sample_request` (
`request_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `event_venue` varchar(100) NOT NULL,
  `event_description` varchar(1000) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approval` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction__sample_request`
--

INSERT INTO `transaction__sample_request` (`request_id`, `agent_id`, `event_name`, `event_date`, `event_venue`, `event_description`, `request_date`, `approval`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'iseng aja', '2016-05-20', 'alsut', 'rame', '2016-05-18 10:27:22', 0, '2016-05-24 07:56:39', '2016-05-24 00:56:22', NULL),
(4, 3, '', '0000-00-00', '', '', '2016-05-20 08:37:01', 0, '2016-05-24 04:38:06', '2016-05-23 21:37:59', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about__us`
--
ALTER TABLE `about__us`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq__question`
--
ALTER TABLE `faq__question`
 ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `master__admin`
--
ALTER TABLE `master__admin`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_ad_ci_id` (`city_id`);

--
-- Indexes for table `master__admin_information`
--
ALTER TABLE `master__admin_information`
 ADD PRIMARY KEY (`information_id`), ADD KEY `fk_adin_ad_id` (`admin_id`);

--
-- Indexes for table `master__agent_rating`
--
ALTER TABLE `master__agent_rating`
 ADD PRIMARY KEY (`rating_id`), ADD KEY `fk_agrat_ag_id` (`agent_id`), ADD KEY `fk_agrat_cust_id` (`customer_id`);

--
-- Indexes for table `master__bank`
--
ALTER TABLE `master__bank`
 ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `master__city`
--
ALTER TABLE `master__city`
 ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `master__cut_off_date`
--
ALTER TABLE `master__cut_off_date`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master__member`
--
ALTER TABLE `master__member`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_mem_ci_id` (`city_id`), ADD KEY `fk_ma_me_bank` (`bank_id`);

--
-- Indexes for table `master__req_agent`
--
ALTER TABLE `master__req_agent`
 ADD PRIMARY KEY (`reqagent_id`), ADD KEY `fk_req_bank_id` (`bank_id`), ADD KEY `fk_member_id` (`member_id`);

--
-- Indexes for table `master__tx_balance`
--
ALTER TABLE `master__tx_balance`
 ADD PRIMARY KEY (`balance_id`), ADD KEY `fk_txbal_ag_id` (`agent_id`), ADD KEY `fk_tx_orderid` (`order_id`);

--
-- Indexes for table `password__resets`
--
ALTER TABLE `password__resets`
 ADD PRIMARY KEY (`email`);

--
-- Indexes for table `product__category`
--
ALTER TABLE `product__category`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product__testimonial`
--
ALTER TABLE `product__testimonial`
 ADD PRIMARY KEY (`testimonial_id`), ADD KEY `fk_protes_id` (`id`), ADD KEY `fk_protes_var_id` (`varian_id`);

--
-- Indexes for table `product__varian`
--
ALTER TABLE `product__varian`
 ADD PRIMARY KEY (`varian_id`), ADD KEY `fk_provar_cat_id` (`category_id`);

--
-- Indexes for table `transaction__order`
--
ALTER TABLE `transaction__order`
 ADD PRIMARY KEY (`order_id`), ADD KEY `fk_traor_cus_id` (`customer_id`), ADD KEY `fk_traor_ag_id` (`agent_id`), ADD KEY `fk_or_ci_id` (`ship_city_id`);

--
-- Indexes for table `transaction__order_detail`
--
ALTER TABLE `transaction__order_detail`
 ADD PRIMARY KEY (`order_id`,`varian_id`), ADD KEY `fk_orde_or_id` (`order_id`), ADD KEY `fk_orde_var_id` (`varian_id`);

--
-- Indexes for table `transaction__sample_detail`
--
ALTER TABLE `transaction__sample_detail`
 ADD PRIMARY KEY (`request_id`,`varian_id`), ADD KEY `fk_orde_or_id` (`request_id`), ADD KEY `fk_orde_var_id` (`varian_id`);

--
-- Indexes for table `transaction__sample_request`
--
ALTER TABLE `transaction__sample_request`
 ADD PRIMARY KEY (`request_id`), ADD KEY `fk_sample_agent_id` (`agent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about__us`
--
ALTER TABLE `about__us`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `faq__question`
--
ALTER TABLE `faq__question`
MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `master__admin`
--
ALTER TABLE `master__admin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `master__admin_information`
--
ALTER TABLE `master__admin_information`
MODIFY `information_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `master__agent_rating`
--
ALTER TABLE `master__agent_rating`
MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `master__bank`
--
ALTER TABLE `master__bank`
MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `master__city`
--
ALTER TABLE `master__city`
MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `master__cut_off_date`
--
ALTER TABLE `master__cut_off_date`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `master__member`
--
ALTER TABLE `master__member`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `master__req_agent`
--
ALTER TABLE `master__req_agent`
MODIFY `reqagent_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `master__tx_balance`
--
ALTER TABLE `master__tx_balance`
MODIFY `balance_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `product__category`
--
ALTER TABLE `product__category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product__testimonial`
--
ALTER TABLE `product__testimonial`
MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `product__varian`
--
ALTER TABLE `product__varian`
MODIFY `varian_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `transaction__order`
--
ALTER TABLE `transaction__order`
MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `transaction__sample_request`
--
ALTER TABLE `transaction__sample_request`
MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `master__admin`
--
ALTER TABLE `master__admin`
ADD CONSTRAINT `fk_ad_ci_id` FOREIGN KEY (`city_id`) REFERENCES `master__city` (`city_id`);

--
-- Constraints for table `master__admin_information`
--
ALTER TABLE `master__admin_information`
ADD CONSTRAINT `fk_adin_ad_id` FOREIGN KEY (`admin_id`) REFERENCES `master__admin` (`id`);

--
-- Constraints for table `master__agent_rating`
--
ALTER TABLE `master__agent_rating`
ADD CONSTRAINT `fk_agrat_ag_id` FOREIGN KEY (`agent_id`) REFERENCES `master__member` (`id`),
ADD CONSTRAINT `fk_agrat_cust_id` FOREIGN KEY (`customer_id`) REFERENCES `master__member` (`id`);

--
-- Constraints for table `master__member`
--
ALTER TABLE `master__member`
ADD CONSTRAINT `fk_ma_me_bank` FOREIGN KEY (`bank_id`) REFERENCES `master__bank` (`bank_id`),
ADD CONSTRAINT `fk_mem_ci_id` FOREIGN KEY (`city_id`) REFERENCES `master__city` (`city_id`);

--
-- Constraints for table `master__req_agent`
--
ALTER TABLE `master__req_agent`
ADD CONSTRAINT `fk_member_id` FOREIGN KEY (`member_id`) REFERENCES `master__member` (`id`),
ADD CONSTRAINT `fk_req_bank_id` FOREIGN KEY (`bank_id`) REFERENCES `master__bank` (`bank_id`);

--
-- Constraints for table `master__tx_balance`
--
ALTER TABLE `master__tx_balance`
ADD CONSTRAINT `fk_tx_orderid` FOREIGN KEY (`order_id`) REFERENCES `transaction__order` (`order_id`),
ADD CONSTRAINT `fk_txbal_ag_id` FOREIGN KEY (`agent_id`) REFERENCES `master__member` (`id`);

--
-- Constraints for table `product__testimonial`
--
ALTER TABLE `product__testimonial`
ADD CONSTRAINT `fk_protes_id` FOREIGN KEY (`id`) REFERENCES `master__member` (`id`),
ADD CONSTRAINT `fk_protes_var_id` FOREIGN KEY (`varian_id`) REFERENCES `product__varian` (`varian_id`);

--
-- Constraints for table `product__varian`
--
ALTER TABLE `product__varian`
ADD CONSTRAINT `fk_provar_cat_id` FOREIGN KEY (`category_id`) REFERENCES `product__category` (`category_id`);

--
-- Constraints for table `transaction__order`
--
ALTER TABLE `transaction__order`
ADD CONSTRAINT `fk_or_ci_id` FOREIGN KEY (`ship_city_id`) REFERENCES `master__city` (`city_id`),
ADD CONSTRAINT `fk_traor_ag_id` FOREIGN KEY (`agent_id`) REFERENCES `master__member` (`id`),
ADD CONSTRAINT `fk_traor_cus_id` FOREIGN KEY (`customer_id`) REFERENCES `master__member` (`id`);

--
-- Constraints for table `transaction__order_detail`
--
ALTER TABLE `transaction__order_detail`
ADD CONSTRAINT `fk_orde_or_id` FOREIGN KEY (`order_id`) REFERENCES `transaction__order` (`order_id`),
ADD CONSTRAINT `fk_orde_var_id` FOREIGN KEY (`varian_id`) REFERENCES `product__varian` (`varian_id`);

--
-- Constraints for table `transaction__sample_detail`
--
ALTER TABLE `transaction__sample_detail`
ADD CONSTRAINT `fk_sample_req_id` FOREIGN KEY (`request_id`) REFERENCES `transaction__sample_request` (`request_id`),
ADD CONSTRAINT `fk_sample_var_id` FOREIGN KEY (`varian_id`) REFERENCES `product__varian` (`varian_id`);

--
-- Constraints for table `transaction__sample_request`
--
ALTER TABLE `transaction__sample_request`
ADD CONSTRAINT `fk_sample_agent_id` FOREIGN KEY (`agent_id`) REFERENCES `master__member` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
