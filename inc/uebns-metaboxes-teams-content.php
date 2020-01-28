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

/* Hooks the metabox. */
add_action('admin_init', 'uebns_add_team', 1);
function uebns_add_team() {
	add_meta_box( 
		'uebns', 
		__('Teamlist', 'aus' ), 
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
	
	//Array of fielnames in the DB
	$fields_to_process = array(
			'_uebns_firstname',
			'_uebns_lastname',
			'_uebns_job',
			'_uebns_desc',
			'_uebns_sc',
			'_uebns_photo',
			'_uebns_photo_url',
			'_uebns_member_en'
	);

	/* GetIcon Array */
	$social_links_options = getIconArrayList();

	//Hidden field.
	wp_nonce_field( 'uebns_meta_box_nonce', 'uebns_meta_box_nonce' ); 
	
	?>
	<!-- MeatBox -->
	<div class="team_metabox">
		<div class="team_view_toolbar">
			<a class="collapse_all button" href="#">
				<span class="dashicons dashicons-editor-contract"></span>
				<?php _e('Collapse all', 'aus' ) ?>
			</a>
			<a class="expand_all button" href="#">
				<span class="dashicons dashicons-editor-expand"></span>
				<?php _e('Expand all', 'aus' ) ?>
			</a>
			<div class="uebns_clearfix"></div>
		</div><!-- /.team_view_toolbar -->
		<div class="team_area_content">
			<?php 
			if ( $teammembers ) {
				foreach ( $teammembers as $team_member ) {
					$member = array();
					foreach ( $fields_to_process as $field) {
						$member[$field] = ( isset($team_member[$field]) ) ? esc_attr($team_member[$field]) : ''; // Default empty
					}
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
							<?php echo __('Member details','aus'); ?>
						</div><!-- ./member_head_title -->
						<div class="member_field_firstname member-grid member-grid-33">
							<div class="member_field_title">
								<?php echo __('First name','aus'); ?>
							</div>
							<input class="ubns-field regular-text member-firstname-field" type="text" value="<?php echo $member['_uebns_firstname']; ?>" placeholder="<?php echo __('e.g. Max','aus'); ?>">
						</div><!-- ./member_field_firstname -->
						<div class="member_field_lastname member-grid member-grid-33">
							<div class="member_field_title">
							<?php echo __('Lastname','aus'); ?>
							</div>
							<input class="ubns-field regular-text member-lastname-field" type="text" value="<?php echo $member['_uebns_lastname']; ?>" placeholder="<?php echo __('e.g. Mustermann','aus'); ?>">
						</div><!-- ./member_field_lastname -->
						<div class="member_field_jobrole member-grid member-grid-33">
							<div class="member_field_title">
							<?php echo __('Job titel','aus'); ?>
							</div>
							<input class="ubns-field regular-text member-jobrole-field" type="text" value="<?php echo $member['_uebns_job']; ?>" placeholder="<?php echo __('e.g. Lead','aus'); ?>">
						</div><!-- ./member_field_jobrole -->
						<div class="member_field_jobrole member-grid member-grid-100">
							<div class="member_field_title">
							<?php echo __('Biography','aus'); ?>
							</div>
							<div class="ubns-field uebns_description_of_member">
							</div>
							<textarea id="uebns-description-member" class="textarea-member-bio"><?php echo $member['_uebns_desc']; ?></textarea>
						</div><!-- ./member_field_jobrole -->
						<div class="uebns_clearfix"></div><!-- Clearfix -->
						<div class="member_head_title">
							<?php echo __('Social media links','aus'); ?>
						</div><!-- ./member_head_title -->
						<?php
							if ( isset($member['_uebns_sc']) && !empty($member['_uebns_sc']) ){
								?><?php
								$member_sc_data = explode('||', $member['_uebns_sc']);
								$i=0;
								foreach ($member_sc_data as $member_sc_line){
									if(empty($member_sc_line)){break;}
									$member_sc_line_data = explode('###', $member_sc_line);
									$member_social_media_kanal = $member_sc_line_data[0];
									$member_social_link_titel = $member_sc_line_data[1];
									$uebns_field_link_url = $member_sc_line_data[2];
								?>
								<div class="social-boxes">
									<div class="member_field_social_link member-grid member-grid-33"> <!-- Social Media Line -->
										<div class="member_field_title">
											<?php echo __('Social media kanal','aus'); ?>
										</div>
									</div><!-- ./member_field_social_link -->
									<div class="member_field_social_link_name member-grid member-grid-33">
										<div class="member_field_title">
											<?php echo __('Link titel','aus'); ?>
										</div>
									</div><!-- ./member_field_social_link_name -->
									<div class="member_field_social_link_url member-grid member-grid-33">
										<div class="member_field_title">
											<?php echo __('Link URL','aus'); ?>
										</div>
									</div><!-- ./member_field_social_link_url -->
									<div class="uebns_clearfix"></div><!-- Clearfix -->
										<div class="member_field_social_link row-second member-grid member-grid-33"> <!-- Social Media Line -->
											<select class="ubns-select member_social_media_kanal<?php echo $i; ?>">
												<?php foreach ( $social_links_options as $label => $css_class ) { ?>
												<option value="<?php echo $label; ?>" <?php selected( $member_social_media_kanal, $label ); ?>><?php echo $label; ?></option>
												<?php } ?>
											</select>
										</div><!-- ./member_field_social_link -->
										<div class="member_field_social_link_name row-second member-grid member-grid-33">
											<input class="ubns-field uebns-field-link-titel regular-text member-social-link-titel<?php echo $i; ?>-field" type="text" value="<?php echo $member_social_link_titel; ?>" placeholder="<?php echo __('e.g. Mail','aus'); ?>">
										</div><!-- ./member_field_social_link_name -->
										<div class="member_field_social_link_url row-second member-grid member-grid-33">
											<input class="ubns-field uebns-field-link-url regular-text member-social-link-url<?php echo $i; ?>-field" type="text" value="<?php echo $uebns_field_link_url; ?>" placeholder="<?php echo __('e.g. mailto:info@example.com','aus'); ?>">
											<a class="button button-trash-social-line-btn button-large" href="#"><span class="dashicons dashicons-trash"></span></a>		
										</div><!-- ./member_field_social_link_url -->
										<div class="uebns_clearfix"></div><!-- Clearfix -->
									</div>
								<?php
								$i++;
								}								
							}
						?>						
						<div class="member_field_social_link uebns-social-add member-grid member-grid-33"> 
							<a class="button button-primary button-large button-social-add" href="#"><span class="dashicons dashicons-share"></span> <?php echo __('Add','aus') ?></a>
						</div><!-- ./member_field_social_link_name -->
						<div class="uebns_clearfix"></div><!-- Clearfix -->
						<div class="member_head_title">
							<?php echo __('Photo','aus'); ?>
						</div><!-- ./member_head_title -->
						<div class="member_field_photo member-grid member-grid-33">
							<div class="member_field_title">
							<?php echo __('Image profile','aus'); ?>
							</div>
							<div class="uebns_field_title uebns_img_data_url" data-img="<?php echo $member['_uebns_photo']; ?>"></div>
							<div class="uebns_upload_img_btn button button-primary button-large">
								<?php echo __('Upload photo', 'aus' ) ?>
							</div>
						</div><!-- ./member_field_photo -->
						<div class="member_field_profile_image row-second member-grid member-grid-33">
							<div class="member_field_title">
								<?php echo __('Image Link','aus'); ?>
							</div>
							<input class="ubns-field regular-text member-image-link-field" type="text" value="<?php echo $member['_uebns_photo_url']; ?>" placeholder="<?php echo __('e.g. http://example.com/member','aus'); ?>">
						</div><!-- ./member_field_profile_image -->
						<div class="uebns_clearfix"></div><!-- Clearfix -->
						<div class="member_head_title">
							<?php echo __('Member Setting','aus'); ?>
						</div><!-- ./member_head_title -->
						<div class="member_field_dis_en_member uebns-social-add member-grid member-grid-33">
							<div class="member_field_title">
								<?php echo __('Member enabled','aus'); ?>
							</div>
							<input class="uebns-checkbox-field uebns-user-enabled" id="member_en_dis" type="checkbox" name="member_en_dis" value="y" <?php echo ($member['_uebns_member_en'] === 'y' ? 'checked' : '' ); ?>>
							<!-- <label for="member_en_dis"><?php echo __('Member enabled?','aus'); ?></label> -->
						</div><!-- ./member_field_social_link_name -->
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
					<div class="member_add_title"><?php echo __('Untitled','aus'); ?></div>
					<a class="button trash remove_row" href="#" title="Remove"><span class="dashicons dashicons-trash"></span></a>
					<div class="uebns_clearfix"></div>
				</div><!-- /.member_toolbar -->
				<div class="member_add_content_row">
					<div class="member_head_title">
						<?php echo __('Member details','aus'); ?>
					</div><!-- ./member_head_title -->
					<div class="member_field_firstname member-grid member-grid-33">
						<div class="member_field_title">
							<?php echo __('First name','aus'); ?>
						</div>
						<input class="ubns-field regular-text member-firstname-field" type="text" value="" placeholder="<?php echo __('e.g. Max','aus'); ?>">
					</div><!-- ./member_field_firstname -->
					<div class="member_field_lastname member-grid member-grid-33">
						<div class="member_field_title">
						<?php echo __('Lastname','aus'); ?>
						</div>
						<input class="ubns-field regular-text member-lastname-field" type="text" value="" placeholder="<?php echo __('e.g. Mustermann','aus'); ?>">
					</div><!-- ./member_field_lastname -->
					<div class="member_field_jobrole member-grid member-grid-33">
						<div class="member_field_title">
						<?php echo __('Job titel','aus'); ?>
						</div>
						<input class="ubns-field regular-text member-jobrole-field" type="text" value="" placeholder="<?php echo __('e.g. Lead','aus'); ?>">
					</div><!-- ./member_field_jobrole -->
					<div class="member_field_jobrole member-grid member-grid-100">
						<div class="member_field_title">
						<?php echo __('Biography','aus'); ?>
						</div>
						<div class="ubns-field uebns_description_of_member">
						</div>
						<textarea id="uebns-description-member" class="textarea-member-bio"></textarea>
					</div><!-- ./member_field_jobrole -->
					<div class="uebns_clearfix"></div><!-- Clearfix -->
					<div class="member_head_title">
						<?php echo __('Social media links','aus'); ?>
					</div><!-- ./member_head_title -->
					<div class="member_field_social_link uebns-social-add member-grid member-grid-33"> 
							<a class="button button-primary button-large button-social-add" href="#"><span class="dashicons dashicons-share"></span> <?php echo __('Add','aus') ?></a>
					</div><!-- ./member_field_social_link_name -->
					<div class="uebns_clearfix"></div><!-- Clearfix -->
					<div class="member_head_title">
						<?php echo __('Photo','aus'); ?>
					</div><!-- ./member_head_title -->
					<div class="member_field_photo member-grid member-grid-33">
						<div class="member_field_title">
						<?php echo __('Image profile','aus'); ?>
						</div>
						<div class="uebns_field_title uebns_img_data_url" data-img=""></div>
						<div class="uebns_upload_img_btn button button-primary button-large">
							<?php echo __('Upload photo', 'aus' ) ?>
						</div>
					</div><!-- ./member_field_photo -->
					<div class="member_field_profile_image row-second member-grid member-grid-33">
						<div class="member_field_title">
							<?php echo __('Image Link','aus'); ?>
						</div>
						<input class="ubns-field regular-text member-image-link-field" type="text" value="" placeholder="<?php echo __('e.g. http://example.com/member','aus'); ?>">
					</div><!-- ./member_field_profile_image -->
					<div class="uebns_clearfix"></div><!-- Clearfix -->
					<div class="member_head_title">
						<?php echo __('Member Setting','aus'); ?>
					</div><!-- ./member_head_title -->
					<div class="member_field_dis_en_member uebns-social-add member-grid member-grid-33">
						<div class="member_field_title">
							<?php echo __('Member enabled','aus'); ?>
						</div>
						<input class="uebns-checkbox-field uebns-user-enabled" id="member_en_dis" type="checkbox" name="member_en_dis" value="y">
						<!-- <label for="member_en_dis"><?php echo __('Member enabled?','aus'); ?></label> -->
					</div><!-- ./member_field_social_link_name -->
					<div class="uebns_clearfix"></div><!-- Clearfix -->
				</div><!-- ./member_add_content_row -->
			</div><!-- /.team_member_add_content -->
			<div class="row_clear row_content"> <!-- Empty Row -->
				<?php echo __('Click the <strong>Add member</strong> button to add a team member to the list.','aus'); ?>
			</div><!-- /.row_clear -->
		</div><!-- /.team_area_content -->
		<div class="team_area_footer">
			<a class="add_member_button button button-primary button-large" href="#">
				<span class="dashicons dashicons-id"></span>
				<?php _e('Add member', 'aus' ) ?>
			</a>
		</div><!-- /.team_area_footer -->
	</div>
	<!-- Empty Social Box -->
	<div class="social-box" style="display:none;">
		<div class="member_field_social_link member-grid member-grid-33"> <!-- Social Media Line -->
			<div class="member_field_title">
				<?php echo __('Social media kanal','aus'); ?>
			</div>
		</div><!-- ./member_field_social_link -->
		<div class="member_field_social_link_name member-grid member-grid-33">
			<div class="member_field_title">
				<?php echo __('Link titel','aus'); ?>
			</div>
		</div><!-- ./member_field_social_link_name -->
		<div class="member_field_social_link_url member-grid member-grid-33">
			<div class="member_field_title">
				<?php echo __('Link URL','aus'); ?>
			</div>
		</div><!-- ./member_field_social_link_url -->
		<div class="uebns_clearfix"></div><!-- Clearfix -->
		<div class="member_field_social_link row-second member-grid member-grid-33"> 
			<select class="ubns-select">
				<?php foreach ( $social_links_options as $label => $css_class ) { ?>
				<option value="<?php echo $label; ?>"><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div><!-- ./member_field_social_link -->
		<div class="member_field_social_link_name row-second member-grid member-grid-33">
			<input class="ubns-field uebns-field-link-titel regular-text" type="text" value="" placeholder="<?php echo __('e.g. Mail','aus'); ?>">
		</div><!-- ./member_field_social_link_name -->
		<div class="member_field_social_link_url row-second member-grid member-grid-33">
			<input class="ubns-field uebns-field-link-url regular-text" type="text" value="" placeholder="<?php echo __('e.g. mailto:info@example.com','aus'); ?>">
			<a class="button button-trash-social-line-btn button-large" href="#"><span class="dashicons dashicons-trash"></span></a>				
		</div><!-- ./member_field_social_link_url -->
		<div class="uebns_clearfix"></div><!-- Clearfix -->
	</div>
	<!-- End Empty Social Box -->
<?php
}