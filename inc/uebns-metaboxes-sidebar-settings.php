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

/* Add a metabox */
add_action('admin_init', 'uebns_add_settings', 1);
function uebns_add_settings() {
	add_meta_box( 
		'uebns_settings', 
		'<span class="dashicons dashicons-admin-generic"></span> '.__('Settings', 'aus'), 
		'uebns_settings_display', 
		'uebns', 
		'side', 
		'low'
	);
}

/* Displays the metabox */
function uebns_settings_display() { 
	
	global $post;
	$settings = array();

	$settings['_uebns_layout'] = get_post_meta( $post->ID, '_uebns_layout', true );
	if (!$settings['_uebns_layout']) { $settings['_uebns_layout'] = 'default'; }

	$settings['_uebns_photo_setting'] = get_post_meta( $post->ID, '_uebns_photo_setting', true );
	if (!$settings['_uebns_photo_setting']) { $settings['_uebns_photo_setting'] = 'round'; }

	$settings['_uebns_color_shema'] = get_post_meta( $post->ID, '_uebns_color_shema', true );
	if (!$settings['_uebns_color_shema']) { $settings['_uebns_color_shema'] = '#eb5466'; }

	$options_members_line = array ( 
		__('1 per line', 'aus') => '1',
		__('2 per line', 'aus') => '2',
		__('3 per line', 'aus') => '3',
		__('4 per line', 'aus') => '4',
		__('5 per line', 'aus') => '5'    
	);

	$settings['_uebns_line_member'] = get_post_meta( $post->ID, '_uebns_line_member', true );
	if (!$settings['_uebns_line_member']) { $settings['_uebns_line_member'] = '1'; }

	$options_image_filter = array ( 
		__('none', 'aus') => 'none',
		__('grayscale', 'aus') => 'grayscale',
		__('sepia', 'aus') => 'sepia' 
	);
	$settings['_uebns_filter_image'] = get_post_meta( $post->ID, '_uebns_filter_image', true );
	if (!$settings['_uebns_filter_image']) { $settings['_uebns_filter_image'] = 'none'; }

	$options_images_clickable = array ( 
		__('no', 'aus') => 'no',
		__('yes', 'aus') => 'yes'
	);

	$settings['_uebns_images_clickable'] = get_post_meta( $post->ID, '_uebns_images_clickable', true );
	if (!$settings['_uebns_images_clickable']) { $settings['_uebns_images_clickable'] = 'no'; }


	?>
	<div class="uebns_settings_box uebns_sidebar">
		<div class="member_head_title">
			<?php /* translators: General settings */ _e('General', 'aus') ?>
		</div>
		<!-- Layout Settings -->
		<div class="layout_settings">
			<div class="member_field_title">
					<?php _e('Member per line', 'aus' ) ?>
			</div>
			<div class="layout_out">
				<select class="" name="line_member">	
					<?php foreach ( $options_members_line as $label => $value ) { ?>
						<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_uebns_line_member'])) ? $settings['_uebns_line_member'] : '1', $value ); ?>><?php echo $label; ?></option>
					<?php } ?>
				</select>
			</div>
		</div><!-- /.layout_settings -->
		<!-- Layout Settings -->
		<div class="layout_settings">
			<div class="member_field_title">
					<?php _e('Layout', 'aus' ) ?>
			</div>
			<div class="layout_out">
				<fielset>
					<label class="uebns-setting-checkbox"><input type="radio" name="uebns_layout" value="default" <?php echo ( ( isset($settings['_uebns_layout']) && $settings['_uebns_layout'] === 'default' ) ? 'checked="checked"' : ''); ?>><img src="<?php echo plugins_url('../assets/img/settings_theme_default.png', __FILE__); ?>"> </label>
					<label class="uebns-setting-checkbox"><input type="radio" name="uebns_layout" value="layout1" <?php echo ( ( isset($settings['_uebns_layout']) && $settings['_uebns_layout'] === 'layout1' ) ? 'checked="checked"' : ''); ?>><img src="<?php echo plugins_url('../assets/img/settings_theme_layout_1.png', __FILE__); ?>"> </label>
					<label class="uebns-setting-checkbox"><input type="radio" name="uebns_layout" value="layout2" <?php echo ( ( isset($settings['_uebns_layout']) && $settings['_uebns_layout'] === 'layout2' ) ? 'checked="checked"' : ''); ?>><img src="<?php echo plugins_url('../assets/img/settings_theme_layout_2.png', __FILE__); ?>"> </label>	
				</fielset>
			</div>
		</div><!-- /.layout_settings -->
		<!-- Photo Layout Setting -->
		<div class="layout_settings">
			<div class="member_field_title">
					<?php _e('Profile Photo Style', 'aus' ) ?>
			</div>
			<div class="layout_out">
				<fielset>
					<label class="uebns-setting-checkbox"><input type="radio" name="uebns_photo_setting" value="round" <?php echo ( ( isset($settings['_uebns_photo_setting']) && $settings['_uebns_photo_setting'] === 'round' ) ? 'checked="checked"' : ''); ?>><img src="<?php echo plugins_url('../assets/img/settings_photo_setting_round.png', __FILE__); ?>"> </label>
					<label class="uebns-setting-checkbox"><input type="radio" name="uebns_photo_setting" value="square" <?php echo ( ( isset($settings['_uebns_photo_setting']) && $settings['_uebns_photo_setting'] === 'square' ) ? 'checked="checked"' : ''); ?>><img src="<?php echo plugins_url('../assets/img/settings_photo_setting_square.png', __FILE__); ?>"> </label>
				</fielset>
			</div>
		</div><!-- /.layout_settings -->
		<!-- Layout Settings -->
		<div class="layout_settings">
			<div class="member_field_title">
					<?php _e('Image Filter', 'aus' ) ?>
			</div>
			<div class="layout_out">
				<select class="" name="image_filter">	
					<?php foreach ( $options_image_filter as $label => $value ) { ?>
						<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_uebns_filter_image'])) ? $settings['_uebns_filter_image'] : 'none', $value ); ?>><?php echo $label; ?></option>
					<?php } ?>
				</select>
			</div>
		</div><!-- /.layout_settings -->
		<!-- Layout Settings -->
		<div class="layout_settings">
			<div class="member_field_title">
					<?php _e('Images clickable?', 'aus' ) ?>
			</div>
			<div class="layout_out">
				<select class="" name="images_clickable">	
					<?php foreach ( $options_images_clickable as $label => $value ) { ?>
						<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_uebns_images_clickable'])) ? $settings['_uebns_images_clickable'] : 'no', $value ); ?>><?php echo $label; ?></option>
					<?php } ?>
				</select>
			</div>
		</div><!-- /.layout_settings -->
	</div>
<?php 
}
