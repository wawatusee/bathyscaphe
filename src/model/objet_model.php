<?php class ObjetModel {
    private $scrcJson;
    private $objet;
    public function __construct($srcJson)
    {
        $this->srcJson=$srcJson;
        $this->objet=json_decode(file_get_contents($this->srcJson));
    }
    public function get_objet()
    {
        $objet_array=$this->objet;
        return $objet_array;
    }
    public function getActivityById($id)
    {
        $myActivities = $this->objet[1]->activities;
        $foundActivity = null;
    
        foreach ($myActivities as $activity) {
            if ($activity->id === $id) {
                $foundActivity = $activity;
                break;
            }
        }
    
        return $foundActivity;
    }
    
}