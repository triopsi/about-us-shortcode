<?php
/**
* Plugin Name: About us Shortcode
* Plugin URI: https://www.wiki.profoxi.de
* Description: A very simple "About Us" site Plugin. Create Teams and copy-paste the shortcode everywhere in your post or site.
* Version: 0.1.1
* Author: triopsi
* Author URI: http://wiki.profoxi.de
* Text Domain: aus
* Domain Path: /lang/
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

//Definie plugin version
if (!defined('UEBNS_VERSION'))
    define('UEBNS_VERSION', '0.1.1');


/* General */
/* Loads plugin's text domain. */
add_action( 'init', 'uebns_load_plugin_textdomain' );

/* Admin */
require_once('inc/uebns-admin.php');
require_once('inc/uebns-settings.php');
require_once('inc/uebns-metaboxes-settings-teams.php'); //Team meta
require_once('inc/uebns-metaboxes-teams-content.php'); //Team meta

/* Front Scripts and Styles */
require_once('inc/uebns-user.php');

/* Columns */
require_once('inc/uebns-shortcode-column.php');
require_once('inc/uebns-shortcode.php');

/* Shortcode */
require_once('inc/uebns-shortcode.php');

/* Side Metaboxes */
require_once('inc/uebns-metaboxes-sidebar-settings.php');
require_once('inc/uebns-metaboxes-sidebar-shortcode.php');

/* Save the Team */
require_once('inc/uebns-save-metaboxes.php');

/**
 * Init Script. Load languages
 *
 * @return void
 */
function uebns_load_plugin_textdomain() {
  load_plugin_textdomain( 'aus', FALSE, 'about-us-shortcode/lang/' );
}
