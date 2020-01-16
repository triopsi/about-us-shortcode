<?php

/* Registers the teams post type. */
add_action( 'init', 'register_uebns_type' );

/**
 * Function about the ini of the Plugin
 *
 * @return void
 */
function register_uebns_type() {
	
  /* Defines labels. */
  $labels = array(
		'name'               => __( 'Teams', 'plg-ueber-uns' ),
		'singular_name'      => __( 'Team', 'plg-ueber-uns' ),
		'menu_name'          => __( 'Teams', 'plg-ueber-uns' ),
		'name_admin_bar'     => __( 'Team', 'plg-ueber-uns' ),
		'add_new'            => __( 'Add New Team', 'plg-ueber-uns' ),
		'add_new_item'       => __( 'Add New Team', 'plg-ueber-uns' ),
		'new_item'           => __( 'New Team', 'plg-ueber-uns' ),
		'edit_item'          => __( 'Edit Team', 'plg-ueber-uns' ),
		'view_item'          => __( 'View Team', 'plg-ueber-uns' ),
		'all_items'          => __( 'All Teams', 'plg-ueber-uns' ),
		'search_items'       => __( 'Search Teams', 'plg-ueber-uns' ),
		'not_found'          => __( 'No Teams found.', 'plg-ueber-uns' ),
		'not_found_in_trash' => __( 'No Teams found in Trash.', 'plg-ueber-uns' )
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


/* Customizes teams update messages. */
add_filter( 'post_updated_messages', 'uebns_updated_messages' );
function uebns_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );
    
  /* Defines update messages. */
	$messages['uebns'] = array(
		1  => __( 'Team updated.', 'plg-ueber-uns' ),
		4  => __( 'Team updated.', 'plg-ueber-uns' ),
		6  => __( 'Team published.', 'plg-ueber-uns' ),
		7  => __( 'Team saved.', 'plg-ueber-uns' ),
		10 => __( 'Team draft updated.', 'plg-ueber-uns' )
	);

	return $messages;

}