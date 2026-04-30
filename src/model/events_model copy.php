<?php
/**
 * Gestionnaire d'événements basé sur des fichiers JSON
 * 
 * Classe concrète qui étend FileManager pour gérer des événements stockés dans des fichiers JSON
 * avec le format : [numero]_[date]_[artiste1]_[artiste2].json
 * 
 * Fournit des méthodes pour :
 * - Lister et parser les événements
 * - Trouver l'événement par défaut (prochain ou dernier)
 * - Trier les événements passés/futurs
 * - Retrouver un fichier par son numéro
 */
class EventsModel extends FileManager
{
    private $default_event_numero;

    public function __construct($repertoire)
    {
        parent::__construct($repertoire);
        $this->default_event_numero = $this->setDefaultEventNumero();
    }

    protected function isValidFile(string $filename): bool
    {
        return $filename !== "."
            && $filename !== ".."
            && $filename !== "refs_events.json"
            && pathinfo($filename, PATHINFO_EXTENSION) === 'json';
    }
    /**
     * Lit et analyse le contenu JSON d'un fichier d'événement,
     * puis renvoie les informations nécessaires au reste de la classe.
     *
     * @param string $filename Nom du fichier (ex: "n1_2024-04-13_Asetone_Esteban-Stan_3DB.json")
     * @return array Tableau associatif contenant notamment 'numero', 'date', 'artists', 'filename'
     */
    protected function parseFilename(string $filename): array
    {
        // Construire le chemin complet
        $filepath = rtrim($this->repertoire, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . $filename;

        // Vérifier que le fichier existe
        if (!file_exists($filepath)) {
            return [];
        }

        // Lire le contenu du fichier
        $jsonContent = file_get_contents($filepath);
        if ($jsonContent === false) {
            return [];
        }

        // Décoder le JSON en tableau associatif
        $data = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['event'])) {
            return [];
        }

        // Récupérer la partie 'event'
        $event = $data['event'];

        // Extraire les propriétés dont vous avez besoin
        $eventId = $event['id'] ?? null;             // Par exemple : 1
        $eventDate = $event['time']['date'] ?? null;            // Par exemple : "2024-04-13"
        $eventTitle = $event['title'] ?? '';               // Facultatif : "Navigation #1..."
        $artists = $event['artists'] ?? [];               // Par exemple : ["a001","a002","a003"]

        // Pour conserver la même logique que votre code existant,
        // qui cherche un "numero" commençant par "n", on peut préfixer l'id :
        $numero = $eventId !== null ? 'n' . (string) $eventId : null;

        // Renvoyer les infos au format attendu
        return [
            'numero' => $numero,         // ex : "n1"
            'date' => $eventDate,      // ex : "2024-04-13"
            'artists' => $artists,        // ex : ["a001","a002","a003"]
            'filename' => $filename,       // le nom du fichier JSON, ex : "n1_2024-04-13_Asetone_Esteban-Stan_3DB.json"

            // Facultatif : conserver ici d'autres détails si utile
            'title' => $eventTitle,
            'raw' => $event          // juste pour référence, si vous souhaitez le transmettre plus loin
        ];
    }
    /*protected function parseFilename(string $filename): array
    {
        $fullfilename = $filename;
        $filename = basename($filename, ".json");
        $parts = explode('_', $filename);

        return [
            'numero' => $parts[0] ?? null,
            'date' => $parts[1] ?? null,
            'artists' => array_map(function ($artist) {
                return str_replace('-', ' ', $artist);
            }, array_slice($parts, 2)),
            'filename' => $fullfilename,
        ];
    }*/
    /*Pour remplacer parseFilename par une méthode qui ouvre les json pour en extraire les infos */
    /**
     * Analyse le contenu d'un fichier JSON d'événement et extrait les informations pertinentes
     * 
     * @param string $filepath Chemin complet vers le fichier JSON à analyser
     * @return array Tableau contenant les informations de l'événement ou tableau vide en cas d'erreur
     */
    protected function extractEventDataFromJson(string $filepath): array
    {
        // Vérification de l'existence du fichier
        if (!file_exists($filepath)) {
            return [];
        }

        // Lecture et décodage du contenu JSON
        $content = file_get_contents($filepath);
        if ($content === false) {
            return [];
        }

        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['event'])) {
            return [];
        }

        $event = $data['event'];

        // Extraction des données essentielles
        $eventId = $event['id'] ?? null;
        $eventDate = $event['time']['date'] ?? null;

        // Extraction des artistes - peut être soit un tableau d'IDs, soit directement les noms
        $artistIds = $event['artists'] ?? [];

        // Extraction d'autres informations utiles (à adapter selon vos besoins)
        $eventTitle = $event['title'] ?? '';
        $eventIllustration = $event['illustration'] ?? '';
        $eventActivityTypes = $event['activity_type_ids'] ?? [];

        // Construction du résultat qui conserve la structure existante
        // pour compatibilité avec le reste du code
        return [
            'numero' => (string) $eventId,  // Conversion en string pour compatibilité
            'date' => $eventDate,
            'artists' => $artistIds,       // IDs des artistes au lieu des noms
            'filename' => basename($filepath),
            // Données additionnelles qui pourraient être utiles
            'title' => $eventTitle,
            'illustration' => $eventIllustration,
            'activity_types' => $eventActivityTypes,
            // Stocker l'objet event complet si besoin d'accès à d'autres propriétés
            'eventData' => $event
        ];
    }
    /*Fin de la méthode  extractEventDataFromJson*/

    private function setDefaultEventNumero(): string
    {
        $currentDate = date('Ymd');
        $pastEvents = [];
        $futureEvents = [];

        foreach ($this->fichiers as $fichier) {
            if ($fichier['date'] < $currentDate) {
                $pastEvents[] = $fichier;
            } else {
                $futureEvents[] = $fichier;
            }
        }

        if (empty($futureEvents)) {
            return end($pastEvents)['numero'] ?? '000'; // Valeur par défaut
        }

        return reset($futureEvents)['numero'] ?? '000'; // Valeur par défaut
    }

    public function getDefaultEventNumero(): string
    {
        return $this->default_event_numero;
    }

    public function getJsonFullName($numero): ?string
    {
        foreach ($this->fichiers as $fichier) {
            if ($fichier['numero'] === $numero) {
                return $fichier['filename'];
            }
        }
        return null;
    }
    //Methode créée par Claude
    public function sortEventsWithNextEvent()
    {
        $currentDate = date('Y-m-d'); // Changez le format ici
        //echo $currentDate;
        $nextEvent = null;
        $futureEvents = [];
        $pastEvents = [];

        foreach ($this->fichiers as $event) {
            if ($event['date'] >= $currentDate) { // Comparaison directe maintenant possible
                // Si c'est le premier événement futur, il devient le nextEvent
                if ($nextEvent === null || $event['date'] < $nextEvent['date']) {
                    if ($nextEvent !== null) {
                        $futureEvents[] = $nextEvent;
                    }
                    $nextEvent = $event;
                } else {
                    $futureEvents[] = $event;
                }
            } else {
                $pastEvents[] = $event;
            }
        }

        // Trier les événements futurs et passés
        usort($futureEvents, function ($a, $b) {
            return $a['date'] <=> $b['date']; // Du plus proche au plus lointain
        });

        usort($pastEvents, function ($a, $b) {
            return $b['date'] <=> $a['date']; // Du plus récent au plus ancien
        });

        return [
            'nextEvent' => $nextEvent,
            'futureEvents' => $futureEvents,
            'pastEvents' => $pastEvents
        ];
    }
}
