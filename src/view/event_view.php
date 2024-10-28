<?php class EventView{
    private $eventDatas;
    public function __construct($eventModel){
        $this->eventDatas=$eventModel->event;
    } 
    public function getEventView($lang){
        $eventDatas=$this->eventDatas;
        $id=$eventDatas->id;
        $date=$eventDatas->time->date;
        $horaire=$eventDatas->time->horaire->$lang;
        $title=$eventDatas->title;
        $illustration=$eventDatas->illustration;
        $description=$eventDatas->description_event->$lang;
        $artist=[];
        $necessitedbook=$eventDatas->infospratiques->necessitedbook;
        $price=$eventDatas->infospratiques->price;
        $ticketlink=$this->getTicketButtonHtml($date);
        $eventViewHtml='';
        $eventViewHtml.=<<<EVENTVIEWHTML
        <section class="core">
            <h2>Event</h2>
            <section id="activity">
                <article class="fullActivity">
                <div>
                    <span class="infosdates" data-field="dates">$date</span>
                    <span class="infosHoraires" data-field="horaire">$horaire</span>
                </div>
                <h3 data-field="title">$title<h3>
                <div class="activity-illustration"><img src="/public/img/content/events/$illustration" data-field="illustration"></div>
                <div class="activity-types" data-field="types">
                <span class="card-type">exposition</span>
                <span class="card-type">Repas</span>
                <span class="card-type">concert</span>
            </div>
            <article class="activity-description">
            <div class="activity-texte">
                    <p data-field="description">
                    $description
                    </p>
                </div>
            </article>
            <article>
                <h3>Infos pratiques</h3>
                <section class="infospratik">
                    <article class="infos-elements">
                        <span data-field="organisateur">Organisateur : <a href="https://www.bathyscaphe.be/">Bathyscaphe.be</a></span>
                        <hr>
                        <div>
                            <span class="infosdates" data-field="dates">$date<br></span>
                            <span class="infosHoraires" data-field="horaire">$horaire</span>
                        </div>
                        <hr>
                        <div class="infosresa">
                            Réservation obligatoire: <b><span data-field="booking">$necessitedbook</span></b><br>
                            <span>Prix:<span data-field="price"></span> $price</span>
                        </div>
                        <hr>
                        <span class="infoslocation" data-field="location">Rue Dieudonné Lefèvre 215<br>Bruxelles<br>Belgique</span>
                    </article>
                    <div id="map2" class="infos-map-activity"></div>
                <script src="./js/share.js"></script>
                <script src="./js/mapbathy.js"></script>
                </section>
            </article>
            <br>
            <hr>
            </section>
                <article>
                    <h3>Billets</h3>
                    <section> 
                        $ticketlink
                    </section>
                </article>
        </article>
    </section>
    </section>
                

EVENTVIEWHTML;


        return $eventViewHtml;
    }
    private function getTicketButtonHtml($date) {
        $currentDate = new DateTime();
        $eventDate = new DateTime($date);
    
        if ($currentDate > $eventDate->modify('+1 day')) {
            return "<p>L'événement est terminé. Merci pour votre intérêt !</p>";
        } elseif (!empty($this->eventDatas->infospratiques->ticket->link)) {
            $ticketlink = $this->eventDatas->infospratiques->ticket->link;
            return "<a href=\"$ticketlink\" onclick=\"var w=window.open('$ticketlink', 'Reserver', 'width=650, height=600, top=100, left=100, toolbar=no, resizable=yes, scrollbars=yes, status=no'); w.focus(); return false;\">
                        <img style=\"width:200px;\" src=\"https://www.billetweb.fr/images/buttons/billetterie_bleu.png\">
                    </a>";
        } else {
            return "<p>Les billets ne sont pas encore disponibles.</p>";
        }
    }
    
    public function getEventForm($lang) {
        $eventDatas = $this->eventDatas;
        $id = $eventDatas->id;
        $date = $eventDatas->time->date;
        $horaire = $eventDatas->time->horaire->$lang;
        $title = $eventDatas->title;
        $description = $eventDatas->description_event->$lang;
        $necessitedbook = $eventDatas->infospratiques->necessitedbook ? "checked" : "";
        $price = $eventDatas->infospratiques->price;
    
        $eventFormHtml = <<<EVENTFORMHTML
    <form id="eventForm">
        <h2>Modifier l'Événement</h2>
        <input type="hidden" name="id" value="$id">
        
        <label>Date: <input type="date" name="date" value="$date" required></label><br>
        <label>Horaire: <input type="text" name="horaire" value="$horaire" required></label><br>
        <label>Titre: <input type="text" name="title" value="$title" required></label><br>
        <label>Description: <textarea name="description" required>$description</textarea></label><br>
        
        <label>Nécessité de réservation: <input type="checkbox" name="booking" $necessitedbook></label><br>
        <label>Prix: <input type="text" name="price" value="$price" required></label><br>
        
        <button type="button" id="submitEvent">Sauvegarder l'événement</button>
    </form>
    EVENTFORMHTML;
    
        return $eventFormHtml;
    }
}