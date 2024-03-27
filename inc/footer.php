<footer>
    <section id="sitemap">
        <h2>Links</h2>
            <div class="footerNav">
                <nav class="navfooterbloc">
                    <h3>Contacts</h3>
                    <a href="info@annebsollis.com">info@bathyscaphe.be</a>
                    <a href="tel:+32485966694">+32(0)485 96 66 94</a>
                    <address>rue Dieudonné Lefèvre, 215<br> 1020 Brussels - Belgium</address>
                </nav>
                <nav class="navfooterbloc">
                    <h3>Menu</h3>
                    <?php echo $menuMain_view?>
                </nav>
            </div>
    </section>
    <nav id="menuRS" class="nav-rs">
        <?php 
                    foreach($menuRS as $item){
                        echo "<a href=".$item->page." title='".$item->titre."' target='_blank'><div class='rs ".$item->titre."'></div></a>";
                    }
        ?>
    </nav>

</footer>