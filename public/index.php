<?php
//Config.php instancie Config_model qui nous donnera de quoi traiter les langues, le titre, le comportement singlepage, les adresses des répertoires utiles du site.
require_once "../config/config.php";
require_once "../src/utils.php"?>
<!DOCTYPE html>
<html lang=<?=$lang?> prefix="og:http://ogp.me/ns#">
    <?php require_once "../inc/head.php"?>
    <body>
        <?php
        if(!$singlePage);
        else   echo "singlePage = vrai";
        require_once "../inc/header.php"?>
        <?php require_once "../inc/main.php"?>
        <?php require_once "../inc/footer.php"?>
    </body> 
</html>