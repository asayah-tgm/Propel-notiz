
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- person
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `person`;

CREATE TABLE `person`
(
    `personName` VARCHAR(32),
    `beschreibung` VARCHAR(128),
    `person_id` INTEGER NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`person_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- notiz
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `notiz`;

CREATE TABLE `notiz`
(
    `betreff` VARCHAR(256) NOT NULL,
    `text` VARCHAR(0) NOT NULL,
    `datum` DATE NOT NULL,
    `besitzer` VARCHAR(32) NOT NULL,
    `projekt` VARCHAR(64),
    `notiz_id` INTEGER NOT NULL AUTO_INCREMENT,
    `fk_id` INTEGER NOT NULL,
    PRIMARY KEY (`notiz_id`),
    INDEX `notiz_fi_c5043a` (`fk_id`),
    CONSTRAINT `notiz_fk_c5043a`
        FOREIGN KEY (`fk_id`)
        REFERENCES `person` (`person_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- projekt
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `projekt`;

CREATE TABLE `projekt`
(
    `projektname` VARCHAR(64),
    `startdate` DATE,
    `enddate` DATE,
    `projekt_id` INTEGER NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`projekt_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rezept
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rezept`;

CREATE TABLE `rezept`
(
    `rezept_id` INTEGER NOT NULL,
    PRIMARY KEY (`rezept_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rezeptverwaltung
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rezeptverwaltung`;

CREATE TABLE `rezeptverwaltung`
(
    `fkrezept_id` INTEGER NOT NULL,
    `fknotiz_id` INTEGER NOT NULL,
    INDEX `rezeptverwaltung_fi_c2386f` (`fknotiz_id`),
    INDEX `rezeptverwaltung_fi_9a1c47` (`fkrezept_id`),
    CONSTRAINT `rezeptverwaltung_fk_c2386f`
        FOREIGN KEY (`fknotiz_id`)
        REFERENCES `notiz` (`notiz_id`),
    CONSTRAINT `rezeptverwaltung_fk_9a1c47`
        FOREIGN KEY (`fkrezept_id`)
        REFERENCES `rezept` (`rezept_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- teilnehmen
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `teilnehmen`;

CREATE TABLE `teilnehmen`
(
    `pid` INTEGER NOT NULL,
    `tid` INTEGER NOT NULL,
    INDEX `teilnehmen_fi_74aa77` (`pid`),
    INDEX `teilnehmen_fi_51f647` (`tid`),
    CONSTRAINT `teilnehmen_fk_74aa77`
        FOREIGN KEY (`pid`)
        REFERENCES `person` (`person_id`),
    CONSTRAINT `teilnehmen_fk_51f647`
        FOREIGN KEY (`tid`)
        REFERENCES `projekt` (`projekt_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- toDo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `toDo`;

CREATE TABLE `toDo`
(
    `toDo_id` INTEGER NOT NULL,
    `status` VARCHAR(16) NOT NULL,
    `priority` INTEGER NOT NULL,
    INDEX `toDo_fi_687bc2` (`toDo_id`),
    CONSTRAINT `toDo_fk_687bc2`
        FOREIGN KEY (`toDo_id`)
        REFERENCES `notiz` (`notiz_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
