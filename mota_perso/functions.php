<?php
function mon_theme_enqueue_styles() {
    //1. ENQUEUE MAIN THEME STYLE
    wp_enqueue_style(
        'theme-id-style',  // Handle: identifiant unique
        get_stylesheet_uri(), // Chemin: style.css à la racine
        array(),
        wp_get_theme()->get('Version')
    );

    //2. ENQUEUE FONTS 
    wp_enqueue_style(
        'theme-fonts',
        get_template_directory_uri() . '/css/font.css',
        array('theme-id-style'),
        '1.0'
    );

    //3. ENQUEUE MAIN CSS
    wp_enqueue_style(
        'theme-main-css',
        get_template_directory_uri() . '/css/main.css',
        array('theme-fonts'),
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_styles');

function mon_theme_register_nav_menus() {
    //Enregistre les emplacements de menus personnalisés
        register_nav_menus(
            array(
                'primary' => __( 'Menu Principal', 'motaTheme' ), // 'primary' est le slug (identifiant)
                'footer'  => __( 'Menu Pied de Page', 'motaTheme' )  // Exemple d'un second emplacement
            )
        );
    }
add_action( 'after_setup_theme', 'mon_theme_register_nav_menus' );