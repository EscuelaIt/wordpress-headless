<?php

// Registrar el nuevo endpoint
add_action('rest_api_init', 'eit_register_eventos_endpoint');

function eit_register_eventos_endpoint() {
    register_rest_route('eit/v1', '/eventos', array(
        'methods' => 'GET',
        'callback' => 'eit_get_eventos',
    ));
}


// Callback para manejar la solicitud del endpoint
function eit_get_eventos($request) {

  $args = array(
      'post_type' => 'eventos',
      'posts_per_page' => -1,
  );

  $eventos = array();

  $query = new WP_Query($args);

  if ($query->have_posts()) {
      while ($query->have_posts()) {
          $query->the_post();

          $evento = array(
              'id' => get_the_ID(),
              'titulo' => get_the_title(),
              'contenido' => get_the_content(),
              'excerpt' => get_the_excerpt(),
              'imagen_destacada' => get_the_post_thumbnail_url(),
              'precio' => get_field('precio'),
              'lugar' => get_field('localidad'),
              'tipo' => wp_get_post_terms(get_the_ID(), 'tipo', array('fields' => 'names')),
              'link' => get_the_permalink()
          );

          $eventos[] = $evento;
      }
      wp_reset_postdata();
  }

  return $eventos;
}





// Agregar un widget personalizado al dashboard con WP Query
add_action('wp_dashboard_setup', 'eit_add_custom_dashboard_widget');

function eit_add_custom_dashboard_widget() {
  wp_add_dashboard_widget('custom_dashboard_widget', 'Próximos eventos WP Query', 'eit_render_custom_dashboard_widget');
}

// Función para renderizar el contenido del widget
function eit_render_custom_dashboard_widget() {

  $args = array(
      'post_type' => 'eventos',
      'posts_per_page' => 5, // Cambia este valor según la cantidad de eventos que desees mostrar
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) {
      echo '<ul>';
      while ($query->have_posts()) {
          $query->the_post();
          echo '<li><a href="' . get_edit_post_link(get_the_ID()) . '">' . get_the_title() . '</a></li>';
      }
      echo '</ul>';
      wp_reset_postdata();
  } else {
      echo 'No hay eventos disponibles.';
  }
}











// Agregar un widget personalizado al dashboard con REST API
add_action('wp_dashboard_setup', 'eit_dashboard_widget');

function eit_dashboard_widget() {
    wp_add_dashboard_widget('eit_dashboard_widget', 'Próximos Eventos EIT REST', 'eit_render_dashboard_widget');
}

function eit_render_dashboard_widget() {
    echo '<div id="eit-events"></div>';
}





