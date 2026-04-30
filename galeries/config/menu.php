<?php
//Menus du site, alimente la navigation principale impliquant le controleur frontal et d'autres navigations, exemple : "links","réseaux sociaux" parfois intégrées au footer  
require_once("../src/model/menus_model.php");
$menus=new MenusModel(JSON."menus.json");
$menuRS=$menus->getMenu("RS_menu");
$pagesDuMenus=array();
 foreach($menus->getMenu("Main_menu") as $page){
     array_push($pagesDuMenus,$page->page) ;
 }
define('PAGE_ARRAY',$pagesDuMenus);
//Fin des menus du sites