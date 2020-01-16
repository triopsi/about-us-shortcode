<?php 

/* Hooks the metabox. */
add_action('admin_init', 'uebns_add_settings', 1);
function uebns_add_settings() {
	add_meta_box( 
		'uebns_settings', 
		'<span class="dashicons dashicons-admin-generic"></span> '.__('Settings', 'plg-ueber-uns'), 
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
	$settings['_tmm_columns'] = get_post_meta( $post->ID, '_tmm_columns', true );
	if (!$settings['_tmm_columns']) { $settings['_tmm_columns'] = '3'; }

	?>
	<div class="uebns_settings_box uebns_sidebar">
		<div class="member_head_title">
			<?php /* translators: General settings */ _e('General', 'plg-ueber-uns') ?>
		</div>
		<!-- Layout Settings -->
		<div class="layout_settings">
			<div class="member_field_title">
					<?php _e('Layout', 'plg-ueber-uns' ) ?>
			</div>
			<div class="layout_out">
				<fielset>
					<label class="uebns-setting-checkbox"><input type="radio" name="uebns_layout" value="default" checked="checked"><img src="<?php echo plugins_url('../assets/img/settings_theme_default.png', __FILE__); ?>"> </label>
					<label class="uebns-setting-checkbox"><input type="radio" name="uebns_layout" value="layout1"><img src="<?php echo plugins_url('../assets/img/settings_theme_layout_1.png', __FILE__); ?>"> </label>
					<label class="uebns-setting-checkbox"><input type="radio" name="uebns_layout" value="layout2"><img src="<?php echo plugins_url('../assets/img/settings_theme_layout_2.png', __FILE__); ?>"> </label>	
				</fielset>
			</div>
		</div>
	</div>
<?php } ?>