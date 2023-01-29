<?php

//namespace XoopsModules\Slider;

/*
 Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Module:  slider
 *
 * @package      \module\slider\class
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       ZySpec <owners@zyspec.com>
 * @author       Mamba <mambax7@gmail.com>
 * @since        
 */

//use XoopsModules\Slider;

/**
 * Class Utility
 */
class Slider_Plugin
{
  

/**
 * @public function getPermissions
 * returns right for $perms
 *
 * @$moduleName string : nom du module
 * @perms : tableau des code permission a retourner (array('news_view','news_submit','news_approve'))
 * @return bool
 */

var $moduleDirName = '';
var $mid = 1;
var $groupIds = array();
var $gIds = '';
//var $level = '';

var $showAllCatLib = false;
var $showCategories = false;
var $showMainMenu = false;
var $showAdminmodule = false;
var $order = 0;
var $catIsSubmenu = true;

//var $params = array();

function __construct ($moduleDirName){
    $this->moduleDirName = $moduleDirName;
    $this->mid = $this->getModuleId();
    if ($this->mid > 0){
      $this->groupIds = $this->getUserGroupes();
      $this->gIds = implode(',', $this->groupIds);
    }
    //----------------------------------------------------------
    $language = $GLOBALS['xoopsConfig']['language'];
    $path     =  "modules/slider/plugins/{$this->moduleDirName}";
    if (!file_exists($fileinc = $GLOBALS['xoops']->path("{$path}/{$language}.php"))) {
        if (!file_exists($fileinc = $GLOBALS['xoops']->path("{$path}/english.php"))) {
            //return false;
        }
    }
    //echo '===>Fichier de langue -><br>' . $fileinc . "<br>";
    $ret = include_once $fileinc;
    //----------------------------------------------------------
    
}


 /* ********************
 *
 *********************** */   
public function getClauseExtra(){
    return $this->options['where_extra'];  
}

/* *************************************
*
* ************************************** */
public function getMenu(){
        //global $xoopsDB;
    $block = array();      
    $mainMenu = $this->getMainMenu();
    
    if ($this->catIsSubmenu){
      $catItems['catItems']['url'] = '#';
      $catItems['catItems']['lib'] = constant(strtoupper("_MB_SLD_{$this->moduleDirName}_SUBMENU_CAT"));;
      $catItems['catItems']['submenu'] =  $this->getcatItems();
    }else{
        $catItems = $this->getcatItems();
    }
    $tSep['sep1']['url'] = '#';
    $tSep['sep1']['lib'] = "<hr>";
    
    //defini l'ordre d'affichage des block options du modules (new, search, ;;;) et liste des catégories
    if ($this->order == 0){
        if(count($catItems) > 0) {
          if ($this->catIsSubmenu){
            $finalMenu = array_merge($mainMenu, $catItems);
          }else{
            $sep = (count($mainMenu) > 0) ? $tSep : array();
            $finalMenu = array_merge($mainMenu, $sep, $catItems);
          }
        }else{
            $finalMenu = $mainMenu ;
        }
        
    }else{
        if(count($catItems) > 0) {
          if ($this->catIsSubmenu){
            $finalMenu = array_merge($catItems, $mainMenu);
          }else{
            $sep = (count($mainMenu) > 0) ? $tSep : array();
            $finalMenu = array_merge($catItems, $sep, $mainMenu);
          }
        }else{
            if(count($mainMenu) > 0) $finalMenu = $mainMenu;
        }
    }
    //--------------------------------------------------------    
    if ($this->showHrBefore) {
        $block['main'][] = array_merge($tSep, $finalMenu);
    }else{
        $block['main'][] = $finalMenu;
    }
    //--------------------------------------------------

    
    //------------------------------------------------------------------------------------    
//         if ($this->moduleDirName == 'mediatheque')
//         echo "<hr>{$this->mid} - {$this->moduleDirName} - {$table} <pre>" . print_r($block, true) . "</pre><hr>";
    return $block;
}
/* *************************************
*
* ************************************** */
// public function getMenuHr(){
//         //global $xoopsDB;
//     $block = array();      
//     $tSep['sep1']['url'] = '#';
//     $tSep['sep1']['lib'] = "<hr>";
//     
//     $block['main'][] =  $tSep;
//     return $block;
// }

/* *************************************
*
* ************************************** */
public function getUserGroupes()
{
	global $xoopsUser;
    //-----------------------------------------
    //liste des goupes du user
	$currentuid = 0;
 	if (isset($xoopsUser) && is_object($xoopsUser)) {
// 		if ($xoopsUser->isAdmin($xoopsModule->mid())) {
// 			return array();
// 		}
 		$currentuid = $xoopsUser->uid();
 	}
    //-------------------------------------------
	$memberHandler = xoops_getHandler('member');
	if ($currentuid == 0) {
		$group_ids = [XOOPS_GROUP_ANONYMOUS];
	} else {
		$group_ids = $memberHandler->getGroupsByUser($currentuid);
	}
    //-----------------------------------------
    return $group_ids;
}

/**
 * @public function getPermissions
 * returns right for $perms
 *
 * @$moduleName string : nom du module
 * @perms : tableau des code permission a retourner (array('news_view','news_submit','news_approve'))
 * @return bool
 */
public function getModuleId()
{
    $xoopsModule = XoopsModule::getByDirname($this->moduleDirName);
	$mid = ($xoopsModule) ? $xoopsModule->mid() : 0;
    //-----------------------------------------
 	return $mid;
}

/**
 * @public function getPermissions
 * returns right for $perms
 *
 * @$moduleName string : nom du module
 * @perms : tableau des code permission a retourner (array('news_view','news_submit','news_approve'))
 * @return bool
 */
public function getPermissionsIds($gperm_name)
{
	global $xoopsUser;

        if ($this->mid == 0) return array();   
    
    //-----------------------------------------
    //$ids = implode(',', $this->groupIds);
    //echo "<hr>Groupes du user{$this->gIds}<hr>";
	$grouppermHandler = xoops_getHandler('groupperm');
    $idsArray = $grouppermHandler->getItemIds($gperm_name, $this->groupIds, $this->mid);
//echo "<hr>getPermissionsIds : {$gperm_name} - {$ids} - {$this->mid}<pre>" . print_r($idsArray, true) . "</pre><hr>";    
    return $idsArray;
    //echo "<hr>=== getPermissions ===<hr>";
}


    /**
     * Get all item IDs that a group is assigned a specific permission
     *
     * @param string $gperm_name  Name of permission
     * @param        int          /array $gperm_groupid A group ID or an array of group IDs
     * @param int    $gperm_modid ID of a module
     *
     * @return array array of item IDs
     */
    public function getPermsissionsNames($show = false)
    {
        if ($this->mid == 0) return array();   

        $permsNames      = array();
        $criteria = new CriteriaCompo(new Criteria('gperm_modid', (int)$this->mid));
        $criteria->add(new Criteria('gperm_groupid', "({$this->gIds})", 'IN'));
        
     	$grouppermHandler = xoops_getHandler('groupperm');
        $perms = $grouppermHandler->getObjects($criteria, true);
        foreach (array_keys($perms) as $i) {
            $permsNames[] = $perms[$i]->getVar('gperm_name');
        }

       $permsNamesUnique = array_unique($permsNames);
       if ($show)
            echo "<hr>Noms des permissions du user pour le module {$this->moduleDirName}<pre>" 
                 . print_r($permsNamesUnique, true) . "</pre><hr>";
       
       if ($this->showAdminmodule){
         if ($this->isPermAdmin()) $permsNamesUnique[] = "admin"; 
       }
       return $permsNamesUnique;
    }
    
    /**
     * Get all item IDs that a group is assigned a specific permission
     *
     * @param string $gperm_name  Name of permission
     * @param        int          /array $gperm_groupid A group ID or an array of group IDs
     * @param int    $gperm_modid ID of a module
     *
     * @return array array of item IDs
     */
    public function getAllPermsissions()
    {
        global $xoopsDB;
        
        if ($this->mid == 0) return array();
                
        $permsNames      = array();
        $criteria = new CriteriaCompo(new Criteria('gperm_modid', (int)$this->mid));
//         if (is_array($this->groupIds)) {
//             $criteria2 = new CriteriaCompo();
//             foreach ($this->groupIds as $gid) {
//                 $criteria2->add(new Criteria('gperm_groupid', $gid), 'OR');
//             }
//             $criteria->add($criteria2);
//         } else {
//             $criteria->add(new Criteria('gperm_groupid', (int)$this->groupIds));
//         }
         $grouppermHandler = xoops_getHandler('groupperm');
         $perms = $grouppermHandler->getObjects($criteria, true);
         $ret = array();
            
            
            
        foreach (array_keys($perms) as $i) {
            $t = array();
            $t['gperm_id']      =  $perms[$i]->getVar('gperm_id');
            $t['gperm_name']    =  $perms[$i]->getVar('gperm_name');
            $t['gperm_groupid'] =  $perms[$i]->getVar('gperm_groupid');
            $t['gperm_itemid']  =  $perms[$i]->getVar('gperm_itemid');
            $t['gperm_modid']   =  $perms[$i]->getVar('gperm_modid');

            $ret[] = $t;
        }
             //while (false !== ($myrow = $xoopsDB->fetchArray($perms))) {
//              while ($myrow = $xoopsDB->fetchArray($perms)) {
//                  $ret[] = $myrow;
//              }
       //echo "<hr>Noms des permissions du user pour le module {$this->moduleDirName}<pre>" . print_r($permsNames, true) . "</pre><hr>";
        return $ret;
    }
    
    /**
     * Get all item IDs that a group is assigned a specific permission
     *
     * @param string $gperm_name  Name of permission
     * @param        int          /array $gperm_groupid A group ID or an array of group IDs
     * @param int    $gperm_modid ID of a module
     *
     * @return array array of item IDs
     */
    public function isPermAdmin()
    {
    $gperm_name = 'module_admin';
	$grouppermHandler = xoops_getHandler('groupperm');
    $idsArray = $grouppermHandler->getItemIds($gperm_name, $this->groupIds, 1);//module system
    
    //echo "<hr>isPermAdmin : {$gperm_name} - {$this->mid}<pre>" . print_r($idsArray, true) . "</pre><hr>";    

    return in_array($this->mid, $idsArray);
    }

/****************
 * supprime le prefixe du titre - separateur par defaut : '-'
 ***************/
function parse_title($title, $sep = '-') {
    if (!$sep) return $title;
      $h = strpos($title, $sep);
      if (!($h === false)) $title = substr($title, $h + 1);
      return $title;
}

/****************
 * 
        $options['table'] = 'news_topics';
        $options['fld_id'] = 'topic_id';
        $options['fld_pid'] = 'topic_pid';
        $options['fld_name'] = 'topic_title';
        $options['fld_weight'] = 'topic_weight';
        $options['permView'] = 'news_view';
        $options['captionAll'] = _MB_SLD_NEWS_ALL_STORIES;
        $options['catPage'] = 'index.php';
        $options['catParamName'] = 'storytopic';
        $options['maxLevelPid'] = '-1';
        $options['addAllCategories'] = true;
        
 ***************/
function getCatItems(&$options = null){
        global $xoopsDB;
        
        if (!$this->showCategories) return array();
        //---------------------------------------------
        //$options['moduleDirName'] = $this->moduleDirName;        
        
        //transformation du tableau de variables en variables nommées
        foreach($this->options AS $key=>$value){
            $$key = $value;
        }
        //La table des categories n'est pas renseignée alors return un tableau vide
        if(!$table) return array();
        //--------------------------------------------------------
        $asPid = '';
        if (!isset($fld_pid) || $fld_pid == '') {
            $fld_pid = 'cat_pid';
            $asPid = '0 AS ';
        }
        $asWeight = '';
        if (!isset($fld_weight) || $fld_weight == '') {
            $fld_weight = 'cat_weight';
            $asWeight = '0 AS ';
        }
        $asActive = '';
        if (!isset($fld_active) || $fld_active == '') {
            $fld_active = 'cat_active';
            $asActive = '1 AS ';
        }
        
        $moduleUrl = XOOPS_URL . "/modules/{$this->moduleDirName}";        

        $permsOK = false;
// if ($this->mid==37){
// echo "<hr>options [1] <pre>" . print_r($this->options, true) . "</pre><hr>";        
// }     
        if (isset($permView) && $permView != ''){
            $perm_ids = $this->getPermissionsIds($permView);
            if (count($perm_ids) > 0) $permsOK = true;
            else return array();
        }else{
            //return array();
        }    
// if ($this->mid==37){
// echo "<hr>options [2] <pre>" . print_r($this->options, true) . "</pre><hr>";        
// echo "<hr>Permissions ==>" .$this->options['permView'] . "<pre>" . print_r($perm_ids, true) . "</pre><hr>";        
// }     
//         if (isset($perm_ids)) {
//         }
        //-------------------------------------
        $tWheres = array();
        if ($permsOK) $tWheres[] = "{$fld_id} in (" . implode(',', $perm_ids) . ")";
        //if (isset($where_extra) && $where_extra != '' ) $tWheres[] = $where_extra; 

        $where_extra = $this->getClauseExtra(); 
        if ($where_extra) $tWheres[] = $where_extra; 
        //if (isset($where_extra) && $where_extra != '' ) $tWheres[] = $this->getClauseExtra(); 
        
        if (count($tWheres) > 0) {
            $where = " WHERE " . implode(' AND ', $tWheres) ;
        }else{
            $where = "";
        }
        
        //on ne renvoie que les categories 
        $sql = "SELECT {$fld_id}, {$asPid}{$fld_pid}, {$fld_name}, {$asWeight}{$fld_weight}, {$asActive}{$fld_active}"
             . " FROM " . $xoopsDB->prefix($table) . $where
             . " ORDER BY {$fld_pid},{$fld_weight},{$fld_name}";
        //---------------------------------------------------
        $result = $xoopsDB->query($sql);
/*
 //if ($this->mid==42){
 echo "<hr>{$this->mid}<br>{$sql}- {$table} <pre>" . print_r($result, true) . "</pre><hr>";
if ($table == 'creaquiz_categories'){          //tdmdownloads_cat
 exit;
 }        
*/
        //ajoute "toutes les categories" en tête de liste
        if($this->showAllCatLib){
            $catItems = array();
                $t['id'] = -1;
                $t['lib'] = $captionAll;
                $t['url'] = $moduleUrl . "/" . $catPage;
            $catItems[-1] = $t;
        }
            
        // tot do : filtrer selon les autorisations de groupes
        $parentId = 0;
        $url = "{$moduleUrl}/{$catPage}?{$catParamName}=";
                
        while ($topic = $xoopsDB->fetchArray($result)) {   
            if($topic[$fld_active]){
              $id =  $topic[$fld_id];
              $parentId =  $topic[$fld_pid];
              
              $item = array();
              $item['id'] = $id;
              $item['lib'] = $this->parse_title($topic[$fld_name], $sepTitle) ;
              $item['url'] = $url . $id;
              //----------------------------------------
              
              if ($topic[$fld_pid] > 0){
                if(isset($catItems[$parentId]))
                $catItems[$parentId]['submenu'][$id] = $item;
              }else{
                $catItems[$id] = $item;
                //$parentId = $id;
              }
            }
        }
        
//         if ($this->moduleDirName == 'news')
//         echo "<hr>{$this->mid} - {$this->moduleDirName} - {$table} <pre>" . print_r($catItems, true) . "</pre><hr>";
                
    return $catItems;
}    

/****************
*
 ***************/
function addCommonOptions(&$block){
    //ajout du titre du menu
    $block['module']['url'] = "modules/{$this->moduleDirName}";
    $block['module']['lib'] = constant(strtoupper("_MB_SLD_{$this->moduleDirName}_CAPTION"));
    $block['module']['mid'] = $this->mid;

    // --- Admin du module
//     if ($this->showAdminmodule){
//        if ($this->isPermAdmin()) {
//           $block['main']['admin_module']['url'] = XOOPS_ROOT_PATH . "/modules/{$this->moduleDirName}/admin/index.php";
//           $block['main']['admin_module']['lib'] = _MB_SLD_ADMIN_MODULE;
//        } 
//     }
    
    if (!$this->showMainMenu) unset($block['main']);

}

} // Fin de la Class
