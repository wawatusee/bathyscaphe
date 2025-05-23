<?php
/**
 * Classe abstraite pour la gestion et le listing de fichiers dans un répertoire
 * 
 * Fournit une base pour lister les fichiers d'un répertoire en permettant aux classes enfants
 * de définir leurs propres règles de validation et de traitement des noms de fichiers.
 * 
 * @abstract
 */
abstract class FileManager
{
    protected $repertoire;
    protected $fichiers = [];

    public function __construct($repertoire)
    {
        $this->repertoire = $repertoire;
        $this->listerContenuRepertoire();
    }

    protected function listerContenuRepertoire()
    {
        if (!is_dir($this->repertoire)) {
            throw new Exception("Le chemin spécifié n'est pas un répertoire.");
        }

        if ($dh = opendir($this->repertoire)) {
            while (($file = readdir($dh)) !== false) {
                if ($this->isValidFile($file)) {
                    $this->fichiers[] = $this->parseFilename($file);
                }
            }
            closedir($dh);
        } else {
            throw new Exception("Impossible d'ouvrir le répertoire.");
        }
    }

    abstract protected function isValidFile(string $filename): bool;

    abstract protected function parseFilename(string $filename): array;

    public function getFichiers(): array
    {
        return $this->fichiers;
    }
}
