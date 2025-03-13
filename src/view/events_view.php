<?php class EventsView {
    private $listEvents;
    private $repImg;
    private $lang;

    public function __construct($listEvents, $repImg) {
        $this->listEvents = $listEvents;
        $this->repImg = $repImg;
    }

    /*public function getEventsViewHtml($lang) {
        $html = '<ul class="list_events">';
        $lang=$lang;

        foreach ($this->listEvents as $event) {
            $numero = $event['numero'];
            $date = $event['date'];
            $artists = $event['artists'];
            $imagePath = $this->repImg . $numero . '_sml.jpg';

            $artistList = '';
            foreach ($artists as $artist) {
                $artistList .= "<div class=\"artist\">" . htmlspecialchars($artist) . "</div>";
            }

            $html .= <<<HTML
<li>
    
    <div class="card_event">
        <a href="?page=events&event=$numero&lang=$lang">
            <div class="date">$date</div>
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
    }*/
    public function getEventsViewHtml($lang, $eventsSorted) {
        $html = '';

        // Prochain événement (mis en avant)
        if ($eventsSorted['nextEvent']) {
            $html .= '<section class="next-event">';
            $html .= '<h3>Prochain Événement</h3>';
            $html .= $this->renderSingleEvent($eventsSorted['nextEvent'], $lang);
            $html .= '</section>';
        }

        // Événements futurs
        if (!empty($eventsSorted['futureEvents'])) {
            $html .= '<section class="future-events">';
            $html .= '<h3>Événements à venir</h3>';
            $html .= $this->renderEventsList($eventsSorted['futureEvents'], $lang);
            $html .= '</section>';
        }

        // Événements passés
        if (!empty($eventsSorted['pastEvents'])) {
            $html .= '<section class="past-events">';
            $html .= '<h3>Événements Passés</h3>';
            $html .= $this->renderEventsList($eventsSorted['pastEvents'], $lang);
            $html .= '</section>';
        }

        return $html;
    }

    private function renderSingleEvent($event, $lang) {
        // Méthode pour rendre un événement unique (plus de détails)
        $numero = $event['numero'];
        $date = $event['date'];
        $artists = $event['artists'];
        $imagePath = $this->repImg . $numero . '_sml.jpg';

        $artistList = implode(', ', $artists);

        return <<<HTML
        <div class="next-event-card">
            <a href="?page=events&event=$numero&lang=$lang">
                <div class="date">$date</div>
                <div class="image">
                    <img src="$imagePath" alt="Next Event Image">
                </div>
                <div class="artists">$artistList</div>
            </a>
        </div>
        HTML;
    }

    private function renderEventsList($events, $lang) {
        $html = '<ul class="list_events">';
        foreach ($events as $event) {
            $numero = $event['numero'];
            $date = $event['date'];
            $artists = $event['artists'];
            $imagePath = $this->repImg . $numero . '_sml.jpg';
    
            $artistList = '';
            foreach ($artists as $artist) {
                $artistList .= "<div class=\"artist\">" . htmlspecialchars($artist) . "</div>";
            }
    
            $html .= <<<HTML
            <li>
                <div class="card_event">
                    <a href="?page=events&event=$numero&lang=$lang">
                        <div class="date">$date</div>
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

