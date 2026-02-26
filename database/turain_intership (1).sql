-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 08:03 AM
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
-- Database: `turain_intership`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_assignment_submission_full_data` ()   BEGIN
    SELECT 
        sub.assign_id,
        sub.project_link,
        sub.submission,
        sub.submitted_by_mentor,
         sub.submitted_by_hr,
        sub.id,

        ass.project,

        a.candidate_id,

        i.name AS candidate_name

    FROM assignment_submissions sub

    LEFT JOIN assignment ass
        ON ass.id = sub.assign_id

    LEFT JOIN assign a
        ON a.id = sub.assign_id

    LEFT JOIN intern_data i
        ON i.id = a.candidate_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_candidate_assignment_data` (IN `p_candidate_id` INT)   BEGIN
    SELECT 
        a.id,
        a.candidate_id,
        a.mentor_id,

        m.name,

        ass.assign_id,
        ass.project,
        ass.documentation,
        ass.project_description,
        ass.start_date,
        ass.end_date

    FROM assign a

    -- ✅ FIX: correct mentor join
    LEFT JOIN mentor_data m 
        ON m.id = a.mentor_id

    -- ✅ assignment join
    LEFT JOIN assignment ass 
        ON ass.assign_id = a.id

    WHERE a.candidate_id = p_candidate_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_candidate_assignment_submission` (IN `p_candidate_id` INT)   BEGIN
    SELECT 
        a.id AS assign_id,
        a.candidate_id,

        ass.project,
        ass.start_date,

        sub.project_link,
        sub.submission,
        sub.submitted_by_mentor

    FROM assign a

    LEFT JOIN assignment ass
        ON ass.assign_id = a.id

    LEFT JOIN assignment_submissions sub
        ON sub.assign_id = ass.id

    WHERE a.candidate_id = p_candidate_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_intern_profile` (IN `intern_id` INT)   BEGIN
    SELECT 
        i.*,
        s.name AS state_name,
        d.name AS district_name,
        c.name AS city_name
    FROM intern_data i
    LEFT JOIN states s ON s.id = i.state
    LEFT JOIN districts d ON d.id = i.district
    LEFT JOIN cities c ON c.id = i.city
    WHERE i.id = intern_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_submitted_projects_by_user` (IN `p_user_id` INT)   BEGIN
    DECLARE v_candidate_id INT;
    DECLARE v_assign_id INT;

    -- Step 1: Get candidate internship ID
    SELECT internship_data_id
    INTO v_candidate_id
    FROM users
    WHERE id = p_user_id
    LIMIT 1;

    -- Step 2: Get assign ID
    SELECT id
    INTO v_assign_id
    FROM assign
    WHERE candidate_id = v_candidate_id
    LIMIT 1;

    -- Step 3: Get submitted assignments with submission data
    SELECT 
        a.id AS assignment_id,
        a.project,
        a.status,
        a.end_date,
         a.start_date,

        s.project_link,
        s.notes,
        s.submission,
        s.submitted_by_mentor,
        s.submitted_by_hr

    FROM assignment a
    LEFT JOIN assignment_submissions s
        ON s.assign_id = a.id
       AND s.assign_id = v_assign_id

    WHERE a.assign_id = v_assign_id
      AND a.status = 0;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `assign`
--

CREATE TABLE `assign` (
  `id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assign`
--

INSERT INTO `assign` (`id`, `mentor_id`, `candidate_id`, `status`) VALUES
(1, 1, 2, 1),
(2, 1, 6, 1),
(3, 3, 7, 1),
(4, 2, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL,
  `project` varchar(255) NOT NULL,
  `documentation` varchar(255) NOT NULL,
  `project_description` text DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`id`, `assign_id`, `project`, `documentation`, `project_description`, `start_date`, `end_date`, `status`) VALUES
(1, 1, 'asdtyukjhgfsdfghjk.htdszxchj', '1771654882_69994ee2073fe.pdf', 'sdrtyuikbvcxzsdujillkjhgJUYTRSXCVHJIUYTFDGHicvhjiuytfdcvhjiuytfvhjkoiuygfcvbjkiuytfvbjkiuytgfvhjiuytrdfguitrtyuihgvvbnm', '2026-02-21 11:13:23', '2026-02-23 00:00:00', 0),
(2, 2, 'asdtyukjhgf', '1771408261_DataTables Bootstrap Card Example.pdf', 'wertyuijhgfdsaertyuikjhgdAHJARFTYJHGFD', '2026-02-18 15:21:01', '2026-02-20 00:00:00', 1),
(3, 1, 'asdtyukjhgf', '1771408422_2bc5c17695484ae627313cb72ecc06ce (1).pdf', 'sdfgyuiokjsdsdfghjrtyu', '2026-02-18 15:23:42', '2026-03-12 00:00:00', 1),
(4, 2, 'asdtyukjhgfsdfghjk.htdszxchj', '1771593006_1771404536_21d091383c24116c84b3c256f3ae2d53.pdf', 'kkjhgfdsawertyukjhgfdsafghj,mnfdsartyuioiuytd', '2026-02-20 18:40:06', '2026-03-05 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_github`
--

CREATE TABLE `assignment_github` (
  `id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL,
  `github_link` text NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment_github`
--

INSERT INTO `assignment_github` (`id`, `assign_id`, `github_link`, `created_at`, `status`) VALUES
(1, 1, 'https://github.com/RiyaMondal0706/Turain_internship.git', '2026-02-24 05:46:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_notes`
--

CREATE TABLE `assignment_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assign_id` bigint(20) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment_notes`
--

INSERT INTO `assignment_notes` (`id`, `assign_id`, `note`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 'asdfghjkl,mndsdfghjk\ndftyuikol;.,mngfd\nhjkl;kjhgf', '2026-02-23 06:36:41', '2026-02-23 06:36:41', 1),
(2, 1, 'wertyuikjhgf\nsdrtyuiklmnbvc\nsdfghjk,mnbvcx', '2026-02-22 06:40:09', '2026-02-24 11:35:21', 1),
(3, 1, 'hrszxcghuytrdsxcgh\ntrsxfghytrdfghj\nytdxchj', '2026-02-21 07:55:55', '2026-02-24 11:35:34', 1),
(4, 3, 'qwe456789ytre\n345678opuy\n3ertghj\neszxfgio\nursxfgio\nytrsxghjk', '2026-02-22 01:18:40', '2026-02-24 04:30:07', 1),
(5, 3, 'drfyuiop;\'jhgfdswertyuio\nwertyu8iosfghjkl', '2026-02-23 02:46:13', '2026-02-24 04:40:31', 1),
(6, 3, 'u654wasdfyuiyfdxchj\nytrszxcghugfch\ndxcvhjgcvb\nuytrdfghj', '2026-02-24 03:00:19', '2026-02-24 04:29:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL,
  `project_link` text NOT NULL,
  `notes` text NOT NULL,
  `submission` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `submitted_by_mentor` text DEFAULT NULL,
  `submitted_by_hr` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment_submissions`
--

INSERT INTO `assignment_submissions` (`id`, `assign_id`, `project_link`, `notes`, `submission`, `status`, `submitted_by_mentor`, `submitted_by_hr`) VALUES
(1, 1, 'http://127.0.0.1:8000/candidate/projects', 'edrfyuiollkjhgfds\nwertyuionbvcx', '2026-02-24 07:21:23', 1, 'Good', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `district_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 12, 'Kolkata', NULL, NULL),
(2, 12, 'Salt Lake', NULL, NULL),
(3, 12, 'New Town', NULL, NULL),
(4, 12, 'Howrah', NULL, NULL),
(5, 12, 'Barrackpore', NULL, NULL),
(6, 1, 'Alipurduar', NULL, NULL),
(7, 1, 'Falakata', NULL, NULL),
(8, 1, 'Jaigaon', NULL, NULL),
(9, 1, 'Birpara', NULL, NULL),
(10, 1, 'Madarihat', NULL, NULL),
(11, 1, 'Kumargram', NULL, NULL),
(12, 2, 'Bankura', NULL, NULL),
(13, 2, 'Bishnupur', NULL, NULL),
(14, 2, 'Khatra', NULL, NULL),
(15, 2, 'Sonamukhi', NULL, NULL),
(16, 2, 'Onda', NULL, NULL),
(17, 2, 'Taldangra', NULL, NULL),
(18, 2, 'Raipur', NULL, NULL),
(19, 2, 'Indpur', NULL, NULL),
(20, 2, 'Gangajalghati', NULL, NULL),
(21, 2, 'Chhatna', NULL, NULL),
(22, 3, 'Suri', NULL, NULL),
(23, 3, 'Bolpur', NULL, NULL),
(24, 3, 'Rampurhat', NULL, NULL),
(25, 3, 'Nalhati', NULL, NULL),
(26, 3, 'Dubrajpur', NULL, NULL),
(27, 3, 'Sainthia', NULL, NULL),
(28, 3, 'Mayureswar', NULL, NULL),
(29, 3, 'Mohammad Bazar', NULL, NULL),
(30, 3, 'Murarai', NULL, NULL),
(31, 3, 'Labpur', NULL, NULL),
(32, 4, 'Cooch Behar', NULL, NULL),
(33, 4, 'Dinhata', NULL, NULL),
(34, 4, 'Mathabhanga', NULL, NULL),
(35, 4, 'Tufanganj', NULL, NULL),
(36, 4, 'Mekliganj', NULL, NULL),
(37, 4, 'Sitalkuchi', NULL, NULL),
(38, 4, 'Sitai', NULL, NULL),
(39, 4, 'Haldibari', NULL, NULL),
(40, 5, 'Balurghat', NULL, NULL),
(41, 5, 'Gangarampur', NULL, NULL),
(42, 5, 'Bansihari', NULL, NULL),
(43, 5, 'Kumarganj', NULL, NULL),
(44, 5, 'Harirampur', NULL, NULL),
(45, 5, 'Tapan', NULL, NULL),
(46, 5, 'Kushmandi', NULL, NULL),
(47, 6, 'Darjeeling', NULL, NULL),
(48, 6, 'Siliguri', NULL, NULL),
(49, 6, 'Kurseong', NULL, NULL),
(50, 6, 'Mirik', NULL, NULL),
(51, 6, 'Matigara', NULL, NULL),
(52, 6, 'Naxalbari', NULL, NULL),
(53, 6, 'Phansidewa', NULL, NULL),
(54, 7, 'Chinsurah', NULL, NULL),
(55, 7, 'Chandannagar', NULL, NULL),
(56, 7, 'Serampore', NULL, NULL),
(57, 7, 'Rishra', NULL, NULL),
(58, 7, 'Uttarpara', NULL, NULL),
(59, 7, 'Baidyabati', NULL, NULL),
(60, 7, 'Bhadreswar', NULL, NULL),
(61, 7, 'Arambagh', NULL, NULL),
(62, 7, 'Tarakeswar', NULL, NULL),
(63, 7, 'Pandua', NULL, NULL),
(64, 8, 'Howrah', NULL, NULL),
(65, 8, 'Uluberia', NULL, NULL),
(66, 8, 'Domjur', NULL, NULL),
(67, 8, 'Bagnan', NULL, NULL),
(68, 8, 'Amta', NULL, NULL),
(69, 8, 'Shyampur', NULL, NULL),
(70, 8, 'Bally', NULL, NULL),
(71, 9, 'Jalpaiguri', NULL, NULL),
(72, 9, 'Malbazar', NULL, NULL),
(73, 9, 'Dhupguri', NULL, NULL),
(74, 9, 'Maynaguri', NULL, NULL),
(75, 9, 'Rajganj', NULL, NULL),
(76, 9, 'Nagrakata', NULL, NULL),
(77, 10, 'Jhargram', NULL, NULL),
(78, 10, 'Gopiballavpur', NULL, NULL),
(79, 10, 'Binpur', NULL, NULL),
(80, 10, 'Lalgarh', NULL, NULL),
(81, 10, 'Jamboni', NULL, NULL),
(82, 10, 'Sankrail', NULL, NULL),
(83, 11, 'Kalimpong', NULL, NULL),
(84, 11, 'Gorubathan', NULL, NULL),
(85, 11, 'Lava', NULL, NULL),
(86, 11, 'Loleygaon', NULL, NULL),
(87, 11, 'Pedong', NULL, NULL),
(88, 13, 'Malda', NULL, NULL),
(89, 13, 'English Bazar', NULL, NULL),
(90, 13, 'Chanchal', NULL, NULL),
(91, 13, 'Gazole', NULL, NULL),
(92, 13, 'Ratua', NULL, NULL),
(93, 13, 'Harishchandrapur', NULL, NULL),
(94, 13, 'Manikchak', NULL, NULL),
(95, 14, 'Berhampore', NULL, NULL),
(96, 14, 'Domkal', NULL, NULL),
(97, 14, 'Jangipur', NULL, NULL),
(98, 14, 'Murshidabad', NULL, NULL),
(99, 14, 'Raghunathganj', NULL, NULL),
(100, 14, 'Kandi', NULL, NULL),
(101, 14, 'Lalgola', NULL, NULL),
(102, 15, 'Krishnanagar', NULL, NULL),
(103, 15, 'Ranaghat', NULL, NULL),
(104, 15, 'Nabadwip', NULL, NULL),
(105, 15, 'Kalyani', NULL, NULL),
(106, 15, 'Shantipur', NULL, NULL),
(107, 15, 'Haringhata', NULL, NULL),
(108, 16, 'Barasat', NULL, NULL),
(109, 16, 'Barrackpore', NULL, NULL),
(110, 16, 'Dum Dum', NULL, NULL),
(111, 16, 'Habra', NULL, NULL),
(112, 16, 'Ashoknagar', NULL, NULL),
(113, 16, 'Bangaon', NULL, NULL),
(114, 16, 'Basirhat', NULL, NULL),
(115, 17, 'Asansol', NULL, NULL),
(116, 17, 'Durgapur', NULL, NULL),
(117, 17, 'Raniganj', NULL, NULL),
(118, 17, 'Pandaveswar', NULL, NULL),
(119, 17, 'Chittaranjan', NULL, NULL),
(120, 18, 'Kharagpur', NULL, NULL),
(121, 18, 'Medinipur', NULL, NULL),
(122, 18, 'Chandrakona', NULL, NULL),
(123, 18, 'Dantan', NULL, NULL),
(124, 18, 'Garhbeta', NULL, NULL),
(125, 18, 'Salboni', NULL, NULL),
(126, 19, 'Bardhaman', NULL, NULL),
(127, 19, 'Kalna', NULL, NULL),
(128, 19, 'Katwa', NULL, NULL),
(129, 19, 'Purbasthali', NULL, NULL),
(130, 19, 'Guskara', NULL, NULL),
(131, 20, 'Tamluk', NULL, NULL),
(132, 20, 'Haldia', NULL, NULL),
(133, 20, 'Contai', NULL, NULL),
(134, 20, 'Egra', NULL, NULL),
(135, 20, 'Nandakumar', NULL, NULL),
(136, 20, 'Medinipur', NULL, NULL),
(137, 21, 'Purulia', NULL, NULL),
(138, 21, 'Raghunathpur', NULL, NULL),
(139, 21, 'Joypur', NULL, NULL),
(140, 21, 'Balarampur', NULL, NULL),
(141, 21, 'Hura', NULL, NULL),
(142, 22, 'Alipore', NULL, NULL),
(143, 22, 'Diamond Harbour', NULL, NULL),
(144, 22, 'Baruipur', NULL, NULL),
(145, 22, 'Canning', NULL, NULL),
(146, 22, 'Bhangar', NULL, NULL),
(147, 22, 'Kulpi', NULL, NULL),
(148, 22, 'Basanti', NULL, NULL),
(149, 23, 'Raiganj', NULL, NULL),
(150, 23, 'Islampur', NULL, NULL),
(151, 23, 'Kaliyaganj', NULL, NULL),
(152, 23, 'Itahar', NULL, NULL),
(153, 23, 'Harirampur', NULL, NULL),
(154, 23, 'Goalpokhar', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `department_code` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `department_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Software Development', 'DEV', 1, '2026-02-19 07:19:08', '2026-02-20 03:09:19'),
(2, 'Web Development', 'WEB', 1, '2026-02-19 07:19:08', '2026-02-19 07:19:08'),
(3, 'Mobile App Development', 'MOB', 1, '2026-02-19 07:19:08', '2026-02-19 07:19:08'),
(4, 'Quality Assurance', 'QA', 1, '2026-02-19 07:19:08', '2026-02-19 07:19:08'),
(5, 'UI / UX Design', 'UX', 1, '2026-02-19 07:19:08', '2026-02-19 07:19:08'),
(6, 'DevOps & Cloud', 'DEVOPS', 1, '2026-02-19 07:19:08', '2026-02-19 07:19:08'),
(7, 'Data Science', 'DATA', 0, '2026-02-19 07:19:08', '2026-02-20 03:08:47'),
(8, 'Digital Marketing', 'DM', 1, '2026-02-19 07:19:08', '2026-02-19 07:19:08'),
(9, 'Human Resources', 'HR', 1, '2026-02-19 07:19:08', '2026-02-19 07:19:08'),
(10, 'Sales & Business Development', 'SALES', 1, '2026-02-19 07:19:08', '2026-02-19 07:19:08'),
(11, 'Graphics', 'GRA', 1, '2026-02-19 05:11:07', '2026-02-19 05:11:07');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation_name` varchar(100) NOT NULL,
  `level` enum('Junior','Mid','Senior','Lead','Manager') DEFAULT 'Junior',
  `status` tinyint(4) DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `department_id`, `designation_name`, `level`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Software Engineer', 'Junior', 1, '2026-02-19 07:19:22', '2026-02-20 09:26:32'),
(2, 1, 'Senior Software Engineer', 'Senior', 1, '2026-02-19 07:19:22', '2026-02-20 09:26:32'),
(3, 1, 'Tech Lead', 'Lead', 0, '2026-02-19 07:19:22', '2026-02-20 03:09:19'),
(4, 2, 'Frontend Developer', 'Junior', 0, '2026-02-19 07:19:22', '2026-02-20 03:55:15'),
(5, 2, 'Backend Developer', 'Mid', 0, '2026-02-19 07:19:22', '2026-02-20 03:55:15'),
(6, 2, 'Full Stack Developer', 'Senior', 0, '2026-02-19 07:19:22', '2026-02-20 03:55:15'),
(7, 3, 'Android Developer', 'Junior', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(8, 3, 'iOS Developer', 'Mid', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(9, 3, 'Mobile App Lead', 'Lead', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(10, 4, 'QA Tester', 'Junior', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(11, 4, 'Automation Test Engineer', 'Mid', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(12, 4, 'QA Lead', 'Lead', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(13, 5, 'UI Designer', 'Junior', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(14, 5, 'UX Researcher', 'Mid', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(15, 5, 'Product Designer', 'Senior', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(16, 9, 'HR Executive', 'Junior', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(17, 9, 'HR Manager', 'Manager', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(18, 10, 'Business Development Executive', 'Junior', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(19, 10, 'Sales Manager', 'Manager', 1, '2026-02-19 07:19:22', '2026-02-20 08:17:25'),
(20, 11, 'Graphics Designer', 'Junior', 1, '2026-02-19 05:32:33', '2026-02-20 08:17:25'),
(21, 11, 'UI Designer', 'Mid', 1, '2026-02-19 05:33:27', '2026-02-20 08:17:25'),
(22, 1, 'UI Designer', 'Junior', 1, '2026-02-20 00:22:35', '2026-02-20 09:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `state_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 28, 'Alipurduar', NULL, NULL),
(2, 28, 'Bankura', NULL, NULL),
(3, 28, 'Birbhum', NULL, NULL),
(4, 28, 'Cooch Behar', NULL, NULL),
(5, 28, 'Dakshin Dinajpur', NULL, NULL),
(6, 28, 'Darjeeling', NULL, NULL),
(7, 28, 'Hooghly', NULL, NULL),
(8, 28, 'Howrah', NULL, NULL),
(9, 28, 'Jalpaiguri', NULL, NULL),
(10, 28, 'Jhargram', NULL, NULL),
(11, 28, 'Kalimpong', NULL, NULL),
(12, 28, 'Kolkata', NULL, NULL),
(13, 28, 'Malda', NULL, NULL),
(14, 28, 'Murshidabad', NULL, NULL),
(15, 28, 'Nadia', NULL, NULL),
(16, 28, 'North 24 Parganas', NULL, NULL),
(17, 28, 'Paschim Bardhaman', NULL, NULL),
(18, 28, 'Paschim Medinipur', NULL, NULL),
(19, 28, 'Purba Bardhaman', NULL, NULL),
(20, 28, 'Purba Medinipur', NULL, NULL),
(21, 28, 'Purulia', NULL, NULL),
(22, 28, 'South 24 Parganas', NULL, NULL),
(23, 28, 'Uttar Dinajpur', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intern_data`
--

CREATE TABLE `intern_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `designation` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `dob` varchar(255) NOT NULL,
  `github_link` text DEFAULT NULL,
  `mp_boad` text DEFAULT NULL,
  `mp_marks` varchar(255) DEFAULT NULL,
  `hs_boad` text DEFAULT NULL,
  `hs_marks` text DEFAULT NULL,
  `graduation` text DEFAULT NULL,
  `graduation_cgpa` text DEFAULT NULL,
  `post_graduation` text DEFAULT NULL,
  `post_graduation_cgpa` text DEFAULT NULL,
  `address` longtext NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `state` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `district` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `create_at` datetime NOT NULL,
  `entry_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `intern_data`
--

INSERT INTO `intern_data` (`id`, `name`, `email`, `phone`, `designation`, `department`, `dob`, `github_link`, `mp_boad`, `mp_marks`, `hs_boad`, `hs_marks`, `graduation`, `graduation_cgpa`, `post_graduation`, `post_graduation_cgpa`, `address`, `pincode`, `state`, `city`, `district`, `image`, `create_at`, `entry_date`, `end_date`, `status`) VALUES
(1, 'Dipti Show', 'yesom61903@esyline.com', '6789098765', '8', '3', '2001-10-11', 'https://chatgpt.com/c/699401aa-a378-8322-add3-c1a177d7be0d', 'ertyuiolkjhg', '55', 'sdfghnm', '55.44', 'dfghjk', '55.88', 'jmnbv', '55.66', 'rghjjhgfdshtresxcghuytfd', '678883', 28, 98, '14', '1771331788_699460cc9973e.jpg', '2026-02-14 16:01:08', '2026-02-25', '2026-05-25', 1),
(2, 'Dipa', 'werelac629@homuno.com', '8654334567', '16', '9', '2000-06-14', NULL, 'ertyuiolkjhg', '45', 'asdfghj', '55', 'tgyhjklkjhg', '54.67', 'wertyuiklmnbfds', '44.77', 'oiuygfcvbn', '765432', 28, 84, '11', '2.jpg', '2026-02-14 16:11:14', '2026-02-18', '2026-05-18', 1),
(6, 'Joti Das', 'bohik57143@bitonc.com', '6789098765', '7', '3', '1998-06-20', NULL, 'ertyuiolkjhg', '45', 'sdfghnm', '33.99', 'wertyjk', '44', 'asdfghj', '66.77', 'rghjjhgfds', '345678', 28, 84, '11', '1771317635_6994298351c39.jpg', '2026-02-17 08:36:55', '2026-02-18', '2026-05-18', 1),
(7, 'Ridhi Sen', 'fejag77136@bitonc.com', '6789098765', '18', '10', '2000-06-15', NULL, 'ertyuiolkjhg', '45.76', 'sdfghnm', '66.76', 'qwertyuk.', '55.88', 'jmnbv', '44', 'rghjjhgfds', '345678', 28, 2, '12', '1771318182_69942ba6b2b74.jpg', '2026-02-17 08:49:42', '2026-02-23', '2026-05-23', 1),
(8, 'Rohit Show', 'intense.tiger.zlfj@hidingmail.com', '6789098765', '3', '1', '2000-06-06', NULL, 'ertyuiolkjhg', '45.76', 'asdfghj', '55.44', 'sdfghjklkjhgfd', '54.67', 'wertyuiklmnbfds', '66.77', 'rghjjhgfds', '345678', 28, 84, '11', '1771486620_6996bd9c362cb.jpg', '2026-02-19 07:37:00', '2026-02-23', '2026-05-23', 1),
(9, 'Rita Ghos', 'godir83444@amiralty.com', '6789098765', '1', '1', '2000-06-15', NULL, 'skutrdghjk', '33', 'scv cxasdfbnm', '65', 'dfghmnbvdsaa', '66', 'wertyujhgfds', '88', 'wertyuiklkjhgfd', '345678', 28, 72, '9', '1771999829_699e92557a97e.jpg', '2026-02-23 08:23:00', '2026-03-01', '2026-06-01', 1),
(10, 'Ritik Halder', 'gesivam917@hutudns.com', '6789098765', '7', '3', '1998-05-20', NULL, 'skutrdghjk', '46', 'scv cxasdfbnm', '33.77', 'dfghmnbvdsaa', '77.55', 'wertyujhgfds', '33.87', 'rghjjhgfds', '345678', 28, 84, '11', '1771999792_699e9230690b8.jpg', '2026-02-25 06:09:52', '2026-03-02', '2026-06-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentor_data`
--

CREATE TABLE `mentor_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentor_data`
--

INSERT INTO `mentor_data` (`id`, `name`, `email`, `phone`, `designation`, `department`, `address`, `image`, `created_at`, `status`) VALUES
(1, 'Dipti Show', 'yesom61903@esyline.com', '6789098765', '9', '3', 'rghjjhgfdsjytrsxcghjsedrftyjjhgfd', '1771324884_699445d48d691.jpg', '2026-02-17 10:41:24', 1),
(2, 'Subir Das', 'dasawe8630@esyline.com', '6789098765', '7', '3', 'rghjjhgfds', '1771330481_69945bb11606e.jpg', '2026-02-17 12:14:41', 1),
(3, 'Subham Varma', 'rival.mandrill.ccau@hidingmail.com', '6789098765', '2', '1', 'rghjjhgfds', '1771488651_6996c58bc0d9b.jpg', '2026-02-19 08:10:51', 1),
(4, 'Sumit Show', 'bocipaj644@hutudns.com', '6789098765', '1', '1', 'rghjjhgfds', '1772083400_699fd8c8e82a6.jpg', '2026-02-26 05:23:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('modalriya0706@gmail.com', '$2y$12$BJbGrZ2wYn/hZ6x6/UQTh.S9HfWtwV27H44Cb0kqz4oArSmee7/hS', '2026-02-12 02:12:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('35HGscAmFxCrFUdkyWNs970Tvzqcp5j8MZU4H8zq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSzYyNkdnWnpXeFdsamR3TW1maldJdk54TWlHMVUwVnFrVUJ4cmNjUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW50b3IvcHJvZmlsZSI7czo1OiJyb3V0ZSI7czoxMjoicHJvZmlsZS5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo3OiJ1c2VyX2lkIjtpOjg7czo5OiJ1c2VyX3JvbGUiO3M6NjoibWVudG9yIjt9', 1772088994);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Andhra Pradesh', 'AP', NULL, NULL),
(2, 'Arunachal Pradesh', 'AR', NULL, NULL),
(3, 'Assam', 'AS', NULL, NULL),
(4, 'Bihar', 'BR', NULL, NULL),
(5, 'Chhattisgarh', 'CG', NULL, NULL),
(6, 'Goa', 'GA', NULL, NULL),
(7, 'Gujarat', 'GJ', NULL, NULL),
(8, 'Haryana', 'HR', NULL, NULL),
(9, 'Himachal Pradesh', 'HP', NULL, NULL),
(10, 'Jharkhand', 'JH', NULL, NULL),
(11, 'Karnataka', 'KA', NULL, NULL),
(12, 'Kerala', 'KL', NULL, NULL),
(13, 'Madhya Pradesh', 'MP', NULL, NULL),
(14, 'Maharashtra', 'MH', NULL, NULL),
(15, 'Manipur', 'MN', NULL, NULL),
(16, 'Meghalaya', 'ML', NULL, NULL),
(17, 'Mizoram', 'MZ', NULL, NULL),
(18, 'Nagaland', 'NL', NULL, NULL),
(19, 'Odisha', 'OD', NULL, NULL),
(20, 'Punjab', 'PB', NULL, NULL),
(21, 'Rajasthan', 'RJ', NULL, NULL),
(22, 'Sikkim', 'SK', NULL, NULL),
(23, 'Tamil Nadu', 'TN', NULL, NULL),
(24, 'Telangana', 'TS', NULL, NULL),
(25, 'Tripura', 'TR', NULL, NULL),
(26, 'Uttar Pradesh', 'UP', NULL, NULL),
(27, 'Uttarakhand', 'UK', NULL, NULL),
(28, 'West Bengal', 'WB', NULL, NULL),
(29, 'Andaman and Nicobar Islands', 'AN', NULL, NULL),
(30, 'Chandigarh', 'CH', NULL, NULL),
(31, 'Dadra and Nagar Haveli and Daman and Diu', 'DN', NULL, NULL),
(32, 'Delhi', 'DL', NULL, NULL),
(33, 'Jammu and Kashmir', 'JK', NULL, NULL),
(34, 'Ladakh', 'LA', NULL, NULL),
(35, 'Lakshadweep', 'LD', NULL, NULL),
(36, 'Puducherry', 'PY', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('hr','candidate','mentor') NOT NULL DEFAULT 'candidate',
  `turain_id` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT 1,
  `internship_data_id` int(11) DEFAULT NULL,
  `mentor_data_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `turain_id`, `status`, `internship_data_id`, `mentor_data_id`) VALUES
(1, 'Bikash Prasad', 'bikashprasad14@gmail.com', NULL, '$2y$12$fs5/csgqoOBHXMsn/ghohOZgX041roYtwQsJuLkXk9ezbg4NHUZPq', NULL, '2026-02-11 19:24:52', '2026-02-11 19:24:52', 'mentor', NULL, 1, 0, NULL),
(2, 'Riya Mondal', 'modalriya0706@gmail.com', NULL, '$2y$12$rW7CRayHnXD/85ziINqaye6Ew1FOuaad2f.rtt2LQgwxk61xe2ime', 'UsOsxiDdhaUj0N3QItRluXdFm9PcM1liWMrQT8Ki9ElZL5V7aV0t33bBgdYB', '2026-02-11 19:26:20', '2026-02-11 19:26:20', 'candidate', NULL, 1, 0, NULL),
(3, 'Hr', 'hr@turaingrp.com', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-11 19:42:56', '2026-02-11 19:42:56', 'hr', NULL, 1, 0, NULL),
(4, 'Rimpa das', 'xehofom753@homuno.com', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-14 10:31:08', '2026-02-14 10:31:08', 'candidate', 'turain3454', 1, 1, NULL),
(5, 'Dipa', 'werelac629@homuno.com', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-14 10:41:14', '2026-02-14 10:41:14', 'candidate', 'turain1413', 1, 2, NULL),
(6, 'Joti Das', 'bohik57143@bitonc.com', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-17 03:06:56', '2026-02-17 03:06:56', 'candidate', 'turain8287', 1, 6, NULL),
(7, 'Ridhi Sen', 'fejag77136@bitonc.com', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-17 03:19:43', '2026-02-17 03:19:43', 'candidate', 'turain2630', 1, 7, NULL),
(8, 'Dipti Show', 'yesom61903@esyline.com', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-17 05:11:24', '2026-02-17 05:11:24', 'mentor', 'turain2560', 1, 0, 1),
(9, 'Subir Das', 'dasawe8630@esyline.com', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-17 06:44:41', '2026-02-17 06:44:41', 'mentor', 'turain2562', 1, NULL, 2),
(10, 'Rohit Show', 'intense.tiger.zlfj@hidingmail.com', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-19 02:07:00', '2026-02-19 02:07:00', 'candidate', 'turain1480', 1, 8, NULL),
(11, 'Subham Varma', 'rival.mandrill.ccau@hidingmail.com', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-19 02:40:52', '2026-02-19 02:40:52', 'mentor', 'turain4864', 1, NULL, 3),
(12, 'Rita Ghos', 'godir83444@amiralty.com', NULL, '$2y$12$cOE03iThfyvL1/QUspKG0.DseJgsWf2Fj712Jehh.8tXsoCOD7MRS', NULL, '2026-02-23 02:53:00', '2026-02-23 02:53:00', 'candidate', 'turain7505', 1, 9, NULL),
(13, 'Ritik Halder', 'gesivam917@hutudns.com', NULL, '$2y$12$ygpB/4fqhbJYreSn3iKjHe6N8m6lfzgZDCayBUOxzwBg0iJ4.vHby', NULL, '2026-02-25 00:39:52', '2026-02-25 00:39:52', 'candidate', 'turain3471', 1, 10, NULL),
(14, 'Sumit Show', 'bocipaj644@hutudns.com', NULL, '$2y$12$WuJOFYPxJQlZSU3B/B0F2.SZmxk/ymNYhoW2FMZakrIMwrbEmi9Qy', NULL, '2026-02-25 23:53:21', '2026-02-25 23:53:21', 'mentor', 'turain6209', 1, NULL, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign`
--
ALTER TABLE `assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_github`
--
ALTER TABLE `assignment_github`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_notes`
--
ALTER TABLE `assignment_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_name` (`department_name`),
  ADD UNIQUE KEY `department_code` (`department_code`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_designation_department` (`department_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `intern_data`
--
ALTER TABLE `intern_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentor_data`
--
ALTER TABLE `mentor_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign`
--
ALTER TABLE `assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assignment_github`
--
ALTER TABLE `assignment_github`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignment_notes`
--
ALTER TABLE `assignment_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intern_data`
--
ALTER TABLE `intern_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mentor_data`
--
ALTER TABLE `mentor_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `fk_designation_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
