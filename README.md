# Slider-Module-Xoops
Module de gestion des slides des thème xbootstrap

module "slider" pour Xoops: 
-----------------------------------

Fonctionnalités : 
- Ajout, Supprimer de slides à la page d'accueil
- Activation, désactivation des slide, sans suppression
- Défini le type d'affichage: avec ou sans période d'affichage
- Définition de l'ordre d'affichage des slides
- Définition d'une période d'affichage pour anticiper un évènement

slider_update_tpl
Fichier "tpl/slider.tpl" du thème sélectionné
Thèmes de type "xbootstrap".

Ajout d'un nouveau slide :
Titre : message affiché sur le slide.
Description : Message affiché sous le titre sur le slide.
Image : Image du slide. Attention vérifiez la taille des fichiers (1920 px x 500 px pour xbootstrap).
Actif : non = Le slide ne sera jamais afficher. Permet d’activer un slide pour une utilisation ultérieure sans le supprimer, par exemple pour les fêtes récurrentes.
Visible : oui = le slide est toujours affiché -  non = il faut définir la période d'affichage.
Date de début : date et heure de début d'affichage du slide.
Date de fin : date de fin d'affichage du slide.
Poids : défini l'ordre d'affichage des slides. Si plusieurs slides ont le même poids l'ordre alphabétique des titres est appliqué.

Traitements :
Sur la page d'index il y a plusieurs traitements possibles.
- Réinitialise les fichiers 'tpl/slider.tpl' d'origine de chaque thème.
  Désactive le block du module slider pour permettre l'affichage des slides d'origine
  Supprime les caches pour actualiser l'affichage immédiatement

-Activer le block qui permet la mise à jour des slides 
 Equivaut à afficher le block dans le gestionnaire de blocks
 
Utilisation :
- Installation standard  de module
- Ajouter des slides au thèmes utilisés (voir "Ajout de slide)""
- Activer le block du module, peu importe sa place il restera invisible
  Important : l'option "Afficher le block" Permet de lister les slides sélectionnés
              à utiliser en mode débogage uniquement
              Laisser la sur "Non" en production
