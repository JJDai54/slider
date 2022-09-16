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
if (!\defined('XOOPS_ICONS32_PATH')) {
    define('XOOPS_ICONS32_PATH', XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
}
if (!\defined('XOOPS_ICONS32_URL')) {
    define('XOOPS_ICONS32_URL', XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
}

define('SLIDER_SHOW_TPL_NAME', 0);

define('SLIDER_DIRNAME', 'slider');
define('SLIDER_PATH', XOOPS_ROOT_PATH . '/modules/' . SLIDER_DIRNAME);
define('SLIDER_URL', XOOPS_URL . '/modules/' . SLIDER_DIRNAME);
define('SLIDER_ICONS_PATH', SLIDER_PATH . '/assets/icons');
define('SLIDER_ICONS_URL', SLIDER_URL . '/assets/icons');
define('SLIDER_IMAGE_PATH', SLIDER_PATH . '/assets/images');
define('SLIDER_IMAGE_URL', SLIDER_URL . '/assets/images');
define('SLIDER_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . SLIDER_DIRNAME);
define('SLIDER_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . SLIDER_DIRNAME);
define('SLIDER_UPLOAD_FILES_PATH', SLIDER_UPLOAD_PATH . '/files');
define('SLIDER_UPLOAD_FILES_URL', SLIDER_UPLOAD_URL . '/files');
define('SLIDER_UPLOAD_IMAGE_PATH', SLIDER_UPLOAD_PATH . '/images');
define('SLIDER_UPLOAD_IMAGE_URL', SLIDER_UPLOAD_URL . '/images');
define('SLIDER_UPLOAD_SHOTS_PATH', SLIDER_UPLOAD_PATH . '/images/shots');
define('SLIDER_UPLOAD_SHOTS_URL', SLIDER_UPLOAD_URL . '/images/shots');
define('SLIDER_ADMIN', SLIDER_URL . '/admin/index.php');
define('SLIDER_THEMES_PATH',SLIDER_PATH . "/templates/admin");

$localLogo = SLIDER_IMAGE_URL . '/jjdai_logo.png';
// Module Information
$copyright = "<a href='http://jubile.fr' title='Origami du monde' target='_blank'><img src='" . $localLogo . "' alt='Origami du monde' /></a>";
include_once XOOPS_ROOT_PATH . '/class/xoopsrequest.php';
include_once SLIDER_PATH . '/include/functions.php';
include_once SLIDER_PATH . '/include/fnc-slider.php';

define ('_SLD_PERIODICITY_MAJ_NEVER',     'j'); // Jamais
define ('_SLD_PERIODICITY_MAJ_RANDOM',    'r'); // Random
define ('_SLD_PERIODICITY_MAJ_MINUTE',    'n'); // Minute pour tester en dev
define ('_SLD_PERIODICITY_MAJ_HOUR',      'h'); // hour
define ('_SLD_PERIODICITY_MAJ_DAY',       'd'); // day
define ('_SLD_PERIODICITY_MAJ_WEEK',      'w'); // week
define ('_SLD_PERIODICITY_MAJ_MONTH',     'm'); // month
define ('_SLD_PERIODICITY_MAJ_BIMONTLY',  'b'); // bimestre
define ('_SLD_PERIODICITY_MAJ_QUATER',    'q'); // trimestre
define ('_SLD_PERIODICITY_MAJ_SEMESTER',  's'); // semestre
define ('_SLD_PERIODICITY_MAJ_YEAR',      'y'); // year

//define('pathModuleAdmin', SLIDER_URL . $pathModuleAdmin);
define ('_SLD_PERIODICITY_ALL',      0); // tout
define ('_SLD_PERIODICITY_ALWAYS',   1); // toujurs
define ('_SLD_PERIODICITY_FLOAT',    2); // periode flottante
define ('_SLD_PERIODICITY_WEEK',     3); // week
define ('_SLD_PERIODICITY_MONTH',    4); // month
define ('_SLD_PERIODICITY_BIMONTLY', 5); // bimestre
define ('_SLD_PERIODICITY_QUATER',   6); // trimestre
define ('_SLD_PERIODICITY_SEMESTER', 7); // semestre
define ('_SLD_PERIODICITY_YEAR',     8); // year

define ('_SLD_SURCHARGE_CSS_FILLE_NAME', 'my_css.css'); //my_xoops
