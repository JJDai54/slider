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
CREATE TABLE `extcal_cat` (
  `cat_id`     INT(11)      NOT NULL AUTO_INCREMENT,
  `cat_pid`    INT(11)      NOT NULL DEFAULT '0',
  `cat_name`   VARCHAR(255) NOT NULL,
  `cat_desc`   TEXT         NULL,
  `cat_color`  VARCHAR(6)   NOT NULL,
  `cat_weight` INT          NOT NULL DEFAULT '0',
  `cat_icone`  VARCHAR(50)  NOT NULL,
  PRIMARY KEY (`cat_id`)
)

*/

use XoopsModules\Extcal;

class Slider_Extcal extends Slider_Plugin
{
var $options = array(
            'table'        => 'extcal_cat',
            'fld_id'       => 'cat_id',
            'fld_pid'      => '',
            'fld_name'     => 'cat_name',
            'fld_weight'   => 'cat_weight',
            'fld_active'   => '',
            'permView'     => 'extcal_cat_view',
//            'captionAll'   => _ALL,
            'catPage'      => 'view_calendar-month.php',
            'catParamName' => 'cat');
            
        
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
$this->options['captionAll'] = _MB_SLD_EXTCAL_ALL_CAT;

    $permsNames = $this->getPermsissionsNames();
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
      
        $mainMenu['month']['url'] = $moduleUrl . "/view_calendar-month.php";
        $mainMenu['month']['lib'] = _MB_SLD_EXTCAL_PLANNING;
    
    
        $mainMenu['month']['submenu']['planning1']['url'] = $moduleUrl . "/view_calendar-month.php";
        $mainMenu['month']['submenu']['planning1']['lib'] = _MB_SLD_EXTCAL_VIEW_MONTH;
    
        $mainMenu['month']['submenu']['planning2']['url'] = $moduleUrl . "/view_month.php";
        $mainMenu['month']['submenu']['planning2']['lib'] = _MB_SLD_EXTCAL_VIEW_MONTH_LIST;
    
        $mainMenu['month']['submenu']['planning3']['url'] = $moduleUrl . "/view_week.php";
        $mainMenu['month']['submenu']['planning3']['lib'] = _MB_SLD_EXTCAL_VIEW_WEEK_LIST;
    
    
        $mainMenu['search']['url'] = $moduleUrl . "/view_search.php";
        $mainMenu['search']['lib'] = _MB_SLD_EXTCAL_SEARCH_EVENT;


    //$permHandler = Extcal\Perm::getHandler();
   //   if (count($permHandler->getAuthorizedCat($xoopsUser, 'extcal_cat_submit')) > 0) {
        if (in_array('extcal_cat_submit', $permsNames)){
          $mainMenu['submit']['url'] = $moduleUrl . "/view_new-event.php";
          $mainMenu['submit']['lib'] = _MB_SLD_EXTCAL_SUBMIT_EVENT;
        }
    
        $mainMenu['location']['url'] = $moduleUrl . "/location-list.php";
        $mainMenu['location']['lib'] = _MB_SLD_EXTCAL_LOCATIONS;
    
    return $mainMenu;

}
    

  } // fin de la classe
    


?>