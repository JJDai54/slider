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



define ('_SLD_PERIODICITY_NEVER',     'j'); // Jamais
define ('_SLD_PERIODICITY_RANDOM',    'r'); // Random
define ('_SLD_PERIODICITY_MINUTE',    'n'); // Minute pour tester en dev
define ('_SLD_PERIODICITY_HOUR',      'h'); // hour
define ('_SLD_PERIODICITY_DAY',       'd'); // day
define ('_SLD_PERIODICITY_WEEK',      'w'); // week
define ('_SLD_PERIODICITY_MONTH',     'm'); // month
define ('_SLD_PERIODICITY_BIMONTLY',  'b'); // bimestre
define ('_SLD_PERIODICITY_QUATER',    'q'); // trimestre
define ('_SLD_PERIODICITY_SEMESTER',  's'); // semestre
define ('_SLD_PERIODICITY_YEAR',      'y'); // year

/**
 * Function show block
 * @param  $options
 * @return array
 */
function b_slider_update_theme_show($options)
{
global $xoopsConfig, $helper;
    $block = array();
// echo "<hr><pre>" . print_r($xoopsConfig, true ). "</pre><hr>";
    $periodicite = (isset($options[0])) ? $options[0]: 0;
    $hideBlock = ($options[1]==0) ? 1 : 0;
    //----------------------------------------------------------        
    include_once XOOPS_ROOT_PATH . '/modules/slider/class/Slides.php';
    $myts = MyTextSanitizer::getInstance();

    $helper      = Helper::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
    
    // selection des slides actifs
    $now = time();
    
    //recupe du theme actif
    $theme = $xoopsConfig['theme_set'];
    $slides = getSlidesActifs($theme, ($periodicite != 'j'));
    //--------------------------------------------------------------
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    //echo "<hrt><pre>" . print_r($options, true) . "</pre><hr>";
    $block['hide'] = $hideBlock;
    $block['slides'] = $slides;    
    
    
    //--------------------------------------------------------------
    $forceRebuild = $helper->getConfig('forceRebuildSlides');
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
function b_slider_update_theme_edit($options)
{

    include_once XOOPS_ROOT_PATH . '/modules/slider/class/slides.php';
    $helper = Helper::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    
    
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');


        $periodicite = (isset($options[0])) ? $options[0]: 0; 
        $k = _SLD_PERIODICITE;
            $selPeriodicite = new XoopsFormSelect(_MB_SLIDER_PERIODICITY_RND, "options[0]", $periodicite);
            $selPeriodicite->addOption(_SLD_PERIODICITY_NEVER,    _MB_SLIDER_PERIODICITE_NEVER);
            $selPeriodicite->addOption(_SLD_PERIODICITY_RANDOM,   _MB_SLIDER_PERIODICITE_RANDOM);
            $selPeriodicite->addOption(_SLD_PERIODICITY_MINUTE,   _MB_SLIDER_PERIODICITE_MINUTE);
            $selPeriodicite->addOption(_SLD_PERIODICITY_HOUR,     _MB_SLIDER_PERIODICITE_HOUR);
            $selPeriodicite->addOption(_SLD_PERIODICITY_DAY,      _MB_SLIDER_PERIODICITE_DAY);
            $selPeriodicite->addOption(_SLD_PERIODICITY_WEEK,     _MB_SLIDER_PERIODICITE_WEEK);
            $selPeriodicite->addOption(_SLD_PERIODICITY_MONTH,    _MB_SLIDER_PERIODICITE_MONTH);
            $selPeriodicite->addOption(_SLD_PERIODICITY_BIMONTLY, _MB_SLIDER_PERIODICITE_BIMONTHLY);
            $selPeriodicite->addOption(_SLD_PERIODICITY_QUATER,   _MB_SLIDER_PERIODICITE_QUATER);
            $selPeriodicite->addOption(_SLD_PERIODICITY_SEMESTER, _MB_SLIDER_PERIODICITE_SEMESTER);
            $selPeriodicite->addOption(_SLD_PERIODICITY_YEAR,     _MB_SLIDER_PERIODICITE_YEAR);
            $selPeriodicite->setDescription(_MB_SLIDER_PERIODICITY_RND_DESC);

            $form->addElement($selPeriodicite);


        $showBlock = (isset($options[1])) ? $options[1]: 0; 
        $radShowBlock = new \XoopsFormRadioYN(_MB_SLIDER_SHOW_BLOCK, 'options[1]', $showBlock);
        $radShowBlock->SetDescription(_MB_SLIDER_SHOW_BLOCK_DESC);
        $form->addElement($radShowBlock);
        
        
    return $form->render();


}


