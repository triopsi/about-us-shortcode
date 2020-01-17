<?php 

/* Shortcode on the Page */
add_shortcode("uebns", "uebns_sh");

//Function for the Shortcode
function uebns_sh($atts) {

  //Global Variable for the Post. Data of the current Post
  global $post;

  /* Gets table slug (post name). */
  $all_attr = shortcode_atts( array( "name" => '' ), $atts );

  //Name of the Team
  $name = $all_attr['name'];

  /* Gets the team. */
  $args = array('post_type' => 'uebns', 'name' => $name);

  // Get Posts
  $custom_posts = get_posts($args);
  
  //Empty team Sring
  $team_view = '';

  //Social
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
		'mailto:'         => 'far fa-envelope',
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

  foreach($custom_posts as $post) : setup_postdata($post);
      $members = get_post_meta( get_the_id(), '_uebns_members', true );
      $settings_layout = get_post_meta( get_the_id(), '_uebns_layout', true );
      $settings_photo_setting = get_post_meta( get_the_id(), '_uebns_photo_setting', true );
      $settings_color_shema = get_post_meta( get_the_id(), '_uebns_color_shema', true );
      $settings_line_member = get_post_meta( get_the_id(), '_uebns_line_member', true );

      
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

      if ( is_array($members) || is_object($members) || !empty($settings_layout) ) {
        $team_view.='<div class="uebns-team">';
        if($settings_layout === "default"){
          
          foreach ($members as $key => $member) {
            $team_view.='
              <div class="uebns-main uebns-row uebns-row'.$style_class_line_members.'">
                <div class="uebns-content">
                  <div class="uebns-col uebns-profile-image">
                    <div class="uebns-profile-images"><img class="uebns-photo-member ' . ( $settings_photo_setting === 'round' ? 'uebns-round' : '' ) . '" src="'.$member['_uebns_photo'].'" alt=""></div>
                  </div>
                  <div class="uebns-col uebns-txt">
                    <div class="uebns-des-text">
                      <div class="uebns-header"><h2 class="">'.$member['_uebns_firstname'].' '.$member['_uebns_lastname'].'</h2></div><!-- /.uebns-header -->
                      ' . ( !empty( $member['_uebns_job'] ) ? '<div class="uebns-sub-header">' . $member['_uebns_job'].  '</div><!-- /.uebns-sub-header -->' : '' ) . '
                      <hr class="uebns-hr" style="background:' . (!empty($settings_color_shema)? $settings_color_shema : '' ) . ';">
                      <div class="uebns-description-bio">'.$member['_uebns_desc'].'</div><!-- /.uebns-description-bio -->
                        <div class="uebns-social-link">
                          <ul id="uebns-social-link-menu" class="uebns-social-menu">';
                            /* Displays social links. */
                            for ($i = 1; $i <= 3; $i++) {
                              if ($member['_uebns_sc_type'.$i] != 'nada') {
                                $team_view.='<li class="uebns-link"><a style="background-color:' . (!empty($settings_color_shema)? $settings_color_shema : '' ) . ';" class="' . ($settings_photo_setting === 'round' ? 'uebns-round-link' : '' ) . '" title="'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'" href="'.(!empty($member['_uebns_sc_url'.$i])?$member['_uebns_sc_url'.$i]:'').'"><span class="screen-reader-text">'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'</span><i class="'.uebns_get_icon_social($social_links_icons,$member['_uebns_sc_url'.$i]).'"></i></a></li>';
                              }
                            }
                          $team_view.='
                        </ul>
                      </div><!-- /.uebns-social-link -->
                    </div><!-- /.uebns-des-text -->
                  </div><!-- /.uebns-col -->
                </div><!-- /.uebns-content -->
              </div><!-- /.uebns-main uebns-row -->';
          }


        }elseif ($settings_layout === "layout1"){
          foreach ($members as $key => $member) {
            $team_view.='
              <div class="uebns-main uebns-row uebns-row'.$style_class_line_members.'">
                <div class="uebns-content">
                  <div class="uebns-col uebns-profile-image">
                    <div class="uebns-profile-images"><img class="uebns-photo-member ' . ( $settings_photo_setting === 'round' ? 'uebns-round' : '' ) . '" src="'.$member['_uebns_photo'].'" alt=""></div>
                  </div>
                  <div class="uebns-col uebns-txt">
                    <div class="uebns-des-text">
                      <div class="uebns-header"><h2 class="">'.$member['_uebns_firstname'].' '.$member['_uebns_lastname'].'</h2></div><!-- /.uebns-header -->
                      ' . ( !empty( $member['_uebns_job'] ) ? '<div class="uebns-sub-header">' . $member['_uebns_job'].  '</div><!-- /.uebns-sub-header -->' : '' ) . '
                      <hr class="uebns-hr" style="background:' . (!empty($settings_color_shema)? $settings_color_shema : '' ) . ';">
                      <div class="uebns-description-bio">'.$member['_uebns_desc'].'</div><!-- /.uebns-description-bio -->
                        <div class="uebns-social-link">
                          <ul id="uebns-social-link-menu" class="uebns-social-menu">';
                            /* Displays social links. */
                            for ($i = 1; $i <= 3; $i++) {
                              if ($member['_uebns_sc_type'.$i] != 'nada') {
                                $team_view.='<li class="uebns-link"><a style="background-color:' . (!empty($settings_color_shema)? $settings_color_shema : '' ) . ';" class="' . ($settings_photo_setting === 'round' ? 'uebns-round-link' : '' ) . '" title="'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'" href="'.(!empty($member['_uebns_sc_url'.$i])?$member['_uebns_sc_url'.$i]:'').'"><span class="screen-reader-text">'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'</span><i class="'.uebns_get_icon_social($social_links_icons,$member['_uebns_sc_url'.$i]).'"></i></a></li>';
                              }
                            }
                          $team_view.='
                        </ul>
                      </div><!-- /.uebns-social-link -->
                    </div><!-- /.uebns-des-text -->
                  </div><!-- /.uebns-col -->
                </div><!-- /.uebns-content -->
              </div><!-- /.uebns-main uebns-row -->';
          }

        }elseif ($settings_layout === "layout2"){

        }
        $team_view.='</div><!-- /.uebns-team -->';
      }


      // if (is_array($members) || is_object($members)) {
      //       foreach ($members as $key => $member) {
      //         $team_view.="Namen: <strong>" . $member['_uebns_firstname']."</strong></br>";
      //         $team_view.="Nachnamen: <strong>" . $member['_uebns_lastname']."</strong></br>";
      //         $team_view.="Rolle: <strong>" . $member['_uebns_job']."</strong></br>";
      //         $team_view.="<img style=\"width:175px;height:100%;\" src=\"".$member['_uebns_photo']."\"></br>";
      //               /* Displays social links. */
      //               for ($i = 1; $i <= 3; $i++) {
      //                 if ($member['_uebns_sc_type'.$i] != 'nada') {
      //                   if ($member['_uebns_sc_type'.$i] == 'email') {
      //                     $team_view .= '<a class="tmm_sociallink" href="'.(!empty($member['_uebns_sc_url'.$i])?$member['_uebns_sc_url'.$i]:'').'" title="'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'">'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'</a>';
      //                   } else {
      //                     $team_view .= '<a target="_blank" class="tmm_sociallink" href="'.(!empty($member['_uebns_sc_url'.$i])?$member['_uebns_sc_url'.$i]:'').'" title="'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'">'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'</a>';
      //                   }
      //                 }
      //               }
      //       }
      // }
  endforeach; wp_reset_postdata();
//https://hootproof.de/ueber-uns/
  return $team_view;
}

function uebns_get_icon_social( $social_icons,$url ){
  $icon_class = "far fa-envelope";
  foreach ( $social_icons as $attr => $value ) {
    if ( false !== strpos( $url, $attr ) ) {
      $icon_class = $value;//str_replace( $args->link_after, '</span>' . bademanteltour_get_icon( array( 'icon' => esc_attr( $value ) ) ), $item_output );
    }
  }

  return $icon_class;
}

?>