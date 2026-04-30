<?php class Model_gallery {
    private $directory;
    private $allowedMimeType;

    public function __construct(string $directory, string $allowedMimeType = 'image/jpeg') {
        $this->directory = rtrim($directory, '/'); // S'assurer que le chemin n'a pas de slash à la fin
        $this->allowedMimeType = $allowedMimeType;
    }

    public function getImages(): array {
        // Vérifier si le répertoire existe et est lisible
        if (!is_dir($this->directory) || !is_readable($this->directory)) {
            throw new Exception("Le répertoire n'existe pas ou n'est pas accessible.");
        }

        $images = [];
        $files = scandir($this->directory);

        foreach ($files as $file) {
            $filePath = $this->directory . '/' . $file;

            // Vérifier si c'est un fichier et non un répertoire
            if (is_file($filePath)) {
                // Obtenir les informations de l'image
                $imageInfo = getimagesize($filePath);

                if ($imageInfo && $imageInfo['mime'] === $this->allowedMimeType) {
                    // Ajouter les informations de l'image au tableau
                    $images[] = [
                        'name' => $file,
                        'width' => $imageInfo[0],
                        'height' => $imageInfo[1]
                    ];
                }
            }
        }

        return $images;
    }
}
