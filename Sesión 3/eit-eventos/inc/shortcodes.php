<?php

function eit_mostrar_eventos_ajax( $atts ) {
	$atts = shortcode_atts( array(
			'num_eventos' => 2,
	), $atts );

	// Obtener la página actual si es una solicitud AJAX
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	// Obtener los eventos usando WP_Query
	$args = array(
			'post_type' => 'eventos',
			'posts_per_page' => $atts['num_eventos'],
			'paged' => $paged
	);
	$query = new WP_Query($args);

	// Comprobar si hay eventos
	if ($query->have_posts()) {
			$output = '<section id="eventos-container" class="eventos">';
			while ($query->have_posts()) {
					$query->the_post();
					// Obtener los campos ACF
					$fecha = get_field('fecha');
					$precio = get_field('precio');
					$lugar = get_field('lugar');
					// $latitud = get_field('coordenadas')['latitud'];
					// $longitud = get_field('coordenadas')['longitud'];

					// Construir la tarjeta de evento
					$output .= '<div class="evento">';
					$output .= '<h2>' . get_the_title() . '</h2>';
					$output .= '<p>Fecha: ' . $fecha . '</p>';
					$output .= '<p>Precio: ' . $precio . '</p>';
					$output .= '<p>Lugar: ' . $lugar . '</p>';
					$output .= '<p>' . get_the_excerpt() . '</p>';
					$output .= '<a href="' . get_the_permalink() . '" target="_blank">Leer más</a>';

					$output .= '</div>';
			}
			$output .= '</section>';

			// Agregar botones de paginación por AJAX
			$output .= '<div id="pagination-container">';
			$output .= paginate_links(array(
					'total' => $query->max_num_pages,
					'current' => $paged,
					'type' => 'list'
			));
			$output .= '</div>';

			// Restaurar datos de la consulta original
			wp_reset_postdata();

			return $output;
	} else {
			return 'No se encontraron eventos.';
	}
}
add_shortcode('mostrar_eventos', 'eit_mostrar_eventos_ajax');




/**
 * Mostrar els CPT a través del script utilitzant la REST API
 * Es fa la crida i s'utilitzen els templates com a plantilla per clonar-los i afegir contingut, tot desde JS
 */
function eit_show_eventos( $atts ){

    $atts = shortcode_atts( array(
      'num_eventos' => 2,
  ), $atts );
  
    ob_start();
    ?>
  
    <section id="eventos" data-perpage="<?php echo $atts['num_eventos'];?>">
    <!-- <section id="eventos"> -->
      <h2>Eventos</h2>
      <div id="tipos"></div>
      <div id="eventos-info" class="eventos"></div>
      <div id="pagination-container"></div>
    </section>

    <template id="eventos-template">
      <article class="evento-card">
        <h2 class="evento-title"></h2>
        <div class="evento-content"></div>
      </article>
    </template>
    <?php
  
    return ob_get_clean();
  
  }
  
  add_shortcode('eventos', 'eit_show_eventos');