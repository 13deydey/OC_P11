 
<section class="modale-contact" id="modale-contact">
    <!--En display:none-->
    <div class="modale-content">
        <div class="titre">CONTACT</div>
        <?php echo do_shortcode('[contact-form-7 id="39285c9" title="ModaleContact"]'); ?>
    </div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/script.js"></script>
<!-- intègre le script JS -->

<footer>
    <div class="footer_content">
        <nav id="site-navigation" class="nav_menu" role="navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer', // L'identifiant (slug) que vous avez déclaré dans functions.php
                'container'      => false,     // Ne pas envelopper le menu dans un div (utilise directement <ul>)
                'menu_class'     => 'footer-menu', // La classe CSS appliquée au <ul> du menu
                'depth'          => 2,         // Niveau de profondeur autorisé (ex: 2 pour sous-menus)
            ) );
            ?>
        </nav>
    </div>
</footer>
</body>
</html>