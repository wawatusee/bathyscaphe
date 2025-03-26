<?php
class StudioEquipmentView {
    private $lexiqueModel;
    private $lang;
    private $equipments;

    public function __construct(LexiqueModel $lexiqueModel, $lang = 'fr',$repImg) {
        $this->lexiqueModel = $lexiqueModel;
        $this->lang = $lang;
        $this->repImg = $repImg;
        $this->equipments = $this->lexiqueModel->get_lexique()['studio_equipment'];
    }

    public function render() {
        $html = '<section class="studio-tools">';
        $html .= '<h2>Studio Equipment</h2>';
        $html .= '<div class="tools-grid">';

        foreach ($this->equipments as $equipment) {
            $imagePath = $this->repImg . 'studio/' . $equipment['image_ref'];
            $html .= <<<HTML
            <div class="tool-card">
                <div class="tool-image">
                <img src="{$imagePath}" alt="{$equipment['name']}">                </div>
                <div class="tool-details">
                    <h3>{$equipment['name']}</h3>
                    <p>{$equipment['description'][$this->lang]}</p>
                </div>
            </div>
            HTML;
        }

        $html .= '</div>';
        $html .= '</section>';

        return $html;
    }
}
