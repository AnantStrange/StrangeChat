START TRANSACTION;
SET time_zone = "+00:00";

create database if not exists StrangeChat;
use StrangeChat;

CREATE TABLE if not exists `users` (
  `id` SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(25) UNIQUE,
  `password` varchar(256) NOT NULL,
  `userrole` varchar(10) NOT NULL DEFAULT "guest",
  `status` varchar(10) NOT NULL DEFAULT "active",
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists `users_logged_in` (
  `id` SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(25) UNIQUE,
  `session_id` varchar(40) NOT NULL UNIQUE,
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  last_activity TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`username`),
  INDEX (`session_id`),
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists `messages` (
  `id` SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `sender` varchar(25) NOT NULL,
  `receiver` varchar(10) NOT NULL DEFAULT "guest",
  `visibility_level` TINYINT  NOT NULL DEFAULT 3,
  `pm` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `tag` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `text` text NOT NULL,
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`sender`),
  INDEX (`receiver`),
  INDEX (`pm`),
  INDEX (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE if not exists message_pms (
    msg_id SMALLINT UNSIGNED,
    user_id SMALLINT UNSIGNED,
    PRIMARY KEY (msg_id, user_id),
    FOREIGN KEY (msg_id) REFERENCES messages(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE if not exists message_tags (
    msg_id SMALLINT UNSIGNED,
    user_id SMALLINT UNSIGNED,
    PRIMARY KEY (msg_id, user_id),
    FOREIGN KEY (msg_id) REFERENCES messages(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(25) UNIQUE,
  `setting` JSON NOT NULL CHECK (JSON_VALID(setting)),
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `public_notes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(25) UNIQUE,
  `note` TEXT NOT NULL,
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `personal_notes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(25) UNIQUE,
  `note` TEXT NOT NULL,
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `suggestions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(25) UNIQUE,
  `suggestion` TEXT NOT NULL,
  `dt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`username`),
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (username, password, userrole, status)
VALUES ('void', 'voidpassword', 'admin', 'active');

INSERT INTO users (username, password, userrole, status)
VALUES ('SuggestionBox', 'suggestionpassword', 'admin', 'active');



COMMIT;
