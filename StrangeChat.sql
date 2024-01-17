START TRANSACTION;
SET time_zone = "+00:00";

create database if not exists StrangeChat;
use StrangeChat;

CREATE TABLE if not exists `users` (
  `id` SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(25) UNIQUE,
  `password` varchar(256) NOT NULL,
  `userRole` varchar(10) not null DEFAULT "guest",
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists `users_logged_in` (
  `id` SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(25) UNIQUE,
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_activity` TIMESTAMP NOT NULL,
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists `messages` (
  `id` SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `sender` varchar(25) NOT NULL,
  `receiver` varchar(10) NOT NULL DEFAULT "guest",
  `visibility_level` TINYINT UNSIGNED NOT NULL DEFAULT 3,
  `pm` varchar(25) NOT NULL DEFAULT '-1',
  `tag` varchar(25) NOT NULL DEFAULT '-1',
  `text` text NOT NULL,
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`sender`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`receiver`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX (`sender`),
  INDEX (`receiver`),
  INDEX (`pm`),
  INDEX (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists `user_settings` (
  `id` int(8) AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(25) UNIQUE,
  `setting` json NOT NULL
  CHECK (JSON_VALID(setting))
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists "notes" (
  "id" int(8) AUTO_INCREMENT primary key,
  "username" varchar(25) UNIQUE,
  "note" text NOT NULL,
  FOREIGN KEY ("username") REFERENCES "users" ("username") ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


COMMIT;
