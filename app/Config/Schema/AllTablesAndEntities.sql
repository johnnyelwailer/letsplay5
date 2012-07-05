

-- -----------------------------------------------------
-- Table `groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `created` DATETIME NULL DEFAULT NULL ,
  `modified` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) );


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(30) NOT NULL DEFAULT 'Gast' ,
  `password` VARCHAR(32) NOT NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `created` DATETIME NULL DEFAULT NULL, -- CURRENT_TIMESTAMP ,
  `modified` DATETIME NULL DEFAULT NULL, -- CURRENT_TIMESTAMP ,
  `score` INT NULL DEFAULT 0 ,
  `isMale` TINYINT NULL DEFAULT 1 ,
  `group_id` INT NOT NULL ,
  `storePassword` TINYINT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_users_groups`
    FOREIGN KEY (`group_id` )
    REFERENCES `groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- CREATE INDEX `fk_users_groups` ON `users` (`group_id` ASC) ;


-- -----------------------------------------------------
-- Table `games`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `games` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `challenger_id` INT NULL DEFAULT 0 ,
  `opponent_id` INT NULL DEFAULT 0 ,
  `created` DATETIME  DEFAULT NULL, -- CURRENT_TIMESTAMP ,
  `modified` DATETIME DEFAULT NULL, -- CURRENT_TIMESTAMP ,
  `terminated` TINYINT NULL DEFAULT 0 ,
  `winner_id` INT DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_games_users2`
    FOREIGN KEY (`challenger_id` )
    REFERENCES `users` (`id` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_games_users3`
    FOREIGN KEY (`opponent_id` )
    REFERENCES `users` (`id` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_games_users1`
    FOREIGN KEY (`winner_id` )
    REFERENCES `users` (`id` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- CREATE INDEX `fk_games_challenger_id` ON `games` (`challenger_id` ASC) ;
-- CREATE INDEX `fk_games_opponent_id` ON `games` (`opponent_id` ASC) ;
-- CREATE INDEX `fk_games_winner_id` ON `games` (`winner_id` ASC) ;


-- -----------------------------------------------------
-- Table `turns`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `turns` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `created` DATETIME DEFAULT NULL, -- CURRENT_TIMESTAMP ,
  `game_id` INT NOT NULL ,
  `creator` INT NULL ,
  `x` TINYINT NOT NULL ,
  `y` TINYINT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_turns_games1`
    FOREIGN KEY (`game_id` )
    REFERENCES `games` (`id` )
    ON DELETE RESTRICT
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_turns_users1`
    FOREIGN KEY (`creator` )
    REFERENCES `users` (`id` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

/*
CREATE INDEX `fk_turns_game_id` ON `turns` (`game_id` ASC) ;
CREATE INDEX `fk_turns_creator` ON `turns` (`creator` ASC) ;
*/

-- -----------------------------------------------------
-- Table `acos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `acos` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `parent_id` INT(10) NULL DEFAULT NULL ,
  `model` VARCHAR(255) NULL DEFAULT '' ,
  `foreign_key` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `alias` VARCHAR(255) NULL DEFAULT '' ,
  `lft` INT(10) NULL DEFAULT NULL ,
  `rght` INT(10) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) );


-- -----------------------------------------------------
-- Table `aros`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `aros` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `parent_id` INT(10) NULL DEFAULT NULL ,
  `model` VARCHAR(255) NULL DEFAULT '' ,
  `alias` VARCHAR(255) NULL DEFAULT '' ,
  `lft` INT(10) NULL DEFAULT NULL ,
  `rght` INT(10) NULL DEFAULT NULL ,
  `foreign_key` INT(10) UNSIGNED NULL DEFAULT NULL ,
  PRIMARY KEY (`id`)
/*  ,
  CONSTRAINT `fk_aros_groups1`
    FOREIGN KEY (`foreign_key` )
    REFERENCES `groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
	*/
	);

-- CREATE INDEX `fk_aros_groups1` ON `aros` (`foreign_key` ASC) ;


-- -----------------------------------------------------
-- Table `aros_acos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `aros_acos` (
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
    REFERENCES `acos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aros_acos_aros1`
    FOREIGN KEY (`aco_id` )
    REFERENCES `aros` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
/*
CREATE INDEX `fk_aros_acos_aro_id` ON `aros_acos` (`aro_id` ASC) ;
CREATE INDEX `fk_aros_acos_aco_id` ON `aros_acos` (`aco_id` ASC) ;
*/

-- -----------------------------------------------------
-- Table `sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sessions` (
  `id` VARCHAR(255) NOT NULL DEFAULT '' ,
  `data` TEXT NULL DEFAULT NULL ,
  `expires` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) );


-- -----------------------------------------------------
-- Table `waitingForGames`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `waitingForGames` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `created` DATETIME  DEFAULT NULL, -- CURRENT_TIMESTAMP ,
  `modified` DATETIME  ,
  `session_id` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_waitingForGames_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_waitingForGames_cake_sessions1`
    FOREIGN KEY (`session_id` )
    REFERENCES `sessions` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = Memory;

-- CREATE INDEX `fk_waitingForGames_user_id` ON `waitingForGames` (`user_id` ASC) ;

-- CREATE INDEX `fk_waitingForGames_cake_session_id` ON `waitingForGames` (`session_id` ASC) ;


