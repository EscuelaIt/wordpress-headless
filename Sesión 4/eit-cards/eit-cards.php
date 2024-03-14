<?php
/**
 * Plugin Name: EIT Cards
 * Description: shortcode de soporte para juego de cartas.
 * Version:     1.0.0
 * Author:      Human CTA
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.  You may NOT assume that you can use any other
 * version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.
 *
 * @package    CoreFunctionality
 * @since      1.0.0
 * @copyright  Copyright (c) 2019, Human CTA
 * @license    GPL-2.0+
 */


defined( 'ABSPATH' ) || exit;


define( 'EIT' , plugin_dir_path( __FILE__ ) );
require_once( EIT . '/inc/cpt.php' );
require_once( EIT . '/inc/cf.php' );



// Registrar el nuevo endpoint
add_action('rest_api_init', 'register_custom_endpoint');

function register_custom_endpoint() {
    register_rest_route('eit/v1', '/cards', array(
        'methods' => 'GET',
        'callback' => 'get_eventos_data',
    ));
}

// Callback para manejar la solicitud del endpoint
function get_eventos_data($request) {
    $args = array(
        'post_type' => 'personajes',
        'posts_per_page' => -1,
    );

    $personajes = array();

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $personaje = array(
                'id' => get_the_ID(),
                'nombre' => get_the_title(),
                'texto' => get_the_content(),
                'imagen_destacada' => get_the_post_thumbnail_url(),
                // 'ataque' => get_field('ataque'),
                // 'defensa' => get_field('defensa'),
                'ataque' => get_post_meta(get_the_ID(),'_pers_attack',true),
                'defensa' => get_post_meta(get_the_ID(),'_pers_defense',true),
                // 'raza' => wp_get_post_terms( get_the_ID(), 'raza', array( 'fields' => 'names' ) ),
                'link' => get_the_permalink()
            );

            $personajes[] = $personaje;
        }
        wp_reset_postdata();
    }

    return $personajes;
}






/**
 * Obtener los personajes por id
 */
function eit_single_personaje( $data ) {
//   $posts = get_posts( array(
//     'personajes' => $data['id'],
//   ) );

//   if ( empty( $posts ) ) {
//     return null;
//   }

//   return $posts[0]->post_title;


  $args = array(
    'post_type' => 'personajes',
    'p' => $data['id'],
);

$personaje = [];

$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();

        $personaje = [
            'id' => get_the_ID(),
            'nombre' => get_the_title(),
            'texto' => get_the_content(),
            'imagen_destacada' => get_the_post_thumbnail_url(),
            // 'ataque' => get_field('ataque'),
            // 'defensa' => get_field('defensa'),
            'ataque' => get_post_meta(get_the_ID(),'_pers_attack',true),
            'defensa' => get_post_meta(get_the_ID(),'_pers_defense',true),
            'raza' => wp_get_post_terms( get_the_ID(), 'raza', array( 'fields' => 'names' ) ),
            'raza_id' => wp_get_post_terms( get_the_ID(), 'raza', array( 'fields' => 'ids' ) ),
            // 'sema' => wp_get_post_terms( get_the_ID(), 'raza'),
            'link' => get_the_permalink()
        ];

    }
    wp_reset_postdata();
} else {
    return __('No se han encontado resultados', 'eit');
}

return $personaje;



}

add_action( 'rest_api_init', function () {
  register_rest_route( 'eit/v1', '/cards/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'eit_single_personaje',
  ) );
} );









function eit_personajes_tax( $data ) {
  
    $args = array(
        'post_type' => 'personajes',    // post type.
        'tax_query' => array(
            array(
                'taxonomy' => 'raza',   // taxonomy
                'field' => 'term_id',   // term_id, slug or name
                'terms' => $data['id'], // term id, term slug o term name
            )
        )
            );
    
    $personajes = array();

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $personaje = array(
                'id' => get_the_ID(),
                'nombre' => get_the_title(),
                'texto' => get_the_content(),
                'imagen_destacada' => get_the_post_thumbnail_url(),
                'ataque' => get_post_meta(get_the_ID(),'_pers_attack',true),
                'defensa' => get_post_meta(get_the_ID(),'_pers_defense',true),
                'raza' => wp_get_post_terms( get_the_ID(), 'raza', array( 'fields' => 'names' ) ),
            );

            $personajes[] = $personaje;
        }
        wp_reset_postdata();
    }

    return $personajes;
}


add_action( 'rest_api_init', function () {
    register_rest_route( 'eit/v1', '/byraza/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'eit_personajes_tax',
    ) );
} );
