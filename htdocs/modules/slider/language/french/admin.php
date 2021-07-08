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
//include_once __DIR__ . '/main.php';

// ---------------- Admin Index ----------------
define('_AM_SLIDER_STATISTICS', 'Statistics');
// There are
define('_AM_SLIDER_THEREARE_SLIDES', "Il y a <span class='bold'>%s</span> slides dans la base");
// ---------------- Admin Files ----------------
// There aren't
define('_AM_SLIDER_THEREARENT_SLIDES', "Il n'y a pas de slide");
// Save/Delete
define('_AM_SLIDER_FORM_OK', 'Enregistrement réussi');
define('_AM_SLIDER_FORM_DELETE_OK', 'Suppression réussie');
define('_AM_SLIDER_FORM_SURE_DELETE', "Etes-vous sur de vouloir supprimer : <b><span style='color : Red;'>%s </span></b>");
define('_AM_SLIDER_FORM_SURE_RENEW', "Etes-vous sur de vouloir mettre à jour: <b><span style='color : Red;'>%s </span></b>");
// Buttons
define('_AM_SLIDER_ADD_SLIDE', 'Ajouter un nouveau Slide');
// Lists
define('_AM_SLIDER_SLIDES_LIST', 'Liste des Slides');
// ---------------- Admin Classes ----------------
// Slide add/edit
define('_AM_SLIDER_SLIDE_ADD', 'Ahouter le Slide');
define('_AM_SLIDER_SLIDE_EDIT', 'Editer le  Slide');
// Elements of Slide
define('_AM_SLIDER_SLIDE_ID', 'Id');
define('_AM_SLIDER_SLIDE_TITLE', 'Titre');
define('_AM_SLIDER_SLIDE_DESCRIPTION', 'Description');
define('_AM_SLIDER_SLIDE_WEIGHT', 'Poids');
define('_AM_SLIDER_SLIDE_DATE_BEGIN', 'Date de début');
define('_AM_SLIDER_SLIDE_DATE_END', 'Date de fin');
define('_AM_SLIDER_SLIDE_ACTIF', 'Actif');
define('_AM_SLIDER_SLIDE_ACTIF_DESC', 'Active ou non le slide quelque soit les options suivantes.<br>Cela évite de la supprimer pour le réutiliser plus tard');
define('_AM_SLIDER_SLIDE_SELECT_THEME', "Selectioner le thème à modifier");
define('_AM_SLIDER_SLIDE_SELECT_THEME_DESC', "Le fichier original 'slide.tlp' sera sauvegardé avec l'extension '_old'");
define('_AM_SLIDER_SLIDE_IMAGE', 'Image');
define('_AM_SLIDER_SLIDE_IMAGE_UPLOADS', 'Image in %s :');
// General
define('_AM_SLIDER_FORM_UPLOAD', 'télécharger un slide');
define('_AM_SLIDER_FORM_UPLOAD_NEW', 'Télécharger un nouveau slide: ');
define('_AM_SLIDER_FORM_UPLOAD_SIZE', 'Poids maximum des images: ');
define('_AM_SLIDER_FORM_UPLOAD_SIZE_MB', 'MB');
define('_AM_SLIDER_FORM_UPLOAD_IMG_WIDTH', 'Largeur max des images: ');
define('_AM_SLIDER_FORM_UPLOAD_IMG_HEIGHT', 'Hauteur max des imagest: ');
define('_AM_SLIDER_FORM_IMAGE_PATH', 'Fichiers in %s :');
define('_AM_SLIDER_FORM_ACTION', 'Action');
define('_AM_SLIDER_FORM_EDIT', 'Modification');
define('_AM_SLIDER_FORM_DELETE', 'Suppprimer');
// ---------------- Admin Others ----------------
define('_AM_SLIDER_SLIDE_HAS_PERIODE', 'Définir une période');
define('_AM_SLIDER_SLIDE_HAS_PERIODE_DESC', 'Non : Visible quelque soit la période définie si "actif" est oui');
define('_AM_SLIDER_ABOUT_MAKE_DONATION', 'Faire une donation');
define('_AM_SLIDER_SUPPORT_FORUM', 'Support Forum');
define('_AM_SLIDER_DONATION_AMOUNT', 'Montant de donation');
define('_AM_SLIDER_MAINTAINEDBY', ' is maintained by ');
define('_AM_SLIDER_SLIDE_TO_LOAD', 'Selectionner le slide à télécharger ');
define('_AM_SLIDER_SLIDE', 'Slide');
define('_AM_SLIDER_UPLOADSIZE', "Taille maximum du slide %s mo");
define('_AM_SLIDER_SLIDE_THEME', "Thème");
define('_AM_SLIDER_CONTRIBUTION', "Contribution");
define('_AM_SLIDER_BY', "par");
define('_AM_SLIDER_WHY_DONATE', "Faire une donation c'est contribuer à maintenir le projet, et à aider l'auteur à le maintenir.<br>Merci à tous ceux qui feront un donation, si petite soit-elle.");
define('_AM_SLIDER_ACTIVATE', "Activation");
define('_AM_SLIDER_DESACTIVATE', "Désactivation");

define('_AM_SLIDER_CLEAN_DIR', "Thèmes");
define('_AM_SLIDER_CLEAN_DIR_DESC', "Rinitialise les fichiers 'slider.tpl' de chaque thème");
define('_AM_SLIDER_BLOCK', "Slider Block");
define('_AM_SLIDER_BLOCK_DESC', "Active le block qui permet la mise à jour des slides");
define('_AM_SLIDER_TRAITEMENTS', "Traitements");
define('_AM_SLIDER_SLIDE_SHORT_NAME', "Nom court");
define('_AM_SLIDER_SLIDE_TITLE_DESC', "Titre principal affiché sur le slide");
define('_AM_SLIDER_SUBTITLE_DESC', "Texte ou sous-titre affiché sur le slide");
define('_AM_SLIDER_BUTTON_URL', "URL du bouton");
define('_AM_SLIDER_SLIDE_READ_MORE_DESC', "Lien sur un article ou une page avec plus d'informations");
define('_AM_SLIDER_SLIDE_PROCESSING_OK', "Traitement effectué");
define('_AM_SLIDER_REFRESH_SLIDERS', "Rafraichier les sliders");
define('_AM_SLIDER_REFRESH_SLIDERS_DESC', "Réinitialise tous les thèmes et force la reconstruction des sliders");
define('_AM_SLIDER_SLIDE_CURRENT_STATUS', "Courrant");
define('_AM_SLIDER_UP', "Monter");
define('_AM_SLIDER_DOWN', "Descendre");
define('_AM_SLIDER_HIGHSLIDE_0', "<span style=\"color:red;\">Le framework \"<a href=\"http://highslide.com/\">Highslide</a>\" n'est pas installé.</span>");
define('_AM_SLIDER_HIGHSLIDE_1', "<span style=\"color:green;\">Le framework \"<a href=\"http://highslide.com/\">Highslide</a>\" est installé.</span>");

define('_AM_SLIDER_SLIDE_BUTTON_CAPTION', "Titre du bouton");
define('_AM_SLIDER_SLIDE_BUTTON_CAPTION_DESC', "Le bouton n'apparait que si une url est définie.<br>exemples de titres : Lire plus | En savoir plus ...");

define('_AM_SLIDER_FIRST', "Premier");
define('_AM_SLIDER_LAST', "Dernier");

define('_AM_SLIDER_SLIDE_STYLE_TITLE', "Style du titre");
define('_AM_SLIDER_SLIDE_STYLE_TITLE_DESC', "Utiliser les style CSS sans le nom du style ni les acolades. Exemple :<br>color:red;<br>background:yellow;");

define('_AM_SLIDER_SLIDE_STYLE_SUBTITLE', "Style du sous-titre");
define('_AM_SLIDER_SLIDE_STYLE_SUBTITLE_DESC', "Utiliser les style CSS sans le nom du style ni les acolades. Exemple :<br>color:red;<br>background:yellow;");

define('_AM_SLIDER_SLIDE_STYLE_BUTTON', "Style du bouton");
define('_AM_SLIDER_SLIDE_STYLE_BUTTON_DESC', "Utiliser les style CSS sans le nom du style ni les acolades. Exemple :<br>color:red;<br>background:yellow;");

define('_AM_SLIDER_PERIODICITY', "Périodicité");
define('_AM_SLIDER_PERIODICITY_DESC', "Défini la périodicité de renouvellement d'affichage après une période expirée<br>'Toujours' : aucune prériodicité.<br>pour les autres options définir une date de début et de fin.");

define('_AM_SLIDER_PERIODICITE_ALWAYS', 'Toujours');
define('_AM_SLIDER_PERIODICITE_FLOAT', 'Période flottante');
define('_AM_SLIDER_PERIODICITE_CYCLIQUE', 'Période cyclique');
define('_AM_SLIDER_PERIODICITE_WEEK', 'Toute les semaines');
define('_AM_SLIDER_PERIODICITE_MONTH', 'Tous les mois');
//define('_AM_SLIDER_PERIODICITE_BIMONTHLY', 'Une fois tous les deux mois');
define('_AM_SLIDER_PERIODICITE_QUATER', 'Tous les trimestres');
//define('_AM_SLIDER_PERIODICITE_SEMESTER', 'Une fois par semestre');
define('_AM_SLIDER_PERIODICITE_YEAR', 'Tous les ans');
define('_AM_SLIDER_UPDATE_PERIODICITY', 'Mettre à jour la périodicité');
define('_AM_SLIDER_PERIODICITY_UPDATED', "Les périodes de %s slides ont été mises à jour");
define('_AM_SLIDER_NO_PERIODICITY_TO_UPDATE', "Il n'y a pas de période à mettre à jour");
define('_AM_SLIDER_NON_ACTIF', "Non actif");
define('_AM_SLIDER_ACTIF', "Actif");
define('_AM_SLIDER_CURRENT_DATE', "Date courante");
// define('_AM_SLIDER_SLIDE_SELECT_THEME', "Choix du ou des thèmes");
// define('_AM_SLIDER_SLIDE_SELECT_THEME_DESC', "Date courante");
define('_AM_SLIDER_THEME', "Thèmes");

define('_AM_SLIDER_ALL_THEMES_ARE_VISIBLE', "Visible dans tous les thèmes");
define('_AM_SLIDER_ALL_THEMES', "Tous les thèmes");
define('_AM_SLIDER_TITLE', "Titre principal");
define('_AM_SLIDER_SUBTITLE', "Sous-titre");
define('_AM_SLIDER_BUTTON', "Bouton");
define('_AM_SLIDER_OPTIONS', "Options");

// ---------------- End ----------------
