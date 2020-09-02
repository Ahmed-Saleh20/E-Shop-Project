-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2020 at 12:30 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(8, 'Hand Made', 'Hand Made Items', 0, 1, 1, 1, 1),
(10, 'Cell Phones', 'Cell Phones', 0, 3, 0, 0, 0),
(11, 'Clothing', 'Clothing And Fashion', 8, 4, 0, 0, 0),
(17, 'Games', 'Hand Made Games ', 12, 3, 0, 0, 0),
(18, 'Electronics', 'Electronics Tools', 0, 10, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `tags`) VALUES
(35, 'Screen', 'Samsung Tv Screen', '500', '2020-03-23', 'Cairo', '', '1', 0, 0, 18, 1, NULL),
(36, 'Smart Watch', 'Apple Smart Watch', '100', '2020-09-02', 'USA', '', '0', 0, 0, 18, 1, 'Electronics'),
(37, 'T-shirt', 'Zara T-shirt Colection 2019', '100', '2020-09-02', 'Egypt', '', '0', 0, 1, 11, 2, 'Clothing'),
(38, 'Samsung J7 Pro', 'Smart Cell Phone ', '200', '2020-09-02', 'Calafornia', '', '0', 0, 1, 10, 37, 'phone'),
(39, 'Pes20', 'Plantation Games 2020 ', '300', '2020-09-02', 'USA', '', '0', 0, 1, 17, 38, 'Games'),
(40, 'Fifa16', 'Plantation Games 2016', '200', '2020-09-02', 'USA', '', '0', 0, 0, 17, 2, 'Games'),
(41, 'Booket', 'Booket Bag', '50', '2020-09-02', 'China', '', '0', 0, 1, 8, 2, NULL),
(42, 'Computer', 'New Computer Gaming ', '1000', '2020-09-02', 'Egypt', '', '0', 0, 0, 18, 37, 'Electronics'),
(43, 'iPhone X Max', 'Apple Smart Phone', '800', '2020-09-02', 'Japan', '', '0', 0, 1, 10, 38, 'phone'),
(44, 'LG TV', 'LG Smart TV 2002', '500', '2020-09-02', 'USA', '', '0', 0, 0, 18, 38, 'Electronics'),
(45, 'Book Gift', 'Book hand gift', '20', '2020-09-02', 'Egypt', '', '0', 0, 1, 8, 37, 'handmade'),
(46, 'Crash', 'Plantation Game ', '100', '2020-09-02', 'Caina', '', '0', 0, 0, 17, 2, 'Games'),
(47, 'Red Dress', 'Red Dress From H&M', '100', '2020-09-02', 'Egypt', '', '0', 0, 1, 11, 37, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To Identify User',
  `Username` varchar(255) NOT NULL COMMENT 'Username To Login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'Identify User Group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'User Approval',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'Admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin@gmail.com', 'Administrator', 1, 1, 1, '2020-02-18', ''),
(2, 'Ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ahmed@gmail.com', 'Ahmed Saleh Khalil', 0, 0, 1, '2020-03-23', ''),
(35, 'Mohmaed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohamed@gmail.com', 'Mohamed Ahmed', 0, 0, 1, '2020-09-02', ''),
(37, 'Mostafa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mostafa@gmail.com', 'Mostafa Karim', 0, 0, 0, '2020-09-02', ''),
(38, 'Karim', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'karim@gmail.com', 'karim Saleh', 0, 0, 0, '2020-09-02', ''),
(39, 'Islam', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'islam@gmail.com', 'Islam Hessin', 0, 0, 0, '2020-09-02', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify User', AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
