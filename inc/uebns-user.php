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

/* Add CSS Class to the front */
add_action( 'wp_enqueue_scripts', 'add_uebns_front_css', 99 );
function add_uebns_front_css() {
  wp_enqueue_style( 'uebns', plugins_url('../assets/css/front-style.css', __FILE__));
}

/* Get option - Style Font Awesome */
$option_cdn = ( empty( get_option( 'uebns_settings_cdn_awesome') ) ? 'yes' : get_option('uebns_settings_cdn_awesome') );
if( 'yes' === $option_cdn ){
    add_action( 'wp_enqueue_scripts', 'add_cdn_font_awesome', 99 );
}

/**
 * CDN Function FOnt Awesome include
 */
function add_cdn_font_awesome() {
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css', __FILE__);
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
            'docker.com'      => 'fab fa-docker',
            'dribbble.com'    => 'fab fa-dribbble',
            'dropbox.com'     => 'fab fa-dropbox',
            'facebook.com'    => 'fab fa-facebook',
            'flickr.com'      => 'fab fa-flickr',
            'foursquare.com'  => 'fab fa-foursquare',
            'plus.google.com' => 'fab fa-google-plus-square',
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
            '- Another link -'=> 'fas fa-link',
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
 * RowStyle and math variable function
 *
 * @param [type] $style_class_line_members
 * @return void
 */
function getRowStyleCount($settings_line_member){
    $retunrData = array();
    switch ($settings_line_member) {
        case 1:
            $retunrData['style']='1';
            $retunrData['mt']='1';
            break;
        case 2:
            $retunrData['style']='50';
            $retunrData['mt']='2';
            break;
        case 3:
            $retunrData['style']='33';
            $retunrData['mt']='3';
            break;
        case 4:
            $retunrData['style']='25';
            $retunrData['mt']='4';
            break;
        case 5:
            $retunrData['style']='20';
            $retunrData['mt']='5';
            break;
        default:
            $retunrData['style']='1';
            $retunrData['mt']='1';
      }
    return $retunrData;
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
    $icon_array = getIconStyle();
    $icon_class = $icon_array['- Another link -'];

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
  
/**
 * Show the Icon bar
 *
 * @param [type] $member
 * @param [type] $settings_photo_setting
 * @return void
 */
function getSocialMedia($member,$settings_photo_setting){
    if(empty($member['_uebns_sc'])){return '';}
    $member_sc_data = explode('||', $member['_uebns_sc']);
    $i=0;
    $team_view = '<div class="uebns-social-link">'; 
    $team_view.= '<ul id="uebns-social-link-menu" class="uebns-social-menu">';  
    foreach ($member_sc_data as $member_sc_line){
        if(empty($member_sc_line)){break;}
        $member_sc_line_data = explode('###', $member_sc_line);
        $member_social_media_kanal = $member_sc_line_data[0];
        $member_social_link_titel = $member_sc_line_data[1];
        $uebns_field_link_url = $member_sc_line_data[2];
        // var_dump($uebns_field_link_url);
        $team_view.='<li class="uebns-link">
        <a class="' . ($settings_photo_setting === 'round' ? 'uebns-round-link' : '' ) . '" title="'.(!empty($member_social_link_titel)?$member_social_link_titel:'').'" href="'.(!empty($uebns_field_link_url)?$uebns_field_link_url:'').'">
        <span class="screen-reader-text">'.(!empty($member_social_link_titel)?$member_social_link_titel:'').'</span>
        <i class="'.uebns_get_icon_social(getIconStyle(),$uebns_field_link_url).'"></i>
        </a>
        </li>';
    }  
    $team_view.= '</ul>';   
    $team_view.= '</div><!-- /.uebns-social-link -->';     
    return $team_view;
}