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

CREATE TABLE `lxcategories` (
  `categoryID`  TINYINT(4)   NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(100) NOT NULL DEFAULT '',
  `description` TEXT         NOT NULL,
  `total`       INT(11)      NOT NULL DEFAULT '0',
  `weight`      INT(11)      NOT NULL DEFAULT '1',
  `logourl`     VARCHAR(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`categoryID`),
  UNIQUE KEY columnID (`categoryID`)
)

*/
use XoopsModules\Slider;

class Slider_Lexikon extends Slider_Plugin
{
var $options = array(
            'table'        => 'lxcategories',
            'fld_id'       => 'categoryID',
            'fld_pid'      => '',
            'fld_name'     => 'name',
            'fld_weight'   => 'weight',
//            'captionAll'   => _ALL,
            'permView'     => 'lexikon_view',
            'captionAll'   => ,
            'catPage'      => 'category.php',
            'catParamName' => 'categoryID');
            
    
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
$this->options['captionAll'] = _MB_SLD_LEXIKON_ALL_CAT;

    $permsNames = $this->getPermsissionsNames();
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $mainMenu = array();
      
    //Items absoluts (nes, nouvel articles, statistique, ...)
    // --- Soumettre une définition
    if (in_array('lexikon_submit',$permsNames)){
    $mainMenu['submit']['url'] = $moduleUrl . "/submit.php";
    $mainMenu['submit']['lib'] = _MB_SLD_LEXIKON_SUBMIT;
    }
    
    // --- Suggérer une définition
    if (in_array('lexikon_request',$permsNames)){
    $mainMenu['submit']['url'] = $moduleUrl . "/request.php";
    $mainMenu['submit']['lib'] = _MB_SLD_LEXIKON_REQUEST;
    }
    
    // --- Chercher une définition
    if (in_array('lexikon_view',$permsNames)){
    $mainMenu['submit']['url'] = $moduleUrl . "/search.php";
    $mainMenu['submit']['lib'] = _MB_SLD_LEXIKON_SEARCH;
    }
    
    return $mainMenu;

}
    
    
  } // fin de la classe
    


?>