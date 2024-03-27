<h1>Bathyscaphe</h1>
<?php
$repJson="../json/";
//New datas incoming
$objets= new ObjetModel($repjson."magasin.json");
var_dump($objets);
?>
<section>
    <h1>Liste matériel studio</h1>
    <p>Matériel envisagé pour le studio du Bathyscaphe.</p>
    <ul>
    <?php foreach ($objets as $objet):
<<<OBJET
        <li>
            <div>
                
            </div>
        </li>
OBJET;
    endforeach;
    ?>
    </ul>
</section>