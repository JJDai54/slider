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

CREATE TABLE tdmdownloads_cat (
  cat_cid INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  cat_pid INT(5) UNSIGNED NOT NULL DEFAULT '0',
  cat_title VARCHAR(255) NOT NULL DEFAULT '',
  cat_imgurl VARCHAR(255) NOT NULL DEFAULT '',
  cat_description_main TEXT NOT NULL,
  cat_weight INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (cat_cid),
  KEY cat_pid (cat_pid)
)

*/
use XoopsModules\Slider;

class Slider_Tdmdownloads extends Slider_Plugin

{
var $options = array(
            'table'        => 'tdmdownloads_cat',
            'fld_id'       => 'cat_cid',
            'fld_pid'      => 'cat_pid',
            'fld_name'     => 'cat_title',
            'fld_weight'   => 'cat_weight',
            'captionAll'   => 'tdmdownloads_view',
//            'captionAll'   => _ALL,
            'catPage'      => 'search.php',
            'catParamName' => 'cat');

 /* ********************
 *
 *********************** */   
public function getMainMenu(){
$this->options['captionAll'] = _MB_SLD_TDMDOWNLOADS_ALL_CAT;
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $permsNames = $this->getPermsissionsNames();
    $mainMenu = array();
    
    $mainMenu['index']['url'] = $moduleUrl . "/index.php";
    $mainMenu['index']['lib'] = _MB_SLD_TDMDOWNLOADS_ALL_CAT;
    
    $mainMenu['search']['url'] = $moduleUrl . "/search.php";
    $mainMenu['search']['lib'] = _MB_SLD_TDMDOWNLOADS_SEARCH;
    
    
    $mainMenu['submit']['url'] = $moduleUrl . "/submit.php";
    $mainMenu['submit']['lib'] = _MB_SLD_TDMDOWNLOADS_SUBMIT;
    //-------------------------------------------
    
    return $mainMenu;

}
    
  } // fin de la classe
    


?>