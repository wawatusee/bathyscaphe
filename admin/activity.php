<?php 
	session_start();
	if(!isset($_SESSION['user'])){
		header("location: login.php");
		exit();
	}

	if(isset($_GET['logout'])){
		unset($_SESSION['user']);
		header("location: login.php");
		exit();
	}
//FIN SESSION

//Minimum requis
require_once "../config/config.php";
//Dans config Gestion de langue
//Dans config //Répertoire global des images
//Fin de gestion de langue
//Gestion des répertoires : sources partagés avec le site public
?>
<!--Datas activités-->
<!--Créer variables pour cibler la bonne année et cibler les répertoires correspondant-->
<?php 
if(isset($_GET["activityYear"])){
    $year_activity=$_GET["activityYear"];
}else $year_activity="2024";
Echo ("Année de l'activités : ".$year_activity.'<br>');
?>
<?php
//Chargements de la classe pour traitement des donnés
require_once "../src/model/eventsModel.php";
//Chargements de la classe pour traitement de la vue
require_once "../src/view/eventsView.php";
//Création d'une instance avec chargement du JSON et transformation en tableau 
//$events= new EventsModel("../json/activities.json");
//
$events= new EventsModel("../json/activities/".$year_activity."/".$year_activity."-activities.json");
$events_array=$events->get_catalogue();
$events_window=new EventsView($events_array,$repMedias,$lang);
$events_display=$events_window->get_events_view();
?>
<?php
//Récupération de l'id de l'activité
if(isset($_GET["activityId"])){
 $activityId = $_GET["activityId"];
 //Récupération des données de l'activité
 $activityModel=$events->getActivityById($activityId);
 $activityView=$events_window->get_event_view_by_id($activityModel);
}else $activityView=$events_display;
//Fin minimum requis
?>

<!--Vue de l'activité-->
<!DOCTYPE html>
<html lang=<?=$lang?>>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../public/css/style.css">
		<link rel="stylesheet" href="../public/css/main.css">
        <link rel="stylesheet" href="css/activity.css">
		<!--<link rel="stylesheet" href="admin.css">-->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
		<title>Admin</title>
	</head>
    <body class="content">
        <header>
            <div class="commands-admin">
                <a href="?logout">Log out</a>
                <div class="menulangues">
                <?php //Liste déroulante des langues
                echo '<form method="get">';
                echo '<select name="lang" id="lang" onchange="this.form.submit()">';
                foreach ($langues_disponibles as $code_langue => $nom_langue) {
                    echo '<option value="' . $code_langue . '"';
                    if ($lang === $code_langue) {
                        echo ' selected';
                    }
                    echo '>' . $code_langue . '</option>';
                }
                echo '</select>';
                echo '<input type="hidden" name="activityId" value='.$activityId.'>';
                echo '</form>';
                //Fin liste déroulante des langues?>
                </div>
                 <a href="admin.php">activities</a>
            </div>
            <h2>Welcome <?php echo $_SESSION['user']; ?><h2>
        </header>
        <hr>
        <main>
            <section id="activity">
                <h3>Edition activité<span><button id="btn-update">MAJ</button></span></h3>
                <?php echo $activityView?>
            </section>
        <main>
    </body> 
    <script id="db_json">
            const db_json=<?php echo json_encode($events_array,true)?>
    </script>
    <script src="js/activity-admin.js" type="module"></script>
    <script>//Carte d'activité
        const map2 = L.map('map2').setView([50.85045, 4.34878], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map2);
        // Ajouter un marqueur aux coordonnées après chargement de la page
        document.addEventListener("DOMContentLoaded", function() {
        // Attendre que le DOM soit complètement chargé
        // Récupérer les coordonnées de latitude et de longitude depuis vos constantes
        const latitude = activityLat;
        const longitude = activityLon;
        const titreActivity=activityTitle;
        // Créer un marqueur et ajoutez-le à votre carte map2
        const marker = L.marker([latitude, longitude]).addTo(map2);
        //Ajouter une popup au marqueur
        marker.bindPopup(titreActivity).openPopup();
        });
    </script>
</html>