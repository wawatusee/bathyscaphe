<header>
    <div class="mainTitleBlock">
        <h1><img class="logo" src="img/deco/logotype-blanc.png">
        </h1>
        <div class="menulangues">
        <?php //Liste déroulante des langues
        echo '<form method="get">';
            echo '<select name="lang" id="lang" onchange="this.form.submit()">';
            foreach ($langs as $code_langue => $nom_langue) {
                echo '<option value="' . $code_langue . '"';
                if ($lang === $code_langue) {
                    echo ' selected';
                }
                echo '>' . $code_langue . '</option>';
            }
            echo '</select>';
        echo '</form>';
        //Fin liste déroulante des langues?>
        </div>
    </div>
    <div class="menu">
        <?php require_once "../inc/nav.php"?>
    </div>
</header>