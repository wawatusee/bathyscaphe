<?php
class ViewGalleryChoices {
    private $galleryChoices;
    private $page;
    private $selectedGallery;

    public function __construct(array $galleryChoices, string $page, string $selectedGallery = '') {
        $this->galleryChoices = $galleryChoices;
        $this->page = $page;
        $this->selectedGallery = $selectedGallery;
    }

    public function render() {
        if (empty($this->galleryChoices)) {
            echo '<p>Aucune galerie disponible.</p>';
            return;
        }

        echo '<form action="" method="GET" id="galleryForm">';
        echo '<select name="gallery" id="gallery" onchange="this.form.submit()">';

        // Boucle pour afficher chaque option
        foreach ($this->galleryChoices as $choice) {
            // Marquer l'option sélectionnée par défaut si elle est déjà choisie
            $isSelected = $choice === $this->selectedGallery ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($choice) . '"' . $isSelected . '>' . htmlspecialchars($choice) . '</option>';
        }

        echo '</select>';
        
        // Champ caché pour la page
        echo '<input type="hidden" name="page" value="' . htmlspecialchars($this->page) . '">';
        echo '</form>';
    }
}
?>
