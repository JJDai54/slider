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


use XoopsModules\Slider\Common;

include_once \dirname(__DIR__) . '/preloads/autoloader.php';
require __DIR__ . '/header.php';

// Template Index
$templateMain = 'slider_admin_index.tpl';

// Count elements
$countSlides = $slidesHandler->getCount();

/***********************************************/
// InfoBox Statistics
$adminObject->addInfoBox(_AM_SLIDER_STATISTICS);
// Info elements
$adminObject->addInfoBoxLine(\sprintf( '<label>' . _AM_SLIDER_THEREARE_SLIDES . '</label>', $countSlides));

/***********************************************/
// traitements
$adminObject->addInfoBox(_AM_SLIDER_TRAITEMENTS);
// Info elements
$traitement = sprintf("<label>%s</label> : <a href='%s'>%s</a>", _AM_SLIDER_CLEAN_DIR, "traitements.php?op=clean_themes_dir", _AM_SLIDER_CLEAN_DIR_DESC);
$adminObject->addInfoBoxLine($traitement);

$traitement = sprintf("<label>%s</label> : <a href='%s'>%s</a>", _AM_SLIDER_BLOCK, "traitements.php?op=activate_block", _AM_SLIDER_BLOCK_DESC);
$adminObject->addInfoBoxLine($traitement);
/***********************************************/

// Upload Folders
$configurator = new Common\Configurator();
if ($configurator->uploadFolders && \is_array($configurator->uploadFolders)) {
	foreach (\array_keys($configurator->uploadFolders) as $i) {
		$folder[] = $configurator->uploadFolders[$i];
	}
}
// Uploads Folders Created
foreach (\array_keys($folder) as $i) {
	$adminObject->addConfigBoxLine($folder[$i], 'folder');
	$adminObject->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
}

// Render Index
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('index.php'));
// Test Data
if ($helper->getConfig('displaySampleButton')) {
	\xoops_loadLanguage('admin/modulesadmin', 'system');
	include_once \dirname(__DIR__) . '/testdata/index.php';
	$adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_ADD_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=load', 'add');
	$adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_SAVE_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=save', 'add');
//	$adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_EXPORT_SCHEMA'), '__DIR__ . /../../testdata/index.php?op=exportschema', 'add');
	$adminObject->displayButton('left');
}
$GLOBALS['xoopsTpl']->assign('index', $adminObject->displayIndex());
// End Test Data
require __DIR__ . '/footer.php';
