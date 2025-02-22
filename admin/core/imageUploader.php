<?php

class ImageUploader {
    private $uploadDir;
    private $width;
    private $height;
    private $imageName;
    private $imageFormat;

    // Constructeur pour initialiser les paramètres
    public function __construct($uploadDir, $width, $height, $imageName, $imageFormat) {
        $this->uploadDir = $uploadDir;
        $this->width = $width;
        $this->height = $height;
        $this->imageName = $imageName;
        $this->imageFormat = $imageFormat;
    }

    // Méthode pour gérer l'upload d'une seule image
    public function upload($file) {
        if (!isset($file) || $file['error'] != 0) {
            throw new Exception("Invalid file upload");
        }

        $fileInfo = getimagesize($file['tmp_name']);
        if ($fileInfo === false) {
            throw new Exception("Invalid image file");
        }

        $imageType = $fileInfo[2];
        if (!in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF])) {
            throw new Exception("Unsupported image format");
        }

        // Créer le répertoire de réception s'il n'existe pas
        if (!is_dir($this->uploadDir)) {
            if (!mkdir($this->uploadDir, 0777, true)) {
                throw new Exception("Failed to create upload directory");
            }
        }

        // Définir le chemin du fichier cible
        $targetFile = $this->uploadDir . '/' . $this->imageName . '.' . $this->imageFormat;

        // Déplacer le fichier téléchargé vers le répertoire cible
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $this->resizeImage($targetFile, $imageType);
            return true;
        } else {
            throw new Exception("Failed to move uploaded file");
        }
    }

    // Méthode pour redimensionner l'image
    private function resizeImage($filePath, $imageType) {
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

        // Calculer les nouvelles dimensions en conservant le ratio d'aspect
        if ($this->width && !$this->height) {
            $this->height = $this->width / $aspectRatio;
        } elseif ($this->height && !$this->width) {
            $this->width = $this->height * $aspectRatio;
        } elseif (!$this->width && !$this->height) {
            $this->width = $origWidth;
            $this->height = $origHeight;
        }

        $newImage = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $this->width, $this->height, $origWidth, $origHeight);

        // Sauvegarder l'image redimensionnée
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

        imagedestroy($image);
        imagedestroy($newImage);
    }
}
