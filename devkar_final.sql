-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.11-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for devkar_courses_db
CREATE DATABASE IF NOT EXISTS `devkar_final_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `devkar_final_db`;devkar_final_db


-- Dumping structure for table devkar_courses_db.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `COURSE_ID` int(5) NOT NULL AUTO_INCREMENT,
  `COURSE_CODE` varchar(50) DEFAULT NULL,
  `COURSE_TITLE` varchar(50) DEFAULT NULL,
  `COURSE_CREDITS` int(10) DEFAULT NULL,
  `DEPT_ID` int(5) DEFAULT NULL,
  PRIMARY KEY (`COURSE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- Dumping data for table devkar_courses_db.courses: ~34 rows (approximately)
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` (`COURSE_ID`, `COURSE_CODE`, `COURSE_TITLE`, `COURSE_CREDITS`, `DEPT_ID`) VALUES
	(1, 'Arch_001', 'Building Technologies', 4, 1),
	(2, 'Arch_002', 'Design Methods', 3, 1),
	(3, 'Bioc_001', 'Experiential Learning', 3, 4),
	(4, 'Bioc_003', 'Biochemistry Laboratory', 4, 4),
	(5, 'Chem_005', 'Biophysical Chemistry', 3, 5),
	(6, 'Crim_002', 'Criminal Justice', 6, 6),
	(7, 'Chem_001', 'General Chemistry', 2, 5),
	(8, 'Finance_001', 'Investment Management', 4, 8),
	(9, 'Finance_002', 'Financial Derivatives', 3, 8),
	(10, 'Gemo_001', 'Introductory Colored Stones', 3, 10),
	(11, 'Gemo_002', 'Advanced Colored Stones', 3, 10),
	(12, 'Maths_001', 'Calculus', 3, 11),
	(13, 'Maths_002', 'Algebra', 4, 11),
	(14, 'Busi_001', 'Business Process Management', 3, 13),
	(15, 'Hist_001', 'Western Intellectual History I', 3, 14),
	(16, 'Hist_002', 'Western Intellectual History II', 4, 14),
	(17, 'Hist_003', 'Societies of the World', 4, 14),
	(18, 'Chem_005', 'Explorations in Chemistry', 4, 5),
	(19, 'Chem_006', 'Survey of Organic Chemistry', 2, 5),
	(20, 'Bioc_004', 'Biochemical Methods', 6, 4),
	(21, 'Bioc_005', 'Plant Biochemistry', 4, 4),
	(22, 'Crim_004', 'Biosocial criminology', 2, 6),
	(23, 'Crim_005', 'Crime and Human Development', 4, 6),
	(24, 'Finance_003', 'Corporate Valuation', 5, 8),
	(25, 'Finance_004', 'International Corporate Finance', 4, 8),
	(26, 'Finance_005', 'Advanced Corporate Finance', 6, 8),
	(27, 'Gemo_003', 'Colored Stones & Diamonds Lab', 6, 10),
	(28, 'Gemo_004', 'Diamonds', 2, 10),
	(29, 'Busi_003', 'Entrepreneurship Concentration', 2, 13),
	(30, 'Busi_004', 'International Business Concentration', 4, 13),
	(31, 'Busi_005', 'Supply Chain Management', 3, 13),
	(32, 'Astro_002', 'Interstellar Matter', 4, 15),
	(33, 'Astro_003', 'Stars', 2, 15),
	(34, 'Astro_004', 'Galaxies', 4, 15);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;


-- Dumping structure for table devkar_courses_db.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `DEPT_ID` int(5) NOT NULL AUTO_INCREMENT,
  `DEPT_NAME` varchar(50) DEFAULT NULL,
  `DEPT_YEAR` int(10) DEFAULT NULL,
  `UNIV_ID` int(5) DEFAULT NULL,
  `MAIL_OFFICE_ID` int(5) DEFAULT NULL,
  PRIMARY KEY (`DEPT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Dumping data for table devkar_courses_db.departments: ~15 rows (approximately)
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` (`DEPT_ID`, `DEPT_NAME`, `DEPT_YEAR`, `UNIV_ID`, `MAIL_OFFICE_ID`) VALUES
	(1, 'Architecture', 1990, 3, 2),
	(2, 'Biology', 1991, 2, 4),
	(3, 'Biomedical', 1998, 4, 14),
	(4, 'Biochemistry', 1889, 6, 8),
	(5, 'Chemistry', 1891, 5, 10),
	(6, 'Criminology', 1988, 9, 1),
	(7, 'Asian Languages', 1891, 8, 5),
	(8, 'Finance', 1991, 11, 11),
	(9, 'Geology', 1791, 1, 12),
	(10, 'Gemology', 1971, 6, 8),
	(11, 'Maths', 1892, 5, 10),
	(12, 'Physics', 1991, 2, 4),
	(13, 'Business', 2000, 4, 14),
	(14, 'History', 1991, 15, 3),
	(15, 'Astronomy', 1881, 12, 6);
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;


-- Dumping structure for table devkar_courses_db.mailoffice
CREATE TABLE IF NOT EXISTS `mailoffice` (
  `OFFICE_ID` int(5) NOT NULL AUTO_INCREMENT,
  `INCHARGE_NAME` varchar(50) NOT NULL DEFAULT '0',
  `OFFICE_FLOOR` int(10) NOT NULL DEFAULT '0',
  `OFFICE_DAYS` varchar(50) DEFAULT NULL,
  `CONTACT_MAIL` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`OFFICE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Dumping data for table devkar_courses_db.mailoffice: ~16 rows (approximately)
/*!40000 ALTER TABLE `mailoffice` DISABLE KEYS */;
INSERT INTO `mailoffice` (`OFFICE_ID`, `INCHARGE_NAME`, `OFFICE_FLOOR`, `OFFICE_DAYS`, `CONTACT_MAIL`) VALUES
	(1, 'Ashley', 1, 'Mon-Fri', 'ashley@gmail.com'),
	(2, 'Shannon', 1, 'Mon-Thurs', 'shannon@gmail.com'),
	(3, 'Kyle', 1, 'Mon-Thurs', 'kyle@gmail.com'),
	(4, 'Bill', 2, 'Mon-Thurs', 'bill@gmail.com'),
	(5, 'George', 1, 'Mon-Thurs', 'george@gmail.com'),
	(6, 'Scot', 3, 'Mon-Thurs', 'scot@gmail.com'),
	(7, 'Eric', 1, 'Mon-Wed', 'eric@gmail.com'),
	(8, 'Todd', 2, 'Mon-Thurs', 'todd@gmail.com'),
	(9, 'Kent', 3, 'Mon-Thurs', 'kent@gmail.com'),
	(10, 'Charles', 1, 'Mon-Wed', 'charles@gmail.com'),
	(11, 'Ryan', 2, 'Mon-Thurs', 'ryan@gmail.com'),
	(12, 'Tommy', 1, 'Mon-Fri', 'tommy@gmail.com'),
	(13, 'Steve', 3, 'Mon-Thurs', 'steve@gmail.com'),
	(14, 'Mark', 1, 'Mon-Fri', 'mark@gmail.com'),
	(15, 'Nick', 2, 'Mon-Thurs', 'nick@gmail.com'),
	(16, 'Henry', 2, 'Mon-Fri', 'henry@gmail.com');
/*!40000 ALTER TABLE `mailoffice` ENABLE KEYS */;


-- Dumping structure for table devkar_courses_db.professors
CREATE TABLE IF NOT EXISTS `professors` (
  `PROF_ID` int(5) NOT NULL AUTO_INCREMENT,
  `PROF_FNAME` varchar(50) DEFAULT '0',
  `PROF_LNAME` varchar(50) DEFAULT '0',
  `PROF_CABIN` varchar(50) DEFAULT '0',
  `PROF_EMAIL` varchar(50) DEFAULT '0',
  PRIMARY KEY (`PROF_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- Dumping data for table devkar_courses_db.professors: ~19 rows (approximately)
/*!40000 ALTER TABLE `professors` DISABLE KEYS */;
INSERT INTO `professors` (`PROF_ID`, `PROF_FNAME`, `PROF_LNAME`, `PROF_CABIN`, `PROF_EMAIL`) VALUES
	(1, 'Balcom', 'Gaylord', 'Alexander Hall_1101', 'balcom@gmail.com'),
	(2, 'Kacy', 'Popler', 'Alexander Hall_2105', 'kacy@gmail.com'),
	(3, 'Lucila', 'Tiger', 'Mason Hall_4205', 'lucila@gmail.com'),
	(4, 'Jeffy', 'Parnel', 'Richmond_1100', 'jeffy@gmail.com'),
	(5, 'Carmen', 'Caylor', 'Woods Hall_1300', 'carmen@gmail.com'),
	(6, 'Minta', 'Loften', 'Mason Hall_1308', 'minta@gmail.com'),
	(7, 'Kim', 'Adams', 'Wilson Hall_4105', 'kim@gmail.com'),
	(8, 'Teri', 'Adams', 'Collins_4309', 'teri@gmail.com'),
	(9, 'Gloria', 'Acosta', 'Alexander Hall_4106', 'gloria@gmail.com'),
	(10, 'Scotty', 'Wallen', 'J. Jones_3401', 'scotty@gmail.com'),
	(11, 'Evard', 'Hege', 'Richmond_1200', 'evard@gmail.com'),
	(12, 'Henry', 'Mansen', 'Collins_2200', 'henry@gmail.com'),
	(13, 'Jonathan', 'Zellers', 'Wilson Hall_3208', 'jonathan@gmail.com'),
	(14, 'Michelle', 'Robinson', 'Mason Hall_2200', 'michelle@gmail.com'),
	(15, 'Cara', 'Carlson', 'J. Jones_2408', 'cara@gmail.com'),
	(16, 'Caren', 'Ganett', 'Woods Hall_2301', 'caren@gmail.com'),
	(17, 'Mark', 'Robinson', 'AlexanderHall_3200', 'mark@gmail.com'),
	(21, 'Henrick', 'Bauer', 'Hilton Hall_1207', 'henrick@gmail.com'),
	(22, 'Michael', 'Simson', 'Manson Hall_2100', 'michael@gmail.com');
/*!40000 ALTER TABLE `professors` ENABLE KEYS */;


-- Dumping structure for table devkar_courses_db.sections
CREATE TABLE IF NOT EXISTS `sections` (
  `SECTION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SECTION_CODE` int(11) DEFAULT '0',
  `YEAR` int(11) DEFAULT '2000',
  `SEMESTER` varchar(50) DEFAULT '0',
  `COURSE_ID` int(11) DEFAULT '0',
  `PROF_ID` int(11) DEFAULT '0',
  PRIMARY KEY (`SECTION_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- Dumping data for table devkar_courses_db.sections: ~42 rows (approximately)
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` (`SECTION_ID`, `SECTION_CODE`, `YEAR`, `SEMESTER`, `COURSE_ID`, `PROF_ID`) VALUES
	(2, 1020, 2017, 'Fall', 1, 3),
	(3, 1010, 2016, 'Summer', 4, 6),
	(4, 1020, 2016, 'Summer', 4, 2),
	(5, 1010, 2016, 'Summer', 16, 10),
	(6, 1020, 2016, 'Fall', 16, 10),
	(7, 1030, 2016, 'Fall', 16, 13),
	(8, 1010, 2016, 'Spring', 14, 2),
	(9, 1010, 2016, 'Spring', 30, 3),
	(10, 1020, 2016, 'Summer', 30, 10),
	(11, 1010, 2016, 'Summer', 24, 6),
	(12, 1020, 2016, 'Fall', 24, 7),
	(13, 1030, 2016, 'Spring', 24, 14),
	(14, 1010, 2016, 'Fall', 26, 15),
	(15, 1010, 2016, 'Spring', 12, 4),
	(16, 1010, 2016, 'Fall', 13, 8),
	(17, 1010, 2016, 'Fall', 2, 6),
	(18, 1020, 2016, 'Fall', 2, 3),
	(19, 1030, 2017, 'Spring', 2, 6),
	(20, 1010, 2016, 'Fall', 3, 4),
	(22, 1010, 2016, 'Fall', 24, 11),
	(23, 1020, 2016, 'Fall', 24, 12),
	(24, 1010, 2017, 'Spring', 22, 15),
	(25, 1020, 2016, 'Fall', 22, 15),
	(26, 1010, 2016, 'Fall', 20, 1),
	(27, 1020, 2016, 'Fall', 20, 8),
	(28, 1010, 2016, 'Fall', 18, 13),
	(29, 1020, 2017, 'Spring', 18, 13),
	(30, 1010, 2016, 'Fall', 16, 12),
	(31, 1020, 2016, 'Summer', 16, 10),
	(32, 1030, 2017, 'Spring', 16, 12),
	(37, 2010, 2017, 'Fall ', 10, 1),
	(38, 1010, 2017, 'Summer', 10, 11),
	(39, 1010, 2016, 'Fall', 32, 9),
	(40, 1020, 2016, 'Fall', 32, 12),
	(41, 1010, 2017, 'Summer', 34, 4),
	(43, 1010, 2017, 'Spring', 6, 4),
	(45, 1010, 2016, 'Fall', 1, 1),
	(46, 1010, 2017, 'Summer', 33, 7),
	(47, 1010, 2017, 'Fall', 33, 14),
	(48, 1040, 2017, 'Summer ', 2, 21),
	(49, 1010, 2016, 'Summer', 17, 5),
	(59, 1010, 2017, 'Summer', 25, 2);
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;


-- Dumping structure for table devkar_courses_db.universities
CREATE TABLE IF NOT EXISTS `universities` (
  `UNIV_ID` int(11) NOT NULL AUTO_INCREMENT,
  `UNIV_NAME` varchar(50) DEFAULT NULL,
  `UNIV_STATE` varchar(50) DEFAULT NULL,
  `UNIV_COUNTRY` varchar(50) DEFAULT NULL,
  `TIME_CREATED` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`UNIV_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Dumping data for table devkar_courses_db.universities: ~15 rows (approximately)
/*!40000 ALTER TABLE `universities` DISABLE KEYS */;
INSERT INTO `universities` (`UNIV_ID`, `UNIV_NAME`, `UNIV_STATE`, `UNIV_COUNTRY`, `TIME_CREATED`) VALUES
	(1, 'University of Maryland', 'Maryland', 'US', '2016-05-07 10:06:04'),
	(2, 'University of Texas', 'Texas', 'USA', '2016-05-07 10:07:13'),
	(3, 'Arizona State Univeristy', 'Arizona', 'USA', '2016-05-07 10:16:50'),
	(4, 'Arkansas Tech University', 'Arkansas', 'USA', '2016-05-07 10:19:11'),
	(5, 'University of California, Berkeley', 'California', 'USA', '2016-05-07 10:27:44'),
	(6, 'Sonoma State University', 'California', 'USA', '2016-05-07 10:27:44'),
	(7, 'Adams State University', 'Colorado', 'USA', '2016-05-07 10:27:44'),
	(8, 'University of Delaware', 'Delware', 'USA', '2016-05-07 10:27:44'),
	(9, 'Florida Atlantic University', 'Florida', 'USA', '2016-05-07 10:27:45'),
	(10, 'College of Coastal Georgia', 'Georgia', 'USA', '2016-05-07 10:27:45'),
	(11, 'Columbus State University', 'Georgia', 'USA', '2016-05-07 10:27:45'),
	(12, 'University of Hawaii at Hilo', 'Hawaii', 'USA', '2016-05-07 10:27:45'),
	(13, 'Ball State University', 'Indiana', 'USA', '2016-05-07 10:27:45'),
	(14, 'Emporia State University', 'Kansas', 'USA', '2016-05-07 10:27:45'),
	(15, 'Michigan State University ', 'Michigan', 'USA', '2016-05-07 10:27:45');
/*!40000 ALTER TABLE `universities` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
