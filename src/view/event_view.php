<?php class EventView{
    private $eventDatas;
    public function __construct($eventModel){
        $this->eventDatas=$eventModel->event;
    } 
    public function getEventView($lang){
        $eventDatas=$this->eventDatas;
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
                

EVENTVIEWHTML;


        return $eventViewHtml;
    }
}