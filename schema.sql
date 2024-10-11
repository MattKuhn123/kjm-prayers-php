CREATE TABLE IF NOT EXISTS `kjm`.`prayers` (
  `first_name` VARCHAR(32) NOT NULL,
  `last_name` VARCHAR(32) NOT NULL,
  `county` VARCHAR(16) NOT NULL,
  `date` DATE NOT NULL,
  `prayer` VARCHAR(512) NULL,
  PRIMARY KEY (`first_name`, `last_name`, `county`, `date`));