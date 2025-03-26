<?php 
class LexiqueModel {
    private $filePath;
    private $data;

    public function __construct($filePath) {
        // Débogage
        error_log("Chemin reçu : " . $filePath);
        error_log("Chemin absolu : " . realpath($filePath));
        
        if (!is_string($filePath)) {
            error_log("Type reçu : " . gettype($filePath));
            throw new InvalidArgumentException("Le chemin du fichier doit être une chaîne de caractères");
        }
        
        $this->filePath = $filePath;
        $this->loadData();
    }

    private function loadData() {
        if (file_exists($this->filePath)) {
            $json = file_get_contents($this->filePath);
            $this->data = json_decode($json, true);
            
            if ($this->data === null) {
                error_log("Erreur de décodage JSON pour le fichier : " . $this->filePath);
                $this->data = [];
            }
        } else {
            error_log("Fichier non trouvé : " . $this->filePath);
            $this->data = [];
        }
    }

    public function get_lexique() {
        return $this->data;
    }
}