<?php
require_once("../config/config.php");
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si la variable "gallery-name" existe dans la requête POST
    if (isset($_POST['galleryName']) && !empty($_POST['galleryName'])) {
        // Récupère et sécurise la valeur
        $galleryName = htmlspecialchars($_POST['galleryName']);
    } else {
        echo "Aucune galerie sélectionnée.";
    }
} else {
    echo "Accès non autorisé.";
}
$repgalleries = $repImg . 'galleries/' . $galleryName . '/original';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/admin.css">
    <title>Gestion des Images de galerie</title>
</head>

<body>
    <header>
        <h1>Gestion des Images de la galerie: <?= $galleryName ?></h1>
        <a href="index.php">Back to galleries</a>
    </header>
    <main>
        <section class="form-contener">
            <!-- Sélection des fichiers à uploader -->
            <input type="file" id="fileInput" multiple />
            <button onclick="uploadImages()">Upload</button>
            <!--Fin de Sélection des fichiers à uploader -->
        </section>
        <section class="form-contener">
            <!-- Rafraîchir les miniatures -->
            <button id="refreshThumbsBtn">Rafraîchir les miniatures</button>
            <!--Fin de Rafraîchir les miniatures -->
        </section>
        <!-- Nouvelle section : Mini-galerie -->
        <section>
            <h2>Images</h2>
            <div id="thumbnailsContainer" class="thumbnails-grid"></div>
        </section>

    </main>
    <script>
        function uploadImages() {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length === 0) {
                alert("Please select image files");
                return;
            }

            const files = fileInput.files;
            const formData = new FormData();

            // Ajout des fichiers au formulaire
            for (let i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            // Définition des paramètres pour l'upload
            formData.append('uploadDir', '<?= $repgalleries ?>');
            formData.append('width', 400); // Exemple de largeur
            formData.append('height', 600); // Exemple de hauteur
            formData.append('imageFormat', 'jpg');

            // Vérification de la largeur dans la console
            console.log("Chemin upload: ", formData.get('uploadDir'));
            console.log("Width sent:", formData.get('width'));
            fetch('upload.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert("Images uploaded successfully");
                    } else {
                        alert("Failed to upload images: " + data.error);
                    }
                })
                .catch(error => {
                    alert("Error uploading images: " + error);
                });
        }
    </script>
    <script>
        document.getElementById('refreshThumbsBtn').addEventListener('click', () => {
            const galleryName = '<?= htmlspecialchars($galleryName, ENT_QUOTES) ?>';
            fetch('refresh_gallery_thumbs.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        galleryName
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                    } else {
                        alert("Erreur : " + data.error);
                    }
                })
                .catch(error => {
                    alert("Erreur lors de l'appel AJAX : " + error.message);
                });
        });
    </script>
    <script>
        // Charger les miniatures
        function loadThumbnails() {
            const galleryName = '<?= htmlspecialchars($galleryName, ENT_QUOTES) ?>';

            fetch('load_thumbnails.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        galleryName
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const thumbnailsContainer = document.getElementById('thumbnailsContainer');
                        thumbnailsContainer.innerHTML = ''; // Clear existing thumbnails

                        data.thumbnails.forEach(thumbnail => {
                            const thumbnailElement = document.createElement('div');
                            thumbnailElement.className = 'thumbnail-item';

                            thumbnailElement.innerHTML = `
                        <img src="${thumbnail.url}" alt="${thumbnail.name}" />
                        <button onclick="deleteImage('${thumbnail.name}')">Suppr</button>
                        <button onclick="renameImage('${thumbnail.name}')">Renommer</button>
                    `;

                            thumbnailsContainer.appendChild(thumbnailElement);
                        });
                    } else {
                        alert("Erreur : " + data.error);
                    }
                })
                .catch(error => {
                    console.error("Erreur lors du chargement des miniatures :", error);
                    alert("Erreur lors du chargement des miniatures : " + error.message);
                });
        }

        // Supprimer une image
        function deleteImage(imageName) {
            const galleryName = '<?= htmlspecialchars($galleryName, ENT_QUOTES) ?>';
            if (confirm(`Supprimer l'image ${imageName} ?`)) {
                fetch('delete_image.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            galleryName,
                            imageName
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            loadThumbnails(); // Recharger la galerie
                        } else {
                            alert("Erreur : " + data.error);
                        }
                    })
                    .catch(error => {
                        alert("Erreur : " + error.message);
                    });
            }
        }

        // Renommer une image
        function renameImage(oldName) {
            const newName = prompt("Entrez le nouveau nom pour l'image (sans l'extension) :", oldName.split('.')[0]);
            if (!newName) return;

            const galleryName = '<?= htmlspecialchars($galleryName, ENT_QUOTES) ?>';
            fetch('rename_image.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        galleryName,
                        oldName,
                        newName
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        loadThumbnails(); // Recharger la galerie
                    } else {
                        alert("Erreur : " + data.error);
                    }
                })
                .catch(error => {
                    alert("Erreur : " + error.message);
                });
        }

        // Charger les miniatures au démarrage
        document.addEventListener('DOMContentLoaded', loadThumbnails);
    </script>
</body>

</html>