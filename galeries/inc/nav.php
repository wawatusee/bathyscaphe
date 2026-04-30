<?php
$menuMain_model = $menus->getMenu("Main_menu");
require_once("../src/view/view_menus.php");
$menusView = new ViewMenu($lang);
//Le deuxième paramètre determine le comportement du site en singlepage ou pas
$menuMain_view = $menusView->getViewMainMenu($menuMain_model, $singlePage);
?>
<nav class="responsiveMenu" id="responsiveMenu">
    <a href="javascript:void(0);" class="icon" onclick="responsiveMenu()">
        <img src="img/deco/menu-responsive-btn-blanc.svg" alt="bouton menu-toggle">
    </a>
    <?php
    echo "<div class='links'>" . $menuMain_view . "</div>";
    ?>
</nav>