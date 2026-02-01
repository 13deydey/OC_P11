<?php 
            // Récupération des posts précédent et suivant dans la même catégorie dans des variables
            $next_post_showcase = get_next_post( true, '', 'categorie' );
            $prev_post_showcase = get_previous_post( true, '', 'categorie' );

            //Déclaration des derniers recours possibles en bouclant les posts
                // Le tout premier post (le plus ancien)
                //1. récupérer le premier post publié = au 1er en partant de l'ordre croissant
                $first_post_query = get_posts(array('post_type' => 'photo', 'posts_per_page' => 1, 'order' => 'ASC'));
                //2. vérifier qu'on a bien un post et l'assigner à la variable [le n° 0 du tableau renvoyé par get_posts, CAD le 1er du début]
                if(!empty($first_post_query)) {
                    $absolute_first = $first_post_query[0];
                } else {
                    $absolute_first = null;
                }

                // Le tout dernier post (le plus récent)
                //1. récupérer le dernier post publié = au 1er en partant de l'ordre décroissant
                $last_post_query = get_posts(array('post_type' => 'photo', 'posts_per_page' => 1, 'order' => 'DESC'));
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
                $first_posts = get_posts(array(
                    'post_type'      => 'photo',
                    'posts_per_page' => 1,
                    'order'          => 'ASC'
                ));
                if (!empty($first_posts)) {
                    $next_post_showcase = $absolute_first;
                }
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

            //Attribution des liens et des images aux variables
            if ( !empty($next_post_showcase) ) {
                $next_url_showcase = get_permalink($next_post_showcase->ID);
                $next_thumb_showcase = get_the_post_thumbnail_url($next_post_showcase->ID, 'full');
            }
            if ( !empty($prev_post_showcase) ) {
                $prev_url_showcase = get_permalink($prev_post_showcase->ID);
                $prev_thumb_showcase = get_the_post_thumbnail_url($prev_post_showcase->ID, 'full');
            }
            //Affichage des deux photos
            ?>
