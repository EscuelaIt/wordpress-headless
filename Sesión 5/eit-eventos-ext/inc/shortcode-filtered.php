<?php
	/**
 * Mostrar els CPT a través del script usando la REST API
 */
function eit_show_filtered_eventos( $atts ){

	$atts = shortcode_atts( array(
		'num_eventos' => 2,
), $atts );

	ob_start();
	?>


	<div id="map" style="height: 400px;"></div>

	<section id="eventos">
		<h2>Eventos Filtrados</h2>
		<div id="eventos-info-filtered" class="eventos"></div>
	</section>

	<template id="eventos-template-filtered">
		<article class="evento-card evento-filtered">
			<h2 class="evento-title"><a class="evento-link"></a></h2>
			<div class="evento-datos">
				<p class="evento-lugar"></p>
				<p>Precio: <span class="evento-precio"></span>€</p>
			</div>
		</article>
	</template>
	<?php

	return ob_get_clean();

}

add_shortcode('eventos_filtrados', 'eit_show_filtered_eventos');

