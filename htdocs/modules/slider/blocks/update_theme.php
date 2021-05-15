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
function b_slider_update_theme_show($options)
{
global $xoopsConfig;
    $block = array();
// echo "<hr><pre>" . print_r($xoopsConfig, true ). "</pre><hr>";

    include_once XOOPS_ROOT_PATH . '/modules/slider/class/Slides.php';
    $myts = MyTextSanitizer::getInstance();

    $helper      = Helper::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
    
    // selection des slides actifs
    $now = time();
    
    //recupe du theme actif
    $theme = $xoopsConfig['theme_set'];
    $slides = getSlidesActifs($theme);
        
    //--------------------------------------------------------------
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    //echo "<hrt><pre>" . print_r($options, true) . "</pre><hr>";
    $block['hide'] = ($options[0]==0) ? 1 : 0;
    $block['slides'] = $slides;    
    
    
    //--------------------------------------------------------------
    $bolOk = build_new_tpl($slides, $theme, false);
    $block['generation'] = ($bolOk) ? _MB_SLIDER_TPL_OK : _MB_SLIDER_TPL_NOT_OK;
   
    $block['now'] = sprintf(_MB_SLIDER_TPL_HEURE_COURANTE, date("Y-m-d H:i:s", $now));    
    return $block;

}

/**
 * Function edit block
 * @param  $options
 * @return string
 */
function b_slider_update_theme_edit($options)
{

    include_once XOOPS_ROOT_PATH . '/modules/slider/class/slides.php';
    $helper = Helper::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    
    
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $showBlock = (isset($options[0])) ? $options[0]: 0; 
        $radShowBlock = new \XoopsFormRadioYN(_BL_SLIDER_SHOW_BLOCK, 'options[0]', $showBlock);
        $radShowBlock->SetDescription(_BL_SLIDER_SHOW_BLOCK_DESC);
        $form->addElement($radShowBlock);
        
        
    return $form->render();


}

