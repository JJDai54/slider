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

\define('CO_' . $moduleDirNameUpper . '_' . 'FB_FORM_TITLE', 'Envoyer un retour');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_RECIPIENT', 'Recipient');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_NAME', 'Name');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_NAME_PLACEHOLER', 'Entrez votre nom');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_SITE', 'Site WEB');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_SITE_PLACEHOLER', 'Entres votre site WEB');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_MAIL', 'Courriel');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_MAIL_PLACEHOLER', 'Entrez votre courriel');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_TYPE', 'Type de retour');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_TYPE_SUGGESTION', 'Suggestions');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_TYPE_BUGS', 'Bugs');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_TYPE_TESTIMONIAL', 'Témoignages');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_TYPE_FEATURES', 'Caractéristiques');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_TYPE_OTHERS', 'miscellaneous');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_TYPE_CONTENT', 'Contenu du retour');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_SEND_FOR', 'Retour pour le module ');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_SEND_SUCCESS', 'Retour correctement envoyé');
\define('CO_' . $moduleDirNameUpper . '_' . 'FB_SEND_ERROR', 'Une erreur est survenue lors de l\'envoi du retour!');
