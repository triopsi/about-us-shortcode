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

/* Shortcode on the Page */
add_shortcode("uebns", "uebns_sh");

//Show the Shortcode in the post/site/content
function uebns_sh($atts) {

  //Data of the current Post
  global $post;

  // Gets table slug (post name)
  $all_attr = shortcode_atts( array( "name" => '' ), $atts );

  //Name of the Team
  $name = $all_attr['name'];

  //Gets the team
  $args = array('post_type' => 'uebns', 'name' => $name);

  // Get Posts
  $custom_posts = get_posts($args);
  
  //Empty team Sring
  $team_view = '';

  //SocialIcons
  $social_links_icons = getIconStyle();

  foreach($custom_posts as $post) : setup_postdata($post);
      //Load Members
      $members = get_post_meta( get_the_id(), '_uebns_members', true );

      //Load Settings
      $settings_layout = get_post_meta( get_the_id(), '_uebns_layout', true );
      $settings_photo_setting = get_post_meta( get_the_id(), '_uebns_photo_setting', true );

      //Style
      $main_color = get_option( 'uebns_setting_main_color' , '#eb5466');
      $hover_color = get_option( 'uebns_setting_main_color_hover' , '#212952');

      $settings_line_member = get_post_meta( get_the_id(), '_uebns_line_member', true );
      $setting_image_filter = get_post_meta( get_the_id(), '_uebns_filter_image', true );
      $setting_images_clickable = get_post_meta( get_the_id(), '_uebns_images_clickable', true );
      $style_class_line_members = getRowStyleCount($settings_line_member);
      $style_image_filter = getImageFilterStyle($setting_image_filter);
      ob_start();
      ?>
      <style>
          .uebns-link a:link,
          .uebns-link a{
              background-color:<?php echo $main_color; ?>;
          }
          .uebns-link a:hover {
              background-color:<?php echo $hover_color; ?>;
          }
          .uebns-hr{
            background: <?php echo $main_color; ?>;
          }
    </style>
    <?php
      $o = ob_get_clean();
      if ( is_array($members) || is_object($members) || !empty($settings_layout) ) {
        $i=0;
        $memberscount=count($members);
        $team_view.='<div class="uebns-team">';
        if($settings_layout === "default"){
          foreach ($members as $key => $member) {
            //if member disabeld, then next
            if($member['_uebns_member_en'] === 'n'){break;}
            if ( $memberscount != $i && $i != 0 && ( $i % $style_class_line_members['mt'] ) == 0){ 
              $team_view.= '</div><!-- ./uebns-team -->
              <div class="uebns-team">' ;
            }
            $team_view.='<!-- default -->
              <div class="uebns-main uebns-row uebns-row'.$style_class_line_members['style'].'">
                <div class="uebns-content">
                  <div class="uebns-col uebns-profile-image">
                  ' . uebns_get_image_html( $member, $setting_images_clickable, $style_image_filter, $settings_photo_setting ) . '
                  </div>
                  <div class="uebns-col uebns-txt">
                    <div class="uebns-des-text">
                      <div class="uebns-header"><h2 class="">'.$member['_uebns_firstname'].' '.$member['_uebns_lastname'].'</h2></div><!-- /.uebns-header -->
                      ' . ( !empty( $member['_uebns_job'] ) ? '<div class="uebns-sub-header">' . $member['_uebns_job'].  '</div><!-- /.uebns-sub-header -->' : '' ) . '
                      <hr class="uebns-hr">
                      <div class="uebns-description-bio">' . (!empty($member['_uebns_desc']) ? $member['_uebns_desc'] : '' ) . '</div><!-- /.uebns-description-bio -->';
                          $team_view.=getSocialMedia($member,$settings_photo_setting);
                          $team_view.='
                    </div><!-- /.uebns-des-text -->
                  </div><!-- /.uebns-col -->
                </div><!-- /.uebns-content -->
              </div><!-- /.uebns-main uebns-row -->';
              $i++;
          }


        }elseif ($settings_layout === "layout1"){
          foreach ($members as $key => $member) {
            //if member disabeld, then next
            if($member['_uebns_member_en'] === 'n'){break;}
            if ( $memberscount != $i && $i != 0 && ( $i % $style_class_line_members['mt'] ) == 0){ 
              $team_view.= '</div><!-- ./uebns-team -->
              <div class="uebns-team">' ;
            }
            $team_view.='<!-- layout1 -->
              <div class="uebns-main uebns-row uebns-row'.$style_class_line_members['style'].'">
                <div class="uebns-content">
                  <div class="uebns-profile-image uebns-center">
                  ' . uebns_get_image_html( $member, $setting_images_clickable, $style_image_filter, $settings_photo_setting ) . '
                  </div>
                  <div class="uebns-txt uebns-center">
                    <div class="uebns-des-text">
                      <div class="uebns-header"><h2 class="">'.$member['_uebns_firstname'].' '.$member['_uebns_lastname'].'</h2></div><!-- /.uebns-header -->
                      ' . ( !empty( $member['_uebns_job'] ) ? '<div class="uebns-sub-header">' . $member['_uebns_job'].  '</div><!-- /.uebns-sub-header -->' : '' ) . '
                      <hr class="uebns-hr uebns-hr-full">
                      <div class="uebns-description-bio">' . (!empty($member['_uebns_desc']) ? $member['_uebns_desc'] : '' ) . '</div><!-- /.uebns-description-bio -->';
                          $team_view.=getSocialMedia($member,$settings_photo_setting);
                          $team_view.='
                    </div><!-- /.uebns-des-text -->
                  </div><!-- /.uebns-txt -->
                </div><!-- /.uebns-content -->
              </div><!-- /.uebns-main uebns-row -->';
              $i++;
          }

        }elseif ($settings_layout === "layout2"){
          foreach ($members as $key => $member) {
            //if member disabeld, then next
            if($member['_uebns_member_en'] === 'n'){break;}
            if ( $memberscount != $i && $i != 0 && ( $i % $style_class_line_members['mt'] ) == 0){ 
              $team_view.= '</div><!-- ./uebns-team -->
              <div class="uebns-team">' ;
            }
            $team_view.='<!-- default -->
              <div class="uebns-main uebns-row uebns-row'.$style_class_line_members['style'].'">
                <div class="uebns-content">
                  <div class="uebns-col uebns-txt">
                    <div class="uebns-des-text">
                      <div class="uebns-header"><h2 class="">'.$member['_uebns_firstname'].' '.$member['_uebns_lastname'].'</h2></div><!-- /.uebns-header -->
                      ' . ( !empty( $member['_uebns_job'] ) ? '<div class="uebns-sub-header">' . $member['_uebns_job'].  '</div><!-- /.uebns-sub-header -->' : '' ) . '
                      <hr class="uebns-hr">
                      <div class="uebns-description-bio">' . (!empty($member['_uebns_desc']) ? $member['_uebns_desc'] : '' ) . '</div><!-- /.uebns-description-bio -->';
                          $team_view.=getSocialMedia($member,$settings_photo_setting);
                          $team_view.='
                    </div><!-- /.uebns-des-text -->
                  </div><!-- /.uebns-col -->
                  <div class="uebns-col uebns-profile-image">
                  ' . uebns_get_image_html( $member, $setting_images_clickable, $style_image_filter, $settings_photo_setting ) . '
                  </div>
                </div><!-- /.uebns-content -->
              </div><!-- /.uebns-main uebns-row -->';
              $i++;
          }
        }
        $team_view.='</div><!-- /.uebns-team -->';
      }
  endforeach; wp_reset_postdata();

  return $o.$team_view;

}