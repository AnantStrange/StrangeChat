START TRANSACTION;
SET time_zone = "+00:00";

create database if not exists StrangeChat;
use StrangeChat;

CREATE TABLE if not exists `users` (
  `username` varchar(25) PRIMARY KEY,
  `password` varchar(256) NOT NULL,
  `role` varchar(10) DEFAULT "guest",
  `dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists `users_logged_in` (
  `username` varchar(25) PRIMARY KEY,
  `dt` datetime NOT NULL DEFAULT current_timestamp(),
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

CREATE TABLE if not exists `messages` (
    `id` int(8) AUTO_INCREMENT primary key,
    `sender` varchar(25) NOT NULL,
    `receiver` varchar(25) NOT NULL DEFAULT 'everyone',
    `text` text NOT NULL,
    `dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists `user_settings` (
  `username` varchar(25) primary key,
  `settings` text NOT NULL,
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



COMMIT;
