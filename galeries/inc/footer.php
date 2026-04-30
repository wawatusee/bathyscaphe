<footer>
    <div class="footerNav">
        <nav class="navfooterbloc">
            <h3>Menu</h3>
            <?php echo $menuMain_view ?>
        </nav>
        <nav class="navfooterbloc">
            <h3>Contacts</h3>
            <a class="maillink" href="mailto:anne@wawatusee.com">info[at]wawatusee.com</a>
           <!-- <a class="phonelink" href="tel:+41762416369">Tel : +41 76 241 63 69</a>-->
            <!--<a class="whatsapplink" aria-label="Chat on WhatsApp" href="https://wa.me/+32484708131">whats app</a>-->
        </nav>

    </div>
    <nav id="menuRS" class="nav-rs">
        <?php
        foreach ($menuRS as $item) {
            echo "<a href=" . $item->page . " title='" . $item->titre . "' target='_blank'><div class='rs " . $item->titre . "'></div></a>";
        }
        ?>
    </nav>
</footer>