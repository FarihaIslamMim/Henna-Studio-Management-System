-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2026 at 07:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `henna_studio_management_and_booking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `Artist_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `User_Password` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Specialization` varchar(100) DEFAULT NULL CHECK (`Specialization` in ('Bridal','Arabic','Indian','Pakistani','Simple','Floral','Mandala','Moroccan','Minimalist','Traditional','Modern','Glitter','Eid Special','Festival','Finger Design','Back Hand','Front Hand','Full Hand','SEMI-BRIDAL')),
  `Experience_Years` int(11) DEFAULT NULL CHECK (`Experience_Years` >= 0),
  `Joining_Date` date DEFAULT curdate(),
  `Status` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`Artist_ID`, `Name`, `Phone`, `Email`, `User_Password`, `Address`, `Specialization`, `Experience_Years`, `Joining_Date`, `Status`) VALUES
(1, 'Mim', '01744-444444', 'mimartist@gmail.com', 'mim123', 'Sylhet', 'Bridal', 3, '2026-07-10', 'Active'),
(2, 'Fabia', '01855-555555', 'fabia@gmail.com', 'fabia123', 'Sylhet', 'Arabic', 2, '2026-07-10', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `Booking_ID` int(11) NOT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `Artist_ID` int(11) DEFAULT NULL,
  `Design_ID` int(11) DEFAULT NULL,
  `Booking_Date` date NOT NULL,
  `Booking_Time` time NOT NULL,
  `Status` varchar(20) DEFAULT 'CONFIRMED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`Booking_ID`, `Customer_ID`, `Artist_ID`, `Design_ID`, `Booking_Date`, `Booking_Time`, `Status`) VALUES
(1, 1, 1, 1, '2026-07-20', '10:00:00', 'CONFIRMED'),
(2, 2, 2, 2, '2026-07-21', '14:30:00', 'CONFIRMED'),
(3, 1, 2, 3, '2026-07-22', '16:00:00', 'CONFIRMED');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `Customer_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Registration_Date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`Customer_ID`, `Name`, `Phone`, `Email`, `Password`, `Address`, `Registration_Date`) VALUES
(1, 'Masuma', '01822-222222', 'masuma@gmail.com', 'masuma123', 'Sylhet', '2026-07-10'),
(2, 'Ziyoda', '01933-333333', 'ziyoda@gmail.com', 'ziyoda123', 'Sylhet', '2026-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `Design_ID` int(11) NOT NULL,
  `Design_Name` varchar(100) NOT NULL,
  `Category` varchar(50) DEFAULT NULL CHECK (`Category` in ('Bridal','Arabic','Indian','Pakistani','Simple','Floral','Mandala','Moroccan','Minimalist','Traditional','Modern','Glitter','Eid Special','Festival','Finger Design','Back Hand','Front Hand','Full Hand','SEMI-BRIDAL')),
  `Price` decimal(10,2) DEFAULT NULL CHECK (`Price` > 0),
  `Availability` enum('Available','Unavailable') DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`Design_ID`, `Design_Name`, `Category`, `Price`, `Availability`, `Description`) VALUES
(1, 'Royal Bridal', 'Bridal', 4000.00, 'Available', 'Full hand bridal henna'),
(2, 'Arabic Bloom', 'Arabic', 2000.00, 'Unavailable', 'Elegant Arabic design'),
(3, 'Flower Magic', 'Floral', 1500.00, 'Available', 'Beautiful floral pattern');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `Payment_ID` int(11) NOT NULL,
  `Booking_ID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL CHECK (`Amount` >= 0),
  `Payment_Method` varchar(30) DEFAULT NULL,
  `Payment_Date` date DEFAULT curdate(),
  `Payment_Status` varchar(20) DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`Payment_ID`, `Booking_ID`, `Amount`, `Payment_Method`, `Payment_Date`, `Payment_Status`) VALUES
(1, 1, 4000.00, 'Cash', '2026-07-10', 'Paid'),
(2, 2, 2000.00, 'Bkash', '2026-07-10', 'Paid'),
(3, 3, 1500.00, 'Nagad', '2026-07-10', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `Review_ID` int(11) NOT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `Booking_ID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `Comment` text DEFAULT NULL,
  `Review_Date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`Review_ID`, `Customer_ID`, `Booking_ID`, `Rating`, `Comment`, `Review_Date`) VALUES
(1, 1, 1, 5, 'Excellent service', '2026-07-10'),
(2, 2, 2, 4, 'Beautiful design', '2026-07-10'),
(3, 1, 3, 5, 'Highly recommended', '2026-07-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`Artist_ID`),
  ADD UNIQUE KEY `Phone` (`Phone`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`),
  ADD KEY `Artist_ID` (`Artist_ID`),
  ADD KEY `Design_ID` (`Design_ID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`Customer_ID`),
  ADD UNIQUE KEY `Phone` (`Phone`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`Design_ID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Booking_ID` (`Booking_ID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`Review_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`),
  ADD KEY `Booking_ID` (`Booking_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customers` (`Customer_ID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`Artist_ID`) REFERENCES `artists` (`Artist_ID`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`Design_ID`) REFERENCES `designs` (`Design_ID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customers` (`Customer_ID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
