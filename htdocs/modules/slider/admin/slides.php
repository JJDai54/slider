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
$select_theme = Request::getString('select_theme',  $xoopsConfig['theme_set']);
//echo "===>get select_theme = {$select_theme}<br>";      
switch ($op) {
    case 'list':
    default:
//echo "===>select_theme = {$select_theme}";
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'slider_admin_slides.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('slides.php'));
        $adminObject->addItemButton(_AM_SLIDER_ADD_SLIDE, "slides.php?op=new&select_theme={$select_theme}", 'add');
        $adminObject->addItemButton(_AM_SLIDER_UPDATE_PERIODICITY, "slides.php?op=update_periodicity&select_theme={$select_theme}", 'update');
        
        $imgDeleted = \purgerSliderFolder(0);
        if($imgDeleted > 0){
          $caption = sprintf(_AM_SLIDER_PURGER_SLIDES, $imgDeleted);
          $adminObject->addItemButton($caption, "slides.php?op=purger_sliders_folder&select_theme={$select_theme}", 'update');
        }
        
                
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $slidesCount = $slidesHandler->getCountSlides();
        
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('sld_theme', $select_theme, '='));
        //$criteria->add(new \Criteria('length(sld_theme)','0','=', 'OR'));
        //$criteria->add(new \Criteria('sld_theme', '','=', 'OR'));
        
        $criteria->add(new Criteria('sld_theme',  0, '=', '', "LENGTH(sld_theme)" ), 'OR');
   // public function __construct($column, $value = '', $operator = '=', $prefix = '', $function = '')
            
        $slidesAll = $slidesHandler->getAllSlides($criteria, $start, $limit,'sld_theme ASC, sld_weight ASC, sld_short_name');
        $GLOBALS['xoopsTpl']->assign('slides_count', $slidesCount);
        $GLOBALS['xoopsTpl']->assign('slider_url', SLIDER_URL);
        $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
        // Table view slides
        if ($slidesCount > 0) {
            foreach (\array_keys($slidesAll) as $i) {
                $slide = $slidesAll[$i]->getValuesSlides();
                $GLOBALS['xoopsTpl']->append('slides_list', $slide);
                unset($slide);
            }
            // Display Navigation
            if ($slidesCount > $limit) {
                include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($slidesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_SLIDER_THEREARENT_SLIDES);
        }
        
Utility::include_highslide(array('allowMultipleInstances'=>false));  
$xoTheme->addScript(XOOPS_URL . '/Frameworks/trierTableauHTML/trierTableau.js');      
                                 
        /* --------- selection du theme ----------------*/
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $sldThemeSelect = new \XoopsFormSelectTheme(_AM_SLIDER_SLIDE_SELECT_THEME, 'select_theme', $select_theme,1, true);        
        $sldThemeSelect->setDescription(_AM_SLIDER_SLIDE_SELECT_THEME_DESC);        
        $sldThemeSelect->setExtra("onChange=\"document.theme_form.submit()\"");
        $GLOBALS['xoopsTpl']->assign('sldThemeSelect', $sldThemeSelect->render());
        $GLOBALS['xoopsTpl']->assign('current_DateTime', \formatTimestamp(time(), 'm'));
        break;
        
    case 'new':
        $templateMain = 'slider_admin_slides.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('slides.php'));
        $adminObject->addItemButton(_AM_SLIDER_SLIDES_LIST, 'slides.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $slidesObj = $slidesHandler->create();
        $form = $slidesObj->getFormSlides($select_theme);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
        
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('slides.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($sldId > 0) {
            $slidesObj = $slidesHandler->get($sldId);
        } else {
            $slidesObj = $slidesHandler->create();
        }
        // Set Vars
        $slidesObj->setVar('sld_short_name', Request::getString('sld_short_name', ''));
        $slidesObj->setVar('sld_title', Request::getText('sld_title', ''));
        $slidesObj->setVar('sld_subtitle', Request::getText('sld_subtitle', ''));
        $slidesObj->setVar('sld_read_more', Request::getString('sld_read_more', ''));
        $slidesObj->setVar('sld_weight', Request::getInt('sld_weight', 0));
        $slideDate_beginArr = Request::getArray('sld_date_begin');
        $slideDate_beginObj = \DateTime::createFromFormat(_SHORTDATESTRING, $slideDate_beginArr['date']);
        $slideDate_beginObj->setTime(0, 0, 0);
        $slideDate_begin = $slideDate_beginObj->getTimestamp() + (int)$slideDate_beginArr['time'];
        $slidesObj->setVar('sld_date_begin', $slideDate_begin);
        $slideDate_endArr = Request::getArray('sld_date_end');
        $slideDate_endObj = \DateTime::createFromFormat(_SHORTDATESTRING, $slideDate_endArr['date']);
        $slideDate_endObj->setTime(0, 0, 0);
        $slideDate_end = $slideDate_endObj->getTimestamp() + (int)$slideDate_endArr['time'];
        $slidesObj->setVar('sld_date_end', $slideDate_end);
        $slidesObj->setVar('sld_actif', Request::getInt('sld_actif', 0));
        $slidesObj->setVar('sld_periodicity', Request::getInt('sld_periodicity', 0));
        $slidesObj->setVar('sld_theme', Request::getString('sld_theme', ''));
        
        $slidesObj->setVar('sld_button_title', Request::getString('sld_button_title', ''));
        $slidesObj->setVar('sld_style_title', Request::getText('sld_style_title'));
        $slidesObj->setVar('sld_style_subtitle', Request::getText('sld_style_subtitle'));
        $slidesObj->setVar('sld_style_button', Request::getText('sld_style_button'));
        
        //-------------------------------------------------------
        // Set Var sld_image
        $theme = Request::getString('sld_theme', '');
//  echo "<hr><pre>" . print_r($_FILES, true ). "</pre><hr>";       
 ///       if($_FILES['sld_image']['error'] == 0){
//            echo "===>Ok pour une image<br>";
              include_once XOOPS_ROOT_PATH . '/class/uploader.php';
              $filename       = $_FILES['sld_image']['name'];
              $imgMimetype    = $_FILES['sld_image']['type'];
              $imgNameDef     = Request::getString('sld_short_name');
              $uploaderErrors = '';
              $uploader = new \XoopsMediaUploader(SLIDER_UPLOAD_IMAGE_PATH . '/slides/', 
                                                          $helper->getConfig('mimetypes_image'), 
                                                          $helper->getConfig('maxsize_image'), null, null);
              if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                  $h= strlen($filename) - strrpos($filename, '.');   
                  $imgName = substr($filename,0,-$h);
                  $imgName = TexteSansAccent($imgName, "_");
      //            $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $filename);            
      //            echo "===>filename = {$filename}<br>===>h = {$h}<br>===>imgName = {$imgName}";            
      //exit;
                  $uploader->setPrefix($imgName . "-");
                  $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
                  if (!$uploader->upload()) {
                      $uploaderErrors = $uploader->getErrors();
                  } else {
                      $savedFilename = $uploader->getSavedFileName();
                      $maxwidth  = (int)$helper->getConfig('maxwidth_image');
                      $maxheight = (int)$helper->getConfig('maxheight_image');
                      if ($maxwidth > 0 && $maxheight > 0) {
                          // Resize image
                          $imgHandler                = new Slider\Common\Resizer();
                          $endFile = "{$theme}-{$savedFilename}" ;
                          
                          $imgHandler->sourceFile    = SLIDER_UPLOAD_IMAGE_PATH . "/slides/" . $savedFilename;
                          $imgHandler->endFile       = SLIDER_UPLOAD_IMAGE_PATH . "/slides/" . $savedFilename;
                          $imgHandler->imageMimetype = $imgMimetype;
                          $imgHandler->maxWidth      = $maxwidth;
                          $imgHandler->maxHeight     = $maxheight;
                          $result                    = $imgHandler->resizeImage();
                      }
                      $slidesObj->setVar('sld_image', $savedFilename);
                  }
              } else {
                  if ($filename > '') {
                      $uploaderErrors = $uploader->getErrors();
                  }
                  // il faut garder l'image existante si il n'y a pas eu de nouvelle selection
                  // ou l'image sélectionée dans la liste
                  $slidesObj->setVar('sld_image', Request::getString('sld_image'));

              }
//         }else{
// //            echo "===>pas d'image<br>";
//         }

              
        //suppression du fichier des flags pour forcer un rafraichissement
        //ce fichier contien la list des id des slide à afficher
//         $fFlag = XOOPS_ROOT_PATH . "/uploads/slider/images/slides/" . $theme . ".txt";
//         unlink($fFlag);
        //echo "===>{$fFlag}<br>";
            
        $bolOk = $slidesHandler->insert($slidesObj);
        // Insert Data
        if ($bolOk) {
            if ('' !== $uploaderErrors) {
                if ($themesHandler->isActif($theme)){
                    generer_new_tpl($theme);
                }
                //\force_rebuild_slider();
                \redirect_header("slides.php?op=edit&sld_id=" . $sldId, 5, $uploaderErrors);
            } else {
                \redirect_header("slides.php?op=list&select_theme={$theme}", 2, _AM_SLIDER_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $slidesObj->getHtmlErrors());
        $form = $slidesObj->getFormSlides($theme);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
        
    case 'edit':
        $templateMain = 'slider_admin_slides.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('slides.php'));
        //$adminObject->addItemButton(_AM_SLIDER_ADD_SLIDE, "slides.php?op=new&theme={$select_theme}", 'add');
        $adminObject->addItemButton(_AM_SLIDER_SLIDES_LIST, 'slides.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $slidesObj = $slidesHandler->get($sldId);
        $form = $slidesObj->getFormSlides($select_theme);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
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
        break;
        
    case 'bascule_actif':
        $sld_id = Request::getInt('sld_id', 0);
        $newValue = Request::getInt('value', 0);
        $sql = "UPDATE " . $xoopsDB->prefix("slider_slides") . " SET sld_actif={$newValue} WHERE sld_id={$sld_id}";
        $xoopsDB->queryf($sql);
        \redirect_header("slides.php?op=list&sld_theme={$select_theme}", 0, "");

        //permet le rafraissement de la page d'accueil    
        deleteSliderthemeFlag($sld_theme);
        break;
        
    case 'bascule_periodicity':
        $sld_id = Request::getInt('sld_id', 0);
        $newValue = Request::getInt('value', 0);
        $sql = "UPDATE " . $xoopsDB->prefix("slider_slides") . " SET sld_periodicity={$newValue} WHERE sld_id={$sld_id}";
        $xoopsDB->queryf($sql);

        //permet le rafraissement de la page d'accueil    
        deleteSliderthemeFlag($sld_theme);
        \redirect_header("slides.php?op=list&sld_theme={$select_theme}", 0, "");
        break;
        
    case 'weight':
        $sld_id = Request::getInt('sld_id', 0);
         $sld_weight = Request::getInt('sld_weight', 0);
         $sld_theme = Request::getString('sld_theme', '');
         $action = Request::getString('sens', "asc") ;
         switch ($action){
            case 'up'; 
              $sens =  '<';
              $ordre = "DESC";
              break;

            case 'down'; 
              $sens =  '>';
              $ordre = "ASC";
            break;

            case 'first'; 
              $sens =  '<';
              $ordre = "ASC";
            break;

            case 'last'; 
              $sens =  '>';
              $ordre = "DESC";
            break;
         }
         
        $tbl = $xoopsDB->prefix("slider_slides");
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('sld_theme', $select_theme));
        $criteria->add(new \Criteria('sld_weight', $sld_weight, $sens));
        $limit = 0;
        $start = 0;
        $slidesAll = $slidesHandler->getAllSlides($criteria, $start, $limit, "sld_weight {$ordre}, sld_short_name {$ordre}, sld_id");
        if(count($slidesAll) == 0  ){
                    \redirect_header("slides.php?op=list&sld_theme={$select_theme}", 0, "");
        }
        $key = array_key_first($slidesAll);
//            echo "===> count = " . count($slidesAll) . "<br>key={$key}"; 
        $slide = $slidesAll[$key]->getValuesSlides();
        $sld_id2 = $slide['id'];
        $sld_weight2 = $slide['weight'];
        

                
                
                
         switch ($action){
            case 'up'; 
            case 'down'; 
              $sql = "UPDATE {$tbl} SET sld_weight={$sld_weight2} WHERE sld_id={$sld_id}";
              $xoopsDB->queryf($sql);
              
              $sql = "UPDATE {$tbl} SET sld_weight={$sld_weight} WHERE sld_id={$sld_id2}";
              $xoopsDB->queryf($sql);
            break;

            case 'first'; 
              $sld_weight2 -= 10;  
              $sql = "UPDATE {$tbl} SET sld_weight={$sld_weight2} WHERE sld_id={$sld_id}";
              $xoopsDB->queryf($sql);
              
              $sql = "SET @rank=0;";
              $xoopsDB->queryf($sql);
              
              $sql = "update {$tbl} SET sld_weight = (@rank:=@rank+10) ORDER BY sld_weight ASC;";
              $xoopsDB->queryf($sql);
            break;

            case 'last'; 
              $sld_weight2 += 10;  
              $sql = "UPDATE {$tbl} SET sld_weight={$sld_weight2} WHERE sld_id={$sld_id}";
              $xoopsDB->queryf($sql);
              
              $sql = "SET @rank=0;";
              $xoopsDB->queryf($sql);
              
              $sql = "update {$tbl} SET sld_weight = (@rank:=@rank+10) ORDER BY sld_weight ASC;";
              $xoopsDB->queryf($sql);
            break;
            
         }

        //permet le rafraissement de la page d'accueil    
        deleteSliderthemeFlag($sld_theme);
        \redirect_header("slides.php?op=list&sld_theme={$select_theme}", 0, "");
        break;
        
    case 'update_periodicity'; 
        sld_updatePeriodicity($msg);
        \redirect_header("slides.php?op=list&sld_theme={$select_theme}", 3, $msg);
        break;

    case 'purger_sliders_folder':
        $imgDeleted = \purgerSliderFolder(1);
        $msg = ($imgDeleted == 0) ? _AM_SLIDER_IMG_DELETED_0: sprintf(_AM_SLIDER_IMG_DELETED_1, $imgDeleted);
        \redirect_header("slides.php?op=list&sld_theme={$select_theme}", 3, $msg);
        break;

}
require __DIR__ . '/footer.php';

