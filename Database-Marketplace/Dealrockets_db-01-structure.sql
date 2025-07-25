SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

CREATE TABLE `addon_settings` (
  `id` char(36) NOT NULL,
  `key_name` varchar(191) DEFAULT NULL,
  `live_values` longtext DEFAULT NULL,
  `test_values` longtext DEFAULT NULL,
  `settings_type` varchar(255) DEFAULT NULL,
  `mode` varchar(20) NOT NULL DEFAULT 'live',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `additional_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `add_fund_bonus_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `bonus_type` varchar(50) NOT NULL,
  `bonus_amount` double(14,2) NOT NULL DEFAULT 0.00,
  `min_add_money_amount` double(14,2) NOT NULL DEFAULT 0.00,
  `max_bonus_amount` double(14,2) NOT NULL DEFAULT 0.00,
  `start_date_time` datetime DEFAULT NULL,
  `end_date_time` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `admin_role_id` bigint(20) NOT NULL DEFAULT 2,
  `image` varchar(30) NOT NULL DEFAULT 'def.png',
  `identify_image` text DEFAULT NULL,
  `identify_type` varchar(255) DEFAULT NULL,
  `identify_number` int(11) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(80) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `lead_notif` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `admin_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `module_access` longtext DEFAULT NULL,
  `modules` longtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `admin_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `inhouse_earning` double NOT NULL DEFAULT 0,
  `withdrawn` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `commission_earned` double(8,2) NOT NULL DEFAULT 0.00,
  `delivery_charge_earned` double(8,2) NOT NULL DEFAULT 0.00,
  `pending_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `total_tax_collected` double(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `admin_wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `payment` varchar(191) NOT NULL DEFAULT 'received',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `banner_type` varchar(255) NOT NULL,
  `theme` varchar(255) NOT NULL DEFAULT 'default',
  `published` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `resource_type` varchar(191) DEFAULT NULL,
  `resource_id` bigint(20) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `sub_title` varchar(191) DEFAULT NULL,
  `button_text` varchar(191) DEFAULT NULL,
  `background_color` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `billing_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_person_name` varchar(191) DEFAULT NULL,
  `address_type` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `zip` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `longitude` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'def.png',
  `image_storage_type` varchar(10) DEFAULT 'public',
  `image_alt_text` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `business_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `value` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `cart_group_id` varchar(191) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_type` varchar(20) NOT NULL DEFAULT 'physical',
  `digital_product_type` varchar(30) DEFAULT NULL,
  `color` varchar(191) DEFAULT NULL,
  `choices` text DEFAULT NULL,
  `variations` text DEFAULT NULL,
  `variant` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` double NOT NULL DEFAULT 1,
  `tax` double NOT NULL DEFAULT 1,
  `discount` double NOT NULL DEFAULT 1,
  `tax_model` varchar(20) NOT NULL DEFAULT 'exclude',
  `is_checked` tinyint(1) NOT NULL DEFAULT 0,
  `slug` varchar(191) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `thumbnail` varchar(191) DEFAULT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `seller_is` varchar(191) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shop_info` varchar(191) DEFAULT NULL,
  `shipping_cost` double(8,2) DEFAULT NULL,
  `shipping_type` varchar(191) DEFAULT NULL,
  `is_guest` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cart_shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_group_id` varchar(191) DEFAULT NULL,
  `shipping_method_id` bigint(20) DEFAULT NULL,
  `shipping_cost` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `icon_storage_type` varchar(10) DEFAULT 'public',
  `parent_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `home_status` tinyint(1) NOT NULL DEFAULT 0,
  `priority` int(11) DEFAULT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `category_storage_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `category_shipping_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `cost` double(8,2) DEFAULT NULL,
  `multiply_qty` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `chats_others` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_id` char(36) DEFAULT NULL,
  `category` enum('chat','notification') NOT NULL DEFAULT 'chat',
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` enum('customer','seller','admin') NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_type` enum('seller','admin','customer') DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `priority` enum('low','normal','high') NOT NULL DEFAULT 'normal',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `stocksell_id` bigint(20) UNSIGNED DEFAULT NULL,
  `leads_id` bigint(20) UNSIGNED DEFAULT NULL,
  `suppliers_id` bigint(20) UNSIGNED DEFAULT NULL,
  `openstatus` enum('1','0') DEFAULT '1',
  `product_id` varchar(255) DEFAULT NULL,
  `product_qty` varchar(255) DEFAULT NULL,
  `chat_initiator` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `chattings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `delivery_man_id` bigint(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachment`)),
  `sent_by_customer` tinyint(1) NOT NULL DEFAULT 0,
  `sent_by_seller` tinyint(1) NOT NULL DEFAULT 0,
  `sent_by_admin` tinyint(1) DEFAULT NULL,
  `sent_by_delivery_man` tinyint(1) DEFAULT NULL,
  `seen_by_customer` tinyint(1) NOT NULL DEFAULT 1,
  `seen_by_seller` tinyint(1) NOT NULL DEFAULT 1,
  `seen_by_admin` tinyint(1) DEFAULT NULL,
  `seen_by_delivery_man` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `notification_receiver` varchar(20) DEFAULT NULL COMMENT 'admin, seller, customer, deliveryman',
  `seen_notification` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shop_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cities` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` mediumint(8) UNSIGNED NOT NULL,
  `state_code` varchar(255) NOT NULL,
  `country_id` mediumint(8) UNSIGNED NOT NULL,
  `country_code` char(2) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '2014-01-01 12:01:01',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `wikiDataId` varchar(255) DEFAULT NULL COMMENT 'Rapid API GeoDB Cities'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `company_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description_head` varchar(255) DEFAULT NULL,
  `description_text` text DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `certificates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`certificates`)),
  `total_capitalization` varchar(255) DEFAULT NULL,
  `year_established` year(4) DEFAULT NULL,
  `total_employees` varchar(255) DEFAULT NULL,
  `company_certificates` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `product_certificates` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `total_annual_sales` varchar(255) DEFAULT NULL,
  `export_percentage` int(11) DEFAULT NULL,
  `oem_service` tinyint(1) DEFAULT 0,
  `small_orders_accepted` tinyint(1) DEFAULT 0,
  `main_export_markets` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`main_export_markets`)),
  `payment_terms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_terms`)),
  `delivery_terms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`delivery_terms`)),
  `hot_products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hot_products`)),
  `product_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_categories`)),
  `factory_size` varchar(255) DEFAULT NULL,
  `production_lines` int(11) DEFAULT NULL,
  `monthly_output` varchar(255) DEFAULT NULL,
  `main_products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`main_products`)),
  `lead_time` varchar(255) DEFAULT NULL,
  `qc_staff_count` int(11) DEFAULT NULL,
  `inspection_process` text DEFAULT NULL,
  `testing_equipment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`testing_equipment`)),
  `qc_certifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`qc_certifications`)),
  `rd_staff_count` int(11) DEFAULT NULL,
  `patents` int(11) DEFAULT NULL,
  `annual_rd_spending` varchar(255) DEFAULT NULL,
  `customization_offered` tinyint(1) DEFAULT 0,
  `product_dev_time` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `local_time` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `showroom` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_dept` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `seller` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `mobile_number` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `feedback` varchar(191) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reply` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `countries` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numeric_code` char(3) DEFAULT NULL,
  `iso2` char(2) DEFAULT NULL,
  `phonecode` varchar(255) DEFAULT NULL,
  `capital` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `currency_name` varchar(255) DEFAULT NULL,
  `currency_symbol` varchar(255) DEFAULT NULL,
  `tld` varchar(255) DEFAULT NULL,
  `native` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `region_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `subregion` varchar(255) DEFAULT NULL,
  `subregion_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `timezones` text DEFAULT NULL,
  `translations` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `emoji` varchar(191) DEFAULT NULL,
  `emojiU` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `wikiDataId` varchar(255) DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  `blacklist` enum('yes','no','','') DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `added_by` varchar(191) NOT NULL DEFAULT 'admin',
  `coupon_type` varchar(50) DEFAULT NULL,
  `coupon_bearer` varchar(191) NOT NULL DEFAULT 'inhouse',
  `seller_id` bigint(20) DEFAULT NULL COMMENT 'NULL=in-house, 0=all seller',
  `customer_id` bigint(20) DEFAULT NULL COMMENT '0 = all customer',
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(15) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `min_purchase` decimal(8,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(15) NOT NULL DEFAULT 'percentage',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `symbol` varchar(191) NOT NULL,
  `code` varchar(191) NOT NULL,
  `exchange_rate` varchar(191) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `customer_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `balance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `royality_points` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `customer_wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `transaction_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `transaction_type` varchar(20) DEFAULT NULL,
  `transaction_method` varchar(30) DEFAULT NULL,
  `transaction_id` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cvs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pnumber` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `deal_assist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `deal_of_the_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(12) NOT NULL DEFAULT 'amount',
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `deliveryman_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `description` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `deliveryman_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) NOT NULL,
  `current_balance` decimal(50,2) NOT NULL DEFAULT 0.00,
  `cash_in_hand` decimal(50,2) NOT NULL DEFAULT 0.00,
  `pending_withdraw` decimal(50,2) NOT NULL DEFAULT 0.00,
  `total_withdraw` decimal(50,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `delivery_country_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_code` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `delivery_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `deliveryman_id` bigint(20) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `longitude` varchar(191) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `location` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `delivery_man_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `transaction_id` char(36) NOT NULL,
  `debit` decimal(50,2) NOT NULL DEFAULT 0.00,
  `credit` decimal(50,2) NOT NULL DEFAULT 0.00,
  `transaction_type` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `delivery_men` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `f_name` varchar(100) DEFAULT NULL,
  `l_name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country_code` varchar(20) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `identity_number` varchar(30) DEFAULT NULL,
  `identity_type` varchar(50) DEFAULT NULL,
  `identity_image` varchar(191) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `bank_name` varchar(191) DEFAULT NULL,
  `branch` varchar(191) DEFAULT NULL,
  `account_no` varchar(191) DEFAULT NULL,
  `holder_name` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_online` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `auth_token` varchar(191) NOT NULL DEFAULT '6yIRXJRRfp78qJsAoKZZ6TTqhzuNJ3TcdvPBmk6n',
  `fcm_token` varchar(191) DEFAULT NULL,
  `app_language` varchar(191) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `delivery_zip_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zipcode` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `digital_product_authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `digital_product_otp_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_details_id` varchar(255) DEFAULT NULL,
  `identity` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `otp_hit_count` tinyint(4) NOT NULL DEFAULT 0,
  `is_temp_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `temp_block_time` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `digital_product_publishing_houses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `publishing_house_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `digital_product_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_key` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `price` decimal(24,8) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `template_name` varchar(191) NOT NULL,
  `user_type` varchar(191) NOT NULL,
  `template_design_name` varchar(191) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `banner_image` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `button_name` varchar(191) DEFAULT NULL,
  `button_url` varchar(191) DEFAULT NULL,
  `footer_text` varchar(191) DEFAULT NULL,
  `copyright_text` varchar(191) DEFAULT NULL,
  `pages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pages`)),
  `social_media` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_media`)),
  `hide_field` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hide_field`)),
  `button_content_status` tinyint(4) NOT NULL DEFAULT 1,
  `product_information_status` tinyint(4) NOT NULL DEFAULT 1,
  `order_information_status` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `emergency_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `country_code` varchar(20) DEFAULT NULL,
  `phone` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `error_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_code` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `hit_counts` int(11) NOT NULL DEFAULT 0,
  `redirect_url` varchar(255) DEFAULT NULL,
  `redirect_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `faq` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `seller` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(1000) NOT NULL,
  `sub_type` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `listing_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `feature_deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(191) DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `flash_deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `background_color` varchar(255) DEFAULT NULL,
  `text_color` varchar(255) DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `deal_type` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `flash_deal_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flash_deal_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `guest_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `fcm_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `help_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'default',
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `ranking` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_appliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jobid` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `apply_via` enum('cv','form') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `job_search_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `search` varchar(255) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('buyer','seller') NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` int(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `posted_date` date NOT NULL,
  `quantity_required` varchar(255) DEFAULT NULL,
  `buying_frequency` varchar(255) DEFAULT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `quotes_recieved` int(25) NOT NULL DEFAULT 0,
  `industry` varchar(255) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hs_code` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `delivery_terms` varchar(255) DEFAULT NULL,
  `delivery_mode` varchar(255) DEFAULT NULL,
  `place_of_loading` varchar(255) DEFAULT NULL,
  `port_of_loading` varchar(255) DEFAULT NULL,
  `packing_type` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `compliance_status` enum('pending','approved','flagged') NOT NULL DEFAULT 'pending',
  `city` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `refund` varchar(255) DEFAULT NULL,
  `avl_stock` varchar(255) DEFAULT NULL,
  `avl_stock_unit` varchar(255) DEFAULT NULL,
  `lead_time` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `payment_option` varchar(255) DEFAULT NULL,
  `offer_type` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `images` longtext DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `dynamic_data` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `login_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `loyalty_point_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` char(36) NOT NULL,
  `credit` decimal(24,3) NOT NULL DEFAULT 0.000,
  `debit` decimal(24,3) NOT NULL DEFAULT 0.000,
  `balance` decimal(24,3) NOT NULL DEFAULT 0.000,
  `reference` varchar(191) DEFAULT NULL,
  `transaction_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `memberships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `membership_id` int(20) UNSIGNED NOT NULL,
  `membership_status` enum('active','inactive','suspended','expired') NOT NULL DEFAULT 'inactive',
  `paymentstatus` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `membership_user_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `membership_tiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `membership_id` int(255) NOT NULL,
  `membership_benefits` longtext NOT NULL,
  `membership_name` varchar(255) NOT NULL,
  `membership_type` varchar(255) NOT NULL,
  `membership_active` varchar(255) NOT NULL,
  `membership_order` int(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `most_demandeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `new_product_stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `hts_code` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `extra_images` longtext DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `minimum_order_qty` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `supply_capacity` varchar(255) DEFAULT NULL,
  `unit_price` decimal(15,2) DEFAULT NULL,
  `delivery_terms` varchar(255) DEFAULT NULL,
  `delivery_mode` varchar(255) DEFAULT NULL,
  `place_of_loading` varchar(255) DEFAULT NULL,
  `port_of_loading` varchar(255) DEFAULT NULL,
  `lead_time` varchar(255) DEFAULT NULL,
  `lead_time_unit` varchar(255) DEFAULT NULL,
  `payment_terms` varchar(255) DEFAULT NULL,
  `packing_type` varchar(255) DEFAULT NULL,
  `weight_per_unit` varchar(255) DEFAULT NULL,
  `dimensions_per_unit` varchar(255) DEFAULT NULL,
  `target_market` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `short_details` text DEFAULT NULL,
  `details` longtext DEFAULT NULL,
  `dynamic_data` longtext DEFAULT NULL,
  `dynamic_data_technical` longtext DEFAULT NULL,
  `certificates` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `supply_unit` varchar(255) DEFAULT NULL,
  `local_currency` varchar(255) DEFAULT NULL,
  `request_status` int(12) NOT NULL DEFAULT 0,
  `status` int(12) NOT NULL DEFAULT 0,
  `dimension_unit` varchar(255) DEFAULT NULL,
  `master_packing` varchar(255) DEFAULT NULL,
  `container` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sent_by` varchar(255) NOT NULL DEFAULT 'system',
  `sent_to` varchar(255) NOT NULL DEFAULT 'customer',
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `notification_count` int(11) NOT NULL DEFAULT 0,
  `image` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notification_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(191) DEFAULT NULL,
  `key` varchar(191) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notification_seens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `secret` varchar(100) NOT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `offline_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_info`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `offline_payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `method_fields` text NOT NULL,
  `method_informations` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(15) DEFAULT NULL,
  `is_guest` tinyint(4) NOT NULL DEFAULT 0,
  `customer_type` varchar(10) DEFAULT NULL,
  `payment_status` varchar(15) NOT NULL DEFAULT 'unpaid',
  `order_status` varchar(50) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(100) DEFAULT NULL,
  `transaction_ref` varchar(30) DEFAULT NULL,
  `payment_by` varchar(191) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `order_amount` double NOT NULL DEFAULT 0,
  `admin_commission` decimal(8,2) NOT NULL DEFAULT 0.00,
  `is_pause` varchar(20) NOT NULL DEFAULT '0',
  `cause` varchar(191) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount_amount` double NOT NULL DEFAULT 0,
  `discount_type` varchar(30) DEFAULT NULL,
  `coupon_code` varchar(191) DEFAULT NULL,
  `coupon_discount_bearer` varchar(191) NOT NULL DEFAULT 'inhouse',
  `shipping_responsibility` varchar(255) DEFAULT NULL,
  `shipping_method_id` bigint(20) NOT NULL DEFAULT 0,
  `shipping_cost` double(8,2) NOT NULL DEFAULT 0.00,
  `is_shipping_free` tinyint(1) NOT NULL DEFAULT 0,
  `order_group_id` varchar(191) NOT NULL DEFAULT 'def-order-group',
  `verification_code` varchar(191) NOT NULL DEFAULT '0',
  `verification_status` tinyint(4) NOT NULL DEFAULT 0,
  `seller_id` bigint(20) DEFAULT NULL,
  `seller_is` varchar(191) DEFAULT NULL,
  `shipping_address_data` text DEFAULT NULL,
  `delivery_man_id` bigint(20) DEFAULT NULL,
  `deliveryman_charge` double NOT NULL DEFAULT 0,
  `expected_delivery_date` date DEFAULT NULL,
  `order_note` text DEFAULT NULL,
  `billing_address` bigint(20) UNSIGNED DEFAULT NULL,
  `billing_address_data` text DEFAULT NULL,
  `order_type` varchar(191) NOT NULL DEFAULT 'default_type',
  `extra_discount` double(8,2) NOT NULL DEFAULT 0.00,
  `extra_discount_type` varchar(191) DEFAULT NULL,
  `free_delivery_bearer` varchar(255) DEFAULT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT 0,
  `shipping_type` varchar(191) DEFAULT NULL,
  `delivery_type` varchar(191) DEFAULT NULL,
  `delivery_service_name` varchar(191) DEFAULT NULL,
  `third_party_delivery_tracking_id` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_delivery_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `digital_file_after_sell` varchar(191) DEFAULT NULL,
  `product_details` text DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `tax` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `tax_model` varchar(20) NOT NULL DEFAULT 'exclude',
  `delivery_status` varchar(15) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(15) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shipping_method_id` bigint(20) DEFAULT NULL,
  `variant` varchar(255) DEFAULT NULL,
  `variation` varchar(255) DEFAULT NULL,
  `discount_type` varchar(30) DEFAULT NULL,
  `is_stock_decreased` tinyint(1) NOT NULL DEFAULT 1,
  `refund_request` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_expected_delivery_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_type` varchar(191) NOT NULL,
  `expected_delivery_date` date NOT NULL,
  `cause` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_status_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_type` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `cause` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_transactions` (
  `seller_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `order_amount` decimal(50,2) NOT NULL DEFAULT 0.00,
  `seller_amount` decimal(50,2) NOT NULL DEFAULT 0.00,
  `admin_commission` decimal(50,2) NOT NULL DEFAULT 0.00,
  `received_by` varchar(191) NOT NULL,
  `status` varchar(191) DEFAULT NULL,
  `delivery_charge` decimal(50,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(50,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `seller_is` varchar(191) DEFAULT NULL,
  `delivered_by` varchar(191) NOT NULL DEFAULT 'admin',
  `payment_method` varchar(191) DEFAULT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_resets` (
  `identity` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `otp_hit_count` tinyint(4) NOT NULL DEFAULT 0,
  `is_temp_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `temp_block_time` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type` varchar(191) NOT NULL DEFAULT 'customer',
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `payment_requests` (
  `id` char(36) NOT NULL,
  `payer_id` varchar(64) DEFAULT NULL,
  `receiver_id` varchar(64) DEFAULT NULL,
  `payment_amount` decimal(24,2) NOT NULL DEFAULT 0.00,
  `gateway_callback_url` varchar(191) DEFAULT NULL,
  `success_hook` varchar(100) DEFAULT NULL,
  `failure_hook` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `currency_code` varchar(20) NOT NULL DEFAULT 'USD',
  `payment_method` varchar(50) DEFAULT NULL,
  `additional_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payer_information` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `external_redirect_link` varchar(255) DEFAULT NULL,
  `receiver_information` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `attribute_id` varchar(64) DEFAULT NULL,
  `attribute` varchar(255) DEFAULT NULL,
  `payment_platform` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `paytabs_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `result` text NOT NULL,
  `response_code` int(10) UNSIGNED NOT NULL,
  `pt_invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `currency` varchar(191) DEFAULT NULL,
  `transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `card_brand` varchar(191) DEFAULT NULL,
  `card_first_six_digits` int(10) UNSIGNED DEFAULT NULL,
  `card_last_four_digits` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `phone_or_email_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone_or_email` varchar(191) DEFAULT NULL,
  `token` text DEFAULT NULL,
  `otp_hit_count` tinyint(4) NOT NULL DEFAULT 0,
  `is_temp_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `temp_block_time` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `added_by` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `slug` varchar(120) DEFAULT NULL,
  `product_type` varchar(20) NOT NULL DEFAULT 'physical',
  `category_ids` varchar(80) DEFAULT NULL,
  `category_id` varchar(191) DEFAULT NULL,
  `sub_category_id` varchar(191) DEFAULT NULL,
  `sub_sub_category_id` varchar(191) DEFAULT NULL,
  `brand_id` bigint(20) DEFAULT NULL,
  `unit` varchar(191) DEFAULT NULL,
  `min_qty` int(11) NOT NULL DEFAULT 1,
  `refundable` tinyint(1) NOT NULL DEFAULT 1,
  `digital_product_type` varchar(30) DEFAULT NULL,
  `digital_file_ready` varchar(191) DEFAULT NULL,
  `digital_file_ready_storage_type` varchar(10) DEFAULT 'public',
  `images` longtext DEFAULT NULL,
  `color_image` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `thumbnail_storage_type` varchar(10) DEFAULT 'public',
  `preview_file` varchar(255) DEFAULT NULL,
  `preview_file_storage_type` varchar(255) DEFAULT 'public',
  `featured` varchar(255) DEFAULT NULL,
  `flash_deal` varchar(255) DEFAULT NULL,
  `video_provider` varchar(30) DEFAULT NULL,
  `video_url` varchar(150) DEFAULT NULL,
  `colors` varchar(150) DEFAULT NULL,
  `variant_product` tinyint(1) NOT NULL DEFAULT 0,
  `attributes` varchar(255) DEFAULT NULL,
  `choice_options` text DEFAULT NULL,
  `variation` text DEFAULT NULL,
  `digital_product_file_types` longtext DEFAULT NULL,
  `digital_product_extensions` longtext DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `purchase_price` double NOT NULL DEFAULT 0,
  `tax` varchar(191) NOT NULL DEFAULT '0.00',
  `tax_type` varchar(80) DEFAULT NULL,
  `tax_model` varchar(20) NOT NULL DEFAULT 'exclude',
  `discount` varchar(191) NOT NULL DEFAULT '0.00',
  `discount_type` varchar(80) DEFAULT NULL,
  `current_stock` int(11) DEFAULT NULL,
  `minimum_order_qty` int(11) NOT NULL DEFAULT 1,
  `details` text DEFAULT NULL,
  `free_shipping` tinyint(1) NOT NULL DEFAULT 0,
  `attachment` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `featured_status` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_description` varchar(191) DEFAULT NULL,
  `meta_image` varchar(191) DEFAULT NULL,
  `request_status` tinyint(1) NOT NULL DEFAULT 0,
  `denied_note` text DEFAULT NULL,
  `shipping_cost` double(8,2) DEFAULT NULL,
  `multiply_qty` tinyint(1) DEFAULT NULL,
  `temp_shipping_cost` double(8,2) DEFAULT NULL,
  `is_shipping_cost_updated` tinyint(1) DEFAULT NULL,
  `code` varchar(191) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `views` int(20) NOT NULL DEFAULT 0,
  `customization` varchar(255) DEFAULT NULL,
  `style` varchar(255) DEFAULT NULL,
  `usage` varchar(255) DEFAULT NULL,
  `sample_price` varchar(255) DEFAULT NULL,
  `sample_amount` varchar(255) DEFAULT NULL,
  `model_number` varchar(255) DEFAULT NULL,
  `small_orders` tinyint(1) NOT NULL DEFAULT 0,
  `additional_details` longtext DEFAULT NULL,
  `faq` text DEFAULT NULL,
  `why_choose_us` text DEFAULT NULL,
  `fob_port` varchar(255) DEFAULT NULL,
  `weight_per_unit` varchar(255) DEFAULT NULL,
  `hts_code` varchar(255) DEFAULT NULL,
  `export_carton_dimensions` varchar(255) DEFAULT NULL,
  `logistics_attributes` varchar(255) DEFAULT NULL,
  `lead_time` varchar(255) DEFAULT NULL,
  `dimensions_per_unit` varchar(255) DEFAULT NULL,
  `units_per_carton` varchar(255) DEFAULT NULL,
  `carton_weight` varchar(255) DEFAULT NULL,
  `export_markets` text DEFAULT NULL,
  `payment_methods` varchar(255) DEFAULT NULL,
  `currency_accepted` varchar(255) DEFAULT NULL,
  `payment_terms` varchar(255) DEFAULT NULL,
  `invoicing` varchar(255) DEFAULT NULL,
  `refund_policy` text DEFAULT NULL,
  `supply_capacity` varchar(255) DEFAULT NULL,
  `supply_unit` varchar(255) DEFAULT NULL,
  `local_currency` varchar(255) DEFAULT NULL,
  `delivery_terms` varchar(255) DEFAULT NULL,
  `delivery_mode` varchar(255) DEFAULT NULL,
  `place_of_loading` varchar(255) DEFAULT NULL,
  `port_of_loading` varchar(255) DEFAULT NULL,
  `lead_time_unit` varchar(255) DEFAULT NULL,
  `target_market` longtext DEFAULT NULL,
  `short_details` longtext DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `technical_specification` longtext DEFAULT NULL,
  `packing_type` varchar(255) DEFAULT NULL,
  `extra_images` longtext DEFAULT NULL,
  `dynamic_data` longtext NOT NULL,
  `dynamic_data_technical` longtext NOT NULL,
  `certificates` varchar(255) DEFAULT NULL,
  `dimension_unit` varchar(255) NOT NULL,
  `master_packing` varchar(255) NOT NULL,
  `container` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `master_packing_type` varchar(255) DEFAULT NULL,
  `load_capacity_per_lot` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_compares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'customer_id',
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_seos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `index` varchar(255) DEFAULT NULL,
  `no_follow` varchar(255) DEFAULT NULL,
  `no_image_index` varchar(255) DEFAULT NULL,
  `no_archive` varchar(255) DEFAULT NULL,
  `no_snippet` varchar(255) DEFAULT NULL,
  `max_snippet` varchar(255) DEFAULT NULL,
  `max_snippet_value` varchar(255) DEFAULT NULL,
  `max_video_preview` varchar(255) DEFAULT NULL,
  `max_video_preview_value` varchar(255) DEFAULT NULL,
  `max_image_preview` varchar(255) DEFAULT NULL,
  `max_image_preview_value` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `variant` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `qty` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `publishing_houses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pnumber` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `industry` varchar(255) NOT NULL,
  `term` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `buying_frequency` varchar(255) NOT NULL,
  `converted_lead` varchar(255) DEFAULT NULL,
  `target_unit_price` varchar(255) DEFAULT NULL,
  `target_unit_price_currency` varchar(255) DEFAULT NULL,
  `max_budget` varchar(255) DEFAULT NULL,
  `max_budget_currency` varchar(255) DEFAULT NULL,
  `shipping_method` varchar(255) DEFAULT NULL,
  `destination_port` varchar(255) DEFAULT NULL,
  `destination_port_currency` varchar(255) DEFAULT NULL,
  `spin_time` varchar(255) DEFAULT NULL,
  `terms` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `refund_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_details_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) NOT NULL,
  `approved_count` tinyint(4) NOT NULL DEFAULT 0,
  `denied_count` tinyint(4) NOT NULL DEFAULT 0,
  `amount` double(8,2) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `refund_reason` longtext NOT NULL,
  `images` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_note` longtext DEFAULT NULL,
  `rejected_note` longtext DEFAULT NULL,
  `payment_info` longtext DEFAULT NULL,
  `change_by` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `refund_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `refund_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `change_by` varchar(191) DEFAULT NULL,
  `change_by_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `refund_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_for` varchar(191) DEFAULT NULL,
  `payer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_by` varchar(191) DEFAULT NULL,
  `paid_to` varchar(191) DEFAULT NULL,
  `payment_method` varchar(191) DEFAULT NULL,
  `payment_status` varchar(191) DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `transaction_type` varchar(191) DEFAULT NULL,
  `order_details_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `refund_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `delivery_man_id` bigint(20) DEFAULT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `attachment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachment`)),
  `rating` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_saved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `review_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` int(11) NOT NULL,
  `added_by_id` int(11) DEFAULT NULL,
  `added_by` varchar(255) NOT NULL COMMENT 'customer, seller, admin, deliveryman',
  `reply_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `robots_meta_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_name` varchar(255) DEFAULT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_image` varchar(255) DEFAULT NULL,
  `canonicals_url` varchar(255) DEFAULT NULL,
  `index` varchar(255) DEFAULT NULL,
  `no_follow` varchar(255) DEFAULT NULL,
  `no_image_index` varchar(255) DEFAULT NULL,
  `no_archive` varchar(255) DEFAULT NULL,
  `no_snippet` varchar(255) DEFAULT NULL,
  `max_snippet` varchar(255) DEFAULT NULL,
  `max_snippet_value` varchar(255) DEFAULT NULL,
  `max_video_preview` varchar(255) DEFAULT NULL,
  `max_video_preview_value` varchar(255) DEFAULT NULL,
  `max_image_preview` varchar(255) DEFAULT NULL,
  `max_image_preview_value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `search_functions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(150) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `visible_for` varchar(191) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `search_hist_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `count` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `sellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `f_name` varchar(30) DEFAULT NULL,
  `l_name` varchar(30) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `image` varchar(30) NOT NULL DEFAULT 'def.png',
  `email` varchar(80) NOT NULL,
  `password` varchar(80) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'pending',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bank_name` varchar(191) DEFAULT NULL,
  `branch` varchar(191) DEFAULT NULL,
  `account_no` varchar(191) DEFAULT NULL,
  `holder_name` varchar(191) DEFAULT NULL,
  `auth_token` text DEFAULT NULL,
  `sales_commission_percentage` double(8,2) DEFAULT NULL,
  `gst` varchar(191) DEFAULT NULL,
  `cm_firebase_token` varchar(191) DEFAULT NULL,
  `pos_status` tinyint(1) NOT NULL DEFAULT 0,
  `minimum_order_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `free_delivery_status` int(11) NOT NULL DEFAULT 0,
  `free_delivery_over_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `app_language` varchar(191) NOT NULL DEFAULT 'en',
  `membership` varchar(255) DEFAULT NULL,
  `years` int(11) DEFAULT NULL,
  `membership_id` bigint(20) NOT NULL,
  `chat_id` bigint(20) NOT NULL,
  `membership_status` varchar(255) NOT NULL,
  `current_chatrooms` varchar(255) NOT NULL,
  `vendor_type` varchar(255) NOT NULL DEFAULT 'vendor',
  `supplier_id` int(5) UNSIGNED DEFAULT NULL,
  `suppliers_confirm_status` tinyint(4) NOT NULL DEFAULT 0,
  `mem_benefits` longtext DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `ad_banners` longtext DEFAULT NULL,
  `seller_unique_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `seller_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `total_earning` double NOT NULL DEFAULT 0,
  `withdrawn` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `commission_given` double(8,2) NOT NULL DEFAULT 0.00,
  `pending_withdraw` double(8,2) NOT NULL DEFAULT 0.00,
  `delivery_charge_earned` double(8,2) NOT NULL DEFAULT 0.00,
  `collected_cash` double(8,2) NOT NULL DEFAULT 0.00,
  `total_tax_collected` double(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `seller_wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `payment` varchar(191) NOT NULL DEFAULT 'received',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(15) DEFAULT NULL,
  `is_guest` tinyint(4) NOT NULL DEFAULT 0,
  `contact_person_name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address_type` varchar(20) NOT NULL DEFAULT 'home',
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `longitude` varchar(191) DEFAULT NULL,
  `is_billing` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) DEFAULT NULL,
  `creator_type` varchar(191) NOT NULL DEFAULT 'admin',
  `title` varchar(100) DEFAULT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT 0.00,
  `duration` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `shipping_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(191) NOT NULL DEFAULT 'en',
  `address` varchar(255) NOT NULL,
  `contact` varchar(25) NOT NULL,
  `image` varchar(30) NOT NULL DEFAULT 'def.png',
  `image_storage_type` varchar(10) DEFAULT 'public',
  `bottom_banner` varchar(191) DEFAULT NULL,
  `bottom_banner_storage_type` varchar(10) DEFAULT 'public',
  `offer_banner` varchar(255) DEFAULT NULL,
  `offer_banner_storage_type` varchar(10) DEFAULT 'public',
  `vacation_start_date` date DEFAULT NULL,
  `vacation_end_date` date DEFAULT NULL,
  `vacation_note` varchar(255) DEFAULT NULL,
  `vacation_status` tinyint(4) NOT NULL DEFAULT 0,
  `temporary_close` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banner` varchar(191) NOT NULL,
  `banner_storage_type` varchar(10) DEFAULT 'public',
  `subtitle` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `shop_followers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Customer ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `shortlist_candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jobid` bigint(20) UNSIGNED NOT NULL,
  `applier_id` bigint(20) UNSIGNED NOT NULL,
  `recruiter_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `social_medias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `active_status` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `soft_credentials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `solutions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `banner_text` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `solution_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `solution_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `solution_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `solution_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `states` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` mediumint(8) UNSIGNED NOT NULL,
  `country_code` char(2) NOT NULL,
  `fips_code` varchar(255) DEFAULT NULL,
  `iso2` varchar(255) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `wikiDataId` varchar(255) DEFAULT NULL COMMENT 'Rapid API GeoDB Cities'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

CREATE TABLE `stock_category` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `stock_sell` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext NOT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','rejected') NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quote_recieved` bigint(20) NOT NULL DEFAULT 0,
  `image` varchar(1000) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `industry` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `company_icon` varchar(255) DEFAULT NULL,
  `compliance_status` enum('pending','approved','flagged') NOT NULL DEFAULT 'pending',
  `upper_limit` varchar(255) DEFAULT NULL,
  `lower_limit` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `stock_type` varchar(255) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `refundable` varchar(255) DEFAULT NULL,
  `sub_category_id` varchar(255) DEFAULT NULL,
  `hs_code` varchar(255) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `local_currency` varchar(255) DEFAULT NULL,
  `delivery_terms` varchar(255) DEFAULT NULL,
  `place_of_loading` varchar(255) DEFAULT NULL,
  `port_of_loading` varchar(255) DEFAULT NULL,
  `packing_type` varchar(255) DEFAULT NULL,
  `weight_per_unit` varchar(255) DEFAULT NULL,
  `dimensions_per_unit` varchar(255) DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `dynamic_data` varchar(255) DEFAULT NULL,
  `dynamic_data_technical` varchar(255) DEFAULT NULL,
  `dimensions_per_unit_type` varchar(255) DEFAULT NULL,
  `dimension_per_unit` varchar(255) DEFAULT NULL,
  `dimension_per_unit_type` varchar(255) DEFAULT NULL,
  `master_packing` varchar(255) DEFAULT NULL,
  `master_packing_unit` varchar(255) DEFAULT NULL,
  `weight_per_unit_type` varchar(255) DEFAULT NULL,
  `rate_unit` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `delivery_mode` varchar(255) NOT NULL,
  `payment_terms` varchar(255) NOT NULL,
  `certificate_name` varchar(255) NOT NULL,
  `pod_port` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `storages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_type` varchar(255) NOT NULL,
  `data_id` varchar(100) NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `business_type` varchar(255) NOT NULL,
  `main_products` varchar(255) NOT NULL,
  `management_certification` varchar(255) NOT NULL,
  `city_province` varchar(255) NOT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `priority` varchar(15) NOT NULL DEFAULT 'low',
  `description` varchar(255) DEFAULT NULL,
  `attachment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachment`)),
  `reply` varchar(255) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `support_ticket_convs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `customer_message` varchar(191) DEFAULT NULL,
  `attachment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachment`)),
  `admin_message` varchar(191) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `table_jobprofile` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `alternate_phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alternate_email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `highest_education` varchar(255) DEFAULT NULL,
  `field_of_study` varchar(255) DEFAULT NULL,
  `university_name` varchar(255) DEFAULT NULL,
  `graduation_year` year(4) DEFAULT NULL,
  `additional_courses` text DEFAULT NULL,
  `certifications` text DEFAULT NULL,
  `languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`languages`)),
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills`)),
  `bio` text DEFAULT NULL,
  `linkedin_profile` varchar(255) DEFAULT NULL,
  `portfolio_url` varchar(255) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `current_position` varchar(255) DEFAULT NULL,
  `current_employer` varchar(255) DEFAULT NULL,
  `work_experience` text DEFAULT NULL,
  `desired_position` varchar(255) DEFAULT NULL,
  `employment_type` varchar(255) DEFAULT NULL,
  `desired_salary` decimal(10,2) DEFAULT NULL,
  `relocation` tinyint(1) NOT NULL DEFAULT 0,
  `industry` varchar(255) DEFAULT NULL,
  `preferred_locations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`preferred_locations`)),
  `open_to_remote` tinyint(1) NOT NULL DEFAULT 0,
  `available_immediately` tinyint(1) NOT NULL DEFAULT 0,
  `availability_date` date DEFAULT NULL,
  `references` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`references`)),
  `hobbies` text DEFAULT NULL,
  `has_drivers_license` tinyint(1) NOT NULL DEFAULT 0,
  `visa_status` varchar(255) DEFAULT NULL,
  `passport_number` varchar(255) DEFAULT NULL,
  `has_criminal_record` tinyint(1) NOT NULL DEFAULT 0,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `short_term_goal` varchar(255) DEFAULT NULL,
  `long_term_goal` varchar(255) DEFAULT NULL,
  `seeking_internship` tinyint(1) NOT NULL DEFAULT 0,
  `open_to_contract` tinyint(1) NOT NULL DEFAULT 0,
  `github_profile` varchar(255) DEFAULT NULL,
  `behance_profile` varchar(255) DEFAULT NULL,
  `twitter_profile` varchar(255) DEFAULT NULL,
  `personal_website` varchar(255) DEFAULT NULL,
  `portfolio_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`portfolio_items`)),
  `videos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`videos`)),
  `profile_views` int(11) NOT NULL DEFAULT 0,
  `applications_sent` int(11) NOT NULL DEFAULT 0,
  `connections` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `previous_employers` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(191) NOT NULL,
  `visit_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tradeshows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `hall` varchar(255) NOT NULL,
  `stand` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `company_icon` varchar(255) NOT NULL,
  `featured` varchar(255) NOT NULL,
  `popularity` varchar(255) NOT NULL,
  `phone` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `timeline` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`timeline`)),
  `clicks` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `trade_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `payment_for` varchar(100) DEFAULT NULL,
  `payer_id` bigint(20) DEFAULT NULL,
  `payment_receiver_id` bigint(20) DEFAULT NULL,
  `paid_by` varchar(15) DEFAULT NULL,
  `paid_to` varchar(15) DEFAULT NULL,
  `payment_method` varchar(15) DEFAULT NULL,
  `payment_status` varchar(10) NOT NULL DEFAULT 'success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `transaction_type` varchar(191) DEFAULT NULL,
  `order_details_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `translations` (
  `translationable_type` varchar(191) NOT NULL,
  `translationable_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) NOT NULL,
  `key` varchar(191) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `phone` varchar(25) NOT NULL,
  `image` varchar(30) NOT NULL DEFAULT 'def.png',
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(80) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `street_address` varchar(250) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `house_no` varchar(50) DEFAULT NULL,
  `apartment_no` varchar(50) DEFAULT NULL,
  `cm_firebase_token` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `payment_card_last_four` varchar(191) DEFAULT NULL,
  `payment_card_brand` varchar(191) DEFAULT NULL,
  `payment_card_fawry_token` text DEFAULT NULL,
  `login_medium` varchar(191) DEFAULT NULL,
  `social_id` varchar(191) DEFAULT NULL,
  `is_phone_verified` tinyint(1) NOT NULL DEFAULT 0,
  `temporary_token` varchar(191) DEFAULT NULL,
  `is_email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `wallet_balance` double(8,2) DEFAULT NULL,
  `loyalty_point` double(8,2) DEFAULT NULL,
  `login_hit_count` tinyint(4) NOT NULL DEFAULT 0,
  `is_temp_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `temp_block_time` timestamp NULL DEFAULT NULL,
  `referral_code` varchar(255) DEFAULT NULL,
  `referred_by` int(11) DEFAULT NULL,
  `app_language` varchar(191) NOT NULL DEFAULT 'en',
  `membership_id` bigint(20) NOT NULL,
  `membership` varchar(255) NOT NULL,
  `chat_id` bigint(20) NOT NULL,
  `membership_status` varchar(255) NOT NULL,
  `current_chatrooms` varchar(255) NOT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `typerole` varchar(255) NOT NULL DEFAULT 'customer',
  `terms_accepted` int(255) NOT NULL DEFAULT 0,
  `mem_benefits` longtext DEFAULT NULL,
  `lead_notif` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vacancies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `salary_low` decimal(10,2) DEFAULT NULL,
  `employment_type` enum('Full-Time','Part-Time','Contract','Freelance') NOT NULL DEFAULT 'Full-Time',
  `status` enum('active','inactive','closed') NOT NULL DEFAULT 'active',
  `category` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` text DEFAULT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `vacancies` int(11) NOT NULL DEFAULT 1,
  `location` varchar(255) DEFAULT NULL,
  `remote` tinyint(1) NOT NULL DEFAULT 0,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `experience_required` int(11) DEFAULT NULL,
  `education_level` varchar(255) DEFAULT NULL,
  `skills_required` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills_required`)),
  `certifications_required` text DEFAULT NULL,
  `visa_sponsorship` tinyint(1) NOT NULL DEFAULT 0,
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`benefits`)),
  `application_deadline` date DEFAULT NULL,
  `application_process` text DEFAULT NULL,
  `application_link` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `applications_received` int(11) NOT NULL DEFAULT 0,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `Approved` enum('0','1','2') NOT NULL,
  `currency` varchar(255) NOT NULL,
  `salary_high` varchar(255) NOT NULL,
  `company_employees` varchar(255) NOT NULL,
  `company_type` varchar(255) NOT NULL,
  `employment_space` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vendor_extra_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `registered_business_name` varchar(255) DEFAULT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `year_of_establishment` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `country_of_registration` varchar(255) DEFAULT NULL,
  `tax_id` varchar(255) DEFAULT NULL,
  `tax_expiry` date DEFAULT NULL,
  `industry_category` varchar(255) DEFAULT NULL,
  `main_products_services` text DEFAULT NULL,
  `head_office_address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `alt_contact` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `swift_code` varchar(255) DEFAULT NULL,
  `bank_address` text DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `local_branches` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`local_branches`)),
  `overseas_offices` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`overseas_offices`)),
  `export_countries` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`export_countries`)),
  `warehousing_locations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`warehousing_locations`)),
  `business_license_path` varchar(255) DEFAULT NULL,
  `tax_certificate_path` varchar(255) DEFAULT NULL,
  `import_export_license_path` varchar(255) DEFAULT NULL,
  `bank_proof_path` varchar(255) DEFAULT NULL,
  `authority_id_path` varchar(255) DEFAULT NULL,
  `authority_name` varchar(255) DEFAULT NULL,
  `authority_designation` varchar(255) DEFAULT NULL,
  `authority_contact` varchar(255) DEFAULT NULL,
  `authority_email` varchar(255) DEFAULT NULL,
  `business_card_path` varchar(255) DEFAULT NULL,
  `is_operational` tinyint(1) NOT NULL DEFAULT 0,
  `is_info_verified` tinyint(1) NOT NULL DEFAULT 0,
  `has_authorized_consent` tinyint(1) NOT NULL DEFAULT 0,
  `authorized_name` varchar(255) DEFAULT NULL,
  `authorized_signature_path` varchar(255) DEFAULT NULL,
  `company_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`company_images`)),
  `factory_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`factory_images`)),
  `seller_id` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seller_users` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vendor_registration_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vendor_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_complete` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` char(36) NOT NULL,
  `credit` decimal(24,3) NOT NULL DEFAULT 0.000,
  `debit` decimal(24,3) NOT NULL DEFAULT 0.000,
  `admin_bonus` decimal(24,3) NOT NULL DEFAULT 0.000,
  `balance` decimal(24,3) NOT NULL DEFAULT 0.000,
  `transaction_type` varchar(191) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `reference` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `withdrawal_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_name` varchar(191) NOT NULL,
  `method_fields` text NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `withdraw_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `delivery_man_id` bigint(20) DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `amount` varchar(191) NOT NULL DEFAULT '0.00',
  `withdrawal_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `withdrawal_method_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `transaction_note` text DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `addon_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_settings_id_index` (`id`);

ALTER TABLE `add_fund_bonus_categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admin_wallets`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admin_wallet_histories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `billing_addresses`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cart_shippings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `category_shipping_costs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `chats_others`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_others_leads_id_foreign` (`leads_id`),
  ADD KEY `chats_others_suppliers_id_foreign` (`suppliers_id`),
  ADD KEY `fk_stocksell_id` (`stocksell_id`);

ALTER TABLE `chattings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_test_ibfk_1` (`state_id`),
  ADD KEY `cities_test_ibfk_2` (`country_id`);

ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_continent` (`region_id`),
  ADD KEY `country_subregion` (`subregion_id`);

ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customer_wallets`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customer_wallet_histories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `deal_assist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `deal_of_the_days`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `deliveryman_notifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `deliveryman_wallets`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `delivery_country_codes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `delivery_histories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `delivery_man_transactions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `delivery_men`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `delivery_zip_codes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `digital_product_authors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `digital_product_otp_verifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `digital_product_publishing_houses`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `digital_product_variations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `error_logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `feature_deals`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flash_deals`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flash_deal_products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `guest_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `help_topics`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

ALTER TABLE `job_appliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_appliers_admin_id_foreign` (`admin_id`),
  ADD KEY `job_appliers_user_id_foreign` (`user_id`),
  ADD KEY `job_appliers_jobid_foreign` (`jobid`);

ALTER TABLE `job_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `job_search_logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `login_setups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `loyalty_point_transactions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memberships_membership_id_foreign` (`membership_id`);

ALTER TABLE `membership_tiers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `most_demandeds`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `new_product_stores`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notification_messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notification_seens`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

ALTER TABLE `offline_payments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `offline_payment_methods`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_delivery_verifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_expected_delivery_histories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_status_histories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_transactions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`identity`);

ALTER TABLE `paytabs_invoices`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

ALTER TABLE `phone_or_email_verifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_compares`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_seos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_tag`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `publishing_houses`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `refund_statuses`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `refund_transactions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `review_replies`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `robots_meta_contents`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `search_functions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sellers_email_unique` (`email`),
  ADD KEY `sellers_supplier_id_foreign` (`supplier_id`);

ALTER TABLE `seller_wallets`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `seller_wallet_histories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shipping_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shop_followers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shortlist_candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shortlist_candidates_jobid_foreign` (`jobid`),
  ADD KEY `shortlist_candidates_recruiter_id_foreign` (`recruiter_id`),
  ADD KEY `shortlist_applier_id` (`applier_id`);

ALTER TABLE `social_medias`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `soft_credentials`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `solutions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `solution_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solution_categories_solution_id_foreign` (`solution_id`);

ALTER TABLE `solution_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solution_sub_categories_solution_category_id_foreign` (`solution_category_id`);

ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_region` (`country_id`);

ALTER TABLE `stock_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stock_sell`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `storages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `storages_data_id_index` (`data_id`),
  ADD KEY `storages_value_index` (`value`);

ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `support_ticket_convs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `table_jobprofile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_jobprofile_user_id_foreign` (`user_id`);

ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tradeshows`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `trade_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transactions`
  ADD UNIQUE KEY `transactions_id_unique` (`id`);

ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_translationable_id_index` (`translationable_id`),
  ADD KEY `translations_locale_index` (`locale`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacancies_user_id_foreign` (`user_id`),
  ADD KEY `admin_id_foreingkey` (`admin_id`);

ALTER TABLE `vendor_extra_details`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `vendor_registration_reasons`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `vendor_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `withdrawal_methods`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `withdraw_requests`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `add_fund_bonus_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `admin_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `admin_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `admin_wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `billing_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `business_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `cart_shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

ALTER TABLE `category_shipping_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

ALTER TABLE `chats_others`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

ALTER TABLE `chattings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `cities`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154152;

ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

ALTER TABLE `company_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `countries`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `customer_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `customer_wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `deal_assist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `deal_of_the_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `deliveryman_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `deliveryman_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `delivery_country_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `delivery_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `delivery_man_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `delivery_men`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `delivery_zip_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `digital_product_authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `digital_product_otp_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `digital_product_publishing_houses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `digital_product_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `emergency_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `error_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6507;

ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `faq`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `feature_deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `flash_deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `flash_deal_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `guest_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11219;

ALTER TABLE `help_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `job_appliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `job_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `job_search_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

ALTER TABLE `login_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `loyalty_point_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `memberships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `membership_tiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

ALTER TABLE `most_demandeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `new_product_stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `notification_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

ALTER TABLE `notification_seens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `offline_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `offline_payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100005;

ALTER TABLE `order_delivery_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `order_expected_delivery_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `order_status_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `order_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `paytabs_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `phone_or_email_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=362;

ALTER TABLE `product_compares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_seos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `publishing_houses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `refund_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `refund_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `refund_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `review_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `robots_meta_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `search_functions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

ALTER TABLE `sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

ALTER TABLE `seller_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `seller_wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `shipping_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `shop_followers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `shortlist_candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `social_medias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `soft_credentials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `solutions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `solution_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `solution_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

ALTER TABLE `states`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5321;

ALTER TABLE `stock_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `stock_sell`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

ALTER TABLE `storages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `support_ticket_convs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `table_jobprofile`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

ALTER TABLE `tradeshows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `trade_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `vacancies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `vendor_extra_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `vendor_registration_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `vendor_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `withdrawal_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `withdraw_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `chats_others`
  ADD CONSTRAINT `fk_stocksell_id` FOREIGN KEY (`stocksell_id`) REFERENCES `stock_sell` (`id`) ON DELETE CASCADE;

ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `cities_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

ALTER TABLE `countries`
  ADD CONSTRAINT `country_continent_final` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `country_subregion_final` FOREIGN KEY (`subregion_id`) REFERENCES `subregions` (`id`);

ALTER TABLE `job_appliers`
  ADD CONSTRAINT `job_appliers_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_appliers_jobid_foreign` FOREIGN KEY (`jobid`) REFERENCES `vacancies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_appliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `shortlist_candidates`
  ADD CONSTRAINT `shortlist_applier_id` FOREIGN KEY (`applier_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shortlist_candidates_jobid_foreign` FOREIGN KEY (`jobid`) REFERENCES `vacancies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shortlist_candidates_recruiter_id_foreign` FOREIGN KEY (`recruiter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `solution_categories`
  ADD CONSTRAINT `solution_categories_solution_id_foreign` FOREIGN KEY (`solution_id`) REFERENCES `solutions` (`id`) ON DELETE CASCADE;

ALTER TABLE `solution_sub_categories`
  ADD CONSTRAINT `solution_sub_categories_solution_category_id_foreign` FOREIGN KEY (`solution_category_id`) REFERENCES `solution_categories` (`id`) ON DELETE CASCADE;

ALTER TABLE `states`
  ADD CONSTRAINT `country_region_final` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

ALTER TABLE `table_jobprofile`
  ADD CONSTRAINT `table_jobprofile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `vacancies`
  ADD CONSTRAINT `admin_id_foreingkey` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vacancies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

