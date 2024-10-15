-- Create the offices table first
CREATE TABLE `offices` (
  `office_id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `phone_number` VARCHAR(45) NOT NULL,
  `fname` VARCHAR(100) NOT NULL,
  `reset_code` VARCHAR(50) DEFAULT NULL,
  `code_expiry` DATETIME DEFAULT NULL,
  PRIMARY KEY (`office_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Then create the files table
CREATE TABLE `files` (
  `file_id` INT(11) NOT NULL AUTO_INCREMENT,
  `file_name` VARCHAR(100) DEFAULT NULL,
  `file_path` VARCHAR(100) DEFAULT NULL,
  `sender_office_id` INT(11) NOT NULL,
  `receiver_office_id` INT(255) NOT NULL,
  `message` TEXT DEFAULT NULL,
  `time_sent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`file_id`),
  KEY `sender_office_id` (`sender_office_id`),
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`sender_office_id`) REFERENCES `offices` (`office_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for `mails`
CREATE TABLE `mails` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `recipient_email` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(255) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `attachment` VARCHAR(50) DEFAULT NULL,
  `sent_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
