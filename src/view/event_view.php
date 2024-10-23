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
        $description=$eventDatas->description->event->$lang;
        $artist=[];
        $necessitedbook=$eventDatas->infospratiques->necessitedbook;
        $price=$eventDatas->infospratiques->price;
        $ticketlink=$eventDatas->infospratiques->ticket->link;
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
                            <span>Prix:<span data-field="price">18</span>$price</span>
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
            </section>            <article>
                <h3>Billets</h3>
                <section>
                <a href="$ticketlink" onclick="var w=window.open('$ticketlink', 'Reserver', 'width=650, height=600, top=100, left=100, toolbar=no, resizable=yes, scrollbars=yes, status=no'); w.focus(); return false;"><img style="width:200px;" src="https://www.billetweb.fr/images/buttons/billetterie_bleu.png"></a>
                </section>
            </article>
        </article>
    </section>
                

EVENTVIEWHTML;


        return $eventViewHtml;
    }
}