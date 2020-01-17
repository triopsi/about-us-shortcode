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
**/

/* Defines plugin's root folder. */
define( 'PLG_PATH', plugin_dir_path( __FILE__ ) );

/* General */
/* Loads plugin's text domain. */
add_action( 'plugins_loaded', 'uebns_load_plugin_textdomain' );

/* Admin */
require_once('inc/uebns-admin.php');
require_once('inc/uebns-metaboxes-settings-teams.php'); //Team meta
require_once('inc/uebns-metaboxes-teams-content.php'); //Team meta

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



/* Add CSS Class to the front */
add_action( 'wp_enqueue_scripts', 'add_uebns_front_css', 99 );
function add_uebns_front_css() {
  wp_enqueue_style( 'uebns', plugins_url('assets/css/front-style.css', __FILE__));
}


/**
 * Init Script. Load languages
 *
 * @return void
 */
function uebns_load_plugin_textdomain() {
  load_plugin_textdomain( 'plg-ueber-uns', FALSE, PLG_PATH . 'lang/' );
}
