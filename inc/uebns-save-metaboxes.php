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

	/* Gets members. */
	$old_team = get_post_meta($post_id, '_uebns_members', true);

	/* Inits new team. */
	$new_team = array();

	/* Settings. */
	$old_team_settings = array();

	//Load old Setting
	$old_team_settings['_uebns_layout'] = get_post_meta( $post_id, '_uebns_layout', true );
	$old_team_settings['_uebns_photo_setting'] = get_post_meta( $post_id, '_uebns_photo_setting', true );
	$old_team_settings['_uebns_color_shema'] = get_post_meta( $post_id, '_uebns_color_shema', true );
	$old_team_settings['_uebns_line_member'] = get_post_meta( $post_id, '_uebns_line_member', true );
	$old_team_settings['_uebns_filter_image'] = get_post_meta( $post_id, '_uebns_filter_image', true );
	$old_team_settings['_uebns_images_clickable'] = get_post_meta( $post_id, '_uebns_images_clickable', true );

	$count = count($_POST['uebns_data']) - 1;
	for ( $i = 0; $i < $count; $i++ ) {
		if($_POST['uebns_data'][$i]){
			$member_data = explode(';;', $_POST['uebns_data'][$i]);
			$member_firstname = $member_data[0];
			$member_lastname = $member_data[1];
			$member_job = $member_data[2];
			$member_bio = $member_data[3];
			$member_scl_type1 = $member_data[4];
			$member_scl_title1 = $member_data[5];
			$member_scl_url1 = $member_data[6];
			$member_scl_type2 = $member_data[7];
			$member_scl_title2 = $member_data[8];
			$member_scl_url2 = $member_data[9];
			$member_scl_type3 = $member_data[10];
			$member_scl_title3 = $member_data[11];
			$member_scl_url3 = $member_data[12];
			$member_photo = $member_data[13];
			$member_photo_url = $member_data[14];

      		/* Saves the member if at least one of these fields are not empty */
			if ( $member_firstname != ''|| $member_lastname != '' || $member_job != ''|| $member_bio != ''|| $member_photo != '' ) {
				(isset($member_firstname) && $member_firstname) ? $new_team[$i]['_uebns_firstname'] = stripslashes( wp_kses_post( $member_firstname ) ) : $new_team[$i]['_uebns_firstname'] = __('Untitled', 'plg-ueber-uns' );
				(isset($member_lastname) && $member_lastname) ? $new_team[$i]['_uebns_lastname'] = stripslashes( wp_kses_post( $member_lastname ) ) : $new_team[$i]['_uebns_lastname'] = '';
				(isset($member_job) && $member_job) ? $new_team[$i]['_uebns_job'] = stripslashes( wp_kses_post( $member_job ) ) : $new_team[$i]['_uebns_job'] = '';
				(isset($member_bio) && $member_bio) ? $new_team[$i]['_uebns_desc'] = balanceTags( $member_bio ) : $new_team[$i]['_uebns_desc'] = '';
				(isset($member_photo) && $member_photo) ? $new_team[$i]['_uebns_photo'] = stripslashes( strip_tags( sanitize_text_field( $member_photo ) ) ) : $new_team[$i]['_uebns_photo'] = '';
				(isset($member_photo_url) && $member_photo_url) ? $new_team[$i]['_uebns_photo_url'] = stripslashes( strip_tags( sanitize_text_field( $member_photo_url ) ) ) : $new_team[$i]['_uebns_photo_url'] = '';
				(isset($member_scl_type1) && $member_scl_type1) ? $new_team[$i]['_uebns_sc_type1'] = stripslashes( strip_tags( sanitize_text_field( $member_scl_type1 ) ) ) : $new_team[$i]['_uebns_sc_type1'] = '';
				(isset($member_scl_title1) && $member_scl_title1) ? $new_team[$i]['_uebns_sc_title1'] = stripslashes( strip_tags( sanitize_text_field( $member_scl_title1 ) ) ) : $new_team[$i]['_uebns_sc_title1'] = '';
				(isset($member_scl_url1) && $member_scl_url1) ? $new_team[$i]['_uebns_sc_url1'] = stripslashes( strip_tags( sanitize_text_field( $member_scl_url1 ) ) ) : $new_team[$i]['_uebns_sc_url1'] = '';
				(isset($member_scl_type2) && $member_scl_type2) ? $new_team[$i]['_uebns_sc_type2'] = stripslashes( strip_tags( sanitize_text_field( $member_scl_type2 ) ) ) : $new_team[$i]['_uebns_sc_type2'] = '';
				(isset($member_scl_title2) && $member_scl_title2) ? $new_team[$i]['_uebns_sc_title2'] = stripslashes( strip_tags( sanitize_text_field( $member_scl_title2 ) ) ) : $new_team[$i]['_uebns_sc_title2'] = '';
				(isset($member_scl_url2) && $member_scl_url2) ? $new_team[$i]['_uebns_sc_url2'] = stripslashes( strip_tags( sanitize_text_field( $member_scl_url2 ) ) ) : $new_team[$i]['_uebns_sc_url2'] = '';
				(isset($member_scl_type3) && $member_scl_type3) ? $new_team[$i]['_uebns_sc_type3'] = stripslashes( strip_tags( sanitize_text_field( $member_scl_type3 ) ) ) : $new_team[$i]['_uebns_sc_type3'] = '';
				(isset($member_scl_title3) && $member_scl_title3) ? $new_team[$i]['_uebns_sc_title3'] = stripslashes( strip_tags( sanitize_text_field( $member_scl_title3 ) ) ) : $new_team[$i]['_uebns_sc_title3'] = '';
				(isset($member_scl_url3) && $member_scl_url3) ? $new_team[$i]['_uebns_sc_url3'] = stripslashes( strip_tags( sanitize_text_field( $member_scl_url3 ) ) ) : $new_team[$i]['_uebns_sc_url3'] = '';
			}
		}
	}

  	/* Save settings */
	(isset($_POST['uebns_layout']) && $_POST['uebns_layout']) ? $new_team_settings['_uebns_layout'] = stripslashes( strip_tags( sanitize_text_field( $_POST['uebns_layout'] ) ) ) : $new_team_settings['_uebns_layout'] = '';
	(isset($_POST['uebns_photo_setting']) && $_POST['uebns_photo_setting']) ? $new_team_settings['_uebns_photo_setting'] = stripslashes( strip_tags( sanitize_text_field( $_POST['uebns_photo_setting'] ) ) ) : $new_team_settings['_uebns_photo_setting'] = '';
	(isset($_POST['uebns-color-shema']) && $_POST['uebns-color-shema']) ? $new_team_settings['_uebns_color_shema'] = stripslashes( strip_tags( sanitize_text_field( $_POST['uebns-color-shema'] ) ) ) : $new_team_settings['_uebns_color_shema'] = '';
	(isset($_POST['line_member']) && $_POST['line_member']) ? $new_team_settings['_uebns_line_member'] = stripslashes( strip_tags( sanitize_text_field( $_POST['line_member'] ) ) ) : $new_team_settings['_uebns_line_member'] = '';
	(isset($_POST['image_filter']) && $_POST['image_filter']) ? $new_team_settings['_uebns_filter_image'] = stripslashes( strip_tags( sanitize_text_field( $_POST['image_filter'] ) ) ) : $new_team_settings['_uebns_filter_image'] = '';
	(isset($_POST['images_clickable']) && $_POST['images_clickable']) ? $new_team_settings['_uebns_images_clickable'] = stripslashes( strip_tags( sanitize_text_field( $_POST['images_clickable'] ) ) ) : $new_team_settings['_uebns_images_clickable'] = '';
	
	/* Updates plans. */
	if ( !empty( $new_team ) && $new_team != $old_team ) {
		update_post_meta( $post_id, '_uebns_members', $new_team );
	} elseif ( empty($new_team) && $old_team ){
		delete_post_meta( $post_id, '_uebns_members', $old_team );
	}

	/* Update Settings */
	if ( !empty( $new_team_settings['_uebns_layout'] ) && $new_team_settings['_uebns_layout'] != $old_team_settings['_uebns_layout'] ) {
		update_post_meta( $post_id, '_uebns_layout', $new_team_settings['_uebns_layout'] );
	}
	if ( !empty( $new_team_settings['_uebns_photo_setting'] ) && $new_team_settings['_uebns_photo_setting'] != $old_team_settings['_uebns_photo_setting'] ) {
		update_post_meta( $post_id, '_uebns_photo_setting', $new_team_settings['_uebns_photo_setting'] );
	}
	if ( !empty( $new_team_settings['_uebns_color_shema'] ) && $new_team_settings['_uebns_color_shema'] != $old_team_settings['_uebns_color_shema'] ) {
		update_post_meta( $post_id, '_uebns_color_shema', $new_team_settings['_uebns_color_shema'] );
	}
	if ( !empty( $new_team_settings['_uebns_line_member'] ) && $new_team_settings['_uebns_line_member'] != $old_team_settings['_uebns_line_member'] ) {
		update_post_meta( $post_id, '_uebns_line_member', $new_team_settings['_uebns_line_member'] );
	}
	if ( !empty( $new_team_settings['_uebns_filter_image'] ) && $new_team_settings['_uebns_filter_image'] != $old_team_settings['_uebns_filter_image'] ) {
		update_post_meta( $post_id, '_uebns_filter_image', $new_team_settings['_uebns_filter_image'] );
	}
	if ( !empty( $new_team_settings['_uebns_images_clickable'] ) && $new_team_settings['_uebns_images_clickable'] != $old_team_settings['_uebns_images_clickable'] ) {
		update_post_meta( $post_id, '_uebns_images_clickable', $new_team_settings['_uebns_images_clickable'] );
	}
}