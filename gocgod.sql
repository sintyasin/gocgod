-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2016 at 10:36 AM
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
-- Table structure for table `faq__kategori`
--

CREATE TABLE IF NOT EXISTS `faq__kategori` (
`id_kategori` int(11) NOT NULL,
  `kategori_pertanyaan` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq__kategori`
--

INSERT INTO `faq__kategori` (`id_kategori`, `kategori_pertanyaan`) VALUES
(1, 'Pembayaran');

-- --------------------------------------------------------

--
-- Table structure for table `faq__pertanyaan`
--

CREATE TABLE IF NOT EXISTS `faq__pertanyaan` (
`id_pertanyaan` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `pertanyaan` varchar(500) NOT NULL,
  `jawaban` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq__pertanyaan`
--

INSERT INTO `faq__pertanyaan` (`id_pertanyaan`, `id_kategori`, `pertanyaan`, `jawaban`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nomor Rekening', 'Nomor rekening Tokopedia\r\n\r\nPastikan kamu men-transfer dana ke salah satu nomor rekening Tokopedia berikut:\r\n\r\n\r\n\r\nBCA\r\n\r\n- Cabang Permata Hijau\r\n\r\nNomor rekening: 178 303 7878\r\n\r\nAtas Nama: PT. Tokopedia\r\n\r\n \r\n\r\n- Cabang Kedoya Permai\r\n\r\nNomor rekening: 372 309 8781\r\n\r\nAtas Nama: PT. Tokopedia\r\n\r\n \r\n\r\n- Cabang Kedoya Permai\r\n\r\nNomor rekening: 372 177 3939\r\n\r\nAtas Nama: PT. Tokopedia\r\n\r\n \r\n\r\n- Cabang Kedoya Permai\r\n\r\nNomor rekening: 372 178 5066\r\n\r\nAtas Nama: PT. Tokopedia\r\n\r\n \r\n\r\nMandiri\r\n\r\n- Cabang Permata Hijau\r\n\r\nNomor rekening: 102-00-0526387-3\r\n\r\nAtas Nama: Tokopedia\r\n\r\n \r\n\r\n- Cabang Kebon Jeruk\r\n\r\nNomor rekening:  1650070070017\r\n\r\nAtas Nama: Tokopedia\r\n\r\n \r\n\r\n- Cabang Kebon Jeruk\r\n\r\nNomor rekening: 1650030073333\r\n\r\nAtas Nama: Tokopedia\r\n\r\n \r\n\r\nBNI\r\n\r\n- Cabang Kebon Jeruk\r\n\r\nNomor rekening: 800 600 6009\r\n\r\nAtas Nama: PT. Tokopedia\r\n\r\n \r\n\r\nBRI\r\n\r\n- Cabang Kebon Jeruk\r\n\r\nNomor rekening: 037 701 000 435 301\r\n\r\nAtas Nama: PT. Tokopedia\r\n\r\n \r\n\r\n- Cabang Kebon Jeruk\r\n\r\nNomor rekening: 037 701 000 692 301\r\n\r\nAtas Nama: PT. Tokopedia\r\n\r\n \r\n\r\nCIMB NIAGA\r\n\r\n- Cabang Tomang Tol\r\n\r\nNomor rekening: 1770100731002\r\n\r\nAtas Nama: PT. Tokopedia', '2016-04-22 07:31:43', '0000-00-00 00:00:00');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master__agent_rating`
--

CREATE TABLE IF NOT EXISTS `master__agent_rating` (
  `agent_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
`rating_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master__city`
--

CREATE TABLE IF NOT EXISTS `master__city` (
`city_id` int(11) NOT NULL,
  `city_name` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__city`
--

INSERT INTO `master__city` (`city_id`, `city_name`, `created_at`, `updated_at`) VALUES
(1, 'jakarta', '2016-04-21 10:05:46', '0000-00-00 00:00:00'),
(2, 'tangerang', '2016-04-29 07:31:56', '0000-00-00 00:00:00');

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
  `status_user` int(11) NOT NULL,
  `verification` int(11) NOT NULL,
  `balance` int(11) DEFAULT NULL,
  `bank_account` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master__member`
--

INSERT INTO `master__member` (`id`, `name`, `address`, `city_id`, `date_of_birth`, `email`, `phone`, `password`, `status_user`, `verification`, `balance`, `bank_account`, `created_at`, `updated_at`, `remember_token`) VALUES
(3, 'af', '', 1, '0000-00-00', 'a@a.com', '', '$2y$10$rqLqee3NTP9g7t7ILwnvtu6fC0MZuL9.YfaFq.pWlNLcOEja9XLny', 0, 0, 0, '', '2016-04-25 05:25:54', '2016-04-24 22:25:54', 'NcsEHOD96jvyiONfHT2vPBh1kMUUWTk2s1XQqrM9IKIZMl1WyWAl4TcuXGwT'),
(6, 'a', 'abc', 2, '2016-04-25', 'b@b.com', '123456', '$2y$10$aakE9JDD6c1dKZyqHkwkqudVA3eQVauKaYzT7cNmDO37rWMcjhf/C', 0, 0, NULL, '999', '2016-04-29 08:32:21', '2016-04-29 01:32:21', '37WIdt5IDnZqs5RJo5XOVHaH37PuDOyWRKTAzDiaR9WxdOod8Mb2NYDvh6od'),
(9, 'testing', 'abc', 1, '2016-04-12', 'c@c.com', '123456', '$2y$10$LJnQzXtW5CGf3eOeiRgU1u7azLZI9fGHgeZnRLRp5uNke5EjkhSWW', 1, 0, NULL, '999', '2016-04-29 08:35:40', '2016-04-29 01:35:40', 'cK6EsHSIJcrlN313fkov6ZVzyp5B6vnxNTnuxESNR0QMeIiUUAo637mptZlP');

-- --------------------------------------------------------

--
-- Table structure for table `master__tx_balance`
--

CREATE TABLE IF NOT EXISTS `master__tx_balance` (
`balance_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `balance_type` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
('a@a.com', 'f665fa6f30b52c38962ec2754d5bab21c10a488fc549a55c2f9ccb3647de363c', '2016-04-21 03:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `product__category`
--

CREATE TABLE IF NOT EXISTS `product__category` (
`category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product__category`
--

INSERT INTO `product__category` (`category_id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'minuman', '', '2016-04-21 10:47:13', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `product__testimonial`
--

CREATE TABLE IF NOT EXISTS `product__testimonial` (
  `testimonial_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `testimonial` varchar(500) NOT NULL,
  `approval` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product__varian`
--

INSERT INTO `product__varian` (`varian_id`, `category_id`, `varian_name`, `price`, `qty`, `picture`, `description`, `weight`, `created_at`, `updated_at`) VALUES
(1, 1, 'Soya Milk', 60000, 10, 'soya_milk.jpg', 'Soya milk terbuat dari kacang kedelai pilihan , minuman bergizi dan berprotein sangat tinggi\r\nTanpa bahan pengawet !!! Dan pemanis buatan\r\nSangat cocok untuk anak-anak, dewasa, dan org tua . Kualitas terjamin ??????', 2, '2016-04-21 11:08:18', '0000-00-00 00:00:00'),
(2, 1, 'Cin Cau', 60000, 10, 'cin_cau.jpg', 'Manfaat air cin cau cukup beragam sudah biasa di gunakan dalam pengobatan tradisional untuk obat batuk, tekanan darah tinggi, diare, sembelit, menurunkan demam , mengobati panas dalam, menjaga sistem pencernaan , mengatasi perut kembung .\r\nAir cin cau hitam juga sangat membantu bagi anda yg sedang menjalani program diet .', 2, '2016-04-21 11:09:00', '0000-00-00 00:00:00'),
(3, 1, 'Honey Pine', 75000, 10, 'honey_pine.jpg', 'Sari buah nanas ini sangat bermanfaat buat kecantikan karna di buat tanpa bahan pengawet dan gula, bener2 murni dan fress \r\nManfaat sari buat nanas \r\n1. Menjaga kesehatan mata\r\n2. Meningkatkan imunitas\r\n3. Membantu pencernaan\r\n5. Mencegah hipertensi\r\n6. Meredakan mual\r\n7. Menguatkan tulang\r\n8. Memperbaiki kulit kaki\r\n9. Melembabkan kulit\r\n10. Mencerna kandungan lemak pada makanan Yang kita makan', 2, '2016-04-21 11:10:39', '0000-00-00 00:00:00'),
(4, 1, 'Guava', 75000, 10, 'guava.jpg', 'Guava adalah sari buah jambu pilihan , yg di proses secara higienis tanpa bahan pengawet dan gula, rasanya benar2 alami seperti makan buah aslinya \r\nManfaat sari guava diantaranya yaitu \r\n1. Mengandung vitamin C yg sangat di butuhkan Oleh tubuh \r\n2. Mengandung serat alami \r\n3.Melancarkan pencernaan seperti susah BAB, Sembelit serta menbuang zat-zat berbahaya di Dalam usus\r\n4.Membuat kulit lebih cerah dan lembut', 2, '2016-04-21 11:10:39', '0000-00-00 00:00:00'),
(5, 1, 'Fruit Punch', 75000, 10, 'fruit_punch.jpg', 'Fruit Punch Aneka Buah adalah minuman yang dibuat dari aneka macam buah-buahan segar seperti melon, semangka, jeruk, biji selasih dan air soda. Buah-buahan memanglah sangat dianjurkan untuk dikonsumsi tubuh karena memiliki sejuta manfaat yang beragam bagi kesehatan. Seperti buah semangka yang memiliki manfaat menjaga kesehatan jantung, mata dan tulang, menangkal radikal bebas, meningkatkan sistem kekebalan tubuh, membantu meningkatkan aliran urine dan mengurangi lemak pada tubuh. Selain semangka, biji selasih yang turut digunakan sebagai bahan pelengkpnya juga memiliki manfaat bagi tubuh antara lain dapat mengobati radang lambung, menyembuhkan sakit gigi, baik untuk menghaluskan kulit wajah, sebagai obat sakit kepala dan lain sebagainya.', 2, '2016-04-21 11:13:34', '0000-00-00 00:00:00'),
(6, 1, 'Sirsak', 60000, 10, 'sirsak.jpg', '\r\nManfaat jus sirsak sangat luar biasa bagi kesehatan seperti untuk diet, kulit, kanker, dan banyak lagi yang harus Anda ketahui. Buah sirsak merupakan jenis buah yang banyak disukai karena rasanya yang nikmat dan menyegarkan. Selain rasanya yang nikmat dan segar, buah sirsak mengandung manfaat yang sangat berkhasiat dalam mengatasi berbagai masalah kesehatan. Buah sirsak dapat dikonsumsi langsung buahnya atau dijadikan minuman jus yang lebih mudah diserap tubuh, sehingga sangat baik untuk saluran pencernaan.\r\n\r\n', 1, '2016-04-21 11:13:34', '0000-00-00 00:00:00'),
(7, 1, 'Kacang Hijau', 60000, 10, 'kacang_hijau.jpg', 'Manfaat sari kacang hijau \r\n1.Meningkatkan penyerapan nutrisi\r\n2. Mencegah penyakit jantung & stroke\r\n3.Membersihkan pencernaan\r\n4.Mengatasi anemia\r\n5.Menjaga berat badan\r\n6.Membantu pertumbuhan sel organ, otot & otak\r\nTampa bahan pengawet !!!!', 2, '2016-04-21 11:16:07', '0000-00-00 00:00:00'),
(8, 1, 'Liang Teh', 75000, 10, 'liang_teh.jpg', '\r\nLiang teh merupakan minuman yang mempunyai manfaat serta khasiat yang banyak bagi kesehatan tubuh. Selain itu, liang teh mempunyai rasa yang enak dan banyak digemari oleh semua kalangan baik anak – anak, remaja dan orang tua. Liang teh merupakan jenis minuman yang dapat disajikan dalam keadaan hangat maupun dingin. Kandungan didalamnya dapat meredakan panas dalam dan mengatasi masalah sistem pencernaan tubuh. Minuman herbal yang berasal dari China ini memiliki jenis warna dan rasa yang sangat bervariatif sesuai dengan jenis tanaman yang digunakan sebagai bahan pembuat liang teh.\r\n\r\n', 2, '2016-04-21 11:16:07', '0000-00-00 00:00:00'),
(9, 1, 'Lime Watz', 75000, 10, 'lime_watz.jpg', 'Membantu menurunkan berat badan\r\nSari lemon kerap disertakan dalam diet penurunan berat badan. Biasanya, sari lemon dicampurkan dengan air hangat dan madu. Tak hanya sehat, lemon juga rendah kalori, bahkan termasuk yang terendah di antara buah citrus lainnya. Sekitar 100 g lemon hanya mengandung 29 kalori. Lemon pun bebas kolesterol, lemak jenuh, dan memiliki indeks glikemik rendah. Lemon juga kaya serat pangan sehingga baik dikonsumsi Anda yang ingin memangkas berat badan.\r\nLime Watz itu campuran Lemon , madu , kiwi dan Semangka kuning.', 2, '2016-04-21 11:17:42', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction__order`
--

CREATE TABLE IF NOT EXISTS `transaction__order` (
`order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `status_payment` int(11) NOT NULL,
  `ship_address` varchar(500) NOT NULL,
  `ship_city_id` int(11) NOT NULL,
  `status_confirmed` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `transaction__shipping`
--

CREATE TABLE IF NOT EXISTS `transaction__shipping` (
`shipping_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `day_time` datetime NOT NULL,
  `total_week` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction__shipping_product`
--

CREATE TABLE IF NOT EXISTS `transaction__shipping_product` (
  `tx_shipping_id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction__tx_shipping`
--

CREATE TABLE IF NOT EXISTS `transaction__tx_shipping` (
  `shipping_id` int(11) NOT NULL,
`tx_shipping_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `date_shipping` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faq__kategori`
--
ALTER TABLE `faq__kategori`
 ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `faq__pertanyaan`
--
ALTER TABLE `faq__pertanyaan`
 ADD PRIMARY KEY (`id_pertanyaan`), ADD KEY `fk_faq_id_kat` (`id_kategori`);

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
-- Indexes for table `master__city`
--
ALTER TABLE `master__city`
 ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `master__member`
--
ALTER TABLE `master__member`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_mem_ci_id` (`city_id`);

--
-- Indexes for table `master__tx_balance`
--
ALTER TABLE `master__tx_balance`
 ADD PRIMARY KEY (`balance_id`), ADD KEY `fk_txbal_ag_id` (`agent_id`);

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
 ADD KEY `fk_orde_or_id` (`order_id`), ADD KEY `fk_orde_var_id` (`varian_id`);

--
-- Indexes for table `transaction__shipping`
--
ALTER TABLE `transaction__shipping`
 ADD PRIMARY KEY (`shipping_id`), ADD KEY `fk_ship_or_id` (`order_id`);

--
-- Indexes for table `transaction__shipping_product`
--
ALTER TABLE `transaction__shipping_product`
 ADD KEY `fk_shippro_txship_id` (`tx_shipping_id`), ADD KEY `fk_shippro_var_id` (`varian_id`);

--
-- Indexes for table `transaction__tx_shipping`
--
ALTER TABLE `transaction__tx_shipping`
 ADD PRIMARY KEY (`tx_shipping_id`), ADD KEY `fk_tx_ship_id` (`shipping_id`), ADD KEY `fk_tx_ag_id` (`agent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faq__kategori`
--
ALTER TABLE `faq__kategori`
MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `faq__pertanyaan`
--
ALTER TABLE `faq__pertanyaan`
MODIFY `id_pertanyaan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `master__admin`
--
ALTER TABLE `master__admin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master__admin_information`
--
ALTER TABLE `master__admin_information`
MODIFY `information_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master__agent_rating`
--
ALTER TABLE `master__agent_rating`
MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master__city`
--
ALTER TABLE `master__city`
MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `master__member`
--
ALTER TABLE `master__member`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `master__tx_balance`
--
ALTER TABLE `master__tx_balance`
MODIFY `balance_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product__category`
--
ALTER TABLE `product__category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product__varian`
--
ALTER TABLE `product__varian`
MODIFY `varian_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `transaction__order`
--
ALTER TABLE `transaction__order`
MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction__shipping`
--
ALTER TABLE `transaction__shipping`
MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction__tx_shipping`
--
ALTER TABLE `transaction__tx_shipping`
MODIFY `tx_shipping_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `faq__pertanyaan`
--
ALTER TABLE `faq__pertanyaan`
ADD CONSTRAINT `fk_faq_id_kat` FOREIGN KEY (`id_kategori`) REFERENCES `faq__kategori` (`id_kategori`);

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
ADD CONSTRAINT `fk_mem_ci_id` FOREIGN KEY (`city_id`) REFERENCES `master__city` (`city_id`);

--
-- Constraints for table `master__tx_balance`
--
ALTER TABLE `master__tx_balance`
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
-- Constraints for table `transaction__shipping`
--
ALTER TABLE `transaction__shipping`
ADD CONSTRAINT `fk_ship_or_id` FOREIGN KEY (`order_id`) REFERENCES `transaction__order` (`order_id`);

--
-- Constraints for table `transaction__shipping_product`
--
ALTER TABLE `transaction__shipping_product`
ADD CONSTRAINT `fk_shippro_txship_id` FOREIGN KEY (`tx_shipping_id`) REFERENCES `transaction__tx_shipping` (`tx_shipping_id`),
ADD CONSTRAINT `fk_shippro_var_id` FOREIGN KEY (`varian_id`) REFERENCES `product__varian` (`varian_id`);

--
-- Constraints for table `transaction__tx_shipping`
--
ALTER TABLE `transaction__tx_shipping`
ADD CONSTRAINT `fk_tx_ag_id` FOREIGN KEY (`agent_id`) REFERENCES `master__member` (`id`),
ADD CONSTRAINT `fk_tx_ship_id` FOREIGN KEY (`shipping_id`) REFERENCES `transaction__shipping` (`shipping_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
