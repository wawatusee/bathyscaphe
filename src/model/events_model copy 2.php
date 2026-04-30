<?php
//require_once("FileManager.php");

class EventsModel extends FileManager
{
    private $default_event_numero;
    private $artistMap = [];

    public function __construct($repertoire)
    {
        parent::__construct($repertoire);
        $this->artistMap = $this->loadArtistsFromDirectory('../json/artists/');
        $this->default_event_numero = $this->setDefaultEventNumero();

    }

    protected function loadArtistsFromDirectory(string $artistsDir): array
    {
        $pattern = rtrim($artistsDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'a[0-9][0-9][0-9].json';
        $files = glob($pattern);

        $map = [];

        foreach ($files as $file) {
            $jsonData = file_get_contents($file);
            if ($jsonData === false) {
                continue;
            }

            $data = json_decode($jsonData, true);
            if (
                json_last_error() === JSON_ERROR_NONE
                && isset($data['artist']['id'], $data['artist']['name'])
            ) {
                $artistId = $data['artist']['id'];
                $artistName = $data['artist']['name'];
                $map[$artistId] = $artistName;
            }
        }

        return $map;
    }

    protected function isValidFile(string $filename): bool
    {
        return $filename !== "."
            && $filename !== ".."
            && pathinfo($filename, PATHINFO_EXTENSION) === 'json';
    }

    protected function parseFilename(string $filename): array
    {
        $filepath = rtrim($this->repertoire, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        if (!file_exists($filepath)) {
            return [];
        }

        $jsonContent = file_get_contents($filepath);
        if ($jsonContent === false) {
            return [];
        }

        $data = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['event'])) {
            return [];
        }

        $event = $data['event'];
        $eventId = $event['id'] ?? null;
        $eventDate = $event['time']['date'] ?? null;
        $eventTitle = $event['title'] ?? '';
        $artistRefs = $event['artists'] ?? [];

        $numero = $eventId !== null ? 'n' . (string) $eventId : null;

        $artistNames = [];
        foreach ($artistRefs as $ref) {
            $artistNames[] = $this->artistMap[$ref] ?? $ref;
        }
        // Ex. : tracer le tableau $artistNames
        var_dump('parseFilename → $filename:', [
            'numero' => $numero,
            'date' => $eventDate,
            'artistNames' => $artistNames
        ]);
        return [
            'numero' => $numero,
            'date' => $eventDate,
            'artists' => $artistNames,
            'filename' => $filename,
            'title' => $eventTitle
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
            return end($pastEvents)['numero'] ?? '000';
        }

        return reset($futureEvents)['numero'] ?? '000';
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

    public function sortEventsWithNextEvent(): array
    {
        $currentDate = date('Y-m-d');
        $nextEvent = null;
        $futureEvents = [];
        $pastEvents = [];

        foreach ($this->fichiers as $event) {
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