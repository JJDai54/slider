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


/**
 * réinitialise chaque theme avec le fichier slider.tpl d'origine
 * er active le block du module pour forcer la reconstruction dues sliders de chaque theme utlisé
 *
 */
function force_rebuild_slider() {
    
        \cleanAllThemesFolder();
        \setBlockSliderVisible(true);
    
}



/**
 * Renvoioe un tableau des slides actif pour le theme courant
 *
 */
function getSlidesActifs($theme = '', $rnd = false) {
global $xoopsConfig, $helper;

    $helper      = Helper::getInstance();
    $myts = MyTextSanitizer::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
    
    //recupe du theme actif
    if ($theme == '') $theme = $xoopsConfig['theme_set'];
                
    // selection des slides actifs
    $now = time();
    
    //-------------------------------------------------------------------------
    //Selectionne les slides actifs pour le theme courant
    $crSlidesActif = new \CriteriaCompo();    
    $crSlidesActif->add(new \Criteria('sld_actif', 1, '='));
 
 
    $crSlidesTheme = new \CriteriaCompo();    
    $crSlidesTheme->add(new \Criteria('sld_theme', $theme, '='));
    $crSlidesTheme->add(new Criteria('sld_theme',  0, '=', '', "LENGTH(sld_theme)" ), 'OR');
 
 
 
    
    //-------------------------------------------------------------------------
    //Selectionne les slides qui n'utilisent pas une periode
    $crSlidesHasPeriode = new \CriteriaCompo();
    $crSlidesHasPeriode->add(new \Criteria('sld_periodicity', 0, '='));
    
    //pour les slides qui utilisent une période 
    //sélectionne ceux qui concordent avec la date en cours
    $crSlidesperiode = new \CriteriaCompo();    
    $crSlidesperiode->add(new \Criteria('sld_periodicity', 0, '>'));
    $crSlidesperiode->add(new \Criteria('sld_date_end', $now, '>='));
    $crSlidesperiode->add(new \Criteria('sld_date_begin', $now, '<='));
    //$crSlidesperiode->add(new \Criteria('sld_date_begin', $now + 86400, '<='));
    
    $crSlidesAP = new \CriteriaCompo();    
    $crSlidesAP->add($crSlidesHasPeriode);    
    $crSlidesAP->add($crSlidesperiode, "OR");    
    //-------------------------------------------------------------------------
    //criteria = (actif AND theme courant) AND (sans periode OR (utilise periode AND (date_debut < date courante AND date_fin > date courante))) 
    $crSlides0 = new \CriteriaCompo();    
    $crSlides0->add($crSlidesActif);    
    $crSlides0->add($crSlidesTheme, 'AND');    
    $crSlides0->add($crSlidesAP, "AND");  
    
    //-------------------------------------------------------------------------
    //defini l'ordre d'affichage  
    if ($rnd){
      $crSlides0->setSort('RAND()');
      //$crSlides0->setOrder('ASC');
    }else{
      $crSlides0->setSort('sld_weight,sld_short_name');
      $crSlides0->setOrder('ASC');
    }
  
    $slidesAll = $slidesHandler->getAll($crSlides0);
    unset($crSlides);
    $slides = array();
    $Slide_Ids = [];
    
    if (\count($slidesAll) > 0) {
        foreach (\array_keys($slidesAll) as $i) {
            $id = $slidesAll[$i]->getVar('sld_id'); // pas utile mais il y avait un doute sur la clé du recordset, a verifier
            $slides[$id] = $slidesAll[$i]->getValuesSlides();

        }
    }

//echo "<hr><pre>" . print_r ($slidesAll, true). "</pre><hr>";
//echo "<hr><pre>" . print_r ($slides, true). "</pre><hr>";
    
    return $slides;
}

/**********************************************************************
 * 
 **********************************************************************/
function build_new_tpl($slides, $theme, $periodicite, $forceRebuild = false){
global $helper;
$rnd =  ($periodicite != 'j');
//echo "<hr>slides<pre>" . print_r($slides, true) . "</pre><hr>"; exit("build_new_tpl");   
    $tpl_main = "slider_main-02.tpl";

    // generation du fichier de flag pour eviter de reconstruire à chaque connexion utilisateur   
    //construction d'un tableu des id trié par ordre croissant
    $slide_Ids = array_keys($slides);
    //sort($slide_Ids);
    $newFlag = implode("|", $slide_Ids);
    $newFlag  = sld_getFlagPeriodicity($periodicite, array_keys($slides));  
    //echo "<hr>===>Flag = {$newFlag}<hr>";  
   
    //chargement du fichier en court
    $fFlag = XOOPS_ROOT_PATH . "/uploads/slider/images/slides/" . $theme . ".txt";
    $oldflag = slider_loadTextFile($fFlag);
    
    //si le nouveau flag egal l'ancien flag pas de reconstruction du tpl des slides
    if ($newFlag == $oldflag && !$forceRebuild) return false;   
    
    //sauvegarde du nouveau fichier d'id
    saveTexte2File($fFlag, $newFlag);

    //---------------------------------------------
    //rebuild du tpl
//     $block['msg'] = "Mise à jour des slides du theme";
//     $block['theme'] = $xoopsConfig['theme_set'];
    $fullName = XOOPS_ROOT_PATH . "/themes/" . $theme. '/tpl/slider.tpl';
    $fullName_old = str_replace(".tpl","-old.tpl",$fullName);   
    //echo "<hr>===>{$fullName}<br>===>{$fullName_old}<hr>";
    //Sauvegarde du slides.tpl d'origine si ce n'est déjà fait
    if (!is_readable($fullName_old)){
        rename($fullName, $fullName_old);
    }
    //---------------------------------------------------
    $allStyles = buildStyles($slides);
//echo "<hr><pre>" . print_r($slides, true) . "</pre><hr>";
    //génération de la liste des slides et indicators
    $template = 'db:slider_theme_xbootstrap.tpl';
    $tpl = new \XoopsTpl();
    $tpl->assign('slides', $slides);

$options = array();
$clignotement_name='flash_points';
$options['slider_style_points'] = $helper->getConfig('slider_style_points') . "\n animation-name: {$clignotement_name};\n";
$options['slider_style_point_active'] = $helper->getConfig('slider_style_point_active');
$options['slider_style_clignotement'] = $helper->getConfig('slider_style_clignotement');
$options['clignotement_name'] = 'flash_points';
    
    $tpl->assign('options', $options);

    
    
    $content = $tpl->fetch($template);

    $fSlide = XOOPS_ROOT_PATH . "/modules/slider/templates/admin/{$tpl_main}";
                           
    if (!is_readable($fSlide)) return false;
    //-------------------------------------------------------
    $tplOrg = slider_loadTextFile($fSlide);
    
    // sauvegarde du nouveau tpl/slide.tpl
    $tplOrg = str_replace ("__Slides__", $content, $tplOrg);
    $tplOrg = str_replace ("__STYLES__", $allStyles, $tplOrg);
    $tplOrg = str_replace ("__EXTRA__", $helper->getConfig('slider-extra'), $tplOrg);
    
    saveTexte2File($fullName, $tplOrg, $mod = 0777);
    
    //nettoyage des cachepour un rafraichissement immediat
    cleanThemeCache($theme, 'smarty_cache');
    cleanThemeCache($theme, 'smarty_compile');


    
//    echo "<hr><pre>{$content}</pre><hr>";
    //$content = "togodo";
            
    return true;        
}

/**********************************************************************
 * 
 **********************************************************************/
function buildStyles(&$slides){
    $bolOk = false;
    $tStyles = array();
    
    foreach ($slides as $k=>$v){
        $prefixeName = "slide-{$v['id']}";
        
        if (trim($v['style_title']) != ''){
            $name = "{$prefixeName}-title";
            $tStyles[] = "#{$name}{{$v['style_title']}}";
            $slides[$k]['style_title_name'] = $name;
            $bolOk = true;
        }else $slides[$k]['style_title_name'] = '';
        
        if (trim($v['style_subtitle']) != ''){
            $name = "{$prefixeName}-subtitle";
            $tStyles[] = "#{$name}{{$v['style_subtitle']}}";
            $slides[$k]['style_subtitle_name'] = $name;
            $bolOk = true;
        }else $slides[$k]['style_subtitle_name'] = '';
        
        if (trim($v['style_button']) != ''){
            $name = "{$prefixeName}-button";
            $tStyles[] = "#{$name}{{$v['style_button']}}";
            $slides[$k]['style_button_name'] = $name;
            $bolOk = true;
        }else $slides[$k]['style_button_name'] = '';
    
    
    }
    
    if ($bolOk){
        $allStyles = "<style>\n" . implode("\n", $tStyles) . "</style>\n";

    }else{
        $allStyles = "";
    }
    //echo "allStyles : <hr><pre><code>" . implode("\n", $tStyles) . "</code></pre><hr>";
    //return "allStyles : <hr><pre><code>" . implode("\n", $tStyles) . "</code></pre><hr>";
    return $allStyles; 
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








///////////////////////////////////////////////////////////////

/**
 * réinitialise chaque theme avec le fichier slider.tpl d'originel
 *
 */
function cleanAllThemesFolder() {

$dirThemes   = XOOPS_ROOT_PATH . '/themes';
$theme_directories = scandir($dirThemes);

    //echo "<hr><pre>" . print_r($theme_directories, true) . "</pre><hr>";
    foreach ($theme_directories as $theme_dir) {
        $dir = $dirThemes . "/" . $theme_dir;
        if (is_dir($dir) && substr($theme_dir,0,1) != "."){
//            echo "=>theme : {$dir} <br>";
            if (cleanThemeFolder($dir)){
              cleanThemeCache($theme_dir, 'smarty_cache');
              cleanThemeCache($theme_dir, 'smarty_compile');
              deleteSliderthemeFlag($theme_dir);
            }
        }
    }
    
    //désactivation des block du module
    setBlockSliderVisible(false);
    
    //
}

/**
 * suppression du fichier de flag du theme
 *
 * @param string $theme      nom du theme 
 * @return bool $bolOk          Le fichier a bien ete supprimer
 */
function deleteSliderthemeFlag($theme) {

    $fFlag = XOOPS_ROOT_PATH . "/uploads/slider/images/slides/" . $theme . ".txt";
    if (is_readable($fFlag)){
        $bolOk = unlink($fFlag);
    }else{
       $bolOk = false;
    }

    return $bolOk;
}


/**
 * reinitalise le fichier slider.tpl du theme $themeDir
 *
 * @param string $themeDir      nom du theme dont il faut effacer les caches
 * @return bool $bolOk          Le fichier slider-old.tpl existe et a éé réinitialisé
 */
function cleanThemeFolder($themeDir) {
    $newTpl = $themeDir . "/tpl/slider.tpl";
    $oldTpl = $themeDir . "/tpl/slider-old.tpl";
    
    if (is_readable($oldTpl)){
//        echo "===> {$oldTpl}<br>";
        unlink ($newTpl);
        rename ($oldTpl, $newTpl);
        $bolOk = true;
    }else{
        $bolOk=false;
    }
    return $bolOk;
}

/**
 * supprime tous les caches du dossier $cache du theme passé en parametre
 * @param string $themeName  nom du theme dont il faut effacer les caches
 * @param string $cache      nom du dossier cache à nettoyer
 * @return null

*/
function cleanThemeCache($themeName, $cache) {

$dirCaches   = XOOPS_VAR_PATH . "/caches/{$cache}";
$tDir = scandir($dirCaches);

    //echo "<hr><pre>" . print_r($theme_directories, true) . "</pre><hr>";
    foreach ($tDir as $f) {
        //$dir = $dirThemes . "/" . $theme_dir;
        $fullName = $dirCaches . '/' . $f;
        if (stripos($fullName, $themeName) !== false){
//            echo "==>cache : {$f} <br>";
            chmod($fullName, 0777);
            unlink ($fullName);
        }
    }

}
    
/**
 * Active ou désactive les blocks du module slider
 * 
 * @param bool $visible  nouveau status visible pour les blocks du module 
 * @return null
*/
function setBlockSliderVisible($visible = true) {
global $xoopsDB, $xoopsModule, $helper;
//$xoopsModule   = XoopsModule::getByDirname($dirname);
$intVisible = ($visible) ? 1 : 0;
$moduleId = $xoopsModule->getVar('mid');

    $sql = "UPDATE " . $xoopsDB->prefix('newblocks') . " SET visible={$intVisible} WHERE mid = {$moduleId}";
//    echo "===>update block : <br>{$sql}<br>";
    $xoopsDB->queryf($sql);
}


/**
 * defini le poids du prochain slider
 * 
 * @param bool $visible  nouveau status visible pour les blocks du module 
 * @return null
*/
function getWeightForNextSlide($theme) {
global $xoopsDB;
//$xoopsModule   = XoopsModule::getByDirname($dirname);

    $sql = "SELECT max(sld_weight)+10 AS nextWeight FROM " . $xoopsDB->prefix('slider_slides') . " WHERE sld_theme = '{$theme}'";
    $rst = $xoopsDB->query($sql);
    $t = $xoopsDB->fetchArray($rst);
 
    return $t['nextWeight'];
}


/**
 * renvoi l'état actuel d'un slide
 * 
 * @param bool $visible  nouveau status visible pour les blocks du module 
 * @return bool 
*/
function getCurrentStatusOfSlide(&$slide) {

   if (!$slide['actif']) return false;

   if ($slide['periodicity'] == CONSTANTS::PERIODICITY_ALWAYS) return true;
   
   $now = time();
   if (($slide['date_begin'] < $now) && ($slide['date_end'] > $now)) return true;
//echo "<hr>{$slide['id']}<br>{$slide['date_begin']}<br>{$slide['date_end']}<br>{$now}<hr>";   //  
   return false;

}

/**
*
*/
function sld_getFlagPeriodicity($periodicite, $slidesIds)
{
global $xoopsConfig, $helper;
    //recupe du theme actif
    $theme = $xoopsConfig['theme_set'];
    $ids = "";
    
        switch($periodicite){
        case _SLD_PERIODICITY_MINUTE:
            $instant = date("Y-m-d-i");
            break;
        case _SLD_PERIODICITY_HOUR:
            $instant = date("Y-m-d-H");
            break;
        case _SLD_PERIODICITY_DAY:
            $instant = date("Y-m-d");
            break;
        case _SLD_PERIODICITY_WEEK:
            $instant = date("Y-W");
            break;
        case _SLD_PERIODICITY_MONTH:
            $instant = date("Y-m");
            break;
        case _SLD_PERIODICITY_BIMONTLY:
            $month = (intval((date("m") -1) / 2 ) * 2)+ 1;
            $instant =  date("Y-m", mktime(0,0,0, $month, 1, date("Y")));
            break;
        case _SLD_PERIODICITY_QUATER:
            $month = (intval((date("m") -1) / 3 ) * 3)+ 1;
            $instant =  date("Y-m", mktime(0,0,0, $month, 1, date("Y")));
            break;
         case _SLD_PERIODICITY_SEMESTER:
            $month = (intval((date("m") -1) / 6 ) * 6)+ 1;
            $instant =  date("Y-m", mktime(0,0,0, $month, 1, date("Y")));
            //echo "===>mois = " . date("m") ."<br>===>instant = {$instant}<br>" . intval(11/6) . "<br>";
            break;
        case _SLD_PERIODICITY_YEAR:
            $instant = date("Y", mktime());
            break;
            break;
        case _SLD_PERIODICITY_RANDOM:
            $instant = 0;
            break;
        default:
            $instant = 0;
            $ids = implode("-", $slidesIds);
            break;
        }
        //echo "<hr>===>code periode-> {$month} - {$instant}<hr>";

//        if($instant == '')
//             return '';
//        else{
//            //$tpl = "bid-%'.03d\n|%s|%s";
//            $tpl = "%s|%s|%03d|%s";
//            return sprintf($tpl, $theme, $periodicite, $instant, $ids);
//        }
           $tpl = "%s|%s|%s|%s";
           return sprintf($tpl, $theme, $periodicite, $instant, $ids);
    }


/* ******************************************

*********************************************/
function sld_updatePeriodicity(&$msg){
global $xoopsDB, $slidesHandler;
    
    $now = time();
    $criteria = new CriteriaCompo();
    $criteria->add( new Criteria('sld_periodicity', Constants::PERIODICITY_FLOAT, '>'));
    $criteria->add( new Criteria('sld_date_end', $now, '<'));
    $slidesAll = $slidesHandler->getAll($criteria);
    $countSlides = count($slidesAll);
    if ($countSlides > 0) {
        //foreach (\array_keys($slidesAll) as $i=>$slide) {
        foreach ($slidesAll as $i=>$slide) {
            //$slide = $slidesAll[$i]->getValuesSlides();
            $dateBegin = $slide->getVar('sld_date_begin');
            $dateEnd   = $slide->getVar('sld_date_end');
            
            $db = new DateTime();
            $db->setTimestamp($dateBegin);
            $de = new DateTime();
            $de->setTimestamp($dateEnd);
            
            switch ($slide->getVar('sld_periodicity')){
            case  Constants::PERIODICITY_WEEK :
                $interval = new DateInterval('P7D');
                Break;
            case  Constants::PERIODICITY_MONTH :
                $interval = new DateInterval('P1M');
                Break;
            case  Constants::PERIODICITY_QUATER :
                $interval = new DateInterval('P3M');
                Break;
            case  Constants::PERIODICITY_YEAR :
                 $interval = new DateInterval('P1Y');
               Break;
            }
            
            while ($de->getTimestamp() < $now){
              $db->add($interval);
              $de->add($interval);
            }
            
            
            $slide->setVar('sld_date_begin', $db->getTimestamp());            
            $slide->setVar('sld_date_end', $de->getTimestamp());
            $slidesHandler->insert($slide);

/*
            $sql = "UPDATE " . $xoopsDB->prefix("slider_slides")
                 . " SET sld_date_begin={$db->getTimestamp()}, sld_date_end={$de->getTimestamp()}}"
                 . " WHERE sld_id = " . $slide->getVar('sld_periodicity');
            echo "<br>===> sql : {$sql}<hr>";
*/            
        }
        $msg = sprintf(_AM_SLIDER_PERIODICITY_UPDATED, $countSlides);
    }else $msg = _AM_SLIDER_NO_PERIODICITY_TO_UPDATE;
    
//exit ("sld_updatePeriodicity => {$msg}");   
}

/* ***********************

************************** */
function sld_getThemesAllowed($addAll = false){
    
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