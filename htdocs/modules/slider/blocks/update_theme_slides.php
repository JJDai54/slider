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

use XoopsModules\Slider;
use XoopsModules\Slider\Helper;
use XoopsModules\Slider\Constants;

include_once XOOPS_ROOT_PATH . '/modules/slider/include/common.php';

/**
 * Function show block
 * @param  $options
 * @return array
 */
function b_slider_update_theme_slides_show($options)
{
global $xoopsConfig, $helper;
//exit;
    $helper      = Helper::getInstance();
    //recupe du theme actif
    $theme = $xoopsConfig['theme_set'];
    $block = array();
    $themesHandler = $helper->getHandler('Themes');
    $slidesHandler = $helper->getHandler('Slides');
    
    $themeObj = $themesHandler->getThemeByName($theme);
    $hideBlock = 1;
    $block = array();
    //--------------------------------------------------

    
    $periodicite = $themeObj['theme_random'];
    $now = time();    
    
    
    

////////////////////////////////////////////////////////////
    
    
    $slides = $slidesHandler->getSlidesActifs($theme, ($periodicite != 'j'));
//echo "===>Slides : <hr><pre>" . print_r($slides, true) . "</pre><hr>";
    //--------------------------------------------------------------
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    //echo "<hrt><pre>" . print_r($options, true) . "</pre><hr>";
   
    
    //--------------------------------------------------------------
    $forceRebuild = $helper->getConfig('forceRebuildSlides');
    //$criteria = new \criteria("theme_actif")
    $bolOk = build_new_tpl($slides, $theme, $periodicite, $forceRebuild);
    $block['generation'] = ($bolOk) ? _MB_SLIDER_TPL_OK : _MB_SLIDER_TPL_NOT_OK;
   
    $block['now'] = sprintf(_MB_SLIDER_TPL_HEURE_COURANTE, date("Y-m-d H:i:s", $now));    

    return $block;    
}

/**
 * Function edit block
 * @param  $options
 * @return string
 */
function b_slider_update_theme_slides_edit($options)
{



}
/* ********************************************************* */
/**********************************************************************
 * 
 **********************************************************************/
function build_new_tpl($slides, $theme, $periodicite, $forceRebuild = false){
global $helper, $themesHandler;


//echo "<hr>slides<pre>" . print_r($slides, true) . "</pre><hr>"; exit("build_new_tpl");   
//exit;
    //$themeVersion = sld_getThemesVersion($theme);
    $themesHandler = $helper->getHandler('Themes');
    $dbTheme = $themesHandler->getThemeByName($theme);
    
    // generation du fichier de flag pour eviter de reconstruire à chaque connexion utilisateur   
    //construction d'un tableu des id trié par ordre croissant
    $slide_Ids = array_keys($slides);
    //sort($slide_Ids);
    $newFlag = implode("|", $slide_Ids);
    $newFlag  = sld_getFlagPeriodicity($periodicite, array_keys($slides));  
  
    //chargement du fichier en court
     $fFlag = XOOPS_ROOT_PATH . "/uploads/slider/images/slides/" . $theme . ".txt";
     $oldflag = sld_loadTextFile($fFlag);
     
// echo "<hr>===>newFlag = {$newFlag}";  
// echo "<br>===>oldFlag = {$oldflag}<hr>";  
    
    //si le nouveau flag egal l'ancien flag pas de reconstruction du tpl des slides
    if ($newFlag == $oldflag && !$forceRebuild) return false;   
//    echo "===>oldFlag = {$oldflag}<br>===>newFlag = {$newFlag}<br>";
    
    generer_new_tpl_slider($theme);
    return true;        
}


