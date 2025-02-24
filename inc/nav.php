<?php
$menuMain_model = $menus->getMenu("Main_menu");
require_once("../src/view/view_menus.php");
$menusView = new ViewMenu($lang);
$menuMain_view = $menusView->getViewMainMenu($menuMain_model, $singlePage);
?>
<nav class="responsiveMenu" id="responsiveMenu">
<a href="javascript:void(0);" class="icon" onclick="responsiveMenu()">
        <span id="menuIcon">☰</span> <!-- Icône du menu -->
    </a>
    <?php
    echo $menuMain_view;
    ?>

</nav>