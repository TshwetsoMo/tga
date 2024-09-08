-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2024 at 09:51 AM
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
-- Database: `tga`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(25) NOT NULL,
  `adminName` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminName`, `email`, `password`, `role`) VALUES
(111, 'Admin', 'admin@tga.com', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcementID` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `postedDate` date NOT NULL,
  `postedBy` int(10) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcementID`, `title`, `description`, `postedDate`, `postedBy`, `role`) VALUES
(2, 'Innovation Sprint: Speed Networking & Brainstorm S', 'Date: April 2, 2024\r\nTime: 5:30 PM - 7:30 PM\r\nLocation: TechSpace Lab, Sandton, Johannesburg\r\n\r\nJoin us for an exciting Innovation Sprint event! This is your chance to connect with creative minds from diverse backgrounds and spark new ideas for future projects.\r\n\r\nSpeed Networking: Meet professionals and innovators in your field.\r\nLightning Brainstorming: Share ideas, gain fresh insights, and receive rapid feedback.\r\nInspiration Panel: Listen to industry leaders share stories of creativity and growth.\r\nSpaces are limited! Register by March 30, 2024, to secure your spot.\r\n\r\nRefreshments and snacks will be served.', '2024-09-05', 0, ''),
(3, 'Hack the Future: 2024 Innovation Hackathon', 'Hackathon Schedule\r\nDay 1: (April 5)\r\n\r\n9:00 AM: Check-in & Networking Breakfast\r\n10:00 AM: Opening Ceremony & Keynote Speaker: Elise Motaung, CEO of SmartTech Solutions\r\n12:00 PM: Hacking Begins\r\n6:00 PM: Team Check-ins & Mentorship Sessions\r\nDay 2: (April 6)\r\n\r\n8:00 AM: Breakfast & Progress Reviews\r\n10:00 AM: Workshop: “The Future of IoT in Smart Cities” by John Nkosi\r\n3:00 PM: Final Code Review with Mentors\r\nDay 3: (April 7)\r\n\r\n8:00 AM: Final Day of Hacking\r\n12:00 PM: Hacking Ends & Project Submission Deadline\r\n2:00 PM: Team Presentations & Demo Day\r\n5:00 PM: Judging & Award Ceremony\r\n7:00 PM: Closing Ceremony', '2024-09-05', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignmentID` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `dueDate` date NOT NULL,
  `postedDate` date NOT NULL,
  `totalMarks` int(100) NOT NULL,
  `teacherID` int(10) NOT NULL,
  `courseID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignmentID`, `title`, `description`, `dueDate`, `postedDate`, `totalMarks`, `teacherID`, `courseID`) VALUES
(2, 'Test', 'this is a test!', '2024-09-13', '0000-00-00', 100, 1, 101),
(4, 'Test 2', 'this is also a test!', '2024-09-12', '0000-00-00', 100, 1, 102),
(5, 'Marketing Assignment', 'This is an assignmnet', '2024-09-06', '0000-00-00', 100, 1, 103),
(6, 'Software Development Assignmemt', 'This is an assignment', '2024-09-06', '0000-00-00', 80, 1, 101);

-- --------------------------------------------------------

--
-- Table structure for table `courseenrollment`
--

CREATE TABLE `courseenrollment` (
  `enrollmentID` int(10) NOT NULL,
  `studentID` int(10) NOT NULL,
  `courseID` int(10) NOT NULL,
  `enrollmentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courseenrollment`
--

INSERT INTO `courseenrollment` (`enrollmentID`, `studentID`, `courseID`, `enrollmentDate`) VALUES
(1001, 2402, 101, '2024-08-01'),
(1002, 2402, 103, '2024-09-01'),
(1003, 2402, 103, '2024-09-01'),
(2001, 2402, 102, '2024-08-01'),
(2002, 1, 101, '2024-09-01'),
(2003, 1, 102, '2024-09-01'),
(2004, 1, 103, '2024-09-01'),
(2005, 1, 104, '2024-09-01'),
(3001, 2, 101, '2024-09-01'),
(3002, 2, 102, '2024-09-01'),
(3003, 2, 103, '2024-09-01'),
(3004, 2, 104, '2024-09-01'),
(4001, 3, 101, '2024-09-01'),
(4002, 3, 102, '2024-09-01'),
(4003, 3, 103, '2024-09-01'),
(4004, 3, 104, '2024-09-01');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseID` int(10) NOT NULL,
  `courseName` varchar(20) NOT NULL,
  `courseCode` int(10) NOT NULL,
  `credits` int(40) NOT NULL,
  `department` varchar(30) NOT NULL,
  `teacherID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseID`, `courseName`, `courseCode`, `credits`, `department`, `teacherID`) VALUES
(101, 'Software Development', 101, 40, 'Academics', 1),
(102, 'Software Design', 102, 40, 'Admissions', 5),
(103, 'Marketing', 103, 40, 'Academics', 1),
(104, 'Product Design', 104, 40, 'Academics', 5);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentID` int(10) NOT NULL,
  `studentName` varchar(20) NOT NULL,
  `studentSurname` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `enrollmentDate` date NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentID`, `studentName`, `studentSurname`, `email`, `password`, `enrollmentDate`, `role`) VALUES
(1, 'Tshepi', 'Goat', 'tg@tga.com', 'Tshepi', '2024-09-05', 'Student'),
(2, 'Kate', 'More', 'km@tga.com', 'Kate', '0000-00-00', 'Student'),
(3, 'Tharo', 'Zoochi', 'tz@tga.com', 'Tharo', '0000-00-00', 'Student'),
(4, 'Luna', 'Sanchez', 'ls@tga.com', 'Luna', '0000-00-00', 'Student'),
(2402, 'Palesa', 'Bulldozer', 'pb@tga.com', 'Palesa', '2024-09-01', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `submissionID` int(10) NOT NULL,
  `submissionDate` date NOT NULL,
  `filePath` varchar(20) NOT NULL,
  `marksObtained` int(100) NOT NULL,
  `feedback` varchar(2000) NOT NULL,
  `assignmentID` int(10) NOT NULL,
  `studentID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`submissionID`, `submissionDate`, `filePath`, `marksObtained`, `feedback`, `assignmentID`, `studentID`) VALUES
(2, '2024-09-05', 'TshwetsoMokgatlhe_UX', 90, 'Well done!\r\nYou need to go over your theory some more', 2, 2402),
(6, '2024-09-08', 'Slide 16_9 - 1.pdf', 60, 'You can do better than that!', 4, 2402),
(7, '2024-09-08', 'UXT 200 Term 2 Brief', 0, '', 5, 2402),
(10, '2024-09-08', 'Tshwetso Mokgatlhe X', 0, '', 6, 2402);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacherID` int(10) NOT NULL,
  `teacherName` varchar(20) NOT NULL,
  `teacherSurname` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `hireDate` date NOT NULL,
  `department` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'teacher'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacherID`, `teacherName`, `teacherSurname`, `email`, `password`, `hireDate`, `department`, `role`) VALUES
(1, 'Tshwetso', 'Mokgatlhe', 'tm@tga.com', 'teacher1', '2024-08-04', 'Academics', 'teacher'),
(2, 'Bob', 'Builder', 'bb@tga.com', 'teacher2', '2024-08-01', 'Admissions', 'teacher'),
(4, 'Jean', 'Storm', 'js@tga.com', 'teacher3', '2024-09-06', 'Academics', 'Teacher'),
(5, 'Aditche', 'Ngozi', 'an@tga.com', 'Aditche', '2024-08-09', 'Academics', 'Teacher'),
(6, 'Naledi', 'Ngwenda', 'nn@tga.com', 'Naledi', '2024-08-01', 'Academics', 'Teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcementID`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignmentID`),
  ADD KEY `teacherID` (`teacherID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `courseenrollment`
--
ALTER TABLE `courseenrollment`
  ADD PRIMARY KEY (`enrollmentID`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseID`),
  ADD KEY `teacherID` (`teacherID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentID`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`submissionID`),
  ADD KEY `assignmentID` (`assignmentID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacherID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcementID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignmentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `courseenrollment`
--
ALTER TABLE `courseenrollment`
  MODIFY `enrollmentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4005;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `studentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2403;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `submissionID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacherID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`),
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`);

--
-- Constraints for table `courseenrollment`
--
ALTER TABLE `courseenrollment`
  ADD CONSTRAINT `courseenrollment_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`),
  ADD CONSTRAINT `courseenrollment_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignmentID`) REFERENCES `assignments` (`assignmentID`),
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
