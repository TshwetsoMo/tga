--
-- Database: `techgeniusacademy`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(25) NOT NULL AUTO_INCREMENT,
  `adminName` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacherID` int(10) NOT NULL AUTO_INCREMENT,
  `teacherName` varchar(20) NOT NULL,
  `teacherSurname` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `hireDate` date NOT NULL,
  `department` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'teacher',
  PRIMARY KEY (`teacherID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentID` int(10) NOT NULL AUTO_INCREMENT,
  `studentName` varchar(20) NOT NULL,
  `studentSurname` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `enrollmentDate` date NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'student',
  PRIMARY KEY (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcementID` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `postedDate` date NOT NULL,
  `postedBy` int(10) NOT NULL,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`announcementID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courseEnrollment`
--

CREATE TABLE `courseEnrollment` (
  `enrollmentID` int(10) NOT NULL AUTO_INCREMENT,
  `studentID` int(10) NOT NULL,
  `courseID` int(10) NOT NULL,
  `enrollmentDate` date NOT NULL,
  PRIMARY KEY (`enrollmentID`),
  FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`),
  FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignmentID` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `dueDate` date NOT NULL,
  `postedDate` date NOT NULL,
  `totalMarks` int(100) NOT NULL,
  `teacherID` int(10) NOT NULL,
  `courseID` int(10) NOT NULL,
  PRIMARY KEY (`assignmentID`),
  FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`),
  FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseID` int(10) NOT NULL AUTO_INCREMENT,
  `courseName` varchar(20) NOT NULL,
  `courseCode` int(10) NOT NULL,
  `credits` int(40) NOT NULL,
  `department` varchar(30) NOT NULL,
  `teacherID` int(10) NOT NULL,
  PRIMARY KEY (`courseID`),
  FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `submissionID` int(10) NOT NULL AUTO_INCREMENT,
  `submissionDate` date NOT NULL,
  `filePath` varchar(20) NOT NULL,
  `marksObtained` int(100) NOT NULL,
  `feedback` varchar(2000) NOT NULL,
  `assignmentID` int(10) NOT NULL,
  `studentID` int(10) NOT NULL,
  PRIMARY KEY (`submissionID`),
  FOREIGN KEY (`assignmentID`) REFERENCES `assignments` (`assignmentID`),
  FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;