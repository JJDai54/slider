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

use XoopsModules\Slider;
use XoopsModules\Slider\Helper;
use XoopsModules\Slider\Constants;

include_once XOOPS_ROOT_PATH . '/modules/slider/include/common.php';

/**
 * Function show block
 * @param  $options
 * @return array
 */
function b_slider_update_theme_show($options)
{
global $xoopsConfig;
    $block = array();
// echo "<hr><pre>" . print_r($xoopsConfig, true ). "</pre><hr>";

    include_once XOOPS_ROOT_PATH . '/modules/slider/class/Slides.php';
    $myts = MyTextSanitizer::getInstance();

    $helper      = Helper::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
    
    //recupe du theme actif
    $theme = $xoopsConfig['theme_set'];
                
    // selection des slides actifs
    $now = time();
    
    
//     $crSlides->add(new \Criteria('sld_date_end', \DateTime::createFromFormat(_SHORTDATESTRING), '>='));
//     $crSlides->add(new \Criteria('sld_date_begin', \DateTime::createFromFormat(_SHORTDATESTRING) + 86400, '<='));
    
    $crSlidesTheme = new \CriteriaCompo();    
    $crSlidesTheme->add(new \Criteria('sld_theme', $theme, '='));
    $crSlidesTheme->add(new \Criteria('sld_actif', 1, '='));
    
    $crSlidesActif = new \CriteriaCompo();
    $crSlidesActif->add(new \Criteria('sld_always_visible', 1, '='));
    
     $crSlidesperiode = new \CriteriaCompo();    
    $crSlidesperiode->add(new \Criteria('sld_date_end', $now, '>='));
    $crSlidesperiode->add(new \Criteria('sld_date_begin', $now, '<='));
    //$crSlidesperiode->add(new \Criteria('sld_date_begin', $now + 86400, '<='));
   
    $crSlidesAP = new \CriteriaCompo();    
    $crSlidesAP->add($crSlidesActif);    
    $crSlidesAP->add($crSlidesperiode, "OR");    
    
    $crSlides0 = new \CriteriaCompo();    
    $crSlides0->add($crSlidesTheme);    
    $crSlides0->add($crSlidesAP, "AND");    
    $crSlides0->setSort('sld_weight,sld_title');
    $crSlides0->setOrder('ASC');

    $slidesAll = $slidesHandler->getAll($crSlides0);
    unset($crSlides);
    $slides = array();
    $Slide_Ids = [];
    if (\count($slidesAll) > 0) {
        foreach (\array_keys($slidesAll) as $i) {
            $slides[$i]['title'] = $myts->htmlSpecialChars($slidesAll[$i]->getVar('sld_title'));
            //$slides[$i]['description'] = \strip_tags($slidesAll[$i]->getVar('sld_description'));
            $slides[$i]['description'] = $slidesAll[$i]->getVar('sld_description');
            $slides[$i]['weight'] = $myts->htmlSpecialChars($slidesAll[$i]->getVar('sld_weight'));
//             $slides[$i]['date_begin'] = $slidesAll[$i]->getVar('sld_date_begin');
//             $slides[$i]['date_end'] = $slidesAll[$i]->getVar('sld_date_end');
            $slides[$i]['date_begin']  = \formatTimestamp($slidesAll[$i]->getVar('sld_date_begin'), 'm');
            $slides[$i]['date_end']    = \formatTimestamp($slidesAll[$i]->getVar('sld_date_end'), 'm');
            
            $slides[$i]['actif'] = $slidesAll[$i]->getVar('sld_actif');
            $slides[$i]['always_visible'] = $slidesAll[$i]->getVar('sld_always_visible');
            $slides[$i]['theme'] = $slidesAll[$i]->getVar('sld_theme');
            $slides[$i]['image'] = $slidesAll[$i]->getVar('sld_image');
            $slides[$i]['image_fullName'] = XOOPS_URL . "/uploads/slider/images/slides/" . $slidesAll[$i]->getVar('sld_image');
            
            $Slide_Ids[$slidesAll[$i]->getVar('sld_id')] = $slidesAll[$i]->getVar('sld_id');

        }
    }
    
    
        
    //--------------------------------------------------------------
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    //echo "<hrt><pre>" . print_r($options, true) . "</pre><hr>";
    $block['hide'] = ($options[0]==0) ? 1 : 0;
    $block['slides'] = $slides;    
    
    
    //--------------------------------------------------------------
    sort($Slide_Ids);
    $fFlag = XOOPS_ROOT_PATH . "/uploads/slider/images/slides/" . $theme . ".txt";
    $oldflag = slider_loadTextFile($fFlag);
    $newFlag = implode("|", $Slide_Ids);
    if ($newFlag != $oldflag){
        saveTexte2File($fFlag, $newFlag);
        build_new_tpl($slides, $theme);
        $block['generation'] = _MB_SLIDER_TPL_OK;
    }else{
        $block['generation'] = _MB_SLIDER_TPL_NOT_OK;
    }
   
    $block['now'] = sprintf(_MB_SLIDER_TPL_HEURE_COURANTE, date("Y-m-d H:i:s", $now));    
    return $block;

}

/**
 * Function edit block
 * @param  $options
 * @return string
 */
function b_slider_update_theme_edit($options)
{

    include_once XOOPS_ROOT_PATH . '/modules/slider/class/slides.php';
    $helper = Helper::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    
    
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $showBlock = (isset($options[0])) ? $options[0]: 0; 
        $radShowBlock = new \XoopsFormRadioYN(_BL_SLIDER_SHOW_BLOCK, 'options[0]', $showBlock);
        $radShowBlock->SetDescription(_BL_SLIDER_SHOW_BLOCK_DESC);
        $form->addElement($radShowBlock);
        
        
    return $form->render();


}

/**********************************************************************
 * 
 **********************************************************************/
function build_new_tpl($slides, $theme){
//     $block['msg'] = "Mise à jour des slides du theme";
//     $block['theme'] = $xoopsConfig['theme_set'];
    $fullName = XOOPS_ROOT_PATH . "/themes/" . $theme. '/tpl/slider.tpl';
    $fullName_old = str_replace(".tpl","-old.tpl",$fullName);   
    //echo "<hr>===>{$fullName}<br>===>{$fullName_old}<hr>";
    if (!is_readable($fullName_old)){
        rename($fullName, $fullName_old);
    }
    //---------------------------------------------------

            
    $tpl = new \XoopsTpl();
    $tpl->assign('slides', $slides);

//$template = XOOPS_ROOT_PATH . "/modules/slider/templates/admin/slider_slider.tpl";
//    $content = $tpl->fetch($template);
    $template = 'db:slider_slider.tpl';

    $content = '<{if $xoops_page == "index"}>' ."\n"
             . $tpl->fetch($template)
             . "\n" . '<{/if}>' ."\n";
 

    

//    echo "<hr><pre>{$content}</pre><hr>";
    //$content = "togodo";
    saveTexte2File($fullName, $content, $mod = 0777);
    cleanThemeCache($theme, 'smarty_cache');
    cleanThemeCache($theme, 'smarty_compile');
            
    return true;        
}

/**********************************************************************
 * 
 **********************************************************************/
function saveTexte2File($fullName, $content, $mod = 0777){
  $fullName = str_replace('//', '/', $fullName);  
  
  //echo "\n<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>\n";
  //buildPath(dirname($fullName));
  
  
      $fp = fopen ($fullName, "w");  
      fwrite ($fp, $content);
      fclose ($fp);
      if ($mod <> 0000) {
        //echo "<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>";
        chmod($fullName, $mod);
      }
  
  
/*
  if (isFolder(dirname($fullName), true)){
      if (file_exists($fullName)){
        chmod($fullName, 0777);
      }
      
      $fp = fopen ($fullName, "w");  
      fwrite ($fp, $content);
      fclose ($fp);
      if ($mod <> 0000) {
        //echo "<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>";
        chmod($fullName, $mod);
      }
    }else{
      return false;
    }
*/  
  

}

/**********************************************************************
 * 
 **********************************************************************/
function slider_loadTextFile ($fullName){


  if (!is_readable($fullName)){return '';}
  
  $fp = fopen($fullName,'rb');
  $taille = filesize($fullName);
  $content = fread($fp, $taille);
  fclose($fp);
  
  return $content;

}
