# Slider-Module-Xoops
Module de gestion des slides des thème xbootstrap

module "slider" pour Xoops: 
-----------------------------------

Fonctionnalités : 
=================
- Ajout, Suppression de slides sur la page d'accueil
- Activation, désactivation des slides, sans suppression
- Défini le type d'affichage: avec ou sans période d'affichage
- Définition de l'ordre d'affichage des slides
- Définition d'une période d'affichage pour anticiper un évènement
- gestion de tous les thèmes installé et actifs

Installation du module :
=======================
1) Télécharger le ZIP du module "SLIDER" ici:
https://github.com/JJDai54/slider
Pour le télécharger, procédez ainsi:
Cliquez sur le bouton vert "Code", puis sur "Download ZIP".
>>> Enregistrer le fichier (slider-main).
Ainsi, vous obtenez le dossier "slider-main".

2) double cliquez sur "modules", vous trouverez le dossier "slider" à l'intérieur.
copiez/collez le dossier "slider" dans votre Fillezilla (logiciel Fançais N° 1 dans le monde): "/mon site/modules".

3) Framework : le module utilise deux frameworks qui ne sont pas obligatoires, mais améliorent son ergonomie:
- highslide : ce framework permet de zoomer les images des slides. 
rendez-vous à cette adresse (ce n'est qu'à moitié sécurisé, c'est juste que le concepteur du site a plein de boulot, alors, il n'a pas eu le temps de renouveler les SSL, ce site n'est pas vérolé puisque j'y ai été personnellement pour le télécharger) :
http://highslide.com/
Téléchargez et copier/coller le dossier "highslide" dans "/mon site/Frameworks
Renommez le en : "highslide-5.0.0"

- triertableauHtml : permet de trier les listes dans l'admin selon les colones.
Il se trouve normaalement dans l'archive, si ce n'est pas le cas, rendez-vous à cette adresse :
https://github.com/JJDai54/trierTableauHTML
Téléchargez et copier/coller le dossier "triertableauHtml" dans "/mon site/Frameworks

4) rendez-vous ensuite dans votre admin Xoops:
panneau de contrôle/ Modules/ slider - Gestion des Slides/ Slides:
Placez les images de vos sliders désirés (taille = 1920 x 500 pixels).
Champs à renseigner:
Titre : message affiché sur le slide.
Description : Message affiché sous le titre sur le slide.
Image : Image du slide. Attention vérifiez la taille des fichiers (1920 px x 500 px pour xbootstrap).
Actif : non = Le slide ne sera jamais afficher. Permet d’activer un slide pour une utilisation ultérieure sans le supprimer, par exemple pour les fêtes récurrentes.
Visible : oui = le slide est toujours affiché -  non = il faut définir la période d'affichage.
Périodicité : Permet de définir une période d'affichage:
- Toujours : Le slide sera toujours affiché si le champ est actif
- période flottante : Affiche le slide selon la période de début et de fin.
- Semaine, Mois Trimestre, An : Affiche le slide pendant la période définie. Ces options permettent de réactualiser automatiquement les périodes une fois celle-ci passée.
Date de début : date et heure de début d'affichage du slide.
Date de fin : date de fin d'affichage du slide.
Poids : défini l'ordre d'affichage des slides. Si plusieurs slides ont le même poids l'ordre alphabétique des titres est appliqué.


6) dans l'onglet "Thèmes":
12e colonne, cliquez sur "générer"
Vos sliders sont maintenant opérationnels

7) activer le block 'slider - alétoire" si vous utilisé des périodes d'affichage.
Ce block est invisible et peu donc se trouver n'importe où.
Le bloc "sliders - Slides courants" doit rester inactif, il sert uniquement pour le développement."

MODE D'EMPLOI créé par Luc Bardot le 17/10/2021 pour aider le concepteur du module: JJDay.
Long life Xoops !!!

=================================================================

 
