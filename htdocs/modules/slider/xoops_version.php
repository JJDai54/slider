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

// 
$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);
// ------------------- Informations ------------------- //
$modversion = [
    'name'                => _MI_SLIDER_NAME,
    'version'             => 2.20,
    'release_date'        => '2022/05/09',
    'release'             => '',
    'module_status'       => 'Beta 1',
    'description'         => _MI_SLIDER_DESC,
    'author'              => 'JJDai',
    'author_mail'         => 'jjdelalandre@orange.fr',
    'author_website_url'  => 'http://jubile.fr',
    'author_website_name' => 'Origami du monde',
    'credits'             => 'XOOPS Development Team',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'http://www.gnu.org/licenses/gpl-3.0.en.html',
    'help'                => 'page=help',
    'release_info'        => 'release_info',
    'release_file'        => XOOPS_URL . '/modules/slider/docs/release_info file',
    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . '/modules/slider/docs/install.txt',
    'min_php'             => '5.5',
    'min_xoops'           => '2.5.9',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5', 'mysqli' => '5.5'],
    'image'               => 'assets/images/logoModule.png',
    'dirname'             => \basename(__DIR__),
    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    'sysicons16'          => '../../Frameworks/moduleclasses/icons/16',
    'sysicons32'          => '../../Frameworks/moduleclasses/icons/32',
    'modicons16'          => 'assets/icons/16',
    'modicons32'          => 'assets/icons/32',
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'hasMain'             => 0,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    'onInstall'           => 'include/install.php',
    'onUninstall'         => 'include/uninstall.php',
    'onUpdate'            => 'include/update.php',
];
// ------------------- Templates ------------------- //
$modversion['templates'] = [
    // Admin templates
    ['file' => 'slider_theme_xbootstrap_3.tpl', 'description' => 'Generation du nouveau tpl pour les themes bootstrap 3', 'type' => 'admin'],
    ['file' => 'slider_theme_xbootstrap_4.tpl', 'description' => 'Generation du nouveau tpl pour les themes bootstrap 4', 'type' => 'admin'],
    ['file' => 'slider_admin_about.tpl',  'description' => '', 'type' => 'admin'],
    ['file' => 'slider_admin_header.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'slider_admin_index.tpl',  'description' => '', 'type' => 'admin'],
    ['file' => 'slider_admin_slides.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'slider_admin_themes.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'slider_admin_styles.tpl', 'description' => '', 'type' => 'admin'],    
    ['file' => 'slider_admin_footer.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'slider_admin_logo.tpl',   'description' => '', 'type' => 'admin'],
    ['file' => 'slider_menu_xbootstrap_main.tpl', 'description' => '', 'type' => ''],
    ['file' => 'slider_menu_xswatch4_main.tpl',   'description' => '', 'type' => ''],


    // User templates
//     ['file' => 'slider_header.tpl', 'description' => ''],
//     ['file' => 'slider_index.tpl', 'description' => ''],
//     ['file' => 'slider_breadcrumbs.tpl', 'description' => ''],
//     ['file' => 'slider_footer.tpl', 'description' => ''],
];


// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'] = [
    'slider_slides',
    'slider_themes',
];
// ------------------- Blocks ------------------- //
$modversion['blocks'][] = [
    'file'        => 'update_theme_slides.php',
    'name'        => _AM_SLIDER_RANDOM_SLIDER,
    'description' => _AM_SLIDER_RANDOM_SLIDER_DESC,
    'show_func'   => 'b_slider_update_theme_slides_show',
    'edit_func'   => 'b_slider_update_theme_slides_edit', 
    'template'    => 'slider_block_update_theme_slides.tpl',
    'options'     => '',
];

$modversion['blocks'][] = [
    'file'        => 'verif_slides_of_theme.php',
    'name'        => _MI_SLIDER_VERIF_SLIDES_OF_THEME,
    'description' => _MI_SLIDER_VERIF_SLIDES_OF_THEME_DESC,
    'show_func'   => 'b_slider_verif_slides_of_theme_show',
    'edit_func'   => 'b_slider_verif_slides_of_theme_edit', //
    'template'    => 'slider_block_slides_of_theme.tpl',
    'options'     => '',
];
$modversion['blocks'][] = [
    'file'        => 'menu_manager.php',
    'name'        => _MI_SLIDER_MENU_MANAGER,
    'description' => _MI_SLIDER_MENU_MANAGER_DESC,
    'show_func'   => 'b_slider_menu_manager_show',
    'edit_func'   => 'b_slider_menu_manager_edit', //
    'template'    => 'slider_menu_manager.tpl',
    'options'     => '', //option a definir dans nav_menu.tpl : moduleDirName|theme|level|sens
];

$modversion['blocks'][] = [
    'file'        => 'surcharge_theme.php',
    'name'        => _MI_SLIDER_SURCHARGE_THEME,
    'description' => _MI_SLIDER_SURCHARGE_THEME_DESC,
    'show_func'   => 'b_slider_surcharge_theme_show',
    'edit_func'   => 'b_slider_surcharge_theme_edit', 
    'template'    => 'slider_surcharge_theme.tpl',
    'options'     => '', //option a definir dans nav_menu.tpl : moduleDirName|theme|level|sens
];


/*
*/


// ------------------- Config ------------------- //
// Editor Admin
\xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
    'name'        => 'editor_admin',
    'title'       => '_MI_SLIDER_EDITOR_ADMIN',
    'description' => '_MI_SLIDER_EDITOR_ADMIN_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtml',
    'options'     => array_flip($editorHandler->getList()),
];

/*
// Editor : max characters admin area
$modversion['config'][] = [
    'name'        => 'editor_maxchar',
    'title'       => '_MI_SLIDER_EDITOR_MAXCHAR',
    'description' => '_MI_SLIDER_EDITOR_MAXCHAR_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 50,
];
// Keywords
$modversion['config'][] = [
    'name'        => 'keywords',
    'title'       => '_MI_SLIDER_KEYWORDS',
    'description' => '_MI_SLIDER_KEYWORDS_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'slider, slides',
];
*/

// create increment steps for file size
include_once __DIR__ . '/include/xoops_version.inc.php';
$iniPostMaxSize       = sliderReturnBytes(\ini_get('post_max_size'));
$iniUploadMaxFileSize = sliderReturnBytes(\ini_get('upload_max_filesize'));
$maxSize              = min($iniPostMaxSize, $iniUploadMaxFileSize);
if ($maxSize > 10000 * 1048576) {
    $increment = 500;
}
if ($maxSize <= 10000 * 1048576) {
    $increment = 200;
}
if ($maxSize <= 5000 * 1048576) {
    $increment = 100;
}
if ($maxSize <= 2500 * 1048576) {
    $increment = 50;
}
if ($maxSize <= 1000 * 1048576) {
    $increment = 10;
}
if ($maxSize <= 500 * 1048576) {
    $increment = 5;
}
if ($maxSize <= 100 * 1048576) {
    $increment = 2;
}
if ($maxSize <= 50 * 1048576) {
    $increment = 1;
}
if ($maxSize <= 25 * 1048576) {
    $increment = 0.5;
}
$optionMaxsize = [];
$i = $increment;
while ($i * 1048576 <= $maxSize) {
    $optionMaxsize[$i . ' ' . _MI_SLIDER_SIZE_MB] = $i * 1048576;
    $i += $increment;
}
// Uploads : maxsize of image
$modversion['config'][] = [
    'name'        => 'maxsize_image',
    'title'       => '_MI_SLIDER_MAXSIZE_IMAGE',
    'description' => '_MI_SLIDER_MAXSIZE_IMAGE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 3145728,
    'options'     => $optionMaxsize,
];
// Uploads : mimetypes of image
$modversion['config'][] = [
    'name'        => 'mimetypes_image',
    'title'       => '_MI_SLIDER_MIMETYPES_IMAGE',
    'description' => '_MI_SLIDER_MIMETYPES_IMAGE_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['image/gif', 'image/jpeg', 'image/png'],
    'options'     => ['bmp' => 'image/bmp','gif' => 'image/gif','pjpeg' => 'image/pjpeg', 'jpeg' => 'image/jpeg','jpg' => 'image/jpg','jpe' => 'image/jpe', 'png' => 'image/png'],
];
$modversion['config'][] = [
    'name'        => 'maxwidth_image',
    'title'       => '_MI_SLIDER_MAXWIDTH_IMAGE',
    'description' => '_MI_SLIDER_MAXWIDTH_IMAGE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 1920,
];
$modversion['config'][] = [
    'name'        => 'maxheight_image',
    'title'       => '_MI_SLIDER_MAXHEIGHT_IMAGE',
    'description' => '_MI_SLIDER_MAXHEIGHT_IMAGE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 500,
];
// Admin pager
$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => '_MI_SLIDER_ADMIN_PAGER',
    'description' => '_MI_SLIDER_ADMIN_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];
// Admin framework highslide
$modversion['config'][] = [
    'name'        => 'highslide',
    'title'       => '_MI_SLIDER_HIGHSLIDE',
    'description' => '_MI_SLIDER_HIGHSLIDE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'string',
    'default'     => 'highslide', //highslide-5.0.0
];
//Force la reconstruction du template des slide
$modversion['config'][] = [
    'name'        => 'forceRebuildSlides',
    'title'       => '_MI_SLIDER_REBUILD',
    'description' => '_MI_SLIDER_REBUILD_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
/*
//-------------------------------------------------------
//css defaut pour les titres soustitres et boutons
//extra - code à ajouter dans le template
$modversion['config'][] = [
    'name'        => 'slider_style_title',
    'title'       => '_MI_STYLE_TITLE',
    'description' => '_MI_STYLE_TITLE_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => "color:#496381;
background:#E1D6C9;
opacity: 0.8;
padding: 0px 25px 0px 25px;
border-radius: 50px 50px 50px 50px;
margin-left:250px;
margin-right:250px;
margin-bottom:15px;",
];

//extra - code à ajouter dans le template
$modversion['config'][] = [
    'name'        => 'slider_style_subtitle',
    'title'       => '_MI_STYLE_SUBTITLE',
    'description' => '_MI_STYLE_SUBTITLE_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => "color : #496381;
background : #E1D6C9;
opacity : 0.8;
padding : 25px;
border-radius : 50px 50px 50px 50px;
margin-left : 250px;
margin-right : 250px;
padding-bottom : 5px;
padding-top : 5px;",
];

//extra - code à ajouter dans le template
$modversion['config'][] = [
    'name'        => 'slider_style_button',
    'title'       => '_MI_STYLE_BUTTON',
    'description' => '_MI_STYLE_BUTTON_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => "color:#496381;
background:#E1D6C9;
opacity: 0.9;
padding:25px;
border-radius: 50px 50px 50px 50px;
margin-left:250px;
margin-right:250px;
padding-bottom : 5px;
padding-top : 5px;",
];
*/
//-------------------------------------------------------
//extra - code à ajouter dans le template
$modversion['config'][] = [
    'name'        => 'slider_style_points',
    'title'       => '_MI_STYLE_POINTS',
    'description' => '_MI_STYLE_POINTS_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => "width: 20px;
 height: 20px;
 margin: 2px;
 background-color: rgba(0, 0, 0, 0);
 border: 0px solid #f00;
 border-radius: 20px;

 animation-duration: 12s;
 animation-iteration-count: infinite;
 transition: none;",
];

//extra - code à ajouter dans le template
$modversion['config'][] = [
    'name'        => 'slider_style_clignotement',
    'title'       => '_MI_STYLE_POINTS_FLASH',
    'description' => '_MI_STYLE_POINTS_FLASH_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => "0%   { opacity:1;background:white; }
25%   {opacity:1;background:blue; }
50% { opacity:1;background:yellow; }
75% { opacity:1;background:green; }
100%   { opacity:1;background:white; }",

];

//extra - code à ajouter dans le template
$modversion['config'][] = [
    'name'        => 'slider_style_point_active',
    'title'       => '_MI_STYLE_POINTS_ACTIVE',
    'description' => '_MI_STYLE_POINTS_ACTIVE_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => "width: 22px;
 height: 32px;
 margin: 0;
 background-color: #0000ff;",
];

//extra - code à ajouter dans le template
$modversion['config'][] = [
    'name'        => 'slider-extra',
    'title'       => '_MI_SLIDER_EXTRA',
    'description' => '_MI_SLIDER_EXTRA_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '',
];

/*
// Number column
$modversion['config'][] = [
    'name'        => 'numb_col',
    'title'       => '_MI_SLIDER_NUMB_COL',
    'description' => '_MI_SLIDER_NUMB_COL_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
    'options'     => [1 => '1', 2 => '2', 3 => '3', 4 => '4'],
];
// Divide by
$modversion['config'][] = [
    'name'        => 'divideby',
    'title'       => '_MI_SLIDER_DIVIDEBY',
    'description' => '_MI_SLIDER_DIVIDEBY_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
    'options'     => [1 => '1', 2 => '2', 3 => '3', 4 => '4'],
];
// Table type
$modversion['config'][] = [
    'name'        => 'table_type',
    'title'       => '_MI_SLIDER_TABLE_TYPE',
    'description' => '_MI_SLIDER_DIVIDEBY_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 'bordered',
    'options'     => ['bordered' => 'bordered', 'striped' => 'striped', 'hover' => 'hover', 'condensed' => 'condensed'],
];
// Panel by
$modversion['config'][] = [
    'name'        => 'panel_type',
    'title'       => '_MI_SLIDER_PANEL_TYPE',
    'description' => '_MI_SLIDER_PANEL_TYPE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'default',
    'options'     => ['default' => 'default', 'primary' => 'primary', 'success' => 'success', 'info' => 'info', 'warning' => 'warning', 'danger' => 'danger'],
];
// Advertise
$modversion['config'][] = [
    'name'        => 'advertise',
    'title'       => '_MI_SLIDER_ADVERTISE',
    'description' => '_MI_SLIDER_ADVERTISE_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '',
];
// Bookmarks
$modversion['config'][] = [
    'name'        => 'bookmarks',
    'title'       => '_MI_SLIDER_BOOKMARKS',
    'description' => '_MI_SLIDER_BOOKMARKS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
// Make Sample button visible?
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_SLIDER_SHOW_SAMPLE_BUTTON',
    'description' => 'CO_SLIDER_SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Maintained by
$modversion['config'][] = [
    'name'        => 'maintainedby',
    'title'       => '_MI_SLIDER_MAINTAINEDBY',
    'description' => '_MI_SLIDER_MAINTAINEDBY_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'https://xoops.org/modules/newbb',
];


*/