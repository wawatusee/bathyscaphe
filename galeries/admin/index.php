<?php
/*session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
    exit();
}*/
//FIN SESSION
?>
<?php
// index.php dans le dossier admin
require_once 'gallery_manager.class.php';
// Définir le répertoire de base pour les galeries
$baseDir = realpath(__DIR__ . '/../public/img/content/galleries/');
$galleryManager = new GalleryManager($baseDir);
// Gestion des requêtes
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_gallery'])) {
        $galleryName = $_POST['gallery_name'];
        try {
            $galleryManager->createGallery($galleryName);
            echo "Galerie '$galleryName' créée avec succès.";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    if (isset($_POST['rename_gallery'])) {
        $oldName = $_POST['old_name'];
        $newName = $_POST['new_name'];
        try {
            $galleryManager->renameGallery($oldName, $newName);
            echo "Galerie '$oldName' renommée en '$newName'.";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    if (isset($_POST['delete_gallery'])) {
        $galleryName = $_POST['gallery_name'];
        try {
            $galleryManager->deleteGallery($galleryName);
            echo "Galerie '$galleryName' supprimée avec succès.";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
// Affichage des galeries existantes
$galleries = array_diff(scandir($baseDir), array('.', '..'));
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestionnaire de Galeries</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <header>
        <h1>Gestionnaire de Galeries</h1>
    </header>
    <main>
        <section class="form-contener">
            <h2>Créer une galerie</h2>
            <form method="POST">
                <input type="text" name="gallery_name" required placeholder="Nom de la galerie">
                <button type="submit" name="create_gallery">Créer</button>
            </form>
        </section>
        <section class="form-contener">
            <h2>Renommer une galerie</h2>
            <form method="POST">
                <select name="old_name" required>
                    <?php foreach ($galleries as $gallery): ?>
                        <option value="<?= htmlspecialchars($gallery) ?>"><?= htmlspecialchars($gallery) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="new_name" required placeholder="Nouveau nom de la galerie">
                <button type="submit" name="rename_gallery">Renommer</button>
            </form>
        </section>
        <section class="form-contener">
            <h2>Supprimer une galerie</h2>
            <form method="POST">
                <select name="gallery_name" required>
                    <?php foreach ($galleries as $gallery): ?>
                        <option value="<?= htmlspecialchars($gallery) ?>"><?= htmlspecialchars($gallery) ?></option>
                    <?php endforeach; ?>
                </select>
                <!--<input type="text" name="gallery_name" required placeholder="Nom de la galerie à supprimer">-->
                <button type="submit" name="delete_gallery">Supprimer</button>
            </form>
        </section>
        <section class="form-contener">
            <h2>Gestion, chargement d'images dans une galerie existante</h2>
            <ul>
                <?php foreach ($galleries as $gallery): ?>
                    <li>
                        <?= htmlspecialchars($gallery) ?>
                        <form action="gallery_image_management.php" method="post" style="display:inline;">
                            <input type="hidden" name="galleryName" value="<?= htmlspecialchars($gallery) ?>">
                            <button type="submit">Image management</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>

</html>