<main>
<?php if(!$singlePage): ?>
    <?php
//CONTROLEUR CENTRAL
    //$pageArray charge le tableau déclaré dans config.php,
    //Ce tableau comprend toutes les pages du site et est utilisé pour réaliser le menu(view_menu.php)
    $pagesArray = PAGE_ARRAY;
    //On définit le premier nom de page comme page par défaut du site
    $defaultPage=$pagesDuMenus[0];
    if (isset($_GET["page"])) {
    $page = $_GET["page"];
    $titre=$page;
        if ( in_array($page, $pagesArray) ) {
        require_once '../inc/pages/' . $page . '.php';
        } else {
        //si la page reçue en paramètre d'url ne fait pas partie des pages officielles du site
        require_once '../inc/pages/'.$defaultPage.'.php';
        }
    } else {
        //Si on a pas recu de variable get, alors on renvoit sur la page par défaut du site
        require_once '../inc/pages/'.$defaultPage.'.php';
    }
    ?>
<?php else: ?>
    <?php 
    //Si le site n'est pas en singlepage, donc multipage
    foreach($pagesDuMenus as $page){
        require_once '../inc/pages/' . $page . '.php';
    }
//FIN DE CONTROLEUR CENTRAL
    ?>    
<?php endif ?>
</main>