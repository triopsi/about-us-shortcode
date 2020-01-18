<?php
/**
* Plugin Name: Über Uns
* Plugin URI: https://www.wiki.profoxi.de
* Description: Zeigt eine "Über Uns" Team Ansicht in einem Beitrag an.
* Version: 1.0
* Author: Daniel Rodriguez Baumann
* Author URI: http://wiki.profoxi.de
* Text Domain: plg-ueber-uns
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

/* Defines plugin's root folder. */
define( 'PLG_PATH', plugin_dir_path( __FILE__ ) );

//Plugin Version
if (!defined('UEBNS_VERSION'))
    define('UEBNS_VERSION', '1.0');


/* General */
/* Loads plugin's text domain. */
add_action( 'plugins_loaded', 'uebns_load_plugin_textdomain' );

/* Admin */
require_once('inc/uebns-admin.php');
require_once('inc/uebns-settings.php');
require_once('inc/uebns-metaboxes-settings-teams.php'); //Team meta
require_once('inc/uebns-metaboxes-teams-content.php'); //Team meta

/* Front Scripts and Styles */
require_once('inc/uebns-user.php');

/* columns */
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
  load_plugin_textdomain( 'plg-ueber-uns', FALSE, PLG_PATH . 'lang/' );
}
