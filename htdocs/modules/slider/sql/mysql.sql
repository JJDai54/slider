# SQL Dump for slider - slides management module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: xmodules.jubile.fr
# Generated on: Tue May 11, 2021 to 19:16:51
# Server version: 5.6.49-log
# PHP Version: 7.3.27

#
# Structure table for `slider_slides` 9
#

CREATE TABLE `slider_slides` (
  `sld_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sld_short_name` VARCHAR(80) NOT NULL DEFAULT '',
  `sld_title` TEXT  NOT NULL DEFAULT '',
  `sld_subtitle` TEXT NOT NULL ,
  `sld_button` VARCHAR(80) NOT NULL DEFAULT '',  
  `sld_read_more`  VARCHAR(255) NOT NULL DEFAULT '',
  `sld_weight` INT(10) NOT NULL DEFAULT '0',
  `sld_periodicity` INT(1) NOT NULL DEFAULT '0',
  `sld_date_begin` INT(10) NOT NULL DEFAULT '0',
  `sld_date_end` INT(10) NOT NULL DEFAULT '0',
  `sld_actif` INT(1) NOT NULL DEFAULT '0',
  `sld_theme` VARCHAR(100) NOT NULL DEFAULT '',
  `sld_button_title` VARCHAR(80) NOT NULL ,
  `sld_style_title` TEXT NOT NULL ,
  `sld_style_subtitle` TEXT NOT NULL ,
  `sld_style_button` TEXT NOT NULL ,
  `sld_style_id_title` INT(10) NOT NULL DEFAULT '0' ,
  `sld_style_id_subtitle` INT(10) NOT NULL DEFAULT '0' ,
  `sld_style_id_button` INT(10) NOT NULL DEFAULT '0' ,
  `sld_image` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`sld_id`)
) ENGINE=InnoDB;


#
# Structure table for `slider_themes` 4
#

CREATE TABLE `slider_themes` (
  `theme_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `theme_folder` VARCHAR(80) NOT NULL DEFAULT '',
  `theme_mycss` VARCHAR(80) NOT NULL DEFAULT '',
  `theme_random`  VARCHAR(1) NOT NULL DEFAULT 'j',
  `theme_transition`  INT(10) NOT NULL DEFAULT '0',
  `theme_tpl_slider` VARCHAR(80) NOT NULL DEFAULT '',
  `theme_status`  INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB;

CREATE TABLE `slider_styles` (
  `sty_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sty_name` VARCHAR(255) NOT NULL DEFAULT '',
  `sty_css` TEXT NOT NULL ,
  PRIMARY KEY (`sty_id`)
) ENGINE=InnoDB; 


## ------------------------------------

INSERT INTO slider_styles (sty_id,sty_name,sty_object,sty_css)
values(1,"Defaut - Titre","","color:#496381;
background:#E1D6C9;
opacity: 0.8;
padding: 0px 25px 0px 25px;
border-radius: 50px 50px 50px 50px;
margin-left:250px;
margin-right:250px;
margin-bottom:15px;");

INSERT INTO slider_styles (sty_id,sty_name,sty_object,sty_css)
values(2,"Defaut - Sous-titre","","color:#496381;
background:#E1D6C9;
opacity: 0.8;
padding: 0px 25px 0px 25px;
border-radius: 50px 50px 50px 50px;
margin-left:250px;
margin-right:250px;
margin-bottom:15px;");

INSERT INTO slider_styles (sty_id,sty_name,sty_object,sty_css)
values(3,"Defaut - Bouton","","color:#496381;
background:#E1D6C9;
opacity: 0.9;
padding:25px;
border-radius: 50px 50px 50px 50px;
margin-left:250px;
margin-right:250px;
padding-bottom : 5px;
padding-top : 5px;");

