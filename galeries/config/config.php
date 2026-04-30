<?php 
//Config du site, partie publique
//Comportement single ou multipage,
// chaque section intégrée sera soit absorbée par la simple page ou deviendra une page à part entière
$singlePage=0;
//Fin de comportement single ou multipage,
/*****************************************/
//Gestion de langue
// Tableau des langues disponibles
$langues_disponibles = array(
    'fr' => 'Français'
);
// Vérifier si la variable 'lang' est définie dans l'URL
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $langues_disponibles)) {
    $lang = $_GET['lang'];
} else {
    // Si la variable 'lang' n'est pas définie ou n'est pas valide, définir une langue par défaut (par exemple, le français)
    $lang = 'fr';
}
//Fin de gestion de langue
/************************/
//Paramètres de base du site
/*******/
//Racine du site
define('ROOT', '../');
define('PUBLIC_URL', '../public/');
//Répertoire global des images
define('IMG_URL',PUBLIC_URL.'img/');
$repMedias=IMG_URL;
$repDeco=IMG_URL.'deco/';
$repImg=IMG_URL.'content/';
define('JSON','../json/');
/************************/
//Titre du site
//Les éléments du titre sont décomposés dans un tableau pour permettre plus de mobilité dans la présentation de celui-ci. 
$titleWebSite=["Bathyscaphe",".com","galeries"];
/************************/
//Fin des paramètres de base du site
//Fin de config du site, partie publique