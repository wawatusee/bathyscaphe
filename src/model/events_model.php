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
        $fullfilename=$filename;
        // Enlève l'extension .json
        $filename = basename($filename, ".json");
        
        // Sépare les différentes parties par underscore
        $parts = explode('_', $filename);
        
        // La première partie est le numéro
        $numero = $parts[0];
        
        // La deuxième partie est la date
        $date = $parts[1];
        
        // Les autres parties sont les noms d'artistes, les tirets restent intactes
        $artists = array_slice($parts, 2);
        // Remplace les tirets par des espaces dans les noms d'artistes
        $artists = array_map(function($artist) {
            return str_replace('-', ' ', $artist);
        }, $artists);
        // Crée un tableau associatif avec les informations
        return [
            'numero' => $numero, 
            'date' => $date, 
            'artists' => $artists,
            'filename'=>$fullfilename
        ];
    }
    

    public function getFichiers() {
        return $this->fichiers;
    }
    public function getJsonFullName($numero) {
        foreach ($this->fichiers as $fichier) {
            if ($fichier['numero'] === $numero) {
                return $fichier['filename'];
            }
        }
        return null; // Retourne null si aucun fichier correspondant n'est trouvé
    }
}
?>
