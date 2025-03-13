
<?php
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

    protected function parseFilename(string $filename): array
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
    }

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
        echo $currentDate;
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
        usort($futureEvents, function($a, $b) {
            return $a['date'] <=> $b['date']; // Du plus proche au plus lointain
        });
        
        usort($pastEvents, function($a, $b) {
            return $b['date'] <=> $a['date']; // Du plus récent au plus ancien
        });
        
        return [
            'nextEvent' => $nextEvent,
            'futureEvents' => $futureEvents,
            'pastEvents' => $pastEvents
        ];
    }
}
