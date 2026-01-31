<?php

/**
 * Template Name: Single Photo Page
 */

get_header(); 

?>

<section class="single_photo_section">
    <div class="photo_container">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="photo_informations">
                <?php the_title( '<h2 class="entry-title">', '</h2>' ); //the_title ≠ get_the_title bc inclus echo  ?> 
                <p>RÉFÉRENCE : <?php the_field('reference'); ?></p>
                <?php 
                    // --- RÉCUPÉRATION DE LA TAXONOMIE CATÉGORIE ---
                    $terms_cat = get_the_terms( get_the_ID(), 'categorie' );
                    if ( ! empty( $terms_cat ) && ! is_wp_error( $terms_cat ) ) : ?>
                        <p>CATÉGORIE : <?php echo esc_html( $terms_cat[0]->name ); ?></p>
                <?php endif; ?>
                <?php 
                    // --- RÉCUPÉRATION DE LA TAXONOMIE FORMAT ---
                    $terms_format = get_the_terms( get_the_ID(), 'format' );
                    if ( ! empty( $terms_format ) && ! is_wp_error( $terms_format ) ) : ?>
                        <p>FORMAT : <?php echo esc_html( $terms_format[0]->name ); ?></p>
                <?php endif; ?>
                <p>TYPE : <?php the_field('type'); ?></p>
                <?php 
                    // --- RÉCUPÉRATION DE LA TAXONOMIE ANNÉE ---
                    $terms_annee = get_the_terms( get_the_ID(), 'annee' );
                    if ( ! empty( $terms_annee ) && ! is_wp_error( $terms_annee ) ) : ?>
                        <p>ANNÉE : <?php echo esc_html( $terms_annee[0]->name ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="photo_showcase">
                    <?php the_post_thumbnail( 'full' ); // Formats possibles 'thumbnail', 'medium', 'large' ou 'full' ?>
                </div>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/default_img.png" alt="Image par défaut">
            <?php endif; ?>

            <?php endwhile;  ?>
    </div>
    <div class="more">
        <div class="cta_button">
            <p>Cette photo vous intéresse ? </p>
            <span class="contact_cta"
                data-reference="<?php the_field('reference'); ?>"
                >
                Contact 
            </span>
        </div>
        <div class="preview_next">
        <?php 
            // Récupérer la référence actuelle du CPT pour la navigation avec les flèches via JS et AJAX
            $current_photo_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); //get_the_post_thumbnail_url récupère l'URL de l'image mise en avant sans l'afficher
        ?>
            <img src="" alt="Aperçu de la photo suivante" class="preview_image">
            <div class="arrows_navigation">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/left_arrow.svg" alt="Précédente" class="preview_arrow">                         
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/right_arrow.svg" alt="Suivante" class="next_arrow">      
            </div> 
        </div>
    </div>
    <p><?php the_content(); ?></p>

    <div class="other_photos_section">
        <h3>Vous aimerez aussi </h2>
        <div class="other_photos_container">
            <a href="<?php //lien vers la photo 1 ?>" class="other_photo_item">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/nathalie-1.jpeg" alt="Photo 1">
            </a>
            <a href="<?php //lien vers la photo 2 ?>" class="other_photo_item">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/nathalie-2.jpeg" alt="Photo 2">
            </a>
        </div>
    </div>
</section>


<?php get_footer(); ?>