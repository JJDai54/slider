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
use XoopsModules\Slider\Utility;

        $templateMain = 'slider_admin_slides.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('slides.php'));
        $adminObject->addItemButton(_AM_SLIDER_SLIDES_LIST, 'slides.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $slidesObj = $slidesHandler->create();
//         $newWeigh = $slidesHandler->getMax("sld_weight", $inpTheme, +10);
//         $slidesObj->setVar('sld_weight', $newWeigh);
//         echo "<hr>newWeigh = {$newWeigh}<hr>";
        $form = $slidesObj->getFormSlides($inpTheme);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
