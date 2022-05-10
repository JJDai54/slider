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
	case 'logo-form':
		$templateMain = 'slider_admin_logo.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('themes.php'));
		//$adminObject->addItemButton(_AM_SLIDER_ADD_THEME, 'themes.php?op=new', 'add');
		$adminObject->addItemButton(_AM_SLIDER_THEMES_LIST, 'themes.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$themesObj = $themesHandler->get($themeId);
		$form = $themesObj->getFormLogo();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
        

	case 'logo-loader':
        if(!$_FILES[$_POST['xoops_upload_file'][0]]['name'] || $themeId == 0) \redirect_header('themes.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        //echo "<hr>" . $_FILES[$_POST['xoops_upload_file'][0]]['name'] . "<hr>"; exit;
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('themes.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}

include_once XOOPS_ROOT_PATH . '/class/uploader.php';        
		$themesObj = $themesHandler->get($themeId);
		$themeFolder = $themesObj->getVar('theme_folder');
    
////////////////////////////////////////////////////////
//$f['folder']  = SLIDER_UPLOAD_IMAGE_PATH . '/slides/'; 
        $f['folder']  = XOOPS_ROOT_PATH . "/themes/{$themeFolder}/images";
        $f['maxwidth']  = 550; 
        $f['maxheight']  = 350; 
///////////////////////////////////////
        //if (!is_dir($f['folder'])) mkdir($f['folder'], 0774);

        $uploaderErrors = '';
        $uploader = new \XoopsMediaUploader($f['folder'] , 
                                            $helper->getConfig('mimetypes_image'), 
                                            $helper->getConfig('maxsize_image'), null, null);
    
        $uf = $_FILES['logo'];
//sld_echoArray($uf, 'upload', 'green');
        $index = 0;
        
      //-------------------------------------------------------
      if ($uploader->fetchMedia($_POST['xoops_upload_file'][$index])) {

          $h= strlen($uf['name']) - strrpos($uf['name'], '.');   
          $imgName = substr($uf['name'],0,-$h);
          $imgName = TexteSansAccent($imgName, "_");
          $uploader->setPrefix($imgName . "-");
          //$uploader->fetchMedia($_POST['xoops_upload_file'][$index]);
          
          
          if (!$uploader->upload()) {
              $uploaderErrors = "\n" . $uploader->getErrors();
          } else {
              $savedFilename = $uploader->getSavedFileName();
              /*
              if ($f['maxwidth'] > 0 && $f['maxheight'] > 0) {
                  // Resize image
                  $imgHandler                = new Slider\Common\Resizer();
                  //$endFile = "{$theme}-{$savedFilename}" ;
                  
                  $imgHandler->sourceFile    = $f['folder']  . $savedFilename;
                  $imgHandler->endFile       = $f['folder']  . $savedFilename;
                  $imgHandler->imageMimetype = $uf['type'];
                  $imgHandler->maxWidth      = $f['maxwidth'];
                  $imgHandler->maxHeight     = $f['maxheight'];
                  $result                    = $imgHandler->resizeImage();
                  
              }
              */
                $fSource =  $f['folder'] . '/' . $savedFilename;
                //echo "<hr>" . $fSource . '<br>' . $f['folder'] . '/logo.png' . '<hr>';
                unlink( $f['folder'] . '/logo.png');
                rename( $fSource, $f['folder'] . '/logo.png');
                $themesHandler->cleanAllCaches($themeFolder);      
                \redirect_header('themes.php?op=list', 2, _AM_SLIDER_FORM_OK);          
                //exit ('renomage');
          }
      } else {
          if ($f['name'] != '') {
              $uploaderErrors = $uploader->getErrors();
          }
      }
    
//        exit ('logo-loader');
////////////////////////////////////////////////////////        
		break;
        

	default:
		break;
}
require __DIR__ . '/footer.php';
