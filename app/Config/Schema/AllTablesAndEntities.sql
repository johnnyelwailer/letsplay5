SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `created` DATETIME NULL DEFAULT NULL ,
  `modified` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) );


-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(30) NOT NULL DEFAULT 'Gast' ,
  `password` VARCHAR(32) NOT NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
  `score` INT NULL DEFAULT 0 ,
  `isMale` TINYINT NULL DEFAULT 1 ,
  `group_id` INT NOT NULL ,
  `storePassword` TINYINT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_users_groups`
    FOREIGN KEY (`group_id` )
    REFERENCES `mydb`.`groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_users_groups` ON `mydb`.`users` (`group_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`games`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`games` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `challenger_id` INT NULL DEFAULT 0 ,
  `opponent_id` INT NULL DEFAULT 0 ,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `terminated` TINYINT NULL DEFAULT 0 ,
  `winner_id` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_games_users2`
    FOREIGN KEY (`challenger_id` )
    REFERENCES `mydb`.`users` (`id` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_games_users3`
    FOREIGN KEY (`opponent_id` )
    REFERENCES `mydb`.`users` (`id` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_games_users1`
    FOREIGN KEY (`winner_id` )
    REFERENCES `mydb`.`users` (`id` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_games_users2` ON `mydb`.`games` (`challenger_id` ASC) ;

CREATE INDEX `fk_games_users3` ON `mydb`.`games` (`opponent_id` ASC) ;

CREATE INDEX `fk_games_users1` ON `mydb`.`games` (`winner_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`turns`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`turns` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `game_id` INT NOT NULL ,
  `creator` INT NULL ,
  `x` TINYINT NOT NULL ,
  `y` TINYINT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_turns_games1`
    FOREIGN KEY (`game_id` )
    REFERENCES `mydb`.`games` (`id` )
    ON DELETE RESTRICT
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_turns_users1`
    FOREIGN KEY (`creator` )
    REFERENCES `mydb`.`users` (`id` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_turns_games1` ON `mydb`.`turns` (`game_id` ASC) ;

CREATE INDEX `fk_turns_users1` ON `mydb`.`turns` (`creator` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`acos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`acos` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `parent_id` INT(10) NULL DEFAULT NULL ,
  `model` VARCHAR(255) NULL DEFAULT '' ,
  `foreign_key` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `alias` VARCHAR(255) NULL DEFAULT '' ,
  `lft` INT(10) NULL DEFAULT NULL ,
  `rght` INT(10) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) );


-- -----------------------------------------------------
-- Table `mydb`.`aros`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`aros` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `parent_id` INT(10) NULL DEFAULT NULL ,
  `model` VARCHAR(255) NULL DEFAULT '' ,
  `alias` VARCHAR(255) NULL DEFAULT '' ,
  `lft` INT(10) NULL DEFAULT NULL ,
  `rght` INT(10) NULL DEFAULT NULL ,
  `foreign_key` INT(10) UNSIGNED NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_aros_groups1`
    FOREIGN KEY (`foreign_key` )
    REFERENCES `mydb`.`groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE INDEX `fk_aros_groups1` ON `mydb`.`aros` (`foreign_key` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`aros_acos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`aros_acos` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `aro_id` INT(10) UNSIGNED NOT NULL ,
  `aco_id` INT(10) UNSIGNED NOT NULL ,
  `_create` CHAR(2) NOT NULL DEFAULT 0 ,
  `_read` CHAR(2) NOT NULL DEFAULT 0 ,
  `_update` CHAR(2) NOT NULL DEFAULT 0 ,
  `_delete` CHAR(2) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_aros_acos_acos1`
    FOREIGN KEY (`aro_id` )
    REFERENCES `mydb`.`acos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aros_acos_aros1`
    FOREIGN KEY (`aco_id` )
    REFERENCES `mydb`.`aros` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE INDEX `fk_aros_acos_acos1` ON `mydb`.`aros_acos` (`aro_id` ASC) ;

CREATE INDEX `fk_aros_acos_aros1` ON `mydb`.`aros_acos` (`aco_id` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`sessions` (
  `id` VARCHAR(255) NOT NULL DEFAULT '' ,
  `data` TEXT NULL DEFAULT NULL ,
  `expires` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) );


-- -----------------------------------------------------
-- Table `mydb`.`waitingForGames`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`waitingForGames` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
  `modified` DATETIME NULL ,
  `session_id` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_waitingForGames_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `mydb`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_waitingForGames_cake_sessions1`
    FOREIGN KEY (`session_id` )
    REFERENCES `mydb`.`sessions` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_waitingForGames_users1` ON `mydb`.`waitingForGames` (`user_id` ASC) ;

CREATE INDEX `fk_waitingForGames_cake_sessions1` ON `mydb`.`waitingForGames` (`session_id` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
