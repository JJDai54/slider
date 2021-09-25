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
//        \setBlockSliderVisible(true);
//exit;    
}


/**
 * Function show block
 * @param  $options
 * @return array
 */
function generer_new_tpl($theme)
{
global $xoopsConfig, $helper, $slidesHandler, $themesHandler;
//echo "===>generer_new_tpl : theme ={$theme}<br>";
    
    if (is_null($slidesHandler)) {
$helper = \XoopsModules\Slider\Helper::getInstance();
$slidesHandler = $helper->getHandler('Slides');
$themesHandler = $helper->getHandler('Themes');
    }
    
    $themeObj = $themesHandler->getThemeByName($theme);
    $tpl_main = "slider_main-02.tpl";    
    //--------------------------------------------
    // selection des slides actifs
    $now = time();
    //$random = $themeObj->getVar('theme_random');
    $random = $themeObj['theme_random'];
    
    //recupe du theme actif
    $slides = $slidesHandler->getSlidesActifs($theme, ($random != 'j'));
    $slide_Ids = array_keys($slides);    
    $newFlag = implode("|", $slide_Ids);
    $newFlag  = sld_getFlagPeriodicity($random, array_keys($slides));  
    //chargement du fichier en court
    //$oldflag = sld_loadTextFile($fFlag);    
    //if ($newFlag == $oldflag && !$forceRebuild) return false;    
    
    //sauvegarde du nouveau fichier d'id
    $fFlag = XOOPS_ROOT_PATH . "/uploads/slider/images/slides/" . $theme . ".txt";    
    saveTexte2File($fFlag, $newFlag);
    
    //
    $fullName = XOOPS_ROOT_PATH . "/themes/" . $theme. '/tpl/slider.tpl';
    save_file_org_2_old($fullName);
    
    //---------------------------------------------------
    $template = "db:{$themeObj['tpl_slider']}";
    $allStyles = buildStyles($slides);
    
$sldOptions = array();
$clignotement_name='flash_points';
$sldOptions['slider_style_points'] = $helper->getConfig('slider_style_points') . "\n animation-name: {$clignotement_name};\n";
$sldOptions['slider_style_point_active'] = $helper->getConfig('slider_style_point_active');
$sldOptions['slider_style_clignotement'] = $helper->getConfig('slider_style_clignotement');
$sldOptions['clignotement_name'] = 'flash_points';
$sldOptions['slider_transition'] = ($themeObj['transition']==1) ? 'vert' : '';
$sldOptions['show_slider'] = 1; //$themeObj['']==1) ? 'vert' : '';    
$sldOptions['show_jumbotron'] = 0; //$themeObj['']==1) ? 'vert' : '';    
    
    $tpl = new \XoopsTpl();
    $tpl->assign('slides', $slides);
    $tpl->assign('sldOptions', $sldOptions);
    
    $allSlides = $tpl->fetch($template);
    
    $fSlide = XOOPS_ROOT_PATH . "/modules/slider/templates/admin/{$tpl_main}";
    if (!is_readable($fSlide)) return false;
    $tplOrg = sld_loadTextFile($fSlide);
    
    // sauvegarde du nouveau tpl/slide.tpl
    $tplOrg = str_replace ("__SLIDES__", $allSlides, $tplOrg);
    $tplOrg = str_replace ("__STYLES__", $allStyles, $tplOrg);
    $tplOrg = str_replace ("__EXTRA__", $helper->getConfig('slider-extra'), $tplOrg);
    saveTexte2File($fullName, $tplOrg, $mod = 0777);    
    
    //-------------------------------------------------
    
    
    Slider\ThemesHandler::cleanAllCaches($theme);
    
////////////////////////////////////////////////////////////////////////
   
    return true;        

}

/**********************************************************************
 * permet de garder une version originale d'un fichier
 * verifie si le fichier old existe, si on le crée
 **********************************************************************/
function save_file_org_2_old($fullName, $keepOrg = false, $extOld = "_old"){
    $h = strrpos($fullName, '.');
    $oldFullName = substr($fullName,0, $h) . $extOld .  substr($fullName,$h); 

    if (!file_exists($oldFullName)){
        //echo "<hr>save_file_org_2_old : <br>org : {$fullName}<br>old : {$oldFullName}<hr>";
        if($keepOrg){
            $ret = copy($fullName, $oldFullName);
        }else{
          $ret = rename($fullName, $oldFullName);
        }
    }
    
    return $ret;
}
/**
 * reinitalise le fichier _old sauver avec save_file_org_2_old
 *
 * @param string $themeDir      nom du theme dont il faut effacer les caches
 * @return bool $bolOk          Le fichier slider-old.tpl existe et a éé réinitialisé
 */
function restaure_file_old_2_org($fullName, $keepOld = false, $extOld = "_old") {

    $h = strrpos($fullName, '.');
    $oldFullName = substr($fullName,0, $h) . $extOld .  substr($fullName,$h); 

    if (file_exists($oldFullName)){
        if (file_exists($fullName)) $ret = unlink ($fullName);
        //echo "<hr>save_file_org_2_old : <br>org : {$fullName}<br>old : {$oldFullName}<hr>";
        if($keepOld){
            $ret = copy($oldFullName, $fullName);
        }else{
            $ret = rename($oldFullName, $fullName);
        }
        
    }

    return $ret;

}

/**********************************************************************
 * construit les tyle des titres et des boutons pour les slides actifs
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





///////////////////////////////////////////////////////////////

/**
 * réinitialise chaque theme avec le fichier slider.tpl d'origine
 *
ç */
function cleanAllThemesFolder() {

    $themesDir   = XOOPS_ROOT_PATH . '/themes';
    $themesList = XoopsLists::getDirListAsArray($themesDir);
    
    //echo "<hr><pre>" . print_r($themesList, true) . "</pre><hr>";
    foreach ($themesList as $theme) {
        $bolOk = cleanThemeFolder($theme);    
//    echo ($bolOk) ? 'glopglop<br>' : 'pas glop<br>';
    }
    
    //désactivation des block du module
//    setBlockSliderVisible(false);
//echo "<hr><pre>" . print_r($themesList, true ). "</pre><hr>";    

}

/**
 * reinitalise le fichier slider.tpl du theme $themeDir
 *
 * @param string $themeDir      nom du theme dont il faut effacer les caches
 * @return bool $bolOk          Le fichier slider-old.tpl existe et a éé réinitialisé
 */
function cleanThemeFolder($theme) {

    $fullName = XOOPS_ROOT_PATH . "/themes/{$theme}" . "/tpl/slider.tpl";;
    //supression du fichier slider.tpl et renomage de slider-old.tpl en slider.tpl
    restaure_file_old_2_org($fullName, $keepOld = false, $extOld = "_old");

/*
    //theme de type xwatch4E
    $fullNameXW = XOOPS_ROOT_PATH . "/themes/{$theme}/tpl/" . 'xswatchCss.tpl';
    //if (file_exists($fullNameXW)) 
    restaure_file_old_2_org($fullNameXW);
*/

    //nettoyage de caches
    Slider\ThemesHandler::cleanAllCaches($theme);          
    deleteSliderthemeFlag($theme);
    return $bolOk;
    
}


/**
 * suppression du fichier de flag du theme dans le dossier "/uploads/slider/images/slides/"
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
function sld_getFilePrefixedBy($dirname, $extensions = null, $prefix = '', $addBlanck = false){
    
    $dirList = XoopsLists::getFileListByExtension($dirname, $extensions, '');
    
    if (strlen($prefix) > 0){
    $files = array();
        foreach($dirList as $key=>$name){
            if(substr($name, 0, strlen($prefix)) == $prefix){
                $files[$name] = $name;
            }
        }
    }else{
        $files = $dirList;
    }
    if ($addBlanck) {
        $blank = array('' => '');
        return array_merge($blank, $files);
    }else{
        return $files;
    }

}

//////////////////////////////

/**********************************************************************
 * 
 **********************************************************************/
function sld_loadTextFile ($fullName){


  if (!is_readable($fullName)){return '';}
  
  $fp = fopen($fullName,'rb');
  $taille = filesize($fullName);
  $content = fread($fp, $taille);
  fclose($fp);
  
  return $content;

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
  
  
  

}

/* ***********************

************************** */
  function TexteSansAccent($texte, $replaceBlankBy = null){

   $accent   = 'ÀÁÂàÄÅàáâàäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏ' . 'ìíîïÙÚÛÜùúûüÿÑñ';
   $noaccent = 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNnuuyNn';
   $texte = strtr($texte,$accent,$noaccent);
   
   if ($replaceBlank) $texte = strtr($texte," ", $replaceBlank);
   return $texte;
   }
   
/* ***********************
@ purgerSliderFolder : compte ou supprime les slide inutilisés
@ $action : 0 = Compte - 1 = suppression
************************** */
function purgerSliderFolder($action = 0){
global $slidesHandler;
    $allSlides = $slidesHandler->getAllSlides();
    $imgUsed = array();
    
    foreach($allSlides AS $slide){
        $imgUsed[$slide->getVar('sld_image')] = $slide->getVar('sld_image');
    }
//     foreach (\array_keys($allSlides) as $i) {
//         $slide = $allSlides[$i]->getValuesSlides();
//         $imgUsed[$slide->getVar('sld_image')] = $slide->getVar('sld_image');
// //        $GLOBALS['xoopsTpl']->append('slides_list', $slide);
//         unset($slide);
//     }

    $dirname = XOOPS_ROOT_PATH . '/uploads/slider/images/slides';
    $listImg = sld_getFilePrefixedBy($dirname, array('jpg','png'), '');
    
    $nbImgDeleted = 0;
    foreach($listImg as $key=>$img){
        if (!array_key_exists($key, $imgUsed)){
            if ($action == 1) unlink($dirname . '/' . $key);
            $nbImgDeleted++;
        }
    }
    
//  echo "<hr><pre>" . print_r(, true ). "</pre><hr>";
//  echo "<hr><pre>" . print_r($listImg, true ). "</pre><hr>";    
    return $nbImgDeleted;
   }
   
   /* *****************************
   
   * ****************************** */
function getFormPeriodicity($caption, $name, $periodicite = 'j', $prefixConst = '_AM_'){

 
    $selPeriodicite = new \XoopsFormSelect($caption, $name, $periodicite);
    //------------------------------------------------------------------
//     $selPeriodicite->addOption(_SLD_PERIODICITY_NEVER,    _MB_SLIDER_PERIODICITE_NEVER);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_RANDOM,   _MB_SLIDER_PERIODICITE_RANDOM);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_MINUTE,   _MB_SLIDER_PERIODICITE_MINUTE);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_HOUR,     _MB_SLIDER_PERIODICITE_HOUR);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_DAY,      _MB_SLIDER_PERIODICITE_DAY);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_WEEK,     _MB_SLIDER_PERIODICITE_WEEK);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_MONTH,    _MB_SLIDER_PERIODICITE_MONTH);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_BIMONTLY, _MB_SLIDER_PERIODICITE_BIMONTHLY);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_QUATER,   _MB_SLIDER_PERIODICITE_QUATER);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_SEMESTER, _MB_SLIDER_PERIODICITE_SEMESTER);
//     $selPeriodicite->addOption(_SLD_PERIODICITY_YEAR,     _MB_SLIDER_PERIODICITE_YEAR);
    
    $selPeriodicite->addOptionArray(getPeriodicityCaptions($prefixConst));
    //------------------------------------------------------------------
    if (defined($caption)){
        $desc = constant($caption + '_DESC');
        if (!is_null($desc))
             $selPeriodicite->setDescription($desc);
    }

    return $selPeriodicite;
}

   /* *****************************
   
   * ****************************** */
function getPeriodicityCaptions($prefixConst = '_AM_'){
//echo "===>getPeriodicityCaptions :  prefixConst = {$prefixConst}<br>";    
    $tCaptions = array(
     _SLD_PERIODICITY_NEVER       => constant($prefixConst . 'SLIDER_PERIODICITE_RND_NEVER'),
     _SLD_PERIODICITY_RANDOM      => constant($prefixConst . 'SLIDER_PERIODICITE_RND_RANDOM'),
     _SLD_PERIODICITY_MINUTE      => constant($prefixConst . 'SLIDER_PERIODICITE_RND_MINUTE'),
     _SLD_PERIODICITY_HOUR        => constant($prefixConst . 'SLIDER_PERIODICITE_RND_HOUR'),
     _SLD_PERIODICITY_DAY         => constant($prefixConst . 'SLIDER_PERIODICITE_RND_DAY'),
     _SLD_PERIODICITY_WEEK        => constant($prefixConst . 'SLIDER_PERIODICITE_RND_WEEK'),
     _SLD_PERIODICITY_MONTH       => constant($prefixConst . 'SLIDER_PERIODICITE_RND_MONTH'),
     _SLD_PERIODICITY_BIMONTLY    => constant($prefixConst . 'SLIDER_PERIODICITE_RND_BIMONTHLY'),
     _SLD_PERIODICITY_QUATER      => constant($prefixConst . 'SLIDER_PERIODICITE_RND_QUATER'),
     _SLD_PERIODICITY_SEMESTER    => constant($prefixConst . 'SLIDER_PERIODICITE_RND_SEMESTER'),
     _SLD_PERIODICITY_YEAR        => constant($prefixConst . 'SLIDER_PERIODICITE_RND_YEAR')
    );

    return $tCaptions;
}

   /* *****************************
   
   * ****************************** */
function getPeriodicityCaption($key, $prefixConst = '_AM_'){
//echo "===>getPeriodicityCaption :  prefixConst = {$prefixConst}<br>";
    $tPer = getPeriodicityCaptions($prefixConst);
    return($tPer[$key]);
}
    
/* ***********************

************************** */
function isExpInFile($exp, $fullName, $root = XOOPS_ROOT_PATH){
        
    $fileToParse = $root . $fullName; 
    if (is_readable($fileToParse)){
        $contents = \sld_loadTextFile($fileToParse);
        
        //$h = strpos($contents, '@import url(../css-');
        $h = strpos($contents, $exp);
        return ($h === false) ? false : true;
    }

    return false;
}
