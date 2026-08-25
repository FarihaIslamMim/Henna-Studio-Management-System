-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2026 at 09:27 AM
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
-- Database: `henna studio management & booking system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `Username`, `Password`, `Email`, `reset_token`, `token_expiry`) VALUES
(1, 'Tasfi', 'tasfi@22', 'tasfi22@gmail.com', '5bcd10e4580578904a5f2fecdbbb448502b71b68df02807f05378a02d5d1f52c', '2026-07-19 19:43:08'),
(4, 'Shimu', 'shimu@19', 'shimu19@gmail.com', NULL, NULL),
(5, 'Mim', 'farihamim@21', 'farihaislammim2@gmail.com', NULL, NULL);

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
(1, 'Fariha Mim', '01703387094', 'mimartist@gmail.com', 'mim123', 'Sylhet', 'Bridal', 3, '2026-07-10', 'Active'),
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
  `Status` enum('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
  `Custom_Design_Image` varchar(255) DEFAULT NULL,
  `Custom_Design_Note` text DEFAULT NULL,
  `Payment_Option` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`Booking_ID`, `Customer_ID`, `Artist_ID`, `Design_ID`, `Booking_Date`, `Booking_Time`, `Status`, `Custom_Design_Image`, `Custom_Design_Note`, `Payment_Option`) VALUES
(1, 1, 1, 1, '2026-07-20', '10:00:00', 'Confirmed', NULL, NULL, NULL),
(2, 2, 2, 2, '2026-07-21', '14:30:00', 'Confirmed', NULL, NULL, NULL),
(3, 1, 2, 3, '2026-07-22', '16:00:00', 'Confirmed', NULL, NULL, NULL),
(5, 8, 1, 10, '2026-08-01', '15:00:00', 'Cancelled', NULL, NULL, NULL),
(6, 8, 2, 8, '2026-08-04', '16:00:00', 'Confirmed', NULL, NULL, NULL),
(7, 9, 1, 5, '2026-08-19', '19:00:00', 'Confirmed', NULL, NULL, NULL),
(9, 11, 1, 3, '2026-08-03', '18:00:00', 'Pending', NULL, NULL, NULL),
(10, 12, 2, 3, '2026-08-12', '19:00:00', 'Pending', NULL, NULL, NULL),
(11, 14, 1, 6, '2026-08-07', '19:00:00', 'Pending', NULL, NULL, NULL),
(12, 15, 2, 9, '2026-08-27', '13:09:00', 'Pending', NULL, NULL, NULL),
(13, 16, 2, 8, '2026-08-12', '20:00:00', 'Pending', NULL, NULL, NULL),
(14, 17, 1, 7, '2026-08-22', '17:25:00', 'Pending', NULL, NULL, NULL),
(15, 18, 2, 8, '2026-08-26', '19:04:00', 'Pending', NULL, NULL, NULL),
(16, 19, 1, 4, '2026-09-15', '16:00:00', 'Pending', NULL, NULL, NULL),
(17, 21, 1, 11, '2026-10-06', '17:00:00', 'Pending', NULL, NULL, NULL),
(18, 22, 1, NULL, '2026-08-08', '13:00:00', 'Pending', NULL, NULL, NULL),
(19, 23, 2, 6, '2026-08-28', '13:20:00', 'Pending', NULL, NULL, NULL),
(20, 16, 1, NULL, '2026-08-31', '15:00:00', 'Pending', NULL, NULL, 'Now'),
(21, 24, 1, 8, '2026-12-01', '14:00:00', 'Pending', NULL, NULL, 'Later'),
(22, 25, 1, NULL, '2026-11-15', '15:30:00', 'Pending', NULL, NULL, NULL),
(23, 26, 2, 3, '2026-10-24', '15:30:00', 'Pending', NULL, NULL, 'Now'),
(24, 27, 2, NULL, '2026-08-06', '17:30:00', 'Pending', NULL, NULL, NULL),
(25, 28, 2, 3, '2026-12-01', '13:00:00', 'Pending', NULL, NULL, 'Now'),
(26, 26, 1, NULL, '2026-08-13', '13:07:00', 'Pending', NULL, NULL, NULL),
(27, 29, 1, 8, '2026-08-31', '20:04:00', 'Pending', NULL, NULL, 'Now'),
(28, 30, 2, 1, '2026-08-22', '20:30:00', 'Pending', NULL, NULL, 'Now'),
(29, 31, 2, 10, '2026-08-26', '18:50:00', 'Pending', NULL, NULL, 'Now'),
(30, 32, 2, 9, '2026-08-18', '10:30:00', 'Pending', NULL, NULL, 'Now'),
(31, 21, 2, 8, '2026-08-21', '14:57:00', 'Pending', NULL, NULL, 'Now'),
(32, 33, 2, 9, '2026-08-24', '16:55:00', 'Pending', NULL, NULL, 'Now'),
(33, 34, 1, 8, '2026-08-21', '15:22:00', 'Pending', NULL, NULL, 'Now'),
(34, 35, 1, 9, '2026-08-25', '11:05:00', 'Pending', NULL, NULL, 'Now'),
(35, 36, 1, 2, '2026-08-26', '13:34:00', 'Pending', NULL, NULL, 'Now'),
(36, 37, 2, 1, '2026-08-23', '18:38:00', 'Pending', NULL, NULL, 'Now'),
(37, 38, 1, 2, '2026-09-09', '12:55:00', 'Pending', NULL, NULL, 'Now'),
(38, 39, 2, 9, '2026-08-26', '20:59:00', 'Pending', NULL, NULL, 'Now'),
(39, 40, 2, 2, '2026-09-15', '13:04:00', 'Pending', NULL, NULL, 'Now'),
(40, 41, 1, 2, '2026-09-29', '10:17:00', 'Pending', NULL, NULL, 'Now');

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
  `Registration_Date` date DEFAULT curdate(),
  `Status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`Customer_ID`, `Name`, `Phone`, `Email`, `Password`, `Address`, `Registration_Date`, `Status`) VALUES
(1, 'Masuma Akther', '01822-222222', 'masuma@gmail.com', 'masuma123', 'Tilagor,Sylhet', '2026-07-10', 'Active'),
(2, 'Ziyoda Pathan', '01933-333333', 'ziyoda@gmail.com', 'ziyoda123', 'Rikabibazar,Sylhet', '2026-07-10', 'Active'),
(3, 'Khadiza Islam Maliha', '01712882766', 'khadijamaliha10@gmail.com', 'maliha1@', 'Mejortila,Sylhet', '2026-07-17', 'Active'),
(4, 'Farzana Chowdhury', '01819847666', 'farihaislammim2@gmail.com', 'farihamim@21', 'Bonani,Dhaka', '2026-07-18', 'Active'),
(5, 'Madeha Tasnim', '01712345678', 'madeha22@gmail.com', 'madeha1@', 'Tajpur', '2026-07-20', 'Active'),
(8, 'Sayma Jahan', '01298398493', 'sayma@20.gmail.com', '', 'Tilagor', '2026-08-01', 'Active'),
(9, 'Ziyoda Pathan', '01819847222', 'ziyoda@gmail.com', '', 'Housing state', '2026-08-01', 'Active'),
(10, 'Zara Islam', '123456778899003', 'zara12@gmail.com', '', 'Purobi', '2026-08-01', 'Active'),
(11, 'Nazha Binte', '+8801712882766', 'nazha@gmail.com', '', 'Zindabazar', '2026-08-01', 'Active'),
(12, 'Nazha Binte', '+8801712882734', 'nazha@gmail.com', '', 'Zindabazar', '2026-08-01', 'Active'),
(14, 'Sayma Jahan', '+8801712882761', 'sayma@20.gmail.com', '', 'Tilagor', '2026-08-01', 'Active'),
(15, 'Angel Sadia', '+8801319488758', 'angel@gmail.com', '', 'Delulu', '2026-08-01', 'Active'),
(16, 'Nafaisha Sara', '+8801312345678', 'sara@gmail.com', '', 'Subidbazar', '2026-08-01', 'Active'),
(17, 'Amayra Islam', '+8801913987487', 'amayra12@gmail.com', '', 'Marget', '2026-08-05', 'Active'),
(18, 'Eti Jahan', '+8801703387016', 'eti23@gmail.com', '', 'Maymansing', '2026-08-05', 'Active'),
(19, 'Saida Imam', '+8801703387015', 'saida3@gmail.com', '', 'Italy', '2026-08-05', 'Active'),
(20, 'Nowrin Jahan', '+8801712345555', 'nowrin22@gmail.com', '', 'Uposohor', '2026-08-05', 'Active'),
(21, 'Nowrin Jahsan', '+8801712222222', 'nowrin2@gmail.com', '', 'Uposohor', '2026-08-05', 'Active'),
(22, 'Mahdia Islam', '+8801794929424', 'mahdia20@gmail.com', '', 'Mohammodpur', '2026-08-06', 'Inactive'),
(23, 'Lamia Tahsin', '+8801812345678', 'lamia123@gmail.com', '', 'Sylhet', '2026-08-06', 'Inactive'),
(24, 'Simi Islam', '+8801912345678', 'simi123@gmail.com', '', 'Syadpur', '2026-08-06', 'Active'),
(25, 'Sadie Sink', '+8801817777777', 'sadiasink@gmail.com', '', 'Washington', '2026-08-06', 'Active'),
(26, 'Muntaha Begom', '+8801777777777', 'muntaha12@gmail.com', '', 'Shahporan', '2026-08-06', 'Active'),
(27, 'Nabha Khatun', '+8801333333333', 'nabha@gmail.com', '', 'Shymoli', '2026-08-06', 'Active'),
(28, 'Esha Rashid', '+8801366666666', 'esha12@gmail.com', '', 'Shibganj', '2026-08-11', 'Active'),
(29, 'Ishrat chowdhury', '+8801999999999', 'ishrat21@gmail.com', '', 'UK', '2026-08-15', 'Active'),
(30, 'Eshita Jahan', '+8801344444444', 'eshita21@gmail.com', '', 'Jahanganj', '2026-08-15', 'Active'),
(31, 'Diya', '+8801899999999', 'diya@gmail.com', '', 'Sylhet', '2026-08-15', 'Active'),
(32, 'Gorgia', '+8801311111111', 'gorgia@gmail.com', '', 'USA', '2026-08-15', 'Active'),
(33, 'Kaniz', '+8801912222228', 'kaniz@gmail.com', '', 'Dhaka', '2026-08-15', 'Active'),
(34, 'Simran', '+8801866666667', 'simran@gmail.com', '', 'Sylhet', '2026-08-15', 'Active'),
(35, 'Lima', '+8801677777777', 'lima@gmail.com', '', 'Sylhet', '2026-08-15', 'Active'),
(36, 'Lithi Islam', '+8801988888888', 'lithi@gmail.com', '', 'Dhaka', '2026-08-16', 'Active'),
(37, 'Anisa', '+8801911111111', 'anisa@gmail.com', '', 'Sylhet', '2026-08-16', 'Active'),
(38, 'Daniya', '+8801866666666', 'daniya@gmail.com', '', 'Tilagor', '2026-08-16', 'Active'),
(39, 'Lamha', '+8801719999999', 'lamha@gmail.com', '', 'Dhaka', '2026-08-16', 'Active'),
(40, 'Olivia', '+8801712882744', 'olivia@gmail.com', '', 'UK', '2026-08-16', 'Active'),
(41, 'Maha', '+8801755555555', 'maha@gmail.com', '', 'Sylhet', '2026-08-20', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `Design_ID` int(11) NOT NULL,
  `Design_Code` varchar(20) NOT NULL,
  `Category` varchar(50) DEFAULT NULL CHECK (`Category` in ('Bridal','Semi Bridal','Arabic','Front Hand','Back Hand','Simple','Floral','Royal','Gorgeous','Modern','Stylish','Custom Design')),
  `Price` decimal(10,2) DEFAULT NULL CHECK (`Price` >= 0),
  `Availability` enum('Available','Unavailable') DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`Design_ID`, `Design_Code`, `Category`, `Price`, `Availability`, `Image`) VALUES
(1, 'BR001', 'Bridal', 4000.00, 'Available', 'BR001.jpeg'),
(2, 'AR001', 'Arabic', 2000.00, 'Available', 'AR001.jpeg'),
(3, 'FL001', 'Floral', 1500.00, 'Available', 'FL001.jpeg'),
(4, 'FH001', 'Front Hand', 1000.00, 'Available', 'FH001.jpeg'),
(5, 'MD001', 'Modern', 750.00, 'Available', 'MD001.jpeg'),
(6, 'MD002', 'Modern', 850.00, 'Available', 'MO001.jpeg'),
(7, 'FL002', 'Floral', 900.00, 'Available', 'FL002.jpeg'),
(8, 'SP001', 'Simple', 200.00, 'Available', 'SP001.jpeg'),
(9, 'SB001', 'Semi Bridal', 2500.00, 'Available', 'SB001.jpg'),
(10, 'GO001', 'Gorgeous', 1500.00, 'Available', 'GO001.jpeg'),
(11, 'CUSTOM', 'Custom Design', 0.00, 'Available', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `Payment_ID` int(11) NOT NULL,
  `Booking_ID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL CHECK (`Amount` >= 0),
  `Payment_Method` enum('Bkash','Nagad') DEFAULT NULL,
  `Payment_Date` date DEFAULT curdate(),
  `Payment_Status` enum('Paid','Unpaid','Refunded') DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`Payment_ID`, `Booking_ID`, `Amount`, `Payment_Method`, `Payment_Date`, `Payment_Status`) VALUES
(1, 1, 1000.00, '', '2026-07-10', 'Paid'),
(4, 23, 1500.00, 'Bkash', '2026-08-06', 'Paid'),
(5, 25, 1500.00, 'Bkash', '2026-08-11', 'Paid'),
(6, 27, 200.00, 'Bkash', '2026-08-15', 'Paid'),
(7, 28, 4000.00, 'Bkash', '2026-08-15', 'Paid'),
(8, 29, 1500.00, 'Bkash', '2026-08-15', 'Paid'),
(9, 30, 2500.00, 'Bkash', '2026-08-15', 'Paid'),
(10, 31, 200.00, 'Bkash', '2026-08-15', 'Paid'),
(11, 32, 2500.00, 'Bkash', '2026-08-15', 'Paid'),
(12, 33, 200.00, 'Bkash', '2026-08-15', 'Paid'),
(13, 34, 2500.00, 'Bkash', '2026-08-15', 'Paid'),
(14, 36, 4000.00, 'Nagad', '2026-08-15', 'Paid'),
(15, 37, 2000.00, 'Nagad', '2026-08-15', 'Paid'),
(16, 38, 2500.00, 'Nagad', '2026-08-15', 'Paid'),
(17, 39, 2000.00, 'Bkash', '2026-08-15', 'Paid'),
(18, 40, 2000.00, 'Bkash', '2026-08-20', 'Paid');

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
(1, 2, 2, 5, 'Very satisfied ', '2026-07-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `Artist_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `Design_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `Review_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
