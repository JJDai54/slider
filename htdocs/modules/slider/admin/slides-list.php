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

//echo "===>select_theme = {$select_theme}";
        //-----------------------------------------------------
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'slider_admin_slides.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('slides.php'));
        $adminObject->addItemButton(_AM_SLIDER_ADD_SLIDE, "slides.php?op=new&inpTheme={$inpTheme}", 'add');
        $adminObject->addItemButton(_AM_SLIDER_UPDATE_PERIODICITY, "slides.php?op=update_periodicity&inpTheme={$inpTheme}", 'update');
        
        $imgDeleted = \purgerSliderFolder(0);
        if($imgDeleted > 0){
          $caption = sprintf(_AM_SLIDER_PURGER_SLIDES, $imgDeleted);
          $adminObject->addItemButton($caption, "slides.php?op=purger_sliders_folder&select_theme={$inpTheme}", 'update');
        }
        
                
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        
        $criteria = $slidesHandler->getAdminlistCriteria($inpTheme, $inpPeriodicity, $inpActif);
        /*
        $criteria = new \CriteriaCompo();
        //$criteria->add(new \Criteria('sld_theme', $inpTheme, '='));
        if($inpTheme != ''){
            $criteria->add(new \Criteria('sld_theme', "%|{$inpTheme}|%", 'LIKE'));
        }
        
        if($inpPeriodicity != 0) $criteria->add(new \Criteria('sld_periodicity', $inpPeriodicity, "="));
        
        if($inpActif == 0 || $inpActif == 1) {
            $criteria->add(new \Criteria('sld_actif', $inpActif, "="));
        }elseif($inpActif == 2){
            $criteria->add(getCriteriaOFCurrentStatus(), "AND");
            
        }
        */
        //$criteria->add(new \Criteria('length(sld_theme)','0','=', 'OR'));
        //$criteria->add(new \Criteria('sld_theme', '','=', 'OR'));
        
        //$criteria->add(new Criteria('sld_theme',  0, '=', '', "LENGTH(sld_theme)" ), 'OR');
   // public function __construct($column, $value = '', $operator = '=', $prefix = '', $function = '')
        //$GLOBALS['xoopsTpl']->assign('params', $params);
        $GLOBALS['xoopsTpl']->assign('paramsList', $paramsList);
            
        $slidesCount = $slidesHandler->getCountSlides($criteria);
        $slidesAll = $slidesHandler->getAllSlides($criteria, $start, $limit,'sld_weight ASC, sld_theme ASC, sld_short_name');
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

        $xfTheme = new \XoopsFormSelect(_AM_SLIDER_SLIDE_SELECT_THEME, 'inpTheme', $inpTheme);   
        $xfTheme->setDescription(_AM_SLIDER_SLIDE_SELECT_THEME_DESC);        
        $xfTheme->addOptionArray($themesHandler->getThemesAllowed(true));   
        $xfTheme->setExtra("onChange=\"document.theme_form.submit()\"");
        $GLOBALS['xoopsTpl']->assign('xfTheme', $xfTheme->render());
        

        //$GLOBALS['xoopsTpl']->assign('select_theme', $inpTheme);
        $GLOBALS['xoopsTpl']->assign('current_DateTime', \formatTimestamp(time(), 'm'));

        $xfPeriodicity = Utility::xoopsFormPeriodicite('Filtre', 'inpPeriodicity',$inpPeriodicity,null, "onChange=\"document.theme_form.submit()\"", true);        
        $GLOBALS['xoopsTpl']->assign('xfPeriodicity', $xfPeriodicity->render());
        
        $xfActif = Utility::xoopsFormActif('Filtre', 'inpActif',$inpActif,null, "onChange=\"document.theme_form.submit()\"", true);        
        $GLOBALS['xoopsTpl']->assign('xfActif', $xfActif->render());
