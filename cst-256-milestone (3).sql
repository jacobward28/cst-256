-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:54734
-- Generation Time: Apr 25, 2020 at 01:01 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cst-256-milestone`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `IDADDRESS` int(11) NOT NULL,
  `STREET` varchar(45) DEFAULT NULL,
  `CITY` varchar(45) DEFAULT NULL,
  `STATE` varchar(45) DEFAULT NULL,
  `ZIP` int(5) DEFAULT NULL,
  `USERS_IDUSERS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`IDADDRESS`, `STREET`, `CITY`, `STATE`, `ZIP`, `USERS_IDUSERS`) VALUES
(1, 'somewhere', 'Glendale', 'Arizona', 85301, 1),
(9, NULL, NULL, NULL, NULL, 18),
(11, NULL, NULL, NULL, NULL, 20),
(13, NULL, NULL, NULL, NULL, 22),
(14, NULL, NULL, NULL, NULL, 23),
(15, NULL, NULL, NULL, NULL, 24),
(16, NULL, NULL, NULL, NULL, 25),
(17, NULL, NULL, NULL, NULL, 26),
(18, NULL, NULL, NULL, NULL, 27);

-- --------------------------------------------------------

--
-- Table structure for table `affinitygroupmember`
--

CREATE TABLE `affinitygroupmember` (
  `AFFINITYGROUPS_IDAFFINITYGROUPS` int(11) NOT NULL,
  `USERS_IDUSERS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affinitygroupmember`
--

INSERT INTO `affinitygroupmember` (`AFFINITYGROUPS_IDAFFINITYGROUPS`, `USERS_IDUSERS`) VALUES
(21, 1),
(21, 20),
(25, 20),
(27, 22);

-- --------------------------------------------------------

--
-- Table structure for table `affinitygroups`
--

CREATE TABLE `affinitygroups` (
  `IDAFFINITYGROUPS` int(11) NOT NULL,
  `NAME` varchar(45) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `FOCUS` varchar(45) NOT NULL,
  `USERS_IDUSERS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affinitygroups`
--

INSERT INTO `affinitygroups` (`IDAFFINITYGROUPS`, `NAME`, `DESCRIPTION`, `FOCUS`, `USERS_IDUSERS`) VALUES
(21, 'abcde', 'jacob', 'Java', 1),
(23, 'PHP level 1', 'This group is level one of PHP leaners.', 'PHP', 1),
(24, 'Learn more', 'This group is Java learners.', 'Java', 20),
(25, 'Explorer', 'Learn more about C#.', 'C#', 20),
(27, 'UI concepts', 'This group focus on HTML.', 'HTML', 20);

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `IDEDUCATION` int(11) NOT NULL,
  `SCHOOL` varchar(50) NOT NULL,
  `DEGREE` varchar(45) NOT NULL,
  `FIELD` varchar(45) NOT NULL,
  `GPA` float NOT NULL,
  `STARTYEAR` int(11) NOT NULL,
  `ENDYEAR` int(11) NOT NULL,
  `USERS_IDUSERS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`IDEDUCATION`, `SCHOOL`, `DEGREE`, `FIELD`, `GPA`, `STARTYEAR`, `ENDYEAR`, `USERS_IDUSERS`) VALUES
(1, 'Grand Canyon University', 'Computer Programming', 'Computer Science', 3.8, 2017, 2021, 1),
(7, 'test', 'test', 'test', 3.9, 2018, 2019, 1),
(11, 'Grand canyon', 'Masters', 'Programming', 3.5, 2017, 2020, 20),
(12, 'Grand school', 'Masters 2', 'Programming', 4, 2017, 2020, 22);

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `IDEXPERIENCE` int(11) NOT NULL,
  `TITLE` varchar(45) NOT NULL,
  `COMPANY` varchar(45) NOT NULL,
  `CURRENT` int(11) NOT NULL,
  `STARTYEAR` varchar(45) NOT NULL,
  `ENDYEAR` varchar(45) DEFAULT NULL,
  `DESCRIPTION` text,
  `USERS_IDUSERS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`IDEXPERIENCE`, `TITLE`, `COMPANY`, `CURRENT`, `STARTYEAR`, `ENDYEAR`, `DESCRIPTION`, `USERS_IDUSERS`) VALUES
(1, 'testing', 'testing', 0, '2018', '2019', 'this is a test job', 1),
(13, 'Test job', 'Student', 1, '2017', '2020', 'I am student at GCU.', 20),
(14, 'Testing', 'ABC logical back', 0, '2017', '2019', 'I am a programmer', 22);

-- --------------------------------------------------------

--
-- Table structure for table `jobapplicants`
--

CREATE TABLE `jobapplicants` (
  `JOBS_IDJOBS` int(11) NOT NULL,
  `USERS_IDUSERS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `IDJOBS` int(11) NOT NULL,
  `TITLE` varchar(45) NOT NULL,
  `COMPANY` varchar(45) NOT NULL,
  `STATE` varchar(45) NOT NULL,
  `CITY` varchar(45) NOT NULL,
  `DESCRIPTION` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`IDJOBS`, `TITLE`, `COMPANY`, `STATE`, `CITY`, `DESCRIPTION`) VALUES
(14, 'Tester2', 'GCU', 'AZ', 'GLENDALE', 'This job is for testing applications.'),
(15, 'BackEnd', 'Messa LLC', 'AZ', 'Glendale', 'This job is for PHP backend.');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `IDSKILLS` int(11) NOT NULL,
  `SKILL` varchar(45) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `USERS_IDUSERS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`IDSKILLS`, `SKILL`, `DESCRIPTION`, `USERS_IDUSERS`) VALUES
(10, 'PHP', 'I have a good deal of experience with creating php applications', 1),
(15, 'HTML', 'experience with HTML', 1),
(19, 'PHP', 'coding', 18),
(29, 'Java', 'I know Java', 20),
(30, 'HTML', 'I know HTML', 20),
(33, 'HTML', 'I know HTML', 22),
(34, 'PHP', 'I know PHP', 22),
(35, 'C#', 'I know C#', 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `IDUSERS` int(11) NOT NULL,
  `USERNAME` varchar(100) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `FIRSTNAME` varchar(100) NOT NULL,
  `LASTNAME` varchar(100) NOT NULL,
  `STATUS` int(11) NOT NULL DEFAULT '1',
  `ROLE` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`IDUSERS`, `USERNAME`, `PASSWORD`, `EMAIL`, `FIRSTNAME`, `LASTNAME`, `STATUS`, `ROLE`) VALUES
(1, 'tester', 'testing', 'tester@testing.test', 'tester', 'tester', 1, 1),
(18, 'jacobward', 'password', 'jacobward282@gmail.com', 'Jacob', 'Ward', 1, 1),
(20, 'sidharpr', '12345', 'hsihdu10@outlook.com', 'Harpreet', 'Sidhu', 1, 1),
(22, 'pritam', '12345', 'pritamsidhu@gmail.com', 'Pritam', 'singh', 1, 0),
(23, 'hsidhu', '12345', 'hsihdu10@outlook.com', 'Harpreet', 'Sidhu', 1, 1),
(24, 'arsh', '12345', '7763392@gmail.com', 'Arshdeep', 'Sidhu', 1, 1),
(25, 'sinharpr', '12345', 'hsidhu@my.gcu.edu', 'Harpreet', 'sidhu', 1, 1),
(26, 'jacob', '12345', 'jacobward@gmail.com', 'jacob', 'Ward', 1, 0),
(27, 'abcde', '12345', 'ABCD@gmail.com', 'AbcdE', 'XZY', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `IDUSER_INFO` int(11) NOT NULL,
  `DESCRIPTION` mediumtext,
  `PHONE` varchar(45) DEFAULT NULL,
  `AGE` int(11) DEFAULT NULL,
  `GENDER` varchar(45) DEFAULT NULL,
  `USERS_IDUSERS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`IDUSER_INFO`, `DESCRIPTION`, `PHONE`, `AGE`, `GENDER`, `USERS_IDUSERS`) VALUES
(3, 'this is an admin account for testing', '4441115555', 18, 'Male', 1),
(11, NULL, NULL, NULL, NULL, 18),
(13, 'I am passionate programmer.', '5597763392', 25, 'Male', 20),
(15, 'I am a good boy.', '5597763392', 30, 'Male', 22),
(16, NULL, NULL, NULL, NULL, 23),
(17, NULL, NULL, NULL, NULL, 24),
(18, NULL, NULL, NULL, NULL, 25),
(19, NULL, NULL, NULL, NULL, 26),
(20, NULL, NULL, NULL, NULL, 27);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`IDADDRESS`),
  ADD KEY `fk_ADDRESS_USERS_idx` (`USERS_IDUSERS`);

--
-- Indexes for table `affinitygroupmember`
--
ALTER TABLE `affinitygroupmember`
  ADD PRIMARY KEY (`AFFINITYGROUPS_IDAFFINITYGROUPS`,`USERS_IDUSERS`),
  ADD KEY `fk_AFFINITYGROUPS_has_USERS_USERS1_idx` (`USERS_IDUSERS`),
  ADD KEY `fk_AFFINITYGROUPS_has_USERS_AFFINITYGROUPS1_idx` (`AFFINITYGROUPS_IDAFFINITYGROUPS`);

--
-- Indexes for table `affinitygroups`
--
ALTER TABLE `affinitygroups`
  ADD PRIMARY KEY (`IDAFFINITYGROUPS`),
  ADD KEY `fk_AFFINITYGROUPS_USERS1_idx` (`USERS_IDUSERS`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`IDEDUCATION`),
  ADD KEY `fk_EDUCATION_USERS1_idx` (`USERS_IDUSERS`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`IDEXPERIENCE`),
  ADD KEY `fk_EXPERIENCE_USERS1_idx` (`USERS_IDUSERS`);

--
-- Indexes for table `jobapplicants`
--
ALTER TABLE `jobapplicants`
  ADD PRIMARY KEY (`JOBS_IDJOBS`,`USERS_IDUSERS`),
  ADD KEY `fk_JOBS_has_USERS_USERS1_idx` (`USERS_IDUSERS`),
  ADD KEY `fk_JOBS_has_USERS_JOBS1_idx` (`JOBS_IDJOBS`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`IDJOBS`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`IDSKILLS`),
  ADD KEY `fk_SKILLS_USERS1_idx` (`USERS_IDUSERS`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`IDUSERS`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`IDUSER_INFO`),
  ADD KEY `fk_USER_INFO_USERS1_idx` (`USERS_IDUSERS`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `IDADDRESS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `affinitygroups`
--
ALTER TABLE `affinitygroups`
  MODIFY `IDAFFINITYGROUPS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `IDEDUCATION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `IDEXPERIENCE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `IDJOBS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `IDSKILLS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `IDUSERS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `IDUSER_INFO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_ADDRESS_USERS` FOREIGN KEY (`USERS_IDUSERS`) REFERENCES `users` (`IDUSERS`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `affinitygroupmember`
--
ALTER TABLE `affinitygroupmember`
  ADD CONSTRAINT `fk_AFFINITYGROUPS_has_USERS_AFFINITYGROUPS1` FOREIGN KEY (`AFFINITYGROUPS_IDAFFINITYGROUPS`) REFERENCES `affinitygroups` (`IDAFFINITYGROUPS`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_AFFINITYGROUPS_has_USERS_USERS1` FOREIGN KEY (`USERS_IDUSERS`) REFERENCES `users` (`IDUSERS`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `affinitygroups`
--
ALTER TABLE `affinitygroups`
  ADD CONSTRAINT `fk_AFFINITYGROUPS_USERS1` FOREIGN KEY (`USERS_IDUSERS`) REFERENCES `users` (`IDUSERS`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `fk_EDUCATION_USERS1` FOREIGN KEY (`USERS_IDUSERS`) REFERENCES `users` (`IDUSERS`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `fk_EXPERIENCE_USERS1` FOREIGN KEY (`USERS_IDUSERS`) REFERENCES `users` (`IDUSERS`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `jobapplicants`
--
ALTER TABLE `jobapplicants`
  ADD CONSTRAINT `fk_JOBS_has_USERS_JOBS1` FOREIGN KEY (`JOBS_IDJOBS`) REFERENCES `jobs` (`IDJOBS`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_JOBS_has_USERS_USERS1` FOREIGN KEY (`USERS_IDUSERS`) REFERENCES `users` (`IDUSERS`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `fk_SKILLS_USERS1` FOREIGN KEY (`USERS_IDUSERS`) REFERENCES `users` (`IDUSERS`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `fk_USER_INFO_USERS1` FOREIGN KEY (`USERS_IDUSERS`) REFERENCES `users` (`IDUSERS`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
