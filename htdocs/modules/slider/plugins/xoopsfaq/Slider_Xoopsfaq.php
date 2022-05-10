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

CREATE TABLE `xoopsfaq_categories` (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) NOT NULL DEFAULT '',
  `category_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `category_active` TINYINT(1) NOT NULL DEFAULT '1',
  `category_color_set` VARCHAR(50) NOT NULL default '',
  `category_show_hidetext` TINYINT(1) NOT NULL DEFAULT '0',
  `category_hidetext_align` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 ;

*/
use XoopsModules\Slider;

class Slider_Xoopsfaq extends Slider_Plugin
{
var $options = array(
            'table'        => 'xoopsfaq_categories',
            'fld_id'       => 'category_id',
            'fld_pid'      => '',
            'fld_name'     => 'category_title',
            'fld_weight'   => 'category_order',
            'permView'     => 'xf_cats_consult',// xoopsfaq_cat_consult
            'captionAll'   => _MB_SLD_XOOPSFAQ_ALL_CAT,
            'catPage'      => 'index.php',
            'catParamName' => 'cat_id');

    
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
    $permsNames = $this->getPermsissionsNames();
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $mainMenu = array(); 
    
    return $mainMenu;

}
    
  } // fin de la classe
    


?>