<?php class artistsModel
{
    private $srcJson;
    private $objet;
    private $nameArtist;
    private $links;
    private $id;

    public function __construct($srcJson)
    {
        $this->srcJson = $srcJson;
        $this->objet = json_decode(file_get_contents($this->srcJson));
        $this->set_id();
        $this->set_links();
        $this->set_nameArtist();
    }
    public function get_objet()
    {
        $objet_array = $this->objet;
        return $objet_array;
    }
    private function get_nameArtist()
    {
        $name_artist = $this->nameArtist;
        return $name_artist;

    }
    private function set_nameArtist()
    {
        $this->nameArtist = $this->objet->artist->name;

    }
    public function get_id()
    {
        $id_artist = $this->id;
        return $id_artist;
    }
    private function set_id()
    {
        $this->id = $this->objet->id;
    }
    private function set_links()
    {
        $this->links = $this->objet->links;

    }
    public function get_links()
    {
        return $this->links;
        
    }

}



