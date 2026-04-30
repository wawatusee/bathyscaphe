<?php

class GalleryManager
{
    private $baseDir;

    public function __construct($baseDir)
    {
        $this->baseDir = rtrim($baseDir, '/') . '/';
    }


    // Crée une galerie avec dossiers "original" et "thumbs"
    public function createGallery($name)
    {
        $galleryDir = $this->baseDir . $this->formatGalleryName($name);

        if (!is_dir($galleryDir)) {
            mkdir($galleryDir . '/original', 0777, true);
            mkdir($galleryDir . '/thumbs', 0777, true);
        } else {
            throw new Exception("La galerie existe déjà.");
        }
    }

    // Renomme une galerie
    public function renameGallery($oldName, $newName)
    {
        $oldDir = $this->baseDir . $this->formatGalleryName($oldName);
        $newDir = $this->baseDir . $this->formatGalleryName($newName);

        if (is_dir($oldDir) && !is_dir($newDir)) {
            rename($oldDir, $newDir);
        } else {
            throw new Exception("Impossible de renommer la galerie.");
        }
    }

    // Supprime une galerie et son contenu
    public function deleteGallery($name)
    {
        $galleryDir = $this->baseDir . $this->formatGalleryName($name);

        if (is_dir($galleryDir)) {
            $this->deleteDirectory($galleryDir);
        } else {
            throw new Exception("Galerie introuvable.");
        }
    }

    // Formate le nom du dossier de la galerie
    private function formatGalleryName($name)
    {
        return strtoupper(str_replace(' ', '-', $name));
    }

    // Supprime un dossier et son contenu
    private function deleteDirectory($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteDirectory("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }
}
