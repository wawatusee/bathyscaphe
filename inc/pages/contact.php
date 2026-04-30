<?php
//Load refs-contact
require_once "../src/model/objet_model.php";
$refsContact = (new ObjetModel("../json/contact/refs-contact.json"))->get_objet();
//Construct contact content wich is a mixed of direct value with refs-cont
?>
<section>
    <article>
        <h2><?= $refsContact->refs_contact->title->$lang ?></h2>
        <p><?= $refsContact->refs_contact->advise->$lang ?></p>
        <div class="contacts-container">
            <address class="contacts">
                <a class=" contacts-maillink" href='mailto:info@bathyscaphe.be'>info@bathyscaphe.be</a>
                <a class="contacts-phonelink" href='tel:+32485966694'>+32(0)485 96 66 94</a>
                <div class="contacts-adress"><?= $refsContact->refs_contact->address->$lang ?></div>
            </address>
        </div>
    </article>
</section>