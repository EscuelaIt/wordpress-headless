<?php
// Agregar un widget personalizado al dashboard con REST API con consulta externa
add_action('wp_dashboard_setup', 'eit_dashboard_widget_externo');

function eit_dashboard_widget_externo() {
    wp_add_dashboard_widget('eit_widget_externo', 'Próximos Eventos externos', 'eit_render_dashboard_widget_externo');
}

function eit_render_dashboard_widget_externo() {
    echo '<div id="eit-eventos-externos"></div>';
}