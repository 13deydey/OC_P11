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
            <?php // Récupération des posts précédent et suivant via les fonctions WordPress
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>

            <?php if ( !empty($next_post) ) : 
                // On récupère l'URL de l'image suivante
                $next_thumb_url = get_the_post_thumbnail_url( $next_post->ID, 'thumbnail' );
            ?>
            <!--Affichage de l'aperçu de l'image suivante cliquable-->
                <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link-next">
                    <img src="<?php echo $next_thumb_url; ?>" alt="Suivant" class="preview_image">
                </a>
            <?php endif; ?>

            <!--Affichage des flèches de navigation cliquables via les posts précédent et suivant WordPress-->
            <div class="arrows_navigation">
                <?php if ( !empty($prev_post) ): ?>
                    <a href="<?php echo get_permalink($prev_post->ID); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/left_arrow.svg" alt="Précédente" class="preview_arrow">                         
                    </a>
                <?php endif; ?>

                <?php if ( !empty($next_post) ): ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/right_arrow.svg" alt="Suivante" class="next_arrow">      
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <p><?php the_content(); ?></p>

    <div class="other_photos_section">
        <h3>Vous aimerez aussi </h2>
        <div class="other_photos_container">
            <?php 
        //I. CONFIGURATION DES VARIABLES
        // Récupération des posts précédent et suivant dans la même catégorie dans des variables
            $next_post_showcase = get_next_post( true, '', 'categorie' );
            $prev_post_showcase = get_previous_post( true, '', 'categorie' );

        //Déclaration des derniers recours possibles en bouclant les posts
            // Le tout premier post (le plus ancien)
                //1. récupérer le premier post publié = au 1er en partant de l'ordre croissant
                $first_post_query = get_posts(array(
                    'post_type' => 'photo', 
                    'posts_per_page' => 1, 
                    'order' => 'ASC'
                ));
                //2. vérifier qu'on a bien un post et l'assigner à la variable [le n° 0 du tableau renvoyé par get_posts, CAD le 1er du début]
                if(!empty($first_post_query)) {
                    $absolute_first = $first_post_query[0];
                } else {
                    $absolute_first = null;
                }

            // Le tout dernier post (le plus récent)
                //1. récupérer le dernier post publié = au 1er en partant de l'ordre décroissant
                $last_post_query = get_posts(array(
                    'post_type' => 'photo', 
                    'posts_per_page' => 1, 
                    'order' => 'DESC'
                ));
                //2. vérifier qu'on a bien un post et l'assigner à la variable [le n° 0 du tableau renvoyé par get_posts, CAD le 1er de la fin]
                if(!empty($last_post_query)){
                    $absolute_last = $last_post_query[0];
                } else {
                    $absolute_last = null ;
                }

            //Attribution du post à la variable du post suivant en testant les différents cas possibles
                //Si pas de post dans la même catégorie, on cherche dans la taxonomie année
                if (empty($next_post_showcase)){
                    $next_post_showcase = get_next_post( true, '', 'annee' );
                }
                    //Si pas de post dans la même année, on cherche dans la taxonomie format
                    if (empty($next_post_showcase)){
                        $next_post_showcase = get_next_post( true, '', 'format' );
                    }
                        //Si pas de post dans la même format non plus, on cherche dans le post suivant sans filtre
                        if (empty($next_post_showcase)){
                            $next_post_showcase = get_next_post( false );
                        }
                            //Si pas de post suivant, on cherche dans le post précédent sans filtre
                            if (empty($next_post_showcase)){
                                $next_post_showcase = $absolute_first;
                            }
            

            //Même chose pour le post précédent
            if (empty($prev_post_showcase)){
                $prev_post_showcase = get_previous_post( true, '', 'annee' );
            }
                if (empty($prev_post_showcase)){
                    $prev_post_showcase = get_previous_post( true, '', 'format' );
                }
                    if (empty($prev_post_showcase)){
                        $prev_post_showcase = get_previous_post( false );
                    }
                        if (empty($prev_post_showcase)){
                            $prev_post_showcase = $absolute_last;
                        }
        //II. ATTRIBUTION DES LIENS ET IMAGES VIA VARIABLES                
        //Attribution des liens et des images aux variables
            if ( !empty($next_post_showcase) ) {
                $next_url_showcase = get_permalink($next_post_showcase->ID);
                $next_thumb_showcase = get_the_post_thumbnail_url($next_post_showcase->ID, 'full');
            }
            if ( !empty($prev_post_showcase) ) {
                $prev_url_showcase = get_permalink($prev_post_showcase->ID);
                $prev_thumb_showcase = get_the_post_thumbnail_url($prev_post_showcase->ID, 'full');
            }
        //III. AFFICHAGE DES IMAGES ET LIENS
            ?>
            <a href="<?php echo $prev_url_showcase; ?>" class="other_photo_item">
                <img src="<?php echo $prev_thumb_showcase; ?>" alt="Photo 1">
            </a>
            <a href="<?php echo $next_url_showcase; ?>" class="other_photo_item">
                <img src="<?php echo $next_thumb_showcase;?>" alt="Photo 2">
            </a>
        </div>
    </div>
</section>


<?php get_footer(); ?>