<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Site de Nathalie Mota</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="site_header">
        <div class="nav_logo">
            <?php
            // récupération et affichage du logo personnalisé
            if ( function_exists( 'the_custom_logo' ) ) {
                the_custom_logo();
            }
            ?>
        </div>
        
        <nav id="site-navigation" class="nav_menu" role="navigation">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </button>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary', // L'identifiant (slug) que vous avez déclaré dans functions.php
                'menu_class'     => 'main-menu', // La classe CSS appliquée au <ul> du menu
                'container'      => 'div',
                'container_class'=> 'nav-menu-container',
                'depth'          => 2,                 // Permet les sous-menus
                'fallback_cb'    => false,             // N'affiche rien si aucun menu n'est assigné
            ) );
            ?>
        </nav>
    </header>


    