<?php
class ModelGalleryChoices {
    private $directory;

    public function __construct($directory) {
        $this->directory = rtrim($directory, '/') . '/';
    }

    public function getGalleryChoices() {
        $choices = [];
        if (is_dir($this->directory)) {
            $folders = scandir($this->directory);
            foreach ($folders as $folder) {
                if ($folder !== '.' && $folder !== '..' && is_dir($this->directory . $folder)) {
                    $choices[] = $folder;
                }
            }
        }
        return $choices;
    }
}
