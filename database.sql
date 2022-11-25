
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema test
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8 ;
USE `test` ;

-- -----------------------------------------------------
-- Table `test`.`Countries`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test`.`Countries` (
                                                  `ID` INT NOT NULL AUTO_INCREMENT,
                                                  `Name` ENUM('RU', 'US', 'CH', 'MX') NOT NULL,
                                                  `Prefix` ENUM('+7', '+1', '+86', '+52', '+1905') NOT NULL,
                                                  PRIMARY KEY (`ID`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test`.`Phones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test`.`Phones` (
                                               `ID` INT NOT NULL AUTO_INCREMENT,
                                               `phone` VARCHAR(45) NOT NULL,
                                               `countryID` INT NOT NULL,
                                               PRIMARY KEY (`ID`, `countryID`),
                                               INDEX `fk_Phones_Countries_idx` (`countryID` ASC),
                                               CONSTRAINT `fk_Phones_Countries`
                                                   FOREIGN KEY (`countryID`)
                                                       REFERENCES `test`.`Countries` (`ID`)
                                                       ON DELETE NO ACTION
                                                       ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test`.`Reviews`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test`.`Reviews` (
                                                `ID` INT NOT NULL AUTO_INCREMENT,
                                                `Review` MEDIUMTEXT NOT NULL,
                                                `author` VARCHAR(45) NOT NULL,
                                                `phoneID` INT NOT NULL,
                                                PRIMARY KEY (`ID`, `phoneID`),
                                                INDEX `fk_Reviews_Phones1_idx` (`phoneID` ASC),
                                                CONSTRAINT `fk_Reviews_Phones1`
                                                    FOREIGN KEY (`phoneID`)
                                                        REFERENCES `test`.`Phones` (`ID`)
                                                        ON DELETE NO ACTION
                                                        ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test`.`Votes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test`.`Votes` (
                                              `ID` INT NOT NULL AUTO_INCREMENT,
                                              `rating` TINYINT(10) NULL,
                                              `IP` VARCHAR(45) NOT NULL,
                                              `ReviewID` INT NOT NULL,
                                              PRIMARY KEY (`ID`, `ReviewID`),
                                              INDEX `fk_Votes_Reviews1_idx` (`ReviewID` ASC),
                                              CONSTRAINT `fk_Votes_Reviews1`
                                                  FOREIGN KEY (`ReviewID`)
                                                      REFERENCES `test`.`Reviews` (`ID`)
                                                      ON DELETE NO ACTION
                                                      ON UPDATE NO ACTION)
    ENGINE = InnoDB;

-- TODO: Add Tables Users, Roles

CREATE USER 'admin' IDENTIFIED BY 'SomePass';

GRANT ALL ON `test`.* TO 'admin';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO `test`.`Countries`
(`ID`,
 `Name`,
 `Prefix`)
VALUES
(NULL,'MX', '+52'),
(NULL,'MX', '+1905'),
(NULL,'US', '+1'),
(NULL,'CH', '+86'),
(NULL,'RU', '+7');

INSERT INTO `test`.`Phones`
(`ID`,
 `phone`,
 `countryID`)
VALUES
(NULL,'6561545665', 2),
(NULL,'6241987553', 1),
(NULL,'9147685143', 5),
(NULL,'5135664531', 3),
(NULL,'15567689005', 4);

INSERT INTO `test`.`Reviews`
(`id`,
 `author`,
 `Review`,
 `phoneID`)
VALUES
(NULL,'Anon', 'I like this phone because there is triple six!',1),
(NULL,'Hannibal Lector', 'Mhhm) this girl tasted good',2),
(NULL,'Anon', 'Did you see that new Vovan and Lexus Prime minister prank? I saw this phone in uncensored frame!',3),
(NULL,'911 ', 'Whoever you are, сonfession of your feelings changed my life! I am not a silly phone operator anymore, I knew that strip dancing is my God\'s gift!' ,4),
(NULL,'Xi Zinping', '+15 social credits! Repent your sins, tell me where your partners and I will forgive your dark uygurian soul! ',5);

INSERT INTO `test`.`Votes`
(`ID`,
 `rating`,
 `IP`,
 `ReviewID`)
VALUES
(NULL,'-1','158.78.9.0', 2),
(NULL,'1','139.78.9.0', 2),
(NULL,'1','158.99.9.0', 5),
(NULL,'-1','175.47.6.0', 3),
(NULL,'-1','69.214.10.0', 4);

-- TODO: Insert test users, roles