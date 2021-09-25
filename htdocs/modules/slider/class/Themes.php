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
 * Slides management module for xoops
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
 * Class Object Themes
 */
class Themes extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('theme_id', XOBJ_DTYPE_INT);
		$this->initVar('theme_folder', XOBJ_DTYPE_TXTBOX);
		$this->initVar('theme_random', XOBJ_DTYPE_TXTBOX);
		$this->initVar('theme_transition', XOBJ_DTYPE_INT);
        $this->initVar('theme_tpl_slider', XOBJ_DTYPE_TXTBOX);
        $this->initVar('theme_status', XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdThemes()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormThemes($action = false)
	{
		$helper = \XoopsModules\Slider\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Title
        $theme = $this->getVar('theme_folder');
        
        //$version = $this->getVar('theme_version');
        $themeIni = ThemesHandler::getThemesIni($theme);
        
	//	$title = $this->isNew() ? \sprintf(_AM_SLIDER_THEME_ADD) : \sprintf(_AM_SLIDER_THEME_EDIT);
		$title = \sprintf(_AM_SLIDER_THEME_EDIT, $theme) ;
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Text themeName

        
        $form->addElement(new \XoopsFormHidden('theme_folder', $theme));
        $form->addElement(new \XoopsFormLabel(_AM_SLIDER_FOLDER, $theme));
        $form->addElement(new \XoopsFormLabel(_AM_SLIDER_NAME, $themeIni['Name']));
        $form->addElement(new \XoopsFormLabel(_AM_SLIDER_THEME_VERSION, $themeIni['Version']));
        
        //$inpVersion = new \XoopsFormText(_AM_SLIDER_THEME_VERSION, 'theme_version', 50, 255, $version);
        //$inpVersion->setDescription(_AM_SLIDER_THEME_VERSION_DESC);
		//$form->addElement($inpVersion, true);
        
    		// Form Select tpl_slider
            $path = XOOPS_ROOT_PATH . "/modules/slider/templates/admin";
            //$listSldThemes = \XoopsLists::getFileListAsArray($path, "slider_theme_");
            $listSldThemes = sld_getFilePrefixedBy($path, array("tpl"), "slider_theme_");    
    		$inpSldTheme = new \XoopsFormSelect(_AM_SLIDER_THEME_TPL_SLIDER, 'theme_tpl_slider', $this->getVar('theme_tpl_slider'));
            $inpSldTheme->setDescription(_AM_SLIDER_THEME_TPL_SLIDER_DESC);
            $inpSldTheme->addOptionArray($listSldThemes);   
            $form->addElement($inpSldTheme);

        if( $this->isXwatch4E()){
            $listCss = $this->getCssList();        
            $themeCss = $this->getCurrentCss_xwatch4E(false);
            $inpCSS = new \XoopsFormSelect(_AM_SLIDER_THEME_WHITE_CSS, 'theme_whiteCss', $themeCss);   
            $inpCSS->setDescription(_AM_SLIDER_THEME_WHITE_CSS_DESC);        
            $inpCSS->addOptionArray($listCss);   
            $form->addElement($inpCSS);
            //-------------------------------------------------------------
            $listDarkCss = array('css-cyborg'      => 'css-cyborg',
                                 'css-darkly'      => 'css-darkly',
                                 'css-slate'       => 'css-slate',
                                 'css-solar'       => 'css-solar',
                                 'css-superhero'   => 'css-superhero');
             
            $themeDarkCss = $this->getCurrentCss_xwatch4E(true);
            $inpDarkCSS = new \XoopsFormSelect(_AM_SLIDER_THEME_DARK_CSS, 'theme_darkCss', $themeDarkCss);    
            $inpDarkCSS->setDescription(_AM_SLIDER_THEME_DARK_CSS_DESC);        
            $inpDarkCSS->addOptionArray($listDarkCss);   
            $form->addElement($inpDarkCSS);
                  

        }
        
    		// Form Select theme_transition
    		$inpTransition = new \XoopsFormSelect(_AM_SLIDER_theme_transition, 'theme_transition', $this->getVar('theme_transition'));
            $inpTransition->setDescription(_AM_SLIDER_THEME_TRANSITION_DESC);
    		$inpTransition->addOption(0, _AM_SLIDER_THEME_TRANSITION_HORIZONTAL);
    		$inpTransition->addOption(1, _AM_SLIDER_THEME_TRANSITION_VERTICAL);
    		$form->addElement($inpTransition);

//             //------------ STYLES mycss-------------------------------
//             $mycss = ($isNew) ? $helper->getConfig('slider_style_button') : $this->getVar('sld_style_button', 'e');
//             $inputSytleButton = new \XoopsFormTextArea(_AM_SLIDER_SLIDE_STYLE_BUTTON, 'sld_style_button',  $css, $nbLinesTA, 60);
//             $inputSytleButton->setExtra($stylTA);
//             $inputSytleButton->setDescription(_AM_SLIDER_SLIDE_STYLE_BUTTON_DESC);
//             $form->addElement($inputSytleButton);
		
        $form->addElement(getFormPeriodicity(_AM_SLIDER_THEME_RANDOM, 'theme_random', $this->getVar('theme_random'), '_AM_'));            
        

		// To Save
		$form->addElement(new \XoopsFormHidden('op', 'save'));
		$form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
		return $form;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormMyCss($action = false)
	{
		$helper = \XoopsModules\Slider\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Title
		$title = $this->isNew() ? \sprintf(_AM_SLIDER_THEME_ADD) : \sprintf(_AM_SLIDER_THEME_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Text themeName

        $theme = $this->getVar('theme_folder');
        $themeIni = ThemesHandler::getThemesIni($theme);

        
        $form->addElement(new \XoopsFormHidden('theme_folder', $theme));
        $form->addElement(new \XoopsFormLabel(_AM_SLIDER_NAME, $theme));
        $form->addElement(new \XoopsFormLabel(_AM_SLIDER_NAME, $themeIni['Name']));
        $form->addElement(new \XoopsFormLabel(_AM_SLIDER_THEME_VERSION, $themeIni['Version']));
        
        //------------ STYLES mycss-------------------------------
        $fullName = XOOPS_ROOT_PATH . "/themes/{$theme}/css/my_css.css";
        $mycss = sld_loadTextFile($fullName);

 $stylTA = "style='width:600px';";  
 $nbLinesTA = 25;     
        $inpMycss = new \XoopsFormTextArea(_AM_SLIDER_THEME_EDIT, 'theme_mycss',  $mycss, $nbLinesTA, 50);
        $inpMycss->setExtra($stylTA);
        $inpMycss->setDescription(_AM_SLIDER_THEME_EDIT_DESC);
        $form->addElement($inpMycss);

		// To Save
		$form->addElement(new \XoopsFormHidden('op', 'save_mycss'));
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
	public function getValuesThemes($keys = null, $format = null, $maxDepth = null)
	{global $slidesHandler;
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']           = $this->getVar('theme_id');
		$ret['folder']       = $this->getVar('theme_folder');
		$ret['tpl_slider']   = $this->getVar('theme_tpl_slider');
		$ret['transition']   = $this->getVar('theme_transition');
		//$ret['transition']   = $this->getTransition();
		$ret['transition_caption'] = ($ret['transition'] == 1) ? _AM_SLIDER_THEME_TRANSITION_VERTICAL : _AM_SLIDER_THEME_TRANSITION_HORIZONTAL ;
		$ret['random']       = $this->getVar('theme_random');
		$ret['random_caption'] = getPeriodicityCaption($ret['random'], '_AM_');
		
        //completion avec les optonis du fichier theme.ini
        //$path = XOOPS_ROOT_PATH . "/themes/{$theme}/template.ini";
        //$ini = ThemesHandler::getThemesIni($ret['folder'] );
		$ret['actif']      = $this->isActif();   //$this->getVar('theme_actif');//
        $ini = $this->getThemesIni();
		$ret['name']       = (isset($ini['Name'])) ? $ini['Name'] : '';
		$ret['version']    = (isset($ini['Version'])) ? $ini['Version'] : '';
		
		$ret['isSliderAllowed'] = $this-> is_slider_allowed();
        
		$ret['isXwatch4E']      = $this->isXwatch4E();
        if($ret['isXwatch4E']){
            $ret['css']       = $this->getCurrentCss_xwatch4E(false);
            $ret['darkCss']   = $this->getCurrentCss_xwatch4E(true);
        }else{
            $ret['css']       = '' ; //$this->getCurrentCss_xbootstrap();
            $ret['darkCss']   = '';
        }
if (!$slidesHandler){
    $helper = \XoopsModules\Slider\Helper::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
 }       
        $criteria = new \CriteriaCompo(new \Criteria("sld_theme", $ret['folder'], "="));
        $criteria->add(new \Criteria('sld_theme',  0, '=', '', "LENGTH(sld_theme)" ), 'OR');
            
		$ret['nbSlides']   = $slidesHandler->getCountSlides($criteria);
//echo "theme_ini : <hr><pre>" . print_r($ini, true ). "</pre><hr>";
// exit;       
        return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayThemes()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}

/* ////////////////////////////////////////////////////////// */
           
public function  isActif() {
    return ThemesHandler::isActif($this->getVar('theme_folder'));
} 

public function getThemesIni() {
    return ThemesHandler::getThemesIni($this->getVar('theme_folder'));
} 
//---------------------------------------------------

public function updateCss_xbootstrap($newCss) {
    return ThemesHandler::updateCss($this->getVar('theme_folder'), $newCss);
} 

public function  getCurrentCss_xbootstrap() {
//echo "getCurrentCss_xbootstrap = {$this->getVar('theme_folder')}<br>";
    return ThemesHandler::getCurrentCss_xbootstrap($this->getVar('theme_folder'));
} 
//---------------------------------------------------

public function  isXwatch4E() {
//echo "getCurrentCss = {$this->getVar('theme_folder')}<br>";
    return ThemesHandler::isXwatch4E($this->getVar('theme_folder'));
} 

public function  getCurrentCss_xwatch4E($darkCss = false) {
//echo "getCurrentCss = {$this->getVar('theme_folder')}<br>";
    return ThemesHandler::getCurrentCss_xwatch4E($this->getVar('theme_folder'), $darkCss);
} 
public function updateCss_xwatch4E($newCss, $darkCss = false) {
    return ThemesHandler::updateCss_xwatch4E($this->getVar('theme_folder'), $newCss, $darkCss);
} 
//---------------------------------------------------
           
public function  getCssList($prefix = 'css-') {
    return ThemesHandler::getCssList($this->getVar('theme_folder'), $prefix);
} 

public function  cleanAllCaches() {
    return ThemesHandler::cleanAllCaches($this->getVar('theme_folder'));
} 

public function  cleanCache($cache) {
    return ThemesHandler::cleanCache($this->getVar('theme_folder'), $cache);
} 

public function  getTransition() {
    return ThemesHandler::getTransition($this->getVar('theme_folder'));
} 






public function is_slider_allowed()
{
    return ThemesHandler::is_slider_allowed($this->getVar('theme_folder'));
}

public function set_allowed_slider($enabled = true)
{
    return ThemesHandler::set_allowed_slider($this->getVar('theme_folder'), $enabled);
}
    


} // ----- FIN DE LA CLASSE -----
