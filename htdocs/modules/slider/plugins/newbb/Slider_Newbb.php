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

CREATE TABLE `newbb_categories` (
  `cat_id`          SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cat_image`       VARCHAR(50)          NOT NULL DEFAULT '',
  `cat_title`       VARCHAR(100)         NOT NULL DEFAULT '',
  `cat_description` TEXT                 NOT NULL,
  `cat_order`       SMALLINT(3) UNSIGNED NOT NULL DEFAULT '99',
  `cat_url`         VARCHAR(255)         NOT NULL DEFAULT '',

  PRIMARY KEY (`cat_id`),
  KEY `cat_order`  (`cat_order`)
)

*/

use XoopsModules\Slider;

class Slider_Newbb extends Slider_Plugin
{
var $options = array(
            'table'        => 'newbb_categories',
            'fld_id'       => 'cat_id',
            'fld_pid'      => '',
            'fld_name'     => 'cat_title',
            'fld_weight'   => '',
            'fld_active'   => '',
            'permView'     => 'category_access',
//            'captionAll'   => _ALL,
            'catPage'      => 'index.php',
            'catParamName' => 'cat');
            
        
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
$this->options['captionAll'] = _MB_SLD_NEWBB_ALL_CAT;

    $permsNames = $this->getPermsissionsNames();
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $mainMenu = array();
      
    
    return $mainMenu;

}
    

  } // fin de la classe
    


?>