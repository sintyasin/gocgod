-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2016 at 10:40 AM
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
-- Table structure for table `master__admin`
--

CREATE TABLE IF NOT EXISTS `master__admin` (
`id` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `city_id` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master__admin_information`
--

CREATE TABLE IF NOT EXISTS `master__admin_information` (
  `admin_id` int(11) NOT NULL,
  `information` text NOT NULL,
`information_id` int(11) NOT NULL
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
`rating_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master__city`
--

CREATE TABLE IF NOT EXISTS `master__city` (
`city_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status_user` int(11) NOT NULL,
  `verification` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `bank_account` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master__tx_balance`
--

CREATE TABLE IF NOT EXISTS `master__tx_balance` (
`balance_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `balance_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product__category`
--

CREATE TABLE IF NOT EXISTS `product__category` (
`category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product__testimonial`
--

CREATE TABLE IF NOT EXISTS `product__testimonial` (
  `testimonial_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `testimonial` varchar(500) NOT NULL,
  `approval` int(11) NOT NULL
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
  `weight` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `status_confirmed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction__order_detail`
--

CREATE TABLE IF NOT EXISTS `transaction__order_detail` (
  `order_id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `varian_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
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
  `total_week` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction__shipping_product`
--

CREATE TABLE IF NOT EXISTS `transaction__shipping_product` (
  `tx_shipping_id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction__tx_shipping`
--

CREATE TABLE IF NOT EXISTS `transaction__tx_shipping` (
  `shipping_id` int(11) NOT NULL,
`tx_shipping_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `date_shipping` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

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
MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master__member`
--
ALTER TABLE `master__member`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master__tx_balance`
--
ALTER TABLE `master__tx_balance`
MODIFY `balance_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product__category`
--
ALTER TABLE `product__category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product__varian`
--
ALTER TABLE `product__varian`
MODIFY `varian_id` int(11) NOT NULL AUTO_INCREMENT;
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
