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
 * xbootstrap - Slides management module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        xbootstrap
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         JJDai - Email:<jjdelalandre@orange.fr> - Website:<http://jubile.fr>
 */

use Xmf\Request;
use XoopsModules\Xbootstrap;
use XoopsModules\Xbootstrap\Constants;
use XoopsModules\Xbootstrap\Common;

use XoopsModules\Slider;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request theme_id
$themeId = Request::getInt('theme_id');
$theme   = Request::getString('theme_folder', '');
// $gp = array_merge($_GET, $_POST);
// sld_echoArray($gp, 'get/post', 'red');
// sld_echoArray($_FILES, 'Files', 'blue');

$clearTblBefore = false;
        
switch ($op) {
	case 'list_refresh':
        $clearTblBefore = true;
	case 'list':
	default:
        // mise à jour de la liste des thèmes actif
        // ceux non actif ne sont pas supprimés de la table, 
        // ce qui permet éventuellementderécupérer les paraametres lors de la réactivation
        $themesHandler->updateThemesValid($clearTblBefore);
        
        
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
		$templateMain = 'slider_admin_themes.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('themes.php'));
        
		//$adminObject->addItemButton(_AM_SLIDER_ADD_THEME, 'themes.php?op=new', 'add');
		$adminObject->addItemButton(_AM_SLIDER_REFRESH_TBL_THEME, 'themes.php?op=list_refresh', 'delete');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        
        $criteria = new \criteria('theme_status', 1, '=');
		$themesCount = $themesHandler->getCountThemes($criteria);
		$themesAll = $themesHandler->getAllThemes($criteria, $start, $limit);
		$GLOBALS['xoopsTpl']->assign('themes_count', $themesCount);
// 		$GLOBALS['xoopsTpl']->assign('xbootstrap_url', XBOOTSTRAP_URL);
// 		$GLOBALS['xoopsTpl']->assign('xbootstrap_upload_url', XBOOTSTRAP_UPLOAD_URL);
        
        $xoTheme->addScript(XOOPS_URL . '/Frameworks/trierTableauHTML/trierTableau.js');
		// Table view themes
		if ($themesCount > 0) {
			foreach (\array_keys($themesAll) as $i) {
				$theme = $themesAll[$i]->getValuesThemes();
//                 if( $theme['version'] == 4){
//                     $theme['transition_caption'] = ($theme['theme_transition'] == 1) ? _AM_SLIDER_THEME_TRANSITION_VERTICAL : _AM_SLIDER_THEME_TRANSITION_HORIZONTAL ;
//                 }else{
//                     $theme['transition_caption'] = 'ooo' ;
//                 }
                        
				$GLOBALS['xoopsTpl']->append('themes_list', $theme);
				unset($theme);
			}
			// Display Navigation
			if ($themesCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($themesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_SLIDER_THEREARENT_THEMES);
		}
		break;
        
	case 'save':
//exit;
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('themes.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if ($themeId > 0) {
			$themesObj = $themesHandler->get($themeId);
		} else {
			$themesObj = $themesHandler->create();
		}
		// Set Vars
        //$theme   = Request::getString('theme_folder', '');
        //$version = Request::getString('theme_version', 3);
        
		$themesObj->setVar('theme_folder', $theme);
		$themesObj->setVar('theme_mycss',  Request::getString('theme_mycss', ''));
		$themesObj->setVar('theme_random',  Request::getString('theme_random', 'j'));
		$themesObj->setVar('theme_transition', Request::getString('theme_transition', ''));
		$themesObj->setVar('theme_tpl_slider', Request::getString('theme_tpl_slider', 'slider_theme_xbootstrap_3'));
 $attributs =  Request::getArray('css', null);         
//sld_echoArray($attributs, 'saveNewAttribute', 'blue');           
		
        //suppresion des images
        $delImg = Request::getArray('del', null);
        if($delImg){
          foreach($delImg AS $keyClass=>$class){
              foreach($class AS $keyAttrinute=>$attribute){
                  //unset($attributs[$keyClass][$keyAttrinute]);
                  $attributs[$keyClass][$keyAttrinute] = '';
              }
          }
        }
//sld_echoArray($attributs, 'saveNewAttribute-del', 'red');           
        
        
        
        
        
        // Insert Data
		if ($themesHandler->insert($themesObj)) {
$css = Request::getArray('css', null);   
include "uploader.php";   
     
            $newCss     = Request::getString('theme_whiteCss', '');
            $newDarkCss = Request::getString('theme_darkCss', '');
            
            if($themesObj->isXswatch4E()){
                $themesObj->updateCss_xswatch4E($newCss, false);
                $themesObj->updateCss_xswatch4E($newDarkCss, true);
            }
           $css = getCssParser($theme, $newCss);
           $css->saveNewAttribute($attributs, false);
          Slider\ThemesHandler::cleanAllCaches($theme);          
//exit;        

//sld_echoArray($attributs, 'saveNewAttribute2', 'blue');           
//           exit;
			\redirect_header('themes.php?op=list', 2, _AM_SLIDER_FORM_OK);
		}
        
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $themesObj->getHtmlErrors());
		$form = $themesObj->getFormThemes();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
        
	case 'edit':
		$templateMain = 'slider_admin_themes.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('themes.php'));
		//$adminObject->addItemButton(_AM_SLIDER_ADD_THEME, 'themes.php?op=new', 'add');
		$adminObject->addItemButton(_AM_SLIDER_THEMES_LIST, 'themes.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$themesObj = $themesHandler->get($themeId);
		$form = $themesObj->getFormThemes();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
        
	case 'edit_mycss':
		$templateMain = 'slider_admin_themes.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('themes.php'));
		//$adminObject->addItemButton(_AM_SLIDER_ADD_THEME, 'themes.php?op=new', 'add');
		$adminObject->addItemButton(_AM_SLIDER_THEMES_LIST, 'themes.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$themesObj = $themesHandler->get($themeId);
		$form = $themesObj->getFormMyCss();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
        
	case 'save_mycss':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('themes.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}

        //$theme   = Request::getString('theme_folder', '');
        $mycss   = Request::getString('theme_mycss', '');
        
        $fullName = XOOPS_ROOT_PATH . "/themes/{$theme}/css/my_css.css";
        saveTexte2File($fullName, $mycss);        
        
        \force_rebuild_slider();		
        \redirect_header('themes.php?op=list', 2, _AM_SLIDER_FORM_OK);
		break;
        
	case 'allowed_slider':
        $etat   = Request::getInt('etat', 0);    
        $bolOk = $themesHandler::set_allowed_slider($theme, $etat);
        \redirect_header('themes.php?op=list', 2, _AM_SLIDER_FORM_OK);
		break;
        
        
	case 'generer_new_slider':
        $bolOk = generer_new_tpl_slider($theme);
        \redirect_header('themes.php?op=list', 2, _AM_SLIDER_FORM_OK);
		break;
        
	case 'generer_old_slider':
        $bolOk = cleanThemeFolder($theme);
        \redirect_header('themes.php?op=list', 2, _AM_SLIDER_FORM_OK);
		break;
}
require __DIR__ . '/footer.php';
