<?php

/* Add Admin panel */
add_action( 'admin_enqueue_scripts', 'add_admin_uebns_style' );


/**
 * Undocumented function
 *
 * @return void
 */
function add_admin_uebns_style() {

  /* Gets the post type. */
  global $post_type;

  if( 'uebns' == $post_type ) {

    /* CSS for metaboxes. */
    wp_enqueue_style( 'uebns_admin_styles', plugins_url('../assets/css/editor-admin.css', __FILE__));

    /* CSS for preview.s */
    // wp_enqueue_style( 'tmm_styles', plugins_url('assets/css/tmm_style.min.css', __FILE__));

    /* Others. */
    wp_enqueue_style( 'wp-color-picker' );
    

    /* JS for metaboxes */
    wp_enqueue_script( 'logic-form', plugins_url('../assets/js/logic-form.js', __FILE__));

    /* JS for metaboxes */
    wp_enqueue_script( 'images-picker', plugins_url('../assets/js/images-picker.js', __FILE__));
    wp_enqueue_script( 'color-picker', plugins_url('../assets/js/color-picker.js', __FILE__), array( 'jquery', 'wp-color-picker' ) );

    /* Localizes string for JS file. */
    wp_localize_script( 'uebns', 'objectL10n', array(
      'untitled' => __( 'Untitled', 'plg-ueber-uns' ),
    ));

    wp_enqueue_media();

    wp_enqueue_style( 'thickbox' );
    
  }

}