<?php
/**
 * Plugin Name: EIT Eventos Externos
 * Description: Plugin que crea un widget en el dashboard de WordPress
 * Version:     1.0.0
 * Author:      Escuela IT
 *
 *
 * @package    CoreFunctionality
 * @since      1.0.0
 * @copyright  Copyright (c) 2024, Escuela IT
 * @license    GPL-2.0+
 */


defined( 'ABSPATH' ) || exit;

define( 'EITEXT' , plugin_dir_path( __FILE__ ) );
define( 'RESTURL', 'https://agenda.nemesisweb.dev/wp-json/wp/v2');

require_once( EITEXT . '/inc/dashboard-ext.php' ); // crea un widget en el dashboard de WordPress
require_once( EITEXT . '/inc/shortcode-ext.php' ); // crea un shortcode que se puede usar en cualquier página
require_once( EITEXT . '/inc/options.php' ); // crea un shortcode que se puede usar en cualquier página
require_once( EITEXT . '/inc/shortcode-filtered.php' ); // crea un shortcode que se puede usar en cualquier página



// // Incluir scripts para admin
function eit_custom_dashboard_script_ext() {
  wp_enqueue_script('eit-custom-dashboard-script-ext', plugins_url('js/eit-dashboard-ext.js', __FILE__), array(), null, true);
}
add_action('admin_enqueue_scripts', 'eit_custom_dashboard_script_ext');


// Incluir scripts y estilos necesarios para el front
function eit_eventos_ext_enqueue_scripts() {
  wp_enqueue_script('eit-eventos-script-ext', plugins_url('js/eit-eventos-ext.js', __FILE__), array(), '1.0.0', true); 
  wp_enqueue_style('eit-eventos-style-ext', plugins_url('css/eit-eventos-ext.css', __FILE__) , array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'eit_eventos_ext_enqueue_scripts');





// Incluir scripts y estilos necesarios para el front
function eit_eventos_filtered_enqueue_scripts() {

  wp_register_script( 'leaflet-script', 'https://unpkg.com/leaflet/dist/leaflet.js', array('jquery'), '1.0', true );
  wp_enqueue_script( 'leaflet-script' );

  wp_register_style( 'leaflet-style', 'https://unpkg.com/leaflet/dist/leaflet.css', array(), '1.0', 'all' );
  wp_enqueue_style( 'leaflet-style' );

  wp_enqueue_script('eit-eventos-script-filtered', plugins_url('js/eit-eventos-filtered.js', __FILE__), array(), '1.0.0', true); 
  wp_localize_script('eit-eventos-script-filtered', 'eitParams', array(
    'apiUrl' => esc_url_raw(RESTURL),
    'tax' => get_option('eit_tipos_eventos_seleccionados', array()),
  ));
  wp_enqueue_style('eit-eventos-filtered', plugins_url('css/eit-eventos-filtered.css', __FILE__) , array(), '1.0.0');

}
add_action('wp_enqueue_scripts', 'eit_eventos_filtered_enqueue_scripts');