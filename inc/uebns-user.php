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

/* Add CSS Class to the front */
add_action( 'wp_enqueue_scripts', 'add_uebns_front_css', 99 );
function add_uebns_front_css() {
  wp_enqueue_style( 'uebns', plugins_url('../assets/css/front-style.css', __FILE__));
}

/**
 * default IconArray
 *
 * @return void
 */
function getIconArrayList(){
        $social_links_icons = array(
            'behance.net'     => 'fab fa-behance',
            'codepen.io'      => 'fab fa-codepen',
            'deviantart.com'  => 'fab fa-deviantart',
            'digg.com'        => 'fab fa-digg',
            'docker.com'      => 'fab fa-dockerhub',
            'dribbble.com'    => 'fab fa-dribbble',
            'dropbox.com'     => 'fab fa-dropbox',
            'facebook.com'    => 'fab fa-facebook',
            'flickr.com'      => 'fab fa-flickr',
            'foursquare.com'  => 'fab fa-foursquare',
            'plus.google.com' => 'fab fa-google-plus',
            'github.com'      => 'fab fa-github',
            'instagram.com'   => 'fab fa-instagram',
            'linkedin.com'    => 'fab fa-linkedin',
            'mailto:'         => 'fas fa-envelope',
            'medium.com'      => 'fab fa-medium',
            'pinterest.com'   => 'fab fa-pinterest-p',
            'pscp.tv'         => 'fab fa-periscope',
            'getpocket.com'   => 'fab fa-get-pocket',
            'reddit.com'      => 'fab fa-reddit-alien',
            'skype.com'       => 'fab fa-skype',
            'skype:'          => 'fab fa-skype',
            'slideshare.net'  => 'fab fa-slideshare',
            'snapchat.com'    => 'fab fa-snapchat-ghost',
            'soundcloud.com'  => 'fab fa-soundcloud',
            'spotify.com'     => 'fab fa-spotify',
            'stumbleupon.com' => 'fab fa-stumbleupon',
            'tumblr.com'      => 'fab fa-tumblr',
            'twitch.tv'       => 'fab fa-twitch',
            'twitter.com'     => 'fab fa-twitter',
            'vimeo.com'       => 'fab fa-vimeo',
            'vine.co'         => 'fab fa-vine',
            'vk.com'          => 'fab fa-vk',
            'wordpress.org'   => 'fab fa-wordpress',
            'wordpress.com'   => 'fab fa-wordpress',
            'yelp.com'        => 'fab fa-yelp',
            'youtube.com'     => 'fab fa-youtube',
        );
    return $social_links_icons;
}

/**
 * Front Style Icons
 *
 * @return void
 */
function getIconStyle(){
    //Load settings
    $uebns_settings_social = get_option('uebns_settings_social');
    if( isset( $uebns_settings_social ) && !empty( $uebns_settings_social ) && is_array( $uebns_settings_social ) ){
        $socialmediaiconstyle=$uebns_settings_social;
    }else{
        $socialmediaiconstyle=getIconArrayList();
    }
    return $socialmediaiconstyle;
}

/**
 * RowStyle function
 *
 * @param [type] $style_class_line_members
 * @return void
 */
function getRowStyleCount($settings_line_member){
    switch ($settings_line_member) {
        case 1:
            $style_class_line_members='1';
            break;
        case 2:
            $style_class_line_members='50';
            break;
        case 3:
            $style_class_line_members='33';
            break;
        case 4:
            $style_class_line_members='25';
            break;
        case 5:
            $style_class_line_members='20';
            break;
        default:
            $style_class_line_members='1';
      }
    return $style_class_line_members;
}

/**
 * Imagefilter function
 *
 * @param [type] $setting_image_filter
 * @return void
 */
function getImageFilterStyle($setting_image_filter){
    switch ($setting_image_filter) {
        case 'grayscale':
            $style_image_filter='-webkit-filter: grayscale(1);filter: grayscale(1);';
            break;
        case 'sepia':
            $style_image_filter='-webkit-filter: sepia(1);filter: sepia(1);';
            break;
        default:
        $style_image_filter='';
    }
    return $style_image_filter;
}

/**
 * GetIcons from the url function
 *
 * @param [type] $social_icons
 * @param [type] $url
 * @return void
 */
function uebns_get_icon_social( $social_icons, $url ){
    //default
    $icon_class = "fas fa-link";
    foreach ( $social_icons as $attr => $value ) {
      if ( false !== strpos( $url, $attr ) ) {
        $icon_class = $value;
      }
    }
    return $icon_class;
  }
  
/**
* HTML image function
*
* @param [type] $member
* @param [type] $setting_images_clickable
* @param [type] $style_image_filter
* @param [type] $settings_photo_setting
* @return void
*/
function uebns_get_image_html( $member, $setting_images_clickable, $style_image_filter, $settings_photo_setting ){
    if( !isset($member['_uebns_photo']) || empty($member['_uebns_photo']) ){
        $htmlout='';
    }else{
        $htmlout='<div class="uebns-profile-images">' . ( $setting_images_clickable === "yes" &&  !empty($member['_uebns_photo_url'] ) ? '<a href="'.$member['_uebns_photo_url'].'">':'') . '<img style="' . $style_image_filter . '" class="uebns-photo-member ' . ( $settings_photo_setting === 'round' ? 'uebns-round' : '' ) . '" src="'.$member['_uebns_photo'].'" alt="">' . ($setting_images_clickable === "yes" ? '</a>':'') . '</div>';
    }
    return $htmlout;
}
  