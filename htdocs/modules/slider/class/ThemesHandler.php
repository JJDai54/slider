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
            
      		$themesObj->setVar('theme_transition',   $this->getTransition($theme));
//      		$themesObj->setVar('theme_version', $version);
            $versionProbable = (strpos($ini['Name'],'4')===false) ? 0 : 4;
//echo "===>{$ini['Name']}--->{$versionProbable}<br>" ;           
      		$themesObj->setVar('theme_tpl_slider', ($versionProbable==4) ? 'slider_theme_xbootstrap_4.tpl' : 'slider_theme_xbootstrap_3.tpl');
// a traiter
// theme_mycss            
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
        $criteria = new \CriteriaCompo(new \Criteria("sld_theme", "%|{$key}|%", "LIKE"));
        //$criteria->add(new \Criteria("length(sld_theme)", 0, '='), 'OR');
        $criteria->add(new \Criteria("sld_theme", null, '='), 'OR');
        if ($tplString != ''){
            $stat[$key] = sprintf($tplString,  _AM_SLIDER_SLIDE_THEME, $key, 
                              $slidesHandler->getCountSlides($criteria),
                              count($slidesHandler->getSlidesActifs($theme,  false))) ; 
        }else{
            $stat[$key] = $slidesHandler->getCountSlider($criteria);
        }
        
    }
    

    $stat['empty'] = "<tr><td colspan='3'><hr></td></tr>"; 
    $key = _AM_SLIDER_ALL_SLIDES;
    $stat[$key] = sprintf($tplString,  '', $key, 
                      $slidesHandler->getCountSlides(),
                      count($slidesHandler->getSlidesActifs('',  false))) ; 
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

************************** */
public static function getCurrentCss_xbootstrap($theme){
    $fileToParse = "bootstrap.min.css"; 
    $css = '';
    $fullName= XOOPS_ROOT_PATH . "/themes/{$theme}/css/{$fileToParse}";
//    echo "$fullName<br>";
    if (is_readable($fullName)){
        $contents = \sld_loadTextFile($fullName);
        
        //$h = strpos($contents, '@import url(../css-');
        $h = strpos($contents, '/css-');
        if (!($h === false)){
//    echo "===>getCurrentCss_xbootstrap : {$fullName}<br>";
          $h++;
          $i = strpos($contents, '/', $h+1);
          $css = substr($contents, $h, $i-$h);
        }
    }
//echo "===>getCurrentCss_xbootstrap<br>{$fullName}<br>css = |{$css}|";

    return $css;
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
public static function updateCss_xbootstrap($theme, $newCSS){
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
    
    self::cleanAllCaches($theme);
    return true;

}

/* ***********************

************************** */
public static function isXswatch4E($theme){
    $fullNameXW = XOOPS_ROOT_PATH . "/themes/{$theme}/tpl/" . 'xswatchCss.tpl';
    return file_exists($fullNameXW);
}

/* ***********************

************************** */
public static function getCurrentCss_xswatch4E($theme, $darkCss = false){

    $listCssOk = self::getCssList($theme);
    $fileName = ($darkCss) ? 'xswatchDarkCss.tpl' : 'xswatchCss.tpl';    
    $fullName= XOOPS_ROOT_PATH . "/themes/{$theme}/tpl/{$fileName}";
//    echo "$fullName<br>";

    if (is_readable($fullName)){
        $contents = \sld_loadTextFile($fullName);
        $tLines = explode("\n", $contents);
        for ($h=count($tLines)-1; $h>=0; $h--){
            $css = trim($tLines[$h]);
            //if (strlen($css)>0)
            if (array_key_exists($css, $listCssOk)){
                break;
            }
        }
    }else{
        $css = '???';
    }
//echo "===>getCurrentCss_xswatch4E<br>{$fullName}<br>css = |{$css}|<br>";
    return $css; 

}
/* ***********************
met à jour les fichiers du therme xswatch4E:
- xswatchCss.tpl

************************** */
public static function updateCss_xswatch4E($theme, $newCSS, $darkCss = false){
//echo "===> theme = {$theme} - newCSS = {$newCSS}<br>";
//exit;

    $fileName = ($darkCss) ? 'xswatchDarkCss.tpl' : 'xswatchCss.tpl';
    $fullNameXW = XOOPS_ROOT_PATH . "/themes/{$theme}/tpl/{$fileName}"; 
    if (file_exists($fullNameXW)) save_file_org_2_old($fullNameXW);

    //-------------------------------------------------
    $content = $newCSS;  
    saveTexte2File($fullNameXW, $content, $mod = 0777);
//echo "===><br>updateCss_xswatch4E{$fullNameXW}<br>css = |{$newCSS}|<br>";
    
    //pour les themes xswatch4 sous xoops 2510 et inférieur
    //pas vraiment utile à partir de xoops2511 mais à faire quand meme
    self::updateCss_xswatch4E_x2510($theme, $newCSS);
    

    return true;

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
public static function updateCss_xswatch4E_x2510($theme, $newCSS){
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
    
    self::cleanAllCaches($theme);
    return true;

}

/**
 * Function is_slider_allowed
 * @param  $theme : dossier du theme xswatch4
 * @return bool
 */
public static function get_Path($theme, $fileName='')
{
    //------------------------------------------------
    if($fileName != ''){
        $fullName = XOOPS_ROOT_PATH . "/themes/{$theme}/{$fileName}"; 
    }else{
        $fullName = XOOPS_ROOT_PATH . "/themes/{$theme}"; 
    }

    return $fullName;
}

/**
 * Function is_slider_allowed
 * @param  $theme : dossier du theme xswatch4
 * @return bool
 */
public static function is_slider_allowed($theme)
{
    $line1a = '<{* un-comment to enable slider';
    $line1b = '<{* comment to un-enable slider *}>';
    //------------------------------------------------
    $fullName = self::get_Path($theme, 'theme.tpl');
    if (is_readable($fullName)){
        $contents = \sld_loadTextFile($fullName);
        $pos = strpos($contents, $line1a);
        $bolOk = ($pos === false);
    }else $bolOk = false;
    
    return $bolOk;
}

/* ********************
 * Function set_allowed_slider
 * @param  $theme : dossier du theme xswatch4
 * @return bool
* ******************** */
public static function set_allowed_slider($theme, $enabled = true)
{
/*
<{* un-comment to enable slider
<{if $xoops_page == "index"}>
    <{include file="$theme_name/tpl/slider.tpl"}>
<{/if}>
*}>
*/
    $line1a = '<{* un-comment to enable slider';
    $line1b = '<{* comment to un-enable slider *}>';
    $line2a = '*}>';
    $line2b = '<{* slider is alowed *}>';
    
    
    if ($enabled){
        $line2search = $line1a;
        $line2replace = $line1b;
        $lieneEnd = $line2b; 
    }else{
        $line2search = $line1b;
        $line2replace = $line1a;
        $lieneEnd = $line2a; 
    }
    //------------------------------------------------
    $fullName = self::get_Path($theme, 'theme.tpl');
    if (is_readable($fullName)){
        $contents = \sld_loadTextFile($fullName);
        $tLines = explode("\n", $contents);

        for($h = 0; $h < count($tLines); $h++){
            if ($tLines[$h] == $line2search){
                $tLines[$h] = $line2replace;
                $tLines[$h+4] = $lieneEnd;   
                break;         
            }
            
        }
        $content = implode("\n", $tLines);
        saveTexte2File($fullName, $content, $mod = 0777);
    }    
}

/**
 * Function is_jumbotron_allowed
 * @param  $theme : dossier du theme xswatch4
 * @return bool
 */
public static function is_jumbotron_allowed($theme)
{
    //$line1a = '<{include file="$theme_name/tpl/jumbotron.tpl"}>';
    $line1b = '<{* <{include file="$theme_name/tpl/jumbotron.tpl"}> *}>';
    //------------------------------------------------
    $fullName = self::get_Path($theme, 'theme.tpl');
    if (is_readable($fullName)){
        $contents = \sld_loadTextFile($fullName);
        $pos = strpos($contents, $line1b);
        $bolOk = ($pos === false);
    }else $bolOk = false;
    
    return $bolOk;
}
    
/* ********************
 * Function set_allowed_jumbotron
 * @param  $theme : dossier du theme xswatch4
 * @return bool
* ******************** */
public static function set_allowed_jumbotron($theme, $enabled = true)
{
    $line1a = '<{include file="$theme_name/tpl/jumbotron.tpl"}>';
    $line1b = '<{* <{include file="$theme_name/tpl/jumbotron.tpl"}> *}>';
    if ($enabled){
        $line2search = $line1a;
        $line2replace = $line1b;
    }else{
        $line2search = $line1b;
        $line2replace = $line1a;
    }

    //------------------------------------------------
    $fullName = self::get_Path($theme, 'theme.tpl');
    if (is_readable($fullName)){
        $contents = \sld_loadTextFile($fullName);
        //verifie l'état courant du fichier
        $pos = strpos($contents, $line1b);
        $isAllowed = ($pos === false);
        if ($enabled && !$isAllowed){
            $contents = str_replace($line1b, $line1a, $contents);
        }elseif($isAllowed){
            $contents = str_replace($line1a, $line1b, $contents);
        }
        //echo $contents;exit;

        saveTexte2File($fullName, $contents, $mod = 0777);
    }    
    
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
