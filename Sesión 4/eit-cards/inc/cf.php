<?php
function pers_meta_box() {

  add_meta_box(
      'persattack',
      __( 'Ataque del personaje', 'eit' ),
      'eit_pers_attack_meta_box_callback',
      'personajes'
  );
  add_meta_box(
      'persdefense',
      __( 'Defensa del personaje', 'eit' ),
      'eit_pers_defense_meta_box_callback',
      'personajes'
  );
}

add_action( 'add_meta_boxes', 'pers_meta_box' );

function eit_pers_attack_meta_box_callback( $post ) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'pers_attack_nonce', 'pers_attack_nonce' );
  $value = get_post_meta( $post->ID, '_pers_attack', true );
  echo '<textarea style="width:100%" id="pers_attack" name="pers_attack">' . esc_attr( $value ) . '</textarea>';
}

function eit_pers_defense_meta_box_callback( $post ) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'pers_defense_nonce', 'pers_defense_nonce' );
  $value = get_post_meta( $post->ID, '_pers_defense', true );
  echo '<textarea style="width:100%" id="pers_defense" name="pers_defense">' . esc_attr( $value ) . '</textarea>';
}


/**
* Cuando se guarde el post (personaje), se guardan los datos específicos de ataque
*
* @param int $post_id
*/
function eit_save_pers_attack_meta_box_data( $post_id ) {

  // Verificar el nonce
  if ( ! isset( $_POST['pers_attack_nonce'] ) ) {
      return;
  }

  // Verificar que el nonce sea válido
  if ( ! wp_verify_nonce( $_POST['pers_attack_nonce'], 'pers_attack_nonce' ) ) {
      return;
  }

  // Si es un autoguardado, no se hace nada
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
  }

  // Comprobar los permisos de usuario
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) ) {
          return;
      }
  }
  else {
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
          return;
      }
  }

  /* Llegado a este punto, todo está OK. Se puede guardar. */

  // Asegurar que tenemos el campo
  if ( ! isset( $_POST['pers_attack'] ) ) {
      return;
  }

  // Sanitizar el input
  $my_data = sanitize_text_field( $_POST['pers_attack'] );

  // Actualizar the meta field en la base de datos.
  update_post_meta( $post_id, '_pers_attack', $my_data );
}

add_action( 'save_post', 'eit_save_pers_attack_meta_box_data' );

// Mostrar el campo en el contenido del front de la web (es opcional, ya que vamos a usarlo con la REST API)
function eit_pers_attack_before_post( $content ) {
  global $post;
  // retrieve the global notice for the current post
  $pers_attack = esc_attr( get_post_meta( $post->ID, '_pers_attack', true ) );
  $notice = "<div class='sp_pers_attack'>$pers_attack</div>";
  return $notice . $content;
}

add_filter( 'the_content', 'eit_pers_attack_before_post' );







/**
* Cuando se guarde el post (personaje), se guardan los datos específicos de defensa
*
* @param int $post_id
*/
function eit_save_pers_defense_meta_box_data( $post_id ) {

  // Verificar el nonce
  if ( ! isset( $_POST['pers_defense_nonce'] ) ) {
      return;
  }

  // Verificar que el nonce sea válido
  if ( ! wp_verify_nonce( $_POST['pers_defense_nonce'], 'pers_defense_nonce' ) ) {
      return;
  }

  // Si es un autoguardado, no se hace nada
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
  }

  // Comprobar los permisos de usuario
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) ) {
          return;
      }
  }
  else {
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
          return;
      }
  }

  /* Llegado a este punto, todo está OK. Se puede guardar. */

  // Asegurar que tenemos el campo
  if ( ! isset( $_POST['pers_defense'] ) ) {
      return;
  }

  // Sanitizar el input
  $my_data = sanitize_text_field( $_POST['pers_defense'] );

  // Actualizar the meta field en la base de datos.
  update_post_meta( $post_id, '_pers_defense', $my_data );
}

add_action( 'save_post', 'eit_save_pers_defense_meta_box_data' );

// Mostrar el campo en el contenido del front de la web (es opcional, ya que vamos a usarlo con la REST API)
function eit_pers_defense_before_post( $content ) {
  global $post;
  // retrieve the global notice for the current post
  $pers_defense = esc_attr( get_post_meta( $post->ID, '_pers_defense', true ) );
  $notice = "<div class='sp_pers_defense'>$pers_defense</div>";
  return $notice . $content;
}

add_filter( 'the_content', 'eit_pers_defense_before_post' );