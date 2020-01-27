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

/**
 * Init setting setup
 *
 * @return void
 */
function uebns_settings_init()
{
    // register new settings
    register_setting( 'uebns', 'uebns_settings_social' );
    register_setting( 'uebns', 'uebns_settings_cdn_awesome' );
 
    // Social Media CND
    add_settings_section(
        'uebns_settings_section_font_cdn',
        __('Font Awesome CDN','aus'),
        'uebns_settings_cdn_section_cb',
        'uebns'
    );

    // Social Media Icons
    add_settings_section(
        'uebns_settings_section',
        __('Social Media Style','aus'),
        'uebns_settings_section_cb',
        'uebns'
    );

    //Social Media Style CDN Field
    add_settings_field(
        'uebns_settings_cdn_awesome',
        __('Use Font Awesome CDN?','aus'),
        'uebns_settings_field_cdn_cb',
        'uebns',
        'uebns_settings_section_font_cdn'
    );
 
    //Social Media Icons Fields
    $getIconArrayList = getIconArrayList();
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
 * section CDN Description
 */
function uebns_settings_cdn_section_cb()
{
    echo __('Want to use the CDN for Font Awesome Icons?','aus');
}

/**
 * section Style Description
 */
function uebns_settings_section_cb()
{
    printf(
        __('Team Settings Section. Here you can edit the Social Media Icons styles for the front/content. By default the plugin used and needed the font awesome icon libary(%s).','aus'),
        '<a target="_blank" href="https://fontawesome.com/">more infos</a>'
    );
}
 
/**
 * Social Media CDN
 *
 * @param array $args
 * @return void
 */
function uebns_settings_field_cdn_cb( array $args ){
    $old_setting_value = ( !empty( get_option( 'uebns_settings_cdn_awesome' ) ) ? get_option( 'uebns_settings_cdn_awesome' ) : 'yes');
    ?>
    <fieldset>
        <input type="radio" id="field_cdn_yes" class="uebns-field-setting-cdn" name="uebns_settings_cdn_awesome" value="yes" <?php echo ($old_setting_value === 'yes' ? 'checked' : '' ); ?>>
        <label for="field_cdn_yes"> <?php echo __('yes','aus'); ?></label> 
        <input type="radio" id="field_cdn_no" class="uebns-field-setting-cdn" name="uebns_settings_cdn_awesome" value="no" <?php echo ($old_setting_value === 'no' ? 'checked' : '' ); ?>>
        <label for="field_cdn_no"> <?php echo __('no','aus'); ?></label> 
    </fielset>
    
    <?php
}

/**
 * Social Media
 *
 * @param array $args
 * @return void
 */
function uebns_settings_field_cb( array $args ){
    $label_for   = $args['label_for'];
    $type     = $args['type'];
    $old_setting_value = get_option( 'uebns_settings_social' );
    ?>
    <input type="text" class="ubens-field-setting-style" name="uebns_settings_social[<?php echo $label_for; ?>]" value="<?php echo isset( $old_setting_value ) && !empty($old_setting_value) && is_array($old_setting_value) ? esc_attr( $old_setting_value[$label_for] ) : $type; ?>">
    <?php
}

/**
 * top level menu
 */
function uebns_option_menue(){

    add_options_page( 
        __('Team options','aus'), 
        __('Team options','aus'),
        'manage_options',
        'uebns',
        'uebns_options_page_html'
    );
}

/**
* register our uebns_options_page to the admin_menu action hook
*/
add_action( 'admin_menu', 'uebns_option_menue' );

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
        <?php if(WP_DEBUG){ ?>
            <div class="debug-info">
                <h3>Debug information</h3>
                <p>You are seeing this because your WP_DEBUG variable is set to true.</p>
                <pre><?php print_r(get_option( 'uebns_settings_social' )) ?></pre>
                <pre><?php print_r(get_option( 'uebns_settings_cdn_awesome' )) ?></pre>
            </div><!-- /.debug-info -->
        <?php } ?>
    </div>
    <?php
}