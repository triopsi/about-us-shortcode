<?php 

/* Hooks the metabox. */
add_action('admin_init', 'uebns_add_shortcode_panel', 1);
function uebns_add_shortcode_panel() {
	add_meta_box( 
		'uebns_shortcode', 
		'<span class="dashicons dashicons-admin-links"></span> '.__('Shortcode', 'plg-ueber-uns'), 
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
			<?php _e('Shortcode', 'plg-ueber-uns') ?>
		</div>
		<!-- Layout Settings -->
		<div class="layout_settings">
			<div class="member_field_title">
					<?php _e('Shortcode', 'plg-ueber-uns' ) ?>
			</div>
			<div class="layout_out">
				<?php 
					global $post;
					$slug = '';
					$slug = $post->post_name;
					$shortcode = '<input type="text" onfocus="this.select();" readonly="readonly" value="[uebns name=&quot;'.$slug.'&quot;]" class="large-text code">';
					$shortcode_unpublished = "<span style='display:inline-block;color:#e17055'>" . __("<strong>Publish</strong> your team before you can see you shortcode here!", 'plg-ueber-uns' ) . "</span>";
					echo ($slug != '') ? $shortcode : $shortcode_unpublished;
				?>
				<p>
					<?php _e('To display your team members on your site, copy-paste the <strong>[uebns-shortcode]</strong> above in your post/page.', 'plg-ueber-uns' ) ?>
				</p>
			</div>
		</div>
	</div>
<?php } ?>