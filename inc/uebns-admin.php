<?php
/**
* Author: Daniel Rodriguez Baumann
* Author URI: http://wiki.profoxi.de
* License: GPL3
* License URI: https://www.gnu.org/licenses/gpl-3.0
*
* uebns is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* any later version.
*  
* uebns is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*  
* You should have received a copy of the GNU General Public License
* along with uebns. If not, see https://www.gnu.org/licenses/gpl-3.0.
**/

/**
 * Version Check
 *
 * @return void
 */
function uebns_check_version() {
  if (UEBNS_VERSION !== get_option('uebns_plugin_version'))
  uebns_activation();
}

/* Loaded Plugin */
add_action('plugins_loaded', 'uebns_check_version');

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

    /* WP color picker Style and scripts */
    wp_enqueue_style( 'wp-color-picker' );

    /* Add all JS, CSS and settings for the media js */
    wp_enqueue_media();

    /* JS for metaboxes */
    wp_enqueue_script( 'logic-form', plugins_url('../assets/js/logic-form.js', __FILE__));
    wp_enqueue_script( 'images-picker', plugins_url('../assets/js/images-picker.js', __FILE__));
    wp_enqueue_script( 'color-picker', plugins_url('../assets/js/color-picker.js', __FILE__), array( 'jquery', 'wp-color-picker' ) );

    /* Localizes string for JS file. */
    wp_localize_script( 'uebns', 'uebnsobjjs', array(
      'untitled' => __( 'Untitled', 'plg-ueber-uns' ),
    ));
    
  }

}

/**
 * Update Version Number
 *
 * @return void
 */
function uebns_activation(){
  update_option('uebns_plugin_version', UEBNS_VERSION);
}


/* Defines highlight select options */
function social_links_options() {
	$options = array ( 
					__('-', 'plg-ueber-uns' ) => 'nada', 
					__('Github', 'plg-ueber-uns' ) => 'github',
					__('Twitter', 'plg-ueber-uns' ) => 'twitter',
					__('LinkedIn', 'plg-ueber-uns' ) => 'linkedin',
					__('YouTube', 'plg-ueber-uns' ) => 'youtube',
					__('Google+', 'plg-ueber-uns' ) => 'googleplus',
					__('Facebook', 'plg-ueber-uns' ) => 'facebook',
					__('Pinterest', 'plg-ueber-uns' ) => 'pinterest',
					__('Instagram', 'plg-ueber-uns' ) => 'instagram',
					__('Tumblr', 'plg-ueber-uns' ) => 'tumblr',
					__('Research Gate', 'plg-ueber-uns' ) => 'researchgate',
					__('Email', 'plg-ueber-uns' ) => 'email',
					__('Website', 'plg-ueber-uns' ) => 'website',
					__('Phone', 'plg-ueber-uns' ) => 'phone',
					__('Other links', 'plg-ueber-uns' ) => 'customlink'
  	);
	return $options;
}

// Display any errors
function uebns_admin_notice_handler() {

  $errors = get_option('my_admin_errors');

  if($errors) {

      echo '<div class="error"><p>' . $errors . '</p></div>';

  }   

}
add_action( 'admin_notices', 'uebns_admin_notice_handler' );

// Clear any errors
function uebns_clear_errors() {

  update_option('my_admin_errors', false);

}
add_action( 'admin_footer', 'uebns_clear_errors' );