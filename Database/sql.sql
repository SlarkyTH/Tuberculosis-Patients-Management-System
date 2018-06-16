/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.30-MariaDB : Database - pj
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pj` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `pj`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `admin_id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `admin_sex` char(1) NOT NULL,
  `admin_firstname` varchar(50) NOT NULL,
  `admin_lastname` varchar(50) NOT NULL,
  `admin_status` int(1) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `admin` */

insert  into `admin`(`admin_id`,`username`,`password`,`admin_sex`,`admin_firstname`,`admin_lastname`,`admin_status`) values (1,'admin','f90da451a3a00da2c297054c22ad7d82','M','แอดมิน','ใจดี',1);

/*Table structure for table `appointment` */

DROP TABLE IF EXISTS `appointment`;

CREATE TABLE `appointment` (
  `appointment_id` int(5) NOT NULL AUTO_INCREMENT,
  `appointment_status` varchar(1) NOT NULL,
  `appoint_datetime` datetime NOT NULL,
  `doctor_id` int(5) NOT NULL,
  `treatment_id` int(5) NOT NULL,
  `change_id` int(5) DEFAULT NULL,
  `patient_id` int(5) NOT NULL,
  PRIMARY KEY (`appointment_id`),
  KEY `patient_id` (`patient_id`),
  KEY `treatment_id` (`treatment_id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `change_id` (`change_id`),
  CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`),
  CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`),
  CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`doctor_id`),
  CONSTRAINT `appointment_ibfk_4` FOREIGN KEY (`change_id`) REFERENCES `change_appointment` (`change_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `appointment` */

/*Table structure for table `change_appointment` */

DROP TABLE IF EXISTS `change_appointment`;

CREATE TABLE `change_appointment` (
  `change_id` int(5) NOT NULL AUTO_INCREMENT,
  `change_datetime` datetime NOT NULL,
  `old_appoint` datetime NOT NULL,
  `new_appoint` datetime NOT NULL,
  `nurse_id` int(5) NOT NULL,
  PRIMARY KEY (`change_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `change_appointment` */

/*Table structure for table `dispend` */

DROP TABLE IF EXISTS `dispend`;

CREATE TABLE `dispend` (
  `treatment_id` int(5) NOT NULL,
  `medicine_id` int(5) NOT NULL,
  `unit_id` int(5) NOT NULL,
  `amount` int(255) NOT NULL,
  PRIMARY KEY (`treatment_id`,`medicine_id`,`unit_id`),
  KEY `unit_id` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `dispend` */

/*Table structure for table `doctor` */

DROP TABLE IF EXISTS `doctor`;

CREATE TABLE `doctor` (
  `doctor_id` int(5) NOT NULL AUTO_INCREMENT,
  `doctor_status` int(1) NOT NULL,
  `doctor_username` varchar(15) NOT NULL,
  `doctor_password` varchar(32) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `sex` char(1) NOT NULL,
  `tel` varchar(10) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`doctor_id`),
  UNIQUE KEY `unique` (`doctor_username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `doctor` */

insert  into `doctor`(`doctor_id`,`doctor_status`,`doctor_username`,`doctor_password`,`first_name`,`last_name`,`sex`,`tel`,`email`) values (1,1,'doctor','4535c01189501b57901d11af72973431','หมอใจร้าย','มากๆ','M','0911255585','doctor@hotmail.com');

/*Table structure for table `medicine` */

DROP TABLE IF EXISTS `medicine`;

CREATE TABLE `medicine` (
  `medicine_id` int(5) NOT NULL AUTO_INCREMENT,
  `medicine_name` varchar(40) NOT NULL,
  `unit_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`medicine_id`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `medicine_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `medicine` */

/*Table structure for table `nurse` */

DROP TABLE IF EXISTS `nurse`;

CREATE TABLE `nurse` (
  `nurse_id` int(5) NOT NULL AUTO_INCREMENT,
  `nurse_status` int(1) NOT NULL,
  `nurse_username` varchar(15) NOT NULL,
  `nurse_password` varchar(32) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `sex` char(1) NOT NULL,
  `email` varchar(25) DEFAULT NULL,
  `tel` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`nurse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nurse` */

insert  into `nurse`(`nurse_id`,`nurse_status`,`nurse_username`,`nurse_password`,`first_name`,`last_name`,`sex`,`email`,`tel`) values (1,1,'nurse','2517108b88087e967f5979d973fbc70b','พยาบาลสวย','จริงๆ','F','nurse@hotmail.com','0998484585');

/*Table structure for table `patient` */

DROP TABLE IF EXISTS `patient`;

CREATE TABLE `patient` (
  `patient_id` int(5) NOT NULL AUTO_INCREMENT,
  `patient_status` varchar(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `national_id` varchar(13) NOT NULL,
  `sex` char(1) NOT NULL,
  `parent_name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `weight` int(3) NOT NULL,
  `privilege` int(1) NOT NULL,
  `allergic` varchar(200) DEFAULT NULL,
  `nurse_id` int(5) NOT NULL,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `patient` */

/*Table structure for table `treatment` */

DROP TABLE IF EXISTS `treatment`;

CREATE TABLE `treatment` (
  `treatment_id` int(5) NOT NULL AUTO_INCREMENT,
  `treatment_datetime` datetime NOT NULL,
  `symptom` varchar(200) NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `doctor_id` int(5) NOT NULL,
  `patient_id` int(5) NOT NULL,
  PRIMARY KEY (`treatment_id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `treatment_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`doctor_id`),
  CONSTRAINT `treatment_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `treatment` */

/*Table structure for table `unit` */

DROP TABLE IF EXISTS `unit`;

CREATE TABLE `unit` (
  `unit_id` int(5) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(50) NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `unit` */

insert  into `unit`(`unit_id`,`unit_name`) values (1,'มิลลิกรัม'),(2,'ออนซ์'),(3,'มิลลิลิตร'),(4,'กรัม'),(5,'เม็ด'),(6,'แผง');

/*Table structure for table `working_date` */

DROP TABLE IF EXISTS `working_date`;

CREATE TABLE `working_date` (
  `no` int(5) NOT NULL AUTO_INCREMENT,
  `work_time_in` time NOT NULL,
  `work_time_out` time NOT NULL,
  `count_patient` int(100) NOT NULL,
  `work_date` date NOT NULL,
  `doctor_id` int(5) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `working_date` */

/*Table structure for table `x_ray` */

DROP TABLE IF EXISTS `x_ray`;

CREATE TABLE `x_ray` (
  `x_ray_id` int(5) NOT NULL AUTO_INCREMENT,
  `x_ray_file` varchar(200) NOT NULL,
  `treatment_id` int(5) NOT NULL,
  PRIMARY KEY (`x_ray_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `x_ray` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
