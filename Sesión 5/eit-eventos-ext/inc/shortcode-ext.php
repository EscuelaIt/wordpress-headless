<?php
	/**
 * Mostrar els CPT a través del script utilitzant la REST API
 * Es fa la crida i s'utilitzen els templates com a plantilla per clonar-los i afegir contingut, tot desde JS
 */
function eit_show_eventos_ext( $atts ){

	$atts = shortcode_atts( array(
		'num_eventos' => 2,
), $atts );

	ob_start();
	?>

	<section id="eventos">
		<h2>Eventos Externos</h2>
		<div id="eventos-info-ext" class="eventos"></div>
	</section>

	<template id="eventos-template-ext">
		<article class="evento-card">
			<h2 class="evento-title"></h2>
			<div class="evento-tipo"></div>
			<div class="evento-content"></div>
			<!-- <img class="evento-img" src=""> -->
      <!-- <p class="evento-lugar"></p> -->
			<p>Precio: <span class="evento-precio"></span>€</p>
			<a class="evento-link" href="" target="_blank">Ir a evento</a>
		</article>
	</template>
	<?php

	return ob_get_clean();

}

add_shortcode('eventos_externos', 'eit_show_eventos_ext');