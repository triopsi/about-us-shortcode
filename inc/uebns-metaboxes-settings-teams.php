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

/* Registers the teams post type. */
add_action( 'init', 'register_uebns_type' );

/**
 * Function about the ini of the Plugin
 *
 * @return void
 */
function register_uebns_type() {
	
  	/* Defines labels */
  	$labels = array(
		'name'               => __( 'Teams', 'ueber-uns' ),
		'singular_name'      => __( 'Team', 'ueber-uns' ),
		'menu_name'          => __( 'Teams', 'ueber-uns' ),
		'name_admin_bar'     => __( 'Team', 'ueber-uns' ),
		'add_new'            => __( 'Add New Team', 'ueber-uns' ),
		'add_new_item'       => __( 'Add New Team', 'ueber-uns' ),
		'new_item'           => __( 'New Team', 'ueber-uns' ),
		'edit_item'          => __( 'Edit Team', 'ueber-uns' ),
		'view_item'          => __( 'View Team', 'ueber-uns' ),
		'all_items'          => __( 'All Teams', 'ueber-uns' ),
		'search_items'       => __( 'Search Teams', 'ueber-uns' ),
		'not_found'          => __( 'No Teams found.', 'ueber-uns' ),
		'not_found_in_trash' => __( 'No Teams found in Trash.', 'ueber-uns' )
	);

  	/* Defines permissions. */
	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
    	'show_in_admin_bar'  => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title' ),
		'menu_icon'          => 'dashicons-buddicons-buddypress-logo',
	);

  	/* Registers post type. */
	register_post_type( 'uebns', $args );  

}


/* Add update messages */
add_filter( 'post_updated_messages', 'uebns_updated_messages' );

/**
 * Update post message functions
 *
 * @param [type] $messages
 * @return void
 */
function uebns_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );
	$messages['uebns'] = array(
		1  => __( 'Team updated.', 'ueber-uns' ),
		4  => __( 'Team updated.', 'ueber-uns' ),
		6  => __( 'Team published.', 'ueber-uns' ),
		7  => __( 'Team saved.', 'ueber-uns' ),
		10 => __( 'Team draft updated.', 'ueber-uns' )
	);

	return $messages;

}