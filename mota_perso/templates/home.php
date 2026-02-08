<?php

/**
 * Template Name: Home Page
 */

get_header(); 

?>

<section id="hero_section" class="hero_section">
    <hgroup class="hero_header">
        <?php while ( have_posts() ) : the_post(); ?>
            <h1 class="hero_title"><?php the_field('herotitle'); ?></h1>
            <img src="<?php the_field('heroimg'); ?>" />
        <?php endwhile; // end of the loop. ?>
    </hgroup>
</section><!-- #primary -->

<section id="galerie_section" class="galerie_section"> 
    <div class="galerie_filtre">
        <div class="filter_gauche">
            <div class="category_filter">
            <!--//filtre à récupérer dynamiquement via la taxnomie categorie-->
                <select id="categorySelect">
                    <option value="">Catégories</option>
                    <?php
                    $categories = get_terms( array(
                        'taxonomy' => 'categorie',
                        'orderby'  => 'name',
                        'order'    => 'ASC',
                        'hide_empty' => true,
                    ) );

                    foreach ( $categories as $category ) {
                        echo '<option value="' . esc_attr( $category->term_id ) . '">' . esc_html( $category->name ) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="format_filter">
            <!--//filtre à récupérer dynamiquement via la taxnomie Format-->
                <select id="formatSelect">
                    <option value="">Formats</option>
                    <?php
                    $formats = get_terms( array(
                        'taxonomy' => 'photo_formats',
                        'orderby'  => 'name',
                        'order'    => 'ASC',
                        'hide_empty' => true,
                    ) );

                    foreach ( $formats as $format ) {
                        echo '<option value="' . esc_attr( $format->term_id ) . '">' . esc_html( $format->name ) . '</option>';
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="filter_droite">
            <select id="anneeSelect">
                <option value="">Années</option>
                <?php
                    $anneesCroissantes = get_terms( array(
                        'taxonomy' => 'annee',
                        'orderby'  => 'date',
                        'order'    => 'ASC',
                        'hide_empty' => true,
                    ) );
                    $anneesDecroissantes = get_terms( array(
                        'taxonomy' => 'annee',
                        'orderby'  => 'date',
                        'order'    => 'DESC',
                        'hide_empty' => true,
                    ) );
                ?>
                    <option value="$anneesCroissante">Années (croissante)</option>
                    <option value="$anneesDecroissante">Années (décroissante)</option>
                
            </select>

        </div>
    </div>

    <div class="galerie_photos" id="gallery">
    </div>

    <button
        class="load_more_button"
        data-nonce="<?php echo wp_create_nonce('galerie_load_more'); ?>"
        data-action="galerie_load_more"
        data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>"
        >Charger plus
    </button>   

</section> <!-- #galerie_section -->
    
<?php get_footer(); ?>