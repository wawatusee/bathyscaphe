<?php
function listerContenuRepertoire($repertoire) {
    // Vérifie si le chemin est un répertoire
    if (is_dir($repertoire)) {
        // Ouvre le répertoire
        if ($dh = opendir($repertoire)) {
            $fichiers = [];
            // Parcourt tous les fichiers et dossiers dans le répertoire
            while (($file = readdir($dh)) !== false) {
                // Ignore les . et ..
                if ($file != "." && $file != "..") {
                    $fichiers[] = $file;
                }
            }
            // Ferme le répertoire
            closedir($dh);
            return $fichiers;
        } else {
            return "Impossible d'ouvrir le répertoire.";
        }
    } else {
        return "Le chemin spécifié n'est pas un répertoire.";
    }
}


function genererListeEvenements($fichiers) {
    $listeHtml = '<ul>';
    
    foreach ($fichiers as $fichier) {
        // Vérifier si le fichier est un fichier JSON
        if (pathinfo($fichier, PATHINFO_EXTENSION) == 'json') {
            // Supprimer l'extension .json pour obtenir le nom de base
            $nomBase = pathinfo($fichier, PATHINFO_FILENAME);
            
            // Séparer les différentes parties du nom de fichier
            $parties = explode('_', $nomBase);
            
            if (count($parties) >= 3) {
                // Extraire les informations
                $numero = substr($parties[0], 1); // Supprime le "n" initial
                $date = $parties[1];
                $texteDescriptif = "Navigation " . $numero;
                
                // Générer l'élément de liste HTML
                $listeHtml .= '<li>';
                $listeHtml .= '<a href="' . $fichier . '">' . $date . ' - ' . $texteDescriptif . '</a>';
                $listeHtml .= '</li>';
            }
        }
    }
    
    $listeHtml .= '</ul>';
    
    return $listeHtml;
}
?>
