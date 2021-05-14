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

include_once 'common.php';

// ---------------- Admin Main ----------------
\define('_MI_SLIDER_NAME', 'slider - Gestion des Slides');
\define('_MI_SLIDER_DESC', 'Ce module permet de gérer l\'affichage des slides, Ajout, durée d\'affichage, ordre, ...');
// ---------------- Admin Menu ----------------
\define('_MI_SLIDER_ADMENU1', 'Tableau de bord');
\define('_MI_SLIDER_ADMENU2', 'Slides');
\define('_MI_SLIDER_ADMENU3', 'Retour');
\define('_MI_SLIDER_ABOUT', 'A propos');
// ---------------- Admin Nav ----------------
\define('_MI_SLIDER_ADMIN_PAGER', 'Admin pages');
\define('_MI_SLIDER_ADMIN_PAGER_DESC', 'Admin par liste de pages');
// Blocks
\define('_MI_SLIDER_SLIDES_BLOCK', 'Slides block');
\define('_MI_SLIDER_SLIDES_BLOCK_DESC', 'Slides block description');
\define('_MI_SLIDER_SLIDES_BLOCK_SLIDE', 'Slides block  SLIDE');
\define('_MI_SLIDER_SLIDES_BLOCK_SLIDE_DESC', 'Slides block  SLIDE description');
\define('_MI_SLIDER_SLIDES_BLOCK_LAST', 'Slides block last');
\define('_MI_SLIDER_SLIDES_BLOCK_LAST_DESC', 'Slides block last description');
\define('_MI_SLIDER_SLIDES_BLOCK_NEW', 'Slides block new');
\define('_MI_SLIDER_SLIDES_BLOCK_NEW_DESC', 'Slides block new description');
\define('_MI_SLIDER_SLIDES_BLOCK_HITS', 'Slides block hits');
\define('_MI_SLIDER_SLIDES_BLOCK_HITS_DESC', 'Slides block hits description');
\define('_MI_SLIDER_SLIDES_BLOCK_TOP', 'Slides block top');
\define('_MI_SLIDER_SLIDES_BLOCK_TOP_DESC', 'Slides block top description');
\define('_MI_SLIDER_SLIDES_BLOCK_RANDOM', 'Slides block random');
\define('_MI_SLIDER_SLIDES_BLOCK_RANDOM_DESC', 'Slides block random description');
// Config
\define('_MI_SLIDER_EDITOR_ADMIN', 'Editor admin');
\define('_MI_SLIDER_EDITOR_ADMIN_DESC', 'Select the editor which should be used in admin area for text area fields');
\define('_MI_SLIDER_EDITOR_USER', 'Editor user');
\define('_MI_SLIDER_EDITOR_USER_DESC', 'Select the editor which should be used in user area for text area fields');
\define('_MI_SLIDER_EDITOR_MAXCHAR', 'Text max characters');
\define('_MI_SLIDER_EDITOR_MAXCHAR_DESC', 'Max characters for showing text of a textarea or editor field in admin area');
\define('_MI_SLIDER_KEYWORDS', 'Keywords');
\define('_MI_SLIDER_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
\define('_MI_SLIDER_SIZE_MB', 'MB');
\define('_MI_SLIDER_MAXSIZE_IMAGE', 'Max size image');
\define('_MI_SLIDER_MAXSIZE_IMAGE_DESC', 'Define the max size for uploading images');
\define('_MI_SLIDER_MIMETYPES_IMAGE', 'Mime types image');
\define('_MI_SLIDER_MIMETYPES_IMAGE_DESC', 'Define the allowed mime types for uploading images');
\define('_MI_SLIDER_MAXWIDTH_IMAGE', 'Max width image');
\define('_MI_SLIDER_MAXWIDTH_IMAGE_DESC', 'Set the max width to which uploaded images should be scaled (in pixel)<br>0 means, that images keeps the original size. <br>If an image is smaller than maximum value then the image will be not enlarge, it will be save in original width.');
\define('_MI_SLIDER_MAXHEIGHT_IMAGE', 'Max height image');
\define('_MI_SLIDER_MAXHEIGHT_IMAGE_DESC', 'Set the max height to which uploaded images should be scaled (in pixel)<br>0 means, that images keeps the original size. <br>If an image is smaller than maximum value then the image will be not enlarge, it will be save in original height');
\define('_MI_SLIDER_NUMB_COL', 'Number Columns');
\define('_MI_SLIDER_NUMB_COL_DESC', 'Number Columns to View.');
\define('_MI_SLIDER_DIVIDEBY', 'Divide By');
\define('_MI_SLIDER_DIVIDEBY_DESC', 'Divide by columns number.');
\define('_MI_SLIDER_TABLE_TYPE', 'Table Type');
\define('_MI_SLIDER_TABLE_TYPE_DESC', 'Table Type is the slider html table.');
\define('_MI_SLIDER_PANEL_TYPE', 'Panel Type');
\define('_MI_SLIDER_PANEL_TYPE_DESC', 'Panel Type is the slider html div.');
\define('_MI_SLIDER_IDPAYPAL', 'Paypal ID');
\define('_MI_SLIDER_IDPAYPAL_DESC', 'Insert here your PayPal ID for donactions.');
\define('_MI_SLIDER_ADVERTISE', 'Advertisement Code');
\define('_MI_SLIDER_ADVERTISE_DESC', 'Insert here the advertisement code');
\define('_MI_SLIDER_MAINTAINEDBY', 'Maintained By');
\define('_MI_SLIDER_MAINTAINEDBY_DESC', 'Allow url of support site or community');
\define('_MI_SLIDER_BOOKMARKS', 'Social Bookmarks');
\define('_MI_SLIDER_BOOKMARKS_DESC', 'Show Social Bookmarks in the single page');
\define('_MI_SLIDER_FACEBOOK_COMMENTS', 'Facebook comments');
\define('_MI_SLIDER_FACEBOOK_COMMENTS_DESC', 'Allow Facebook comments in the single page');
\define('_MI_SLIDER_DISQUS_COMMENTS', 'Disqus comments');
\define('_MI_SLIDER_DISQUS_COMMENTS_DESC', 'Allow Disqus comments in the single page');

// JJDai
\define('_MI_SLIDER_UPDATE_THEME', 'slider_update_tpl');
\define('_MI_SLIDER_UPDATE_THEME_DESC', 'Block de mise jour de slider.tpl du thème en cours');

// ---------------- End ----------------
