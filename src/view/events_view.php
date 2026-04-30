<?php class EventsView
{
    private $listEvents;
    private $repImg;
    private $lang;

    public function __construct($listEvents, $repImg)
    {
        $this->listEvents = $listEvents;
        $this->repImg = $repImg;
    }

    public function getEventsViewHtml($lang, $eventsSorted)
    {
        $html = '';
        $title_nextevent_text_ml = [
            "fr" => "Prochain Événement",
            "en" => "Next events",
            "nl" => "Volgenden gebeurtenis"
        ];
        $title_pastevent_text_ml = [
            "fr" => "Événements passés",
            "en" => "Past events",
            "nl" => "Verleden gebeurtenissen"
        ];
        // Prochain événement (mis en avant)
        if ($eventsSorted['nextEvent']) {
            $html .= '<section class="next-event">';
            $html .= '<h2>' . $title_nextevent_text_ml[$lang] . '</h2>';
            $html .= $this->renderSingleEvent($eventsSorted['nextEvent'], $lang);
            $html .= '</section>';
        }

        // Événements futurs
        if (!empty($eventsSorted['futureEvents'])) {
            $html .= '<section class="future-events">';
            $html .= '<h2>Événements à venir</h2>';
            $html .= $this->renderEventsList($eventsSorted['futureEvents'], $lang);
            $html .= '</section>';
        }

        // Événements passés
        if (!empty($eventsSorted['pastEvents'])) {
            $html .= '<section class="past-events">';
            $html .= '<h2>' . $title_pastevent_text_ml[$lang] . '</h2>';
            $html .= $this->renderEventsList($eventsSorted['pastEvents'], $lang);
            $html .= '</section>';
        }

        return $html;
    }

    private function renderSingleEvent($event, $lang)
    {
        $eventId = $event['event_id'] ?? 'Unknown'; // Utilise event_id à la place de numero
        $eventName='n'.$eventId;
        $date = $event['date'] ?? 'No date';
        $artists = $event['artists'] ?? [];  // Vérifie l'existence
        $imagePath = $this->repImg .$eventName. '_sml.jpg';

        $artistList = '';
        foreach ($artists as $artist) {
            $artistList .= "<div class=\"artist\">" . htmlspecialchars($artist) . "</div>";
        }

        return <<<HTML
    <ul class="list_events">
        <li>
            <div class="card_event">
                <a href="?page=events&event=$eventName&lang=$lang">
                    <div class="card-event-date">$eventName $date</div>
                    <div class="image">
                        <img src="$imagePath" alt="Events Image">
                    </div>
                    <div class="footer">
                        $artistList
                    </div>
                </a>
            </div>
        </li>
    </ul>
    HTML;
    }


    private function renderEventsList($events, $lang)
    {
        $html = '<ul class="list_events">';
        foreach ($events as $event) {
            $eventId = $event['event_id'] ?? 'Unknown';
            $eventName='n'.$eventId;
            $date = $event['date'] ?? 'No date';
            $artists = $event['artists'] ?? [];
            //$imagePath = $this->repImg .'n'. $eventId . '_sml.jpg';
            $imagePath = $this->repImg . $eventName . '_sml.jpg';
            $artistList = '';
            foreach ($artists as $artist) {
                $artistList .= "<div class=\"artist\">" . htmlspecialchars($artist) . "</div>";
            }

            $html .= <<<HTML
        <li>
            <div class="card_event">
                <a href="?page=events&event=$eventName&lang=$lang">
                    <div class="card-event-date">$eventId $date</div>
                    <div class="image">
                        <img src="$imagePath" alt="Event Image">
                    </div>
                    <div class="footer">
                        $artistList
                    </div>
                </a>
            </div>
        </li>
        HTML;
        }
        $html .= '</ul>';
        return $html;
    }
}

