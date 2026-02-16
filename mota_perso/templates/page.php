<?php

/**
 * Template Name: Page simple
 */

get_header(); 

?>

<?php
if ( have_posts() ) : // On vérifie s'il y a du contenu
    while ( have_posts() ) : the_post(); // On prépare les données de l'article courant ?>

        <article id="post-<?php the_ID(); ?>" class="article_page_defaut" <?php body_class(); ?>>
			<h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php 
                // C'est cette fonction qui affiche tout ce qui vient de Gutenberg
                the_content(); 
                ?>
            </div>

        </article>

    <?php endwhile; 
endif; 
?>

<?php get_footer(); ?>