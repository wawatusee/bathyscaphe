<?php
/**
 * @author Kievu
 * Class ConfigModel
 * Import d'un fichier json config.json, contenant les datas nécessaires pour initialiser le site :
 * le comportement singlepage, les sections du site seront elles concentrées sur une page ou sur plusieurs pages.
 * le tableau des langues disponibles.
 * 
 * 
 */
class ConfigModel{
    /**
     * @var string chemin du fichier json à traiter
     */
    private $srcJson;
    /**
     * @var array config.json to array
     */
    private $configDatas;
    /**
     * @var bool  singlePage give the behaviour of the website singlePage or multipage
     */
    private $singlePage;
    /**
     * @var array langs of the website
     */
    private $langs;
    /**
    *@var array titleWebsite contains the elements of the title
    */
    private $titleWebsite;
    /**
     * @var string repImg repository of content images
     */
    private $repImg;
    /**
     * @var string repImgDeco repository of design images
     */
    private $repImgDeco;
    public function __construct(string $srcJson){
        $this->srcJson=$srcJson;
        $this->configDatas=json_decode(file_get_contents($srcJson));
        $this->set_langs();
        $this->set_singlePage();
        $this->set_title();
        $this->set_images_repository();
    }
    private function set_singlePage(){
        $this->singlePage=$this->configDatas->singlepage;
    }
    public function get_single_page_behaviour(){
        $singlePage=$this->singlePage;
        return $singlePage;
    }
    private function set_langs(){
        $this->langs=$this->configDatas->langs;
    }
    public function get_langs() {
        $langs = [];
    
        foreach ($this->langs as $lang) {
            foreach ($lang as $key => $value) {
                $langs[$key] = $value;
            }
        }
    
        return $langs;
    }
    
    public function get_config_datas(){
        return $this->configDatas;
    }
    private function set_title(){
        $this->titleWebsite=$this->configDatas->titleWebsite;
    }
    public function get_title(){
        $titleWebsite=$this->titleWebsite;
        echo $str_titleWebSite;
        return $titleWebsite;
    }
    public function get_str_title(){
        $a_titleWebsite=$this->titleWebsite;
        $str_titleWebSite='';
        foreach ($a_titleWebsite as $titleWord)
        {
            //echo $titleWord;
            $str_titleWebSite.=$titleWord;
        }
        return $str_titleWebSite;
    }

    private function set_images_repository()
    {
        $this->repImg=$this->configDatas->repImg;
        $this->repImgDeco=$this->configDatas->repImgDeco;
    }
    public function get_images_repository(){
        $repImg=$this->imgRep;
    }
    public function get_design_images_repository(){
        $repImg=$this->imgRepDeco;
    }
    
}