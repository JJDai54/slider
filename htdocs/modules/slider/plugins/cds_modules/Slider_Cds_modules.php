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
*/
use XoopsModules\Slider;

class Slider_Cds_modules extends Slider_Plugin
{
var $options = array();

    
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
      $permsNames = $this->getPermsissionsNames();
      $moduleUrl = XOOPS_URL . '/modules/';
      $mainMenu = array();
    
      $mainMenu['separateur_before']['url'] = "#";
      $mainMenu['separateur_before']['lib'] = "<hr>";
    
      $module = 'lexikon';
      $mainMenu[$module]['url'] = $moduleUrl . $module;
      $mainMenu[$module]['lib'] = _MB_SLD_CDS_MODULES_LEXIKON;
    
      $module = 'xoopsfaq';
      $mainMenu[$module]['url'] = $moduleUrl . $module;
      $mainMenu[$module]['lib'] = _MB_SLD_CDS_MODULES_XOOPSFAQ;
    
      $mainMenu['Facebook']['url'] = "https://www.facebook.com/Conseil-Des-Sages-De-Sainte-Genevi%C3%A8ve-Des-Bois-120796678500074/";
      $mainMenu['Facebook']['lib'] = _MB_SLD_CDS_MODULES_FACEBOOK;
    
      $mainMenu['confinement']['url'] = $moduleUrl .  "newbb/viewtopic.php?topic_id=2";
      $mainMenu['confinement']['lib'] = _MB_SLD_CDS_MODULES_CONFINEMENT;
      
      $module = 'CHGmentions';
      $mainMenu[$module]['url'] = $moduleUrl . $module;
      $mainMenu[$module]['lib'] = _MB_SLD_CDS_MODULES_CHGMENTIONS;
    
      $mainMenu['partenaire']['url'] = $moduleUrl . "xmnews/article.php?news_id=32";
      $mainMenu['partenaire']['lib'] = _MB_SLD_CDS_MODULES_PARTENAIRE;
      
      $module = 'xsitemap';
      $mainMenu[$module]['url'] = $moduleUrl . $module;
      $mainMenu[$module]['lib'] = _MB_SLD_CDS_MODULES_XSITEMAP;
    
//       $mainMenu['separateur_after']['url'] = "#";
//       $mainMenu['separateur_after']['lib'] = "<hr>";

    return $mainMenu;
}

  } // fin de la classe
?>