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
 * Slider module for xoops
 *
 * @param mixed      $module
 * @param null|mixed $prev_version
 * @package        Slider
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 update.php 1 Mon 2018-03-19 10:04:53Z XOOPS Project (www.xoops.org) $
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 */

/**
 * @param      $module
 * @param null $prev_version
 *
 * @return bool|null
 */
function xoops_module_update_slider($module, $prev_version = null)
{
    $ret = null;
    if ($prev_version < 10) {
        $ret = update_slider_v10($module);
    }
    
    if ($prev_version < 214) {
        $ret = update_slider_v214($module);
    }

//-------------------------------------------------------------------
        $items = array();

        require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
        $file_path = XOOPS_ROOT_PATH . '/modules/' . $module->getVar('dirname') . '/versions/';
        $extensions = array("php");
        $files = XoopsLists::getFileListByExtension($file_path, $extensions);
        asort($files);
/*
*/        
        foreach($files AS $k=>$v){
            $shortname = str_replace('.php', '', $v);
            $t = explode('_', $shortname);
            $newVersion = ($t[1] * 100) + $t[2];
            //$files[$k] = $newVersion; 
            if ($prev_version < $newVersion) {
              echo "actuelle = {$prev_version}  - version maj : {$v} = {$newVersion}<br>";
              $name = ucfirst($shortname);
              $f    = $file_path . $v;
              //ext_echo ("Fichier : {$f}<hr>");
              if (is_readable($f)) {
                  //echo "mise � jour version : {$key} = {$val}<br>";
                  require_once $f;
                  $cl = new $name($module, ['previousVersion' => $prev_version]);
              }
            }
            
        }
        
        /* pour test
        $name = "Slider_X_XX";
        $f = $file_path . $name . ".php";
        echo "<hr>{$f}<hr>";
        require_once $f;
        $cl = new $name($module, ['previousVersion' => $prev_version]);
        */        
/*
echo "<hr><pre>" . print_r($files, true) . "</pre><hr>";
exit;
//-------------------------------------------------------------------
    $fld = XOOPS_ROOT_PATH . '/modules/' . $module->getVar('dirname') . '/versions/';
    $cls = 'Slider_%1$s';

    $version = [
        '1_80' => 180,
        '2_02' => 202,
        '2_03' => 203,
    ];

    //    while (list($key, $val) = each($version)) {
    foreach ($version as $key => $val) {
        if ($prev_version < $val) {
            echo "actuelle = {$prev_version}  - version maj : {$key} = {$val}<br>";
            $name = ucfirst(sprintf($cls, $key));
            $f    = $fld . $name . '.php';
            //ext_echo ("Fichier : {$f}<hr>");
            if (is_readable($f)) {
                //echo "mise � jour version : {$key} = {$val}<br>";
                require_once $f;
                $cl = new $name($module, ['previousVersion' => $prev_version]);
            }
        }
    }


*/






//-------------------------------------------------------------------



    $ret = slider_check_db($module);

    //check upload directory
    include_once __DIR__ . '/install.php';
    $ret = xoops_module_install_slider($module);

    $errors = $module->getErrors();
    if (!empty($errors)) {
        print_r($errors);
    }

    return $ret;

}

// irmtfan bug fix: solve templates duplicate issue
/**
 * @param $module
 *
 * @return bool
 */
 
 

// irmtfan bug fix: solve templates duplicate issue
/**
 * @param $module
 *
 * @return bool
 */
 
 
function update_slider_v10($module)
{
    global $xoopsDB;
    $result = $xoopsDB->query(
        'SELECT t1.tpl_id FROM ' . $xoopsDB->prefix('tplfile') . ' t1, ' . $xoopsDB->prefix('tplfile') . ' t2 WHERE t1.tpl_refid = t2.tpl_refid AND t1.tpl_module = t2.tpl_module AND t1.tpl_tplset=t2.tpl_tplset AND t1.tpl_file = t2.tpl_file AND t1.tpl_type = t2.tpl_type AND t1.tpl_id > t2.tpl_id'
    );
    $tplids = [];
    while (false !== (list($tplid) = $xoopsDB->fetchRow($result))) {
        $tplids[] = $tplid;
    }
    if (\count($tplids) > 0) {
        $tplfileHandler  = \xoops_getHandler('tplfile');
        $duplicate_files = $tplfileHandler->getObjects(new \Criteria('tpl_id', '(' . \implode(',', $tplids) . ')', 'IN'));

        if (\count($duplicate_files) > 0) {
            foreach (\array_keys($duplicate_files) as $i) {
                $tplfileHandler->delete($duplicate_files[$i]);
            }
        }
    }
    $sql = 'SHOW INDEX FROM ' . $xoopsDB->prefix('tplfile') . " WHERE KEY_NAME = 'tpl_refid_module_set_file_type'";
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);

        return false;
    }
    $ret = [];
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[] = $myrow;
    }
    if (!empty($ret)) {
        $module->setErrors("'tpl_refid_module_set_file_type' unique index is exist. Note: check 'tplfile' table to be sure this index is UNIQUE because XOOPS CORE need it.");

        return true;
    }
    $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tplfile') . ' ADD UNIQUE tpl_refid_module_set_file_type ( tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_type )';
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);
        $module->setErrors("'tpl_refid_module_set_file_type' unique index is not added to 'tplfile' table. Warning: do not use XOOPS until you add this unique index.");

        return false;
    }

    return true;
}

// irmtfan bug fix: solve templates duplicate issue

/**
 * @param $module
 *
 * @return bool
 */
function slider_check_db($module)
{
    $ret = true;
    //insert here code for database check

    /*
    // Example: update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('slider_images');
    $field   = 'img_exif';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` TEXT NULL AFTER `img_state`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // Example: create new table
    $table   = $GLOBALS['xoopsDB']->prefix('slider_categories');
    $check   = $GLOBALS['xoopsDB']->queryF("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        // create new table 'slider_categories'
        $sql = "CREATE TABLE `$table` (
                  `cat_id`        INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `cat_text`      VARCHAR(100)    NOT NULL DEFAULT '',
                  `cat_date`      INT(8)          NOT NULL DEFAULT '0',
                  `cat_submitter` INT(8)          NOT NULL DEFAULT '0',
                  PRIMARY KEY (`cat_id`)
                ) ENGINE=InnoDB;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when creating table '$table'.");
            $ret = false;
        }
    }
    */
    return $ret;
}

/**
 * @param $module
 *
 * @return bool
 */
function update_slider_v214($module)
{
    global $xoopsDB;

    $sql = "UPDATE " . $xoopsDB->prefix('tplfile') . " SET sld_periodicity = sld_periodicity  + 1 ;";
    $result = $xoopsDB->query($sql);
    return $result;
    
}
