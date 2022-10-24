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

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request sld_id
$sldId = Request::getInt('sld_id');
global $xoopsConfig;
 
$inpTheme = Request::getString('inpTheme',  $xoopsConfig['theme_set']);
$inpPeriodicity = Request::getInt('inpPeriodicity', '0');  
$inpActif = Request::getInt('inpActif', -1);  
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));

//$params = array( $$inpPeriodicity => $inpPeriodicity,  $$inpActif => $inpActif,  $$start => $start,  $$limit => $limit );     
$params = array( 'inptheme' => $inpTheme, 'inpPeriodicity' => $inpPeriodicity,  'inpActif' => $inpActif,  'start' => $start,  'limit' => $limit );     
//    echo "<hr>params<pre>" . print_r($params, true) . "</pre><hr>";
$paramsList = "inptheme={$inpTheme}&inpPeriodicity={$inpPeriodicity}&inpActif={$inpActif}&start={$start}";     
//    $gp = array_merge($_GET, $_POST);
//    echo "<hr>_GET/_POST<pre>" . print_r($gp, true) . "</pre><hr>";

switch ($op) {
    default:
        $op='list';
    case 'list':
    case 'new':
    case 'save':
    case 'delete':
        include_once ("slides-{$op}.php");
        break;
        
    case 'edit':
        $templateMain = 'slider_admin_slides.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('slides.php'));
        //$adminObject->addItemButton(_AM_SLIDER_ADD_SLIDE, "slides.php?op=new&theme={$inpTheme}", 'add');
        $adminObject->addItemButton(_AM_SLIDER_SLIDES_LIST, 'slides.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $slidesObj = $slidesHandler->get($sldId);
        $form = $slidesObj->getFormSlides($inpTheme,false,$paramsArr);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'bascule_actif':
        $sld_id = Request::getInt('sld_id', 0);
        $newValue = Request::getInt('value', 0);
        $sql = "UPDATE " . $xoopsDB->prefix("slider_slides") . " SET sld_actif={$newValue} WHERE sld_id={$sld_id}";
        $xoopsDB->queryf($sql);
        \redirect_header("slides.php?op=list&{$paramsList}", 0, "");

        //permet le rafraissement de la page d'accueil    
        deleteSliderthemeFlag($inpTheme);
        break;
        
    case 'bascule_periodicity':
        $sld_id = Request::getInt('sld_id', 0);
        $newValue = Request::getInt('value', 0);
        $sql = "UPDATE " . $xoopsDB->prefix("slider_slides") . " SET sld_periodicity={$newValue} WHERE sld_id={$sld_id}";
        $xoopsDB->queryf($sql);

        //permet le rafraissement de la page d'accueil    
        deleteSliderthemeFlag($inpTheme);
        \redirect_header("slides.php?op=list&{$paramsList}", 0, "");
        break;
        
    case 'weight':
        $sld_id = Request::getInt('sld_id', 0);
        $action = Request::getString('sens', "asc") ;
        //$sld_theme = Request::getString('sld_theme', '');
        $slidesHandler->updateWeight($sld_id, $action, $inpTheme);
        \redirect_header("slides.php?op=list&{$paramsList}", 0, "");
        break;
        //----------------------------------------------
        
    case 'update_periodicity'; 
        sld_updatePeriodicity($msg);
        \redirect_header("slides.php?op=list&{$paramsLst}", 3, $msg);
        break;

    case 'purger_sliders_folder':
        $imgDeleted = \purgerSliderFolder(1);
        $msg = ($imgDeleted == 0) ? _AM_SLIDER_IMG_DELETED_0: sprintf(_AM_SLIDER_IMG_DELETED_1, $imgDeleted);
        \redirect_header("slides.php?op=list&{$paramsList}", 3, $msg);
        break;

}
require __DIR__ . '/footer.php';

