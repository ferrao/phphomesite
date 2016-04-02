-- MySQL dump 9.11
--
-- Host: localhost    Database: phphomesite
-- ------------------------------------------------------
-- Server version	4.0.24_Debian-5-log

USE phphomesite;
DROP TABLE menu;
DROP TABLE gallery;
DROP TABLE pictures;
--
-- Table structure for table `blog`
--
ALTER TABLE `blog` CHANGE `id` `b_id` INT(11) NOT NULL auto_increment;
ALTER TABLE `blog` CHANGE `posted` `b_date` DATETIME NOT NULL default '0000-00-00 00:00:00';
ALTER TABLE `blog` CHANGE `text` `b_text` LONGTEXT NOT NULL;
ALTER TABLE `blog` CHANGE `picture` `b_picture` TEXT;
ALTER TABLE `blog` ADD `b_popup` CHAR(1) NOT NULL default '';

--
-- Dumping data for table `blog`
--


--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `c_name` varchar(30) NOT NULL default '',
  `c_value` text
) TYPE=MyISAM;

--
-- Dumping data for table `config`
--

INSERT INTO `config` VALUES ('version','0.4.1');
INSERT INTO `config` VALUES ('project copyright',':: Copyright &copy; 2005 Rui Ferrao all rights reserved ::');
INSERT INTO `config` VALUES ('username','admin');
INSERT INTO `config` VALUES ('password','21232f297a57a5a743894a0e4a801fc3');

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `c_id` int(11) NOT NULL auto_increment,
  `c_name` varchar(32) NOT NULL default '',
  `c_type` char(1) NOT NULL default '',
  `table_id` int(11) default NULL,
  PRIMARY KEY  (`c_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `content`
--


--
-- Table structure for table `folder`
--

CREATE TABLE `folder` (
  `f_id` int(11) NOT NULL auto_increment,
  `f_name` varchar(80) NOT NULL default '',
  PRIMARY KEY  (`f_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `folder`
--


--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `g_id` int(11) NOT NULL auto_increment,
  `g_name` text,
  `g_rows` int(11) NOT NULL default '0',
  `g_cols` int(11) NOT NULL default '0',
  `g_text` longtext,
  PRIMARY KEY  (`g_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `gallery`
--


--
-- Table structure for table `guestbook`
--

ALTER TABLE `guestbook` CHANGE `id` `gb_id` INT(11) NOT NULL auto_increment;
ALTER TABLE `guestbook` CHANGE `name` `gb_name` VARCHAR(32) NOT NULL default '';
ALTER TABLE `guestbook` CHANGE `posted` `gb_date` DATETIME NOT NULL default '0000-00-00 00:00:00';
ALTER TABLE `guestbook` CHANGE `text` `gb_text` LONGTEXT NOT NULL;


--
-- Dumping data for table `guestbook`
--


--
-- Table structure for table `html`
--

CREATE TABLE `html` (
  `h_id` int(11) NOT NULL auto_increment,
  `h_file` varchar(80) NOT NULL default '',
  PRIMARY KEY  (`h_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `html`
--


--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `i_id` int(11) NOT NULL auto_increment,
  `g_id` int(11) NOT NULL default '0',
  `i_pos` int(11) NOT NULL default '0',
  `p_id` int(11) NOT NULL default '0',
  `l_id` int(11) default NULL,
  `i_width` int(11) default NULL,
  `i_height` int(11) default NULL,
  `i_caption` text,
  PRIMARY KEY  (`i_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `image`
--


--
-- Table structure for table `lgroup`
--

CREATE TABLE `lgroup` (
  `lg_id` int(11) NOT NULL auto_increment,
  `lg_name` text NOT NULL,
  PRIMARY KEY  (`lg_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `lgroup`
--


--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `l_id` int(11) NOT NULL auto_increment,
  `l_name` text NOT NULL,
  `l_url` varchar(80) NOT NULL default '',
  `lg_id` int(11) NOT NULL,
  PRIMARY KEY  (`l_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `links`
--

--
-- Table structure for table `lnav`
--

CREATE TABLE `lnav` (
  `ln_id` int(11) NOT NULL auto_increment,
  `c_id` int(11) NOT NULL default '0',
  `ln_pos` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ln_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `lnav`
--


--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `p_id` int(11) NOT NULL auto_increment,
  `p_name` varchar(80) NOT NULL default '',
  `p_folder` varchar(80) default NULL,
  PRIMARY KEY  (`p_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `picture`
--

--
-- Table structure for table `rnav`
--

CREATE TABLE `rnav` (
  `rn_id` int(11) NOT NULL auto_increment,
  `ln_id` int(11) NOT NULL default '0',
  `c_id` int(11) NOT NULL default '0',
  `rn_pos` int(11) NOT NULL default '0',
  PRIMARY KEY  (`rn_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `rnav`
--
