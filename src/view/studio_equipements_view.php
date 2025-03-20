<?php
class StudioEquipmentView {
    private $lexiqueModel;
    private $lang;
    private $equipments;

    public function __construct($jsonPath, $lang = 'fr') {
        $this->lexiqueModel = new LexiqueModel($jsonPath);
        $this->lang = $lang;
        $this->equipments = $this->lexiqueModel->get_lexique()['studio_equipment'];
    }

    public function render() {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Studio Equipment</title>
            <link rel="stylesheet" href="/assets/css/style.css">
        </head>
        <body>
            <section class="studio-tools">
                <h2>Studio Equipment</h2>
                <div class="tools-grid">
                    <?php foreach($this->equipments as $equipment): >>
                        <div class="tool-card">
                            <div class="tool-image">
                                <img src="/assets/images/studio/<?=$equipment['image_ref']?>" alt="<?=$equipment['name']?>">
                            </div>
                            <div class="tool-details">
                                <h3><?=$equipment['name']?></h3>
                                <p><?=$equipment['description'][$this->lang]?></p>
                            </div>
                        </div>
                    <<; endforeach; ?>
                </div>
            </section>
        </body>
        </html>
        <?php
    }

    // Méthode optionnelle pour filtrer les équipements
    public function filterEquipments($criteria = []) {
        // Logique de filtrage si nécessaire
        return $this->equipments;
    }
}