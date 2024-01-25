START TRANSACTION;
SET time_zone = "+00:00";

create database if not exists StrangeChat;
use StrangeChat;

CREATE TABLE if not exists `users` (
  `id` SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(25) UNIQUE,
  `password` varchar(256) NOT NULL,
  `userrole` varchar(10) not null DEFAULT "guest",
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists `users_logged_in` (
  `id` SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(25) UNIQUE,
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  last_activity TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`username`),
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists `messages` (
  `id` SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `sender` varchar(25) NOT NULL,
  `receiver` varchar(10) NOT NULL DEFAULT "guest",
  `visibility_level` TINYINT UNSIGNED NOT NULL DEFAULT 3,
  `pm` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `tag` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `text` text NOT NULL,
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`sender`),
  INDEX (`receiver`),
  INDEX (`pm`),
  INDEX (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE message_tags (
    msg_id SMALLINT UNSIGNED,
    user_id SMALLINT UNSIGNED,
    PRIMARY KEY (msg_id, user_id),
    FOREIGN KEY (msg_id) REFERENCES messages(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(25) UNIQUE,
  `setting` JSON NOT NULL CHECK (JSON_VALID(setting)),
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `notes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(25) UNIQUE,
  `note` TEXT NOT NULL,
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
