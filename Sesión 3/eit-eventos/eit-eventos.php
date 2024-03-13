<?php
/**
 * Plugin Name: EIT Eventos
 * Description: Plugin para el desarrollo EIT.
 * Version:     1.0.0
 * Author:      Escuela IT
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
 * @copyright  Copyright (c) 2024, Escuela IT
 * @license    GPL-2.0+
 */


defined( 'ABSPATH' ) || exit;

define( 'EIT' , plugin_dir_path( __FILE__ ) );

require_once( EIT . '/inc/shortcodes.php' );
require_once( EIT . '/inc/dashboard.php' );


function eit_acf_json_save_point( $path ) {
  return EIT . '/acf-json';
}

add_filter( 'acf/settings/save_json', 'eit_acf_json_save_point' );


// Incluir scripts y estilos necesarios
function eit_eventos_enqueue_scripts() {
  wp_enqueue_script('eit-eventos-script', plugins_url('js/eit-eventos.js', __FILE__), array(), '1.0.0', true); 
  wp_enqueue_style('eit-eventos-style', plugins_url('css/eit-eventos.css', __FILE__) , array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'eit_eventos_enqueue_scripts');




// Incluir scripts para admin
function eit_custom_dashboard_script() {
  wp_enqueue_script('eit-custom-dashboard-script', plugins_url('js/eit-dashboard.js', __FILE__), array(), null, true);

  wp_localize_script('eit-custom-dashboard-script', 'customDashboardParams', array(
      'apiUrl' => esc_url_raw(rest_url('eit/v1/eventos')),
      'nonce' => wp_create_nonce('wp_rest'), // Crear nonce para endpoint
  ));
}
add_action('admin_enqueue_scripts', 'eit_custom_dashboard_script');


