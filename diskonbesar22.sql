-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 11, 2025 at 10:40 AM
-- Server version: 12.0.2-MariaDB-ubu2404
-- PHP Version: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diskonbesar22`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `batch_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(509, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:40:47', '2024-12-13 04:40:47'),
(510, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, '20dfb94b-acf8-49e0-b029-6d637951ff1e', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"20dfb94b-acf8-49e0-b029-6d637951ff1e\",\"code\":\"flt\",\"nama\":\"Fleet\",\"created_at\":\"2024-11-18T12:07:11.000000Z\",\"updated_at\":\"2024-11-18T12:07:11.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(511, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, '4e5e4831-6e2a-43ca-9bcd-0381999d7c59', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"4e5e4831-6e2a-43ca-9bcd-0381999d7c59\",\"code\":\"svc\",\"nama\":\"Service\",\"created_at\":\"2024-11-18T12:08:16.000000Z\",\"updated_at\":\"2024-11-18T12:08:16.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(512, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, '6235a3a9-6c92-4d8a-8310-2f5eccb6a29e', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"6235a3a9-6c92-4d8a-8310-2f5eccb6a29e\",\"code\":\"fin\",\"nama\":\"Finance\",\"created_at\":\"2024-11-18T12:06:57.000000Z\",\"updated_at\":\"2024-11-18T12:06:57.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(513, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, '7be2893d-8070-4a06-bccf-70e122362911', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"7be2893d-8070-4a06-bccf-70e122362911\",\"code\":\"spr\",\"nama\":\"Sparepart\",\"created_at\":\"2024-11-18T12:08:25.000000Z\",\"updated_at\":\"2024-11-18T12:08:25.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(514, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, 'a5de642f-1212-4a4a-838a-b34f9560edfd', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"a5de642f-1212-4a4a-838a-b34f9560edfd\",\"code\":\"lsg\",\"nama\":\"Leasing\",\"created_at\":\"2024-11-18T12:07:21.000000Z\",\"updated_at\":\"2024-11-18T12:07:21.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(515, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, 'a8300732-4409-4851-8980-6b4c5e878b19', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"a8300732-4409-4851-8980-6b4c5e878b19\",\"code\":\"dnd\",\"nama\":\"Dpack & NEQ\",\"created_at\":\"2024-11-18T12:07:58.000000Z\",\"updated_at\":\"2024-11-18T12:07:58.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(516, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, 'ae654d90-dfc5-4e72-a34c-051565642488', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"ae654d90-dfc5-4e72-a34c-051565642488\",\"code\":\"ops\",\"nama\":\"Operation\",\"created_at\":\"2024-11-18T12:07:50.000000Z\",\"updated_at\":\"2024-11-18T12:07:50.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(517, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, 'd66525a1-a673-4edb-9680-94a0998e6bcc', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"d66525a1-a673-4edb-9680-94a0998e6bcc\",\"code\":\"mkt\",\"nama\":\"Marketing\",\"created_at\":\"2024-11-18T12:07:31.000000Z\",\"updated_at\":\"2024-11-18T12:07:31.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(518, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, 'd9972da9-976c-49e6-840a-0946aacce60c', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"d9972da9-976c-49e6-840a-0946aacce60c\",\"code\":\"prm\",\"nama\":\"Promosi\",\"created_at\":\"2024-11-18T12:08:06.000000Z\",\"updated_at\":\"2024-11-18T12:08:06.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(519, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, 'f559639f-f5b5-4850-ae80-14726f7996a6', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"f559639f-f5b5-4850-ae80-14726f7996a6\",\"code\":\"ops\",\"nama\":\"Operation\",\"created_at\":\"2024-11-18T12:07:40.000000Z\",\"updated_at\":\"2024-11-18T12:07:40.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:44', '2024-12-13 04:51:44'),
(520, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, '2d97380c-03ae-4df6-9d6a-8a62c9c8c60b', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"2d97380c-03ae-4df6-9d6a-8a62c9c8c60b\",\"code\":\"edu\",\"nama\":\"Education\",\"created_at\":\"2024-11-18T12:06:46.000000Z\",\"updated_at\":\"2024-11-18T12:06:46.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:50', '2024-12-13 04:51:50'),
(521, 'mass remove divisi', 'Menghapus data divisi ', 'App\\Models\\Divisi', NULL, 'd3e4451a-cd95-44e7-b68f-05aeb7d31915', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"d3e4451a-cd95-44e7-b68f-05aeb7d31915\",\"code\":\"crm\",\"nama\":\"CRM\",\"created_at\":\"2024-11-18T12:06:32.000000Z\",\"updated_at\":\"2024-11-18T12:06:32.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 04:51:50', '2024-12-13 04:51:50'),
(522, 'profile', 'Mengubah Data Profile Akun', 'App\\Models\\User', NULL, '6a57a643-965c-4834-9869-df9dae41edc6', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"6a57a643-965c-4834-9869-df9dae41edc6\",\"old_id\":0,\"name\":\"Rizky Pratama\",\"email\":\"admin@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2024-10-17T19:14:42.000000Z\",\"updated_at\":\"2024-12-13T05:06:01.000000Z\",\"last_login_at\":\"2024-12-13T04:40:47.000000Z\",\"last_login_ip\":\"::1\",\"avatar\":\"20241023174705dd68d663d3d7224c1e758c67d694e8f9.jpg\",\"deleted_at\":null},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 05:06:02', '2024-12-13 05:06:02'),
(523, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 07:14:58', '2024-12-13 07:14:58'),
(524, 'tambah divisi', 'Membuat Data divisi dfdsfdsf', 'App\\Models\\Divisi', NULL, 'be1eb58d-d823-427d-8965-26d57512d3ee', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"be1eb58d-d823-427d-8965-26d57512d3ee\",\"nama\":\"dfdsfdsf\",\"updated_at\":\"2024-12-13T08:18:12.000000Z\",\"created_at\":\"2024-12-13T08:18:12.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 08:18:13', '2024-12-13 08:18:13'),
(525, 'edit divisi', 'Mengubah data divisi Admin Gudang', 'App\\Models\\Divisi', NULL, 'be1eb58d-d823-427d-8965-26d57512d3ee', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"be1eb58d-d823-427d-8965-26d57512d3ee\",\"nama\":\"Admin Gudang\",\"created_at\":\"2024-12-13T08:18:12.000000Z\",\"updated_at\":\"2024-12-13T08:18:25.000000Z\"},\"old\":{\"id\":\"be1eb58d-d823-427d-8965-26d57512d3ee\",\"nama\":\"dfdsfdsf\",\"created_at\":\"2024-12-13T08:18:12.000000Z\",\"updated_at\":\"2024-12-13T08:18:12.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 08:18:25', '2024-12-13 08:18:25'),
(526, 'edit divisi', 'Mengubah data divisi Petugas Cek Kondisi Barang Gudang', 'App\\Models\\Divisi', NULL, 'b71bbf26-b91e-11ef-9bf8-000377d1942e', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"b71bbf26-b91e-11ef-9bf8-000377d1942e\",\"nama\":\"Petugas Cek Kondisi Barang Gudang\",\"created_at\":null,\"updated_at\":\"2024-12-13T08:18:55.000000Z\"},\"old\":{\"id\":\"b71bbf26-b91e-11ef-9bf8-000377d1942e\",\"nama\":\"dfsdfd\",\"created_at\":null,\"updated_at\":null},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 08:18:56', '2024-12-13 08:18:56'),
(527, 'tambah user', 'Membuat akun user atas nama asdasdsadsd', 'App\\Models\\User', NULL, 'eb645a48-80cd-4b4a-8f7c-c8ce237c4895', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"avatar\":\"20241213151943avatar.png\",\"id\":\"eb645a48-80cd-4b4a-8f7c-c8ce237c4895\",\"name\":\"asdasdsadsd\",\"email\":\"petugas@gmail.com\",\"updated_at\":\"2024-12-13T08:19:43.000000Z\",\"created_at\":\"2024-12-13T08:19:43.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 08:19:43', '2024-12-13 08:19:43'),
(528, 'edit user', 'Mengubah akun user atas nama lomlom', 'App\\Models\\User', NULL, 'eb645a48-80cd-4b4a-8f7c-c8ce237c4895', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"eb645a48-80cd-4b4a-8f7c-c8ce237c4895\",\"old_id\":null,\"name\":\"lomlom\",\"email\":\"petugas@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2024-12-13T08:19:43.000000Z\",\"updated_at\":\"2024-12-13T08:19:59.000000Z\",\"last_login_at\":null,\"last_login_ip\":null,\"avatar\":\"20241213151943avatar.png\",\"deleted_at\":null},\"old\":{\"id\":\"eb645a48-80cd-4b4a-8f7c-c8ce237c4895\",\"old_id\":null,\"name\":\"asdasdsadsd\",\"email\":\"petugas@gmail.com\",\"email_verified_at\":null,\"password\":\"$2y$12$e4.1K3H0EPz6PLdXAQiEcOTlVwqnoNAk80UiwNzmJnQ9rJ2vm1YrC\",\"remember_token\":null,\"created_at\":\"2024-12-13T08:19:43.000000Z\",\"updated_at\":\"2024-12-13T08:19:43.000000Z\",\"last_login_at\":null,\"last_login_ip\":null,\"avatar\":\"20241213151943avatar.png\",\"deleted_at\":null},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 08:19:59', '2024-12-13 08:19:59'),
(529, 'hapus user', 'Menghapus akun user atas nama lomlom', 'App\\Models\\User', NULL, 'eb645a48-80cd-4b4a-8f7c-c8ce237c4895', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"eb645a48-80cd-4b4a-8f7c-c8ce237c4895\",\"old_id\":null,\"name\":\"lomlom\",\"email\":\"petugas@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2024-12-13T08:19:43.000000Z\",\"updated_at\":\"2024-12-13T08:20:14.000000Z\",\"last_login_at\":null,\"last_login_ip\":null,\"avatar\":\"20241213151943avatar.png\",\"deleted_at\":\"2024-12-13T08:20:14.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2024-12-13 08:20:14', '2024-12-13 08:20:14'),
(530, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-08 07:06:31', '2025-04-08 07:06:31'),
(531, 'tambah divisi', 'Membuat Data divisi Maintenance', 'App\\Models\\Divisi', NULL, '3611030b-1214-45a2-81fa-cbaaab8e9a3d', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"3611030b-1214-45a2-81fa-cbaaab8e9a3d\",\"nama\":\"Maintenance\",\"updated_at\":\"2025-04-08T07:27:25.000000Z\",\"created_at\":\"2025-04-08T07:27:25.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-08 07:27:25', '2025-04-08 07:27:25'),
(532, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-09 03:36:18', '2025-04-09 03:36:18'),
(533, 'edit role', 'Mengubah role Admin', 'Spatie\\Permission\\Models\\Role', NULL, '3', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-17T19:14:42.000000Z\",\"updated_at\":\"2024-10-17T19:14:42.000000Z\"},\"old\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-17T19:14:42.000000Z\",\"updated_at\":\"2024-10-17T19:14:42.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-09 03:38:17', '2025-04-09 03:38:17'),
(534, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 02:14:03', '2025-04-21 02:14:03'),
(535, 'tambah divisi', 'Membuat Data divisi dcsdcds', 'App\\Models\\Divisi', NULL, 'fdab3b6f-ab99-4315-8254-e1f5ff803943', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"fdab3b6f-ab99-4315-8254-e1f5ff803943\",\"nama\":\"dcsdcds\",\"updated_at\":\"2025-04-21T02:15:29.000000Z\",\"created_at\":\"2025-04-21T02:15:29.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 02:15:29', '2025-04-21 02:15:29'),
(536, 'edit divisi', 'Mengubah data divisi 123', 'App\\Models\\Divisi', NULL, 'fdab3b6f-ab99-4315-8254-e1f5ff803943', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"fdab3b6f-ab99-4315-8254-e1f5ff803943\",\"nama\":\"123\",\"created_at\":\"2025-04-21T02:15:29.000000Z\",\"updated_at\":\"2025-04-21T02:15:39.000000Z\"},\"old\":{\"id\":\"fdab3b6f-ab99-4315-8254-e1f5ff803943\",\"nama\":\"dcsdcds\",\"created_at\":\"2025-04-21T02:15:29.000000Z\",\"updated_at\":\"2025-04-21T02:15:29.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 02:15:39', '2025-04-21 02:15:39'),
(537, 'hapus divisi', 'Menghapus data divisi 123', 'App\\Models\\Divisi', NULL, 'fdab3b6f-ab99-4315-8254-e1f5ff803943', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"fdab3b6f-ab99-4315-8254-e1f5ff803943\",\"nama\":\"123\",\"created_at\":\"2025-04-21T02:15:29.000000Z\",\"updated_at\":\"2025-04-21T02:15:39.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 02:15:46', '2025-04-21 02:15:46'),
(538, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 03:35:29', '2025-04-21 03:35:29'),
(539, 'tambah divisi', 'Membuat Data divisi ghjghj', 'App\\Models\\Divisi', NULL, '8ddd282e-95d6-4867-95ba-e597fc42d456', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"8ddd282e-95d6-4867-95ba-e597fc42d456\",\"nama\":\"ghjghj\",\"updated_at\":\"2025-04-21T03:35:59.000000Z\",\"created_at\":\"2025-04-21T03:35:59.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 03:35:59', '2025-04-21 03:35:59'),
(540, 'edit user', 'Mengubah akun user atas nama tes', 'App\\Models\\User', NULL, 'b71fd23a-ddf5-4187-8f87-079931cc476e', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"b71fd23a-ddf5-4187-8f87-079931cc476e\",\"name\":\"tes\",\"email\":\"tes@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2024-11-18T12:27:21.000000Z\",\"updated_at\":\"2025-04-21T04:00:05.000000Z\",\"last_login_at\":null,\"last_login_ip\":null,\"avatar\":\"20250421110005avatar.png\"},\"old\":{\"id\":\"b71fd23a-ddf5-4187-8f87-079931cc476e\",\"name\":\"tes\",\"email\":\"tes@gmail.com\",\"email_verified_at\":null,\"password\":\"$2y$12$xZh2heXrjl7iuky24tPZx.K9aKdV3D46XCQZjIhLeapZ6Vc3pTmFW\",\"remember_token\":null,\"created_at\":\"2024-11-18T12:27:21.000000Z\",\"updated_at\":\"2024-11-18T13:49:22.000000Z\",\"last_login_at\":null,\"last_login_ip\":null,\"avatar\":\"202411181927207644a32940e09177fd717d8196800063.jpg\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 04:00:05', '2025-04-21 04:00:05'),
(541, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 04:10:38', '2025-04-21 04:10:38'),
(542, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'c55ee693-1755-406e-8a49-98c060eebdd4', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:11:19', '2025-04-21 05:11:19'),
(543, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'c55ee693-1755-406e-8a49-98c060eebdd4', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:11:26', '2025-04-21 05:11:26'),
(544, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'c55ee693-1755-406e-8a49-98c060eebdd4', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:11:39', '2025-04-21 05:11:39'),
(545, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'c42940fc-9e6b-4d85-9175-297cc117b1ab', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:13:22', '2025-04-21 05:13:22'),
(546, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'c42940fc-9e6b-4d85-9175-297cc117b1ab', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:13:59', '2025-04-21 05:13:59'),
(547, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'c42940fc-9e6b-4d85-9175-297cc117b1ab', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:14:08', '2025-04-21 05:14:08'),
(548, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'c42940fc-9e6b-4d85-9175-297cc117b1ab', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:18:11', '2025-04-21 05:18:11'),
(549, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'c42940fc-9e6b-4d85-9175-297cc117b1ab', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:22:19', '2025-04-21 05:22:19'),
(550, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '911c8b99-6bb7-4781-a9d8-207ec09523a6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:30:30', '2025-04-21 05:30:30'),
(551, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '911c8b99-6bb7-4781-a9d8-207ec09523a6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:30:37', '2025-04-21 05:30:37'),
(552, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'c64f0c31-de34-475a-b80f-b428e6caae3a', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:37:12', '2025-04-21 05:37:12'),
(553, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '5104332b-9064-4bc5-9f80-05ffeec3845a', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:45:13', '2025-04-21 05:45:13'),
(554, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '5104332b-9064-4bc5-9f80-05ffeec3845a', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:52:28', '2025-04-21 05:52:28'),
(555, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:52:43', '2025-04-21 05:52:43'),
(556, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:52:54', '2025-04-21 05:52:54'),
(557, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', 'b71fd23a-ddf5-4187-8f87-079931cc476e', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:53:06', '2025-04-21 05:53:06'),
(558, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', 'b71fd23a-ddf5-4187-8f87-079931cc476e', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:54:43', '2025-04-21 05:54:43'),
(559, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '5104332b-9064-4bc5-9f80-05ffeec3845a', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:54:57', '2025-04-21 05:54:57'),
(560, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '5104332b-9064-4bc5-9f80-05ffeec3845a', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:58:48', '2025-04-21 05:58:48'),
(561, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 05:58:54', '2025-04-21 05:58:54'),
(562, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 06:06:06', '2025-04-21 06:06:06'),
(563, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '5104332b-9064-4bc5-9f80-05ffeec3845a', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 06:06:11', '2025-04-21 06:06:11'),
(564, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '5104332b-9064-4bc5-9f80-05ffeec3845a', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-04-21 06:07:50', '2025-04-21 06:07:50'),
(565, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-23 03:04:05', '2025-05-23 03:04:05'),
(566, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 16:40:03', '2025-05-30 16:40:03'),
(567, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 16:40:45', '2025-05-30 16:40:45'),
(568, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 16:44:24', '2025-05-30 16:44:24'),
(569, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 16:52:03', '2025-05-30 16:52:03'),
(570, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 17:01:31', '2025-05-30 17:01:31'),
(571, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 17:34:18', '2025-05-30 17:34:18'),
(572, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 18:21:36', '2025-05-30 18:21:36'),
(573, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 18:25:11', '2025-05-30 18:25:11'),
(574, 'logout', ' berhasil Logout', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 18:34:09', '2025-05-30 18:34:09'),
(575, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 18:43:36', '2025-05-30 18:43:36'),
(576, 'hapus user', 'Menghapus akun user atas nama disperindag deliserdang', 'App\\Models\\User', NULL, '5104332b-9064-4bc5-9f80-05ffeec3845a', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"5104332b-9064-4bc5-9f80-05ffeec3845a\",\"name\":\"disperindag deliserdang\",\"email\":\"disperindagdeliserdang.id@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2025-04-21T05:45:13.000000Z\",\"updated_at\":\"2025-04-21T06:06:11.000000Z\",\"last_login_at\":\"2025-04-21T06:06:11.000000Z\",\"last_login_ip\":\"127.0.0.1\",\"avatar\":\"https:\\/\\/lh3.googleusercontent.com\\/a\\/ACg8ocIcnhNktZ5Xc6eLawD56DokyDAUCFvS0oRY1dwQpSlsSzXE0Q=s96-c\",\"provider\":\"google\",\"google_id\":\"116605270633295610717\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 18:53:18', '2025-05-30 18:53:18'),
(577, 'hapus user', 'Menghapus akun user atas nama tes', 'App\\Models\\User', NULL, '2f6cb98a-3554-4f63-8ea5-a3056c305e52', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"2f6cb98a-3554-4f63-8ea5-a3056c305e52\",\"name\":\"tes\",\"email\":\"tesi@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2024-11-18T13:50:07.000000Z\",\"updated_at\":\"2024-11-18T13:50:07.000000Z\",\"last_login_at\":null,\"last_login_ip\":null,\"avatar\":\"202411182050077644a32940e09177fd717d8196800063.jpg\",\"provider\":null,\"google_id\":null},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 19:29:54', '2025-05-30 19:29:54'),
(578, 'edit user', 'Mengubah akun user atas nama tes', 'App\\Models\\User', NULL, 'b71fd23a-ddf5-4187-8f87-079931cc476e', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"b71fd23a-ddf5-4187-8f87-079931cc476e\",\"name\":\"tes\",\"email\":\"tes@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2024-11-18T12:27:21.000000Z\",\"updated_at\":\"2025-04-21T05:53:06.000000Z\",\"last_login_at\":\"2025-04-21T05:53:06.000000Z\",\"last_login_ip\":\"127.0.0.1\",\"avatar\":null,\"provider\":null,\"google_id\":null},\"old\":{\"id\":\"b71fd23a-ddf5-4187-8f87-079931cc476e\",\"name\":\"tes\",\"email\":\"tes@gmail.com\",\"email_verified_at\":null,\"password\":\"$2y$12$xZh2heXrjl7iuky24tPZx.K9aKdV3D46XCQZjIhLeapZ6Vc3pTmFW\",\"remember_token\":null,\"created_at\":\"2024-11-18T12:27:21.000000Z\",\"updated_at\":\"2025-04-21T05:53:06.000000Z\",\"last_login_at\":\"2025-04-21T05:53:06.000000Z\",\"last_login_ip\":\"127.0.0.1\",\"avatar\":null,\"provider\":null,\"google_id\":null},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-30 19:46:49', '2025-05-30 19:46:49'),
(579, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-31 07:21:32', '2025-05-31 07:21:32'),
(580, 'edit role', 'Mengubah role Admin', 'Spatie\\Permission\\Models\\Role', NULL, '3', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-17T19:14:42.000000Z\",\"updated_at\":\"2024-10-17T19:14:42.000000Z\"},\"old\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-17T19:14:42.000000Z\",\"updated_at\":\"2024-10-17T19:14:42.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-31 10:05:26', '2025-05-31 10:05:26'),
(581, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-05-31 18:51:56', '2025-05-31 18:51:56'),
(582, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-06-02 04:38:17', '2025-06-02 04:38:17'),
(583, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-07-18 06:11:58', '2025-07-18 06:11:58'),
(584, 'tambah coba1', 'Membuat data coba1 fgdfgfdg', 'App\\Models\\Coba1', NULL, 'fe8a276e-af37-4f7c-b4c3-e071a00776f3', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"fe8a276e-af37-4f7c-b4c3-e071a00776f3\",\"nama\":\"fgdfgfdg\",\"updated_at\":\"2025-07-18T06:14:25.000000Z\",\"created_at\":\"2025-07-18T06:14:25.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-07-18 06:14:25', '2025-07-18 06:14:25'),
(585, 'edit role', 'Mengubah role Admin', 'Spatie\\Permission\\Models\\Role', NULL, '3', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-17T19:14:42.000000Z\",\"updated_at\":\"2024-10-17T19:14:42.000000Z\"},\"old\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-17T19:14:42.000000Z\",\"updated_at\":\"2024-10-17T19:14:42.000000Z\"},\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-07-18 06:15:12', '2025-07-18 06:15:12'),
(586, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-08-26 06:36:56', '2025-08-26 06:36:56'),
(587, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-08-26 06:37:37', '2025-08-26 06:37:37'),
(588, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-08-28 07:35:44', '2025-08-28 07:35:44'),
(589, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-08-28 07:35:44', '2025-08-28 07:35:44'),
(590, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-09-02 04:22:42', '2025-09-02 04:22:42'),
(591, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-09-02 07:39:32', '2025-09-02 07:39:32'),
(592, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-09-11 03:12:33', '2025-09-11 03:12:33'),
(593, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-09-11 03:17:23', '2025-09-11 03:17:23'),
(594, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-09-11 10:25:25', '2025-09-11 10:25:25'),
(595, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-09-12 02:27:23', '2025-09-12 02:27:23'),
(596, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-09-12 02:34:24', '2025-09-12 02:34:24'),
(597, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"::1\",\"browser\":\"Chrome\",\"os\":\"Windows\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-09-14 18:42:47', '2025-09-14 18:42:47'),
(598, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 02:19:00', '2025-10-10 02:19:00'),
(599, 'tambah user', 'Membuat akun user atas nama tes', 'App\\Models\\User', NULL, 'b31ec1ca-c1ff-4fac-b0b4-264a32bc26c8', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"avatar\":\"20251010094541apple-touch-icon.png\",\"id\":\"b31ec1ca-c1ff-4fac-b0b4-264a32bc26c8\",\"name\":\"tes\",\"email\":\"admidsfdsfn@gmail.com\",\"updated_at\":\"2025-10-10T09:45:42.000000Z\",\"created_at\":\"2025-10-10T09:45:42.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 02:45:42', '2025-10-10 02:45:42'),
(600, 'profile', 'Mengubah Data Profile Akun', 'App\\Models\\User', NULL, '6a57a643-965c-4834-9869-df9dae41edc6', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"6a57a643-965c-4834-9869-df9dae41edc6\",\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2024-10-18T02:14:42.000000Z\",\"updated_at\":\"2025-10-10T10:05:31.000000Z\",\"last_login_at\":\"2025-10-10T09:19:00.000000Z\",\"last_login_ip\":\"127.0.0.1\",\"avatar\":\"20241023174705dd68d663d3d7224c1e758c67d694e8f9.jpg\",\"provider\":null,\"google_id\":null},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 03:05:31', '2025-10-10 03:05:31'),
(601, 'hapus user', 'Menghapus akun user atas nama tes', 'App\\Models\\User', NULL, 'b31ec1ca-c1ff-4fac-b0b4-264a32bc26c8', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"b31ec1ca-c1ff-4fac-b0b4-264a32bc26c8\",\"name\":\"tes\",\"email\":\"admidsfdsfn@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2025-10-10T09:45:42.000000Z\",\"updated_at\":\"2025-10-10T09:45:42.000000Z\",\"last_login_at\":null,\"last_login_ip\":null,\"avatar\":\"20251010094541apple-touch-icon.png\",\"provider\":null,\"google_id\":null},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 03:08:06', '2025-10-10 03:08:06'),
(602, 'hapus user', 'Menghapus akun user atas nama tes', 'App\\Models\\User', NULL, 'b71fd23a-ddf5-4187-8f87-079931cc476e', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"b71fd23a-ddf5-4187-8f87-079931cc476e\",\"name\":\"tes\",\"email\":\"tes@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2024-11-18T19:27:21.000000Z\",\"updated_at\":\"2025-04-21T12:53:06.000000Z\",\"last_login_at\":\"2025-04-21T12:53:06.000000Z\",\"last_login_ip\":\"127.0.0.1\",\"avatar\":null,\"provider\":null,\"google_id\":null},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 03:08:12', '2025-10-10 03:08:12'),
(603, 'hapus role', 'Menghapus role User', 'Spatie\\Permission\\Models\\Role', NULL, '12', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":12,\"name\":\"User\",\"guard_name\":\"web\",\"created_at\":\"2024-11-26T15:25:37.000000Z\",\"updated_at\":\"2024-11-26T15:25:37.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 03:08:23', '2025-10-10 03:08:23'),
(604, 'edit changelog', 'Mengubah changelog dengan nama v1.2.0', 'App\\Models\\Changelog', NULL, 'd98808d5-3ce5-42ec-86c9-19368b893363', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"d98808d5-3ce5-42ec-86c9-19368b893363\",\"nama\":\"v1.2.0\",\"deskripsi\":\"simply dummy text of the printing and typesetting industry.\",\"logs\":\"{\\\"New\\\":[{\\\"nama\\\":\\\"12345678\\\",\\\"deskripsi\\\":\\\"aaaaaaaaa\\\"}],\\\"Update\\\":[{\\\"nama\\\":\\\"123\\\",\\\"deskripsi\\\":\\\"aaaaaaa\\\"}],\\\"Fix\\\":[{\\\"nama\\\":\\\"456\\\",\\\"deskripsi\\\":\\\"aaaaaaaaa\\\"}]}\",\"created_at\":\"2024-10-23T21:16:54.000000Z\",\"updated_at\":\"2025-10-10T10:08:42.000000Z\"},\"old\":{\"id\":\"d98808d5-3ce5-42ec-86c9-19368b893363\",\"nama\":\"Tumek v1.2.0\",\"deskripsi\":\"simply dummy text of the printing and typesetting industry.\",\"logs\":\"{\\\"New\\\":[{\\\"nama\\\":\\\"12345678\\\",\\\"deskripsi\\\":\\\"aaaaaaaaa\\\"}],\\\"Update\\\":[{\\\"nama\\\":\\\"123\\\",\\\"deskripsi\\\":\\\"aaaaaaa\\\"}],\\\"Fix\\\":[{\\\"nama\\\":\\\"456\\\",\\\"deskripsi\\\":\\\"aaaaaaaaa\\\"}]}\",\"created_at\":\"2024-10-23T21:16:54.000000Z\",\"updated_at\":\"2024-10-23T22:55:39.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 03:08:42', '2025-10-10 03:08:42'),
(605, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 21:01:47', '2025-10-10 21:01:47'),
(606, 'edit role', 'Mengubah role Admin', 'Spatie\\Permission\\Models\\Role', NULL, '3', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-18T02:14:42.000000Z\",\"updated_at\":\"2024-10-18T02:14:42.000000Z\"},\"old\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-18T02:14:42.000000Z\",\"updated_at\":\"2024-10-18T02:14:42.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 22:24:26', '2025-10-10 22:24:26'),
(607, 'tambah supplier', 'Menambahkan Supplier: gfbgfb', 'App\\Models\\Supplier', NULL, '0199d1df-6c6b-7358-b61b-9fb796b73555', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"gfbgfb\",\"no_telp\":\"gbg\",\"alamat\":\"bgbgf\",\"keterangan\":\"bgfbg\",\"id\":\"0199d1df-6c6b-7358-b61b-9fb796b73555\",\"updated_at\":\"2025-10-11T06:05:04.000000Z\",\"created_at\":\"2025-10-11T06:05:04.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 23:05:04', '2025-10-10 23:05:04'),
(608, 'hapus supplier', 'Menghapus Supplier: gfbgfb', 'App\\Models\\Supplier', NULL, '0199d1df-6c6b-7358-b61b-9fb796b73555', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"0199d1df-6c6b-7358-b61b-9fb796b73555\",\"nama\":\"gfbgfb\",\"no_telp\":\"gbg\",\"alamat\":\"bgbgf\",\"keterangan\":\"bgfbg\",\"created_at\":\"2025-10-11T06:05:04.000000Z\",\"updated_at\":\"2025-10-11T06:05:04.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 23:25:49', '2025-10-10 23:25:49'),
(609, 'tambah supplier', 'Menambahkan Supplier: sds', 'App\\Models\\Supplier', NULL, '0199d1f2-8dd5-70cf-bc1b-740dce0cfb88', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"sds\",\"no_telp\":\"sdds\",\"alamat\":\"sdsd\",\"keterangan\":\"sdsdds\",\"id\":\"0199d1f2-8dd5-70cf-bc1b-740dce0cfb88\",\"updated_at\":\"2025-10-11T06:25:58.000000Z\",\"created_at\":\"2025-10-11T06:25:58.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 23:25:58', '2025-10-10 23:25:58'),
(610, 'mass delete supplier', 'Menghapus Supplier: sds', 'App\\Models\\Supplier', NULL, '0199d1f2-8dd5-70cf-bc1b-740dce0cfb88', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"0199d1f2-8dd5-70cf-bc1b-740dce0cfb88\",\"nama\":\"sds\",\"no_telp\":\"sdds\",\"alamat\":\"sdsd\",\"keterangan\":\"sdsdds\",\"created_at\":\"2025-10-11T06:25:58.000000Z\",\"updated_at\":\"2025-10-11T06:25:58.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 23:26:46', '2025-10-10 23:26:46'),
(611, 'login', ' berhasil Login', NULL, NULL, NULL, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 23:58:02', '2025-10-10 23:58:02'),
(612, 'tambah supplier', 'Menambahkan Supplier: dscsdc', 'App\\Models\\Supplier', NULL, '0199d210-283e-7058-bc83-7df173c66b37', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"dscsdc\",\"no_telp\":\"dscds\",\"alamat\":\"cdsc\",\"keterangan\":\"dscdsc\",\"id\":\"0199d210-283e-7058-bc83-7df173c66b37\",\"updated_at\":\"2025-10-11T06:58:18.000000Z\",\"created_at\":\"2025-10-11T06:58:18.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-10 23:58:18', '2025-10-10 23:58:18'),
(613, 'tambah supplier', 'Menambahkan Supplier: gg', 'App\\Models\\Supplier', NULL, '0199d246-1d96-7210-8ab5-3116ead1921a', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"gg\",\"no_telp\":\"fggh\",\"alamat\":\"ghgh\",\"keterangan\":\"hghgf\",\"id\":\"0199d246-1d96-7210-8ab5-3116ead1921a\",\"updated_at\":\"2025-10-11T07:57:14.000000Z\",\"created_at\":\"2025-10-11T07:57:14.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 00:57:14', '2025-10-11 00:57:14'),
(614, 'edit role', 'Mengubah role Admin', 'Spatie\\Permission\\Models\\Role', NULL, '3', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-18T02:14:42.000000Z\",\"updated_at\":\"2024-10-18T02:14:42.000000Z\"},\"old\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-18T02:14:42.000000Z\",\"updated_at\":\"2024-10-18T02:14:42.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 01:11:01', '2025-10-11 01:11:01'),
(615, 'tambah brand', 'Menambahkan Brand: sdsdv', 'App\\Models\\Brand', NULL, '0199d257-3f15-72cd-9ed3-7a19790e1c41', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"sdsdv\",\"deskripsi\":null,\"id\":\"0199d257-3f15-72cd-9ed3-7a19790e1c41\",\"updated_at\":\"2025-10-11T08:15:57.000000Z\",\"created_at\":\"2025-10-11T08:15:57.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 01:15:57', '2025-10-11 01:15:57'),
(616, 'tambah brand', 'Menambahkan Brand: sdsdvdsfdf', 'App\\Models\\Brand', NULL, '0199d257-6610-7299-8aad-6de6aa3d805b', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"sdsdvdsfdf\",\"deskripsi\":null,\"id\":\"0199d257-6610-7299-8aad-6de6aa3d805b\",\"updated_at\":\"2025-10-11T08:16:07.000000Z\",\"created_at\":\"2025-10-11T08:16:07.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 01:16:07', '2025-10-11 01:16:07'),
(617, 'hapus brand', 'Menghapus Brand: sdsdvdsfdf', 'App\\Models\\Brand', NULL, '0199d257-6610-7299-8aad-6de6aa3d805b', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"0199d257-6610-7299-8aad-6de6aa3d805b\",\"nama\":\"sdsdvdsfdf\",\"deskripsi\":null,\"created_at\":\"2025-10-11T08:16:07.000000Z\",\"updated_at\":\"2025-10-11T08:16:07.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 01:16:11', '2025-10-11 01:16:11'),
(618, 'tambah brand', 'Menambahkan Brand: cbcbvb', 'App\\Models\\Brand', NULL, '0199d25b-0b23-71b8-aa45-94b923a41a5b', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"cbcbvb\",\"deskripsi\":null,\"id\":\"0199d25b-0b23-71b8-aa45-94b923a41a5b\",\"updated_at\":\"2025-10-11T08:20:06.000000Z\",\"created_at\":\"2025-10-11T08:20:06.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 01:20:06', '2025-10-11 01:20:06');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(619, 'tambah brand', 'Menambahkan Brand: fdgfgg', 'App\\Models\\Brand', NULL, '0199d25c-81d0-7173-8dda-dfab29539ca7', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"fdgfgg\",\"deskripsi\":\"dfgdfg\",\"id\":\"0199d25c-81d0-7173-8dda-dfab29539ca7\",\"updated_at\":\"2025-10-11T08:21:41.000000Z\",\"created_at\":\"2025-10-11T08:21:41.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 01:21:42', '2025-10-11 01:21:42'),
(620, 'edit brand', 'Mengubah data Brand: cbcbvb', 'App\\Models\\Brand', NULL, '0199d25b-0b23-71b8-aa45-94b923a41a5b', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"0199d25b-0b23-71b8-aa45-94b923a41a5b\",\"nama\":\"cbcbvb\",\"deskripsi\":\"fddfgdfg\",\"created_at\":\"2025-10-11T08:20:06.000000Z\",\"updated_at\":\"2025-10-11T08:24:27.000000Z\"},\"old\":{\"id\":\"0199d25b-0b23-71b8-aa45-94b923a41a5b\",\"nama\":\"cbcbvb\",\"deskripsi\":null,\"created_at\":\"2025-10-11T08:20:06.000000Z\",\"updated_at\":\"2025-10-11T08:20:06.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 01:24:27', '2025-10-11 01:24:27'),
(621, 'edit role', 'Mengubah role Admin', 'Spatie\\Permission\\Models\\Role', NULL, '3', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-18T02:14:42.000000Z\",\"updated_at\":\"2024-10-18T02:14:42.000000Z\"},\"old\":{\"id\":3,\"name\":\"Admin\",\"guard_name\":\"web\",\"created_at\":\"2024-10-18T02:14:42.000000Z\",\"updated_at\":\"2024-10-18T02:14:42.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 02:26:56', '2025-10-11 02:26:56'),
(622, 'tambah kategori', 'Menambahkan Kategori: esdrtfgjk', 'App\\Models\\Kategori', NULL, '0199d29f-eaaf-715e-a4d8-d122bdbf36db', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"esdrtfgjk\",\"keterangan\":\"wdfcgvhbjn\",\"id\":\"0199d29f-eaaf-715e-a4d8-d122bdbf36db\",\"updated_at\":\"2025-10-11T09:35:19.000000Z\",\"created_at\":\"2025-10-11T09:35:19.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 02:35:19', '2025-10-11 02:35:19'),
(623, 'tambah kategori', 'Menambahkan Kategori: esdrtfgjkcdffcd', 'App\\Models\\Kategori', NULL, '0199d2a0-0942-7098-90ae-7f24f72011d0', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"nama\":\"esdrtfgjkcdffcd\",\"keterangan\":\"wdfcgvhbjndcf\",\"id\":\"0199d2a0-0942-7098-90ae-7f24f72011d0\",\"updated_at\":\"2025-10-11T09:35:27.000000Z\",\"created_at\":\"2025-10-11T09:35:27.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 02:35:27', '2025-10-11 02:35:27'),
(624, 'edit kategori', 'Mengubah data Kategori: 123er', 'App\\Models\\Kategori', NULL, '0199d2a0-0942-7098-90ae-7f24f72011d0', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"0199d2a0-0942-7098-90ae-7f24f72011d0\",\"nama\":\"123er\",\"keterangan\":\"wdfcgvhbjndcf\",\"created_at\":\"2025-10-11T09:35:27.000000Z\",\"updated_at\":\"2025-10-11T09:35:39.000000Z\"},\"old\":{\"id\":\"0199d2a0-0942-7098-90ae-7f24f72011d0\",\"nama\":\"esdrtfgjkcdffcd\",\"keterangan\":\"wdfcgvhbjndcf\",\"created_at\":\"2025-10-11T09:35:27.000000Z\",\"updated_at\":\"2025-10-11T09:35:27.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 02:35:39', '2025-10-11 02:35:39'),
(625, 'hapus kategori', 'Menghapus Kategori: 123er', 'App\\Models\\Kategori', NULL, '0199d2a0-0942-7098-90ae-7f24f72011d0', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"0199d2a0-0942-7098-90ae-7f24f72011d0\",\"nama\":\"123er\",\"keterangan\":\"wdfcgvhbjndcf\",\"created_at\":\"2025-10-11T09:35:27.000000Z\",\"updated_at\":\"2025-10-11T09:35:39.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 02:35:47', '2025-10-11 02:35:47'),
(626, 'mass delete kategori', 'Menghapus Kategori: esdrtfgjk', 'App\\Models\\Kategori', NULL, '0199d29f-eaaf-715e-a4d8-d122bdbf36db', 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6', '{\"attributes\":{\"id\":\"0199d29f-eaaf-715e-a4d8-d122bdbf36db\",\"nama\":\"esdrtfgjk\",\"keterangan\":\"wdfcgvhbjn\",\"created_at\":\"2025-10-11T09:35:19.000000Z\",\"updated_at\":\"2025-10-11T09:35:19.000000Z\"},\"agent\":{\"ip\":\"127.0.0.1\",\"browser\":\"Chrome\",\"os\":\"Linux\",\"device\":\"Desktop\",\"robot\":false}}', NULL, '2025-10-11 02:35:53', '2025-10-11 02:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` char(36) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `kategori_id` char(36) NOT NULL,
  `brand_id` char(36) NOT NULL,
  `tipe_id` char(36) DEFAULT NULL,
  `satuan` varchar(50) NOT NULL DEFAULT 'pcs',
  `stok` int(11) NOT NULL DEFAULT 0,
  `harga_beli` decimal(15,2) NOT NULL DEFAULT 0.00,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` char(36) NOT NULL DEFAULT uuid(),
  `kode_transaksi` varchar(50) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `supplier_id` char(36) DEFAULT NULL,
  `user_id` char(36) NOT NULL,
  `total_item` int(11) NOT NULL DEFAULT 0,
  `total_harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk_detail`
--

CREATE TABLE `barang_masuk_detail` (
  `id` char(36) NOT NULL DEFAULT uuid(),
  `barang_masuk_id` char(36) NOT NULL,
  `barang_id` char(36) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `harga_beli` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` char(36) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
('0199d257-3f15-72cd-9ed3-7a19790e1c41', 'sdsdv', NULL, '2025-10-11 01:15:57', '2025-10-11 01:15:57'),
('0199d25b-0b23-71b8-aa45-94b923a41a5b', 'cbcbvb', 'fddfgdfg', '2025-10-11 01:20:06', '2025-10-11 01:24:27'),
('0199d25c-81d0-7173-8dda-dfab29539ca7', 'fdgfgg', 'dfgdfg', '2025-10-11 01:21:41', '2025-10-11 01:21:41');

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
-- Table structure for table `changelog`
--

CREATE TABLE `changelog` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `changelog`
--

INSERT INTO `changelog` (`id`, `nama`, `deskripsi`, `logs`, `created_at`, `updated_at`) VALUES
('d81c680e-3a9e-44ee-8484-478a52fde86d', 'Chimox v.1.0.0', 'Base App sebagai model utama sistem aplikasi', '\"{\\\"New\\\":null,\\\"Update\\\":null,\\\"Fix\\\":null}\"', '2024-01-23 08:21:50', '2024-10-23 03:31:28'),
('d98808d5-3ce5-42ec-86c9-19368b893363', 'v1.2.0', 'simply dummy text of the printing and typesetting industry.', '\"{\\\"New\\\":[{\\\"nama\\\":\\\"12345678\\\",\\\"deskripsi\\\":\\\"aaaaaaaaa\\\"}],\\\"Update\\\":[{\\\"nama\\\":\\\"123\\\",\\\"deskripsi\\\":\\\"aaaaaaa\\\"}],\\\"Fix\\\":[{\\\"nama\\\":\\\"456\\\",\\\"deskripsi\\\":\\\"aaaaaaaaa\\\"}]}\"', '2024-10-23 14:16:54', '2025-10-10 03:08:42');

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
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` char(36) NOT NULL DEFAULT uuid(),
  `nama` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_07_032631_create_permission_tables', 1),
(5, '2024_10_07_032650_create_products_table', 1),
(6, '2024_10_17_043855_add_login_fields_to_users_table', 2),
(7, '2024_10_17_162529_add_avatar_to_users_table', 3),
(8, '2024_10_18_152953_create_activity_log_table', 4),
(9, '2024_10_18_152954_add_event_column_to_activity_log_table', 4),
(10, '2024_10_18_152955_add_batch_uuid_column_to_activity_log_table', 4),
(11, '2024_10_26_195506_create_jabatans_table', 5),
(12, '2024_10_26_195601_create_divisis_table', 5),
(13, '2024_10_26_195631_create_karyawan_divisi_jabatan_table', 5),
(14, '2024_10_28_152541_create_emergency_contacts_table', 6),
(15, '2024_10_28_152553_create_bank_accounts_table', 6),
(16, '2024_11_18_112920_add_deleted_at_to_users_table', 7),
(17, '2025_04_21_112012_add_google_id_to_users_table', 8),
(18, '2025_04_21_123354_add_provider_to_users_table', 9),
(19, '2025_08_28_152253_create_personal_access_tokens_table', 10),
(20, '2025_08_28_152253_create_api_clients_table copy 2', 11),
(21, '2025_08_28_152253_create_user_admin_table', 11),
(22, '2025_08_28_152253_create_user_dev_table', 11),
(23, '2025_10_11_044604_create_suppliers_table', 12),
(24, '2025_10_11_044605_create_brands_table', 12),
(25, '2025_10_11_082730_create_kategori_table', 13),
(26, '2025_10_11_094412_create_tipe_table', 14),
(27, '2025_10_11_094652_create_barang_table', 14),
(28, '2025_10_11_095349_create_barang_masuk_table', 15),
(29, '2025_10_11_095350_create_barang_masuk_detail_table', 15),
(30, '2025_10_11_095712_create_penjualan_table', 15),
(31, '2025_10_11_095713_create_penjualan_detail_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', '0'),
(3, 'App\\Models\\User', '6a57a643-965c-4834-9869-df9dae41edc6'),
(3, 'App\\Models\\User', '8f7c25d8-a9e1-448a-b390-26aa97bb7f1a'),
(3, 'App\\Models\\User', '92db3e60-4c60-4a12-bc67-cbd9438f1e82'),
(3, 'App\\Models\\User', 'a898ec08-40d7-4ffd-ab55-93a35e85156f'),
(3, 'App\\Models\\User', 'aa87adbf-b29e-4a24-86e8-7600c4f5ce38'),
(3, 'App\\Models\\User', 'b89c60da-6a18-4627-9d20-62ac96d54ee0');

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
('admin@gmail.com', '$2y$12$53034F5ZZGPmoFu7LU1jouayXy2Vl0yNMSMi/8fgHIc83qPIn.Xdu', '2024-10-09 23:56:38');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` char(36) NOT NULL DEFAULT uuid(),
  `kode_transaksi` varchar(50) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `customer_nama` varchar(150) DEFAULT NULL,
  `user_id` char(36) NOT NULL,
  `total_item` int(11) NOT NULL DEFAULT 0,
  `total_harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id` char(36) NOT NULL DEFAULT uuid(),
  `penjualan_id` char(36) NOT NULL,
  `barang_id` char(36) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `category`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'role-list', 'Role Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(2, 'role-create', 'Role Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(3, 'role-edit', 'Role Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(4, 'role-delete', 'Role Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(5, 'role-massdelete', 'Role Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(9, 'user-list', 'User Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(10, 'user-create', 'User Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(11, 'user-edit', 'User Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(12, 'user-delete', 'User Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(13, 'user-show', 'User Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(14, 'user-massdelete', 'User Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(15, 'logactivity-list', 'Log Activity', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(16, 'logactivity-show', 'Log Activity', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(17, 'role-show', 'Role Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(18, 'changelog-list', 'Changelog', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(19, 'changelog-create', 'Changelog', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(20, 'changelog-edit', 'Changelog', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(21, 'changelog-delete', 'Changelog', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(22, 'changelog-show', 'Changelog', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(23, 'changelog-massdelete', 'Changelog', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(112, 'supplier-list', 'Supplier Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(113, 'supplier-create', 'Supplier Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(114, 'supplier-edit', 'Supplier Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(115, 'supplier-delete', 'Supplier Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(116, 'supplier-show', 'Supplier Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(117, 'supplier-massdelete', 'Supplier Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(118, 'brand-list', 'Brand Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(119, 'brand-create', 'Brand Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(120, 'brand-edit', 'Brand Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(121, 'brand-delete', 'Brand Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(122, 'brand-show', 'Brand Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(123, 'brand-massdelete', 'Brand Management', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(124, 'kategori-list', 'kategori Barang', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(125, 'kategori-create', 'kategori Barang', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(126, 'kategori-edit', 'kategori Barang', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(127, 'kategori-delete', 'kategori Barang', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(128, 'kategori-show', 'kategori Barang', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29'),
(129, 'kategori-massdelete', 'kategori Barang', 'web', '2024-10-09 20:13:29', '2024-10-09 20:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(3, 'Admin', 'web', '2024-10-17 19:14:42', '2024-10-17 19:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3),
(112, 3),
(113, 3),
(114, 3),
(115, 3),
(116, 3),
(117, 3),
(118, 3),
(119, 3),
(120, 3),
(121, 3),
(122, 3),
(123, 3),
(124, 3),
(125, 3),
(126, 3),
(127, 3),
(128, 3),
(129, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RoePahDxm9BPj3LLBxZdSFBchCcLjGpDbA9YLAYx', '6a57a643-965c-4834-9869-df9dae41edc6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieVAzVlFrQloxWUU4VEVLZmk3Y2kxV09rUnpjV0dkS3VnWkZDSWg5TCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MDoiaHR0cDovL2xvY2FsaG9zdC9zdGFydGVyLW1pbi9wdWJsaWMvY3J1ZC1nZW5lcmF0b3IiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NToiaHR0cDovL2xvY2FsaG9zdC9zdGFydGVyLW1pbi9wdWJsaWMvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MzY6IjZhNTdhNjQzLTk2NWMtNDgzNC05ODY5LWRmOWRhZTQxZWRjNiI7fQ==', 1757875374),
('UfZjHCD7nfaKzWR7ZJSc788H7eXDBbvOEqBrmhNu', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSms0QUpQaDNsNWR5VDdEMk1Iam9XN3F2R2V0NFhZUVlYclNJdkVJVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1757875677);

-- --------------------------------------------------------

--
-- Table structure for table `setting_app`
--

CREATE TABLE `setting_app` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo_black` varchar(255) DEFAULT NULL,
  `logo_white` varchar(255) DEFAULT NULL,
  `logo_mobile` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `footer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_app`
--

INSERT INTO `setting_app` (`id`, `logo_black`, `logo_white`, `logo_mobile`, `favicon`, `footer`, `created_at`, `updated_at`) VALUES
(1, 'settings/logo_black_1760169598.svg', 'settings/logo_white_1760169598.svg', 'settings/logo_mobile_1760169598.svg', 'settings/favicon_1760169598.ico', 'DIskon Besar 22', NULL, '2025-10-11 00:59:58');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` char(36) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `nama`, `no_telp`, `alamat`, `keterangan`, `created_at`, `updated_at`) VALUES
('0199d210-283e-7058-bc83-7df173c66b37', 'dscsdc', 'dscds', 'cdsc', 'dscdsc', '2025-10-10 23:58:18', '2025-10-10 23:58:18'),
('0199d246-1d96-7210-8ab5-3116ead1921a', 'gg', 'fggh', 'ghgh', 'hghgf', '2025-10-11 00:57:14', '2025-10-11 00:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `tipe`
--

CREATE TABLE `tipe` (
  `id` char(36) NOT NULL,
  `brand_id` char(36) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `last_login_at`, `last_login_ip`, `avatar`, `provider`, `google_id`) VALUES
('6a57a643-965c-4834-9869-df9dae41edc6', 'Admin', 'admin@gmail.com', NULL, '$2y$12$ayeff/uw.I1sHB9s/DV2purod3zExlxpcK7L83dCSgls5D2Rmvx1a', NULL, '2024-10-17 19:14:42', '2025-10-10 23:58:02', '2025-10-11 06:58:02', '127.0.0.1', '20241023174705dd68d663d3d7224c1e758c67d694e8f9.jpg', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barang_kode_barang_unique` (`kode_barang`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barang_masuk_kode_transaksi_unique` (`kode_transaksi`);

--
-- Indexes for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
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
-- Indexes for table `changelog`
--
ALTER TABLE `changelog`
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
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penjualan_kode_transaksi_unique` (`kode_transaksi`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `setting_app`
--
ALTER TABLE `setting_app`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipe`
--
ALTER TABLE `tipe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=627;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `setting_app`
--
ALTER TABLE `setting_app`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
