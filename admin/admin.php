<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location: login.php");
	exit();
}

if (isset($_GET['logout'])) {
	unset($_SESSION['user']);
	header("location: login.php");
	exit();
}
//FIN SESSION
?>
<?php
//Minimum requis
require_once "../config/config.php";
//Dans config Gestion de langue
//Dans config //Répertoire global des images
//Dans config //Répertoire global des json
//Fin minimum requis pour bon fonctionnement du catalogue
?>
<?php //
//On fixe l'année sur l'année en cours
$current_year = date("Y");
if (isset($_GET['year-activity'])) {
	$current_year = $_GET['year-activity'];
}
echo "L'année courante est : " . $current_year;
?>
<!--*******************************-->
<?php
//Fusion des json activiy
// Parser le répertoire des json de l'année concernée
$rep_json = '../json/';
// Exemple de valeur pour $year_activity
$year_activity = $current_year;
//La valeur de l'année désigne le nom du répertoire du json
//Ce json contiennt toutes les activités et les traductions
$rep_json_year = $rep_json . "activities/" . $year_activity . "/";
require_once "../src/model/refsModel.php";
//$refs_datas stoque les différentes traductions utiles au site
$refs_datas = new RefsModel(JSON . "activities/refs.json");
//Ces traductions seront insérés dans le fichier json final
$refsJson = $refs_datas->get_refs();
//var_dump($refsJson);
// Initialisation du tableau pour stocker les noms des fichiers JSON
$arr_json_year_files = [];
// Vérification si le répertoire existe
if (is_dir($rep_json_year)) {
	if ($dh = opendir($rep_json_year)) {
		while (($file = readdir($dh)) !== false) {
			if (pathinfo($file, PATHINFO_EXTENSION) == 'json') {
				$prefix = $year_activity . "-activity-";
				if (strpos($file, $prefix) === 0) {
					$arr_json_year_files[] = $file;
				}
			}
		}
		closedir($dh);
	}
} else {
	echo "Le répertoire spécifié n'existe pas.";
}
// Initialisation du tableau pour stocker toutes les activités
$activities = [];
// Lecture et fusion des fichiers JSON
foreach ($arr_json_year_files as $json_file) {
	$json_path = $rep_json_year . $json_file;
	$json_data = file_get_contents($json_path);
	$activity_data = json_decode($json_data, true);
	if ($activity_data !== null) {
		$activities[] = $activity_data; // Ajout de l'activité à la liste
	} else {
		echo "Erreur de décodage JSON pour le fichier : $json_file";
	}
}
// Structure du JSON final
$json_final = [
	$refsJson,
	[
		"activities" => $activities // Liste des activités
	]
];
// Chemin et nom du fichier fédérateur
$federated_json_path = $rep_json_year . $year_activity . "-activities.json";
// Encodage en JSON et sauvegarde dans le fichier
file_put_contents($federated_json_path, json_encode($json_final, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
//echo "Le fichier fédérateur a été créé avec succès : $federated_json_path";
//Fin de fusion des json activity
?>

<!--*******************************-->

<?php
//Datas activités
//Chargements de la classe pour traitement des donnés
require_once "../src/model/eventsModel.php";
//Chargements de la classe pour traitement de la vue
require_once "../src/view/eventsView.php";
//Création d'une instance avec chargement du JSON et transformation en tableau 
$pathtojson = $rep_json_year . $year_activity . "-activities.json";
$events = new EventsModel($pathtojson);
$events_array = $events->get_catalogue();
//Définition du prochain id à utiliser pour créer une activité
$nextId = $events->get_next_id();
//Fin datas activités
?>
<?php
//Création de la vue html du programme d'activités
$events_window = new EventsView($events_array, $repMedias, $lang);
$events_display = $events_window->get_events_view();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../public/css/style.css">
	<link rel="stylesheet" href="../public/css/main.css">
	<link rel="stylesheet" href="css/activity.css">
	<title>Admin</title>
</head>
<body class="content">
	<header>
		<div class="commands-admin">
			<a href="?logout">Log out</a>
		</div>
		<h2>Welcome <?php echo $_SESSION['user']; ?><h2>
	</header>
	<div class="activity-creation">
		<span>If that seems empty, please click here : </span>
		<form action="activity-create.php" method="post">
			<input type="hidden" name="activity-id" value="<?= $nextId ?>">
			<input type="hidden" name="activity-year" value="<?= $year_activity ?>">
			<button type="submit">Create a new activity</button>
		</form>
	</div>
	<hr>
	<h3>
		Edition activités
	</h3>
	<hr>
	<?php
	//Toute la vue vient de là 
	echo $events_display ?>
	<script src="js/admin-options.js"></script>
</body>
</html>