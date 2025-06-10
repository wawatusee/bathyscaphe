<?php
$filename = '../json/activity-types.json';

function loadData($filename) {
    if (!file_exists($filename)) {
        return ["art-types" => []];
    }
    $json = file_get_contents($filename);
    return json_decode($json, true);
}

function saveData($filename, $data) {
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$data = loadData($filename);

// Traitement ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $en = trim($_POST['en'] ?? '');
    $fr = trim($_POST['fr'] ?? '');
    $nl = trim($_POST['nl'] ?? '');

    if ($en && $fr && $nl) {
        // Calcul nouvel ID (max+1)
        $nextId = 1;
        if (!empty($data['art-types'])) {
            $ids = array_column($data['art-types'], 'id');
            $nextId = max($ids) + 1;
        }
        $data['art-types'][] = [
            "id" => (string)$nextId,
            "en" => $en,
            "fr" => $fr,
            "nl" => $nl
        ];
        saveData($filename, $data);
        // Redirige pour éviter re-soumission du formulaire
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Activities Types</title>

        <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/admin-liste-json.css">
</head>
<body>
    <header><?php include 'inc/admin_headers.php'?>
    <h1>Admin - Types d'activités artistiques</h1>
</header>
    

    <?php if (!empty($error)): ?>
        <div style="color:red"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Ajouter un type</h2>
    <form method="post">
        <label>Anglais (en) : <input type="text" name="en" required></label><br>
        <label>Français (fr) : <input type="text" name="fr" required></label><br>
        <label>Néerlandais (nl) : <input type="text" name="nl" required></label><br>
        <button type="submit">Ajouter</button>
    </form>

    <h2>Liste des types</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>EN</th>
            <th>FR</th>
            <th>NL</th>
        </tr>
        <?php foreach ($data['art-types'] as $type): ?>
        <tr>
            <td><?= htmlspecialchars($type['id']) ?></td>
            <td><?= htmlspecialchars($type['en']) ?></td>
            <td><?= htmlspecialchars($type['fr']) ?></td>
            <td><?= htmlspecialchars($type['nl']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>