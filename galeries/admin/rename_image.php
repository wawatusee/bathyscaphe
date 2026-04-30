<?php
require_once('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $galleryName = $_POST['galleryName'] ?? null;
    $oldName = $_POST['oldName'] ?? null;
    $newName = $_POST['newName'] ?? null;

    if (!$galleryName || !$oldName || !$newName) {
        echo json_encode(['success' => false, 'error' => 'Paramètres manquants.']);
        exit;
    }

    $originalOldPath = $repImg . 'galleries/' . $galleryName . '/original/' . $oldName;
    $thumbOldPath = $repImg . 'galleries/' . $galleryName . '/thumbs/' . $oldName;

    $extension = pathinfo($oldName, PATHINFO_EXTENSION);
    $newNameWithExtension = $newName . '.' . $extension;

    $originalNewPath = $repImg . 'galleries/' . $galleryName . '/original/' . $newNameWithExtension;
    $thumbNewPath = $repImg . 'galleries/' . $galleryName . '/thumbs/' . $newNameWithExtension;

    try {
        if (file_exists($originalOldPath)) {
            rename($originalOldPath, $originalNewPath);
        }

        if (file_exists($thumbOldPath)) {
            rename($thumbOldPath, $thumbNewPath);
        }

        echo json_encode(['success' => true, 'message' => "L'image $oldName a été renommée en $newNameWithExtension."]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
