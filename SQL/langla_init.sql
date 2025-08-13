-- Tạo database nếu chưa có
CREATE DATABASE IF NOT EXISTS `langla` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `langla`;

-- Tạo bảng player với cấu trúc đầy đủ theo yêu cầu
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `vnd` bigint(20) DEFAULT 10000000,
  `characterName` varchar(100) DEFAULT '',
  `tongnap` bigint(20) DEFAULT 0,
  `top-level` int(11) DEFAULT 0,
  `ref_id` int(11) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `ref_id` (`ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu nếu cần
INSERT INTO `player` (`username`, `password`, `mobile`, `vnd`, `characterName`, `tongnap`, `top-level`) VALUES
('admin', 'admin123', '0123456789', 100000000, 'Admin', 0, 0);
