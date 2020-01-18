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

function uebns_settings_init()
{
    // register a new setting
    register_setting('uebns', 'uebns_settings_social');
 
    // register a new section in the "Uebns" page
    add_settings_section(
        'uebns_settings_section',
        __('Social Media Style','plg-ueber-uns'),
        'uebns_settings_section_cb',
        'uebns'
    );
 
    //Fields
    $getIconArrayList=getIconArrayList();
    foreach ( $getIconArrayList as $link_url => $value ) {
        $callback = 'uebns_settings_field_cb';
        $name_field = 'uebns_settings_social_'.$link_url;
        $args     = array (
            'label_for' => $link_url,
            'type'      => $value
        );
        add_settings_field(
            $name_field,
            $link_url,
            $callback,
            'uebns',
            'uebns_settings_section',
            $args
        );
    }
}
 
/**
 * register uebns_settings_init to the admin_init action hook
 */
add_action('admin_init', 'uebns_settings_init');
 
/**
 * section content cb functions
 */
function uebns_settings_section_cb()
{
    printf(
        __('Team Settings Section. Here you can edit the Social Media Icons styles for the front/content. By default the plugin used and need the font awesome icon libary(%s)','plg-ueber-uns'),
        '<a target="_blank" href="https://fontawesome.com/">more infos</a>'
    );
}
 
/**
 * field content cb
 *
 * @param array $args
 * @return void
 */
function uebns_settings_field_cb( array $args ){
    $label_for   = $args['label_for'];
    $type     = $args['type'];
    // get the value of the setting we've registered with register_setting()
    $old_setting_value = get_option('uebns_settings_social');
    // output the field
    ?>
    <input type="text" name="uebns_settings_social[<?php echo $label_for; ?>]" value="<?php echo isset( $old_setting_value ) && !empty($old_setting_value) && is_array($old_setting_value) ? esc_attr( $old_setting_value[$label_for] ) : $type; ?>">
    <?php
}


/**
 * top level menu
 */
function uebns_options_page() {
    // add top level menu page
    add_menu_page(
    'Team Settings',
    'Team Options',
    'manage_options',
    'uebns',
    'uebns_options_page_html'
    );
   }
    
/**
* register our uebns_options_page to the admin_menu action hook
*/
add_action( 'admin_menu', 'uebns_options_page' );

/**
 * top level menu:
 * callback functions
 */
function uebns_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
    return;
    }
    
    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'uebns_messages', 'uebns_message', __( 'Settings Saved', 'uebns' ), 'updated' );
    }
    
    // show error/update messages
    settings_errors( 'uebns_messages' );

    ?>

    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
            <?php
                // output security fields for the registered setting "uebns"
                settings_fields( 'uebns' );

                // output setting sections and their fields
                // (sections are registered for "uebns", each field is registered to a specific section)
                do_settings_sections( 'uebns' );

                // output save settings button
                submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}