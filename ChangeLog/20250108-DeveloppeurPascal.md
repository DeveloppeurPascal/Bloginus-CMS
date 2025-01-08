# 20250108 - [DeveloppeurPascal](https://github.com/DeveloppeurPascal)

Open sourced the Bloginus CMS and its previous releases.

## Released source codes

* Version 00 - 9 août 2014
* Version 01 - 22 août 2014
* Version 02 - 24 octobre 2014
* Version 03 - 15 novembre 2014
* Version 04 - 1 juillet 2015
* Version 05 - 24 janvier 2016
* Version 06 - 2 mai 2022

## Done since version 6

### Corrections

* module CAP : si on mettait des espaces dans les URL liées aux pages vidéos, on ne pouvait pas y accéder
* si on choisissait la catégorie racine en tant que page par défaut et qu'on installait Bloginus dans un dossier, l'affichage de la page d'accueil pouvait générer une boucle de redirections
* remplacement de "//" dans l'url si on en trouve afin d'éviter les affichages de pages erronées
* suppression des "./" et "../" qui auraient pu apparaitre dans les URL de recherches de fichiers (notamment permettre une faille de sécurité sur le module ZIP si les droits sur le serveur d'hébergement n'étaient pas correctement gérés)

### Nouveautés

* ajout d'un module "ajax" permettant de gérer les scripts du dossier /ajax des sites, thèmes et modules (en public) et du dossier /ajaxadmin des thèmes et modules (en administration)
* on peut désormais passer des paramètres en GET aux pages d'un site, ce qui peut servir à gérer une pagination sur les pages d'un thème ou traiter des résultats de formulaire

## dans les sources

* changed URL parsing to call the good plugin or display page
* replaced foreach() by while() loops
* added tests on localhost (127.0.0.1 IP address)
* updated ATOM feed format
* done minor changes for PHP 7 and 8 compatibility
* updated RSS feed format
* downgraded CKEditor
* updated default Bootstrap CSS files
* downgraded Highlight JS
* added jQuery 1.11
* added a robot file for the sitemap absolute url (to change on each website)
* added a WIP test for a new backoffice design
* added a new Ajax plugin and a WIP use of it in catagories admin
