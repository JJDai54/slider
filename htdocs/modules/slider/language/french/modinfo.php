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
define('_MI_SLIDER_NAME', 'slider - Gestion des Slides');
define('_MI_SLIDER_DESC', 'Ce module permet de gérer l\'affichage des slides, Ajout, durée d\'affichage, ordre, ...');
// ---------------- Admin Menu ----------------
define('_MI_SLIDER_ADMENU1', 'Tableau de bord');
define('_MI_SLIDER_ADMENU2', 'Slides');
define('_MI_SLIDER_ADMENU3', 'Retour');
define('_MI_SLIDER_ABOUT', 'A propos');
// ---------------- Admin Nav ----------------
define('_MI_SLIDER_ADMIN_PAGER', 'Admin pages');
define('_MI_SLIDER_ADMIN_PAGER_DESC', 'Admin par pages');
// Blocks
define('_MI_SLIDER_SLIDES_BLOCK', 'Slides block');
define('_MI_SLIDER_SLIDES_BLOCK_DESC', 'Slides block description');
define('_MI_SLIDER_SLIDES_BLOCK_SLIDE', 'Slides block  SLIDE');
define('_MI_SLIDER_SLIDES_BLOCK_SLIDE_DESC', 'Slides block  SLIDE description');
define('_MI_SLIDER_SLIDES_BLOCK_LAST', 'Slides block last');
define('_MI_SLIDER_SLIDES_BLOCK_LAST_DESC', 'Slides block last description');
define('_MI_SLIDER_SLIDES_BLOCK_NEW', 'Slides block new');
define('_MI_SLIDER_SLIDES_BLOCK_NEW_DESC', 'Slides block new description');
define('_MI_SLIDER_SLIDES_BLOCK_HITS', 'Slides block hits');
define('_MI_SLIDER_SLIDES_BLOCK_HITS_DESC', 'Slides block hits description');
define('_MI_SLIDER_SLIDES_BLOCK_TOP', 'Slides block top');
define('_MI_SLIDER_SLIDES_BLOCK_TOP_DESC', 'Slides block top description');
define('_MI_SLIDER_SLIDES_BLOCK_RANDOM', 'Slides block random');
define('_MI_SLIDER_SLIDES_BLOCK_RANDOM_DESC', 'Slides block random description');
// Config
define('_MI_SLIDER_EDITOR_ADMIN', 'Editeur admin');
define('_MI_SLIDER_EDITOR_ADMIN_DESC', 'Sélectionnez l\'éditeur qui doit être utilisé dans la zone d\'administration pour les champs de zone de texte');
define('_MI_SLIDER_EDITOR_USER', 'Utilisateur de l\'éditeur');
define('_MI_SLIDER_EDITOR_USER_DESC', 'Sélectionnez l\'éditeur qui doit être utilisé dans la zone utilisateur pour les champs de zone de texte');
define('_MI_SLIDER_EDITOR_MAXCHAR', 'Texte max caractères');
define('_MI_SLIDER_EDITOR_MAXCHAR_DESC', 'Max caractères pour afficher le texte d\'une zone de texte ou d\'un champ d\'éditeur dans la zone d\'administration');
define('_MI_SLIDER_KEYWORDS', 'Mots-clés');
define('_MI_SLIDER_KEYWORDS_DESC', 'Insérez ici les mots-clés (séparés par une virgule)');
define('_MI_SLIDER_SIZE_MB', 'MB');
define('_MI_SLIDER_MAXSIZE_IMAGE', 'Taille maximale de l\'image');
define('_MI_SLIDER_MAXSIZE_IMAGE_DESC', 'Définir la taille maximale pour le téléchargement des images');
define('_MI_SLIDER_MIMETYPES_IMAGE', 'Image des types Mime');
define('_MI_SLIDER_MIMETYPES_IMAGE_DESC', 'Définir les types mime autorisés pour le téléchargement des images');
define('_MI_SLIDER_MAXWIDTH_IMAGE', 'Image de largeur maximale');
define('_MI_SLIDER_MAXWIDTH_IMAGE_DESC', 'Définit la largeur maximale à laquelle les images téléchargées doivent être mises à l’échelle (en pixels) <br> 0 signifie que les images conservent la taille originale. <br> Si une image est inférieure à la valeur maximale, l’image ne sera pas agrandi, il sera sauvegardé dans la largeur originale. ');
define('_MI_SLIDER_MAXHEIGHT_IMAGE', 'Image de hauteur maximale');
define('_MI_SLIDER_MAXHEIGHT_IMAGE_DESC', 'Définit la hauteur maximale à laquelle les images téléchargées doivent être mises à l’échelle (en pixels) <br> 0 signifie que les images conservent la taille originale. <br> Si une image est plus petite que la valeur maximale, l’image ne sera pas agrandi, il sera sauvegardé à la hauteur d\'origine ');
define('_MI_SLIDER_NUMB_COL', 'Nombre de colonnes');
define('_MI_SLIDER_NUMB_COL_DESC', 'Nombre de colonnes à afficher.');
define('_MI_SLIDER_DIVIDEBY', 'Diviser par');
define('_MI_SLIDER_DIVIDEBY_DESC', 'Diviser par le nombre de colonnes.');
define('_MI_SLIDER_TABLE_TYPE', 'Type de table');
define('_MI_SLIDER_TABLE_TYPE_DESC', 'Le type de table est la table html du curseur.');
define('_MI_SLIDER_PANEL_TYPE', 'Type de panneau');
define('_MI_SLIDER_PANEL_TYPE_DESC', 'Le type de panneau est le curseur html div.');
define('_MI_SLIDER_IDPAYPAL', 'ID Paypal');
define('_MI_SLIDER_IDPAYPAL_DESC', 'Insérez ici votre identifiant PayPal pour les dons.');
define('_MI_SLIDER_ADVERTISE', 'Code d\'annonce');
define('_MI_SLIDER_ADVERTISE_DESC', 'Insérez ici le code de l\'annonce');
define('_MI_SLIDER_MAINTAINEDBY', 'Maintenu par');
define('_MI_SLIDER_MAINTAINEDBY_DESC', 'Autoriser l\'url du site d\'assistance ou de la communauté');
define('_MI_SLIDER_BOOKMARKS', 'Signets sociaux');
define('_MI_SLIDER_BOOKMARKS_DESC', 'Afficher les signets sociaux dans une seule page');
define('_MI_SLIDER_FACEBOOK_COMMENTS', 'Commentaires Facebook');
define('_MI_SLIDER_FACEBOOK_COMMENTS_DESC', 'Autoriser les commentaires Facebook dans une seule page');
define('_MI_SLIDER_DISQUS_COMMENTS', 'Disqus comments');
define('_MI_SLIDER_DISQUS_COMMENTS_DESC', 'Autoriser les commentaires Disqus dans la page unique');
// JJDai
define('_MI_SLIDER_UPDATE_THEME', 'slider_update_tpl');
define('_MI_SLIDER_UPDATE_THEME_DESC', 'Block de mise jour de slider.tpl du thème en cours');

define('_MI_SLIDER_HIGHSLIDE', 'Framework "highslide"');
define('_MI_SLIDER_HIGHSLIDE_DESC', "Dossier d'installation du framework <a href=\"http://highslide.com/\">Highslide</a>");

define('_MI_SLIDER_REBUILD', 'Reconstruction du template des slides');
define('_MI_SLIDER_REBUILD_DESC', "Force la reconstruction des templates, à utiliser pendant le développement.<br>Laissez 'Non' en production");

define('_MI_SLIDER_EXTRA', 'Extra (CSS & HTML)');
define('_MI_SLIDER_EXTRA_DESC', "Code CSS ou HTML ajouté après la liste des slides dans le fichier \"tpl/slider.tpl\"<br>Ce code n'est affiché que sur la page d'accueil comme les slides<br>Il permet d'ajouter un ou des éléments qui apparaitront sur tous les slides, par exemple un logo avec un lien externe.");


define('_MI_STYLE_POINTS', "Style des points de navigation");
define('_MI_STYLE_POINTS_DESC', "Permet de surcharger le style des points de navigation qui sont parfois peu visible sur certains slide");
define('_MI_STYLE_POINTS_FLASH', "Style de clignotement");
define('_MI_STYLE_POINTS_FLASH_DESC', "Permet d'ajouer un clignotement sur les points de navigation.");
define('_MI_STYLE_POINTS_ACTIVE', "Style du point actif de navigation");
define('_MI_STYLE_POINTS_ACTIVE_DESC', "Permet de surcharger le style du point actif de navigation qui sont parfois peu visible sur certains slide");

define('_MI_STYLE_TITLE', "Style du titre");
define('_MI_STYLE_TITLE_DESC', "Permet de surcharger le style par défaut du titre des slides");

define('_MI_STYLE_SUBTITLE', "Style du sous-titre");
define('_MI_STYLE_SUBTITLE_DESC', "Permet de surcharger le style par défaut du sous-titre des slides");

define('_MI_STYLE_BUTTON', "Style du bouton");
define('_MI_STYLE_BUTTON_DESC', "Permet de surcharger le style par défaut du bouton des slides");

// ---------------- End ----------------


