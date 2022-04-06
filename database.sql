#TABLES: Votes, Phones, Reviews,Countries
#Review n - 1 Phone
#Votes n - 1 Review
#Country 1 - n Phones
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema test
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema test
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8 ;
USE `test` ;

-- -----------------------------------------------------
-- Table `test`.`Countries`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test`.`Countries` (
                                                  `ID` INT NOT NULL,
                                                  `Name` ENUM('RU','US','CH','MX') NOT NULL,
                                                  `Prefix`  ENUM('+7','+1','+86','+52','+1905') NOT NULL,
                                                  PRIMARY KEY (`ID`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test`.`Phones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `test`.`Phones` (
                                               `ID` INT NOT NULL,
                                               `phone` VARCHAR(45) NOT NULL,
                                               `countryID` INT NOT NULL,
                                               PRIMARY KEY (`ID`, `countryID`),
                                               INDEX `fk_Phones_Countries_idx` (`countryID` ASC) VISIBLE,
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
                                                `id` INT NOT NULL,
                                                `Review` MEDIUMTEXT NULL,
                                                `author` VARCHAR(45) NOT NULL,
                                                `phoneID` INT NOT NULL,
                                                PRIMARY KEY (`id`, `phoneID`),
                                                INDEX `fk_Reviews_Phones1_idx` (`phoneID` ASC) VISIBLE,
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
                                              `id` INT NOT NULL,
                                              `rating` TINYINT(10) NULL,
                                              `IP` VARCHAR(45) NOT NULL,
                                              `ReviewID` INT NOT NULL,
                                              PRIMARY KEY (`id`, `ReviewID`),
                                              INDEX `fk_Votes_Reviews1_idx` (`ReviewID` ASC) VISIBLE,
                                              CONSTRAINT `fk_Votes_Reviews1`
                                                  FOREIGN KEY (`ReviewID`)
                                                      REFERENCES `test`.`Reviews` (`id`)
                                                      ON DELETE NO ACTION
                                                      ON UPDATE NO ACTION)
    ENGINE = InnoDB;

CREATE USER 'admin' IDENTIFIED BY 'M6sterpass1';

GRANT ALL, CREATE, DROP, GRANT OPTION, REFERENCES, EVENT, LOCK TABLES ON `test`.* TO 'admin';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
