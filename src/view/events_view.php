<?php class EventsView {
    private $listEvents;
    private $repImg;
    private $lang;

    public function __construct($listEvents, $repImg) {
        $this->listEvents = $listEvents;
        $this->repImg = $repImg;
    }

    public function getEventsViewHtml($lang) {
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
    }

        public function get_event_view_by_id($event, $lang) {
            // Hydratation des variables

    
            // Construction de la vue
            $html = <<<HTML
            <span>LE TITRE : $title</span>;
            
    HTML;
    
            return $html;
        }
    }
    

