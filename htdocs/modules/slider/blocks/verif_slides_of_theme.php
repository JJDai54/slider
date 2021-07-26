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
function b_slider_verif_slides_of_theme_show($options)
{
global $xoopsConfig, $helper;
    $helper      = Helper::getInstance();
    $theme = $xoopsConfig['theme_set'];
    $block = array();
    $themesHandler = $helper->getHandler('Themes');
    $slidesHandler = $helper->getHandler('Slides');
    
    $themeObj = $themesHandler->getThemeByName($theme);
    //--------------------------------------------------
    
    
    
    if (!$themesHandler->isActif($theme)) {
        $block['msg'] = "{$theme} : inactif";
        return $block; 
    }
    
    $block['msg'] = "{$theme} : actif";

    //--------------------------------------------------
// echo "<hr><pre>" . print_r($xoopsConfig, true ). "</pre><hr>";
    $periodicite = $themeObj['theme_random'];
//     $hideBlock   = (isset($options[1])) ? $options[1] : 1;
//     $hideBlock   = ($options[1] == 1) ? 0 : 1;
    $hideBlock   = 0;
    //----------------------------------------------------------        
//    include_once XOOPS_ROOT_PATH . '/modules/slider/class/Slides.php';
//    $myts = MyTextSanitizer::getInstance();
    $now = time();    
    $slides = $slidesHandler->getSlidesActifs($theme, ($periodicite != 'j'));
    //chargement du fichier en court
    $fFlag = XOOPS_ROOT_PATH . "/uploads/slider/images/slides/" . $theme . ".txt";
    $oldflag = sld_loadTextFile($fFlag);
    
    // selection des slides actifs

    //recupe du theme actif

//echo "===>Slides : <hr><pre>" . print_r($slides, true) . "</pre><hr>";
    //--------------------------------------------------------------
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    //echo "<hrt><pre>" . print_r($options, true) . "</pre><hr>";
    $block['hide'] = $hideBlock;
    $block['slides'] = $slides;    
    
    
    //--------------------------------------------------------------
    $block['now'] = sprintf(_MB_SLIDER_TPL_HEURE_COURANTE, date("Y-m-d H:i:s", $now));    
    return $block;

}

/**
 * Function edit block
 * @param  $options
 * @return string
 */
function b_slider_verif_slides_of_theme_edit($options)
{



}


