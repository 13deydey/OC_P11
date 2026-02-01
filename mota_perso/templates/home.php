<?php

/**
 * Template Name: Home Page
 */

get_header(); 

?>

<section id="primary">

    <hgroup class="hero_header">
        <?php while ( have_posts() ) : the_post(); ?>
            <h1 class="hero_title"><?php the_field('herotitle'); ?></h1>
            <img src="<?php the_field('heroimg'); ?>" />
        <?php endwhile; // end of the loop. ?>
    </hgroup>

</section><!-- #primary -->
    
<?php get_footer(); ?>