<?php

namespace XoopsModules\Slider;

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

\defined('XOOPS_ROOT_PATH') || die('Restricted access');
xoops_load('XoopsLists', 'core');
//echo "<hr><pre>" . print_r(get_declared_classes(), true) . "</pre><hr>";

/**
 * Class Object Slides
 */
class Slides extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('sld_id', XOBJ_DTYPE_INT);
        $this->initVar('sld_short_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('sld_title', XOBJ_DTYPE_OTHER);
        $this->initVar('sld_subtitle', XOBJ_DTYPE_OTHER);
        $this->initVar('sld_button_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('sld_read_more', XOBJ_DTYPE_TXTBOX);
        $this->initVar('sld_weight', XOBJ_DTYPE_INT);
        $this->initVar('sld_date_begin', XOBJ_DTYPE_INT);
        $this->initVar('sld_date_end', XOBJ_DTYPE_INT);
        $this->initVar('sld_actif', XOBJ_DTYPE_INT);
        $this->initVar('sld_periodicity', XOBJ_DTYPE_INT);
        $this->initVar('sld_theme', XOBJ_DTYPE_TXTBOX);
        $this->initVar('sld_image', XOBJ_DTYPE_TXTBOX);
        $this->initVar('sld_style_title', XOBJ_DTYPE_OTHER);
        $this->initVar('sld_style_subtitle', XOBJ_DTYPE_OTHER);
        $this->initVar('sld_style_button', XOBJ_DTYPE_OTHER);
        $this->initVar('sld_style_id_title', XOBJ_DTYPE_INT);
        $this->initVar('sld_style_id_subtitle', XOBJ_DTYPE_INT);
        $this->initVar('sld_style_id_button', XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     * @return inserted id
     */
    public function getNewInsertedIdSlides()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormSlides($SelectedTheme, $action = false)
    {
        global $stylesHandler;
        
        $helper  = \XoopsModules\Slider\Helper::getInstance();
        $utility = new \XoopsModules\Slider\Utility();
        $allStyles = $stylesHandler->getListKeyName(true);
        
        $isNew = $this->isNew();
        $helper = \XoopsModules\Slider\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        // Title
        $title = $this->isNew() ? \sprintf(_AM_SLIDER_SLIDE_ADD) : \sprintf(_AM_SLIDER_SLIDE_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        
       
        // ********** Image **************
        // Form Image sldImage
        // Form Image sldImage: Select Uploaded Image 
        //$getSldImage = trim($this->getVar('sld_image'));
        
        $slideImg = $this->getVar('sld_image');
        $fulName = SLIDER_UPLOAD_IMAGE_PATH. "/slides/" . $slideImg;
        if (is_null($slideImg) || $slideImg=='' || !is_readable($fulName)) {
          $urlImg = XOOPS_URL . "/modules/slider/assets/images/slide-temp-01.png";
        }else{
          $urlImg = SLIDER_UPLOAD_IMAGE_URL . "/slides/" . $slideImg;
        }
        $img = new \XoopsFormLabel('', "<br><img src='{$urlImg}'  name='image_img2' id='image_img2' alt='' style='max-width:60%'>");
        
        //choix d'une image existante:
        $dirname = XOOPS_ROOT_PATH . '/uploads/slider/images/slides';
        $listImg = sld_getFilePrefixedBy($dirname, array('jpg','png','gif'), '', true);
        if(count($listImg) > 1){
            $inpImg= new \XoopsFormSelect(_AM_SLIDER_IMG_UPLODED, 'sld_image', $slideImg);   
            $inpImg->addOptionArray($listImg);   
        }

        //Selection d'un image locale dans l'explorateur
        $upload_size = $helper->getConfig('maxsize_image'); 
        $inpLoadImg = new \XoopsFormFile(_AM_SLIDER_SLIDE_TO_LOAD, 'sld_image', $upload_size);
/*
*/        

        //creation du groupe 'traiImg)'
        $imageTray  = new \XoopsFormElementTray(_AM_SLIDER_SLIDE,"<br>"); 
        $imageTray->setDescription(_AM_SLIDER_SLIDE_IMG_DESC . '<br>' . sprintf(_AM_SLIDER_UPLOADSIZE, $upload_size / 1024), '<br>');
        
        
        $imageTray->addElement($inpLoadImg, false);
        if(count($listImg) > 1) $imageTray->addElement($inpImg, false);
        $imageTray->addElement($img, false);
        
        
//        $urlImg =  SLIDER_UPLOAD_IMAGE_URL . '/slides/' . $getSldImage;        
        //$uploadirectory      = XOOPS_ROOT_PATH . "/uploads/slider";        
        
        
        //$imageTray->addElement($img); 
//echo "{$urlImg}<br>"; 
        

        $form->addElement($imageTray, true); 
        
        // Form Text sld_short_name
        $inpShortName = new \XoopsFormText(_AM_SLIDER_SLIDE_SHORT_NAME, 'sld_short_name', 50, 255, $this->getVar('sld_short_name'));
        $inpShortName->setDescription(_AM_SLIDER_SLIDE_SHORT_NAME_DESC);
        $form->addElement($inpShortName, false);
        
        
        
        $stylTA = "style='width:400px;'";  
        $nbLinesTA = 5;     
        //--------------------------------------------------------------------------------
        $form->insertBreak("<tr><th colspan='2'>" . _AM_SLIDER_TITLE . "</th><tr>");
    //$form->insertBreak("<div class='outer'>zzz</div>");
        
        // Form Text sldTitle
        // Form Editor DhtmlTextArea sldDescription
        $editorConfigs = [];
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        
        $editorConfigs['name'] = 'sld_subtitle';
        $editorConfigs['value'] = $this->getVar('sld_title', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '60%';
        $editorConfigs['height'] = '200px';
        $editorConfigs['editor'] = $editor;
        $inputTitle = new \XoopsFormEditor(_AM_SLIDER_SLIDE_TITLE, 'sld_title', $editorConfigs);
        $inputTitle->setDescription(_AM_SLIDER_SLIDE_TITLE_DESC);
        $form->addElement($inputTitle);

        //------------ STYLES -------------------------------
        $styleIdTitle = ($isNew) ? 1 : $this->getVar('sld_style_id_title');
        $inpStyleIdTitle = new \XoopsFormSelect('', 'sld_style_id_title', $styleIdTitle);   
        $inpStyleIdTitle->addoptionArray($allStyles);
        
        //$css = ($isNew) ? $helper->getConfig('slider_style_title') : $this->getVar('sld_style_title', 'e');
        $inputStyleTxtTitle = new \XoopsFormTextArea('', 'sld_style_title', $this->getVar('sld_style_title', 'e'), $nbLinesTA, 60);
        $inputStyleTxtTitle->setExtra($stylTA);
        
        $inpTrayStyleTitle = new \XoopsFormElementTray(_AM_SLIDER_STYLE_TITLE, '<br>');  
        $inpTrayStyleTitle->setDescription(_AM_SLIDER_SLIDE_STYLE_DESC);
        $inpTrayStyleTitle->addElement($inpStyleIdTitle);
        $inpTrayStyleTitle->addElement($inputStyleTxtTitle);
        $form->addElement($inpTrayStyleTitle);        
/* projet d'ajout du css a partir de fichier, à voi !!!!
        $dirname = XOOPS_ROOT_PATH . "/modules/slider/css";
        $extensions = array("css","txt");
        $cssTitles =  \XoopsLists::getFileListByExtension($dirname, $extensions, $prefix = '');       
        $sldCssTitleSelect = new \XoopsFormSelect("zzzzzzz", 'sld_css_title', $cssTitles);   
        $sldCssTitleSelect->setDescription(_AM_SLIDER_SLIDE_SELECT_THEME_DESC);        
        $sldCssTitleSelect->addOptionArray($cssTitles);   
        $form->addElement($sldCssTitleSelect);
*/        
         
        //--------------------------------------------------------------------------------
        $form->insertBreak("<tr><th colspan='2'>" . _AM_SLIDER_SUBTITLE . "</th><tr>");
        
        $editorConfigs2 = [];
        $editorConfigs2['name'] = 'sld_subtitle';
        $editorConfigs2['value'] = $this->getVar('sld_subtitle', 'e');
        $editorConfigs2['rows'] = 5;
        $editorConfigs2['cols'] = 40;
        $editorConfigs2['width'] = '60%';
        $editorConfigs2['height'] = '200px';
        $editorConfigs2['editor'] = $editor;
        $inputSubtitle = new \XoopsFormEditor(_AM_SLIDER_SUBTITLE, 'sld_subtitle', $editorConfigs2);
        $inputSubtitle->setDescription(_AM_SLIDER_SUBTITLE_DESC);
        $form->addElement($inputSubtitle);
        
        //------------ STYLES -------------------------------
        $styleIdSubtitle = ($isNew) ? 2 : $this->getVar('sld_style_id_subtitle');
        $inpStyleIdSubitle = new \XoopsFormSelect('', 'sld_style_id_subtitle', $styleIdSubtitle);   
        $inpStyleIdSubitle->addoptionArray($allStyles);
        
        $inputStyleTxtSubtitle = new \XoopsFormTextArea('', 'sld_style_subtitle',  $this->getVar('sld_style_subtitle', 'e'), $nbLinesTA, 60);
        $inputStyleTxtSubtitle->setExtra($stylTA);
        
        $inpTrayStyleSubitle = new \XoopsFormElementTray(_AM_SLIDER_STYLE_SUBTITLE, '<br>');  
        $inpTrayStyleSubitle->setDescription(_AM_SLIDER_SLIDE_STYLE_DESC);
        $inpTrayStyleSubitle->addElement($inpStyleIdSubitle);
        $inpTrayStyleSubitle->addElement($inputStyleTxtSubtitle);
        $form->addElement($inpTrayStyleSubitle);        

        //--------------------------------------------------------------------------------
        $form->insertBreak("<tr><th colspan='2'>" . _AM_SLIDER_BUTTON . "</th><tr>");
        
        // Form Text sld_button_title
        $inpurReadMore = new \XoopsFormText(_AM_SLIDER_SLIDE_BUTTON_CAPTION, 'sld_button_title', 80, 255, $this->getVar('sld_button_title'));
        $inpurReadMore->setDescription(_AM_SLIDER_SLIDE_BUTTON_CAPTION_DESC);
        $form->addElement($inpurReadMore, false);
        
        // Form Text sld_read_more
        $inpurReadMore = new \XoopsFormText(_AM_SLIDER_BUTTON_URL, 'sld_read_more', 80, 255, $this->getVar('sld_read_more'));
        $inpurReadMore->setDescription(_AM_SLIDER_SLIDE_READ_MORE_DESC);
        $form->addElement($inpurReadMore, false);
        
        //------------ STYLES -------------------------------
        $styleIdButton = ($isNew) ? 3 : $this->getVar('sld_style_id_button');
        $inpStyleIdButton = new \XoopsFormSelect('', 'sld_style_id_button', $styleIdButton);   
        $inpStyleIdButton->addoptionArray($allStyles);
        
        $inputSytleTxtButton = new \XoopsFormTextArea('', 'sld_style_button',  $this->getVar('sld_style_button', 'e'), $nbLinesTA, 60);
        $inputSytleTxtButton->setExtra($stylTA);
        
        $inpTrayStyleSubitle = new \XoopsFormElementTray(_AM_SLIDER_STYLE_BUTTON, '<br>');  
        $inpTrayStyleSubitle->setDescription(_AM_SLIDER_SLIDE_STYLE_DESC);
        $inpTrayStyleSubitle->addElement($inpStyleIdButton);
        $inpTrayStyleSubitle->addElement($inputSytleTxtButton);
        $form->addElement($inpTrayStyleSubitle);        


        //----------------------------------------------------        
        $form->insertBreak("<tr><th colspan='2'>" . _AM_SLIDER_OPTIONS. "</th><tr>");
        //        choix du themes
        global $xoopsConfig;
        if ($this->isNew()) {
            $themeARR = array($SelectedTheme);
        }else{
            $themeARR = explode('|', $this->getVar('sld_theme'));
            if($themeARR[0]=='') array_shift($themeARR);
            if($themeARR[count($themeARR)]=='') array_pop($themeARR);
            //if(count($themeARR)==0) $themeARR = array($SelectedTheme);
        }
//global $themesHandler;
$themesHandler = $helper->getHandler('Themes');
//         $sldThemeSelect = new \XoopsFormSelect(_AM_SLIDER_SLIDE_SELECT_THEME, 'sld_theme', $theme);   
//         $sldThemeSelect->setDescription(_AM_SLIDER_SLIDE_SELECT_THEME_DESC);        
//         $sldThemeSelect->addOptionArray($themesHandler->getThemesAllowed(true));   
//         $form->addElement($sldThemeSelect);


        $sldThemeSelect = new \XoopsFormSelect(_AM_SLIDER_SLIDE_SELECT_THEME, 'sld_themeArr', $themeARR,5,true); 
        $sldThemeSelect->setDescription(_AM_SLIDER_SLIDE_SELECT_THEME_DESC);        
        $sldThemeSelect->setValue($themeARR);
        $sldThemeSelect->addOptionArray($themesHandler->getThemesAllowed(false));   
        $form->addElement($sldThemeSelect);
          
//echo "<hr>Themes : {$theme} - <pre>" . print_r($theme, true ). "</pre><hr>";        
    //public function __construct($caption, $name, $value = null, $size = 1, $multiple = false)
        //----------------------------------------------------        
/*
        $sldThemeSelect = new \XoopsFormSelect(_AM_SLIDER_THEME, 'sld_theme', $this->getVar('sld_theme'));
        $sldThemeSelect->addOption('', _NONE);
        $langArray = \XoopsLists::getLangList();
        $sldThemeSelect->addOptionArray($langArray);
*/  
        // Form Text sldWeight
        $sldWeight = $this->isNew() ? getWeightForNextSlide($SelectedTheme) : $this->getVar('sld_weight');
        
        $form->addElement(new \XoopsFormText(_AM_SLIDER_SLIDE_WEIGHT, 'sld_weight', 20, 150, $sldWeight));
        // Form Radio Yes/No sldActif
        $sldActif = $this->isNew() ?: $this->getVar('sld_actif');
        $sldInputActif = new \XoopsFormRadioYN(_AM_SLIDER_SLIDE_ACTIF, 'sld_actif', $sldActif);
        $sldInputActif->setdescription(_AM_SLIDER_SLIDE_ACTIF_DESC);
        $form->addElement($sldInputActif);
        // Form Radio Yes/No sldHasPeriode
        
//         $sldHasPeriode = $this->isNew() ? 0 : $this->getVar('sld_periodicity');
//         $sldHasPeriode = new \XoopsFormRadioYN(_AM_SLIDER_SLIDE_HAS_PERIODE, 'sld_periodicity', $sldHasPeriode);
//         $sldHasPeriode->setDescription(_AM_SLIDER_SLIDE_HAS_PERIODE_DESC);
//         $form->addElement($sldHasPeriode);
        
        
//         $periodicite = $this->isNew() ? 0 : $this->getVar('sld_periodicity');
//         $selPeriodicite = new \XoopsFormSelect(_AM_SLIDER_PERIODICITY, 'sld_periodicity', $periodicite);
//             $selPeriodicite->setDescription (_AM_SLIDER_PERIODICITY_DESC);
//             $selPeriodicite->addOption(Constants::PERIODICITY_ALWAYS,  _AM_SLIDER_PERIODICITE_ALWAYS);
//             $selPeriodicite->addOption(Constants::PERIODICITY_FLOAT,   _AM_SLIDER_PERIODICITE_FLOAT);
//             $selPeriodicite->addOption(Constants::PERIODICITY_WEEK,    _AM_SLIDER_PERIODICITE_WEEK);
//             $selPeriodicite->addOption(Constants::PERIODICITY_MONTH,   _AM_SLIDER_PERIODICITE_MONTH);
//             $selPeriodicite->addOption(Constants::PERIODICITY_QUATER,  _AM_SLIDER_PERIODICITE_QUATER);
//             $selPeriodicite->addOption(Constants::PERIODICITY_YEAR,    _AM_SLIDER_PERIODICITE_YEAR);
        //$form->addElement($selPeriodicite);
        $selPeriodicite = $utility->xoopsFormPeriodicite(_AM_SLIDER_PERIODICITY,'sld_periodicity',$this->getVar('sld_periodicity'),_AM_SLIDER_PERIODICITY_DESC);
        
        
        // Form Text Date Select sldDate_begin
        $sldDate_begin = $this->isNew() ? time() : $this->getVar('sld_date_begin');
        $inpDateBegin= new \XoopsFormDateTime(_AM_SLIDER_SLIDE_DATE_BEGIN, 'sld_date_begin', '', $sldDate_begin);
        //$form->addElement($inpDateBegin);
        // Form Text Date Select sldDate_end
        $sldDate_end = $this->isNew() ? time() : $this->getVar('sld_date_end');
        $sldDate_end = new \XoopsFormDateTime(_AM_SLIDER_SLIDE_DATE_END, 'sld_date_end', '', $sldDate_end);
        //$form->addElement($inpDateBegin);
/*
$perDate = new \XoopsFormElementTray('', '&nbsp;');  
$perDate->addElement($inpDateBegin);
$perDate->addElement($sldDate_end);
        $inpPeriod = new \XoopsFormElementTray(_AM_SLIDER_PERIODICITY, '<br>');   
        $inpPeriod->setDescription(_AM_SLIDER_PERIODICITY_DESC);
        $inpPeriod->addElement($selPeriodicite);
        $inpPeriod->addElement($perDate);
*/        

        
        $inpPeriod = new \XoopsFormElementTray(_AM_SLIDER_PERIODICITY, '<br>');   
        $inpPeriod->setDescription(_AM_SLIDER_PERIODICITY_DESC);
        $inpPeriod->addElement($selPeriodicite);
        $inpPeriod->addElement($inpDateBegin);
        $inpPeriod->addElement($sldDate_end);
        $form->addElement($inpPeriod);
        
            


        
//---------------------------------------------------        
        //--------------------------------------------------------------------------------
        $form->insertBreak("<tr><th colspan='2'>" . '' . "</th><tr>");

        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesSlides($keys = null, $format = null, $maxDepth = null)
    {
    global $stylesHandler;
        $helper  = \XoopsModules\Slider\Helper::getInstance();
        $utility = new \XoopsModules\Slider\Utility();
        //$ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']                 = $this->getVar('sld_id');
        $ret['short_name']         = $this->getVar('sld_short_name');
        $ret['title']              = $this->getVar('sld_title');
        $ret['subtitle']        = $this->getVar('sld_subtitle', 'e');
        //$editorMaxchar             = $helper->getConfig('editor_maxchar');
        $ret['read_more']          = $this->getVar('sld_read_more');
        $ret['short_name']         = $this->getVar('sld_short_name');
        $ret['weight']             = $this->getVar('sld_weight');
        $ret['date_begin']         = $this->getVar('sld_date_begin');
        $ret['date_end']           = $this->getVar('sld_date_end');
        $ret['str_date_begin']         = \formatTimestamp($this->getVar('sld_date_begin'), 'm');
        $ret['str_date_end']           = \formatTimestamp($this->getVar('sld_date_end'), 'm');
        $ret['actif']              = (int)$this->getVar('sld_actif');
        
        $ret['actif_yn']           = (int)$this->getVar('sld_actif') > 0 ? _YES : _NO;
        $ret['periodicity']        = (int)$this->getVar('sld_periodicity');
        $ret['periodicity_yn']     = (int)$this->getVar('sld_periodicity') > 0 ? _YES : _NO;
        $ret['theme']              = $this->getVar('sld_theme');
        $ret['image']              = trim($this->getVar('sld_image'));
        $fulName = SLIDER_UPLOAD_IMAGE_PATH. "/slides/" . $this->getVar('sld_image');
        if (is_null($ret['image']) || $ret['image']=='' || !is_readable($fulName)) {
          $ret['image_fullName']     = XOOPS_URL . "/modules/slider/assets/images/slide-temp-01.png";
        }else{
          $ret['image_fullName']     = SLIDER_UPLOAD_IMAGE_URL . "/slides/" . $this->getVar('sld_image') ;
        }
        
        $ret['button_title']             = $this->getVar('sld_button_title');
        
        $ret['style_title']     = $this->getVar('sld_style_title', 'e');
        $ret['style_subtitle']  = $this->getVar('sld_style_subtitle', 'e');
        $ret['style_button']    = $this->getVar('sld_style_button', 'e');
        
        $ret['style_id_title']     = $this->getVar('sld_style_id_title');
        $ret['style_id_subtitle']  = $this->getVar('sld_style_id_subtitle');
        $ret['style_id_button']    = $this->getVar('sld_style_id_button');
global $allStyles, $helper;
if (!isset($stylesHandler)) $stylesHandler = $helper->getHandler('Styles');


if (!isset($allStyles))
$allStyles = $stylesHandler->getAll(null,null,false);        
// echo "<hr>Styles :<pre><code>" . print_r($allStyles, true ). "</code></pre><hr>";       
// exit;
         $ret['style_title']    = ($ret['style_id_title'] == 0) ? ""    : str_replace("<br>","\n", $allStyles[$ret['style_id_title']]['sty_css']);
         $ret['style_subtitle'] = ($ret['style_id_subtitle'] == 0) ? "" : str_replace("<br>","\n", $allStyles[$ret['style_id_subtitle']]['sty_css']);
         $ret['style_button']   = ($ret['style_id_button'] == 0) ? ""   : str_replace("<br>","\n", $allStyles[$ret['style_id_button']]['sty_css']);
 
        $ret['style_title']     .= "\n" . $this->getVar('sld_style_title', 'e');
        $ret['style_subtitle']  .= "\n" . $this->getVar('sld_style_subtitle', 'e');
        $ret['style_button']    .= "\n" . $this->getVar('sld_style_button', 'e');
//echo "<hr>Slides :<pre>" . print_r($ret, true ). "</pre><hr>";      
//exit;  
        $ret['current_status'] = getCurrentStatusOfSlide($ret);
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArraySlides()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
