<footer>

            <div class="footerNav">

                <nav class="navfooterbloc">
                    <h2>Contacts</h2>
                    <a class="maillink" href="info@bathyscaphe.be">info@bathyscaphe.be</a>
                    <a class="phonelink" href="tel:+32485966694">+32(0)485 96 66 94</a>
                    <address class="situationlink">rue Dieudonné Lefèvre, 215<br> 1020 Brussels - Belgium</address>
                </nav>
                <nav class="navfooterbloc">
                    <h2>Menu</h2>
                    <?php echo $menuMain_view?>
                </nav>
            </div>
            <img class="footer-logo" src="<?=$repImgDeco?>logo.png" alt="">

    <nav id="menuRS" class="nav-rs">
        <?php 
                    foreach($menuRS as $item){
                        echo "<a href=".$item->page." title='".$item->titre."' target='_blank'><div class='rs ".$item->titre."'></div></a>";
                    }
        ?>
    </nav>
</footer>