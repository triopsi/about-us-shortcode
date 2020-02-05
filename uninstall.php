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

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
/* Delete plugin options */
$option_version = 'uebns_plugin_version';
$option_settings = 'uebns_settings_social';
$option_settings_cdn = 'uebns_settings_cdn_awesome';

delete_option($option_version);
delete_site_option($option_version);

delete_option($option_settings);
delete_site_option($option_settings);

delete_option($option_settings_cdn);
delete_site_option($option_settings_cdn);

delete_option("uebns_setting_main_color");
delete_site_option("uebns_setting_main_color");

delete_option("uebns_setting_main_color_hover");
delete_site_option("uebns_setting_main_color_hover");

// Delete metadata and posts
$post_type_arg = array('post_type' => 'uebns', 'posts_per_page' => -1);
$getpostsentries = get_posts($post_type_arg);
foreach ($getpostsentries as $post) {
	wp_delete_post($post->ID, true);
}

