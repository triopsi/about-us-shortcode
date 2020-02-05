<?php
/**
* Author: triopsi
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
add_action( 'admin_enqueue_scripts', 'add_admin_uebns_style_js' );

/**
 * Undocumented function
 *
 * @return void
 */
function add_admin_uebns_style_js() {

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

    /* Localizes string for JS file. */
    wp_localize_script( 'uebns', 'uebnsobjjs', array(
      'untitled' => __( 'Untitled', 'aus' ),
    ));
    
  }else{
    
    /* CSS for metaboxes. */
    wp_enqueue_style( 'uebns_admin_styles', plugins_url('../assets/css/editor-admin.css', __FILE__));   

    /* Color JS */
    wp_enqueue_script( 'uebns-admin-script-color', plugins_url('../assets/js/uebns-admin-script-color.js', __FILE__), array( 'jquery', 'wp-color-picker'  ) );
  }

}

/**
 * Update Version Number
 *
 * @return void
 */
function uebns_activation(){

  $old_setting_value = get_option( 'uebns_settings_social' );

  $old_setting_value_color = get_option( 'uebns_setting_main_color' );
  $old_setting_value_color_hover = get_option( 'uebns_setting_main_color_hover' );

  // <= 0.0.2 to 0.0.3
  if( is_array( $old_setting_value ) && !empty( $old_setting_value ) && !isset( $old_setting_value['- Another link -'] )){
    $old_setting_value['- Another link -'] = 'fas fa-link';
    update_option('uebns_settings_social', $old_setting_value);
  }

  // <= 0.0.3 to 0.1.0
  if( empty( $old_setting_value_color ) || empty( $old_setting_value_color_hover ) ){
    $old_setting_value_color = "#eb5466";
    $old_setting_value_color_hover = "#212952";
    update_option('uebns_setting_main_color', $old_setting_value_color);
    update_option('uebns_setting_main_color_hover', $old_setting_value_color_hover);
  }

  update_option('uebns_plugin_version', UEBNS_VERSION);
}