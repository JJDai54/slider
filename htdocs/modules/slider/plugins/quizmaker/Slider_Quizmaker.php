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
CREATE TABLE `quizmaker_categories` (
  `cat_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cat_parent_id` int(8) NOT NULL DEFAULT '0',
  `cat_name` varchar(255) NOT NULL DEFAULT '',
  `cat_description` text NOT NULL,
  `cat_theme` varchar(50) NOT NULL DEFAULT '0',
  `cat_weight` int(11) NOT NULL DEFAULT '0',
  `cat_creation` datetime(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000',
  `cat_update` datetime(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB;

*/


class Slider_Quizmaker extends Slider_Plugin
{
var $options = array(
            'table'        => 'quizmaker_categories',
            'fld_id'       => 'cat_id',
            'fld_pid'      => 'cat_parent_id',
            'fld_name'     => 'cat_name',
            'fld_weight'   => 'cat_weight',
            'fld_active'   => '',
            'permView'     => 'quizmaker_view_categories',
//            'captionAll'   => _ALL,
            'catPage'      => 'categories.php',
            'catParamName' => 'cat_id');
            
        
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
$this->options['captionAll'] = _MB_SLD_QUIZMAKER_ALL_CAT;
    $permsNames = $this->getPermsissionsNames(false);
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $mainMenu = array();

    //$mainMenu['separation1'] = array('url' => '', 'lib' => "<hr>");      
    
    return $mainMenu;

}
    

  } // fin de la classe
    


?>