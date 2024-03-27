<?php
require_once "../src/model/config_model.php";
$configDatas=new configModel("../json/config.json");
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
} else {
    // Si la variable 'lang' n'est pas définie ou n'est pas valide, définir une langue par défaut (par exemple, le français)
    $lang = 'en';
}
//Fin de gestion de langue
/************************/
//Paramètres de base du site
/************************/
//Répertoire global des images 
$repImg="img/content/";
/************************/
//Titre du site
$a_titleWebSite=$configDatas->get_title();
$str_titleWebSite=$configDatas->get_str_title();
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
//Fin des paramètres de base du site
//Fin de onfig du site, partie publique