/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `poll_voting_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poll_voting_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(191) NOT NULL,
  `polling_id` varchar(191) NOT NULL,
  `selected_option` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `polling_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `polling_questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(191) NOT NULL,
  `options` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `notify_employees` enum('0','1') NOT NULL DEFAULT '0',
  `anonymous_poll` enum('0','1') NOT NULL DEFAULT '0',
  `poll_author_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `user_code` text DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `email` varchar(191) NOT NULL,
  `active` smallint(6) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `avatar` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` smallint(6) NOT NULL DEFAULT 0,
  `is_onboarded` smallint(6) NOT NULL DEFAULT 1,
  `onboard_type` text NOT NULL DEFAULT 'normal',
  `is_default_password_updated` text NOT NULL DEFAULT '1',
  `org_role` text NOT NULL DEFAULT '5',
  `is_ssa` smallint(6) NOT NULL DEFAULT 0,
  `can_login` smallint(6) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_announcement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_announcement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ann_author_id` int(11) NOT NULL,
  `title_data` text DEFAULT NULL,
  `details_data` text DEFAULT NULL,
  `is_publish` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `notify_employees` enum('0','1') DEFAULT '0',
  `require_acknowledgement` enum('0','1') DEFAULT '0',
  `hide_after` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_asset_inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_asset_inventories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `asset_name` text DEFAULT NULL,
  `asset_type` text DEFAULT NULL,
  `asset_status` text DEFAULT NULL,
  `serial_number` text DEFAULT NULL,
  `warranty` text DEFAULT NULL,
  `vendor` text DEFAULT NULL,
  `assignee` text DEFAULT NULL,
  `assigned_date` date DEFAULT NULL,
  `invoice` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_banks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(191) NOT NULL,
  `min_length` varchar(191) NOT NULL,
  `max_length` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_bloodgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_bloodgroup` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vmt_bloodgroup_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_client_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_client_master` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_code` text DEFAULT NULL,
  `client_name` text DEFAULT NULL,
  `client_logo` varchar(191) NOT NULL,
  `address` text DEFAULT NULL,
  `contract_start_date` date DEFAULT NULL,
  `contract_end_date` date DEFAULT NULL,
  `cin_number` text DEFAULT NULL,
  `company_tan` text DEFAULT NULL,
  `company_pan` text DEFAULT NULL,
  `gst_no` text DEFAULT NULL,
  `epf_reg_number` text DEFAULT NULL,
  `esic_reg_number` text DEFAULT NULL,
  `prof_tax_reg_number` text DEFAULT NULL,
  `lwf_reg_number` text DEFAULT NULL,
  `authorised_person_name` text DEFAULT NULL,
  `authorised_person_designation` text DEFAULT NULL,
  `authorised_person_contact_number` text DEFAULT NULL,
  `authorised_person_contact_email` text DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `doc_uploads` text DEFAULT NULL,
  `product` text DEFAULT NULL,
  `subscription_type` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_config_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_config_master` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `config_name` text NOT NULL,
  `config_value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_config_pms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_config_pms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(191) NOT NULL,
  `can_show_overallscorecard_in_selfappraisal_dashboard` text NOT NULL DEFAULT 'true',
  `can_show_overallscorecard_in_reviewpage` text NOT NULL DEFAULT 'true',
  `can_show_ratingcard_in_reviewpage` text NOT NULL DEFAULT 'true',
  `calendar_type` text DEFAULT NULL,
  `year` text DEFAULT NULL,
  `frequency` text DEFAULT NULL,
  `assignment_period` text DEFAULT NULL,
  `selected_columns` text NOT NULL,
  `selected_head` text NOT NULL,
  `column_header` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `selected_reviewlevel` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_country` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(191) NOT NULL,
  `country_code` varchar(191) NOT NULL,
  `dialing_code` varchar(191) NOT NULL,
  `currency_name` varchar(191) DEFAULT NULL,
  `currency_code` varchar(191) DEFAULT NULL,
  `timezone` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_dashboard_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_dashboard_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `post_image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_department` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `is_active` smallint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_actions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action_type` varchar(191) DEFAULT NULL,
  `action_message` varchar(191) DEFAULT NULL,
  `action_status` varchar(191) DEFAULT NULL,
  `trigger_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_attendance` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(191) NOT NULL,
  `vmt_employee_workshift_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `checkin_time` time DEFAULT NULL,
  `checkout_time` time DEFAULT NULL,
  `shift_type` varchar(191) DEFAULT NULL,
  `leave_type_id` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `work_mode` text NOT NULL DEFAULT 'office',
  `leave_comments` text DEFAULT NULL,
  `selfie_checkin` text DEFAULT NULL,
  `selfie_checkout` text DEFAULT NULL,
  `checkin_comments` text DEFAULT NULL,
  `checkout_comments` text DEFAULT NULL,
  `attendance_mode_checkin` text NOT NULL,
  `attendance_mode_checkout` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_attendance_regularizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_attendance_regularizations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `user_time` time DEFAULT NULL,
  `regularization_type` text DEFAULT NULL,
  `regularize_time` time DEFAULT NULL,
  `reason_type` text NOT NULL,
  `custom_reason` text NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewer_comments` text DEFAULT NULL,
  `reviewer_reviewed_date` timestamp NULL DEFAULT NULL,
  `status` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_compensatory_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_compensatory_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `basic` varchar(191) NOT NULL,
  `hra` varchar(191) NOT NULL,
  `Statutory_bonus` varchar(191) NOT NULL,
  `child_education_allowance` varchar(191) NOT NULL,
  `food_coupon` varchar(191) NOT NULL,
  `lta` varchar(191) NOT NULL,
  `transport_allowance` text DEFAULT NULL,
  `medical_allowance` text DEFAULT NULL,
  `education_allowance` text DEFAULT NULL,
  `special_allowance` varchar(191) NOT NULL,
  `other_allowance` varchar(191) NOT NULL,
  `gross` varchar(191) NOT NULL,
  `epf_employer_contribution` varchar(191) NOT NULL,
  `esic_employer_contribution` varchar(191) NOT NULL,
  `insurance` varchar(191) NOT NULL,
  `graduity` varchar(191) NOT NULL,
  `cic` varchar(191) NOT NULL,
  `epf_employee` varchar(191) NOT NULL,
  `esic_employee` varchar(191) NOT NULL,
  `professional_tax` varchar(191) NOT NULL,
  `labour_welfare_fund` varchar(191) NOT NULL,
  `net_income` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_compensatory_leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_compensatory_leaves` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_leave_id` text NOT NULL,
  `employee_attendance_id` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `dol` date DEFAULT NULL,
  `location` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pan_number` text DEFAULT NULL,
  `dl_no` text NOT NULL DEFAULT '',
  `pan_ack` text DEFAULT NULL,
  `aadhar_number` text DEFAULT NULL,
  `marital_status` text DEFAULT NULL,
  `mobile_number` text DEFAULT NULL,
  `bank_id` text DEFAULT NULL,
  `bank_ifsc_code` text DEFAULT NULL,
  `bank_account_number` text DEFAULT NULL,
  `current_address_line_1` text NOT NULL DEFAULT '',
  `current_address_line_2` text NOT NULL DEFAULT '',
  `current_country_id` text NOT NULL DEFAULT '',
  `current_state_id` text NOT NULL DEFAULT '',
  `permanent_address_line_1` text NOT NULL DEFAULT '',
  `permanent_address_line_2` text NOT NULL DEFAULT '',
  `permanent_country_id` text NOT NULL DEFAULT '',
  `permanent_state_id` text NOT NULL DEFAULT '',
  `current_city` text NOT NULL DEFAULT '',
  `permanent_city` text NOT NULL DEFAULT '',
  `current_pincode` text NOT NULL DEFAULT '0',
  `permanent_pincode` text NOT NULL DEFAULT '0',
  `present_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `aadhar_card_file` text DEFAULT NULL,
  `aadhar_card_backend_file` text DEFAULT NULL,
  `pan_card_file` text DEFAULT NULL,
  `passport_file` text DEFAULT NULL,
  `voters_id_file` text DEFAULT NULL,
  `dl_file` text DEFAULT NULL,
  `education_certificate_file` text DEFAULT NULL,
  `reliving_letter_file` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `blood_group_id` text DEFAULT NULL,
  `physically_challenged` text NOT NULL DEFAULT 'no',
  `no_of_children` text DEFAULT NULL,
  `religion` text DEFAULT NULL,
  `nationality` text DEFAULT NULL,
  `passport_date` date DEFAULT NULL,
  `passport_number` text DEFAULT NULL,
  `docs_reviewed` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `doc_url` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_emergency_contact_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_emergency_contact_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL DEFAULT '',
  `relationship` text NOT NULL DEFAULT '',
  `phone_number_1` text NOT NULL DEFAULT '',
  `phone_number_2` text NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_experiences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_experiences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(191) NOT NULL,
  `user_id` varchar(191) NOT NULL,
  `company_name` varchar(191) NOT NULL,
  `location` varchar(191) NOT NULL,
  `job_position` varchar(191) NOT NULL,
  `period_from` date NOT NULL,
  `period_to` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_family_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_family_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL DEFAULT '',
  `gender` text NOT NULL DEFAULT '',
  `relationship` text NOT NULL DEFAULT '',
  `dob` date DEFAULT NULL,
  `wedding_date` date NOT NULL,
  `phone_number` text NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_hierarchies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_hierarchies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `child_count` smallint(6) NOT NULL,
  `child_nodes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_leaves` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `leave_type_id` int(11) DEFAULT NULL,
  `leaverequest_date` timestamp NULL DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `total_leave_datetime` text DEFAULT NULL,
  `leave_reason` text DEFAULT NULL,
  `reviewer_user_id` int(11) DEFAULT NULL,
  `reviewed_date` timestamp NULL DEFAULT NULL,
  `notifications_users_id` text DEFAULT NULL,
  `reviewer_comments` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_revoked` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_office_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_office_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL,
  `department_id` text DEFAULT NULL,
  `process` text DEFAULT NULL,
  `designation` text DEFAULT NULL,
  `cost_center` text DEFAULT NULL,
  `confirmation_period` text DEFAULT NULL,
  `holiday_location` text DEFAULT NULL,
  `l1_manager_code` text DEFAULT NULL,
  `l1_manager_designation` text DEFAULT NULL,
  `l1_manager_name` text DEFAULT NULL,
  `work_location` text DEFAULT NULL,
  `officical_mail` text DEFAULT NULL,
  `official_mobile` text DEFAULT NULL,
  `emp_notice` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `probation_period` varchar(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_payslip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_payslip` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `EMP_NO` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `EMP_NAME` text DEFAULT NULL,
  `Gender` text DEFAULT NULL,
  `DESIGNATION` text DEFAULT NULL,
  `DEPARTMENT` text DEFAULT NULL,
  `DOJ` date DEFAULT NULL,
  `LOCATION` text DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Father_Name` text DEFAULT NULL,
  `PAN_Number` text DEFAULT NULL,
  `Aadhar_Number` text DEFAULT NULL,
  `UAN` text DEFAULT NULL,
  `EPF_Number` text DEFAULT NULL,
  `ESIC_Number` text DEFAULT NULL,
  `Bank_Name` text DEFAULT NULL,
  `Account_Number` text DEFAULT NULL,
  `Bank_IFSC_Code` text DEFAULT NULL,
  `PAYROLL_MONTH` date DEFAULT NULL,
  `BASIC` text DEFAULT NULL,
  `HRA` text DEFAULT NULL,
  `CHILD_EDU_ALLOWANCE` text DEFAULT NULL,
  `SPL_ALW` text DEFAULT NULL,
  `TOTAL_FIXED_GROSS` text DEFAULT NULL,
  `MONTH_DAYS` text DEFAULT NULL,
  `Worked_Days` text DEFAULT NULL,
  `Arrears_Days` text DEFAULT NULL,
  `LOP` text DEFAULT NULL,
  `Earned_BASIC` text DEFAULT NULL,
  `BASIC_ARREAR` text DEFAULT NULL,
  `Earned_HRA` text DEFAULT NULL,
  `HRA_ARREAR` text DEFAULT NULL,
  `Earned_CHILD_EDU_ALLOWANCE` text DEFAULT NULL,
  `CHILD_EDU_ALLOWANCE_ARREAR` text DEFAULT NULL,
  `Earned_SPL_ALW` text DEFAULT NULL,
  `SPL_ALW_ARREAR` text DEFAULT NULL,
  `Overtime` text DEFAULT NULL,
  `TOTAL_EARNED_GROSS` text DEFAULT NULL,
  `PF_WAGES` text DEFAULT NULL,
  `PF_WAGES_ARREAR_EPFR` text DEFAULT NULL,
  `EPFR` text DEFAULT NULL,
  `EPFR_ARREAR` text DEFAULT NULL,
  `EDLI_CHARGES` text DEFAULT NULL,
  `EDLI_CHARGES_ARREARS` text DEFAULT NULL,
  `PF_ADMIN_CHARGES` text DEFAULT NULL,
  `PF_ADMIN_CHARGES_ARREARS` text DEFAULT NULL,
  `EMPLOYER_ESI` text DEFAULT NULL,
  `Employer_LWF` text DEFAULT NULL,
  `CTC` text DEFAULT NULL,
  `EPF_EE` text DEFAULT NULL,
  `EPF_EE_ARREAR` text DEFAULT NULL,
  `EMPLOYEE_ESIC` text DEFAULT NULL,
  `PROF_TAX` text DEFAULT NULL,
  `income_tax` text DEFAULT NULL,
  `SAL_ADV` text DEFAULT NULL,
  `CANTEEN_DEDN` text DEFAULT NULL,
  `OTHER_DEDUC` text DEFAULT NULL,
  `LWF` text DEFAULT NULL,
  `TOTAL_DEDUCTIONS` text DEFAULT NULL,
  `NET_TAKE_HOME` text DEFAULT NULL,
  `Rupees` text DEFAULT NULL,
  `EL_Opn_Bal` text DEFAULT NULL,
  `Availed_EL` text DEFAULT NULL,
  `Balance_EL` text DEFAULT NULL,
  `SL_Opn_Bal` text DEFAULT NULL,
  `Availed_SL` text DEFAULT NULL,
  `Balance_SL` text DEFAULT NULL,
  `Rename` text DEFAULT NULL,
  `Email` text DEFAULT NULL,
  `Greetings` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stats_bonus` text NOT NULL,
  `earned_stats_bonus` text NOT NULL,
  `earned_stats_arrear` text NOT NULL,
  `travel_conveyance` text NOT NULL DEFAULT '0',
  `other_earnings` text NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_pms_goals_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_pms_goals_table` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `self_kpi_review` text DEFAULT NULL,
  `self_kpi_percentage` text DEFAULT NULL,
  `self_kpi_comments` text DEFAULT NULL,
  `manager_kpi_review` text DEFAULT NULL,
  `manager_kpi_percentage` text DEFAULT NULL,
  `manager_kpi_comments` text DEFAULT NULL,
  `hr_kpi_review` text DEFAULT NULL,
  `hr_kpi_percentage` text DEFAULT NULL,
  `hr_kpi_comments` text DEFAULT NULL,
  `kpi_table_id` text DEFAULT NULL,
  `assignment_period` text DEFAULT NULL,
  `coverage` text DEFAULT NULL,
  `reviewer_id` text DEFAULT NULL,
  `employee_id` text DEFAULT NULL,
  `mail_link` text DEFAULT NULL,
  `author_id` text DEFAULT NULL,
  `employee_kpi_status` varchar(255) DEFAULT NULL,
  `is_employee_submitted` tinyint(4) DEFAULT NULL,
  `is_employee_accepted` tinyint(4) DEFAULT NULL,
  `is_manager_submitted` tinyint(4) DEFAULT NULL,
  `is_manager_approved` tinyint(255) DEFAULT NULL,
  `is_hr_submitted` varchar(255) DEFAULT NULL,
  `appraiser_comment` text DEFAULT NULL,
  `employee_rejection_comments` text DEFAULT NULL,
  `manager_rejection_comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_reimbursements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_reimbursements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reimbursement_type_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user_comments` text NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewed_date` datetime NOT NULL,
  `status` text NOT NULL,
  `reviewer_comments` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_statutory_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_statutory_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` text NOT NULL,
  `uan_number` text DEFAULT NULL,
  `epf_number` text NOT NULL DEFAULT '0',
  `esic_number` text NOT NULL DEFAULT '0',
  `pf_applicable` text NOT NULL,
  `esic_applicable` text NOT NULL,
  `ptax_location_state_id` text NOT NULL,
  `tax_regime` text NOT NULL,
  `lwf_location_state_id` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `epf_abry_eligible` text NOT NULL,
  `eps_pension_eligible` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_employee_workshifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_employee_workshifts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `work_shift_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_client_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_client_master` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `short_name` text DEFAULT NULL,
  `login_instruction` text DEFAULT NULL,
  `client_logo` text DEFAULT NULL,
  `background_img` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_general_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_general_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `workflow_component` text DEFAULT NULL,
  `associate_wise_template` text DEFAULT NULL,
  `kra_competency` text DEFAULT NULL,
  `increment_percentage` text DEFAULT NULL,
  `report_component` text DEFAULT NULL,
  `rating_preference` text DEFAULT NULL,
  `annual_score_calculation` text DEFAULT NULL,
  `show_employee_review_rating` text DEFAULT NULL,
  `employee_review_components` text DEFAULT NULL,
  `percentage_components` text DEFAULT NULL,
  `percentage_groupwise` text DEFAULT NULL,
  `finalscore_calculation_method` text DEFAULT NULL,
  `achievement_based_rating` text DEFAULT NULL,
  `show_all_managers_to_employee` text DEFAULT NULL,
  `show_rated_managers` text DEFAULT NULL,
  `rating_period_based` text DEFAULT NULL,
  `rating_component` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_holidays` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `holiday_name` text DEFAULT NULL,
  `holiday_date` datetime DEFAULT NULL,
  `holiday_description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_kpi_form_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_kpi_form_table` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `dimension` text NOT NULL,
  `kpi` text NOT NULL,
  `operational_definition` text NOT NULL,
  `measure` text NOT NULL,
  `frequency` text NOT NULL,
  `target` text NOT NULL,
  `stretch_target` text NOT NULL,
  `source` text NOT NULL,
  `kpi_weightage` text NOT NULL,
  `author_id` varchar(191) NOT NULL,
  `author_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_kpi_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_kpi_table` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kpi_rows` text DEFAULT NULL,
  `author_id` text DEFAULT NULL,
  `author_name` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_leavepolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_leavepolicy` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `leave_policy_name` text NOT NULL,
  `is_active` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_leavepolicy_holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_leavepolicy_holidays` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `leavepolicy_id` text NOT NULL,
  `holiday_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_leaves` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `leave_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `days_annual` text DEFAULT NULL,
  `days_monthly` text DEFAULT NULL,
  `days_restricted` text DEFAULT NULL,
  `is_finite` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_local_conveyance_vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_local_conveyance_vehicles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_marital_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_marital_status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `document_name` text NOT NULL,
  `is_mandatory` text NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_org_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_org_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text DEFAULT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_performance_apraisal_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_performance_apraisal_questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dimension` text DEFAULT NULL,
  `kpi` text DEFAULT NULL,
  `operational_definition` text DEFAULT NULL,
  `measure` text DEFAULT NULL,
  `frequency` text DEFAULT NULL,
  `target` text DEFAULT NULL,
  `stretch_target` text DEFAULT NULL,
  `source` text DEFAULT NULL,
  `kpi_weightage` text DEFAULT NULL,
  `author_id` text DEFAULT NULL,
  `author_name` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_pms_kpiform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_pms_kpiform` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_name` text NOT NULL,
  `available_columns` text DEFAULT NULL,
  `author_id` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_pms_kpiform_assigned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_pms_kpiform_assigned` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vmt_pms_kpiform_id` text NOT NULL,
  `assignee_id` text NOT NULL,
  `reviewer_id` text NOT NULL,
  `assigner_id` text NOT NULL,
  `calendar_type` text NOT NULL,
  `year` text NOT NULL,
  `frequency` text NOT NULL,
  `assignment_period` text NOT NULL,
  `department_id` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_pms_kpiform_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_pms_kpiform_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vmt_pms_kpiform_id` text NOT NULL,
  `dimension` text DEFAULT NULL,
  `kpi` text DEFAULT NULL,
  `operational_definition` text DEFAULT NULL,
  `measure` text DEFAULT NULL,
  `frequency` text DEFAULT NULL,
  `target` text DEFAULT NULL,
  `stretch_target` text DEFAULT NULL,
  `source` text DEFAULT NULL,
  `kpi_weightage` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_pms_kpiform_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_pms_kpiform_reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vmt_pms_kpiform_assigned_id` text NOT NULL,
  `assignee_kpi_review` text DEFAULT NULL,
  `assignee_kpi_percentage` text DEFAULT NULL,
  `assignee_kpi_comments` text DEFAULT NULL,
  `reviewer_kpi_review` text DEFAULT NULL,
  `reviewer_kpi_percentage` text DEFAULT NULL,
  `reviewer_kpi_comments` text DEFAULT NULL,
  `reviewer_appraisal_comments` text DEFAULT NULL,
  `assigner_kpi_review` text DEFAULT NULL,
  `assigner_kpi_percentage` text DEFAULT NULL,
  `assigner_kpi_comments` text DEFAULT NULL,
  `assignee_kpi_status` text DEFAULT NULL,
  `is_assignee_submitted` text DEFAULT NULL,
  `is_assignee_accepted` text DEFAULT NULL,
  `reviewer_kpi_status` text DEFAULT NULL,
  `is_reviewer_submitted` text DEFAULT NULL,
  `is_reviewer_accepted` text DEFAULT NULL,
  `assignee_rejection_comments` text DEFAULT NULL,
  `reviewer_rejection_comments` text DEFAULT NULL,
  `overall_score` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assignee_id` bigint(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_pms_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_pms_rating` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `score_range` text DEFAULT NULL,
  `performance_rating` text DEFAULT NULL,
  `ranking` text DEFAULT NULL,
  `action` text DEFAULT NULL,
  `sort_order` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_praise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_praise` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `praise_data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `praise_author_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_process` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_reimbursements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_reimbursements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reimbursement_type` text NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_reviewforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_reviewforms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `questions` varchar(191) NOT NULL,
  `author_id` int(11) NOT NULL,
  `author_name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_reviewquestions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_reviewquestions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `option_1` varchar(191) NOT NULL,
  `option_2` varchar(191) DEFAULT NULL,
  `option_3` varchar(191) DEFAULT NULL,
  `option_4` varchar(191) DEFAULT NULL,
  `option_5` varchar(191) DEFAULT NULL,
  `answer` varchar(191) NOT NULL,
  `author_id` int(11) NOT NULL,
  `author_name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_reviewuserforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_reviewuserforms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_staff_attenndance_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_staff_attenndance_device` (
  `id` int(11) NOT NULL,
  `att_server` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `table_name` varchar(30) DEFAULT NULL,
  `device_log_Id` varchar(50) DEFAULT NULL,
  `device_Id` varchar(50) DEFAULT NULL,
  `user_Id` varchar(50) DEFAULT NULL,
  `direction` varchar(10) NOT NULL DEFAULT 'in',
  `verification_mode` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_states` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` varchar(191) NOT NULL,
  `country_code` varchar(191) NOT NULL,
  `state_name` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vmt_work_shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vmt_work_shifts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `shift_type` text DEFAULT NULL,
  `shift_start_time` time DEFAULT NULL,
  `shift_end_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` VALUES (3,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` VALUES (4,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` VALUES (5,'2022_05_10_023444_create_permission_tables',1);
INSERT INTO `migrations` VALUES (6,'2022_05_18_123444_create_vmt_360_questions_table',2);
INSERT INTO `migrations` VALUES (7,'2022_05_20_123444_create_vmt_360_forms_table',3);
INSERT INTO `migrations` VALUES (8,'2022_05_22_123444_create_vmt_360_user_forms_table',4);
INSERT INTO `migrations` VALUES (9,'2022_05_24_123444_create_vmt_360_employee_hierarchy_table',5);
INSERT INTO `migrations` VALUES (10,'2022_05_31_100000_create_vmt_general_settings_table',6);
INSERT INTO `migrations` VALUES (11,'2022_06_05_123456_create_vmt_employee_payslip_table',7);
INSERT INTO `migrations` VALUES (12,'2022_06_07_123456_create_vmt_client_master_table',8);
INSERT INTO `migrations` VALUES (13,'2022_06_08_123456_create_vmt_employees_table',9);
INSERT INTO `migrations` VALUES (14,'2022_06_13_111222_create_vmt_performance_apraisal_questions_table',10);
INSERT INTO `migrations` VALUES (15,'2022_06_22_123123_create_vmt_employee_office_details_table',11);
INSERT INTO `migrations` VALUES (16,'2022_06_22_125125_create_vmt_client_master_table',11);
INSERT INTO `migrations` VALUES (17,'2022_06_26_121212_create_vmt_kpi_table',12);
INSERT INTO `migrations` VALUES (18,'2022_06_27_022837_add_userid_to_vmt_employee_details_table',12);
INSERT INTO `migrations` VALUES (19,'2022_06_27_121212_create_vmt_employee_pms_goals_table',12);
INSERT INTO `migrations` VALUES (20,'2022_06_28_150516_add_self_review_to_vmt_employee_pms_goals_table_table',12);
INSERT INTO `migrations` VALUES (21,'2022_07_01_032937_add_manager_emp_id_to_vmt_employee_details_table',13);
INSERT INTO `migrations` VALUES (22,'2022_07_02_061836_change_vmt_employee_details_table_column',14);
INSERT INTO `migrations` VALUES (24,'2022_07_03_224136_create_vmt_leaves_table',15);
INSERT INTO `migrations` VALUES (25,'2022_07_03_224453_create_vmt_employee_actions_table',15);
INSERT INTO `migrations` VALUES (26,'2022_07_04_072245_add_dummy_data_to_vmt_performance_apraisal_questions_table',16);
INSERT INTO `migrations` VALUES (27,'2022_07_05_041200_add_files_column_to_vmt_employee_details_table',17);
INSERT INTO `migrations` VALUES (28,'2014_10_12_000000_create_countries_list_table',18);
INSERT INTO `migrations` VALUES (29,'2014_10_12_000000_create_state_table',18);
INSERT INTO `migrations` VALUES (30,'2014_10_12_000000_create_bank_list_table',19);
INSERT INTO `migrations` VALUES (31,'2014_10_12_000000_create_vmt_employee_compensatory_details_table',20);
INSERT INTO `migrations` VALUES (32,'2014_10_12_000000_create_vmt_employee_experience_table',21);
INSERT INTO `migrations` VALUES (33,'2014_10_12_000000_create_poll_voting_details_table',22);
INSERT INTO `migrations` VALUES (34,'2014_10_12_000000_create_polling_questions_table',22);
INSERT INTO `migrations` VALUES (35,'2022_07_20_073139_create_notifications_table',22);
INSERT INTO `migrations` VALUES (36,'2022_07_20_075344_create_vmt_holidays_table',22);
INSERT INTO `migrations` VALUES (37,'2022_07_03_221908_create_vmt_employee_attendances_table',23);
INSERT INTO `migrations` VALUES (38,'2022_07_20_082329_add_user_id_to_vmt_employee_attendance_table',24);
INSERT INTO `migrations` VALUES (39,'2022_07_21_084956_create_vmt_asset_inventories_table',25);
INSERT INTO `migrations` VALUES (41,'2022_07_25_050341_add_bloodgroup_to_employee_details_table',27);
INSERT INTO `migrations` VALUES (42,'2022_07_26_051833_create_vmt_config_pms_table',28);
INSERT INTO `migrations` VALUES (43,'2022_07_26_091550_create_vmt_department_table',29);
INSERT INTO `migrations` VALUES (44,'2022_07_26_145428_add_active_to_users_table',30);
INSERT INTO `migrations` VALUES (45,'2022_07_26_111410_vmt_announcement',31);
INSERT INTO `migrations` VALUES (46,'2022_07_23_120549_create_vmt_dashboard_posts_table',32);
INSERT INTO `migrations` VALUES (47,'2022_08_05_123550_create_kpi_form_table',33);
INSERT INTO `migrations` VALUES (48,'2022_08_06_171959_add_columns_vmt_employee_details',34);
INSERT INTO `migrations` VALUES (49,'2022_08_09_192423_add_emp_no_users_table',35);
INSERT INTO `migrations` VALUES (51,'2022_08_09_204023_create_vmt_master_configs_table',36);
INSERT INTO `migrations` VALUES (52,'2022_08_13_123203_create_vmt_p_m_s__k_p_i_form_models_table',37);
INSERT INTO `migrations` VALUES (53,'2022_08_13_124056_create_vmt_p_m_s__k_p_i_form_details_models_table',37);
INSERT INTO `migrations` VALUES (54,'2022_08_13_131446_create_vmt_p_m_s__k_p_i_form_assigned_models_table',37);
INSERT INTO `migrations` VALUES (55,'2022_08_13_140427_create_vmt_p_m_s__k_p_i_form_reviews_models_table',37);
INSERT INTO `migrations` VALUES (57,'2022_08_20_123130_create_vmt_employee_statutory_details_table',38);
INSERT INTO `migrations` VALUES (58,'2022_08_16_204425_add_isadmin_column',39);
INSERT INTO `migrations` VALUES (59,'2022_08_19_063618_add_date_and_checkbox_columns_in_vmt_announcement_table',40);
INSERT INTO `migrations` VALUES (60,'2022_08_19_074317_add_date_and_checkbox_columns_in_polling_questions_table',40);
INSERT INTO `migrations` VALUES (61,'2022_08_19_093643_create_vmt_praises_table',40);
INSERT INTO `migrations` VALUES (62,'2022_08_19_123641_add_author_id_in_vmt_praise_table',40);
INSERT INTO `migrations` VALUES (63,'2022_08_19_123706_add_author_id_in_polling_questions_table',40);
INSERT INTO `migrations` VALUES (64,'2022_08_22_110251_add_assignee_id_in_vmt_pms_kpiform_reviews_table',40);
INSERT INTO `migrations` VALUES (65,'2022_08_22_114358_make_some-columns_nullable_in_vmt_pms_kpiform_reviews_table',41);
INSERT INTO `migrations` VALUES (66,'2022_09_01_185911_create_vmt_p_m_s_ratings_table',42);
INSERT INTO `migrations` VALUES (67,'2022_09_03_080820_add_new_column_selected_levels',42);
INSERT INTO `migrations` VALUES (68,'2022_09_07_151747_usertable_add_new_column_isonboarded',43);
INSERT INTO `migrations` VALUES (69,'2022_09_08_053334_usertable_add_new_column_onboardtype',44);
INSERT INTO `migrations` VALUES (70,'2022_09_09_121302_usertable_add_new_column__is_default_password_updated',45);
INSERT INTO `migrations` VALUES (71,'2022_09_12_135946_attendance_add_new_column_work_mode__leave_comments',46);
INSERT INTO `migrations` VALUES (72,'2022_09_15_113635_emp_details_added_new_columns',47);
INSERT INTO `migrations` VALUES (73,'2022_09_19_133358_users__add_new_columns_is_manager_is_hr',48);
INSERT INTO `migrations` VALUES (74,'2022_09_20_045100_attendance_add_cols_checkinout_selfie_',49);
INSERT INTO `migrations` VALUES (75,'2022_09_20_061342_users__add_new_column_can_login',49);
INSERT INTO `migrations` VALUES (76,'2022_09_21_063740_create_vmt_process_models_table',50);
INSERT INTO `migrations` VALUES (77,'2022_09_21_090057_create_vmt_org_roles_table',50);
INSERT INTO `migrations` VALUES (78,'2022_09_21_092423_dept_addcolumns',50);
INSERT INTO `migrations` VALUES (79,'2022_09_23_092424_empdetails_addcolumns',51);
INSERT INTO `migrations` VALUES (80,'2022_09_28_122805_create_vmt_employee_family_details_table',52);
INSERT INTO `migrations` VALUES (81,'2022_09_29_135850_users__add_new_column_client_id',53);
INSERT INTO `migrations` VALUES (82,'2022_09_30_032259_create_vmt_employee_emergency_contact_details_table',53);
INSERT INTO `migrations` VALUES (83,'2022_10_04_194908_employeedetails__add_new_column_dl_no',54);
INSERT INTO `migrations` VALUES (84,'2022_10_06_100343_familydetails__add_new_column_gender',54);
INSERT INTO `migrations` VALUES (85,'2022_10_06_121029_familydetails__add_new_column_physically_challenged',54);
INSERT INTO `migrations` VALUES (86,'2022_10_06_122541_familydetails__add_new_column_epf_no_esic_no',54);
INSERT INTO `migrations` VALUES (87,'2022_10_06_134313_empdetails__add_new_column_current_permnt_address_line_1_2',54);
INSERT INTO `migrations` VALUES (88,'2022_10_06_174712_empdetails__add_new_columns_country_state',54);
INSERT INTO `migrations` VALUES (89,'2022_10_07_091813_vmt_blood_group',54);
INSERT INTO `migrations` VALUES (90,'2022_10_07_093233_emp_details_rename_location_columns',54);
INSERT INTO `migrations` VALUES (91,'2022_10_07_095453_emp_details_rename_location_columns',54);
INSERT INTO `migrations` VALUES (92,'2022_10_08_163547_emp_details_rename_bank_name',54);
INSERT INTO `migrations` VALUES (93,'2022_10_08_171908_emp_details_add_probation',54);
INSERT INTO `migrations` VALUES (94,'2022_10_08_182013_emp_details_add_wedding_date',54);
INSERT INTO `migrations` VALUES (95,'2022_10_13_194341_p_a_t_add_column_expires_at',55);
INSERT INTO `migrations` VALUES (96,'2022_10_13_195535_create_vmt_employee_leaves_table',56);
INSERT INTO `migrations` VALUES (97,'2022_10_13_200151_create_vmt_work_shifts_table',56);
INSERT INTO `migrations` VALUES (98,'2022_10_14_091857_vmt_leaves_add_new_columns',57);
INSERT INTO `migrations` VALUES (99,'2022_10_17_123445_vmt_leaves_add_new_column_user_id',58);
INSERT INTO `migrations` VALUES (100,'2022_11_03_011319_create_vmt_employee_attendance_regularizations_table',59);
INSERT INTO `migrations` VALUES (101,'2022_11_15_112234_create_vmt_employee_reimbursements_table',60);
INSERT INTO `migrations` VALUES (102,'2022_11_15_113759_create_vmt_reimbursements_table',60);
INSERT INTO `migrations` VALUES (103,'2022_11_29_123340_add_softdelete_column',61);
INSERT INTO `migrations` VALUES (104,'2022_11_29_123609_add_softdelete_column',61);
INSERT INTO `migrations` VALUES (105,'2022_12_19_144002_create_sessions_table',62);
INSERT INTO `migrations` VALUES (106,'2022_12_21_122418_add_new_column_client_master',62);
INSERT INTO `migrations` VALUES (107,'2023_01_06_170042_add_attendance_mode_column',63);
INSERT INTO `migrations` VALUES (108,'2023_01_06_170042_modify_attendance_mode_column',63);
INSERT INTO `migrations` VALUES (109,'2023_01_12_174328_add_column_is_finite',63);
INSERT INTO `migrations` VALUES (110,'2023_01_11_174739_vmt_leavepolicy',64);
INSERT INTO `migrations` VALUES (111,'2023_01_11_175105_vmt_leavepolicy_holidays',64);
INSERT INTO `migrations` VALUES (112,'2023_01_27_183156_add_column_is_revoked',64);
INSERT INTO `migrations` VALUES (113,'2023_02_06_170616_add_column_reviewer_date',65);
INSERT INTO `migrations` VALUES (114,'2023_02_07_203720_add_new_column_to_vmt_employee_payslip_table',65);
INSERT INTO `migrations` VALUES (115,'2023_02_07_205857_update__t_d_s_column_to_vmt_employee_payslip_table',65);
INSERT INTO `migrations` VALUES (116,'2023_01_21_150101_add_new_column',66);
INSERT INTO `migrations` VALUES (117,'2023_02_04_150506_create_vmt_employee_documents_table',66);
INSERT INTO `migrations` VALUES (118,'2023_02_04_160357_create_vmt_documents_table',66);
INSERT INTO `migrations` VALUES (119,'2023_02_14_190441_add_new_columns',66);
INSERT INTO `migrations` VALUES (120,'2023_02_21_134835_remove_columns',66);
INSERT INTO `migrations` VALUES (121,'2023_03_04_194020_add_new_column_in_att_emp',66);
INSERT INTO `migrations` VALUES (122,'2023_03_04_194347_new_table_emp_workshift',66);
INSERT INTO `migrations` VALUES (123,'2023_03_12_100352_create_vmt_marital_statuses_table',66);
INSERT INTO `migrations` VALUES (124,'2023_03_14_171829_create_vmt_local_conveyance_vehicles_table',66);
INSERT INTO `migrations` VALUES (125,'2023_03_16_114400_create_vmt_employee_compensatory_leaves_table',66);
INSERT INTO `migrations` VALUES (126,'2023_03_21_185740_remove_old_columns',66);
INSERT INTO `migrations` VALUES (127,'2023_03_22_121100_remove_old_columns_vmt_employee_office_details',66);
