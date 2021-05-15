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

include_once __DIR__ . '/common.php';
include_once __DIR__ . '/main.php';

// ---------------- Admin Index ----------------
\define('_AM_SLIDER_STATISTICS', 'Statistics');
// There are
\define('_AM_SLIDER_THEREARE_SLIDES', "There are <span class='bold'>%s</span> slides in the database");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_SLIDER_THEREARENT_SLIDES', "There aren't slides");
// Save/Delete
\define('_AM_SLIDER_FORM_OK', 'Successfully saved');
\define('_AM_SLIDER_FORM_DELETE_OK', 'Successfully deleted');
\define('_AM_SLIDER_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_AM_SLIDER_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
// Buttons
\define('_AM_SLIDER_ADD_SLIDE', 'Add New Slide');
// Lists
\define('_AM_SLIDER_SLIDES_LIST', 'List of Slides');
// ---------------- Admin Classes ----------------
// Slide add/edit
\define('_AM_SLIDER_SLIDE_ADD', 'Add Slide');
\define('_AM_SLIDER_SLIDE_EDIT', 'Edit Slide');
// Elements of Slide
\define('_AM_SLIDER_SLIDE_ID', 'Id');
\define('_AM_SLIDER_SLIDE_TITLE', 'Title');
\define('_AM_SLIDER_SLIDE_DESCRIPTION', 'Description');
\define('_AM_SLIDER_SLIDE_WEIGHT', 'Weight');
\define('_AM_SLIDER_SLIDE_DATE_BEGIN', 'DateTime');
\define('_AM_SLIDER_SLIDE_DATE_END', 'DateTime');
\define('_AM_SLIDER_SLIDE_ACTIF', 'Actif');
\define('_AM_SLIDER_SLIDE_ACTIF_DESC', 'Activate or not the slide whatever the following options. This avoids deleting it to reuse it later');
\define('_AM_SLIDER_SLIDE_SELECT_THEME', "Select the theme to update");
\define('_AM_SLIDER_SLIDE_SELECT_THEME_DESC', "the original file 'slide.tlp' will be save with the extension '_old'");
\define('_AM_SLIDER_SLIDE_IMAGE', 'Image');
\define('_AM_SLIDER_SLIDE_IMAGE_UPLOADS', 'Image in %s :');
// General
\define('_AM_SLIDER_FORM_UPLOAD', 'Upload file');
\define('_AM_SLIDER_FORM_UPLOAD_NEW', 'Upload new file: ');
\define('_AM_SLIDER_FORM_UPLOAD_SIZE', 'Max file size: ');
\define('_AM_SLIDER_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_AM_SLIDER_FORM_UPLOAD_IMG_WIDTH', 'Max image width: ');
\define('_AM_SLIDER_FORM_UPLOAD_IMG_HEIGHT', 'Max image height: ');
\define('_AM_SLIDER_FORM_IMAGE_PATH', 'Files in %s :');
\define('_AM_SLIDER_FORM_ACTION', 'Action');
\define('_AM_SLIDER_FORM_EDIT', 'Modification');
\define('_AM_SLIDER_FORM_DELETE', 'Clear');
// ---------------- Admin Others ----------------
\define('_AM_SLIDER_SLIDE_HAS_PERIODE', 'Define a periode');
\define('_AM_SLIDER_SLIDE_HAS_PERIODE_DESC', 'No: Visible whatever the period defined and if "active" is true');
\define('_AM_SLIDER_ABOUT_MAKE_DONATION', 'Submit');
\define('_AM_SLIDER_SUPPORT_FORUM', 'Support Forum');
\define('_AM_SLIDER_DONATION_AMOUNT', 'Donation Amount');
\define('_AM_SLIDER_MAINTAINEDBY', ' is maintained by ');
\define('_AM_SLIDER_SLIDE_TO_LOAD', 'Selectionner le slide à télécharger ');
\define('_AM_SLIDER_SLIDE', 'Slide');
\define('_AM_SLIDER_UPLOADSIZE', "Taille maximum du slide %s mo");
\define('_AM_SLIDER_SLIDE_THEME', "Thème");
\define('_AM_SLIDER_CONTRIBUTION', "Contribution");
\define('_AM_SLIDER_BY', "par");
\define('_AM_SLIDER_WHY_DONATE', "Faire une donation c'est contribuer à maintenir le projet, et à aider l'auteur à le maintenir.<br>Merci à tous ceux qui feront un donation, si petite soit-elle.");
\define('_AM_SLIDER_ACTIVATE', "Activation");
\define('_AM_SLIDER_DESACTIVATE', "Désactivation");

\define('_AM_SLIDER_CLEAN_DIR', "Themes");
\define('_AM_SLIDER_CLEAN_DIR_DESC', "Reset the 'slider.tpl' files for each theme");
\define('_AM_SLIDER_BLOCK', "Slider Block");
\define('_AM_SLIDER_BLOCK_DESC', "Activate the block which allows the update of the slides");
\define('_AM_SLIDER_TRAITEMENTS', "Treatments");
\define('_AM_SLIDER_SLIDE_SHORT_NAME', "Short name");
\define('_AM_SLIDER_SLIDE_TITLE_DESC', "Main title displayed on the slide");
\define('_AM_SLIDER_SLIDE_DESCRIPTION_DESC', "Text or subtitle displayed on the slide");
\define('_AM_SLIDER_SLIDE_READ_MORE', "Learn more");
\define('_AM_SLIDER_SLIDE_READ_MORE_DESC', "URL on an article or a page with more information");
\define('_AM_SLIDER_SLIDE_PROCESSING_OK', "Processing carried out");
\define('_AM_SLIDER_REFRESH_SLIDERS', "Rafraichier les sliders");
\define('_AM_SLIDER_REFRESH_SLIDERS_DESC', "Réinitialise tous les thèmes et force la reconstruction des sliders");

// ---------------- End ----------------
