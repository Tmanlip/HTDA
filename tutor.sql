-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 04:35 PM
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
-- Database: `tutorxcells`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(0, 'admin_user', 'admin_password123', '2025-01-08 07:59:37'),
(0, 'persaka', 'ps12', '2025-01-08 07:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `summary` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `name`, `title`, `email`, `tags`, `content`, `image`, `status`, `summary`, `created_at`) VALUES
(1, 'f', 'gfg', 'taimanaliff@gmail.com', '[\"[{\\\"value\\\":\\\"Machine Languange\\\"}]\"]', '<p>fg</p>', NULL, 'approved', '<p>fgfg</p>', '2025-01-08 08:18:18'),
(2, 'Ahmad Hazim', 'dsfdsfds', 'taimanaliff@gmail.com', '[\"[{\\\"value\\\":\\\"Machine Languange\\\"}]\"]', '<p>sdfdsfdsf</p>', 'uploads/Screenshot 2024-11-07 220025.png', 'approved', '<p>sfsdfdsfd</p>', '2025-01-11 15:24:09'),
(3, 'Ahmad Hazim', 'dfsdfdfd', 'taimanaliff@gmail.com', '[\"[{\\\"value\\\":\\\"C++ Languange\\\"}]\"]', '<p>sdfdsfdsfd</p>', NULL, 'approved', '<p>dsfdsfsdfd</p>', '2025-01-11 15:24:32'),
(4, 'Ahmad Hazim', 'dsfdsf', 'taimanaliff@gmail.com', '[\"[{\\\"value\\\":\\\"Iris Scanning\\\"}]\"]', '<p>dsfdfsd</p>', NULL, 'rejected', '<p>sdfsfdsfs</p>', '2025-01-11 15:26:03'),
(5, 'ssss', 'ddddd', 'tngkuaimnaliff@gmail.com', '[\"[{\\\"value\\\":\\\"Cybersecurity\\\"}]\"]', '<p>dfdf</p>', NULL, 'approved', '<p>dfdf</p>', '2025-01-12 15:11:01'),
(6, 'Zulfiqar Ibrahim', 'Introduction to C++ Language', 'muhammaddenish@graduate.utm.my', '[\"[{\\\"value\\\":\\\"C++ Languange\\\"}]\"]', '<p>C++ is a general-purpose programming language created by Bjarne Stroustrup in 1983 as an extension of C. It introduces object-oriented programming concepts, making it suitable for complex systems and applications. C++ offers features like classes, inheritance, polymorphism, and templates, enabling developers to write reusable and maintainable code.</p>\r\n<p>The language\'s low-level memory manipulation capabilities make it ideal for system-level programming, such as developing operating systems, compilers, and embedded systems. Moreover, its high performance and control over resources make it a popular choice in game development and real-time simulations.</p>\r\n<p>Despite being over four decades old, C++ remains relevant due to its adaptability and widespread use in industries like finance, telecommunications, and robotics. Learning C++ is a valuable skill for programmers seeking to build a strong foundation in computer science.</p>', NULL, 'approved', '<p>C++ is a powerful, versatile programming language that supports procedural, object-oriented, and generic programming paradigms. It is widely used in system software, game development, and high-performance applications due to its efficiency and control over hardware. This article explores its features, applications, and importance in modern software development.</p>', '2025-01-13 05:55:30'),
(7, 'Zulfiqar Ibrahim', 'Understanding Machine Language', 'muhammaddenish@graduate.utm.my', '[\"[{\\\"value\\\":\\\"Machine Languange\\\"}]\"]', '<p>Machine language is the fundamental language of computers, composed of binary digits (0s and 1s). Each instruction in machine language corresponds to a specific operation the CPU can execute, such as arithmetic calculations or memory access.</p>\r\n<p>Unlike high-level languages, machine language is hardware-dependent, meaning instructions vary across different processor architectures. Writing in machine language is tedious and error-prone, as it requires programmers to manage memory addresses and data explicitly.</p>\r\n<p>Despite its complexity, machine language is crucial for computer operation. High-level programming languages are eventually translated into machine language through compilers or interpreters, ensuring compatibility with hardware. Understanding machine language offers insights into how computers process instructions, a fundamental concept for computer engineers and enthusiasts.</p>', 'uploads/hex2.jpg', 'pending', '<p>Machine language, the lowest level of programming language, consists of binary code that a computer\'s CPU directly understands. This article delves into its structure, role in computing, and challenges, highlighting its foundational importance in computer systems.</p>', '2025-01-13 05:57:15'),
(8, 'Zulfiqar Ibrahim', 'The Importance of Cybersecurity in the Digital Age', 'muhammaddenish@graduate.utm.my', '[\"[{\\\"value\\\":\\\"Cybersecurity\\\"}]\"]', '<p>In an era dominated by digital transformation, cybersecurity has become a critical aspect of technology. It involves safeguarding systems, networks, and sensitive data from unauthorized access, theft, and damage.</p>\r\n<p>Common cyber threats include malware, phishing, ransomware, and denial-of-service attacks. These threats can lead to financial losses, data breaches, and reputational damage for individuals and organizations.</p>\r\n<p>Effective cybersecurity strategies encompass firewalls, intrusion detection systems, encryption, and regular software updates. Additionally, fostering a culture of awareness through training and education is vital to counter human vulnerabilities.</p>\r\n<p>As cyber threats evolve, the demand for skilled cybersecurity professionals continues to grow. Investing in cybersecurity is not just a technical necessity but a strategic imperative for ensuring trust and resilience in the digital landscape.</p>', NULL, 'pending', '<p>Cybersecurity protects systems, networks, and data from cyber threats. This article discusses its significance, common threats, and strategies for defense, emphasizing the growing need for robust security measures in a connected world.</p>', '2025-01-13 05:57:41'),
(9, 'Zulfiqar Ibrahim', 'Exploring Adobe Illustrator for Creative Design', 'muhammaddenish@graduate.utm.my', '[\"[{\\\"value\\\":\\\"Adobe Illustrator\\\"}]\"]', '<p>Adobe Illustrator, part of Adobe\'s Creative Cloud suite, is a powerful tool for creating vector graphics. Unlike raster graphics, vector images are resolution-independent, making them ideal for scalable designs like logos and illustrations.</p>\r\n<p>Illustrator offers a range of features, including customizable brushes, advanced typography, and tools for creating complex shapes and patterns. Its compatibility with other Adobe tools enhances workflow efficiency for designers.</p>\r\n<p>The software is widely used in graphic design, branding, and digital marketing. Its precision and flexibility empower creatives to bring their visions to life, whether designing for print or digital media.</p>\r\n<p>For aspiring designers, mastering Adobe Illustrator is a valuable skill that opens doors to various career opportunities in the creative industry.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>dfsd</strong></p>\r\n<ul>\r\n<li>Me</li>\r\n<li>Want</li>\r\n<li>Yo</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<ol>\r\n<li>w</li>\r\n<li>o</li>\r\n<li>p</li>\r\n</ol>', 'uploads/catch_me_if_you_can.png', 'pending', '<p>Adobe Illustrator is a leading vector graphics software used for creating logos, illustrations, and digital art. This article highlights its features, applications, and benefits for designers and creatives.</p>', '2025-01-13 05:58:56'),
(10, 'Ming Wei Tan', 'Iris Scanning: A Revolutionary Biometric Technology', 'nuraimiafiqah@graduate.utm.my', '[\"[{\\\"value\\\":\\\"Iris Scanning\\\"}]\"]', '<p>Iris scanning is a cutting-edge biometric technology that identifies individuals based on the unique patterns in their irises. Each person\'s iris pattern is highly distinctive, making it an excellent identifier for security purposes.</p>\r\n<p>The process involves capturing an image of the eye using infrared light, which highlights the intricate details of the iris. These details are then converted into a digital template and matched against a database for authentication.</p>\r\n<p>Iris scanning is used in various applications, including border control, access management, and financial transactions. Its non-invasive nature and high accuracy make it a preferred choice for secure identification.</p>\r\n<p>As concerns about data privacy and security grow, iris scanning continues to gain traction as a reliable and efficient biometric solution. Its adoption across industries underscores its potential to revolutionize identity verification.</p>', 'uploads/cat.jpg', 'pending', '<p>Iris scanning is a biometric identification technology that uses unique patterns in the human iris for secure authentication. This article explores its working principles, applications, and advantages in enhancing security.</p>', '2025-01-13 06:01:59'),
(11, 'Ming Wei Tan', 'ffff', 'nuraimiafiqah@graduate.utm.my', '[\"[{\\\"value\\\":\\\"C++ Languange\\\"}]\"]', '<ol>\r\n<li>rere</li>\r\n</ol>\r\n<p>frggrg</p>\r\n<p>&nbsp;</p>\r\n<p><strong>sdfsdfsdfds</strong></p>', NULL, 'pending', '<p>sdfsdfdsfsdfdfsd</p>', '2025-01-13 14:43:09');

-- --------------------------------------------------------

--
-- Table structure for table `content_views`
--

CREATE TABLE `content_views` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `views` int(11) DEFAULT 0,
  `last_viewed` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_views`
--

INSERT INTO `content_views` (`id`, `article_id`, `views`, `last_viewed`) VALUES
(1, 1, 1, '2025-01-11 09:24:43'),
(2, 6, 1, '2025-01-13 22:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_resources`
--

CREATE TABLE `deleted_resources` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_resources`
--

INSERT INTO `deleted_resources` (`id`, `course_name`, `document_name`, `file_path`, `upload_date`) VALUES
(9, 'Computational Mathematics', 'Hands-On Project_Instructions 20242025 (1).docx', 'uploads/Hands-On Project_Instructions 20242025 (1).docx', '2025-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_sessions`
--

CREATE TABLE `deleted_sessions` (
  `id` int(11) NOT NULL,
  `session_name` varchar(255) NOT NULL,
  `experience_level` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `members` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_sessions`
--

INSERT INTO `deleted_sessions` (`id`, `session_name`, `experience_level`, `time`, `location`, `max_participants`, `members`) VALUES
(6, 'ML', 'Advanced', 'Weekends Evening', 'Room', 5, 1),
(10, 'd', 'Intermediate', 'Weekends Morning', 'd', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `feedback_text` text NOT NULL,
  `status` enum('Pending','In Progress','Resolved') DEFAULT 'Pending',
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `feedback_text`, `status`, `submission_date`) VALUES
(1, 'System errors during online tutoring sessions\r\n', 'Resolved', '2024-12-10 09:53:58'),
(2, 'Inconsistent tutor availability updates', 'Pending', '2024-12-10 10:23:52'),
(3, 'Discrepancy in payment processing for tutoring sessions', 'Resolved', '2024-12-10 10:23:55'),
(5, 'Delayed or missing notifications for upcoming tutoring sessions\r\n', 'In Progress', '2024-12-10 10:24:05'),
(4, 'Lack of support for specific programming or subject-related queries\r\n', 'Resolved', '2024-12-10 10:24:08'),
(6, 'Delay Payment', 'In Progress', '2024-12-11 05:49:46'),
(0, 'fgfgf', 'In Progress', '2025-01-11 01:32:38'),
(0, 'fgf', 'In Progress', '2025-01-12 15:09:11'),
(0, 'fgfgf', 'Pending', '2025-01-13 14:36:47');

-- --------------------------------------------------------

--
-- Table structure for table `forum_contributions`
--

CREATE TABLE `forum_contributions` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `reply_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_contributions`
--

INSERT INTO `forum_contributions` (`id`, `student_id`, `question_id`, `reply_id`) VALUES
(1, 'A21EC0011', 2, 1),
(3, 'A24EC0098', 4, NULL),
(4, 'A23EC0120', 13, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `employee_no` varchar(20) NOT NULL,
  `lect_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `subject_teached` varchar(100) NOT NULL,
  `image_data` blob DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`employee_no`, `lect_name`, `email`, `phone_number`, `subject_teached`, `image_data`, `last_login`, `username`, `password`) VALUES
('L001', 'Dr. Ahmad Zainal', 'ahmad.zainal@example.com', '1231231234', 'Data Structures', NULL, '2025-01-03 13:00:00', 'ahmad_zainal', 'lecturer123'),
('L002', 'Prof. Aida Roslan', 'aida.roslan@example.com', '2342342345', 'Algorithms', NULL, '2025-01-02 14:00:00', 'aida_roslan', 'lecturer456'),
('L003', 'Dr. Michael Lim', 'michael.lim@example.com', '3453453456', 'Database Management', NULL, '2025-01-01 15:00:00', 'michael_lim', 'lecturer789'),
('L005', 'Prof. David Chong', 'david.chong@example.com', '5675675678', 'Operating Systems', NULL, '2024-12-30 17:00:00', 'david_chong', 'lecturer654');

-- --------------------------------------------------------

--
-- Table structure for table `merit_scores`
--

CREATE TABLE `merit_scores` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `merit_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merit_scores`
--

INSERT INTO `merit_scores` (`id`, `student_id`, `merit_score`) VALUES
(1, 'A21EC0011', 85),
(2, 'A22EC0283', 90),
(3, 'A24EC0098', 75);

-- --------------------------------------------------------

--
-- Table structure for table `participation`
--

CREATE TABLE `participation` (
  `id` int(11) NOT NULL,
  `seminar_id` int(11) NOT NULL,
  `participant_id` varchar(20) NOT NULL,
  `lecturer_id` varchar(20) DEFAULT NULL,
  `role` enum('student','lecturer') NOT NULL,
  `status` enum('completed','oncoming') NOT NULL,
  `registration_date` datetime NOT NULL DEFAULT current_timestamp(),
  `attendance` enum('absent','present') DEFAULT 'absent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participation`
--

INSERT INTO `participation` (`id`, `seminar_id`, `participant_id`, `lecturer_id`, `role`, `status`, `registration_date`, `attendance`) VALUES
(51, 1, 'A22EC0283', NULL, 'student', 'oncoming', '2025-01-10 20:40:05', 'present'),
(52, 2, 'A24EC0098', NULL, 'student', 'oncoming', '2025-01-10 20:40:05', 'present'),
(53, 3, 'A24EC0098', NULL, 'student', 'completed', '2025-01-10 20:40:05', 'absent'),
(55, 5, 'A24EC0098', NULL, 'student', 'oncoming', '2025-01-10 20:40:05', 'absent'),
(56, 2, 'A21EC0011', NULL, 'lecturer', 'completed', '2025-01-10 20:40:05', 'present'),
(58, 3, 'A23EC0120', NULL, 'lecturer', 'completed', '2025-01-10 20:40:05', 'absent'),
(60, 5, 'A21EC0011', NULL, 'student', 'oncoming', '2025-01-10 20:40:05', 'absent'),
(62, 3, 'A23EC0120', NULL, 'student', 'completed', '2025-01-10 20:40:05', 'absent'),
(66, 7, 'A22EC0283', NULL, 'student', 'completed', '2025-01-12 09:58:36', 'present'),
(67, 7, 'A22EC0283', NULL, 'student', 'completed', '2025-01-12 23:13:22', 'absent'),
(68, 1, 'A22EC0283', NULL, 'student', 'completed', '2025-01-13 15:34:37', 'present'),
(69, 1, 'A22EC0283', NULL, 'student', 'completed', '2025-01-13 22:34:12', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `payment_proofs`
--

CREATE TABLE `payment_proofs` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(20) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Completed','Failed','') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_proofs`
--

INSERT INTO `payment_proofs` (`id`, `bill_number`, `file_name`, `file_path`, `upload_time`, `status`) VALUES
(1, 'BILL-103931', 'Article 4.pdf', 'uploads/proof_67807d9bc61556.47186938.pdf', '2025-01-10 01:53:31', 'Completed'),
(2, 'BILL-455620', 'Lab 1 (Encryption).pdf', 'uploads/proof_67827c9cb77931.57445070.pdf', '2025-01-11 14:13:48', 'Completed'),
(3, 'BILL-876041', 'Class Activities 4b2_q.pdf', 'uploads/proof_67831d0ec4cef0.81706610.pdf', '2025-01-12 01:38:22', 'Pending'),
(4, 'BILL-876041', 'Class Activities 4b2_q.pdf', 'uploads/proof_67831d575586a9.22715990.pdf', '2025-01-12 01:39:35', 'Pending'),
(5, 'BILL-876041', 'Class Activities 4b2_q.pdf', 'uploads/proof_67831d5ac15360.87149906.pdf', '2025-01-12 01:39:38', 'Pending'),
(6, 'BILL-486024', 'Class Activities 4b2_q.pdf', 'uploads/proof_678321cc872b60.74970400.pdf', '2025-01-12 01:58:36', 'Pending'),
(7, 'BILL-843816', 'UTM GAMES FINAL(TRACK AND FIELD) - Sheet1.pdf', 'uploads/proof_6783dc1260ae46.69460829.pdf', '2025-01-12 15:13:22', 'Pending'),
(8, 'BILL-889459', '2. PSC_SHO UTMSPACE_11.10.24 Student Tr. Module.pdf', 'uploads/proof_6784c20d8a7973.65760169.pdf', '2025-01-13 07:34:37', 'Pending'),
(9, 'BILL-697990', 'Session2_Tableau (part 1  2).pdf', 'uploads/proof_67852464af7234.61047370.pdf', '2025-01-13 14:34:12', 'Pending'),
(10, 'BILL-17349', 'CIMB OCTO MY-274784972.pdf', 'uploads/proof_6769848012b8f2.72188885.pdf', '2024-12-23 07:40:48', 'Failed'),
(11, 'BILL-169091', 'CIMB OCTO MY-274784972.pdf', 'uploads/proof_676986c8518402.25939192.pdf', '2024-12-23 07:50:32', 'Completed'),
(12, 'BILL-889386', 'CIMB OCTO MY-274784972.pdf', 'uploads/proof_67715a03b9efe5.50877866.pdf', '2024-12-29 06:17:39', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `peer_collaborations`
--

CREATE TABLE `peer_collaborations` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peer_collaborations`
--

INSERT INTO `peer_collaborations` (`id`, `student_id`, `session_id`) VALUES
(4, 'A24EC0098', 7),
(5, 'A21EC0011', 8),
(6, 'A21EC0011', 8),
(7, 'A21EC0011', 9),
(9, 'A23EC0120', 7);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `matric_no` varchar(20) DEFAULT NULL,
  `employee_no` varchar(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `matric_no`, `employee_no`, `title`, `description`, `tags`, `created_at`) VALUES
(1, 'A23EC0120', NULL, 'How to start learning Data Science?', 'I am interested in learning Data Science but not sure where to start.', 'Data Science, Learning', '2025-01-08 15:53:54'),
(2, 'A21EC0011', 'L001', 'Best practices for Data Structures', 'Can you suggest the best practices for learning Data Structures?', 'Data Structures, Best Practices', '2025-01-08 15:53:54'),
(3, 'S003', 'L002', 'Algorithms for Sorting', 'Can you explain the algorithms used for sorting data?', 'Algorithms, Sorting', '2025-01-08 15:53:54'),
(4, 'A24EC0098', NULL, 'How to secure my network?', 'What are the best practices to secure a home network?', 'Cybersecurity, Networking', '2025-01-08 15:53:54'),
(5, 'S005', 'L003', 'Database Management Systems', 'Can you explain the concepts of database normalization?', 'Database, Normalization', '2025-01-08 15:53:54'),
(13, 'A23EC0120', NULL, 'a', 'b', 'c', '2025-01-13 15:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `matric_no` varchar(20) DEFAULT NULL,
  `employee_no` varchar(20) DEFAULT NULL,
  `reply_text` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `question_id`, `matric_no`, `employee_no`, `reply_text`, `created_at`) VALUES
(1, 1, 'A21EC0011', NULL, 'You can start by learning the basics of Python and exploring libraries like Pandas and NumPy.', '2025-01-08 15:55:23'),
(2, 2, 'A23EC0120', NULL, 'You should focus on understanding the concepts first and practice with real-world examples.', '2025-01-08 15:55:23'),
(3, 3, NULL, 'L002', 'There are several sorting algorithms such as QuickSort, MergeSort, and BubbleSort.', '2025-01-08 15:55:23'),
(4, 4, 'A22EC0283', NULL, 'You can use strong passwords, enable two-factor authentication, and regularly update your router firmware.', '2025-01-08 15:55:23'),
(5, 5, NULL, 'L003', 'Database normalization involves organizing data to reduce redundancy and improve data integrity.', '2025-01-08 15:55:23'),
(20, 2, 'A22EC0283', NULL, 'qqq', '2025-01-12 22:15:11'),
(22, 5, 'A22EC0283', NULL, 'uhuks', '2025-01-12 23:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `course_name`, `document_name`, `file_path`, `upload_date`) VALUES
(5, 'Digital Logic', 'Panduan-Fullstack-Web-Developer-6-Bulan-1.pdf', 'uploads/Panduan-Fullstack-Web-Developer-6-Bulan-1.pdf', '2025-01-11 16:00:00'),
(7, 'Digital Logic', 'Figure 1.pdf', 'uploads/Figure 1.pdf', '2025-01-12 16:00:00'),
(8, 'Computational Mathematics', 'Design Thinking Pre Class.pdf', 'uploads/Design Thinking Pre Class.pdf', '2025-01-12 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `resource_sharing`
--

CREATE TABLE `resource_sharing` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `resource_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource_sharing`
--

INSERT INTO `resource_sharing` (`id`, `student_id`, `resource_id`) VALUES
(4, 'A24EC0098', 7),
(5, 'A21EC0011', 8);

-- --------------------------------------------------------

--
-- Table structure for table `seminar`
--

CREATE TABLE `seminar` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `seminar_date` date NOT NULL,
  `description` text NOT NULL,
  `place` varchar(255) NOT NULL,
  `speaker` varchar(255) NOT NULL,
  `time` time NOT NULL,
  `category` varchar(100) NOT NULL,
  `recurring` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seminar`
--

INSERT INTO `seminar` (`id`, `event_name`, `seminar_date`, `description`, `place`, `speaker`, `time`, `category`, `recurring`) VALUES
(1, 'Introduction to Data Science', '2025-01-15', 'A seminar on the basics of Data Science and its applications.', 'Dewan Kuliah 1, N24', '', '00:00:00', '', 0),
(2, 'Advanced Algorithms', '2024-12-20', 'A deep dive into advanced algorithms and their use cases.', 'Dewan Kejora, N28a', '', '00:00:00', '', 0),
(3, 'Database Management Systems', '2024-12-25', 'A seminar on the fundamentals of database management systems.', 'MPK 2, N28', '', '00:00:00', '', 0),
(4, 'Cybersecurity Essentials', '2024-11-10', 'Learn about the latest trends in cybersecurity and how to protect your systems.', 'CCNA, N28', '', '00:00:00', '', 0),
(5, 'Networking Basics', '2025-02-05', 'An introductory seminar on networking and network protocols.', 'Dewan Kuliah 2, L50', '', '00:00:00', '', 0),
(6, 'dfgfg', '2025-01-11', 'dfgdfgf', 'dfgfd', 'dfgfd', '10:47:00', 'Academic', 0),
(7, 'dsfs', '2025-01-12', 'dsfdf', 'dsdf', 'dsfd', '15:14:00', 'Academic', 0),
(8, 'dfgdgd', '2025-01-09', 'fgfdgfdgfd', 'fdgfdg', 'dfgfdg', '12:58:00', 'Academic', 0),
(9, 'fdgdgfdgfdgfgfg', '2025-01-24', 'fdgdfgdfgdf', 'dfgfdgfdg', 'dfgdfgfdg', '10:58:00', 'Academic', 0),
(10, 'sdfdsfdsf', '2025-02-02', 'sdfdsfdsf', 'dsfdfd', 'dssdfds', '09:21:00', 'Academic', 0),
(11, 'fdfdfdsf', '2025-01-08', 'sdfsdf', 'sdfdf', 'dsfdsf', '22:51:00', 'Academic', 0),
(12, 'gffdf', '2025-01-15', 'sdfsdfds', 'sdfdsf', 'sdfdsf', '17:15:00', 'Academic', 0),
(13, 'a', '2025-01-16', 'f', 'f', 'f', '22:28:00', 'Academic', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `session_name` varchar(255) NOT NULL,
  `experience_level` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `members` int(11) NOT NULL DEFAULT 0,
  `student_id` varchar(20) DEFAULT NULL,
  `lecturer_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `session_name`, `experience_level`, `time`, `location`, `max_participants`, `members`, `student_id`, `lecturer_id`) VALUES
(7, 'PUBG', 'Beginner', 'Weekends Morning', 'Library', 2, 1, 'A24EC0098', NULL),
(8, 'ML', 'Beginner', 'Weekdays Evening', 'dfgg', 3, 1, 'A21EC0011', NULL),
(9, 'ML', 'Beginner', 'Weekdays Evening', 'dfg', 2, 0, 'A21EC0011', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `matric_no` varchar(20) NOT NULL,
  `stud_name` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`matric_no`, `stud_name`, `course`, `course_code`, `email`, `phone_number`, `file_path`, `last_login`, `username`, `password`) VALUES
('A21EC0011', 'Nurul Aisyah', 'Bachelors of Software Engineering', '4/SECVH', 'nurul.aisyah@graduate.utm.my', '0987654321', NULL, '2025-01-13 14:18:04', 'nurul_aisyah', 'na12'),
('A21EC0567', 'Hafiz Rahman', 'Bachelors of Software Engineering', '4/SECVH', 'hafiz.rahman@graduate.utm.my', '0011223344', NULL, NULL, 'hafiz_rahman', 'hr123'),
('A21EC0765', 'John Lee', 'Bachelors of Data Science', '4/SECJH', 'john.lee@graduate.utm.my', '6677889900', NULL, NULL, 'john_lee', 'jl123'),
('A22EC0283', 'Ahmad Hazim', 'Bachelors of Software Engineering', '3/SECVH', 'taimanaliff@gmail.com', '1234567890', 'upload/Gambr Rentgku.jpg', '2025-01-12 03:38:58', 'ahmdfa', 'tman00'),
('A22EC0345', 'Fatimah Zahra', 'Bachelors of Software Engineering', '3/SECVH', 'fatimah.zahra@graduate.utm.my', '5566778899', NULL, NULL, 'fatimah_zahra', 'fz123'),
('A22EC0567', 'Amirah Hassan', 'Bachelors of Data Science', '3/SECJH', 'amirah.hassan@graduate.utm.my', '3344556677', NULL, NULL, 'amirah_hassan', 'ah123'),
('A22EC0789', 'Sophia Lim', 'Bachelors of Data Science', '3/SECJH', 'sophia.lim@graduate.utm.my', '9900112233', NULL, NULL, 'sophia_lim', 'sl123'),
('A23EC0120', 'Ming Wei Tan', 'Bavhelors of Cybersecurity', '2/SECRH', 'nuraimiafiqah@graduate.utm.my', '1122334455', NULL, '2025-01-13 15:18:21', 'mingwei_tan', 'mt12'),
('A23EC0345', 'Daniel Pong', 'Bachelors of Computer Science', '2/SECVH', 'daniel.wong@graduate.utm.my', '2233445566', NULL, '1970-01-01 01:00:00', 'daniel_wong', 'dw123'),
('A23EC0456', 'Ali Hamzah', 'Bachelors of Computer Science', '2/SECVH', 'ali.hamzah@graduate.utm.my', '4455667788', NULL, '1970-01-01 01:00:00', 'ali_hamzah', 'ah123'),
('A24EC0098', 'Zulfiqar Ibrahim', 'Bachelors of Data Science', '1/SECJH', 'muhammaddenish@graduate.utm.my', '2233445566', NULL, '2025-01-13 07:29:59', 'zulfiqar_ibrahim', 'zai122'),
('A24EC0123', 'Zara Ali', 'Bachelors of Cybersecurity', '1/SECRH', 'zara.ali@graduate.utm.my', '1122334455', NULL, NULL, 'zara_ali', 'za123');

-- --------------------------------------------------------

--
-- Table structure for table `student_progress`
--

CREATE TABLE `student_progress` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `goal` text NOT NULL,
  `progress` int(11) NOT NULL CHECK (`progress` between 0 and 100),
  `target_date` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_progress`
--

INSERT INTO `student_progress` (`id`, `student_id`, `goal`, `progress`, `target_date`, `created_at`, `updated_at`) VALUES
(1, 'A22EC0283', 'dsdfs', 2, '2025-01-10', '2025-01-08 21:31:48', '2025-01-12 21:42:56'),
(8, 'A23EC0120', 'dfdfd', 6, '2025-01-07', '2025-01-12 23:13:48', '2025-01-12 23:13:53'),
(9, 'A24EC0098', 'number 1', 2, '2025-01-16', '2025-01-13 13:45:17', '2025-01-13 13:45:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_views`
--
ALTER TABLE `content_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `deleted_resources`
--
ALTER TABLE `deleted_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_contributions`
--
ALTER TABLE `forum_contributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_question_id` (`question_id`),
  ADD KEY `fk_reply_id` (`reply_id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`employee_no`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `merit_scores`
--
ALTER TABLE `merit_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seminar_id` (`seminar_id`),
  ADD KEY `participant_id` (`participant_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `payment_proofs`
--
ALTER TABLE `payment_proofs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peer_collaborations`
--
ALTER TABLE `peer_collaborations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matric_no` (`matric_no`),
  ADD KEY `employee_no` (`employee_no`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `matric_no` (`matric_no`),
  ADD KEY `employee_no` (`employee_no`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resource_sharing`
--
ALTER TABLE `resource_sharing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_resource_id` (`resource_id`);

--
-- Indexes for table `seminar`
--
ALTER TABLE `seminar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`matric_no`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `content_views`
--
ALTER TABLE `content_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deleted_resources`
--
ALTER TABLE `deleted_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `forum_contributions`
--
ALTER TABLE `forum_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `merit_scores`
--
ALTER TABLE `merit_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `participation`
--
ALTER TABLE `participation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `peer_collaborations`
--
ALTER TABLE `peer_collaborations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `resource_sharing`
--
ALTER TABLE `resource_sharing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seminar`
--
ALTER TABLE `seminar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `student_progress`
--
ALTER TABLE `student_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `content_views`
--
ALTER TABLE `content_views`
  ADD CONSTRAINT `content_views_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

--
-- Constraints for table `forum_contributions`
--
ALTER TABLE `forum_contributions`
  ADD CONSTRAINT `fk_question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `fk_reply_id` FOREIGN KEY (`reply_id`) REFERENCES `replies` (`id`),
  ADD CONSTRAINT `forum_contributions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`matric_no`) ON DELETE CASCADE;

--
-- Constraints for table `merit_scores`
--
ALTER TABLE `merit_scores`
  ADD CONSTRAINT `merit_scores_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`matric_no`) ON DELETE CASCADE;

--
-- Constraints for table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`seminar_id`) REFERENCES `seminar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`participant_id`) REFERENCES `students` (`matric_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `participation_ibfk_3` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`employee_no`) ON DELETE CASCADE;

--
-- Constraints for table `peer_collaborations`
--
ALTER TABLE `peer_collaborations`
  ADD CONSTRAINT `peer_collaborations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`matric_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `peer_collaborations_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`matric_no`) REFERENCES `students` (`matric_no`) ON DELETE SET NULL,
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`employee_no`) REFERENCES `lecturers` (`employee_no`) ON DELETE SET NULL;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`matric_no`) REFERENCES `students` (`matric_no`) ON DELETE SET NULL,
  ADD CONSTRAINT `replies_ibfk_3` FOREIGN KEY (`employee_no`) REFERENCES `lecturers` (`employee_no`) ON DELETE SET NULL;

--
-- Constraints for table `resource_sharing`
--
ALTER TABLE `resource_sharing`
  ADD CONSTRAINT `fk_resource_id` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resource_sharing_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`matric_no`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`matric_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`employee_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD CONSTRAINT `student_progress_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`matric_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
