<?php Class EventsView{
    private $events_array;
    private $events_view="";
    private $lang;
    private $repImg;
    private $repDeco;
    public function __construct($events_array,$repMedias,$lang)
    {
        $this->events_array=$events_array[1]->activities;
        $this->refs=$events_array[0]->refs;
        $this->repImg=$repMedias.'/content/';
        $this->repDeco=$repMedias.'deco/';
        $this->lang=$lang;
    }
    public function get_events_view()
    {
        $this->events_view.='<div class="events"><div class="list-events">';
        $events=$this->events_array;
        $langue=$this->lang;
        $allTypes=$this->refs->types->{$this->lang};
        $allDates=$this->refs->dates->{$this->lang};
        foreach($events as $event):
            $id=$event->id;
            $title=$event->title;//ok
            $types=$event->types;//ok
            $lesTypes=$this->get_types($allTypes,$types);
            $when=$this->get_dates($allDates,$event->dates);//Modifier format en php pour :
            $illustration=$this->get_illustration($event->illustration);
            $where=$event->location->adress->town;//ok
            $adress=$event->location->adress->street.", ".$event->location->adress->number."<br>".$event->location->adress->postcode." ".$event->location->adress->town;
            if($event->horaire!="hh:mm"):
            $schedule=$event->horaire;
            else :$schedule=" ";
            endif;
            $cardtext="";
            $cardtext.=
<<<EVENT
        <div class="event-card" id="event-card-$id">
                <div class="card-content">
                <a class="lien-activity" href='activity.php?activityId=$id&lang=$this->lang'>+info</a>
                    <div class="chapeau">
                        <span class=cardId>$id</span>
                        <span>$where</span>
                    </div>
                    <h3>$title</h3>
                    <div class="card-date">$when</div>
                    <div class="smldescr" style="background-image:url($illustration)" >
                        <div>$lesTypes</div>
                    </div>
                    <footer><div><span>$adress</span><br><span>$schedule</span></div></footer>
                </div>
        </div>
EVENT;
        $this->events_view.=$cardtext;
        endforeach;
        $this->events_view.='</div></div>';
        return $this->events_view;
    }
    private function get_types($allTypes,$types)
    {
        $typeView="";
        foreach ($types as $type){
         //In the element refs we take the element  
            $typeView.="<span class='card-type'>".$allTypes[$type]."</span>";
        }
        return $typeView;
    }
    private function get_dates($lesDates,$dates)
    {
        $datesView="";
        foreach ($dates as $date){
            $datesView.=$lesDates[$date]."<br>";
        }
        return $datesView;
    }
    private function get_illustration($illustration)
    {
        if ($illustration!=""){
            $imgUrl=$this->repImg.$illustration;
        }else $imgUrl=$this->repImg."fleche2_blanc.svg";
        return $imgUrl;
    }
    private function getDescription($description){
        $descriptionInTheLanguage=$description;
        return $description;
    }
    private function getHours($hours){
        $hoursView=$hours;
        return $hoursView;
    }
    private function getBooking($reservation){
        $booking=$reservation;

        //$bookingContacts.=$contacts->mail;
        return $reservation;
    }
    private function getContacts($bookinglinks){
        $contacts=$bookinglinks;
        return $bookinglinks;
    }
    private function getLocation($location){
        $coordonates=[$location->coordonates->lat,$location->coordonates->lon];
        $adressView='';
        $adressView.=$location->adress->lieudit.'<br>';
        $adressView.=$location->adress->number.', '.$location->adress->street.'<br>';
        $adressView.=$location->adress->postcode.' '.$location->adress->town;
        return $adressView;
    }
    private function getCoordonates($location){
        $coordonates=[$location->coordonates->lat,$location->coordonates->lon];
        return $coordonates;
    }
    private function getPublic($public){
        $publicView="";
        foreach($public as $generation){
            $publicView.=$generation;
        }
        return $publicView;
    }

    private function getLanguages($languages){
        $languagesView="";
        foreach($languages as $language){
            $languagesView.='<span class="activity-language">'.$language.'</span>';
        }
        return $languagesView;
    }
    private function getOrganiserLink($organiserObject) {
        $lien = '';
        if (isset($organiserObject->link) && !empty($organiserObject->link)) {
            // La clé "link" existe et n'est pas vide
            $lien .= '<a href="' . $organiserObject->link . '">'.$organiserObject->name.'</a> ';
        }
        return $lien;
    }

    private function genererBooking($bookingLinksObject) {
        $liens = 'Booking via  ';
        if (isset($bookingLinksObject->link) && !empty($bookingLinksObject->link)) {
            // La clé "link" existe et n'est pas vide
            $liens .= 'Link : <a href="' . $bookingLinksObject->link . '">Bookinglink</a> ';
        }
        if (isset($bookingLinksObject->tel) && !empty($bookingLinksObject->tel)) {
            // La clé "tel" existe et n'est pas vide
            $formattedTel = '+' . substr($bookingLinksObject->tel, 1, 2) . '(0)' . substr($bookingLinksObject->tel, 4);
            $liens .= ' Tel : <a href="tel:' . $bookingLinksObject->tel . '">' . $bookingLinksObject->tel . '</a> ';
        }
        if (isset($bookingLinksObject->mail) && !empty($bookingLinksObject->mail)) {

            $liens .= '  Mail : <a href="mailto:' . $bookingLinksObject->mail . '">' . $bookingLinksObject->mail . '</a> ';
        }
        if (!empty($liens)) {
            $liens = '<div class="booking-links">' . $liens . '</div>';
        } else {
            $liens = 'Aucun lien, numéro de téléphone ou e-mail disponible';
        }
        return $liens;
    }
    public function get_event_view_by_id($eventDatas){
        $cardId=$eventDatas->id;
        $allTypes=$this->refs->types->{$this->lang};
        $lesTypes=$this->get_types($allTypes,$eventDatas->types);
        $description=$this->getDescription($eventDatas->description)->{$this->lang};
        $texteLangue=$this->refs->activitesprestexte->{$this->lang};
        $languages=$this->getLanguages($eventDatas->language);
        $illustration=$this->get_illustration($eventDatas->illustration);
        $repDeco=$this->repDeco;
        $infosPratiquesText=$this->refs->infosPratiques->{$this->lang};
        $organiserText=$this->refs->organiser->{$this->lang}.$this->getOrganiserLink($eventDatas->organisateur);
        $allDates=$this->refs->dates->{$this->lang};
        $dates=$eventDatas->dates;
        $lesDates=$this->get_dates($allDates,$dates);
        $horaires=$this->getHours($eventDatas->horaire);
        $reservation=$this->refs->reservation->{$this->lang};
        $valueBooking=$this->getBooking($eventDatas->booking)?$reservation[1]:$reservation[2];
        $textePrix=$this->refs->price->{$this->lang};
        $location=$this->getLocation($eventDatas->location);
        if($eventDatas->booking){$generatedBooking='<span class="infosbookinglink" data-field="bookinglinks">'.$this->genererBooking($eventDatas->bookinglinks).'</span>';}else $generatedBooking="";
        $activityLat=$this->getCoordonates($eventDatas->location)[0];
        $activityLon=$this->getCoordonates($eventDatas->location)[1];
        $activityView="";
        $activityView.=
<<<ACTIVITY
        '<article class="fullActivity">
            <h2 data-field="title">$eventDatas->title<button id="btnPartager" title="copy link and share"><img src=${repDeco}icons/share.png></button></h2>
            <span class=cardId data-field="id">$cardId</span>
            <div class="activity-types" data-field="types">$lesTypes</div>
            <article class="activity-description">
                <div class="activity-texte">
                    <p data-field="description">$description</p>
                    <div class=language data-field="language">$texteLangue$languages</div>
                </div>
                <div class="activity-illustration"><img src='$illustration' data-field="illustration"></div>
            </article>
            <div class="infospratik">
            <article class="infos-elements">
                <h3>$infosPratiquesText</h3>
                <span data-field="organisateur">$organiserText</span>
                <hr>
                <div>
                    <span class="infosdates" data-field="dates">$lesDates</span>
                    <span class="infosHoraires" data-field="horaire">$horaires</span>
                </div>
                <hr>
                <div class="infosresa">
                    $reservation[0]: <b><span data-field="booking">$valueBooking</span></b><br>
                    <span>$textePrix:<span data-field="price">$eventDatas->price</span> €</span>
                </div>
                <hr>
                <span class="infoslocation" data-field="location">$location</span>
                <hr>
                $generatedBooking
            </article>
            <div id="map2" class="infos-map-activity"></div>
            <script>const activityLat=$activityLat;const activityLon=$activityLon;const activityTitle="$eventDatas->title";</script>
            <script src="./js/share.js"></script>
        </div>
    </article>
    <hr>
ACTIVITY;

        return $activityView;
    }
    public function getOpenGraphView($eventDatas){
        $activityTitle="Slowwaysweekend-".$eventDatas->title;
        $activityType="article";
        $activityDescr=[explode(".",($eventDatas->description)->{$this->lang},4)][0];
        $activityImg=$this->repImg.$eventDatas->illustration;
        $activityUrl;
        $openGraphText="";
        $openGraphText.=
<<<OPENGRAPH
    <title>$activityTitle</title>
    <meta property="og:title" content="$activityTitle" />
    <meta property="og:type" content="$activityType" />
    <meta property="og:url" content="https://slowwaysweekend.be?activityId=$eventDatas->id&lang=$this->lang" />
    <meta property="og:image" content="https://slowwaysweekend.be/public/$activityImg" />
OPENGRAPH;
        return $openGraphText;
    }

}