<?php
/**
 * Template Name: Modale Contact
 */

get_header(); 
?>

<section class="modale-contact" id="modale-contact">
    <!--En display:none-->
    <div class="modale-content">
        <div class="titre">CONTACT</div>
        <?php echo do_shortcode('[contact-form-7 id="dc1223f" title="ModaleContact"]'); ?>
    </div>
</section>


<?php get_footer(); ?>