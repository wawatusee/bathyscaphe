<header>
    <div class="mainTitleBlock">
        <h1><img class="logo" src="img/deco/logotype-blanc.png">
        </h1>
        <div class="menulangues">
            <form method="get">
                <select name="lang" id="lang" onchange="this.form.submit()">
                    <?php
                    foreach ($langs as $code_langue => $nom_langue) {
                        // Conserve tous les paramètres GET existants
                        $selected = ($lang === $code_langue) ? ' selected' : '';
                        echo '<option value="' . $code_langue . '"' . $selected . '>' . $code_langue . '</option>';
                    }
                    ?>
                </select>

                <?php
                // Ajout des paramètres GET cachés
                foreach ($_GET as $key => $value) {
                    if ($key !== 'lang') {
                        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                    }
                }
                ?>
            </form>
        </div>
    </div>
    <div class="menu">
        <?php require_once "../inc/nav.php" ?>
    </div>
</header>