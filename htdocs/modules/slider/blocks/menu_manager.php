<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright      {@link https://xoops.org/ XOOPS Project}
 * @license        {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author         XOOPS Development Team
 */

// defined('XOOPS_ROOT_PATH') || exit('Restricted access.');
/* ***************
function b_slider_menu_manager_show
$option [0] : nom du module
$option [1] : position du menu : 0 = menu principal / 1 = sous-menu
$option [2] : theme : 0 = xwatch / 1 = xbootstrap
****************** */
$h = 0;
define ('_SLIDER_BLOCK_MODULE'  , $h++); // dirname du module
define ('_SLIDER_BLOCK_THEME'   , $h++); // type de theme : 0=slider_menu_xbootstrap_main.tpl / 1=slider_menu_xswatch4_main.tpl
define ('_SLIDER_BLOCK_PARAMS'  , $h++); // Valeur binaire qui précise le contenu du menu 1=showMainMenu / 2=showCategories / 4=catIsSubmenu / 8=showAllCatLib / 16=showAdminmodule
define ('_SLIDER_BLOCK_LEVEL'   , $h++); // 0=niveau de menu 0=Menu principal / 1=Sous-menu de niveau 1 / 2=sous-menu de niveau 2
define ('_SLIDER_BLOCK_ORDER'   , $h++); // Defini l'ordre liste des items - options d'accès du module (accueil du module, nouveelle entrée, ...)
/*
<{block id=165 options="wggallery|0|7|1|0"}> 
<{block id=165 options="quizmaker|0|3|1|0"}> 
<{block id=165 options="xforms|0|3|1||0"}> 
*/

function b_slider_menu_manager_show($options)
{
global $xoopsDB, $xoTheme;
/* exemple d'implementation dans nav_menu.tpl
        <!-- ====================== JJDai - Menu ==================== -->
        <{block id=165 options="cds_xmnews|0|3|0|1"}>   
        <{block id=165 options="news|0|3|0|0"}>   
        <{block id=165 options="extcal|0|3|0|0"}> 
        <{block id=165 options="tdmdownloads|0|3|0|0"}>
        <!-- ====================== JJDai - Extra ==================== -->

*/
    //echo "<hr>Block options<pre>" . print_r($options, true) . "</pre><hr>";
    
    //verification de l'existance du plugin pour le module passé en parametre
    if(isset($options[_SLIDER_BLOCK_MODULE])){
        $module = $options[_SLIDER_BLOCK_MODULE];
    }else{
        return ""; //le plugin n'existe pas
    }
    
    //Instanciation de la class plugin du module
    $clsName = "Slider_" . ucfirst($module);
include_once(XOOPS_ROOT_PATH . "/modules/slider/class/Slider_Plugin.php");    
include_once(XOOPS_ROOT_PATH . "/modules/slider/plugins/{$module}/{$clsName}.php");
    $sldPlugin = new $clsName($module);
    
    //------------------------------------------------------------------------    
    //    //Choix du template xbootstrab ou xwatch
    $tpl    = (isset($options[_SLIDER_BLOCK_THEME]))  ? $options[_SLIDER_BLOCK_THEME]  : 0;
    //$tplMainMenu = sprintf("db:%1\$s_%2\$d%3\$d.tpl", array('slider_menu_xswatch4_main','slider_menu_xbootstrap_main')[$tpl], $level, $sens);
    //Choix du template xbootstrab ou xwatch
    $tplMainMenu = "db:" . array('slider_menu_xbootstrap_main.tpl', 'slider_menu_xswatch4_main.tpl')[$tpl];
    
    //niveau d'implémentation du menu : 0=barre principale - 1=SousMenu 
    $level  = (isset($options[_SLIDER_BLOCK_LEVEL]))  ? $options[_SLIDER_BLOCK_LEVEL]  : 0;
   
    //
    $sldPlugin->order = (isset($options[_SLIDER_BLOCK_ORDER]))   ? $options[_SLIDER_BLOCK_ORDER]   : 0;
    
    // valeur binairee qui défini les options d'affichages : 0 = toutes les options, meme celles qui n'existe pas encore :-)
    $showingOptions  = (isset($options[_SLIDER_BLOCK_PARAMS])) ? $options[_SLIDER_BLOCK_PARAMS]   : 0; 
    
    $sldPlugin->showMainMenu    = ((($showingOptions &  1) != 0) || $showingOptions == 0);
    $sldPlugin->showCategories  = ((($showingOptions &  2) != 0) || $showingOptions == 0);
    $sldPlugin->catIsSubmenu    = ((($showingOptions &  4) != 0) || $showingOptions == 0);
    $sldPlugin->showAllCatLib   = ((($showingOptions &  8) != 0) || $showingOptions == 0);
    $sldPlugin->showAdminmodule = ((($showingOptions & 16) != 0) || $showingOptions == 0);

    
                                                   
    
    //$module = 'news';
    //---------------------------------------------------------
// $f = XOOPS_ROOT_PATH . "/modules/slider/class/Slider_Plugin.php";
// echo "<hr>{$f}<hr>";
// echo (file_exists($f)) ? '===>ok' : "===>non";   
 
    //----------------------------------------------------------

    //----------------------------------------------------------
    //recupe du menu sous forme d'un tableau des catégories et d'items
    $block  = $sldPlugin->getMenu();
    
    //ajout des options communes : acces direct au module (front office) 
    $sldPlugin->addCommonOptions($block);
    
//     $block['module']['nbMainMenu'] = ((isset($block['main'])) ? count($block['main']): 0);
//     $block['module']['nbCatItems'] = ((isset($block['catItems'])) ? count($block['catItems']): 0);
    $block['module']['level'] = $level;
    //$block['module']['tpl'] = array('slider_menu_xswatch4.tpl','slider_menu_manager.tpl')[$tpl];

    //$block['module']['tpl'] ="<{include file='db:{$tplName}' }>";
    $block['module']['tpl'] = $tpl;
    $block['module']['tplMainMenu'] = $tplMainMenu;    
    //echo "<hr>Block menu<pre>" . print_r($block, true) . "</pre><hr>";

    return $block;
} 


/**
 * @param $options
 */
function b_slider_menu_manager_edit($options)
{
}
