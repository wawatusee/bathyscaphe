<?php
ob_start(); // Capture toute sortie accidentelle

require 'image_uploader.class.php';

header('Content-Type: application/json');

$response = array('success' => false, 'error' => '');

try {
    $uploadDir = $_POST['uploadDir'];
    $width = $_POST['width'];
    $height = $_POST['height'];
    $imageFormat = $_POST['imageFormat'];

    if (!isset($_FILES['images'])) {
        throw new Exception("No files uploaded");
    }

    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $file = [
            'name' => $_FILES['images']['name'][$key],
            'type' => $_FILES['images']['type'][$key],
            'tmp_name' => $tmpName,
            'error' => $_FILES['images']['error'][$key],
            'size' => $_FILES['images']['size'][$key],
        ];

        $imageName = pathinfo($file['name'], PATHINFO_FILENAME);
        $uploader = new ImageUploader($uploadDir, $width, $height, $imageName, $imageFormat);
        $uploader->upload($file);
    }

    $response['success'] = true;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Capture de sortie inattendue et JSON sans erreurs
ob_end_clean();
try {
    echo json_encode($response, JSON_THROW_ON_ERROR | JSON_PARTIAL_OUTPUT_ON_ERROR);
} catch (JsonException $jsonError) {
    echo json_encode(['success' => false, 'error' => 'JSON encoding error: ' . $jsonError->getMessage()]);
}
exit;