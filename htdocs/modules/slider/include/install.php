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
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        Slider
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com> XOOPS Project (www.xoops.org) $
 */

use XoopsModules\Slider;
use XoopsModules\Slider\Common;

/**
 * @param \XoopsModule $module
 * @return bool
 */
function xoops_module_pre_install_slider(\XoopsModule $module)
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';
    /** @var Slider\Utility $utility */
    $utility = new Slider\Utility();

    //check for minimum XOOPS version
    $xoopsSuccess = $utility::checkVerXoops($module);

    // check for minimum PHP version
    $phpSuccess = $utility::checkVerPhp($module);

    if ($xoopsSuccess && $phpSuccess) {
        $moduleTables = &$module->getInfo('tables');
        foreach ($moduleTables as $table) {
            $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
        }
    }

    return $xoopsSuccess && $phpSuccess;
}

/**
 * @param \XoopsModule $module
 * @return bool|string
 */
function xoops_module_install_slider(\XoopsModule $module)
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';

    /** @var Slider\Helper $helper */ 
    /** @var Slider\Utility $utility */
    /** @var Common\Configurator $configurator */
    $helper       = Slider\Helper::getInstance();
    $utility      = new Slider\Utility();
    $configurator = new Common\Configurator();

    // Load language files
    $helper->loadLanguage('admin');
    $helper->loadLanguage('modinfo');
    $helper->loadLanguage('common');

    //  ---  CREATE FOLDERS ---------------
    if ($configurator->uploadFolders && \is_array($configurator->uploadFolders)) {
        //    foreach (\array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (\array_keys($configurator->uploadFolders) as $i) {
            $utility::createFolder($configurator->uploadFolders[$i]);
chmod($configurator->uploadFolders[$i], 0777);
        }
    }

    //  ---  COPY blank.gif FILES ---------------
    /* pas utile pour ce module  voir fichier config.php - JJDai */
 
    if ($configurator->copyBlankFiles && \is_array($configurator->copyBlankFiles)) {
        $file = \dirname(__DIR__) . '/assets/images/blank.gif';
        foreach (\array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.gif';
            $utility::copyFile($file, $dest);
        }
        $file = \dirname(__DIR__) . '/assets/images/blank.png';
        foreach (\array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.png';
            $utility::copyFile($file, $dest);
        }
    }

    return true;
}
