<?php

function cptui_register_my_cpts_personajes() {

	/**
	 * Post Type: Personajes.
	 */

	$labels = [
		"name" => esc_html__( "Personajes", "eit" ),
		"singular_name" => esc_html__( "Personaje", "eit" ),
		"menu_name" => esc_html__( "Personajes", "eit" ),
		"all_items" => esc_html__( "Todos los Personajes", "eit" ),
		"add_new" => esc_html__( "Añadir nuevo", "eit" ),
		"add_new_item" => esc_html__( "Añadir nuevo Personaje", "eit" ),
		"edit_item" => esc_html__( "Editar Personaje", "eit" ),
		"new_item" => esc_html__( "Nuevo Personaje", "eit" ),
		"view_item" => esc_html__( "Ver Personaje", "eit" ),
		"view_items" => esc_html__( "Ver Personajes", "eit" ),
		"search_items" => esc_html__( "Buscar Personajes", "eit" ),
		"not_found" => esc_html__( "No se ha encontrado Personajes", "eit" ),
		"not_found_in_trash" => esc_html__( "No se han encontrado Personajes en la papelera", "eit" ),
		"parent" => esc_html__( "Personaje superior", "eit" ),
		"featured_image" => esc_html__( "Imagen destacada para Personaje", "eit" ),
		"set_featured_image" => esc_html__( "Establece una imagen destacada para Personaje", "eit" ),
		"remove_featured_image" => esc_html__( "Eliminar la imagen destacada de Personaje", "eit" ),
		"use_featured_image" => esc_html__( "Usar como imagen destacada de Personaje", "eit" ),
		"archives" => esc_html__( "Archivos de Personaje", "eit" ),
		"insert_into_item" => esc_html__( "Insertar en Personaje", "eit" ),
		"uploaded_to_this_item" => esc_html__( "Subir a Personaje", "eit" ),
		"filter_items_list" => esc_html__( "Filtrar la lista de Personajes", "eit" ),
		"items_list_navigation" => esc_html__( "Navegación de la lista de Personajes", "eit" ),
		"items_list" => esc_html__( "Lista de Personajes", "eit" ),
		"attributes" => esc_html__( "Atributos de Personajes", "eit" ),
		"name_admin_bar" => esc_html__( "Personaje", "eit" ),
		"item_published" => esc_html__( "Personaje publicado", "eit" ),
		"item_published_privately" => esc_html__( "Personaje publicado como privado.", "eit" ),
		"item_reverted_to_draft" => esc_html__( "Personaje devuelto a borrador.", "eit" ),
		"item_trashed" => esc_html__( "Personaje enviado a la papelera.", "eit" ),
		"item_scheduled" => esc_html__( "Personaje programado", "eit" ),
		"item_updated" => esc_html__( "Personaje actualizado.", "eit" ),
		"parent_item_colon" => esc_html__( "Personaje superior", "eit" ),
	];

	$args = [
		"label" => esc_html__( "Personajes", "eit" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "personajes", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-superhero",
		"supports" => [ "title", "editor", "thumbnail", "custom-fields" ],
		"taxonomies" => [ "raza" ],
		"show_in_graphql" => false,
	];

	register_post_type( "personajes", $args );
}

add_action( 'init', 'cptui_register_my_cpts_personajes' );






function cptui_register_my_taxes_raza() {

	/**
	 * Taxonomy: Razas.
	 */

	$labels = [
		"name" => esc_html__( "Razas", "eit" ),
		"singular_name" => esc_html__( "Raza", "eit" ),
		"menu_name" => esc_html__( "Razas", "eit" ),
		"all_items" => esc_html__( "Todos los Razas", "eit" ),
		"edit_item" => esc_html__( "Editar Raza", "eit" ),
		"view_item" => esc_html__( "Ver Raza", "eit" ),
		"update_item" => esc_html__( "Actualizar el nombre de Raza", "eit" ),
		"add_new_item" => esc_html__( "Añadir nuevo Raza", "eit" ),
		"new_item_name" => esc_html__( "Nombre del nuevo Raza", "eit" ),
		"parent_item" => esc_html__( "Raza superior", "eit" ),
		"parent_item_colon" => esc_html__( "Raza superior", "eit" ),
		"search_items" => esc_html__( "Buscar Razas", "eit" ),
		"popular_items" => esc_html__( "Razas populares", "eit" ),
		"separate_items_with_commas" => esc_html__( "Separar Razas con comas", "eit" ),
		"add_or_remove_items" => esc_html__( "Añadir o eliminar Razas", "eit" ),
		"choose_from_most_used" => esc_html__( "Escoger entre los Razas más usandos", "eit" ),
		"not_found" => esc_html__( "No se ha encontrado Razas", "eit" ),
		"no_terms" => esc_html__( "Ningún Razas", "eit" ),
		"items_list_navigation" => esc_html__( "Navegación de la lista de Razas", "eit" ),
		"items_list" => esc_html__( "Lista de Razas", "eit" ),
		"back_to_items" => esc_html__( "Volver a Razas", "eit" ),
		"name_field_description" => esc_html__( "El nombre es cómo aparecerá en tu sitio.", "eit" ),
		"parent_field_description" => esc_html__( "Asigna un término superior para crear una jerarquía. El término jazz, por ejemplo, sería el superior de bebop y big band.", "eit" ),
		"slug_field_description" => esc_html__( "El «slug» es la versión apta para URLs del nombre. Suele estar en minúsculas y sólo contiene letras, números y guiones.", "eit" ),
		"desc_field_description" => esc_html__( "La descripción no suele mostrarse por defecto, pero puede que algunos temas la muestren.", "eit" ),
	];

	
	$args = [
		"label" => esc_html__( "Razas", "eit" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'raza', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "raza",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "raza", [ "personajes" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_raza' );





// add_action( 'init', 'wp_learn_register_meta' );
// function wp_learn_register_meta(){
//     // register_meta(
//     //     'post',
//     //     'attack',
//     //     array(
//     //         'single'       => true,
//     //         'type'         => 'integer',
//     //         'default'      => '',
//     //         'show_in_rest' => true,
//     //     )
//     // );
//     register_meta(
//         'post',
//         'defense1',
//         array(
//             'single'       => true,
//             'type'         => 'integer',
//             'default'      => '',
//             'show_in_rest' => true,
//         )
//     );
//     register_post_meta( 
//       'post', 
//       'attack', 
//       array(
//         'show_in_rest'      => true,
//         'single'            => true,
//         'type'              => 'string',
//       ) 
//     );
//     register_post_meta( 
//       'post', 
//       'defense', 
//       array(
//         'show_in_rest'      => true,
//         'single'            => true,
//         'type'              => 'string',
//       ) 
//     );
// }










