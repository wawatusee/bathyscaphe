
<?php
//Load refs-contact
require_once"../src/model/objet_model.php";
$refsContact=(New ObjetModel("../json/contact/refs-contact.json"))->get_objet();
//Construct contact content wich is a mixed of direct value with refs-cont
?>
<section>
<article>
        <h2><?=$refsContact->refs_contact->title->$lang?></h2>
        <p><?= $refsContact->refs_contact->advise->$lang?></p>
        <div class="contacts-container">
            <ul class="contacts">
                <li> <a class=" contacts-maillink" href='mailto:info@bathyscaphe.be'>info@bathyscaphe.be</a><br>
                </li>
                <li><a class="contacts-phonelink" href='tel:+32485966694'>+32(0)485 96 66 94</a>
                </li>
                <li>
                    <address class="contacts-adress"><?= $refsContact->refs_contact->address->$lang ?></address>
                </li>
            </ul>
        </div>
    </article>
</section>