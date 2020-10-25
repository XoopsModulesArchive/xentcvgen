# phpMyAdmin SQL Dump
# version 2.6.1-rc1
# http://www.phpmyadmin.net
# 
# Host: localhost
# Generation Time: Mar 31, 2005 at 02:03 PM
# Server version: 4.0.23
# PHP Version: 4.3.10
# 
# Database: `xentfactory`
# 

# ############################

# 
# Table structure for table `xent_cvgen`
# 

CREATE TABLE `xent_cvgen` (
    `ID_CVGEN`    INT(5)  NOT NULL AUTO_INCREMENT,
    `uid`         INT(5)  NOT NULL DEFAULT '0',
    `date_create` INT(11) NOT NULL DEFAULT '0',
    `date_modif`  INT(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`ID_CVGEN`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 1;

# ############################

# 
# Table structure for table `xent_cvgen_edu`
# 

CREATE TABLE `xent_cvgen_edu` (
    `ID_CVEDU` INT(5)  NOT NULL AUTO_INCREMENT,
    `ID_CVGEN` INT(5)  NOT NULL DEFAULT '0',
    `uid`      INT(5)  NOT NULL DEFAULT '0',
    `date`     INT(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`ID_CVEDU`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 1;

# ############################

# 
# Table structure for table `xent_cvgen_edu_lang`
# 

CREATE TABLE `xent_cvgen_edu_lang` (
    `ID_CVEDU`    INT(5)       NOT NULL DEFAULT '0',
    `languageid`  VARCHAR(50)  NOT NULL DEFAULT '',
    `defaultlang` INT(5)       NOT NULL DEFAULT '0',
    `edu_name`    VARCHAR(255) NOT NULL DEFAULT '',
    `institution` VARCHAR(255) NOT NULL DEFAULT '',
    `city`        VARCHAR(255) NOT NULL DEFAULT '',
    `country`     VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`ID_CVEDU`, `languageid`)
)
    ENGINE = ISAM;

# ############################

# 
# Table structure for table `xent_cvgen_lang`
# 

CREATE TABLE `xent_cvgen_lang` (
    `ID_CVGEN`     INT(5)       NOT NULL DEFAULT '0',
    `languageid`   VARCHAR(255) NOT NULL DEFAULT '',
    `defaultlang`  INT(5)       NOT NULL DEFAULT '0',
    `summary`      TEXT         NOT NULL,
    `specialities` VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`ID_CVGEN`, `languageid`)
)
    ENGINE = ISAM;

# ############################

# 
# Table structure for table `xent_cvgen_xp`
# 

CREATE TABLE `xent_cvgen_xp` (
    `ID_CVXP`    INT(5)  NOT NULL AUTO_INCREMENT,
    `ID_CVGEN`   INT(5)  NOT NULL DEFAULT '0',
    `uid`        INT(5)  NOT NULL DEFAULT '0',
    `date_start` INT(11) NOT NULL DEFAULT '0',
    `date_end`   INT(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`ID_CVXP`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 1;

# ############################

# 
# Table structure for table `xent_cvgen_xp_lang`
# 

CREATE TABLE `xent_cvgen_xp_lang` (
    `ID_CVXP`     INT(5)       NOT NULL DEFAULT '0',
    `languageid`  VARCHAR(50)  NOT NULL DEFAULT '',
    `defaultlang` INT(5)       NOT NULL DEFAULT '0',
    `client_name` VARCHAR(255) NOT NULL DEFAULT '',
    `city`        VARCHAR(255) NOT NULL DEFAULT '',
    `region`      VARCHAR(255) NOT NULL DEFAULT '',
    `country`     VARCHAR(255) NOT NULL DEFAULT '',
    `position`    VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT         NOT NULL,
    PRIMARY KEY (`ID_CVXP`, `languageid`)
)
    ENGINE = ISAM;
