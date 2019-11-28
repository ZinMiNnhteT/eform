-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2019 at 06:55 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lara_emeter`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `div_state` int(11) NOT NULL DEFAULT '0',
  `district` int(11) NOT NULL DEFAULT '0',
  `township` int(11) NOT NULL DEFAULT '0',
  `town` int(11) NOT NULL DEFAULT '0',
  `group_lvl` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `phone`, `div_state`, `district`, `township`, `town`, `group_lvl`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'SYSTEM', 'system', 'system@mail.com', NULL, '$1$jXRLFnWI$uLrJTJJRnmMellwJgnDBO0', '0912312312', 0, 0, 0, 0, 1, 1, NULL, '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(2, 'MOEE Admin', 'moeeadmin', 'admin.emeter@moee.gov.mm', NULL, '$1$2Rn42TNa$yJWX1yFFRmPS1kV0ojyXW1', '0912312312', 0, 0, 0, 0, 2, 1, NULL, '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(3, 'Admin', NULL, 'officeadmin@mail.com', NULL, '$2y$10$ZyLu9QOpN4ltGn.5uD04IOvs3QRHmhxIhg94b9aJNOpdBoh3eBWYi', '09123123123', 1, 0, 0, 0, 3, 1, NULL, '2019-06-23 17:24:53', '2019-06-23 17:24:53'),
(4, 'Junior Engineer 1', NULL, 'eng1@mail.com', NULL, '$2y$10$sGUJGq2lBWnbeJxCfM2Hw.p4bY1wP29iubpxJ1I5fMeUGog.XEgf2', '09132123123', 2, 3, 14, 0, 6, 1, NULL, '2019-06-23 17:51:58', '2019-06-23 17:51:58'),
(5, 'Junior Engineer 2', NULL, 'eng2@mail.com', NULL, '$2y$10$q2CgYWnYig60wWodx0c7sOG813B7XMxMkcIoFk28Xwfw.Gcz5TPTO', '09987123987', 2, 3, 13, 0, 6, 1, NULL, '2019-06-23 17:53:53', '2019-06-23 17:53:53'),
(6, 'Junior Engineer 3', NULL, 'eng3@mail.com', NULL, '$2y$10$zRpjsFQK2bc0VQdIMWeEBuQD.xhjIZ5GwUEoxf9VPAiR.ThNcBJ2W', '09234509874', 2, 3, 14, 0, 6, 1, NULL, '2019-06-23 17:54:48', '2019-06-23 17:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `admin_actions`
--

CREATE TABLE `admin_actions` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `form_accept` int(11) DEFAULT NULL,
  `form_pending` int(11) DEFAULT NULL,
  `survey_accept` int(11) DEFAULT NULL,
  `survey_confirm` int(11) DEFAULT NULL,
  `survey_confirm_dist` int(11) DEFAULT NULL,
  `survey_confirm_div_state` int(11) DEFAULT NULL,
  `survey_confirm_div_state_to_headoffice` int(11) DEFAULT NULL,
  `survey_confirm_headoffice` int(11) DEFAULT NULL,
  `announce` int(11) DEFAULT NULL,
  `payment_accept` int(11) DEFAULT NULL,
  `install_accept` int(11) DEFAULT NULL,
  `install_confirm` int(11) DEFAULT NULL,
  `register_meter` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_files`
--

CREATE TABLE `application_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `nrc_copy_front` text COLLATE utf8mb4_unicode_ci,
  `nrc_copy_back` text COLLATE utf8mb4_unicode_ci,
  `form_10_front` text COLLATE utf8mb4_unicode_ci,
  `form_10_back` text COLLATE utf8mb4_unicode_ci,
  `occupy_letter` text COLLATE utf8mb4_unicode_ci,
  `no_invade_letter` text COLLATE utf8mb4_unicode_ci,
  `ownership` text COLLATE utf8mb4_unicode_ci,
  `electric_power` text COLLATE utf8mb4_unicode_ci,
  `transaction_licence` text COLLATE utf8mb4_unicode_ci,
  `building_permit` text COLLATE utf8mb4_unicode_ci,
  `bcc` text COLLATE utf8mb4_unicode_ci,
  `dc_recomm` text COLLATE utf8mb4_unicode_ci,
  `prev_bill` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_forms`
--

CREATE TABLE `application_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `apply_type` int(11) NOT NULL,
  `apply_sub_type` int(11) NOT NULL,
  `apply_division` int(11) NOT NULL,
  `is_religion` tinyint(1) DEFAULT '0',
  `serial_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nrc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` int(11) NOT NULL DEFAULT '0',
  `applied_building_type` text COLLATE utf8mb4_unicode_ci,
  `applied_home_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_building` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_lane` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_street` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_quarter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_town` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `township_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `div_state_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_form_contractors`
--

CREATE TABLE `application_form_contractors` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `room_count` int(11) NOT NULL,
  `pMeter10` int(11) DEFAULT NULL,
  `pMeter20` int(11) DEFAULT NULL,
  `pMeter30` int(11) DEFAULT NULL,
  `meter` int(11) DEFAULT NULL,
  `water_meter` tinyint(1) DEFAULT NULL,
  `elevator_meter` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(10) UNSIGNED NOT NULL,
  `division_state_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `division_state_id`, `name`, `eng`, `created_at`, `updated_at`) VALUES
(1, 1, 'ဒက္ခိဏခရိုင်', 'Datkhina', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(2, 1, 'ဥတ္တရခရိုင်', 'Ottara', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(3, 2, 'ရန်ကုန်အရှေ့ပိုင်းခရိုင်', 'Eastern Yangon', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(4, 2, 'ရန်ကုန်အနောက်ပိုင်းခရိုင်', 'Western Yangon', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(5, 2, 'ရန်ကုန်တောင်ပိုင်းခရိုင်', 'Southern Yangon', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(6, 2, 'ရန်ကုန်မြောက်ပိုင်းခရိုင်', 'Northern Yangon', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(7, 3, 'မန္တလေးခရိုင်', 'Mandalay', '2019-06-18 04:30:41', '2019-06-18 04:30:41');

-- --------------------------------------------------------

--
-- Table structure for table `division_states`
--

CREATE TABLE `division_states` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `division_states`
--

INSERT INTO `division_states` (`id`, `name`, `eng`, `created_at`, `updated_at`) VALUES
(1, 'နေပြည်တော်ကောင်စီနယ်မြေ', 'Nay Pyi Taw', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(2, 'ရန်ကုန်တိုင်းဒေသကြီး', 'Yangon', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(3, 'မန္တလေးတိုင်းဒေသကြီး', 'Mandalay', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(4, 'မကွေးတိုင်းဒေသကြီး', 'Magway', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(5, 'ရှမ်းပြည်နယ်', 'Shan', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(6, 'ဧရာဝတီတိုင်းဒေသကြီး', 'Ayeyarwady', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(7, 'ကရင်ပြည်နယ်', 'Kayin', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(8, 'ချင်းပြည်နယ်', 'Chin', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(9, 'မွန်ပြည်နယ်', 'Mon', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(10, 'တနင်္သာရီတိုင်းဒေသကြီး', 'Tanintharyi', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(11, 'ပဲခူးတိုင်းဒေသကြီး', 'Bago', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(12, 'ကချင်ပြည်နယ်', 'Kachin', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(13, 'စစ်ကိုင်းတိုင်းဒေသကြီး', 'Sagaing', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(14, 'ကယားပြည်နယ်', 'Kayah', '2019-06-18 04:30:41', '2019-06-18 04:30:41'),
(15, 'ရခိုင်ပြည်နယ်', 'Rakhine', '2019-06-18 04:30:41', '2019-06-18 04:30:41');

-- --------------------------------------------------------

--
-- Table structure for table `form66s`
--

CREATE TABLE `form66s` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `room_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meter_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `water_meter_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `elevator_meter_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meter_seal_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meter_get_date` date DEFAULT NULL,
  `who_made_meter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ampere` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `mark_user_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `move_date` date DEFAULT NULL,
  `move_budget` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `move_order` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `test_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form138s`
--

CREATE TABLE `form138s` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `form_send_date` date DEFAULT NULL,
  `form_get_date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cash_kyat` int(11) DEFAULT NULL,
  `calculator` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calcu_date` date DEFAULT NULL,
  `payment_form_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_form_date` date DEFAULT NULL,
  `deposite_form_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposite_form_date` date DEFAULT NULL,
  `somewhat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `somewhat_form_date` date DEFAULT NULL,
  `string_form_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `string_form_date` date DEFAULT NULL,
  `service_string_form_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_drafts`
--

CREATE TABLE `form_drafts` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `is_religion` tinyint(1) NOT NULL DEFAULT '0',
  `apply_division` int(10) DEFAULT '2',
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nrc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` int(50) DEFAULT NULL,
  `applied_building_type` text COLLATE utf8mb4_unicode_ci,
  `applied_home_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_building` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_lane` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_street` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_quarter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_town` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `township_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `div_state_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_ei_chks`
--

CREATE TABLE `form_ei_chks` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `ei_files` text COLLATE utf8mb4_unicode_ci,
  `ei_remark` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_process_actions`
--

CREATE TABLE `form_process_actions` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `user_send_to_office` tinyint(1) NOT NULL DEFAULT '0',
  `user_send_form_date` text COLLATE utf8mb4_unicode_ci,
  `form_reject` tinyint(1) NOT NULL DEFAULT '0',
  `reject_date` timestamp NULL DEFAULT NULL,
  `form_pending` tinyint(1) NOT NULL DEFAULT '0',
  `pending_date` timestamp NULL DEFAULT NULL,
  `form_accept` tinyint(1) NOT NULL DEFAULT '0',
  `accepted_date` timestamp NULL DEFAULT NULL,
  `survey_accept` tinyint(1) NOT NULL DEFAULT '0',
  `survey_accepted_date` timestamp NULL DEFAULT NULL,
  `survey_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `survey_confirmed_date` timestamp NULL DEFAULT NULL,
  `survey_confirm_dist` tinyint(1) NOT NULL DEFAULT '0',
  `survey_confirmed_dist_date` timestamp NULL DEFAULT NULL,
  `survey_confirm_div_state` tinyint(1) NOT NULL DEFAULT '0',
  `survey_confirmed_div_state_date` timestamp NULL DEFAULT NULL,
  `survey_confirm_div_state_to_headoffice` tinyint(1) NOT NULL DEFAULT '0',
  `survey_confirmed_div_state_to_headoffice_date` timestamp NULL DEFAULT NULL,
  `survey_confirm_headoffice` tinyint(1) NOT NULL DEFAULT '0',
  `survey_confirmed_headoffice_date` timestamp NULL DEFAULT NULL,
  `announce` tinyint(1) NOT NULL DEFAULT '0',
  `announced_date` timestamp NULL DEFAULT NULL,
  `user_pay` tinyint(1) NOT NULL DEFAULT '0',
  `user_paid_date` timestamp NULL DEFAULT NULL,
  `payment_accept` tinyint(1) NOT NULL DEFAULT '0',
  `payment_accepted_date` timestamp NULL DEFAULT NULL,
  `install_accept` tinyint(1) NOT NULL DEFAULT '0',
  `install_accepted_date` timestamp NULL DEFAULT NULL,
  `install_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `install_confirmed_date` timestamp NULL DEFAULT NULL,
  `register_meter` tinyint(1) NOT NULL DEFAULT '0',
  `registered_meter_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_process_remarks`
--

CREATE TABLE `form_process_remarks` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `error_remark` text COLLATE utf8mb4_unicode_ci,
  `resend_remark` text COLLATE utf8mb4_unicode_ci,
  `reject_remark` text COLLATE utf8mb4_unicode_ci,
  `pending_remark` text COLLATE utf8mb4_unicode_ci,
  `who_did_this` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_routines`
--

CREATE TABLE `form_routines` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `send_from` int(11) DEFAULT NULL,
  `send_to` int(11) DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_send_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_surveys`
--

CREATE TABLE `form_surveys` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `survey_engineer` int(11) DEFAULT NULL,
  `survey_date` timestamp NULL DEFAULT NULL,
  `applied_type` int(11) DEFAULT NULL,
  `phase_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `volt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kilowatt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `living` tinyint(1) DEFAULT NULL,
  `meter` tinyint(1) DEFAULT NULL,
  `invade` tinyint(1) DEFAULT NULL,
  `loaded` tinyint(1) DEFAULT NULL,
  `prev_meter_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_info` text COLLATE utf8mb4_unicode_ci,
  `max_load` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comsumed_power_amt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comsumed_power_file` text COLLATE utf8mb4_unicode_ci,
  `origin_p_meter` int(11) DEFAULT NULL,
  `allow_p_meter` int(11) DEFAULT NULL,
  `transmit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_power_files` text COLLATE utf8mb4_unicode_ci,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `meter_count` int(11) DEFAULT NULL,
  `pMeter10` int(11) DEFAULT NULL,
  `pMeter20` int(11) DEFAULT NULL,
  `pMeter30` int(11) DEFAULT NULL,
  `water_meter_count` int(11) DEFAULT NULL,
  `water_meter_type` int(11) DEFAULT NULL,
  `elevator_meter_count` int(11) DEFAULT NULL,
  `elevator_meter_type` int(11) DEFAULT NULL,
  `tsf_transmit_distance_feet` text COLLATE utf8mb4_unicode_ci,
  `tsf_transmit_distance_kv` text COLLATE utf8mb4_unicode_ci,
  `exist_transformer` text COLLATE utf8mb4_unicode_ci,
  `amp` int(11) DEFAULT NULL,
  `new_tsf_name` text COLLATE utf8mb4_unicode_ci,
  `new_tsf_distance` text COLLATE utf8mb4_unicode_ci,
  `distance_04` text COLLATE utf8mb4_unicode_ci,
  `new_line_type` int(11) DEFAULT NULL,
  `new_tsf_info_volt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_tsf_info_kv` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_tsf_info_volt_two` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_tsf_info_kv_two` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bq_cost` int(11) DEFAULT NULL,
  `bq_cost_files` text COLLATE utf8mb4_unicode_ci,
  `remark_tsp` text COLLATE utf8mb4_unicode_ci,
  `bq_cost_dist` int(11) DEFAULT NULL,
  `bq_cost_dist_files` text COLLATE utf8mb4_unicode_ci,
  `remark_dist` text COLLATE utf8mb4_unicode_ci,
  `bq_cost_div_state` int(11) DEFAULT NULL,
  `bq_cost_div_state_files` text COLLATE utf8mb4_unicode_ci,
  `remark_div_state` text COLLATE utf8mb4_unicode_ci,
  `budget_name` text COLLATE utf8mb4_unicode_ci,
  `location_files` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_survey_transformers`
--

CREATE TABLE `form_survey_transformers` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `survey_engineer` int(11) DEFAULT NULL,
  `pri_tsf_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pri_tsf_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pri_capacity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ct_ratio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ct_ratio_amt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pri_main_ct_ratio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pri_main_ct_ratio_amt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_feeder_peak_load` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_feeder_peak_load_amt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pri_feeder_ct_ratio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pri_feeder_ct_ratio_amt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feeder_peak_load` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feeder_peak_load_amt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_tsf_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_tsf_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_capacity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_main_ct_ratio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_main_ct_ratio_amt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_11_main_ct_ratio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_11_peak_load_day` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_11_peak_load_night` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_11_installed_capacity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feeder_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feeder_ct_ratio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feeder_peak_load_day` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feeder_peak_load_night` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `online_installed_capacity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_line_length` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_line_length` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conductor` text COLLATE utf8mb4_unicode_ci,
  `string_change` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `string_change_type_length` text COLLATE utf8mb4_unicode_ci,
  `power_station_recomm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `one_line_diagram` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_map` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_map` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comsumed_power_amt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comsumed_power_list` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_tsf` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowed_tsf` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `survey_remark` text COLLATE utf8mb4_unicode_ci,
  `tsp_remark` text COLLATE utf8mb4_unicode_ci,
  `dist_remark` text COLLATE utf8mb4_unicode_ci,
  `capacitor_bank` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacitor_bank_amt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `div_state_remark` text COLLATE utf8mb4_unicode_ci,
  `head_office_remark` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `initial_costs`
--

CREATE TABLE `initial_costs` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL,
  `sub_type` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assign_fee` int(11) NOT NULL,
  `deposit_fee` int(11) NOT NULL,
  `string_fee` int(11) NOT NULL,
  `service_fee` int(11) DEFAULT NULL,
  `incheck_fee` int(11) DEFAULT NULL,
  `registration_fee` int(11) NOT NULL,
  `composit_box` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `initial_costs`
--

INSERT INTO `initial_costs` (`id`, `type`, `sub_type`, `name`, `slug`, `assign_fee`, `deposit_fee`, `string_fee`, `service_fee`, `incheck_fee`, `registration_fee`, `composit_box`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Type One', 'type_one', 35000, 4000, 2000, 2000, 1000, 1000, NULL, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(2, 1, 2, 'Type Two', 'type_two', 65000, 4000, 2000, 2000, 1000, 1000, NULL, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(3, 1, 3, 'Type Three', 'type_three', 80000, 4000, 2000, 2000, 1000, 1000, NULL, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(4, 2, 1, '10', '10kw', 800000, 4000, 6000, 0, 0, 2000, 34000, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(5, 2, 2, '20', '20kw', 1000000, 4000, 6000, 0, 0, 2000, 34000, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(6, 2, 3, '30', '30kw', 1200000, 4000, 6000, 0, 0, 2000, 34000, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(7, 3, 1, '10', '10kw', 800000, 82500, 8000, 0, 0, 20000, 34000, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(8, 3, 2, '20', '20kw', 1000000, 157500, 8000, 0, 0, 20000, 34000, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(9, 3, 3, '30', '30kw', 1200000, 232500, 8000, 0, 0, 20000, 34000, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(10, 4, 1, '50', '50kva', 1800000, 307500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(11, 4, 2, '100', '100kva', 2100000, 607500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(12, 4, 3, '160', '160kva', 2400000, 967500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(13, 4, 4, '200', '200kva', 2700000, 1207500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(14, 4, 5, '315', '315kva', 3300000, 1897500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(15, 4, 6, '500', '500kva', 4500000, 3007500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(16, 4, 7, '1000', '1000kva', 7800000, 6007500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(17, 4, 8, '1250', '1250kva', 9300000, 7507500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(18, 4, 9, '20000', '20000kva', 200000000, 120007500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(19, 4, 10, '25000', '25000kva', 250000000, 150007500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53'),
(20, 4, 11, '30000', '30000kva', 300000000, 180007500, 6000, 2000, 0, 20000, 0, '2019-06-18 05:13:53', '2019-06-18 05:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_tbls`
--

CREATE TABLE `mail_tbls` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `send_type` tinyint(1) DEFAULT NULL,
  `mail_send_date` timestamp NULL DEFAULT NULL,
  `mail_body` text COLLATE utf8mb4_unicode_ci,
  `mail_seen` tinyint(1) NOT NULL DEFAULT '0',
  `mail_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_tbls`
--

INSERT INTO `mail_tbls` (`id`, `application_form_id`, `sender_id`, `user_id`, `send_type`, `mail_send_date`, `mail_body`, `mail_seen`, `mail_read`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 9, 1, '2019-10-16 03:28:52', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570683644</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">လိုအပ်ချက်များရှိပါသောကြောင့် ဤလျှောက်လွှာအား လျှောက်ထားသူထံ အောက်ပါမှတ်ချက်နှင့်တကွ ပြန်ပို့ပါမည်။</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterYangonAppliedForm/2\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 03:28:52', '2019-10-18 07:53:58'),
(2, 2, NULL, 9, 2, '2019-10-16 03:30:40', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570683644</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterYangonAppliedForm/2\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 03:30:40', '2019-10-18 07:53:58'),
(3, 2, NULL, 9, 2, '2019-10-16 03:41:56', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570683644</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterYangonAppliedForm/2\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 03:41:56', '2019-10-18 07:53:58'),
(4, 2, NULL, 9, 2, '2019-10-16 04:10:17', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570683644</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterYangonAppliedForm/2\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 04:10:17', '2019-10-18 07:53:58'),
(5, 2, NULL, 9, 4, '2019-10-16 04:12:50', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570683644</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">ပယ်ဖျက်စာရင်းသို့ ပို့ပါမည်။</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterYangonAppliedForm/2\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 04:12:50', '2019-10-18 07:53:58'),
(6, 2, NULL, 9, 3, '2019-10-16 04:19:24', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570683644</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">စောင့်ဆိုင်းစာရင်းသို့ ပို့ပါမည်။</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterYangonAppliedForm/2\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 04:19:24', '2019-10-18 07:53:58'),
(7, 2, NULL, 9, 5, '2019-10-16 04:24:42', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570683644</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link ) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/paymentForm/2\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 04:24:42', '2019-10-18 07:53:58'),
(8, 2, NULL, 9, 6, '2019-10-16 04:32:44', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570683644</span> ) မှာ (16-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterYangonAppliedForm/2\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 04:32:44', '2019-10-18 07:53:58'),
(9, 3, NULL, 9, 1, '2019-10-16 04:52:45', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570693709</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">လိုအပ်ချက်များရှိပါသောကြောင့် ဤလျှောက်လွှာအား လျှောက်ထားသူထံ အောက်ပါမှတ်ချက်နှင့်တကွ ပြန်ပို့ပါမည်။</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialPowerMeterYangonAppliedForm/3\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 04:52:45', '2019-10-18 07:53:58'),
(10, 3, NULL, 9, 2, '2019-10-16 04:54:20', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570693709</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialPowerMeterYangonAppliedForm/3\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 04:54:20', '2019-10-18 07:53:58'),
(11, 3, NULL, 9, 5, '2019-10-16 05:00:27', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570693709</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/paymentForm/3\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 05:00:27', '2019-10-18 07:53:58'),
(12, 3, NULL, 9, 6, '2019-10-16 05:01:29', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570693709</span> ) မှာ (16-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialPowerMeterYangonAppliedForm/3\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 05:01:29', '2019-10-18 07:53:58'),
(13, 4, NULL, 9, 1, '2019-10-16 05:05:16', '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570695139</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">လိုအပ်ချက်များရှိပါသောကြောင့် ဤလျှောက်လွှာအား လျှောက်ထားသူထံ အောက်ပါမှတ်ချက်နှင့်တကွ ပြန်ပို့ပါမည်။</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/commercialPowerMeterYangonAppliedForm/4\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:05:16', '2019-10-18 07:53:58'),
(14, 4, NULL, 9, 2, '2019-10-16 05:05:53', '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570695139</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/commercialPowerMeterYangonAppliedForm/4\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:05:53', '2019-10-18 07:53:58'),
(15, 7, NULL, 10, 2, '2019-10-16 05:11:44', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702215</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/7\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:11:44', '2019-10-17 08:52:05'),
(16, 7, NULL, 10, 5, '2019-10-16 05:13:52', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702215</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link ) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/paymentForm/7\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 05:13:52', '2019-10-17 08:52:05'),
(17, 7, NULL, 10, 6, '2019-10-16 05:15:37', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702215</span> ) မှာ (16-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/7\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 05:15:37', '2019-10-17 08:52:05'),
(18, 5, NULL, 9, 2, '2019-10-16 05:20:36', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570695508</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/contractorMeterYangonAppliedForm/5\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:20:36', '2019-10-18 07:53:58'),
(19, 13, NULL, 10, 1, '2019-10-16 05:21:43', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571203155</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">asdasdasd</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/13\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 05:21:43', '2019-10-17 08:52:05'),
(20, 13, NULL, 10, 2, '2019-10-16 05:28:12', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571203155</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/13\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:28:12', '2019-10-17 08:52:05'),
(21, 13, NULL, 10, 5, '2019-10-16 05:30:46', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571203155</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link ) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/paymentForm/13\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 05:30:46', '2019-10-17 08:52:05'),
(22, 15, NULL, 10, 2, '2019-10-16 05:37:43', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571204017</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/15\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:37:43', '2019-10-17 08:52:05'),
(23, 13, NULL, 10, 6, '2019-10-16 05:38:51', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571203155</span> ) မှာ (16-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/13\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:38:51', '2019-10-17 08:52:05'),
(24, 15, NULL, 10, 4, '2019-10-16 05:40:11', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571204017</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">delete because blabla</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/15\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:40:11', '2019-10-17 08:52:05'),
(25, 14, NULL, 10, 2, '2019-10-16 05:41:16', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571204112</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/14\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:41:16', '2019-10-17 08:52:05'),
(26, 14, NULL, 10, 3, '2019-10-16 05:44:41', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571204112</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">wait wait</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/14\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 05:44:41', '2019-10-17 08:52:05'),
(27, 14, NULL, 10, 5, '2019-10-16 05:45:42', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571204112</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link ) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/paymentForm/14\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 05:45:42', '2019-10-17 08:52:05'),
(28, 14, NULL, 10, 6, '2019-10-16 06:44:13', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571204112</span> ) မှာ (16-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialMeterAppliedForm/14\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 06:44:13', '2019-10-17 08:52:05'),
(29, 5, NULL, 9, 5, '2019-10-16 07:23:56', '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570695508</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link ) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/paymentForm/5\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 07:23:56', '2019-10-18 07:53:58'),
(30, 8, NULL, 10, 2, '2019-10-16 07:38:43', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702342</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialPowerMeterAppliedForm/8\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 07:38:43', '2019-10-17 08:52:05'),
(31, 8, NULL, 10, 5, '2019-10-16 07:41:25', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702342</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/paymentForm/8\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 07:41:25', '2019-10-17 08:52:05'),
(32, 18, NULL, 10, 1, '2019-10-16 08:03:37', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571211887</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">resend</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialPowerMeterAppliedForm/18\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 08:03:37', '2019-10-17 08:52:05'),
(33, 16, NULL, 10, 2, '2019-10-16 08:05:59', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571212892</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialPowerMeterAppliedForm/16\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:05:59', '2019-10-17 08:52:05'),
(34, 16, NULL, 10, 4, '2019-10-16 08:07:50', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571212892</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">cancle</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialPowerMeterAppliedForm/16\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:07:50', '2019-10-17 08:52:05'),
(35, 17, NULL, 10, 2, '2019-10-16 08:08:16', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1571212113</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialPowerMeterAppliedForm/17\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:08:16', '2019-10-17 08:52:05'),
(36, 17, NULL, 10, 3, '2019-10-16 08:10:33', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1571212113</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">dfafasdfdas</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialPowerMeterAppliedForm/17\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:10:33', '2019-10-17 08:52:05'),
(37, 5, NULL, 9, 6, '2019-10-16 08:11:23', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">YGN-1570695508</span> ) မှာ (16-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/contractorMeterYangonAppliedForm/5\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:11:23', '2019-10-18 07:53:58'),
(38, 17, NULL, 10, 5, '2019-10-16 08:11:36', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1571212113</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/paymentForm/17\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 08:11:36', '2019-10-17 08:52:05'),
(39, 17, NULL, 10, 6, '2019-10-16 08:13:03', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1571212113</span> ) မှာ (16-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/residentialPowerMeterAppliedForm/17\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:13:03', '2019-10-17 08:52:05'),
(40, 9, NULL, 10, 1, '2019-10-16 08:13:53', '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702505</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">dfdsf</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/commercialPowerMeterAppliedForm/9\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 08:13:53', '2019-10-17 08:52:05'),
(41, 9, NULL, 10, 2, '2019-10-16 08:14:54', '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702505</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/commercialPowerMeterAppliedForm/9\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:14:54', '2019-10-17 08:52:05'),
(42, 9, NULL, 10, 3, '2019-10-16 08:17:12', '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702505</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">ddd</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/commercialPowerMeterAppliedForm/9\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:17:12', '2019-10-17 08:52:05'),
(43, 9, NULL, 10, 5, '2019-10-16 08:18:26', '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702505</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link ) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/paymentForm/9\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 08:18:26', '2019-10-17 08:52:05'),
(44, 9, NULL, 10, 6, '2019-10-16 08:22:17', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570702505</span> ) မှာ (16-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/commercialPowerMeterAppliedForm/9\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:22:17', '2019-10-17 08:52:05'),
(45, 19, NULL, 10, 2, '2019-10-16 08:22:55', '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1571213990</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/commercialPowerMeterAppliedForm/19\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:22:55', '2019-10-17 08:52:05'),
(46, 19, NULL, 10, 4, '2019-10-16 08:36:23', '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1571213990</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">cancel</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/commercialPowerMeterAppliedForm/19\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:36:23', '2019-10-17 08:52:05'),
(47, 10, NULL, 10, 1, '2019-10-16 08:37:10', 're send', 1, 1, '2019-10-16 08:37:10', '2019-10-17 08:52:05'),
(48, 11, NULL, 10, 2, '2019-10-16 08:38:34', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570703138</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/contractorMeterAppliedForm/11\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:38:34', '2019-10-17 08:52:05'),
(49, 11, NULL, 10, 3, '2019-10-16 08:48:14', '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570703138</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">စောင့်ဆိုင်းစာရင်းသို့ ပို့ပါမည်။</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/contractorMeterAppliedForm/11\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:48:14', '2019-10-17 08:52:05'),
(50, 11, NULL, 10, 3, '2019-10-16 08:48:27', '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570703138</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">wait</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/contractorMeterAppliedForm/11\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 08:48:27', '2019-10-17 08:52:05'),
(51, 11, NULL, 10, 5, '2019-10-16 08:50:00', '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570703138</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link ) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">23-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/paymentForm/11\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-16 08:50:00', '2019-10-17 08:52:05'),
(52, 11, NULL, 10, 6, '2019-10-16 08:52:11', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570703138</span> ) မှာ (16-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/contractorMeterAppliedForm/11\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-16 08:52:11', '2019-10-17 08:52:05'),
(53, 20, NULL, 10, 2, '2019-10-16 09:03:43', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1571216255</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/contractorMeterAppliedForm/20\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 09:03:43', '2019-10-17 08:52:05'),
(54, 20, NULL, 10, 3, '2019-10-16 09:12:09', '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1571216255</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">dfasdf</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/contractorMeterAppliedForm/20\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 09:12:09', '2019-10-17 08:52:05'),
(55, 20, NULL, 10, 4, '2019-10-16 10:36:21', '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1571216255</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\"></div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/contractorMeterAppliedForm/20\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-16 10:36:21', '2019-10-17 08:52:05'),
(56, 12, NULL, 10, 2, '2019-10-17 07:44:30', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570703413</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/transformerAppliedForm/12\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-17 07:44:30', '2019-10-17 08:52:05'),
(57, 12, NULL, 10, 3, '2019-10-17 07:46:21', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570703413</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">lorem wait</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/transformerAppliedForm/12\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-17 07:46:21', '2019-10-17 08:52:05'),
(58, 12, NULL, 10, 4, '2019-10-17 07:48:08', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">NPT-1570703413</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">cancel lorem</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/transformerAppliedForm/12\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-17 07:48:08', '2019-10-17 08:52:05'),
(59, 21, NULL, 10, 2, '2019-10-17 07:58:41', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571298760</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/transformerAppliedForm/21\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-17 07:58:41', '2019-10-17 08:52:05'),
(60, 21, NULL, 10, 3, '2019-10-17 08:01:47', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571298760</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">wait</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/transformerAppliedForm/21\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-17 08:01:47', '2019-10-17 08:52:05'),
(61, 21, NULL, 10, 3, '2019-10-17 08:06:27', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571298760</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">wait</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/transformerAppliedForm/21\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-17 08:06:27', '2019-10-17 08:52:05'),
(62, 21, NULL, 10, 5, '2019-10-17 08:10:52', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571298760</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">24-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/paymentForm/21\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-17 08:10:52', '2019-10-17 08:52:05'),
(63, 21, NULL, 10, 6, '2019-10-17 08:13:34', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571298760</span> ) မှာ (17-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/transformerAppliedForm/21\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 1, '2019-10-17 08:13:34', '2019-10-17 08:52:05'),
(64, 22, NULL, 10, 2, '2019-10-17 08:42:54', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571301453</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/transformerAppliedForm/22\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-17 08:42:54', '2019-10-17 08:52:05'),
(65, 22, NULL, 10, 5, '2019-10-17 08:51:02', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571301453</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">24-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/paymentForm/22\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-17 08:51:02', '2019-10-17 08:52:06'),
(66, 22, NULL, 10, 6, '2019-10-17 08:53:32', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571301453</span> ) မှာ (17-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://192.168.99.105/eform_latest_publish/transformerAppliedForm/22\" class=\"btn btn-info text-center\">Go to Form</a></div>', 0, 0, '2019-10-17 08:53:32', '2019-10-17 08:53:32'),
(67, 25, NULL, 11, 1, '2019-10-18 23:34:58', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571431870</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">လိုအပ်ချက်များရှိပါသောကြောင့် ဤလျှောက်လွှာအား လျှောက်ထားသူထံ အောက်ပါမှတ်ချက်နှင့်တကွ ပြန်ပို့ပါမည်။</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterAppliedForm/25\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-18 23:34:58', '2019-10-19 04:27:01'),
(68, 24, NULL, 11, 2, '2019-10-18 23:35:10', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571431009</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterAppliedForm/24\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-18 23:35:10', '2019-10-19 04:27:01'),
(69, 24, NULL, 11, 5, '2019-10-18 23:39:25', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571431009</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">26-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/paymentForm/24\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-18 23:39:25', '2019-10-19 04:27:01'),
(70, 24, NULL, 11, 6, '2019-10-18 23:47:19', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571431009</span> ) မှာ (19-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterAppliedForm/24\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-18 23:47:19', '2019-10-19 04:27:01'),
(71, 26, NULL, 11, 2, '2019-10-18 23:48:03', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571432430</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterAppliedForm/26\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-18 23:48:03', '2019-10-19 04:27:01'),
(72, 26, NULL, 11, 3, '2019-10-18 23:49:42', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571432430</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">စောင့်ဆိုင်းစာရင်းသို့ ပို့ပါမည်။</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterAppliedForm/26\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-18 23:49:42', '2019-10-19 04:27:01'),
(73, 26, NULL, 11, 4, '2019-10-18 23:50:24', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571432430</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"mt-3 mb-5\">ပယ်ဖျက်စာရင်းသို့ ပို့ပါမည်။</div><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterAppliedForm/26\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-18 23:50:24', '2019-10-19 04:27:01'),
(74, 31, NULL, 11, 2, '2019-10-19 00:01:59', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571441479</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/contractorMeterAppliedForm/31\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-19 00:01:59', '2019-10-19 04:27:01'),
(75, 39, NULL, 11, 2, '2019-10-19 04:02:29', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571457459</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterAppliedForm/39\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-19 04:02:29', '2019-10-19 04:27:01'),
(76, 39, NULL, 11, 5, '2019-10-19 04:10:42', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571457459</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">26-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/paymentForm/39\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-19 04:10:42', '2019-10-19 04:27:01'),
(77, 39, NULL, 11, 6, '2019-10-19 04:12:48', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571457459</span> ) မှာ (19-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterAppliedForm/39\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-19 04:12:48', '2019-10-19 04:27:01'),
(78, 39, NULL, 11, 6, '2019-10-19 04:12:48', '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571457459</span> ) မှာ (19-10-2019)တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/residentialMeterAppliedForm/39\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-19 04:12:48', '2019-10-19 04:27:01'),
(79, 40, NULL, 11, 2, '2019-10-19 04:19:13', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571458559</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/transformerAppliedForm/40\" class=\"btn btn-info text-center\">Go to Form</a></div>', 1, 0, '2019-10-19 04:19:13', '2019-10-19 04:27:01'),
(80, 40, NULL, 11, 5, '2019-10-19 04:26:46', '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class=\"text-danger\">MDY-1571458559</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class=\"text-danger\">26-10-2019 ၂:၀၀ နာရီ</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားအပ်ပါသည်။</p><div class=\"text-center mt-5 mb-5\"><a href=\"http://localhost/eform_latest_publish/paymentForm/40\" class=\"btn btn-info text-center\">Click for payment</a></div>', 1, 1, '2019-10-19 04:26:46', '2019-10-19 04:27:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_02_27_170033_create_admins_table', 1),
(4, '2019_02_27_172446_create_division_states_table', 1),
(5, '2019_02_27_172502_create_districts_table', 1),
(6, '2019_02_27_172521_create_townships_table', 1),
(7, '2019_02_27_172532_create_towns_table', 1),
(8, '2019_02_27_200200_create_initial_costs_table', 1),
(9, '2019_02_27_210923_create_application_forms_table', 1),
(10, '2019_02_27_211043_create_application_files_table', 1),
(11, '2019_02_28_104035_create_form_process_actions_table', 1),
(12, '2019_02_28_104049_create_form_process_remarks_table', 1),
(13, '2019_03_04_063310_create_permission_tables', 1),
(14, '2019_03_04_111413_create_jobs_table', 1),
(15, '2019_03_05_180145_create_form138s_table', 1),
(16, '2019_03_05_184436_create_form66s_table', 1),
(17, '2019_03_05_224051_create_mail_tbls_table', 1),
(18, '2019_03_05_232316_create_payments_table', 1),
(19, '2019_03_29_163727_create_form_routines_table', 1),
(20, '2019_04_01_142634_create_form_ei_chks_table', 1),
(21, '2019_04_02_174232_create_form_surveys_table', 1),
(22, '2019_04_05_222741_create_application_form_contractors_table', 1),
(23, '2019_04_20_150806_create_admin_actions_table', 1),
(24, '2019_04_24_192043_create_notifications_table', 1),
(25, '2019_05_11_195057_create_form_survey_transformers_table', 1),
(26, '2019_05_17_133343_create_tsf_infos_table', 1),
(27, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(28, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(29, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(30, '2016_06_01_000004_create_oauth_clients_table', 2),
(31, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Admin\\Admin', 1),
(2, 'App\\Admin\\Admin', 2),
(3, 'App\\Admin\\Admin', 3),
(6, 'App\\Admin\\Admin', 4),
(7, 'App\\Admin\\Admin', 5),
(7, 'App\\Admin\\Admin', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, 1, 'E-Form MOEE Personal Access Client', 'jxkI1S8x9QZjDEyWSh4ApNgUHNUri8aW0VQXFMg9', 'http://localhost', 1, 0, 0, '2019-08-22 11:05:43', '2019-08-22 11:05:43'),
(2, NULL, 'E-Form MOEE Password Grant Client', '2kbJN8NnmuCsaDkkN8KNDBK3cqab4BVEWP5Q6rLV', 'http://localhost', 0, 1, 0, '2019-08-22 11:05:43', '2019-08-22 11:05:43');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-08-22 11:05:43', '2019-08-22 11:05:43'),
(2, 2, '2019-08-31 10:41:54', '2019-08-31 10:41:54');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `payment_type` int(11) DEFAULT NULL,
  `files` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard-view', 'admin', '2019-06-18 05:17:59', '2019-06-18 05:17:59'),
(2, 'dashboard-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(3, 'dashboard-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(4, 'dashboard-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(5, 'dashboard-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(6, 'inbox-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(7, 'inbox-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(8, 'inbox-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(9, 'inbox-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(10, 'inbox-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(11, 'setting-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(12, 'setting-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(13, 'setting-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(14, 'setting-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(15, 'setting-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(16, 'accountSetting-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(17, 'accountSetting-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(18, 'accountSetting-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(19, 'accountSetting-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(20, 'accountSetting-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(21, 'roleSetting-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(22, 'roleSetting-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(23, 'roleSetting-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(24, 'roleSetting-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(25, 'roleSetting-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(26, 'userAccount-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(27, 'userAccount-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(28, 'userAccount-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(29, 'userAccount-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(30, 'userAccount-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(31, 'residential-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(32, 'residential-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(33, 'residential-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(34, 'residential-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(35, 'residential-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(36, 'residentApplication-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(37, 'residentApplication-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(38, 'residentApplication-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(39, 'residentApplication-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(40, 'residentApplication-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(41, 'residentialGrdChk-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(42, 'residentialGrdChk-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(43, 'residentialGrdChk-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(44, 'residentialGrdChk-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(45, 'residentialGrdChk-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(46, 'residentialChkGrdTownship-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(47, 'residentialChkGrdTownship-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(48, 'residentialChkGrdTownship-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(49, 'residentialChkGrdTownship-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(50, 'residentialChkGrdTownship-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(51, 'residentPending-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(52, 'residentPending-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(53, 'residentPending-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(54, 'residentPending-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(55, 'residentPending-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(56, 'residentReject-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(57, 'residentReject-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(58, 'residentReject-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(59, 'residentReject-delete', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(60, 'residentReject-show', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(61, 'residentialAnnounce-view', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(62, 'residentialAnnounce-create', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(63, 'residentialAnnounce-edit', 'admin', '2019-06-18 05:18:00', '2019-06-18 05:18:00'),
(64, 'residentialAnnounce-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(65, 'residentialAnnounce-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(66, 'residentialConfirmPayment-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(67, 'residentialConfirmPayment-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(68, 'residentialConfirmPayment-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(69, 'residentialConfirmPayment-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(70, 'residentialConfirmPayment-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(71, 'residentialChkInstall-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(72, 'residentialChkInstall-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(73, 'residentialChkInstall-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(74, 'residentialChkInstall-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(75, 'residentialChkInstall-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(76, 'residentialRegisteredMeter-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(77, 'residentialRegisteredMeter-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(78, 'residentialRegisteredMeter-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(79, 'residentialRegisteredMeter-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(80, 'residentialRegisteredMeter-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(81, 'residentialPower-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(82, 'residentialPower-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(83, 'residentialPower-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(84, 'residentialPower-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(85, 'residentialPower-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(86, 'residentPowerApplication-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(87, 'residentPowerApplication-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(88, 'residentPowerApplication-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(89, 'residentPowerApplication-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(90, 'residentPowerApplication-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(91, 'residentialPowerGrdChk-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(92, 'residentialPowerGrdChk-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(93, 'residentialPowerGrdChk-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(94, 'residentialPowerGrdChk-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(95, 'residentialPowerGrdChk-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(96, 'residentialPowerTownshipChkGrd-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(97, 'residentialPowerTownshipChkGrd-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(98, 'residentialPowerTownshipChkGrd-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(99, 'residentialPowerTownshipChkGrd-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(100, 'residentialPowerTownshipChkGrd-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(101, 'residentialPowerDistrictChkGrd-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(102, 'residentialPowerDistrictChkGrd-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(103, 'residentialPowerDistrictChkGrd-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(104, 'residentialPowerDistrictChkGrd-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(105, 'residentialPowerDistrictChkGrd-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(106, 'residentPowerPending-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(107, 'residentPowerPending-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(108, 'residentPowerPending-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(109, 'residentPowerPending-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(110, 'residentPowerPending-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(111, 'residentPowerReject-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(112, 'residentPowerReject-create', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(113, 'residentPowerReject-edit', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(114, 'residentPowerReject-delete', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(115, 'residentPowerReject-show', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(116, 'residentialPowerAnnounce-view', 'admin', '2019-06-18 05:18:01', '2019-06-18 05:18:01'),
(117, 'residentialPowerAnnounce-create', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(118, 'residentialPowerAnnounce-edit', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(119, 'residentialPowerAnnounce-delete', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(120, 'residentialPowerAnnounce-show', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(121, 'residentialPowerConfirmPayment-view', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(122, 'residentialPowerConfirmPayment-create', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(123, 'residentialPowerConfirmPayment-edit', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(124, 'residentialPowerConfirmPayment-delete', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(125, 'residentialPowerConfirmPayment-show', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(126, 'residentialPowerChkInstall-view', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(127, 'residentialPowerChkInstall-create', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(128, 'residentialPowerChkInstall-edit', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(129, 'residentialPowerChkInstall-delete', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(130, 'residentialPowerChkInstall-show', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(131, 'residentialPowerRegisteredMeter-view', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(132, 'residentialPowerRegisteredMeter-create', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(133, 'residentialPowerRegisteredMeter-edit', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(134, 'residentialPowerRegisteredMeter-delete', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(135, 'residentialPowerRegisteredMeter-show', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(136, 'commercialPower-view', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(137, 'commercialPower-create', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(138, 'commercialPower-edit', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(139, 'commercialPower-delete', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(140, 'commercialPower-show', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(141, 'commercialPowerApplication-view', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(142, 'commercialPowerApplication-create', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(143, 'commercialPowerApplication-edit', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(144, 'commercialPowerApplication-delete', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(145, 'commercialPowerApplication-show', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(146, 'commercialPowerGrdChk-view', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(147, 'commercialPowerGrdChk-create', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(148, 'commercialPowerGrdChk-edit', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(149, 'commercialPowerGrdChk-delete', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(150, 'commercialPowerGrdChk-show', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(151, 'commercialPowerTownshipChkGrd-view', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(152, 'commercialPowerTownshipChkGrd-create', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(153, 'commercialPowerTownshipChkGrd-edit', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(154, 'commercialPowerTownshipChkGrd-delete', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(155, 'commercialPowerTownshipChkGrd-show', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(156, 'commercialPowerDistrictChkGrd-view', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(157, 'commercialPowerDistrictChkGrd-create', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(158, 'commercialPowerDistrictChkGrd-edit', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(159, 'commercialPowerDistrictChkGrd-delete', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(160, 'commercialPowerDistrictChkGrd-show', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(161, 'commercialPowerPending-view', 'admin', '2019-06-18 05:18:02', '2019-06-18 05:18:02'),
(162, 'commercialPowerPending-create', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(163, 'commercialPowerPending-edit', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(164, 'commercialPowerPending-delete', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(165, 'commercialPowerPending-show', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(166, 'commercialPowerReject-view', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(167, 'commercialPowerReject-create', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(168, 'commercialPowerReject-edit', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(169, 'commercialPowerReject-delete', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(170, 'commercialPowerReject-show', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(171, 'commercialPowerAnnounce-view', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(172, 'commercialPowerAnnounce-create', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(173, 'commercialPowerAnnounce-edit', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(174, 'commercialPowerAnnounce-delete', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(175, 'commercialPowerAnnounce-show', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(176, 'commercialPowerConfirmPayment-view', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(177, 'commercialPowerConfirmPayment-create', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(178, 'commercialPowerConfirmPayment-edit', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(179, 'commercialPowerConfirmPayment-delete', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(180, 'commercialPowerConfirmPayment-show', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(181, 'commercialPowerChkInstall-view', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(182, 'commercialPowerChkInstall-create', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(183, 'commercialPowerChkInstall-edit', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(184, 'commercialPowerChkInstall-delete', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(185, 'commercialPowerChkInstall-show', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(186, 'commercialPowerRegisteredMeter-view', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(187, 'commercialPowerRegisteredMeter-create', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(188, 'commercialPowerRegisteredMeter-edit', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(189, 'commercialPowerRegisteredMeter-delete', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(190, 'commercialPowerRegisteredMeter-show', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(191, 'contractor-view', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(192, 'contractor-create', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(193, 'contractor-edit', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(194, 'contractor-delete', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(195, 'contractor-show', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(196, 'contractorApplication-view', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(197, 'contractorApplication-create', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(198, 'contractorApplication-edit', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(199, 'contractorApplication-delete', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(200, 'contractorApplication-show', 'admin', '2019-06-18 05:18:03', '2019-06-18 05:18:03'),
(201, 'contractorGrdChk-view', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(202, 'contractorGrdChk-create', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(203, 'contractorGrdChk-edit', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(204, 'contractorGrdChk-delete', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(205, 'contractorGrdChk-show', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(206, 'contractorTownshipChkGrd-view', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(207, 'contractorTownshipChkGrd-create', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(208, 'contractorTownshipChkGrd-edit', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(209, 'contractorTownshipChkGrd-delete', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(210, 'contractorTownshipChkGrd-show', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(211, 'contractorDistrictChkGrd-view', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(212, 'contractorDistrictChkGrd-create', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(213, 'contractorDistrictChkGrd-edit', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(214, 'contractorDistrictChkGrd-delete', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(215, 'contractorDistrictChkGrd-show', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(216, 'contractorDivStateChkGrd-view', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(217, 'contractorDivStateChkGrd-create', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(218, 'contractorDivStateChkGrd-edit', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(219, 'contractorDivStateChkGrd-delete', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(220, 'contractorDivStateChkGrd-show', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(221, 'contractorPending-view', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(222, 'contractorPending-create', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(223, 'contractorPending-edit', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(224, 'contractorPending-delete', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(225, 'contractorPending-show', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(226, 'contractorReject-view', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(227, 'contractorReject-create', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(228, 'contractorReject-edit', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(229, 'contractorReject-delete', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(230, 'contractorReject-show', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(231, 'contractorAnnounce-view', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(232, 'contractorAnnounce-create', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(233, 'contractorAnnounce-edit', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(234, 'contractorAnnounce-delete', 'admin', '2019-06-18 05:18:04', '2019-06-18 05:18:04'),
(235, 'contractorAnnounce-show', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(236, 'contractorConfirmPayment-view', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(237, 'contractorConfirmPayment-create', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(238, 'contractorConfirmPayment-edit', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(239, 'contractorConfirmPayment-delete', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(240, 'contractorConfirmPayment-show', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(241, 'contractorChkInstall-view', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(242, 'contractorChkInstall-create', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(243, 'contractorChkInstall-edit', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(244, 'contractorChkInstall-delete', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(245, 'contractorChkInstall-show', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(246, 'contractorInstallDone-view', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(247, 'contractorInstallDone-create', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(248, 'contractorInstallDone-edit', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(249, 'contractorInstallDone-delete', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(250, 'contractorInstallDone-show', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(251, 'contractorRegisteredMeter-view', 'admin', '2019-06-18 05:18:05', '2019-06-18 05:18:05'),
(252, 'contractorRegisteredMeter-create', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(253, 'contractorRegisteredMeter-edit', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(254, 'contractorRegisteredMeter-delete', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(255, 'contractorRegisteredMeter-show', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(256, 'transformer-view', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(257, 'transformer-create', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(258, 'transformer-edit', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(259, 'transformer-delete', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(260, 'transformer-show', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(261, 'transformerApplication-view', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(262, 'transformerApplication-create', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(263, 'transformerApplication-edit', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(264, 'transformerApplication-delete', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(265, 'transformerApplication-show', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(266, 'transformerGrdChk-view', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(267, 'transformerGrdChk-create', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(268, 'transformerGrdChk-edit', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(269, 'transformerGrdChk-delete', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(270, 'transformerGrdChk-show', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(271, 'transformerTownshipChkGrd-view', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(272, 'transformerTownshipChkGrd-create', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(273, 'transformerTownshipChkGrd-edit', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(274, 'transformerTownshipChkGrd-delete', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(275, 'transformerTownshipChkGrd-show', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(276, 'transformerDistrictChkGrd-view', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(277, 'transformerDistrictChkGrd-create', 'admin', '2019-06-18 05:18:06', '2019-06-18 05:18:06'),
(278, 'transformerDistrictChkGrd-edit', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(279, 'transformerDistrictChkGrd-delete', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(280, 'transformerDistrictChkGrd-show', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(281, 'transformerDivStateChkGrd-view', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(282, 'transformerDivStateChkGrd-create', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(283, 'transformerDivStateChkGrd-edit', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(284, 'transformerDivStateChkGrd-delete', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(285, 'transformerDivStateChkGrd-show', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(286, 'transformerHeadChkGrd-view', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(287, 'transformerHeadChkGrd-create', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(288, 'transformerHeadChkGrd-edit', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(289, 'transformerHeadChkGrd-delete', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(290, 'transformerHeadChkGrd-show', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(291, 'transformerPending-view', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(292, 'transformerPending-create', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(293, 'transformerPending-edit', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(294, 'transformerPending-delete', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(295, 'transformerPending-show', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(296, 'transformerReject-view', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(297, 'transformerReject-create', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(298, 'transformerReject-edit', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(299, 'transformerReject-delete', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(300, 'transformerReject-show', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(301, 'transformerAnnounce-view', 'admin', '2019-06-18 05:18:07', '2019-06-18 05:18:07'),
(302, 'transformerAnnounce-create', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(303, 'transformerAnnounce-edit', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(304, 'transformerAnnounce-delete', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(305, 'transformerAnnounce-show', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(306, 'transformerConfirmPayment-view', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(307, 'transformerConfirmPayment-create', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(308, 'transformerConfirmPayment-edit', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(309, 'transformerConfirmPayment-delete', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(310, 'transformerConfirmPayment-show', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(311, 'transformerChkInstall-view', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(312, 'transformerChkInstall-create', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(313, 'transformerChkInstall-edit', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(314, 'transformerChkInstall-delete', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(315, 'transformerChkInstall-show', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(316, 'transformerInstallDone-view', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(317, 'transformerInstallDone-create', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(318, 'transformerInstallDone-edit', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(319, 'transformerInstallDone-delete', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(320, 'transformerInstallDone-show', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(321, 'transformerRegisteredMeter-view', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(322, 'transformerRegisteredMeter-create', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(323, 'transformerRegisteredMeter-edit', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(324, 'transformerRegisteredMeter-delete', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(325, 'transformerRegisteredMeter-show', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(326, 'applyingForm-view', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(327, 'applyingForm-create', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(328, 'applyingForm-edit', 'admin', '2019-06-18 05:18:08', '2019-06-18 05:18:08'),
(329, 'applyingForm-delete', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(330, 'applyingForm-show', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(331, 'performingForm-view', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(332, 'performingForm-create', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(333, 'performingForm-edit', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(334, 'performingForm-delete', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(335, 'performingForm-show', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(336, 'rejectForm-view', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(337, 'rejectForm-create', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(338, 'rejectForm-edit', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(339, 'rejectForm-delete', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(340, 'rejectForm-show', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(341, 'pendingForm-view', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(342, 'pendingForm-create', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(343, 'pendingForm-edit', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(344, 'pendingForm-delete', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(345, 'pendingForm-show', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(346, 'registeredForm-view', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(347, 'registeredForm-create', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(348, 'registeredForm-edit', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(349, 'registeredForm-delete', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(350, 'registeredForm-show', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'system', 'admin', '2019-06-18 05:18:09', '2019-06-18 05:18:09'),
(2, 'superadmin', 'admin', '2019-06-18 05:18:10', '2019-06-18 05:18:10'),
(3, 'Admin', 'admin', '2019-06-21 07:08:22', '2019-06-21 07:08:22'),
(4, 'Chief Engineer', 'admin', '2019-06-23 17:48:04', '2019-06-23 17:48:04'),
(5, 'Senior Engineer', 'admin', '2019-06-23 17:48:14', '2019-06-23 17:48:14'),
(6, 'Junior Engineer 1', 'admin', '2019-06-23 17:48:27', '2019-06-23 17:49:32'),
(7, 'Junior Engineer 2', 'admin', '2019-06-23 17:49:43', '2019-06-23 17:49:43'),
(8, 'Junior Engineer 3', 'admin', '2019-06-23 17:49:52', '2019-06-23 17:49:52');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(10, 2),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(31, 2),
(31, 3),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(36, 3),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(45, 2),
(46, 1),
(46, 2),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(50, 2),
(51, 1),
(51, 2),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(55, 2),
(56, 1),
(56, 2),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(65, 2),
(66, 1),
(66, 2),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(70, 2),
(71, 1),
(71, 2),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(75, 2),
(76, 1),
(76, 2),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(80, 2),
(81, 1),
(81, 2),
(81, 3),
(82, 1),
(82, 2),
(83, 1),
(83, 2),
(84, 1),
(84, 2),
(85, 1),
(85, 2),
(86, 1),
(86, 2),
(86, 3),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(90, 2),
(91, 1),
(91, 2),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(95, 2),
(96, 1),
(96, 2),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(100, 2),
(101, 1),
(101, 2),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(105, 2),
(106, 1),
(106, 2),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(110, 2),
(111, 1),
(111, 2),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(115, 2),
(116, 1),
(116, 2),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(120, 2),
(121, 1),
(121, 2),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(125, 2),
(126, 1),
(126, 2),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(130, 2),
(131, 1),
(131, 2),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(135, 2),
(136, 1),
(136, 2),
(136, 3),
(137, 1),
(137, 2),
(138, 1),
(138, 2),
(139, 1),
(139, 2),
(140, 1),
(140, 2),
(141, 1),
(141, 2),
(141, 3),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(145, 2),
(146, 1),
(146, 2),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(150, 2),
(151, 1),
(151, 2),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(155, 2),
(156, 1),
(156, 2),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(160, 2),
(161, 1),
(161, 2),
(162, 1),
(163, 1),
(164, 1),
(165, 1),
(165, 2),
(166, 1),
(166, 2),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(170, 2),
(171, 1),
(171, 2),
(172, 1),
(173, 1),
(174, 1),
(175, 1),
(175, 2),
(176, 1),
(176, 2),
(177, 1),
(178, 1),
(179, 1),
(180, 1),
(180, 2),
(181, 1),
(181, 2),
(182, 1),
(183, 1),
(184, 1),
(185, 1),
(185, 2),
(186, 1),
(186, 2),
(187, 1),
(188, 1),
(189, 1),
(190, 1),
(190, 2),
(191, 1),
(191, 2),
(191, 3),
(192, 1),
(192, 2),
(193, 1),
(193, 2),
(194, 1),
(194, 2),
(195, 1),
(195, 2),
(196, 1),
(196, 2),
(196, 3),
(197, 1),
(198, 1),
(199, 1),
(200, 1),
(200, 2),
(201, 1),
(201, 2),
(202, 1),
(203, 1),
(204, 1),
(205, 1),
(205, 2),
(206, 1),
(206, 2),
(207, 1),
(208, 1),
(209, 1),
(210, 1),
(210, 2),
(211, 1),
(211, 2),
(212, 1),
(213, 1),
(214, 1),
(215, 1),
(215, 2),
(216, 1),
(216, 2),
(217, 1),
(218, 1),
(219, 1),
(220, 1),
(220, 2),
(221, 1),
(221, 2),
(222, 1),
(223, 1),
(224, 1),
(225, 1),
(225, 2),
(226, 1),
(226, 2),
(227, 1),
(228, 1),
(229, 1),
(230, 1),
(230, 2),
(231, 1),
(231, 2),
(232, 1),
(233, 1),
(234, 1),
(235, 1),
(235, 2),
(236, 1),
(236, 2),
(237, 1),
(238, 1),
(239, 1),
(240, 1),
(240, 2),
(241, 1),
(241, 2),
(242, 1),
(243, 1),
(244, 1),
(245, 1),
(245, 2),
(246, 1),
(246, 2),
(247, 1),
(248, 1),
(249, 1),
(250, 1),
(250, 2),
(251, 1),
(251, 2),
(252, 1),
(253, 1),
(254, 1),
(255, 1),
(255, 2),
(256, 1),
(256, 2),
(257, 1),
(257, 2),
(258, 1),
(258, 2),
(259, 1),
(259, 2),
(260, 1),
(260, 2),
(261, 1),
(261, 2),
(262, 1),
(262, 2),
(263, 1),
(263, 2),
(264, 1),
(264, 2),
(265, 1),
(265, 2),
(266, 1),
(266, 2),
(267, 1),
(267, 2),
(268, 1),
(268, 2),
(269, 1),
(269, 2),
(270, 1),
(270, 2),
(271, 1),
(271, 2),
(272, 1),
(272, 2),
(273, 1),
(273, 2),
(274, 1),
(274, 2),
(275, 1),
(275, 2),
(276, 1),
(276, 2),
(277, 1),
(277, 2),
(278, 1),
(278, 2),
(279, 1),
(279, 2),
(280, 1),
(280, 2),
(281, 1),
(281, 2),
(282, 1),
(282, 2),
(283, 1),
(283, 2),
(284, 1),
(284, 2),
(285, 1),
(285, 2),
(286, 1),
(286, 2),
(287, 1),
(287, 2),
(288, 1),
(288, 2),
(289, 1),
(289, 2),
(290, 1),
(290, 2),
(291, 1),
(291, 2),
(292, 1),
(292, 2),
(293, 1),
(293, 2),
(294, 1),
(294, 2),
(295, 1),
(295, 2),
(296, 1),
(296, 2),
(297, 1),
(297, 2),
(298, 1),
(298, 2),
(299, 1),
(299, 2),
(300, 1),
(300, 2),
(301, 1),
(301, 2),
(302, 1),
(302, 2),
(303, 1),
(303, 2),
(304, 1),
(304, 2),
(305, 1),
(305, 2),
(306, 1),
(306, 2),
(307, 1),
(307, 2),
(308, 1),
(308, 2),
(309, 1),
(309, 2),
(310, 1),
(310, 2),
(311, 1),
(311, 2),
(312, 1),
(312, 2),
(313, 1),
(313, 2),
(314, 1),
(314, 2),
(315, 1),
(315, 2),
(316, 1),
(316, 2),
(317, 1),
(317, 2),
(318, 1),
(318, 2),
(319, 1),
(319, 2),
(320, 1),
(320, 2),
(321, 1),
(321, 2),
(322, 1),
(322, 2),
(323, 1),
(323, 2),
(324, 1),
(324, 2),
(325, 1),
(325, 2),
(326, 1),
(326, 2),
(326, 3),
(327, 1),
(328, 1),
(329, 1),
(330, 1),
(330, 2),
(331, 1),
(331, 2),
(331, 3),
(332, 1),
(333, 1),
(334, 1),
(335, 1),
(335, 2),
(336, 1),
(336, 2),
(336, 3),
(337, 1),
(338, 1),
(339, 1),
(340, 1),
(340, 2),
(341, 1),
(341, 2),
(341, 3),
(342, 1),
(343, 1),
(344, 1),
(345, 1),
(345, 2),
(346, 1),
(346, 2),
(346, 3),
(347, 1),
(348, 1),
(349, 1),
(350, 1),
(350, 2);

-- --------------------------------------------------------

--
-- Table structure for table `towns`
--

CREATE TABLE `towns` (
  `id` int(10) UNSIGNED NOT NULL,
  `division_state_id` int(10) UNSIGNED NOT NULL,
  `district_id` int(10) UNSIGNED NOT NULL,
  `township_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `townships`
--

CREATE TABLE `townships` (
  `id` int(10) UNSIGNED NOT NULL,
  `division_state_id` int(10) UNSIGNED NOT NULL,
  `district_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `townships`
--

INSERT INTO `townships` (`id`, `division_state_id`, `district_id`, `name`, `eng`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'လယ်ဝေးမြို့နယ်', 'Lewe', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(2, 1, 1, 'ဇမ္ဗူသီရိမြို့နယ်', 'Zabuthiri', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(3, 1, 1, 'ဒက္ခိဏသီရိမြို့နယ်', 'Dakhina', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(4, 1, 1, 'ဇေယျာသီရိမြို့နယ်', 'Zayarthiri', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(5, 1, 1, 'ပျဥ်းမနားမြို့နယ်', 'Pyinmanar', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(6, 1, 2, 'ဥတ္တရသီရိမြို့နယ်', 'Ottarathiri', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(7, 1, 2, 'ပုပ္ဗသီရိမြို့နယ်', 'Pobathiri', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(8, 3, 7, 'အောင်မြေသာစံမြို့နယ်', 'Aungmyaytharzan', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(9, 3, 7, 'ချမ်းအေးသာစံမြို့နယ်', 'Chanayetharzan', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(10, 3, 7, 'မဟာအောင်မြေမြို့နယ်', 'Maharaungmyay', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(11, 3, 7, 'ချမ်းမြသာစည်မြို့နယ်', 'Chanmyatharzi', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(12, 3, 7, 'ပြည်ကြီးတံခွန်မြို့နယ်', 'Pyigyidagwon', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(13, 2, 3, 'လမ်းမတော်မြို့နယ်', 'Lanmadaw', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(14, 2, 3, 'လသာမြို့နယ်', 'Latha', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(15, 2, 3, 'အရှေ့ပိုင်းခရိုင်ရုံး', 'Eastern Office', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(16, 2, 3, 'သာကေတမြို့နယ်', 'Thakayta', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(17, 2, 3, 'မင်္ဂလာတောင်ညွှန့်မြို့နယ်', 'Mingalartaungnyaunt', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(18, 2, 3, 'ဒဂုံ(မြောက်)မြို့နယ်ရုံး', 'Dagon(North)', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(19, 2, 3, 'တောင်ဥက္ကလာပမြို့နယ်', 'South Okkalarpa', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(20, 2, 3, 'ရန်ကင်းမြို့နယ်', 'Yankin', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(21, 2, 3, 'တာမွေမြို့နယ်', 'Tarmwe', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(22, 2, 3, 'ဒဂုံ(တောင်)မြို့နယ်', 'Dagon(South)', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(23, 2, 3, 'ဗိုလ်တထောင်မြို့နယ်', 'Botataung', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(24, 2, 3, 'ပုစွန်တောင်မြို့နယ်', 'Pazuntaung', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(25, 2, 3, 'ဒေါပုံမြို့နယ်', 'Daw Pon', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(26, 2, 3, 'ရွှေပေါက်ကံမြို့နယ်', 'Shwepaunkkan', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(27, 2, 3, 'မြောက်ဥက္ကလာပမြို့နယ်', 'North Okkalarpa', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(28, 2, 4, 'အနောက်ပိုင်းခရိုင်ရုံး', 'Western Office', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(29, 2, 4, 'ပန်းပဲတန်းမြို့နယ်', 'Babaldan', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(30, 2, 4, 'ဆိပ်ကမ်းမြို့နယ်', 'Satekan', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(31, 2, 4, 'မရမ်းကုန်းမြို့နယ်', 'Mayangone', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(32, 2, 4, 'လှိုင်မြို့နယ်', 'Hlaing', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(33, 2, 4, 'ဒဂုံမြို့နယ်', 'Dagon', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(34, 2, 4, 'ဗဟန်းမြို့နယ်', 'Bahan', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(35, 2, 4, 'ကြည့်မြင့်တိုင်မြို့နယ်', 'Kyimyindine', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(36, 2, 4, 'ကမာရွတ်မြို့နယ်', 'Kamaywut', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(37, 2, 4, 'စမ်းချောင်းမြို့နယ်', 'Sanchaung', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(38, 2, 4, 'အလုံမြို့နယ်', 'Alone', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(39, 2, 4, 'ကျောက်တံတားမြို့နယ်', 'Kyauktadar', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(40, 2, 6, 'မြောက်ပိုင်းခရိုင်ရုံး', 'Northern Office', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(41, 2, 6, 'ရွှေပြည်သာမြို့နယ်', 'Shwepyithar', '2019-03-25 08:35:53', '2019-03-25 08:35:53'),
(42, 2, 6, 'အင်းစိန်မြို့နယ်', 'Insein', '2019-03-25 08:35:53', '2019-03-25 08:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `tsf_infos`
--

CREATE TABLE `tsf_infos` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_form_id` int(10) UNSIGNED NOT NULL,
  `order_list` int(11) DEFAULT NULL,
  `tsf_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tsf_ht_kv` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tsf_lt_kv` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tsf_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ct_ratio_ht` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ct_ratio_lt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `switch_gear` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tsf_mva` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `install_cap` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_cap` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highest_power_amp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highest_power_day` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highest_power_night` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tsf_load` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line_size_length` text COLLATE utf8mb4_unicode_ci,
  `tsf_line_ft_mile_total` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tsf_line_ft_mile_req` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Testing User One', 'user1@mail.com', '2019-06-18 04:30:40', '$2y$10$lJKKMfPlGhieRa/N0nwHduwyNPfQSj493sfUVBsAMQVJvaFh79Aqm', '09987654321', 1, 'bYDXlXNU2dEo3K0vSokCkzspqDwkGsFEODcyY4POjLzTb7EVfbRHZf28eSLY', '2019-06-18 04:30:40', '2019-06-21 03:50:03'),
(2, 'Test One', 'test@test.com', NULL, '$2y$10$IO6Ii6dSu3FUZMNRnfCROemPbN38Did55YhdylW1g2FEFn2WIznrO', NULL, 1, NULL, '2019-06-18 09:11:34', '2019-06-19 09:10:29'),
(3, 'Nyi Nyi Han', 'nyinyi@thenexthop.net', NULL, '$2y$10$5kQCbkv1sqv9srvaCWk05OVdTn7.4VAKxBwOard/r7uYkYyepD5Jy', NULL, 1, 'liZgkNHZDNJVZbj3K9vp8grrgKMuwqa98yfZ38GGGeKfMWXYk886XKcxSEPZ', '2019-06-24 07:15:04', '2019-06-24 07:15:04'),
(4, 'Kyaw Thet Aung', 'kyawthetaung3519@gmail.com', NULL, '$2y$10$oUoP5RUuqZk81h/xNgVJ5ugVdRmJpd6IYST2z4NSTsHYptAU1ipE6', NULL, 1, '9cdMsBroNpncHFVMKz68SPmRzjl4mVhSXhC2miCCx5zQRLNM3jMasNDHisbH', '2019-06-24 08:44:40', '2019-06-24 08:44:40'),
(5, 'U Mg Mg', 'mgmg@mail.com', NULL, '$2y$10$GrsvDtwpLOnC2XM9e8lUHOGm7xmttIpWqs/QHbRfBoXhVxSArsnee', NULL, 1, 'ClCtdQn1hGXXvgaEddYfQA4ztN2MIF95rZQ0eEWzX5kYUvNPdnM8nslrsvNn', '2019-06-26 17:11:10', '2019-06-26 17:11:10'),
(6, 'khin aye myint', 'khin@thenexthop.net', NULL, '$2y$10$I7yppPKu8rDp5aKb9s7WjOv5GkFnGvtRbdFlt.w8l2DjLGg8qjlt.', NULL, 1, 'CQB2xSIjpnIWFzx3Ouitns69wlLBwK27sYxicQJuCqzuOP6KxexDyAdQ78DR', '2019-07-08 04:09:26', '2019-07-08 04:09:26'),
(7, 'aungwaisoe', 'aung@gmail.com', NULL, '$2y$10$irtkQQ7vpBElXj8VmOrF.exBp.wfubLtQ8/emYlFTMXsfu/sDi8CO', NULL, 1, '5IveUaRpHCbNiaDrtTyA7k5SLkPJORcrFsn40rk5Dn8mCCG4mCzEl9orAMtB', '2019-07-08 07:55:41', '2019-07-08 07:55:41'),
(8, 'MGMG', 'mgmg@gmail.com', NULL, '$2y$10$PSkT/JAMQbdGZ1LDXwffgOR32NHl29dgGD.HfZh1ejeG.2qfH4jDe', NULL, 1, 'jxWA0eXhG8z1GYZzD4GYgh88rBdEXcH75uX9fxe1FN9L25cnTZY7Je1bs0d6', '2019-10-09 09:36:44', '2019-10-09 09:36:44'),
(9, 'haha', 'haha@mail.com', NULL, '$2y$10$HB0lcEzuSDuZ/cB7UsEBcOqlmI6UCecZJKVi.p0U5Nj9hyPHCXbEu', NULL, 1, 'UZOY1LKxAAFeAaX4eKnIoxQDb8Ha0c0kHvB8wCgPC8SUY9ZlKYbHxf3f0dhm', '2019-10-09 09:38:36', '2019-10-09 09:38:36'),
(10, 'khin aye myint', 'khinayemyint@thenexthop.net', NULL, '$2y$10$eobdvva5vFjkj46wMFfVlek83lIN5oOynvipwELKSfByIyhJbsWGG', NULL, 1, '5yOgiG2JJDQvXmrR3we25xjeGgJtxegcZhNBVignMXHBNG5dxocos3ZMTr79', '2019-10-10 10:08:58', '2019-10-10 10:08:58'),
(11, 'TESTER', 'tester@mail.com', NULL, '$2y$10$SSb9gn06z6iemgczCXclouAzxGjvH.X2DMVPJRSB2WgfxM.gXqGfa', NULL, 1, 'WYeSRVMZwmbwIcVBXhUqAJWdeENdbcDwu0liksFk4NyVTDFZbB7zh7pepDPW', '2019-10-18 20:29:42', '2019-10-18 20:29:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_actions`
--
ALTER TABLE `admin_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_actions_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `application_files`
--
ALTER TABLE `application_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_files_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `application_forms`
--
ALTER TABLE `application_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_form_contractors`
--
ALTER TABLE `application_form_contractors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_form_contractors_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_division_state_id_foreign` (`division_state_id`);

--
-- Indexes for table `division_states`
--
ALTER TABLE `division_states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form66s`
--
ALTER TABLE `form66s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form66s_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `form138s`
--
ALTER TABLE `form138s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form138s_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `form_drafts`
--
ALTER TABLE `form_drafts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_ei_chks`
--
ALTER TABLE `form_ei_chks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_ei_chks_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `form_process_actions`
--
ALTER TABLE `form_process_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_process_actions_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `form_process_remarks`
--
ALTER TABLE `form_process_remarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_process_remarks_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `form_routines`
--
ALTER TABLE `form_routines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_routines_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `form_surveys`
--
ALTER TABLE `form_surveys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_surveys_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `form_survey_transformers`
--
ALTER TABLE `form_survey_transformers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_survey_transformers_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `initial_costs`
--
ALTER TABLE `initial_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `mail_tbls`
--
ALTER TABLE `mail_tbls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mail_tbls_application_form_id_foreign` (`application_form_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_application_form_id_foreign` (`application_form_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `towns`
--
ALTER TABLE `towns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `towns_division_state_id_foreign` (`division_state_id`),
  ADD KEY `towns_district_id_foreign` (`district_id`),
  ADD KEY `towns_township_id_foreign` (`township_id`);

--
-- Indexes for table `townships`
--
ALTER TABLE `townships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `townships_division_state_id_foreign` (`division_state_id`),
  ADD KEY `townships_district_id_foreign` (`district_id`);

--
-- Indexes for table `tsf_infos`
--
ALTER TABLE `tsf_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tsf_infos_application_form_id_foreign` (`application_form_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_actions`
--
ALTER TABLE `admin_actions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_files`
--
ALTER TABLE `application_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_forms`
--
ALTER TABLE `application_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_form_contractors`
--
ALTER TABLE `application_form_contractors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `division_states`
--
ALTER TABLE `division_states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `form66s`
--
ALTER TABLE `form66s`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form138s`
--
ALTER TABLE `form138s`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_drafts`
--
ALTER TABLE `form_drafts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_ei_chks`
--
ALTER TABLE `form_ei_chks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_process_actions`
--
ALTER TABLE `form_process_actions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_process_remarks`
--
ALTER TABLE `form_process_remarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_routines`
--
ALTER TABLE `form_routines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_surveys`
--
ALTER TABLE `form_surveys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_survey_transformers`
--
ALTER TABLE `form_survey_transformers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `initial_costs`
--
ALTER TABLE `initial_costs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_tbls`
--
ALTER TABLE `mail_tbls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `towns`
--
ALTER TABLE `towns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `townships`
--
ALTER TABLE `townships`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tsf_infos`
--
ALTER TABLE `tsf_infos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_actions`
--
ALTER TABLE `admin_actions`
  ADD CONSTRAINT `admin_actions_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `application_files`
--
ALTER TABLE `application_files`
  ADD CONSTRAINT `application_files_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `application_form_contractors`
--
ALTER TABLE `application_form_contractors`
  ADD CONSTRAINT `application_form_contractors_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_division_state_id_foreign` FOREIGN KEY (`division_state_id`) REFERENCES `division_states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form66s`
--
ALTER TABLE `form66s`
  ADD CONSTRAINT `form66s_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form138s`
--
ALTER TABLE `form138s`
  ADD CONSTRAINT `form138s_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_ei_chks`
--
ALTER TABLE `form_ei_chks`
  ADD CONSTRAINT `form_ei_chks_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_process_actions`
--
ALTER TABLE `form_process_actions`
  ADD CONSTRAINT `form_process_actions_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_process_remarks`
--
ALTER TABLE `form_process_remarks`
  ADD CONSTRAINT `form_process_remarks_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_routines`
--
ALTER TABLE `form_routines`
  ADD CONSTRAINT `form_routines_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_surveys`
--
ALTER TABLE `form_surveys`
  ADD CONSTRAINT `form_surveys_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_survey_transformers`
--
ALTER TABLE `form_survey_transformers`
  ADD CONSTRAINT `form_survey_transformers_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mail_tbls`
--
ALTER TABLE `mail_tbls`
  ADD CONSTRAINT `mail_tbls_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `towns`
--
ALTER TABLE `towns`
  ADD CONSTRAINT `towns_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `towns_division_state_id_foreign` FOREIGN KEY (`division_state_id`) REFERENCES `division_states` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `towns_township_id_foreign` FOREIGN KEY (`township_id`) REFERENCES `townships` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `townships`
--
ALTER TABLE `townships`
  ADD CONSTRAINT `townships_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `townships_division_state_id_foreign` FOREIGN KEY (`division_state_id`) REFERENCES `division_states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tsf_infos`
--
ALTER TABLE `tsf_infos`
  ADD CONSTRAINT `tsf_infos_application_form_id_foreign` FOREIGN KEY (`application_form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
