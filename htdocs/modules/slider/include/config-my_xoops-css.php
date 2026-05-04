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


//defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * This keeping config in files has really got to stop. If we can't actually put these into
 * the actual XOOPS config then we should do this. (Who said this? You are right!)
 */
 
$config = array();

    $config['body']['background-color'] = array('type'=>'color', 'default'=>'#888888', 'caption'=>_AM_SLIDER_THEME_BACKCOLOR);
    $config['body']['background-image'] = array('type'=>'file',  'default'=>'', 'caption'=>_AM_SLIDER_THEME_BACKIMAGE);
    $config['body']['color']            = array('type'=>'color', 'default'=>'#000000', 'caption'=>_AM_SLIDER_THEME_COLOR);
    $config['a']['color']               = array('type'=>'color', 'default'=>'#FFFFFF', 'caption'=>_AM_SLIDER_THEME_LINK_COLOR) ;
    $config['a:hover']['color']         = array('type'=>'color', 'default'=>'#0000FF', 'caption'=>_AM_SLIDER_THEME_LINK_HOVER_COLOR) ;
    //$config['.mark,mark']['background-color'] = array('type'=>'color', 'default'=>'#fcf8e3', 'caption'=>_AM_SLIDER_THEME_MARK) ;
    $config['.bg-primary']['background-image'] = array('type'=>'linear', 'default'=>'linear-gradient(#54b4eb,#2fa4e7 60%,#1d9ce5)', 'caption'=>_AM_SLIDER_THEME_NAVBBAR_BACKCOLOR) ;




    //$config['#block_ListIds-99']['background-color'] = array('type'=>'color', 'default'=>'#ff0000', 'caption'=>_AM_SLIDER_THEME_NAVBBAR_BACKCOLOR) ;
//     $config['.navbar-expand-bg']['background-color'] = array('type'=>'color', 'default'=>'#ff0000', 'caption'=>_AM_SLIDER_THEME_NAVBBAR_BACKCOLOR) ;
//     $config['.navbar-dark']['background-color'] = array('type'=>'color', 'default'=>'#ff0000', 'caption'=>_AM_SLIDER_THEME_NAVBBAR_BACKCOLOR) ;
//     $config['.navbar-bg']['background-color'] = array('type'=>'color', 'default'=>'#ff0000', 'caption'=>_AM_SLIDER_THEME_NAVBBAR_BACKCOLOR) ;
//     $config['.xoopscore-bg']['background-color'] = array('type'=>'color', 'default'=>'#ff0000', 'caption'=>_AM_SLIDER_THEME_NAVBBAR_BACKCOLOR) ;

    return $config;

