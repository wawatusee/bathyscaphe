<?php
class EventsModel extends FileManager
{
    private $default_event_numero;
    private $eventsData = [];

    public function __construct($repertoire)
    {
        parent::__construct($repertoire);
        $this->loadEventsData();
        $this->default_event_numero = $this->setDefaultEventNumero();
    }

    private function loadEventsData()
    {
        $filePath = '../json/vue-events-artists.json';
        $jsonData = file_get_contents($filePath);

        if ($jsonData === false) {
            throw new Exception('Impossible de lire les données des événements.');
        }

        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Erreur de décodage JSON.');
        }

        $this->eventsData = $data['events'];
        //var_dump($this->eventsData);
    }

    // Implémente isValidFile avec un comportement par défaut
protected function isValidFile(string $filename): bool
{
    return preg_match('/^n\d+\.json$/', $filename);
}


    // Implémente parseFilename pour satisfaire la déclaration abstraite
    protected function parseFilename(string $filename): array
    {
        if (preg_match('/^n(\d+)\.json$/', $filename, $matches)) {
            return [
                'event_id' => $matches[1],       // par exemple : 42
                'filename' => $filename          // par exemple : n42.json
            ];
        }

        return []; // Ne rien ajouter si le format ne correspond pas
    }



    private function setDefaultEventNumero(): string
    {
        $currentDate = date('Ymd');
        $pastEvents = [];
        $futureEvents = [];

        foreach ($this->eventsData as $event) {
            if ($event['date'] < $currentDate) {
                $pastEvents[] = $event;
            } else {
                $futureEvents[] = $event;
            }
        }

        if (empty($futureEvents)) {
            return end($pastEvents)['numero'] ?? '000';
        }

        return reset($futureEvents)['numero'] ?? '000';
    }

    public function getDefaultEventNumero(): string
    {
        return $this->default_event_numero;
    }

public function getJsonFullName($eventId): ?string
{
    $searchId = ltrim($eventId, 'n'); // supprime le "n" s'il est présent

    foreach ($this->fichiers as $fichier) {
        if ($fichier['event_id'] === $searchId) {
            return $fichier['filename'];
        }
    }
    return null;
}


    public function sortEventsWithNextEvent(): array
    {
        $currentDate = date('Y-m-d');
        $nextEvent = null;
        $futureEvents = [];
        $pastEvents = [];

        foreach ($this->eventsData as $event) {
            if (isset($event['date'])) {
                if ($event['date'] >= $currentDate) {
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
            } else {
                // Traitez les événements sans date si nécessaire
            }
        }

        usort($futureEvents, function ($a, $b) {
            return $a['date'] <=> $b['date'];
        });

        usort($pastEvents, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return [
            'nextEvent' => $nextEvent,
            'futureEvents' => $futureEvents,
            'pastEvents' => $pastEvents
        ];
    }
}