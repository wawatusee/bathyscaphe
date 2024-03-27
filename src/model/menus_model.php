<?php
/**
* @author Kievu
*Class MenusModel
*Permet d'importer un fichier au format json et de renvoyer son contenu sous forme de tableau
*/
class MenusModel{
    /**
     * @var string chemin du fichier json qui va être traité 
     */
    private $srcJson;
     /**
     * @var array valeur de php du fichier json importé
     */
    private $menus;
   // private $types;
    public function __construct(string $srcJson){
        $this->srcJson=$srcJson;
        $this->menus=json_decode(file_get_contents($srcJson));
    }
    /**
     * @param string $menuType could be "main","RS",..
     * @return array $menu_array wich could feed an instance of menuView
     */
    public function getMenu(string $menuType){
        $menu_array=$this->menus->$menuType;
        return $menu_array;
    }
}