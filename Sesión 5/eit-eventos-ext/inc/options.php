<?php


// Agregar página de opciones al menú de administración "Settings"
// Consultar info: https://developer.wordpress.org/reference/functions/add_options_page/
add_action('admin_menu', 'eit_add_options_page');
function eit_add_options_page() {
    add_options_page(
      'Configuración de Eventos', 
      'EIT Eventos', 
      'manage_options', 
      'eit_eventos', 
      'eit_options_page');
}

// Contenido de la página de opciones
function eit_options_page() {
    // Obtener los valores seleccionados de la base de datos
    $tipos_eventos_seleccionados = get_option('eit_tipos_eventos_seleccionados', array());  
    // var_dump($tipos_eventos_seleccionados);

    // Realizar la llamada al endpoint de la API
    $response = wp_remote_get( RESTURL . '/tipo' );
    if (!is_wp_error($response)) {
        $body = wp_remote_retrieve_body($response);
        $tipos_eventos = json_decode($body);

        // Mostrar checkboxes
        if ($tipos_eventos) {
            echo '<form method="post" action="options.php">';
            settings_fields('eit_eventos_opciones');
            echo '<h2>Tipos de Eventos</h2>';
            echo '<p>Selecciona todos los tipos que evento que quieres mostrar</p>';
            foreach ($tipos_eventos as $tipo_evento) {
                // var_dump($tipo_evento);
                $checked = in_array($tipo_evento->id, $tipos_eventos_seleccionados) ? 'checked' : '';
                echo '<input type="checkbox" name="eit_tipos_eventos_seleccionados[]" value="' . esc_attr($tipo_evento->id) . '" ' . $checked . ' />' . esc_html($tipo_evento->name) . '<br>';
            }
            submit_button();
            echo '</form>';
        } else {
            echo 'No se pudo obtener la lista de tipos de eventos.';
        }
    }
}

// Registrar opciones
add_action('admin_init', 'eit_eventos_registrar_opciones');
function eit_eventos_registrar_opciones() {
    register_setting('eit_eventos_opciones', 'eit_tipos_eventos_seleccionados', 'eit_sanitize_tipos_eventos');
}

// Función para sanitizar los datos de los checkboxes
function eit_sanitize_tipos_eventos($input) {
    if (is_array($input)) {
        return array_map('sanitize_text_field', $input);
    }
    return array();
}