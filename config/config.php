<?php
require_once "../src/model/config_model.php";
$configDatas=new ConfigModel("../json/config.json");
//Config du site, partie publique
//Comportement single ou multipage,
// chaque section intégrée sera soit absorbée par la simple page ou deviendra une page à part entière
$singlePage=$configDatas->get_single_page_behaviour();
//Fin de comportement single ou multipage,
/*****************************************/

//Gestion de langue
// Tableau des langues disponibles
$langs = $configDatas->get_langs();
// Vérifier si la variable 'lang' est définie dans l'URL
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $langs)) {
    $lang = $_GET['lang'];
    //echo "La variable langue est comprise dans le tableau";
} else {
    // Si la variable 'lang' n'est pas définie ou n'est pas valide, définir une langue par défaut (par exemple, le français)
    $lang = 'en';
    //echo "La variable langue n'est pas comprise dans le tableau";
}
//Fin de gestion de langue
/************************/
//Paramètres de base du site
/************************/
//Répertoire global des images 
$repImg="img/content/";
$repImgDeco="img/deco/";
/************************/
//Titre du site
$a_titleWebSite=$configDatas->get_title();
$str_titleWebSite=$configDatas->get_str_title();
//echo $str_titleWebSite;
/************************/
//Menus du site, alimente la navigation principale impliquant le controleur frontal et d'autres navigations, exemple : "links","réseaux sociaux" parfois intégrées au footer  
require_once("../src/model/config_model.php");
require_once("../src/model/menus_model.php");
$menus=new MenusModel(__DIR__."../../json/menus.json");
$menuRS=$menus->getMenu("RS_menu");
$pagesDuMenus=array();
 foreach($menus->getMenu("Main_menu") as $page){
     array_push($pagesDuMenus,$page->page) ;
 }
define('PAGE_ARRAY',$pagesDuMenus);
//Fin des menus du sites
// Détermination de la page à charger
$pageParam = $_GET['page'] ?? null; // Récupère le paramètre de la page dans l'URL
$pagePath = $configDatas->loadPage($pageParam, PAGE_ARRAY); // Utilise la méthode loadPage pour obtenir le chemin de la page à inclure

//Fin des paramètres de base du site
//Fin de onfig du site, partie publique