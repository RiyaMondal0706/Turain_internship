-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2026 at 02:34 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_birthdays_desc_all` ()   SELECT
    name,
    designation,
    dob,
    role
FROM (
    SELECT
        name,
        designation,
        dob,
        role,
        IF(
            DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(dob), '-', DAY(dob))) < CURDATE(),
            DATE(CONCAT(YEAR(CURDATE()) + 1, '-', MONTH(dob), '-', DAY(dob))),
            DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(dob), '-', DAY(dob)))
        ) AS next_birthday
    FROM (
        -- Interns
        SELECT name, designation, dob, 'Intern' AS role
        FROM intern_data

        UNION ALL

        -- Mentors
        SELECT name, designation, dob, 'Mentor' AS role
        FROM mentor_data
    ) t
) final

WHERE
    next_birthday BETWEEN CURDATE()
    AND DATE_ADD(CURDATE(), INTERVAL 2 MONTH)

ORDER BY
    next_birthday ASC$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_upcoming_2_month_entries` ()   BEGIN

    SELECT
        name,
        designation,
        entry_date,
        role
    FROM (
        -- Interns
        SELECT
            name,
            designation,
            entry_date,
            'Intern' AS role
        FROM intern_data

        UNION ALL

        -- Mentors
        SELECT
            name,
            designation,
            entry_date,
            'Mentor' AS role
        FROM mentor_data
    ) AS all_users

    -- upcoming anniversaries (ignore year)
    WHERE
        DATE_FORMAT(entry_date, '%m-%d')
        BETWEEN DATE_FORMAT(CURDATE(), '%m-%d')
        AND DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 2 MONTH), '%m-%d')

    -- ✅ ASCENDING ORDER
    ORDER BY
        MONTH(entry_date) ASC,
        DAY(entry_date) ASC;

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
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 2, 3, 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-boost.roster.scan', 'a:2:{s:6:\"roster\";O:21:\"Laravel\\Roster\\Roster\":3:{s:13:\"\0*\0approaches\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:8:{i:0;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^12.0\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:LARAVEL\";s:14:\"\0*\0packageName\";s:17:\"laravel/framework\";s:10:\"\0*\0version\";s:7:\"12.47.0\";s:6:\"\0*\0dev\";b:0;}i:1;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:7:\"v0.3.10\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PROMPTS\";s:14:\"\0*\0packageName\";s:15:\"laravel/prompts\";s:10:\"\0*\0version\";s:6:\"0.3.10\";s:6:\"\0*\0dev\";b:0;}i:2;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.5.2\";s:10:\"\0*\0package\";E:33:\"Laravel\\Roster\\Enums\\Packages:MCP\";s:14:\"\0*\0packageName\";s:11:\"laravel/mcp\";s:10:\"\0*\0version\";s:5:\"0.5.2\";s:6:\"\0*\0dev\";b:1;}i:3;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.24\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PINT\";s:14:\"\0*\0packageName\";s:12:\"laravel/pint\";s:10:\"\0*\0version\";s:6:\"1.27.0\";s:6:\"\0*\0dev\";b:1;}i:4;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.41\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:SAIL\";s:14:\"\0*\0packageName\";s:12:\"laravel/sail\";s:10:\"\0*\0version\";s:6:\"1.52.0\";s:6:\"\0*\0dev\";b:1;}i:5;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^3.8\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PEST\";s:14:\"\0*\0packageName\";s:12:\"pestphp/pest\";s:10:\"\0*\0version\";s:5:\"3.8.4\";s:6:\"\0*\0dev\";b:1;}i:6;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:7:\"11.5.33\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PHPUNIT\";s:14:\"\0*\0packageName\";s:15:\"phpunit/phpunit\";s:10:\"\0*\0version\";s:7:\"11.5.33\";s:6:\"\0*\0dev\";b:1;}i:7;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:10:\"\0*\0package\";E:41:\"Laravel\\Roster\\Enums\\Packages:TAILWINDCSS\";s:14:\"\0*\0packageName\";s:11:\"tailwindcss\";s:10:\"\0*\0version\";s:6:\"4.1.18\";s:6:\"\0*\0dev\";b:1;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:21:\"\0*\0nodePackageManager\";E:43:\"Laravel\\Roster\\Enums\\NodePackageManager:NPM\";}s:9:\"timestamp\";i:1772108385;}', 1772194785);

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
-- Table structure for table `ch_messages`
--

CREATE TABLE `ch_messages` (
  `id` char(36) NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `body` varchar(5000) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ch_messages`
--

INSERT INTO `ch_messages` (`id`, `from_id`, `to_id`, `body`, `attachment`, `seen`, `created_at`, `updated_at`) VALUES
('0219d9cd-55d9-4dc2-ada2-b9c12fef1a38', 1, 2, 'sdfgh', NULL, 0, '2026-02-28 05:07:01', NULL),
('061d3cfe-fc77-461b-a0e2-cbf356f344f2', 2, 5, 'hii', NULL, 0, '2026-02-28 07:44:59', NULL),
('09d6e764-aa49-437e-964d-5073955ff009', 1, 5, 'sdfghjkhgfd', NULL, 0, '2026-02-28 04:37:10', NULL),
('1c3a2c7d-7b21-4cb9-a010-5b69027b8f60', 1, 5, 'hello', NULL, 0, '2026-02-28 03:57:52', NULL),
('25992005-c31b-4718-a59a-45a0d48ab82c', 1, 5, 'hii', NULL, 0, '2026-02-28 06:27:03', NULL),
('3b59daaa-28f8-4b85-81a5-c22c4a1222a1', 2, 1, 'hiii', NULL, 0, '2026-02-28 07:32:50', NULL),
('55301628-4dd7-419a-9e77-9d73a32ceadb', 1, 2, 'hiii', NULL, 0, '2026-02-28 07:14:36', NULL),
('77190c69-b44f-46f1-a13e-3143a6568c12', 2, 1, 'hiii', NULL, 0, '2026-02-28 07:04:31', NULL),
('832dcf54-aaa3-439d-8918-5050c7dfc78f', 1, 2, 'gtreszxcghjk', NULL, 0, '2026-02-28 06:27:11', NULL),
('86a2c961-e3de-4886-ad5d-713bb1d94b08', 1, 5, 'hii', NULL, 0, '2026-02-28 03:53:21', NULL),
('9ce6c860-d04c-45ac-8830-a72068e2e901', 1, 5, 'what are you doing', NULL, 0, '2026-02-28 04:06:25', NULL),
('ae7e46e7-7dba-4532-9913-43d292583370', 1, 5, 'How are You??', NULL, 0, '2026-02-28 04:02:36', NULL),
('cd1ead76-9133-41c0-85b9-2ed570024517', 1, 2, 'hii', NULL, 0, '2026-02-28 05:05:54', NULL),
('d6623621-00e2-425c-b21a-c5425c84bc4d', 1, 2, 'how are yoy', NULL, 0, '2026-02-28 07:33:29', NULL),
('f7674cf7-98dd-416d-8c72-844419c49a36', 1, 2, 'trsdfghj', NULL, 0, '2026-02-28 07:33:01', NULL);

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
(1, 1, 'Software Engineer', 'Junior', 1, '2026-02-19 07:19:22', '2026-02-27 07:09:23'),
(2, 1, 'Senior Software Engineer', 'Senior', 1, '2026-02-19 07:19:22', '2026-02-27 07:09:23'),
(3, 1, 'Tech Lead', 'Lead', 1, '2026-02-19 07:19:22', '2026-02-27 07:09:23'),
(4, 2, 'Frontend Developer', 'Junior', 1, '2026-02-19 07:19:22', '2026-02-27 12:09:58'),
(5, 2, 'Backend Developer', 'Mid', 1, '2026-02-19 07:19:22', '2026-02-27 12:09:58'),
(6, 2, 'Full Stack Developer', 'Senior', 1, '2026-02-19 07:19:22', '2026-02-27 12:09:58'),
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
(22, 1, 'UI Designer', 'Junior', 1, '2026-02-20 00:22:35', '2026-02-27 07:09:23');

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
(1, 'Susmita Mondal', 'bocipaj644@hutudns.com', '8765456789', '5', '2', '2000-03-02', NULL, 'WBBSE', '77.98', 'WBCHSE', '66.98', 'MAKAUT', '77', 'SVU', '88', 'Kolkata', '700012', 28, 84, '11', '1772196235_69a1918b82b18.jpg', '2026-02-27 12:43:55', '2026-03-02', '2026-06-02', 1),
(2, 'Rohit Show', '4lfp5@dollicons.com', '8765434567', '7', '3', '1999-03-30', NULL, 'CBSE', '88.33', 'CBSE', '33.77', 'Kolkata University', '88.44', 'MAKAUT', '44.77', 'Ulubaria', '567886', 28, 65, '8', '1772196490_69a1928aa2931.jpg', '2026-02-27 12:48:10', '2026-03-02', '2026-06-02', 1),
(3, 'Dipti Shen', '2odob@dollicons.com', '8765432345', '1', '1', '1999-05-06', NULL, 'WBBSE', '34.77', 'WBCHSE', '44.87', 'MAKAUT', '34.87', 'MAKAUT', '77.66', 'Kolkata', '876543', 28, 87, '11', '1772196670_69a1933e199d6.jpg', '2026-02-27 12:51:10', '2026-03-12', '2026-06-12', 1);

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
  `entry_date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `dob` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentor_data`
--

INSERT INTO `mentor_data` (`id`, `name`, `email`, `phone`, `designation`, `department`, `address`, `image`, `created_at`, `entry_date`, `status`, `dob`) VALUES
(1, 'Ayan Das', '3cte4@dollicons.com', '9876543456', '2', '1', 'kolkata', '1772197009_69a19491965ff.jpg', '2026-02-27 12:56:49', '2021-03-17 00:00:00', 1, NULL),
(2, 'Joti Das', 'bohik57143@bitonc.com', '6789098765', '13', '5', 'Kolkata', '1772197512_69a19688373d8.jpg', '2026-02-27 13:05:12', '2024-03-08 00:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('0PTRWel34ou76APdH4pkxmh0HcFYrtprgruqGuS2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNmFoaWt4OFgxbHlYMkV2dlVTamFEckt1VjZwb1BBbktxeXViZlkzbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGF0L3VzZXJzIjtzOjU6InJvdXRlIjtzOjI3OiJnZW5lcmF0ZWQ6OjYxcFREVFg0YVdEanZoamYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjc6InVzZXJfaWQiO2k6MTtzOjk6InVzZXJfcm9sZSI7czoyOiJociI7fQ==', 1772282057),
('o1MTC4nLGDwIIfrxtksLzkfAWSZyletDjBvMyOfU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZGE0Wmk0a3duWWg5UzJDcTdyRUI5YzVwTk01Vlc3akt4dUU3aVVkaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjpjVzJzQkJHdmFRSGhZNHY3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772283827),
('VE2si8xuVbLGC5RlEeXFGBddROVvAWf0aQ9dEmop', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaW1GUXZXSmZWUmQzMmJJMWVmRkdEMWY2NEhXUmFkY05LdElManBlTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjpjVzJzQkJHdmFRSGhZNHY3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772285612);

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
  `images` varchar(255) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `images`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `turain_id`, `status`, `internship_data_id`, `mentor_data_id`) VALUES
(1, 'Hr', 'hr@turaingrp.com', NULL, NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-11 14:12:56', '2026-02-11 14:12:56', 'hr', NULL, 1, 0, NULL),
(2, 'Susmita Mondal', 'bocipaj644@hutudns.com', '1772196235_69a1918b82b18.jpg', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-27 07:13:55', '2026-02-27 07:13:55', 'candidate', 'turain4111', 1, 1, NULL),
(3, 'Rohit Show', '4lfp5@dollicons.com', '1772196490_69a1928aa2931.jpg', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-27 07:18:11', '2026-02-27 07:18:11', 'candidate', 'turain8557', 1, 2, NULL),
(4, 'Dipti Shen', '2odob@dollicons.com', '1772196670_69a1933e199d6.jpg', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-27 07:21:10', '2026-02-27 07:21:10', 'candidate', 'turain3506', 1, 3, NULL),
(5, 'Ayan Das', '3cte4@dollicons.com', '1772197009_69a19491965ff.jpg', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-27 07:26:50', '2026-02-27 07:26:50', 'mentor', 'turain6110', 1, NULL, 1),
(6, 'Joti Das', 'bohik57143@bitonc.com', '1772197512_69a19688373d8.jpg', NULL, '$2y$12$OBTe4io9GOut1b3e9wz4s.fp41scg6K11LkNt04wnKyElEp3ksAA2', NULL, '2026-02-27 07:35:12', '2026-02-27 07:35:12', 'mentor', 'turain9475', 1, NULL, 2);

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
-- Indexes for table `ch_messages`
--
ALTER TABLE `ch_messages`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignment_github`
--
ALTER TABLE `assignment_github`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignment_notes`
--
ALTER TABLE `assignment_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mentor_data`
--
ALTER TABLE `mentor_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
