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

/* Save Hook */
add_action('save_post', 'uebns_plan_meta_box_save');

// Function for the save post
function uebns_plan_meta_box_save($post_id) {

	if ( ! isset( $_POST['uebns_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['uebns_meta_box_nonce'], 'uebns_meta_box_nonce' ) )
		return;

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (!current_user_can('edit_post', $post_id))
		return;

	// To keep the errors in
	$errors = false;

	/* Gets the actuel posts/members */
	$old_data_member = get_post_meta($post_id, '_uebns_members', true);

	/* Init the new Team */
	$new_data_member = array();

	/* Load actuel post/member settings */
	$old_data_settings = array();

	//Load old Setting
	$old_data_settings['_uebns_layout'] = get_post_meta( $post_id, '_uebns_layout', true );
	$old_data_settings['_uebns_photo_setting'] = get_post_meta( $post_id, '_uebns_photo_setting', true );
	$old_data_settings['_uebns_line_member'] = get_post_meta( $post_id, '_uebns_line_member', true );
	$old_data_settings['_uebns_filter_image'] = get_post_meta( $post_id, '_uebns_filter_image', true );
	$old_data_settings['_uebns_images_clickable'] = get_post_meta( $post_id, '_uebns_images_clickable', true );

	/* All POST rounds */
	foreach( $_POST['uebns_data'] as $key => $value ){
		$member_data = explode(';;', $_POST['uebns_data'][$key]);
		$member_firstname = $member_data[0];
		$member_lastname = $member_data[1];
		$member_job = $member_data[2];
		$member_bio = $member_data[3];
		$member_sc = $member_data[4];
		$member_photo = $member_data[5];
		$member_photo_url = $member_data[6];
		$member_enabled = $member_data[7];
		
		//Check Post and set default value
		if( $member_firstname != "" && $member_lastname != "" && $member_bio != "" && $member_enabled != "" ){
			(isset($member_firstname) && $member_firstname) ? $new_data_member[$key]['_uebns_firstname'] = stripslashes( wp_kses_post( $member_firstname ) ) : $new_data_member[$key]['_uebns_firstname'] = __('Untitled', 'aus' );
			(isset($member_lastname) && $member_lastname) ? $new_data_member[$key]['_uebns_lastname'] = stripslashes( wp_kses_post( $member_lastname ) ) : $new_data_member[$key]['_uebns_lastname'] = '';
			(isset($member_job) && $member_job) ? $new_data_member[$key]['_uebns_job'] = stripslashes( wp_kses_post( $member_job ) ) : $new_data_member[$key]['_uebns_job'] = '';
			(isset($member_bio) && $member_bio) ? $new_data_member[$key]['_uebns_desc'] = balanceTags( $member_bio ) : $new_data_member[$key]['_uebns_desc'] = '';
			(isset($member_photo) && $member_photo) ? $new_data_member[$key]['_uebns_photo'] = stripslashes( strip_tags( sanitize_text_field( $member_photo ) ) ) : $new_data_member[$key]['_uebns_photo'] = '';
			(isset($member_photo_url) && $member_photo_url) ? $new_data_member[$key]['_uebns_photo_url'] = stripslashes( strip_tags( sanitize_text_field( $member_photo_url ) ) ) : $new_data_member[$key]['_uebns_photo_url'] = '';
			(isset($member_sc) && $member_sc) ? $new_data_member[$key]['_uebns_sc'] = stripslashes( strip_tags( sanitize_text_field( $member_sc ) ) ) : $new_data_member[$key]['_uebns_sc'] = '';
			(isset($member_enabled) && $member_enabled) ? $new_data_member[$key]['_uebns_member_en'] = stripslashes( strip_tags( sanitize_text_field( $member_enabled ) ) ) : $new_data_member[$key]['_uebns_member_en'] = '';
		}
		
		
	}

  	/* Save settings */
	(isset($_POST['uebns_layout']) && $_POST['uebns_layout']) ? $new_team_settings['_uebns_layout'] = stripslashes( strip_tags( sanitize_text_field( $_POST['uebns_layout'] ) ) ) : $new_team_settings['_uebns_layout'] = '';
	(isset($_POST['uebns_photo_setting']) && $_POST['uebns_photo_setting']) ? $new_team_settings['_uebns_photo_setting'] = stripslashes( strip_tags( sanitize_text_field( $_POST['uebns_photo_setting'] ) ) ) : $new_team_settings['_uebns_photo_setting'] = '';
	(isset($_POST['line_member']) && $_POST['line_member']) ? $new_team_settings['_uebns_line_member'] = stripslashes( strip_tags( sanitize_text_field( $_POST['line_member'] ) ) ) : $new_team_settings['_uebns_line_member'] = '';
	(isset($_POST['image_filter']) && $_POST['image_filter']) ? $new_team_settings['_uebns_filter_image'] = stripslashes( strip_tags( sanitize_text_field( $_POST['image_filter'] ) ) ) : $new_team_settings['_uebns_filter_image'] = '';
	(isset($_POST['images_clickable']) && $_POST['images_clickable']) ? $new_team_settings['_uebns_images_clickable'] = stripslashes( strip_tags( sanitize_text_field( $_POST['images_clickable'] ) ) ) : $new_team_settings['_uebns_images_clickable'] = '';
	
	/* Update Team Member*/
	if ( !empty( $new_data_member ) && $new_data_member != $old_data_member ) {
		update_post_meta( $post_id, '_uebns_members', $new_data_member );
	} elseif ( empty($new_data_member) && $old_data_member ){
		delete_post_meta( $post_id, '_uebns_members', $old_data_member );
	}

	/* Update Team Member Settings */
	if ( !empty( $new_team_settings['_uebns_layout'] ) && $new_team_settings['_uebns_layout'] != $old_data_settings['_uebns_layout'] ) {
		update_post_meta( $post_id, '_uebns_layout', $new_team_settings['_uebns_layout'] );
	}
	if ( !empty( $new_team_settings['_uebns_photo_setting'] ) && $new_team_settings['_uebns_photo_setting'] != $old_data_settings['_uebns_photo_setting'] ) {
		update_post_meta( $post_id, '_uebns_photo_setting', $new_team_settings['_uebns_photo_setting'] );
	}
	if ( !empty( $new_team_settings['_uebns_line_member'] ) && $new_team_settings['_uebns_line_member'] != $old_data_settings['_uebns_line_member'] ) {
		update_post_meta( $post_id, '_uebns_line_member', $new_team_settings['_uebns_line_member'] );
	}
	if ( !empty( $new_team_settings['_uebns_filter_image'] ) && $new_team_settings['_uebns_filter_image'] != $old_data_settings['_uebns_filter_image'] ) {
		update_post_meta( $post_id, '_uebns_filter_image', $new_team_settings['_uebns_filter_image'] );
	}
	if ( !empty( $new_team_settings['_uebns_images_clickable'] ) && $new_team_settings['_uebns_images_clickable'] != $old_data_settings['_uebns_images_clickable'] ) {
		update_post_meta( $post_id, '_uebns_images_clickable', $new_team_settings['_uebns_images_clickable'] );
	}
}