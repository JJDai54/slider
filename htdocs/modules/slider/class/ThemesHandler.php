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


/**
 * Class Object Handler Themes
 */
class ThemesHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'slider_themes', Themes::class, 'theme_id', 'theme_folder');
	}

	/**
	 * @param bool $isNew
	 *
	 * @return object
	 */
	public function create($isNew = true)
	{
		return parent::create($isNew);
	}

	/**
	 * retrieve a field
	 *
	 * @param int $i field id
	 * @param null fields
	 * @return mixed reference to the {@link Get} object
	 */
	public function get($i = null, $fields = null)
	{
		return parent::get($i, $fields);
	}

	/**
	 * get inserted id
	 *
	 * @param null
	 * @return int reference to the {@link Get} object
	 */
	public function getInsertId()
	{
		return $this->db->getInsertId();
	}

	/**
	 * Get Count Themes in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountThemes($criteria = null, $start = 0, $limit = 0, $sort = 'theme_id ASC, theme_folder', $order = 'ASC')
	{
		$crCountThemes = ($criteria) ? $criteria: new \CriteriaCompo();
		$crCountThemes = $this->getThemesCriteria($crCountThemes, $start, $limit, $sort, $order);
		return $this->getCount($crCountThemes);
	}

	/**
	 * Get All Themes in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllThemes($criteria = null, $start = 0, $limit = 0, $sort = 'theme_id ASC, theme_folder', $order = 'ASC')
	{
		$crAllThemes = ($criteria) ? $criteria: new \CriteriaCompo();
		$crAllThemes = $this->getThemesCriteria($crAllThemes, $start, $limit, $sort, $order);
		return $this->getAll($crAllThemes);
	}

	/**
	 * Get Criteria Themes
	 * @param        $crThemes
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getThemesCriteria($crThemes, $start, $limit, $sort, $order)
	{
		$crThemes->setStart($start);
		$crThemes->setLimit($limit);
		$crThemes->setSort($sort);
		$crThemes->setOrder($order);
		return $crThemes;
	}

	/**
	 * Get sld_getThemesValid complete la table des themes 
	 * @return int nb themes
	 */
function updateThemesValid($clearBefore = false){
    //$clearBefore=true;
    // réinitialisation de la table
    if ($clearBefore){
      $sql = "DELETE FROM " . $this->db->prefix("slider_themes");
      $this->db->queryf($sql);  
    }else{
      //mise à 0 du status
      $sql = "UPDATE " . $this->db->prefix("slider_themes") . " SET theme_status = 0";
      $this->db->queryf($sql);  
    }
    //------------------------------------------------
     
    // liste des themes dans la table
    //$tblTheme = $this->getAllThemes();
    
    // liste des themes valides
    $validThemes = $this->getThemesAllowed();
    //echo "<hr><pre>" . print_r($validThemes,true) . "</pre><hr>";
    
    foreach ($validThemes AS $key=>$theme){
        $criteria =  new \CriteriaCompo();
        $criteria->add(new \Criteria('theme_folder', $theme, '='));
        $countCSS = $this->getCount($criteria);
        $path = XOOPS_ROOT_PATH . "/themes/{$theme}";
        
        if(is_dir($path)){
          if ($countCSS == 0 ){
            $ini = self::getThemesIni($theme);
    		$ret['name']       = (isset($ini['Name'])) ? $ini['Name'] : '';
    		$ret['version']    = (isset($ini['Version'])) ? $ini['Version'] : '';
          
            //$version =  \sld_getThemesVersion($theme);

  			$themesObj = $this->create();
      		$themesObj->setVar('theme_folder', $theme);
//       		$themesObj->setVar('theme_name', isset($ini['name']) ? isset($ini['name']) : '';
//       		$themesObj->setVar('theme_version', isset($ini['version']) ? isset($ini['version']) : '';
      		//$themesObj->setVar('theme_css', ($version==4) ? 'css-cerulean' : '');
      		$themesObj->setVar('theme_css', '');
            
      		$themesObj->setVar('theme_transition',   $this->getTransition($theme));
//      		$themesObj->setVar('theme_version', $version);
            $versionProbable = (strpos($ini['Name'],'4')===false) ? 0 : 4;
//echo "===>{$ini['Name']}--->{$versionProbable}<br>" ;           
      		$themesObj->setVar('theme_tpl_slider', ($versionProbable==4) ? 'slider_theme_xbootstrap_4.tpl' : 'slider_theme_xbootstrap_3.tpl');
          }else{
  			//$themesObj = $this->get($themeId);    
              $ids = $this->getIds($criteria);       
  			$themesObj = $this->get($ids[0]);           
          }        
      	  $themesObj->setVar('theme_status', 1);
          $this->insert($themesObj);
        }

        //$sql = sprintf($sqlTpl, $theme)
    }

        
    return true;

}
    
	/**
	 * Get sld_getThemesValid complete la table des themes 
	 * @return int nb themes
	 */
function getThemeByName($theme){

    $criteria =  new \CriteriaCompo();
    $criteria->add(new \Criteria('theme_folder', $theme, '='));
    $ids = $this->getIds($criteria);       
    $themesObj = $this->get($ids[0]);           
    $tv = $themesObj->getValuesThemes();
    
    return $tv;

}
/* //////////////////////////////////////////////////////////////// */


/* ***********************

************************** */
function getThemesAllowed($addAll = false){
    
    $themes = array();
    if ($addAll){
        //$themes['(*)'] = _AM_SLIDER_ALL_THEMES ; //'(*)';
        $themes[''] = _AM_SLIDER_ALL_THEMES_ARE_VISIBLE; //Constants::ALL;
    }

    $theme_arr = $GLOBALS['xoopsConfig']['theme_set_allowed'];
    foreach (array_keys($theme_arr) as $i) {
        $themes[$theme_arr[$i]] = $theme_arr[$i]; 
    }
    
    return $themes;

}

/* ***********************

************************** */
function getStatics($tplString = ''){
global $slidesHandler;

    $themesList = $this->getThemesAllowed();
    $stat = array();
    foreach ($themesList AS $key=>$theme){
        $criteria = new \CriteriaCompo(new \Criteria("sld_theme", $key, "="));
        if ($tplString != ''){
            $stat[$key] = sprintf($tplString,  $key, 
                              $slidesHandler->getCountSlides($criteria),
                              count($slidesHandler->getSlidesActifs($theme,  false))) ; 
        }else{
            $stat[$key] = $slidesHandler->getCountSlider($criteria);
        }
        
    }
    return $stat;
}

/* ***********************

************************** */

public static function isActif($theme){
    $fFlag = XOOPS_ROOT_PATH . "/uploads/slider/images/slides/" . $theme . ".txt";
    return is_readable($fFlag);
}

/* ***********************

************************** */
public static function getThemesIni($theme, $forceLcaseForKeys = false){
//Description="XOOPS Template developed with Bootstrap 3 Framework"
//Description="XOOPS Template based on Bootswatch and xBootStrap v4"


    $path = XOOPS_ROOT_PATH . "/themes/$theme/theme.ini";
    
    if (file_exists($path)) {
        $theme_ini = parse_ini_file($path);
    }else{
        $theme_ini = array();
    }
    $theme_ini['Folder'] = $theme;
    //-------------------------------------------------
    if ($forceLcaseForKeys){
        $tOptions = array();
        foreach ($theme_ini AS $key=>$value){
          $tOptions[strtolower($key)] = strtolower($value);
        }
        $theme_ini = $tOptions;
    }
    ///----------------------------------------------
    $keys = array('Name','Description','Version','Author','Demo','Download','W3C','Licence','thumbnail','screenshot');
    for($h=0; $h < count($keys); $h++){
        $key = ($forceLcaseForKeys) ? strtolower($keys[$h]) : $keys[$h];
        if (!isset($theme_ini[$key])) $theme_ini[$key] = '';
    }
//echo "<hr><pre>" . print_r($theme_ini, true) . "</pre><hr>";        
//echo "===>theme {$theme} version {$version}<br>";
    return $theme_ini;
}

/* ***********************
met à jour les fichiers :
- bootstrap.min.css
- cookieconsent.css
- xoops.css

et leru affect le nouveau style CSS du theme en modifiant le contenu avec le nom du dossier css_???
@import url(../css-cerulean/bootstrap.min.css);
@import url(../css-cerulean/cookieconsent.css);
@import url(../css-cerulean/xoops.css);

************************** */
public static function updateCss($theme, $newCSS){
//echo "===> theme = {$theme} - newCSS = {$newCSS}<br>";
//exit;
    $themePath = XOOPS_ROOT_PATH . "/themes/{$theme}";    
    $cssPath = $themePath . "/css";
    $filesList = \XoopsLists::getFileListByExtension($cssPath, array("css"));
//echo "<hr><pre>" . print_r ($fileList, true). "</pre><hr>";     
 //exit;  
    foreach ($filesList as $key=>$css2change){
        $fullName = $cssPath . "/{$css2change}";
        //$name= substr($css2change,0,-4):
        $fSrc = $themePath . "/{$newCSS}/{$css2change}";
//echo "{$fullName}<br>{$fSrc}<br>"; exit;        
        if(is_readable($fullName) && is_readable($fSrc) && $css2change != "my_css.css"){
          $content = "@import url(../{$newCSS}/{$css2change});";  
          saveTexte2File($fullName, $content, $mod = 0777);
        }
    }
    
    self::updateCss_xwatch($theme, $newCSS);   
    //cleanThemeFolder($theme);
    self::cleanAllCaches($theme);
    return true;

}
/* ***********************
met à jour les fichiers du therme xwatch:
- xswatchCss.tpl

************************** */
public static function updateCss_xwatch($theme, $newCSS){
//echo "===> theme = {$theme} - newCSS = {$newCSS}<br>";
//exit;

    $fullNameXW = XOOPS_ROOT_PATH . "/themes/{$theme}/tpl/" . 'xswatchCss.tpl'; 
    if (file_exists($fullNameXW)) save_file_org_2_old($fullNameXW);

    //-------------------------------------------------
    if (file_exists($fullNameXW)){
    }
        $content = $newCSS;  
        saveTexte2File($fullNameXW, $content, $mod = 0777);

    return true;

}
/* ***********************

************************** */
public static function getCurrentCss($theme){
    $fileToParse = "bootstrap.min.css"; 
    $css = '';
    $fullName= XOOPS_ROOT_PATH . "/themes/{$theme}/css/{$fileToParse}";
//    echo "$fullName<br>";
    if (is_readable($fullName)){
        $contents = \sld_loadTextFile($fullName);
        
        //$h = strpos($contents, '@import url(../css-');
        $h = strpos($contents, '/css-');
        if (!($h === false)){
//    echo "===>getCurrentCss : {$fullName}<br>";
          $h++;
          $i = strpos($contents, '/', $h+1);
          $css = substr($contents, $h, $i-$h);
        }
        //echo "===>getCurrentCss - css = |{$css}|";
    }

    return $css;
}

/* ***********************

************************** */
public static function getCssList($theme, $prefix = 'css-'){
    
    $path = XOOPS_ROOT_PATH . "/themes/" . $theme;
    $dirList = \XoopsLists::getDirListAsArray($path);
    //$cssList = XoopsLists::getFileListAsArray($path, "css-");
    $cssList = array();
    foreach($dirList as $key=>$name){
        if(substr($name, 0, strlen($prefix)) == $prefix){
            $cssList[$name] = $name;
        }
    }
// echo "<hr>getCssList : <pre>" . print_r($dirList, true) . "</pre><hr>";    
// echo "<hr>getCssList : |{$theme}|{$prefix}|<pre>" . print_r($cssList, true) . "</pre><hr>";    
// exit;
    return $cssList;

}

public static function cleanAllCaches($theme) {
    self::cleanCache($theme, 'smarty_cache');
    self::cleanCache($theme, 'smarty_compile');
}

/**
 * supprime tous les caches du dossier $cache du theme passé en parametre
 * @param string $theme  nom du theme dont il faut effacer les caches
 * @param string $cache      nom du dossier cache à nettoyer
 * @return null

*/
public static function cleanCache($theme, $cache) {

$dirCaches   = XOOPS_VAR_PATH . "/caches/{$cache}";
$tDir = scandir($dirCaches);

    //echo "<hr><pre>" . print_r($theme_directories, true) . "</pre><hr>";
    foreach ($tDir as $f) {
        //$dir = $dirThemes . "/" . $theme_dir;
        $fullName = $dirCaches . '/' . $f;
        if (stripos($fullName, $theme) !== false){
//            echo "==>cache : {$f} <br>";
            chmod($fullName, 0777);
            unlink ($fullName);
        }
    }

}

public static function getTransition($theme) {
    $bolOk = isExpInFile('class="vert', "/themes/{$theme}/tpl/slider.tpl");
    return ($bolOk) ? 1 : 0;
}

} // --- fin de la classe ---
