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
function b_slider_surcharge_theme_show($options)
{
global $xoopsConfig, $helper;
    global $xoTheme;
    
    $block = array();
//     if($xoTheme){
//       $css = XOOPS_URL . "/modules/slider/assets/css/surcharge-theme.css";
//       //echo "<hr>{$css}<hr>";
//       $xoTheme->addStylesheet($css);
//       //$GLOBALS['xoTheme']->addStylesheet($css, null);
//     }
if(isset($options[0])){
    $css = $options[0];
}else{
$css = <<<__css__
body{
    background-color:#ffbd9d;
    color:#000000;
}
a{
    color:#800000;
}
a:hover{
    color:#0000ff;
}
.bg-primary{
    background-image:linear-gradient(#ff8040,#ff5706 60%,#c44000);
}
/**** Isotope Filtering ****/.isotope-item{
    z-index:2;
}
.isotope-hidden.isotope-item{
    pointer-events:none;
    z-index:1;
}
__css__;

}


    $block['surcharge_css'] = $css;
    return $block;

}

/**
 * Function edit block
 * @param  $options
 * @return string
 */
function b_slider_surcharge_theme_edit($options)
{
xoops_load('XoopsTableForm');
        xoops_load('XoopsFormLoader');
        
if(isset($options[0])){
    $css = $options[0];
}else{
$css = <<<__css__
body{
    background-color:#ffbd9d;
    color:#000000;
}
a{
    color:#800000;
}
a:hover{
    color:#0000ff;
}
.bg-primary{
    background-image:linear-gradient(#ff8040,#ff5706 60%,#c44000);
}
/**** Isotope Filtering ****/.isotope-item{
    z-index:2;
}
.isotope-hidden.isotope-item{
    pointer-events:none;
    z-index:1;
}
__css__;

}
//------------------------------------------------------------
include_once XOOPS_ROOT_PATH . "/class/xoopsform/tableform.php";
    //    public function __construct($title, $name, $action, $method = 'post', $addtoken = false, $summary = '')
    //$form = new \XoopsThemeForm('SURCHARCHE CSS', 'from-surcharge-css','');
    $form = new \XoopsTableForm('SURCHARCHE CSS', 'from-surcharge-css','');
    //$form->setExtra('enctype="multipart/form-data"');
    $cssEditor = new \XoopsFormTextArea("zzzzz", "options[0]", $css, 12, 80);    
    $form->addElement($cssEditor, false);
    //============================================================

    return $form->render();
}

