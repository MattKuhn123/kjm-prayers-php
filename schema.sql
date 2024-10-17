CREATE TABLE IF NOT EXISTS `kjm`.`prayers` (
  `first_name` VARCHAR(32) NOT NULL,
  `last_name` VARCHAR(32) NOT NULL,
  `county` VARCHAR(16) NOT NULL,
  `date` DATE NOT NULL,
  `prayer` VARCHAR(512) NULL,
  PRIMARY KEY (`first_name`, `last_name`, `county`, `date`));

  CREATE TABLE `kjm`.`users` (
  `email` varchar(64) NOT NULL,
  `code` varchar(64) DEFAULT NULL,
  `code_expires` date DEFAULT NULL,
  `can_pray` tinyint(1) NOT NULL DEFAULT '0',
  `can_publish` tinyint(1) NOT NULL DEFAULT '0',
  `can_edit_users` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email`)
)