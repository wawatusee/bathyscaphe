<?php class EventsView {
    private $listEvents;
    private $repImg;

    public function __construct($listEvents, $repImg) {
        $this->listEvents = $listEvents;
        $this->repImg = $repImg;
    }

    public function getEventsViewHtml() {
        $html = '<ul class="list_events">';

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
    <a href="">
    <div class="card_event">
        <div class="date">$date</div>
        <div class="image">
            <img src="$imagePath" alt="Event Image">
        </div>
        <div class="footer">
            $artistList
        </div>
    </div>
    </a>
</li>
HTML;
        }

        $html .= '</ul>';
        return $html;
    }
}
