<?php class View_gallery
{
    private $images;
    private $repository;

    // Le constructeur prend un tableau d'images du modèle
    public function __construct(array $images,$repository)
    {
        $this->images = $images;
        $this->repository=$repository;
    }

    // Méthode pour générer la vue
    public function render(): string
    {
        $output = '';
        // Balises avant les images
        $output .= <<<HTML
                <div class="content">
                    <div class="grid">
                HTML;

        // Dossier pour les images originales et les miniatures (thumbs)
        foreach ($this->images as $image) {
            // Chemins dynamiques pour les images
            $originalImagePath = 'img/content/galleries/'.$this->repository.'/original/'. $image['name'];
            $thumbImagePath = 'img/content/galleries/'.$this->repository.'/thumbs/'. $image['name'];

            // HTML mélangé avec PHP via la syntaxe >>
            $output .= <<<HTML
                <div class="grid__item" data-size="{$image['width']}x{$image['height']}" style="position: absolute;">
                    <a href="{$originalImagePath}" class="img-wrap">
                        <img src="{$thumbImagePath}" alt="{$image['name']}">
                        <!--<div class="description description--grid">{$this->getDescription($image['name'])}</div>-->
                    </a>
                </div>
            HTML;
        }
        // Balises après les images
        $output .= <<<HTML
                </div>
                <!-- /grid -->
                <div class="preview">
                    <button class="action action--close"><i class="fa fa-times"></i><span class="close-btn">X</span></button>
                    <div class="description description--preview"></div>
                </div>
                <!-- /preview -->
            </div>
            <!-- /content -->
            HTML;

        return $output;
    }

    // Méthode pour obtenir une description (basée sur le nom du fichier sans l'extension par défaut)
    private function getDescription(string $filename): string
    {
        return pathinfo($filename, PATHINFO_FILENAME); // Utilise le nom du fichier comme description
    }
}
