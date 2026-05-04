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
$slidesObj = $slidesHandler->get($sldId);
$sldTitle = $slidesObj->getVar('sld_short_name');
if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
    if (!$GLOBALS['xoopsSecurity']->check()) {
        \redirect_header('slides.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
    }
    if ($slidesHandler->delete($slidesObj)) {
        \redirect_header('slides.php', 3, _AM_SLIDER_FORM_DELETE_OK);
    } else {
        $GLOBALS['xoopsTpl']->assign('error', $slidesObj->getHtmlErrors());
    }
} else {
    $xoopsconfirm = new Common\XoopsConfirm(
        ['ok' => 1, 'sld_id' => $sldId, 'op' => 'delete'],
        $_SERVER['REQUEST_URI'],
        \sprintf(_AM_SLIDER_FORM_SURE_DELETE, $slidesObj->getVar('sld_short_name')));
    $form = $xoopsconfirm->getFormXoopsConfirm();
    $GLOBALS['xoopsTpl']->assign('form', $form->render());
}

//permet le rafraissement de la page d'accueil    
deleteSliderthemeFlag($sld_theme);

