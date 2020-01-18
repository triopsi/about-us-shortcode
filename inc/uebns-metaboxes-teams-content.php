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

/* Hooks the metabox. */
add_action('admin_init', 'uebns_add_team', 1);
function uebns_add_team() {
	add_meta_box( 
		'uebns', 
		__('Teamlist', 'plg-ueber-uns' ), 
		'uebns_team_display', // Below
		'uebns', 
		'normal', 
		'high'
	);
}

/**
 * Show the add/edit postpage in admin
 *
 * @return void
 */
function uebns_team_display(){

	//Global Post
    global $post;
	
	//get post meta data
	$teammembers = get_post_meta( $post->ID, '_uebns_members', true );
	
	//Array of Shortcode Fields of the member
	$fields_to_process = array(
		'_uebns_firstname',
		'_uebns_lastname',
		'_uebns_job',
		'_uebns_desc',
		'_uebns_sc_type1', '_uebns_sc_title1', '_uebns_sc_url1',
		'_uebns_sc_type2', '_uebns_sc_title2', '_uebns_sc_url2',
		'_uebns_sc_type3', '_uebns_sc_title3', '_uebns_sc_url3',
		'_uebns_photo',
		'_uebns_photo_url'
	);

    /* Retrieves select options. */
	$social_links_options = social_links_options();

	//Hidden field.
	wp_nonce_field( 'uebns_meta_box_nonce', 'uebns_meta_box_nonce' ); 
	
	?>
	<!-- MeatBox -->
	<div class="team_metabox">
		<div class="team_view_toolbar">
			<a class="collapse_all button" href="#">
				<span class="dashicons dashicons-editor-contract"></span>
				<?php _e('Collapse all', 'plg-ueber-uns' ) ?>
			</a>
			<a class="expand_all button" href="#">
				<span class="dashicons dashicons-editor-expand"></span>
				<?php _e('Expand all', 'plg-ueber-uns' ) ?>
			</a>
			<div class="uebns_clearfix"></div>
		</div><!-- /.team_view_toolbar -->
		<div class="team_area_content">
			<?php 
			if ( $teammembers ) {
				// echo 'Teams gefunden!';
				/* Loops through rows. */
				foreach ( $teammembers as $team_member ) {

					/* Retrieves each field for current member. */
					$member = array();
					foreach ( $fields_to_process as $field) {
						switch ($field) {
							default:
								$member[$field] = ( isset($team_member[$field]) ) ? esc_attr($team_member[$field]) : '';
								break;
						}
					} 
					// echo var_dump($team_member);
					
					?>
				<!-- Load Members -->
					<div class="team_member_add_content"> <!-- #Start with full member -->
					<textarea class="uebns_data" name="uebns_data[]"></textarea>  
					<div class="member_toolbar">
						<a class="move_row_up button tool" href="#" title="Move up"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
						<a class="move_row_down button tool" href="#" title="Move down"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
						<div class="member_add_image_thumbnail"><img class="thumbnail-titelbar" src="<?php echo $member['_uebns_photo']; ?>"></div>
						<div class="member_add_title"></div>
						<a class="button trash remove_row" href="#" title="Remove"><span class="dashicons dashicons-trash"></span></a>
						<div class="uebns_clearfix"></div>
					</div><!-- /.member_toolbar -->
					<div class="member_add_content_row">
						<div class="member_head_title">
							<?php echo __('Member details','plg-ueber-uns'); ?>
						</div><!-- ./member_head_title -->
						<div class="member_field_firstname member-grid member-grid-33">
							<div class="member_field_title">
								<?php echo __('First name','plg-ueber-uns'); ?>
							</div>
							<input class="ubns-field regular-text member-firstname-field" type="text" value="<?php echo $member['_uebns_firstname']; ?>" placeholder="<?php echo __('e.g. Max','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_firstname -->
						<div class="member_field_lastname member-grid member-grid-33">
							<div class="member_field_title">
							<?php echo __('Lastname','plg-ueber-uns'); ?>
							</div>
							<input class="ubns-field regular-text member-lastname-field" type="text" value="<?php echo $member['_uebns_lastname']; ?>" placeholder="<?php echo __('e.g. Mustermann','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_lastname -->
						<div class="member_field_jobrole member-grid member-grid-33">
							<div class="member_field_title">
							<?php echo __('Job titel','plg-ueber-uns'); ?>
							</div>
							<input class="ubns-field regular-text member-jobrole-field" type="text" value="<?php echo $member['_uebns_job']; ?>" placeholder="<?php echo __('e.g. Lead','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_jobrole -->
						<div class="member_field_jobrole member-grid member-grid-100">
							<div class="member_field_title">
							<?php echo __('Biography','plg-ueber-uns'); ?>
							</div>
							<div class="ubns-field uebns_description_of_member">
							</div>
							<textarea id="uebns-description-member" class="textarea-member-bio"><?php echo $member['_uebns_desc']; ?></textarea>
						</div><!-- ./member_field_jobrole -->
						<div class="uebns_clearfix"></div><!-- Clearfix -->
						<div class="member_head_title">
							<?php echo __('Social media links','plg-ueber-uns'); ?>
						</div><!-- ./member_head_title -->
						<div class="member_field_social_link member-grid member-grid-33"> <!-- Round 1 -->
							<div class="member_field_title">
							<?php echo __('Social media kanal','plg-ueber-uns'); ?>
							</div>
							<select class="ubns-select member_social_media_kanal1">
								<?php foreach ( $social_links_options as $label => $value ) { ?>
									<option value="<?php echo $value; ?>" <?php selected( $member['_uebns_sc_type1'], $value ); ?>><?php echo $label; ?></option>
								<?php } ?>
							</select>
						</div><!-- ./member_field_social_link -->
						<div class="member_field_social_link_name member-grid member-grid-33">
							<div class="member_field_title">
							<?php echo __('Link titel','plg-ueber-uns'); ?>
							</div>
							<input class="ubns-field regular-text member-social-link-titel1-field" type="text" value="<?php echo $member['_uebns_sc_title1']; ?>" placeholder="<?php echo __('e.g. Twitter','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_social_link_name -->
						<div class="member_field_social_link_url member-grid member-grid-33">
							<div class="member_field_title">
							<?php echo __('Link URL','plg-ueber-uns'); ?>
							</div>
							<input class="ubns-field regular-text member-social-link-url1-field" type="text" value="<?php echo $member['_uebns_sc_url1']; ?>" placeholder="<?php echo __('e.g. http://twitter.com/user-profile','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_social_link_url -->
						<div class="uebns_clearfix"></div><!-- Clearfix -->
						<div class="member_field_social_link row-second member-grid member-grid-33"> <!-- Round 2 -->
							<select class="ubns-select member_social_media_kanal2">
								<?php foreach ( $social_links_options as $label => $value ) { ?>
									<option value="<?php echo $value; ?>" <?php selected( $member['_uebns_sc_type2'], $value ); ?>><?php echo $label; ?></option>
								<?php } ?>
							</select>
						</div><!-- ./member_field_social_link -->
						<div class="member_field_social_link_name row-second member-grid member-grid-33">
							<input class="ubns-field regular-text member-social-link-titel2-field" type="text" value="<?php echo $member['_uebns_sc_title2']; ?>" placeholder="<?php echo __('e.g. Facebook','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_social_link_name -->
						<div class="member_field_social_link_url row-second member-grid member-grid-33">
							<input class="ubns-field regular-text member-social-link-url2-field" type="text" value="<?php echo $member['_uebns_sc_url2']; ?>" placeholder="<?php echo __('e.g. http://facebook.com/user-profile','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_social_link_url -->
						<div class="uebns_clearfix"></div><!-- Clearfix -->
						<div class="member_field_social_link row-second member-grid member-grid-33"> <!-- Round 3 -->
							<select class="ubns-select member_social_media_kanal3">
								<?php foreach ( $social_links_options as $label => $value ) { ?>
									<option value="<?php echo $value; ?>" <?php selected( $member['_uebns_sc_type3'], $value ); ?>><?php echo $label; ?></option>
								<?php } ?>
							</select>
						</div><!-- ./member_field_social_link -->
						<div class="member_field_social_link_name row-second member-grid member-grid-33">
							<input class="ubns-field regular-text member-social-link-titel3-field" type="text" value="<?php echo $member['_uebns_sc_title3']; ?>" placeholder="<?php echo __('e.g. Mail','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_social_link_name -->
						<div class="member_field_social_link_url row-second member-grid member-grid-33">
							<input class="ubns-field regular-text member-social-link-url3-field" type="text" value="<?php echo $member['_uebns_sc_url3']; ?>" placeholder="<?php echo __('e.g. mailto:info@example.com','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_social_link_url -->
						<div class="uebns_clearfix"></div><!-- Clearfix -->
						<div class="member_head_title">
							<?php echo __('Photo','plg-ueber-uns'); ?>
						</div><!-- ./member_head_title -->
						<div class="member_field_photo member-grid member-grid-33">
							<div class="member_field_title">
							<?php echo __('Image profile','plg-ueber-uns'); ?>
							</div>
							<div class="uebns_field_title uebns_img_data_url" data-img="<?php echo $member['_uebns_photo']; ?>"></div>
							<div class="uebns_upload_img_btn button button-primary button-large">
								<?php echo __('Upload photo', 'plg-ueber-uns' ) ?>
							</div>
						</div><!-- ./member_field_photo -->
						<div class="member_field_profile_image row-second member-grid member-grid-33">
							<div class="member_field_title">
								<?php echo __('Image Link','plg-ueber-uns'); ?>
							</div>
							<input class="ubns-field regular-text member-image-link-field" type="text" value="<?php echo $member['_uebns_photo_url']; ?>" placeholder="<?php echo __('e.g. http://example.com/member','plg-ueber-uns'); ?>">
						</div><!-- ./member_field_profile_image -->
						<div class="uebns_clearfix"></div><!-- Clearfix -->
						</div><!-- ./member_add_content_row -->
					</div><!-- /.team_member_add_content -->
				<!-- /Load Members -->
			<?php
				} // Ende Schleife Member
			}else{
				// echo "Team nicht gefunden";
			}
			?>
			<div class="team_member_add_content member_empty" style="display:none;"> <!-- #Start with empty member -->
				<textarea class="uebns_data" name="uebns_data[]"></textarea>  
				<div class="member_toolbar">
					<a class="move_row_up button tool" href="#" title="Move up"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
					<a class="move_row_down button tool" href="#" title="Move down"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
					<div class="member_add_image_thumbnail"></div>
					<div class="member_add_title"><?php echo __('Untitled','plg-ueber-uns'); ?></div>
					<a class="button trash remove_row" href="#" title="Remove"><span class="dashicons dashicons-trash"></span></a>
					<div class="uebns_clearfix"></div>
				</div><!-- /.member_toolbar -->
				<div class="member_add_content_row">
					<div class="member_head_title">
						<?php echo __('Member details','plg-ueber-uns'); ?>
					</div><!-- ./member_head_title -->
					<div class="member_field_firstname member-grid member-grid-33">
						<div class="member_field_title">
							<?php echo __('First name','plg-ueber-uns'); ?>
						</div>
						<input class="ubns-field regular-text member-firstname-field" type="text" value="" placeholder="<?php echo __('e.g. Max','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_firstname -->
					<div class="member_field_lastname member-grid member-grid-33">
						<div class="member_field_title">
						<?php echo __('Lastname','plg-ueber-uns'); ?>
						</div>
						<input class="ubns-field regular-text member-lastname-field" type="text" value="" placeholder="<?php echo __('e.g. Mustermann','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_lastname -->
					<div class="member_field_jobrole member-grid member-grid-33">
						<div class="member_field_title">
						<?php echo __('Job titel','plg-ueber-uns'); ?>
						</div>
						<input class="ubns-field regular-text member-jobrole-field" type="text" value="" placeholder="<?php echo __('e.g. Lead','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_jobrole -->
					<div class="member_field_jobrole member-grid member-grid-100">
						<div class="member_field_title">
						<?php echo __('Biography','plg-ueber-uns'); ?>
						</div>
						<div class="ubns-field uebns_description_of_member">
						</div>
						<textarea id="uebns-description-member" class="textarea-member-bio"></textarea>
					</div><!-- ./member_field_jobrole -->
					<div class="uebns_clearfix"></div><!-- Clearfix -->
					<div class="member_head_title">
						<?php echo __('Social media links','plg-ueber-uns'); ?>
					</div><!-- ./member_head_title -->
					<div class="member_field_social_link member-grid member-grid-33"> <!-- Round 1 -->
						<div class="member_field_title">
						<?php echo __('Social media kanal','plg-ueber-uns'); ?>
						</div>
						<select class="ubns-select member_social_media_kanal1">
							<?php foreach ( $social_links_options as $label => $value ) { ?>
								<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
							<?php } ?>
						</select>
					</div><!-- ./member_field_social_link -->
					<div class="member_field_social_link_name member-grid member-grid-33">
						<div class="member_field_title">
						<?php echo __('Link titel','plg-ueber-uns'); ?>
						</div>
						<input class="ubns-field regular-text member-social-link-titel1-field" type="text" value="" placeholder="<?php echo __('e.g. Twitter','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_social_link_name -->
					<div class="member_field_social_link_url member-grid member-grid-33">
						<div class="member_field_title">
						<?php echo __('Link URL','plg-ueber-uns'); ?>
						</div>
						<input class="ubns-field regular-text member-social-link-url1-field" type="text" value="" placeholder="<?php echo __('e.g. http://twitter.com/user-profile','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_social_link_url -->
					<div class="uebns_clearfix"></div><!-- Clearfix -->
					<div class="member_field_social_link row-second member-grid member-grid-33"> <!-- Round 2 -->
						<select class="ubns-select member_social_media_kanal2">
							<?php foreach ( $social_links_options as $label => $value ) { ?>
								<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
							<?php } ?>
						</select>
					</div><!-- ./member_field_social_link -->
					<div class="member_field_social_link_name row-second member-grid member-grid-33">
						<input class="ubns-field regular-text member-social-link-titel2-field" type="text" value="" placeholder="<?php echo __('e.g. Facebook','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_social_link_name -->
					<div class="member_field_social_link_url row-second member-grid member-grid-33">
						<input class="ubns-field regular-text member-social-link-url2-field" type="text" value="" placeholder="<?php echo __('e.g. http://facebook.com/user-profile','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_social_link_url -->
					<div class="uebns_clearfix"></div><!-- Clearfix -->
					<div class="member_field_social_link row-second member-grid member-grid-33"> <!-- Round 3 -->
						<select class="ubns-select member_social_media_kanal3">
							<?php foreach ( $social_links_options as $label => $value ) { ?>
								<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
							<?php } ?>
						</select>
					</div><!-- ./member_field_social_link -->
					<div class="member_field_social_link_name row-second member-grid member-grid-33">
						<input class="ubns-field regular-text member-social-link-titel3-field" type="text" value="" placeholder="<?php echo __('e.g. Mail','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_social_link_name -->
					<div class="member_field_social_link_url row-second member-grid member-grid-33">
						<input class="ubns-field regular-text member-social-link-url3-field" type="text" value="" placeholder="<?php echo __('e.g. mailto:info@example.com','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_social_link_url -->
					<div class="uebns_clearfix"></div><!-- Clearfix -->
					<div class="member_head_title">
						<?php echo __('Photo','plg-ueber-uns'); ?>
					</div><!-- ./member_head_title -->
					<div class="member_field_photo member-grid member-grid-33">
						<div class="member_field_title">
						<?php echo __('Image profile','plg-ueber-uns'); ?>
						</div>
						<div class="uebns_field_title uebns_img_data_url" data-img=""></div>
						<div class="uebns_upload_img_btn button button-primary button-large">
							<?php echo __('Upload photo', 'plg-ueber-uns' ) ?>
						</div>
					</div><!-- ./member_field_photo -->
					<div class="member_field_profile_image row-second member-grid member-grid-33">
						<div class="member_field_title">
							<?php echo __('Image Link','plg-ueber-uns'); ?>
						</div>
						<input class="ubns-field regular-text member-image-link-field" type="text" value="" placeholder="<?php echo __('e.g. http://example.com/member','plg-ueber-uns'); ?>">
					</div><!-- ./member_field_profile_image -->
					<div class="uebns_clearfix"></div><!-- Clearfix -->
				</div><!-- ./member_add_content_row -->
			</div><!-- /.team_member_add_content -->
			<div class="row_clear row_content"> <!-- Empty Row -->
				<?php echo __('Click the <strong>Add member</strong> button to add a team member to the list.','plg-ueber-uns'); ?>
			</div><!-- /.row_clear -->
		</div><!-- /.team_area_content -->
		<div class="team_area_footer">
			<a class="add_member_button button button-primary button-large" href="#">
				<span class="dashicons dashicons-id"></span>
				<?php _e('Add member', 'plg-ueber-uns' ) ?>
			</a>
		</div><!-- /.team_area_footer -->
	</div>
    
<?php

}