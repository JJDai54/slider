<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * slider module for xoops
 *
 * @copyright      2021 XOOPS Project (https://xoops.org)
 * @license        GPL 2.0 or later
 * @package        slider
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         TDM XOOPS - Email:<info@email.com> - Website:<http://xoops.org>
 */

use Xmf\Request;
use XoopsModules\Slider;
use XoopsModules\Slider\Constants;
use XoopsModules\Slider\Common;

require __DIR__ . '/header.php';
// Get all request values
$op = Request::getCmd('op', 'list');
$styId = Request::getInt('sty_id');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'slider_admin_styles.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('styles.php'));
        $adminObject->addItemButton(\_AM_SLIDER_ADD_STYLE, 'styles.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $stylesCount = $stylesHandler->getCountStyles();
        $stylesAll = $stylesHandler->getAllStyles($start, $limit);
        $GLOBALS['xoopsTpl']->assign('styles_count', $stylesCount);
        $GLOBALS['xoopsTpl']->assign('slider_url', \SLIDER_URL);
        $GLOBALS['xoopsTpl']->assign('slider_upload_url', \SLIDER_UPLOAD_URL);
        // Table view styles
        if ($stylesCount > 0) {
            foreach (\array_keys($stylesAll) as $i) {
                $style = $stylesAll[$i]->getValuesStyles();
                $GLOBALS['xoopsTpl']->append('styles_list', $style);
                unset($style);
            }
            // Display Navigation
            if ($stylesCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($stylesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_SLIDER_THEREARENT_STYLES);
        }
        break;
    case 'new':
        $templateMain = 'slider_admin_styles.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('styles.php'));
        $adminObject->addItemButton(\_AM_SLIDER_LIST_STYLES, 'styles.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $stylesObj = $stylesHandler->create();
        $form = $stylesObj->getFormStyles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'clone':
        $templateMain = 'slider_admin_styles.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('styles.php'));
        $adminObject->addItemButton(\_AM_SLIDER_LIST_STYLES, 'styles.php', 'list');
        $adminObject->addItemButton(\_AM_SLIDER_ADD_STYLE, 'styles.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Request source
        $styIdSource = Request::getInt('sty_id_source');
        // Get Form
        $stylesObjSource = $stylesHandler->get($styIdSource);
        $stylesObj = $stylesObjSource->xoopsClone();
        $form = $stylesObj->getFormStyles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('styles.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($styId > 0) {
            $stylesObj = $stylesHandler->get($styId);
        } else {
            $stylesObj = $stylesHandler->create();
        }
        // Set Vars
        $stylesObj->setVar('sty_name', Request::getString('sty_name', ''));
        $stylesObj->setVar('sty_css', Request::getString('sty_css', ''));
        // Insert Data
        if ($stylesHandler->insert($stylesObj)) {
                \redirect_header('styles.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_SLIDER_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $stylesObj->getHtmlErrors());
        $form = $stylesObj->getFormStyles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'slider_admin_styles.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('styles.php'));
        $adminObject->addItemButton(\_AM_SLIDER_ADD_STYLE, 'styles.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_SLIDER_LIST_STYLES, 'styles.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $stylesObj = $stylesHandler->get($styId);
        $stylesObj->start = $start;
        $stylesObj->limit = $limit;
        $form = $stylesObj->getFormStyles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'slider_admin_styles.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('styles.php'));
        $stylesObj = $stylesHandler->get($styId);
        $styName = $stylesObj->getVar('sty_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('styles.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($stylesHandler->delete($stylesObj)) {
                \redirect_header('styles.php', 3, \_AM_SLIDER_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $stylesObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'sty_id' => $styId, 'start' => $start, 'limit' => $limit, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_SLIDER_FORM_SURE_DELETE, $stylesObj->getVar('sty_name')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
