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

//echo "<hr>Post : <pre>" . print_r($_POST, true ). "</pre><hr>";

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
//        $slidesObj->setVar('sld_short_name', Request::getString('sld_short_name', ''));
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
        $themeArr = Request::getArray('sld_themeArr', array());
        
        if(count($themeArr)>0){
            sort($themeArr);
            $slidesObj->setVar('sld_theme','|' .  implode('|', $themeArr) . '|');
        }else{
            $slidesObj->setVar('sld_theme','');
        }
// echo "<hr>sld_themeArr : <pre>" . print_r($themeArr, true ). "</pre><hr>";
// echo '|' .  implode('|', Request::getArray('sld_themeArr', '')) . '|' . "<br>";        
        $slidesObj->setVar('sld_button_title', Request::getString('sld_button_title', ''));
        
        $slidesObj->setVar('sld_style_title', Request::getText('sld_style_title'));
        $slidesObj->setVar('sld_style_subtitle', Request::getText('sld_style_subtitle'));
        $slidesObj->setVar('sld_style_button', Request::getText('sld_style_button'));
        
        $slidesObj->setVar('sld_style_id_title',    Request::getText('sld_style_id_title'));
        $slidesObj->setVar('sld_style_id_subtitle', Request::getText('sld_style_id_subtitle'));
        $slidesObj->setVar('sld_style_id_button',   Request::getText('sld_style_id_button'));
        
        //-------------------------------------------------------
        // Set Var sld_image
//        $theme = Request::getString('sld_theme', '');
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
              
              //si le nom n'est pas renseigné on prend le nom du fichier image
              $shortName = Request::getString('sld_short_name', '');
              if($shortName == '') {
                if ($filename == '') $filename = Request::getString('sld_image', '');
                $posExt = strrpos($filename, '.');
                $shortName = substr($filename, 0, $posExt);
                $shortName = str_replace("_", " ", $shortName);
                $slidesObj->setVar('sld_short_name', $shortName);
              }else{
                $slidesObj->setVar('sld_short_name', $shortName);                
              }

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
                          //$endFile = "{$theme}-{$savedFilename}" ;
                          
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
        //exit("paramsList = {$paramsList}");
        // Insert Data
        if ($bolOk) {
            if ('' !== $uploaderErrors) {
                foreach($themeArr AS $k=>$theme){
                  if ($themesHandler->isActif($theme)){
                      generer_new_tpl_slider($theme);
                  }
                }
                //\force_rebuild_slider();
                \redirect_header("slides.php?op=edit&sld_id={$sldId}&{$paramsList}" , 5, $uploaderErrors);
            } else {
                \redirect_header("slides.php?op=list&{$paramsList}", 2, _AM_SLIDER_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $slidesObj->getHtmlErrors());
        $form = $slidesObj->getFormSlides($theme);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
