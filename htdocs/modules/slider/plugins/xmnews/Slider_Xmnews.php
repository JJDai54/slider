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
CREATE TABLE `xmnews_category` (
  `category_id`             smallint(5) unsigned    NOT NULL AUTO_INCREMENT,
  `category_name`           varchar(255)            NOT NULL DEFAULT '',
  `category_description`    text,
  `category_logo`           varchar(50)             NOT NULL DEFAULT '',
  `category_douser`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_dodate`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_domdate`        tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_dohits`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_dorating`       tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_docomment`      tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_weight`         smallint(5) unsigned    NOT NULL DEFAULT '0',
  `category_status`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM;

*/
use XoopsModules\Slider;

class Slider_Xmnews extends Slider_Plugin
{
var $options = array(
            'table'        => 'xmnews_category',
            'fld_id'       => 'category_id',
            'fld_pid'      => '',
            'fld_name'     => 'category_name',
            'fld_weight'   => 'category_weight',
            'permView'     => 'xmnews_viewabstract',
            'captionAll'   => _MB_SLD_XMNEWS_ALL_CAT,
            'catPage'      => 'index.php',
            'catParamName' => 'news_cid',
            'sepTitle'     => '-');


 /* ********************
 *
 *********************** */   
public function getMainMenu(){
    $permsNames = $this->getPermsissionsNames();
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $mainMenu = array();
          
    $mainMenu['approve']['url'] = $moduleUrl . "/index.php";
    $mainMenu['approve']['lib'] = _MB_SLD_XMNEWS_APPROVE_STORYES;
         
    // --- Soumettre un article
    if (in_array('news_submit',$permsNames)){
    $mainMenu['submit']['url'] = $moduleUrl . "/action.php?op=add";
    $mainMenu['submit']['lib'] = _MB_SLD_XMNEWS_SUBMIT;
    }
    
    return $mainMenu;

}

    
} // fin de la classe
    


?>