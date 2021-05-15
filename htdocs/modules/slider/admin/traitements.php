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

use Xmf\Request;
use XoopsModules\Slider;
use XoopsModules\Slider\Constants;
use XoopsModules\Slider\Common;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', '');


//-------------------------------------------------------        
switch ($op) {
    case 'force_slides_management' :
        \forceslidesManagement();
    break;
    
    case 'clean_themes_dir':
        \cleanAllThemesFolder();
    break;
    
    case 'activate_block':
        \setBlockSliderVisible(true);
    break;
    
    case 'deactivate_block':
        \setBlockSliderVisible(true);
    break;
    
    default:

}

require __DIR__ . '/footer.php';
\redirect_header("index.php", 3, _AM_SLIDER_SLIDE_PROCESSING_OK);
