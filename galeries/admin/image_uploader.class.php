<?php

class ImageUploader {
    private $uploadDir;
    private $imageName;
    private $imageFormat;

    // Constructeur
    public function __construct($uploadDir) {
        $this->uploadDir = $uploadDir;
    }

    // Méthode pour gérer l'upload d'une image
    public function upload($file) {
        if (!isset($file) || $file['error'] != 0) {
            throw new Exception("Invalid file upload: " . json_encode($file));
        }

        $fileInfo = getimagesize($file['tmp_name']);
        if ($fileInfo === false) {
            throw new Exception("Invalid image file");
        }

        $imageType = $fileInfo[2];
        if (!in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF])) {
            throw new Exception("Unsupported image format");
        }

        // Récupère le nom original et l'extension
        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $extension = image_type_to_extension($imageType); // Donne l'extension comme ".jpg" ou ".png"

        // Utilise directement le nom original du fichier
        $newName = $originalName . $extension;

        // Crée le répertoire de destination s'il n'existe pas
        if (!is_dir($this->uploadDir)) {
            if (!mkdir($this->uploadDir, 0777, true)) {
                throw new Exception("Failed to create upload directory");
            }
        }

        // Chemin complet du fichier cible
        $targetFile = $this->uploadDir . '/' . $newName;

        // Déplace le fichier et redimensionne si nécessaire
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $this->resizeImage($targetFile, $imageType);
            return $newName; // Retourne le nom du fichier final
        } else {
            throw new Exception("Failed to move uploaded file");
        }
    }

    // Méthode pour redimensionner une image
    private function resizeImage($filePath, $imageType) {
        // Charge l'image selon son type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($filePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($filePath);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($filePath);
                break;
            default:
                throw new Exception("Unsupported image format");
        }

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);
        $aspectRatio = $origWidth / $origHeight;

        // Détermine les dimensions
        if ($aspectRatio > 1) { // Paysage
            $newWidth = 1280;
            $newHeight = round(1280 / $aspectRatio);
        } else { // Portrait
            $newHeight = 1280;
            $newWidth = round(1280 * $aspectRatio);
        }

        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Sauvegarde de l'image
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($newImage, $filePath);
                break;
            case IMAGETYPE_PNG:
                imagepng($newImage, $filePath);
                break;
            case IMAGETYPE_GIF:
                imagegif($newImage, $filePath);
                break;
        }

        // Libération des ressources
        imagedestroy($image);
        imagedestroy($newImage);
    }
    // Méthode publique pour redimensionner une image à une largeur spécifique créée pour les miniatures
    public function resizeToWidth(string $inputPath, string $outputPath, int $width): void {
        // Charger l'image selon son type
        $imageInfo = getimagesize($inputPath);
        $imageType = $imageInfo[2];

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($inputPath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($inputPath);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($inputPath);
                break;
            default:
                throw new Exception("Unsupported image format");
        }

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);
        $aspectRatio = $origWidth / $origHeight;

        $newWidth = $width;
        $newHeight = round($width / $aspectRatio);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Sauvegarder l'image redimensionnée
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($newImage, $outputPath);
                break;
            case IMAGETYPE_PNG:
                imagepng($newImage, $outputPath);
                break;
            case IMAGETYPE_GIF:
                imagegif($newImage, $outputPath);
                break;
        }

        // Libérer les ressources
        imagedestroy($image);
        imagedestroy($newImage);
    }
}
