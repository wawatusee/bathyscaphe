<?php

/**
 * La classe ViewMenu produit les élements d'un menu au format html
 */
class ViewMenu
{
    /**
     * @var string an html usable menu
     * @param $menuArray an array wich contains most of time elements with pairs[page:"value", titre:"value"]
     */
    private $viewMenu = " ";
    private $lang;
    public function __construct($lang)
    {
        $this->lang = $lang;
    }
    public function getViewMainMenu(array $menuArray, $singlePage = true)
    {
       // $this->viewMenu .= "<div class='links'>";
        foreach ($menuArray as $item) {
            if ($singlePage) {
                $this->viewMenu .= "<a class='itemMenu' href=#" . $item->page . ">" . $item->titre->{$this->lang} . "</a>";
            } else $this->viewMenu .= "<a  href=" . "?page=" . $item->page . ">" . $item->titre->{$this->lang} . "</a>";
        }
        //$this->viewMenu .= "</div>";
        $viewMenu = $this->viewMenu;
        return $viewMenu;
    }
    public function getViewMainMenuFromExt(array $menuArray, $singlePage = true)
    {
        foreach ($menuArray as $item) {
            $this->viewMenu .= "<a class='itemMenu' href='index.php?lang=" . $this->lang . "#" . $item->page . "'>" . $item->titre->{$this->lang} . "</a>";
        }
        $viewMenu = $this->viewMenu;
        return $viewMenu;
    }
}
