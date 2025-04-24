<?php class ImageUploader
{
    private $uploadDir;

    public function __construct($uploadDir) {
        $this->uploadDir = $uploadDir;
    }

    public function uploadAndResize($file, $artistId) {
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

        // Crée le répertoire de destination s'il n'existe pas
        if (!is_dir($this->uploadDir)) {
            if (!mkdir($this->uploadDir, 0777, true)) {
                throw new Exception("Failed to create upload directory");
            }
        }

        // Chemin complet du fichier cible
        $targetFile = $this->uploadDir . 'a' . str_pad($artistId, 3, "0", STR_PAD_LEFT) . '.jpg';

        // Déplace le fichier et redimensionne si nécessaire
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $this->resizeToHeight($targetFile, $targetFile, 400);
            return basename($targetFile); // Retourne le nom du fichier final
        } else {
            throw new Exception("Failed to move uploaded file");
        }
    }

    private function resizeToHeight(string $inputPath, string $outputPath, int $height): void {
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

        $newHeight = $height;
        $newWidth = round($height * $aspectRatio);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

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

        imagedestroy($image);
        imagedestroy($newImage);
    }
}
