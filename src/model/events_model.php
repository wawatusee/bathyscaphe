
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
}
