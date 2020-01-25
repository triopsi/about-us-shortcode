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

/* Handles shortcode column display. */
add_action( 'manage_uebns_posts_custom_column' , 'uebns_custom_columns', 10, 2 );

/**
 * Shortcodestyle function
 *
 * @param [type] $column
 * @param [type] $post_id
 * @return void
 */
function uebns_custom_columns( $column, $post_id ) {
  switch ( $column ) {
    case 'uebn_shortcode' :
      global $post;
      $slug = '' ;
      $slug = $post->post_name;
      $shortcode = '<span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="[uebns name=&quot;'.$slug.'&quot;]" class="large-text code"></span>';
      echo $shortcode;
      break;
  }
}


/* Adds the shortcode column in the postslistbar */
add_filter( 'manage_uebns_posts_columns' , 'add_uebns_columns' );

/**
 * AdminCollumnBar function
 *
 * @param [type] $columns
 * @return void
 */
function add_uebns_columns( $columns ) {
  $columns['title'] = __('Team name','aus');
  unset( $columns['author'] );
  unset( $columns['date'] );
  return array_merge( $columns, array('uebn_shortcode' => 'Shortcode') );
}