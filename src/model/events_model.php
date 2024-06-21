<?php 
class EventsModel {
    private $repertoire;
    private $fichiers = [];

    public function __construct($repertoire) {
        $this->repertoire = $repertoire;
        $this->listerContenuRepertoire();
    }

    private function listerContenuRepertoire() {
        // Vérifie si le chemin est un répertoire
        if (is_dir($this->repertoire)) {
            // Ouvre le répertoire
            if ($dh = opendir($this->repertoire)) {
                // Parcourt tous les fichiers et dossiers dans le répertoire
                while (($file = readdir($dh)) !== false) {
                    // Ignore les . et ..
                    if ($file != "." && $file != ".." &&$file!="refs_events.json" && pathinfo($file, PATHINFO_EXTENSION) == 'json') {
                        $this->fichiers[] = $this->parseFilename($file);
                    }
                }
                // Ferme le répertoire
                closedir($dh);
            } else {
                throw new Exception("Impossible d'ouvrir le répertoire.");
            }
        } else {
            throw new Exception("Le chemin spécifié n'est pas un répertoire.");
        }
    }

    private function parseFilename($filename) {
        // Enlève l'extension .json
        $filename = basename($filename, ".json");
        
        // Sépare les différentes parties
        $parts = explode('_', $filename);
    
        // Crée un tableau associatif avec les informations
        return [
            'numero' => $parts[0], // n3, n4, etc.
            'date' => $parts[1],   // 2024-06-28, 2024-07-12, etc.
            'artists' => explode('-', implode('-', array_slice($parts, 2))) // Transforme en tableau en séparant par des tirets
        ];
    }
    

    public function getFichiers() {
        return $this->fichiers;
    }
}
?>
