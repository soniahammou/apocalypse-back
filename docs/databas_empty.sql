-- Adminer 4.8.1 MySQL 10.6.16-MariaDB-0ubuntu0.22.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `email` varchar(255) NOT NULL,
                        `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
                        `password` varchar(255) NOT NULL,
                        `firstname` varchar(64) NOT NULL,
                        `lastname` varchar(64) NOT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `title` varchar(255) NOT NULL,
                            `content` longtext NOT NULL,
                            `created_at` datetime NOT NULL,
                            `updated_at` datetime DEFAULT NULL,
                            `user_id` int(11) DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            KEY `IDX_B6F7494EA76ED395` (`user_id`),
                            CONSTRAINT `FK_B6F7494EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `content` longtext NOT NULL,
                          `created_at` datetime NOT NULL,
                          `updated_at` datetime DEFAULT NULL,
                          `question_id` int(11) DEFAULT NULL,
                          `user_id` int(11) DEFAULT NULL,
                          PRIMARY KEY (`id`),
                          KEY `IDX_DADD4A251E27F6BF` (`question_id`),
                          KEY `IDX_DADD4A25A76ED395` (`user_id`),
                          CONSTRAINT `FK_DADD4A251E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
                          CONSTRAINT `FK_DADD4A25A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(64) NOT NULL,
                            `home_order` int(11) NOT NULL,
                            `picture` varchar(255) DEFAULT NULL,
                            `updated_at` datetime DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(64) NOT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `title` varchar(255) NOT NULL,
                           `summary` varchar(255) NOT NULL,
                           `content` longtext NOT NULL,
                           `slug` varchar(255) NOT NULL,
                           `created_at` datetime NOT NULL,
                           `updated_at` datetime DEFAULT NULL,
                           `picture` varchar(400) DEFAULT NULL,
                           `user_id` int(11) DEFAULT NULL,
                           `category_id` int(11) DEFAULT NULL,
                           `status_id` int(11) NOT NULL,
                           PRIMARY KEY (`id`),
                           KEY `IDX_23A0E66A76ED395` (`user_id`),
                           KEY `IDX_23A0E6612469DE2` (`category_id`),
                           KEY `IDX_23A0E666BF700BD` (`status_id`),
                           CONSTRAINT `FK_23A0E6612469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL,
                           CONSTRAINT `FK_23A0E666BF700BD` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
                           CONSTRAINT `FK_23A0E66A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` varchar(255) NOT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` varchar(64) NOT NULL,
                        `icon_url` varchar(255) NOT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `pinpoint`;
CREATE TABLE `pinpoint` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `description` longtext NOT NULL,
                            `created_at` datetime NOT NULL,
                            `updated_at` datetime DEFAULT NULL,
                            `latitude` double NOT NULL,
                            `longitude` double NOT NULL,
                            `type_id` int(11) NOT NULL,
                            `user_id` int(11) DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            KEY `IDX_94252DDCC54C8C93` (`type_id`),
                            KEY `IDX_94252DDCA76ED395` (`user_id`),
                            CONSTRAINT `FK_94252DDCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
                            CONSTRAINT `FK_94252DDCC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `search_notice`;
CREATE TABLE `search_notice` (
                                 `id` int(11) NOT NULL AUTO_INCREMENT,
                                 `firstname` varchar(64) NOT NULL,
                                 `lastname` varchar(64) NOT NULL,
                                 `home` varchar(255) DEFAULT NULL,
                                 `description` longtext NOT NULL,
                                 `age` int(11) DEFAULT NULL,
                                 `picture` varchar(255) DEFAULT NULL,
                                 `status` int(11) NOT NULL,
                                 `created_at` datetime NOT NULL,
                                 `updated_at` datetime DEFAULT NULL,
                                 `latest_city` varchar(255) DEFAULT NULL,
                                 `latest_date` datetime DEFAULT NULL,
                                 `user_id` int(11) DEFAULT NULL,
                                 PRIMARY KEY (`id`),
                                 KEY `IDX_91EF2ADDA76ED395` (`user_id`),
                                 CONSTRAINT `FK_91EF2ADDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `report`;
CREATE TABLE `report` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `count` int(11) NOT NULL,
                          `date` datetime NOT NULL,
                          `search_notice_id` int(11) DEFAULT NULL,
                          `city_id` int(11) DEFAULT NULL,
                          PRIMARY KEY (`id`),
                          KEY `IDX_C42F7784BCCE5003` (`search_notice_id`),
                          KEY `IDX_C42F77848BAC62AF` (`city_id`),
                          CONSTRAINT `FK_C42F77848BAC62AF` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE CASCADE,
                          CONSTRAINT `FK_C42F7784BCCE5003` FOREIGN KEY (`search_notice_id`) REFERENCES `search_notice` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2024-06-20 09:28:53