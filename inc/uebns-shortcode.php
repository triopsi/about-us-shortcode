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

  foreach($custom_posts as $post) : setup_postdata($post);
      $members = get_post_meta( get_the_id(), '_uebns_members', true );
      if (is_array($members) || is_object($members)) {
            foreach ($members as $key => $member) {
              $team_view.="Namen: <strong>" . $member['_uebns_firstname']."</strong></br>";
              $team_view.="Nachnamen: <strong>" . $member['_uebns_lastname']."</strong></br>";
              $team_view.="Rolle: <strong>" . $member['_uebns_job']."</strong></br>";
              $team_view.="<img style=\"width:175px;height:100%;\" src=\"".$member['_uebns_photo']."\"></br>";
                    /* Displays social links. */
                    for ($i = 1; $i <= 3; $i++) {
                      if ($member['_uebns_sc_type'.$i] != 'nada') {
                        if ($member['_uebns_sc_type'.$i] == 'email') {
                          $team_view .= '<a class="tmm_sociallink" href="'.(!empty($member['_uebns_sc_url'.$i])?$member['_uebns_sc_url'.$i]:'').'" title="'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'">'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'</a>';
                        } else {
                          $team_view .= '<a target="_blank" class="tmm_sociallink" href="'.(!empty($member['_uebns_sc_url'.$i])?$member['_uebns_sc_url'.$i]:'').'" title="'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'">'.(!empty($member['_uebns_sc_title'.$i])?$member['_uebns_sc_title'.$i]:'').'</a>';
                        }
                      }
                    }
            }
      }
  endforeach; wp_reset_postdata();
//https://hootproof.de/ueber-uns/
  $team_view.='
  <div class="uebns-team">
    <div class="uebns-main uebns-row">
      <div class="uebns-content">
        <div class="uebns-col">
          <div class="uebns-profile-images"><img src="" alt=""></div>
        </div>
        <div class="uebns-col">
          <div class="uebns-des-text">
            <div class="uebns-header"><h2 class=""></h2></div><!-- /.uebns-header -->
            <div class="uebns-sub-header"><p></p></div><!-- /.uebns-sub-header -->
            <div class="uebns-description-bio"></div><!-- /.uebns-description-bio -->
            <div class="uebns-social-link">
              <ul id="uebns-social-link-menu" class="uebns-social-menu">
                <li class="uebns-link"><a href="https://www.yelp.com"><span class="screen-reader-text">Yelp</span><i class="fab fa-yelp"></i></a></li>
                <li class="uebns-link"><a href="https://www.facebook.com/wordpress"><span class="screen-reader-text">Facebook</span><i class="fab fa-facebook-f"></i></a></li>
                <li class="uebns-link"><a href="https://twitter.com/wordpress"><span class="screen-reader-text">Twitter</span><i class="fab fa-twitter"></i></a></li>
                <li class="uebns-link"><a href="https://www.instagram.com/explore/tags/wordcamp/"><span class="screen-reader-text">Instagram</span><i class="fab fa-instagram"></i></a></li>
                <li class="uebns-link"><a href="mailto:wordpress@example.com"><span class="screen-reader-text">E-Mail</span><i class="far fa-envelope"></i></a></li>
              </ul>
            </div><!-- /.uebns-social-link -->
          </div><!-- /.uebns-des-text -->
        </div><!-- /.uebns-col -->
      </div><!-- /.uebns-content -->
    </div><!-- /.uebns-main uebns-row -->
  </div><!-- /.uebns-team -->';



  return $team_view;
}

?>