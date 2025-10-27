/*
SQLyog Community v12.5.0 (64 bit)
MySQL - 8.0.24 : Database - fabrictouch_service
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fabrictouch_service` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `fabrictouch_service`;

/*Table structure for table `service_tickets` */

DROP TABLE IF EXISTS `service_tickets`;

CREATE TABLE `service_tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `age` varchar(10) DEFAULT NULL,
  `item_category` varchar(50) DEFAULT NULL,
  `service_id` varchar(50) DEFAULT NULL,
  `sold_to_party` varchar(150) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_on` date DEFAULT NULL,
  `user_status` varchar(100) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `site_code` varchar(50) DEFAULT NULL,
  `call_bifurcation` varchar(150) DEFAULT NULL,
  `part_required` varchar(255) DEFAULT NULL,
  `changed_on` date DEFAULT NULL,
  `call_completion_date` date DEFAULT NULL,
  `serial_no` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `sales_office` varchar(150) DEFAULT NULL,
  `confirmation_no` varchar(100) DEFAULT NULL,
  `transaction_type` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `availability` varchar(150) DEFAULT NULL,
  `higher_level_item` varchar(100) DEFAULT NULL,
  `sla` varchar(150) DEFAULT NULL,
  `billing` varchar(100) DEFAULT NULL,
  `bill_to_party` varchar(150) DEFAULT NULL,
  `pr_number` varchar(150) DEFAULT NULL,
  `invoice_number` varchar(150) DEFAULT NULL,
  `sto_number` varchar(150) DEFAULT NULL,
  `so_number` varchar(150) DEFAULT NULL,
  `article_code` varchar(255) DEFAULT NULL,
  `address` text,
  `service_characteristi` varchar(100) DEFAULT NULL,
  `product_source` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `warranty` varchar(50) DEFAULT NULL,
  `deferment_date` date DEFAULT NULL,
  `field_category` varchar(50) DEFAULT NULL,
  `feedback` text,
  `manager` varchar(100) DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
