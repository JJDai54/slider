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
        $this->initVar('sld_description', XOBJ_DTYPE_OTHER);
        $this->initVar('sld_weight', XOBJ_DTYPE_INT);
        $this->initVar('sld_date_begin', XOBJ_DTYPE_INT);
        $this->initVar('sld_date_end', XOBJ_DTYPE_INT);
        $this->initVar('sld_actif', XOBJ_DTYPE_INT);
        $this->initVar('sld_always_visible', XOBJ_DTYPE_INT);
        $this->initVar('sld_theme', XOBJ_DTYPE_TXTBOX);
        $this->initVar('sld_image', XOBJ_DTYPE_TXTBOX);
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
        
        
        // Form Text sld_short_name
        $form->addElement(new \XoopsFormText(_AM_SLIDER_SLIDE_SHORT_NAME, 'sld_short_name', 50, 255, $this->getVar('sld_short_name')), true);
        
        
        
        // Form Text sldTitle
        // Form Editor DhtmlTextArea sldDescription
        $editorConfigs = [];
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        $editorConfigs['name'] = 'sld_description';
        $editorConfigs['value'] = $this->getVar('sld_description', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '60%';
        $editorConfigs['height'] = '200px';
        $editorConfigs['editor'] = $editor;
        
        
        
        $form->addElement(new \XoopsFormEditor(_AM_SLIDER_SLIDE_TITLE, 'sld_title', $editorConfigs));
        $form->addElement(new \XoopsFormEditor(_AM_SLIDER_SLIDE_DESCRIPTION, 'sld_description', $editorConfigs));
        
        // Form Image sldImage
        // Form Image sldImage: Select Uploaded Image 
        
        // Form Image sldImage
        // Form Image sldImage: Select Uploaded Image 
        $getSldImage = $this->getVar('sld_image');
        $urlImg =  SLIDER_UPLOAD_IMAGE_URL . '/slides/' . $getSldImage;        
        //$uploadirectory      = XOOPS_ROOT_PATH . "/uploads/slider";        
$upload_size = $helper->getConfig('maxsize_image'); 

        $imageTray  = new \XoopsFormElementTray(_AM_SLIDER_SLIDE . '<br><br>' . sprintf(_AM_SLIDER_UPLOADSIZE, $upload_size / 1024), '<br>'); 
        $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='{$urlImg}'  name='image_img2' id='image_img2' alt='' style='max-width:60%'>")); 
//echo "{$urlImg}<br>"; 
        $imageTray->addElement(new \XoopsFormFile(_AM_SLIDER_SLIDE_TO_LOAD, 'sld_image', $upload_size), false);
        
        $form->addElement($imageTray, true);
        
        
        
         // Form Select Lang sldTheme
        //-JJDai
        global $xoopsConfig;
        //$theme = ($this->getVar('sld_theme') != '') ? $this->getVar('sld_theme') : $xoopsConfig['theme_set'];
        $theme = ($this->getVar('sld_theme') != '') ? $this->getVar('sld_theme') : $SelectedTheme;
        
        $sldThemeSelect = new \XoopsFormSelectTheme(_AM_SLIDER_SLIDE_SELECT_THEME, 'sld_theme', $theme);        
        $sldThemeSelect->setDescription(_AM_SLIDER_SLIDE_SELECT_THEME_DESC);        
        $form->addElement($sldThemeSelect);
/*
        $sldThemeSelect = new \XoopsFormSelect(_AM_SLIDER_THEME, 'sld_theme', $this->getVar('sld_theme'));
        $sldThemeSelect->addOption('', _NONE);
        $langArray = \XoopsLists::getLangList();
        $sldThemeSelect->addOptionArray($langArray);
*/  
        // Form Text sldWeight
        $sldWeight = $this->isNew() ? getWeightForNextSlide($theme) : $this->getVar('sld_weight');
        
        $form->addElement(new \XoopsFormText(_AM_SLIDER_SLIDE_WEIGHT, 'sld_weight', 20, 150, $sldWeight));
        // Form Radio Yes/No sldActif
        $sldActif = $this->isNew() ?: $this->getVar('sld_actif');
        $sldInputActif = new \XoopsFormRadioYN(_AM_SLIDER_SLIDE_ACTIF, 'sld_actif', $sldActif);
        $sldInputActif->setdescription(_AM_SLIDER_SLIDE_ACTIF_DESC);
        $form->addElement($sldInputActif);
        // Form Radio Yes/No sldAlwaysActif
        $sldAlwaysVisible = $this->isNew() ?: $this->getVar('sld_always_visible');
        $sldinputAlwaysVisible = new \XoopsFormRadioYN(_AM_SLIDER_SLIDE_ALWAYS_VISIBLE, 'sld_always_visible', $sldAlwaysVisible);
        $sldinputAlwaysVisible->setDescription(_AM_SLIDER_SLIDE_ALWAYS_VISIBLE_DESC);
        $form->addElement($sldinputAlwaysVisible);
        // Form Text Date Select sldDate_begin
        $sldDate_begin = $this->isNew() ? time() : $this->getVar('sld_date_begin');
        $form->addElement(new \XoopsFormDateTime(_AM_SLIDER_SLIDE_DATE_BEGIN, 'sld_date_begin', '', $sldDate_begin));
        // Form Text Date Select sldDate_end
        $sldDate_end = $this->isNew() ? time() : $this->getVar('sld_date_end');
        $form->addElement(new \XoopsFormDateTime(_AM_SLIDER_SLIDE_DATE_END, 'sld_date_end', '', $sldDate_end));
        
        
        

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
        $helper  = \XoopsModules\Slider\Helper::getInstance();
        $utility = new \XoopsModules\Slider\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']                 = $this->getVar('sld_id');
        $ret['short_name']         = $this->getVar('sld_short_name');
        $ret['title']              = $this->getVar('sld_title');
        $ret['description']        = $this->getVar('sld_description', 'e');
        $editorMaxchar             = $helper->getConfig('editor_maxchar');
        $ret['description_short']  = $utility::truncateHtml($ret['description'], $editorMaxchar);
        $ret['weight']             = $this->getVar('sld_weight');
        $ret['date_begin']         = \formatTimestamp($this->getVar('sld_date_begin'), 'm');
        $ret['date_end']           = \formatTimestamp($this->getVar('sld_date_end'), 'm');
        $ret['sld_actif']          = (int)$this->getVar('sld_actif');
        $ret['actif']              = (int)$this->getVar('sld_actif') > 0 ? _YES : _NO;
        $ret['sld_always_visible'] = (int)$this->getVar('sld_always_visible');
        $ret['always_visible']     = (int)$this->getVar('sld_always_visible') > 0 ? _YES : _NO;
        $ret['theme']              = $this->getVar('sld_theme');
        $ret['image']              = $this->getVar('sld_image');
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
