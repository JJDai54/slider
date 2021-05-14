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


