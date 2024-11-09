<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta property="og:title" content="Le Bathyscaphe.be">
    <meta property="og:type" content="article" />
    <meta property="og:url" content="http://www.bathyscaphe.be/public/index.php?page=<?= htmlspecialchars($_GET['page'] ?? 'home') ?>">
    <meta property="og:image" content="http://www.bathyscaphe.be/public/img/deco/logotype-blanc.png">
    <meta property="og:image:width" content="1090">
    <meta property="og:image:height" content="177">
    <meta property="og:site_name" content="Bathyscaphe.be">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/footer.css">
<!--Inclusion de feuille de syle dynamique-->
    <?php 
        if (isset($_GET['page'])) {
            $page = htmlspecialchars($_GET['page']);
            $cssFile = "css/pages/$page.css";
            if (file_exists($cssFile)) {
                echo '<link rel="stylesheet" href="' . $cssFile . '">';
            }
        }
    ?>
    <script src="js/menu.js"></script>
    <link rel="shortcut icon" type="image/png" href="favicon.ico">
    <title>Bathyscaphe.be</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Inclusion conditionnelle de la feuille de style spécifique à chaque page -->
    <?php 
        if (isset($_GET['page'])) {
            $page = htmlspecialchars($_GET['page']);
            $cssFile = "css/pages/$page.css";
            if (file_exists($cssFile)) {
                echo '<link rel="stylesheet" href="' . $cssFile . '">';
            }
        }
    ?>
</head>
