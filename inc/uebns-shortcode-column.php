<?php 

/* Handles shortcode column display. */
add_action( 'manage_uebns_posts_custom_column' , 'uebns_custom_columns', 10, 2 );

function uebns_custom_columns( $column, $post_id ) {
  switch ( $column ) {
    case 'uebn_shortcode' :
      global $post;
      $slug = '' ;
      $slug = $post->post_name;
      $shortcode = '<span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="[uebns name=&quot;'.$slug.'&quot;]" class="large-text code"></span>';
      // $shortcode = '<span style="display:inline-block;border:solid 1px lightgray; background:white; padding:0 8px; font-size:13px; line-height:25px; vertical-align:middle;width:255px;">[uebns name="'.$slug.'"]</span>';
      echo $shortcode;
      break;
  }
}


/* Adds the shortcode column in admin. */
add_filter( 'manage_uebns_posts_columns' , 'add_uebns_columns' );

function add_uebns_columns( $columns ) {
  $columns['title'] = __('Team name','plg-ueber-uns');
  unset( $columns['author'] );
  unset( $columns['date'] );
  return array_merge( $columns, array('uebn_shortcode' => 'Shortcode') );
}

?>