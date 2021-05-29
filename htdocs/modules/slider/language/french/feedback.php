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
 * feedback plugin for xoops modules
 *
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        general
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         XOOPS - Website:<https://xoops.org>
 */
$moduleDirName      = \basename(\dirname(\dirname(__DIR__)));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

\define('CO_SLIDER_FB_FORM_TITLE', 'Envoyer un retour');
\define('CO_SLIDER_FB_RECIPIENT', 'Recipient');
\define('CO_SLIDER_FB_NAME', 'Name');
\define('CO_SLIDER_FB_NAME_PLACEHOLER', 'Entrez votre nom');
\define('CO_SLIDER_FB_SITE', 'Site WEB');
\define('CO_SLIDER_FB_SITE_PLACEHOLER', 'Entres votre site WEB');
\define('CO_SLIDER_FB_MAIL', 'Courriel');
\define('CO_SLIDER_FB_MAIL_PLACEHOLER', 'Entrez votre courriel');
\define('CO_SLIDER_FB_TYPE', 'Type de retour');
\define('CO_SLIDER_FB_TYPE_SUGGESTION', 'Suggestions');
\define('CO_SLIDER_FB_TYPE_BUGS', 'Bugs');
\define('CO_SLIDER_FB_TYPE_TESTIMONIAL', 'Témoignages');
\define('CO_SLIDER_FB_TYPE_FEATURES', 'Caractéristiques');
\define('CO_SLIDER_FB_TYPE_OTHERS', 'miscellaneous');
\define('CO_SLIDER_FB_TYPE_CONTENT', 'Votre du retour');
\define('CO_SLIDER_FB_SEND_FOR', 'Retour pour le module ');
\define('CO_SLIDER_FB_SEND_SUCCESS', 'Retour correctement envoyé');
\define('CO_SLIDER_FB_SEND_ERROR', 'Une erreur est survenue lors de l\'envoi du retour!');
