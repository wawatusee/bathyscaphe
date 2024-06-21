<?php
class EventsView {
    private $model;

    public function __construct(EventsModel $model) {
        $this->model = $model;
    }

    public function genererListeEvenements() {
        $fichiers = $this->model->getFichiers();
        $listeHtml = '<ul>';

        foreach ($fichiers as $fichier) {
            // Supprimer l'extension .json pour obtenir le nom de base
            $nomBase = pathinfo($fichier, PATHINFO_FILENAME);

            // Séparer les différentes parties du nom de fichier
            $parties = explode('_', $nomBase);

            if (count($parties) >= 3) {
                // Extraire les informations
                $numero = substr($parties[0], 1); // Supprime le "n" initial
                $date = $parties[1];
                $texteDescriptif = "Navigation " . $numero;

                // Générer l'élément de liste HTML
                $listeHtml .= '<li>';
                $listeHtml .= '<a href="' . $this->model->repertoire . $fichier . '">' . $date . ' - ' . $texteDescriptif . '</a>';
                $listeHtml .= '</li>';
            }
        }

        $listeHtml .= '</ul>';

        return $listeHtml;
    }
}
