-- =============================================
-- ShipEasy - Database MySQL
-- Jalankan file ini di phpMyAdmin atau MySQL CLI
-- =============================================

CREATE DATABASE IF NOT EXISTS `shipper_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `shipper_db`;

-- Users
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','courier','customer') NOT NULL DEFAULT 'customer',
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Zones
CREATE TABLE `zones` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Rates
CREATE TABLE `rates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `origin_zone_id` bigint UNSIGNED NOT NULL,
  `destination_zone_id` bigint UNSIGNED NOT NULL,
  `service_type` enum('regular','express','same_day') NOT NULL DEFAULT 'regular',
  `price_per_kg` decimal(10,2) NOT NULL,
  `min_weight` decimal(5,2) NOT NULL DEFAULT 1.00,
  `estimated_days` int NOT NULL DEFAULT 3,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`origin_zone_id`) REFERENCES `zones`(`id`),
  FOREIGN KEY (`destination_zone_id`) REFERENCES `zones`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Couriers
CREATE TABLE `couriers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `courier_code` varchar(20) NOT NULL UNIQUE,
  `vehicle_type` enum('motor','mobil','truck') NOT NULL DEFAULT 'motor',
  `vehicle_plate` varchar(20) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Orders
CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `resi_number` varchar(30) NOT NULL UNIQUE,
  `user_id` bigint UNSIGNED NOT NULL,
  `courier_id` bigint UNSIGNED DEFAULT NULL,
  `origin_zone_id` bigint UNSIGNED NOT NULL,
  `destination_zone_id` bigint UNSIGNED NOT NULL,
  `service_type` enum('regular','express','same_day') NOT NULL DEFAULT 'regular',
  `sender_name` varchar(100) NOT NULL,
  `sender_phone` varchar(20) NOT NULL,
  `sender_address` text NOT NULL,
  `sender_city` varchar(100) NOT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `receiver_phone` varchar(20) NOT NULL,
  `receiver_address` text NOT NULL,
  `receiver_city` varchar(100) NOT NULL,
  `package_name` varchar(200) NOT NULL,
  `package_type` enum('regular','fragile','document','elektronik') NOT NULL DEFAULT 'regular',
  `weight` decimal(8,2) NOT NULL,
  `length` decimal(8,2) DEFAULT NULL,
  `width` decimal(8,2) DEFAULT NULL,
  `height` decimal(8,2) DEFAULT NULL,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT 0,
  `insurance_cost` decimal(12,2) NOT NULL DEFAULT 0,
  `total_cost` decimal(12,2) NOT NULL DEFAULT 0,
  `current_status` enum('pending','pickup','in_transit','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `estimated_delivery` date DEFAULT NULL,
  `delivered_at` timestamp DEFAULT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`courier_id`) REFERENCES `couriers`(`id`),
  FOREIGN KEY (`origin_zone_id`) REFERENCES `zones`(`id`),
  FOREIGN KEY (`destination_zone_id`) REFERENCES `zones`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order Statuses (tracking timeline)
CREATE TABLE `order_statuses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','pickup','in_transit','delivered','cancelled') NOT NULL,
  `description` text NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`),
  FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password Resets
CREATE TABLE `password_reset_tokens` (
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sessions
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- SEED DATA
-- =============================================

-- Users (password: password)
INSERT INTO `users` (`name`,`email`,`password`,`role`,`phone`,`is_active`,`created_at`,`updated_at`) VALUES
('Administrator','admin@shipper.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin','081234567890',1,NOW(),NOW()),
('Budi Santoso','kurir@shipper.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','courier','081234567891',1,NOW(),NOW()),
('Andi Wijaya','customer@shipper.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','customer','081234567892',1,NOW(),NOW()),
('Siti Rahma','customer2@shipper.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','customer','081234567893',1,NOW(),NOW()),
('Dedi Kurniawan','kurir2@shipper.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','courier','081234567894',1,NOW(),NOW());

-- Zones
INSERT INTO `zones` (`name`,`province`,`city`,`postal_code`,`is_active`,`created_at`,`updated_at`) VALUES
('Jakarta Pusat','DKI Jakarta','Jakarta Pusat','10110',1,NOW(),NOW()),
('Jakarta Selatan','DKI Jakarta','Jakarta Selatan','12110',1,NOW(),NOW()),
('Surabaya Pusat','Jawa Timur','Surabaya','60271',1,NOW(),NOW()),
('Bandung Kota','Jawa Barat','Bandung','40111',1,NOW(),NOW()),
('Yogyakarta Kota','DI Yogyakarta','Yogyakarta','55111',1,NOW(),NOW()),
('Semarang Kota','Jawa Tengah','Semarang','50111',1,NOW(),NOW()),
('Medan Kota','Sumatera Utara','Medan','20111',1,NOW(),NOW()),
('Makassar Kota','Sulawesi Selatan','Makassar','90111',1,NOW(),NOW());

-- Rates
INSERT INTO `rates` (`origin_zone_id`,`destination_zone_id`,`service_type`,`price_per_kg`,`min_weight`,`estimated_days`,`is_active`,`created_at`,`updated_at`) VALUES
(1,2,'regular',8000,1,1,1,NOW(),NOW()),(1,2,'express',15000,1,1,1,NOW(),NOW()),
(1,3,'regular',12000,1,3,1,NOW(),NOW()),(1,3,'express',22000,1,2,1,NOW(),NOW()),
(1,4,'regular',10000,1,2,1,NOW(),NOW()),(1,4,'express',18000,1,1,1,NOW(),NOW()),
(1,5,'regular',12000,1,2,1,NOW(),NOW()),(1,5,'express',22000,1,2,1,NOW(),NOW()),
(1,6,'regular',11000,1,2,1,NOW(),NOW()),(1,6,'express',20000,1,1,1,NOW(),NOW()),
(1,7,'regular',18000,1,4,1,NOW(),NOW()),(1,7,'express',30000,1,3,1,NOW(),NOW()),
(1,8,'regular',20000,1,5,1,NOW(),NOW()),(1,8,'express',35000,1,3,1,NOW(),NOW()),
(3,1,'regular',12000,1,3,1,NOW(),NOW()),(3,1,'express',22000,1,2,1,NOW(),NOW()),
(3,4,'regular',12000,1,2,1,NOW(),NOW()),(3,4,'express',22000,1,1,1,NOW(),NOW()),
(4,1,'regular',10000,1,2,1,NOW(),NOW()),(4,1,'express',18000,1,1,1,NOW(),NOW());

-- Couriers
INSERT INTO `couriers` (`user_id`,`courier_code`,`vehicle_type`,`vehicle_plate`,`is_available`,`created_at`,`updated_at`) VALUES
(2,'KUR-001','motor','B 1234 ABC',1,NOW(),NOW()),
(5,'KUR-002','mobil','B 5678 DEF',1,NOW(),NOW());

-- Sample Orders
INSERT INTO `orders` (`resi_number`,`user_id`,`courier_id`,`origin_zone_id`,`destination_zone_id`,`service_type`,`sender_name`,`sender_phone`,`sender_address`,`sender_city`,`receiver_name`,`receiver_phone`,`receiver_address`,`receiver_city`,`package_name`,`package_type`,`weight`,`shipping_cost`,`total_cost`,`current_status`,`estimated_delivery`,`created_at`,`updated_at`) VALUES
('SHP-20240101-0001',3,1,1,3,'regular','Andi Wijaya','081234567892','Jl. Sudirman No.1','Jakarta Pusat','Tono Wibowo','085678901234','Jl. Pemuda No.10','Surabaya','Pakaian Batik','regular',2.00,24000,24000,'delivered','2024-01-04',NOW(),NOW()),
('SHP-20240102-0002',4,1,4,3,'express','Siti Rahma','081234567893','Jl. Asia Afrika No.5','Bandung','Rina Susanti','087890123456','Jl. Basuki Rahmat No.20','Surabaya','Sepatu Olahraga','regular',1.50,33000,33000,'in_transit','2024-01-04',NOW(),NOW()),
('SHP-20240103-0003',3,NULL,1,5,'regular','Andi Wijaya','081234567892','Jl. Sudirman No.1','Jakarta Pusat','Joko Purnomo','089012345678','Jl. Malioboro No.8','Yogyakarta','Dokumen Penting','document',0.50,12000,12000,'pending',NULL,NOW(),NOW());

-- Order Statuses
INSERT INTO `order_statuses` (`order_id`,`status`,`description`,`location`,`updated_by`,`created_at`,`updated_at`) VALUES
(1,'pending','Pesanan diterima, menunggu pickup','Jakarta Pusat',1,NOW(),NOW()),
(1,'pickup','Paket telah di-pickup oleh kurir','Jakarta Pusat',2,NOW(),NOW()),
(1,'in_transit','Paket sedang dalam perjalanan','Semarang',2,NOW(),NOW()),
(1,'delivered','Paket berhasil diterima penerima','Surabaya',2,NOW(),NOW()),
(2,'pending','Pesanan diterima, menunggu pickup','Bandung',1,NOW(),NOW()),
(2,'pickup','Paket telah di-pickup oleh kurir','Bandung',2,NOW(),NOW()),
(2,'in_transit','Paket sedang dalam perjalanan','Semarang',2,NOW(),NOW()),
(3,'pending','Pesanan diterima, menunggu konfirmasi admin','Jakarta Pusat',1,NOW(),NOW());
