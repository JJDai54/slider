<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * slider - Slides management module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        slider
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         JJDai - Email:<jjdelalandre@orange.fr> - Website:<http://jubile.fr>
 */

/*
Le plugin doit retourner un tableau de laforme 
[]
    [item1]
        [id]
        [libellé]
        [url]
    [item2]
        [id]
        [libellé]
        [url]

CREATE TABLE `wggallery_albums` (
  `alb_id`            INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alb_pid`           INT(8)          NOT NULL DEFAULT '0',
  `alb_iscoll`        INT(1)          NOT NULL DEFAULT '0',
  `alb_name`          VARCHAR(200)    NOT NULL DEFAULT '',
  `alb_desc`          TEXT            NULL ,
  `alb_weight`        INT(8)          NOT NULL DEFAULT '0',
  `alb_imgtype`       INT(1)          NOT NULL DEFAULT '0',
  `alb_image`         VARCHAR(200)    NOT NULL DEFAULT '',
  `alb_imgid`         INT(8)          NOT NULL DEFAULT '0',
  `alb_state`         INT(1)          NOT NULL DEFAULT '0',
  `alb_wmid`          INT(8)          NOT NULL DEFAULT '0',
  `alb_cats`          TEXT            NULL ,
  `alb_tags`          TEXT            NULL ,
  `alb_date`          INT(8)          NOT NULL DEFAULT '0',
  `alb_submitter`     INT(8)          NOT NULL DEFAULT '0',
  PRIMARY KEY (`alb_id`)
) ENGINE=InnoDB;

CREATE TABLE `wggallery_categories` (
  `cat_id`        INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cat_text`      VARCHAR(100)    NOT NULL DEFAULT '',
  `cat_album`     INT(1)          NOT NULL DEFAULT '0',
  `cat_image`     INT(1)          NOT NULL DEFAULT '0',
  `cat_search`    INT(1)          NOT NULL DEFAULT '0',
  `cat_weight`    INT(8)          NOT NULL DEFAULT '0',
  `cat_date`      INT(8)          NOT NULL DEFAULT '0',
  `cat_submitter` INT(8)          NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB;

*/
use XoopsModules\Slider;

class Slider_Wggallery extends Slider_Plugin
{
var $options = array(
            'table'        => 'wggallery_albums',
            'fld_id'       => 'alb_id',
            'fld_pid'      => 'alb_pid',
            'fld_name'     => 'alb_name',
            'fld_weight'   => 'alb_weight',
            'fld_active'   => '',
            'permView'     => 'wggallery_view',
            'captionAll'   => _MB_SLD_WGGALLERY_ALL_CAT,
            'catPage'      => 'gallery.php',
            'catParamName' => 'alb_id',
            'maxLevelPid'  => 0);

    
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
    $permsNames = $this->getPermsissionsNames();
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $mainMenu = array();
      
    define ('WGGALLERY_XBOOTSTRAP_ALBUMS', 1);           // liste des albums
    define ('WGGALLERY_XBOOTSTRAP_INDEX', 2);            // page index.php du module - sommaire en quelque sorte
    define ('WGGALLERY_XBOOTSTRAP_MANAGE_ALBUMS', 4);    // Gestion des albums
    define ('WGGALLERY_XBOOTSTRAP_NEW_ALBUM', 8);        // Creer un album
    define ('WGGALLERY_XBOOTSTRAP_SEARCH_IMG',  16);     // Recherche d'images

    $globalPermsIds = $this-> getPermissionsIds('wggallery_global');
    $h = 90000;

////////////////////////
    //cet item n'est aficher que si aucun album n'est afficher
    //sinon àa ferait doublon avec l'item du sous menu des albums
    if (in_array(WGGALLERY_XBOOTSTRAP_MANAGE_ALBUMS, $globalPermsIds)){
      $mainMenu['manage_albums']['id'] = $h++;
      $mainMenu['manage_albums']['lib'] = _MB_SLD_WGGALLERY_MANAGE_ALBUMS;
      $mainMenu['manage_albums']['url'] = $moduleUrl . '/albums.php';
    }
    if (in_array(WGGALLERY_XBOOTSTRAP_NEW_ALBUM, $globalPermsIds)){
      $mainMenu['new_album']['id'] = $h++;
      $mainMenu['new_album']['lib'] = _MB_SLD_WGGALLERY_NEW_ALBUM;
      $mainMenu['new_album']['url'] = $moduleUrl . '/albums.php?op=new';
    }
    //---------------------------------------------------------
    if (in_array(WGGALLERY_XBOOTSTRAP_SEARCH_IMG, $globalPermsIds)){
      $mainMenu['search_img']['id'] = $h++;
      $mainMenu['search_img']['lib'] = _MB_SLD_WGGALLERY_SEARCH_IMG;
      $mainMenu['search_img']['url'] = $moduleUrl . '/search.php';
    }
    
    return $mainMenu;

}
    
    
  } // fin de la classe
    


?>