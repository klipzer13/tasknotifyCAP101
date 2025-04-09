-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 07:24 AM
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
-- Database: `final`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `task_id`, `filename`, `path`, `type`, `size`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(2, 2, '475916828_1332724591245341_7283285389048433987_n.jpg', 'images/IyVg4oNW168J2zwJTvhH6cyf9dvNawR0d63WlQGP.jpg', 'image/jpeg', 74422, 2, '2025-04-08 05:03:04', '2025-04-08 05:03:04'),
(3, 3, 'Annex-2-Consent-Form.docx', 'others/79hOmo6PYaDpFIVYi94M2jaIwVimoZqoOG5mQwLf.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 69489, 1, '2025-04-08 05:19:05', '2025-04-08 05:19:05'),
(4, 27, '3a.xlsx', 'spreadsheets/Y6fawe0qjZtFJT7GAUWEVqB0F4toALqOWt4id6QP.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 49854, 1, '2025-04-08 05:22:28', '2025-04-08 05:22:28'),
(5, 3, 'Screenshot (3).png', 'task_attachments/LHmU1cAYoPOveJD31OTGmoGMHoQ3DuxWZJF9EUaj.png', 'image/png', 900406, 2, '2025-04-08 06:54:38', '2025-04-08 06:54:38'),
(6, 3, 'Screenshot (11).png', 'task_attachments/XWUll5LiSJdtL9nSqc7RnznbNqqGtPAzlHMCO1T0.png', 'image/png', 445743, 2, '2025-04-08 07:22:44', '2025-04-08 07:22:44'),
(7, 13, '464981333_3800550490161174_290925355042106018_n.jpg', 'images/CFW8HczfL5PaSXRWpaiJssVz8NdCpHevT1c9Sa5G.jpg', 'image/jpeg', 17752, 1, '2025-04-08 07:24:03', '2025-04-08 07:24:03'),
(9, 3, 'Screenshot (8).png', 'task_attachments/CXXkmU7J2vbA1HRiWjj6bPQAalg2t0po97vjSe3q.png', 'image/png', 223160, 2, '2025-04-08 07:33:36', '2025-04-08 07:33:36'),
(14, 30, '462645634_2290791694630058_7129177464283296295_n.jpg', 'images/o3WUFuYbdB1v90t8ZII0s2xxuK2YsjOKHTW2qW21.jpg', 'image/jpeg', 114737, 6, '2025-04-08 19:24:16', '2025-04-08 19:24:16'),
(15, 33, '462645634_2290791694630058_7129177464283296295_n.jpg', 'images/FRbqrRiQLQbvFDJn1JIuPH6BxMD8bA6gkaqgyrxV.jpg', 'image/jpeg', 114737, 6, '2025-04-08 20:09:00', '2025-04-08 20:09:00');

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
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'IT', 'Information Technology', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(2, 'HR', 'Human Resources', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(3, 'Finance', 'Finance Department', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(4, 'Marketing', 'Marketing Team', '2025-04-08 03:35:23', '2025-04-08 03:35:23');

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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2025_03_26_092218_create_roles_table', 1),
(5, '2025_03_26_092229_create_departments_table', 1),
(6, '2025_03_26_092314_create_users_table', 1),
(7, '2025_03_26_120257_create_sessions_table', 1),
(8, '2025_03_27_062325_create_priorities_table', 1),
(9, '2025_03_27_062344_create_statuses_table', 1),
(10, '2025_03_27_062403_create_tasks_table', 1),
(11, '2025_03_27_062415_create_task_users_table', 1),
(12, '2025_03_27_062428_create_attachments_table', 1),
(13, '2025_04_08_135831_create_task_comments_table', 2),
(14, '2025_04_08_213355_create_task_audit_logs_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'high', '#ff6b6b', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(2, 'medium', '#ffd166', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(3, 'low', '#06d6a0', '2025-04-08 03:35:23', '2025-04-08 03:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Administrator', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(2, 'Chairperson', 'Department Manager', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(3, 'Employee', 'Regular Member', '2025-04-08 03:35:23', '2025-04-08 03:35:23');

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
('q9draTAjdYVSGSa6MSC3JMNFzLfIkhRWXfyXB4ci', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQW92cjZOY3VVNlRJNHpMQlNzMlhyQ0RFcEQ2ZU5CZ3BKdWFISWtSRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvdGFza3MiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc0NDE3MTkxMTt9fQ==', 1744174563),
('SyJy1pzNQhqtFrnf5DPh0cuMpy9b4crYtuetU9U6', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaGhnTVlOZkttMmdQeDdmQ2kyUjZuclNyYTVCcnlzYUtlTjNzbzdnciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2Vycy82L2VkaXQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc0NDE2ODI0NDt9fQ==', 1744171897);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'pending', '#6c757d', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(2, 'pending_approval', '#0dcaf0', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(3, 'in_progress', '#198754', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(4, 'completed', '#198754', '2025-04-08 03:35:23', '2025-04-08 03:35:23'),
(5, 'rejected', '#198754', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `priority_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `due_date`, `created_by`, `priority_id`, `created_at`, `updated_at`) VALUES
(2, 'Submit Monthly Accomplishment Report', 'All employees are required to submit their monthly accomplishment reports detailing their activities, accomplishments, and any pending tasks. Reports should be submitted in PDF format using the template provided in the shared drive.', '2025-04-09', 2, 1, '2025-04-08 05:03:04', '2025-04-08 05:03:04'),
(3, 'Review and Approve Purchase Request', 'Please review the submitted purchase request for new office supplies (bond paper, printer ink, staplers). Verify if the items align with the department’s approved budget and approve or request revision as necessary.', '2025-04-26', 1, 1, '2025-04-08 05:19:05', '2025-04-08 05:19:05'),
(4, 'Draft and Submit Minutes of the Departmental Meeting', 'Prepare a draft of the minutes from the IT Department meeting held on April 6, 2025. The draft should include key discussion points, decisions made, action items, and the attendance list. Submit the draft to the chairperson for review before finalizing.', '2025-04-09', 1, 3, '2025-04-08 05:22:28', '2025-04-08 05:22:28'),
(5, 'Upload Digitized Student Records to Central Archive', 'Upload all scanned copies of student records for Batch 2021 to the university\'s central document archive. Make sure each file is named correctly (e.g., Lastname_Firstname_StudentID.pdf) and organized by course and year. Confirm successful upload by replying in the task comments.', '2025-04-19', 1, 1, '2025-04-08 05:23:56', '2025-04-08 05:23:56'),
(12, 'MEMO', 'TEST', '2025-04-09', 1, 1, '2025-04-08 06:37:14', '2025-04-08 06:37:14'),
(13, 'TEST', 'jksbdujikbd', '2025-04-09', 1, 1, '2025-04-08 07:24:03', '2025-04-08 07:24:03'),
(26, 'last TEST', 'test', '2025-04-10', 2, 3, '2025-04-08 14:54:04', '2025-04-08 14:54:04'),
(27, 'test', 'pogiii', '2025-04-10', 2, 1, '2025-04-08 15:34:08', '2025-04-08 15:34:08'),
(29, 'Test', 'Test', '2025-04-10', 2, 2, '2025-04-08 18:19:56', '2025-04-08 18:19:56'),
(30, 'TEST TASK', 'Description', '2025-04-10', 6, 1, '2025-04-08 19:24:16', '2025-04-08 19:24:16'),
(31, 'Submit Monthly Sales Report', 'Compile sales data from all departments and submit the final report.', '2025-04-10', 6, 2, '2025-04-08 19:47:47', '2025-04-08 19:47:47'),
(32, 'memo', 'test', '2025-04-10', 6, 3, '2025-04-08 20:08:25', '2025-04-08 20:08:25'),
(33, 'memo', 'test', '2025-04-14', 6, 1, '2025-04-08 20:08:59', '2025-04-08 20:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `task_audit_logs`
--

CREATE TABLE `task_audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `old_data` text DEFAULT NULL,
  `new_data` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE `task_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_user`
--

CREATE TABLE `task_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_user`
--

INSERT INTO `task_user` (`id`, `task_id`, `user_id`, `status_id`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 4, '2025-04-08 05:03:04', '2025-04-08 16:54:25'),
(4, 2, 3, 4, '2025-04-08 05:03:04', '2025-04-08 16:54:29'),
(5, 3, 2, 2, '2025-04-08 05:19:05', '2025-04-08 17:14:17'),
(54, 29, 1, 2, '2025-04-08 18:19:56', '2025-04-08 18:29:22'),
(55, 29, 3, 1, '2025-04-08 18:19:56', '2025-04-08 18:19:56'),
(56, 29, 4, 2, '2025-04-08 18:19:56', '2025-04-08 18:29:25'),
(57, 30, 7, 4, '2025-04-08 19:24:16', '2025-04-08 20:12:07'),
(58, 31, 7, 4, '2025-04-08 19:47:47', '2025-04-08 19:49:55'),
(59, 32, 8, 1, '2025-04-08 20:08:25', '2025-04-08 20:08:25'),
(60, 33, 8, 1, '2025-04-08 20:08:59', '2025-04-08 20:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verification_token` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'profile/avatar/profile.png',
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verification_token`, `password`, `username`, `phone`, `avatar`, `role_id`, `department_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', NULL, '$2y$12$ZhtEVL4IX84HvCuafeGWA.Oao3ufWgCRacsmAZnBSTqErhH3NkspG', 'admin', '1234567890', 'storage/profile/avatars/EnNpO52T3q5G1B2ClQMpN79Df56HyqLIVG93zy2t.jpg', 1, 1, NULL, '2025-04-08 03:35:24', '2025-04-08 05:04:12'),
(2, 'Jommel Incipido', 'klipzer02@gmail.com', NULL, '$2y$12$/zWNGv67oZA5OJyeSe.9M.lYYtZKqNOeNwgN.vhX.nUddywDeRe/.', 'klipzer', '0919273123', 'storage/profile/avatars/profile.png', 2, 1, NULL, '2025-04-08 03:47:56', '2025-04-08 09:20:18'),
(3, 'Joshua Daroya', 'daroya@gmail.com', NULL, '$2y$12$CfhgFN7yPHnKhzusXYGkxeLS.qJY/cPDdYRfoVbNR8tZm.WZL6NIy', 'daroya18', '0919273123', 'storage/profile/avatars/uT8tRAxRizOAWsbvVAnmKCJNFNXGGXjZjVfZsFqf.jpg', 3, 1, NULL, '2025-04-08 03:48:47', '2025-04-08 19:31:57'),
(4, 'Jommel Incipido pogs', 'klipzer02@gmail.coms', NULL, '$2y$12$G9I99lyAsAgiztv0E3z0wujywKzdUfewW5rhW6LtvWGB/4pBkd.Ee', 'sads', '112312321', 'storage/profile/avatars/profile.png', 3, 1, NULL, '2025-04-08 06:22:33', '2025-04-08 17:31:26'),
(5, 'test', 'test@test.test', NULL, '$2y$12$qNBw5RY9fGAdYTn0pSJ7i.Fnun2xnsXEL21MZ2X/juoFV/Wtt1.dK', 'tseet', '1536567', 'storage/profile/avatars/profile.png', 3, 3, NULL, '2025-04-08 06:38:19', '2025-04-08 09:20:31'),
(6, 'Elisha Fernandez', 'elish@gmail.com', NULL, '$2y$12$AmLaaEaWaG5YftMIZup6Bu4AxUuyYYcK5k3A7bZ9fNBPvlRD3JGJe', 'elish123', '13', 'storage/profile/avatars/profile.png', 2, 2, NULL, '2025-04-08 19:09:23', '2025-04-08 19:10:26'),
(7, 'Paul Gino-Gino', 'paul13@gmail.com', NULL, '$2y$12$SGq9ZChgiH6fKkkfzxIYN.hh.jJmnETMFQBJExNfjKU8m23fRA4ny', 'paul123', '0919273123', 'storage/profile/avatars/profile.png', 3, 2, NULL, '2025-04-08 19:10:12', '2025-04-08 19:10:12'),
(8, 'elisha', 'jusmine2121@gmail.com', NULL, '$2y$12$JvjkP08LzuHeEbqW7rRqcOc2KbgX6uiIhxVXMr2zJNBXAC0csbraq', 'elish', '8715873t1', 'storage/profile/avatars/profile.png', 3, 2, NULL, '2025-04-08 20:07:46', '2025-04-08 20:07:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_task_id_foreign` (`task_id`),
  ADD KEY `attachments_uploaded_by_foreign` (`uploaded_by`);

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
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_created_by_foreign` (`created_by`),
  ADD KEY `tasks_priority_id_foreign` (`priority_id`);

--
-- Indexes for table `task_audit_logs`
--
ALTER TABLE `task_audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_audit_logs_task_id_foreign` (`task_id`),
  ADD KEY `task_audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_comments_task_id_foreign` (`task_id`),
  ADD KEY `task_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `task_user`
--
ALTER TABLE `task_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_user_task_id_foreign` (`task_id`),
  ADD KEY `task_user_user_id_foreign` (`user_id`),
  ADD KEY `task_user_status_id_foreign` (`status_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_department_id_foreign` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `task_audit_logs`
--
ALTER TABLE `task_audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `task_user`
--
ALTER TABLE `task_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attachments_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_priority_id_foreign` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`);

--
-- Constraints for table `task_audit_logs`
--
ALTER TABLE `task_audit_logs`
  ADD CONSTRAINT `task_audit_logs_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  ADD CONSTRAINT `task_audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD CONSTRAINT `task_comments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_user`
--
ALTER TABLE `task_user`
  ADD CONSTRAINT `task_user_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `task_user_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
