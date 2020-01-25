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

/* Add the metabox */
add_action('admin_init', 'uebns_add_shortcode_panel', 1);
function uebns_add_shortcode_panel() {
	add_meta_box( 
		'uebns_shortcode', 
		'<span class="dashicons dashicons-admin-links"></span> '.__('Shortcode', 'aus'), 
		'uebns_shortcode_display', 
		'uebns', 
		'side', 
		'low'
	);
}

/* Displays the metabox */
function uebns_shortcode_display() { 
	?>
	<div class="uebns_settings_box uebns_sidebar">
		<div class="member_head_title">
			<?php _e('Shortcode', 'aus') ?>
		</div>
		<!-- Layout Settings -->
		<div class="layout_settings">
			<div class="member_field_title">
					<?php _e('Shortcode', 'aus' ) ?>
			</div>
			<div class="layout_out">
				<?php 
					global $post;
					$slug = '';
					$slug = $post->post_name;
					$shortcode = '<input type="text" onfocus="this.select();" readonly="readonly" value="[uebns name=&quot;'.$slug.'&quot;]" class="large-text code">';
					$shortcode_unpublished = "<span style='display:inline-block;color:#e17055'>" . __("<strong>Publish</strong> your team before you can see you shortcode here!", 'aus' ) . "</span>";
					echo ($slug != '') ? $shortcode : $shortcode_unpublished;
				?>
				<p>
					<?php _e('To display your team members on your site, copy-paste the <strong>[uebns-shortcode]</strong> above in your post/page.', 'aus' ) ?>
				</p>
			</div>
		</div>
	</div>
<?php 
}
