<?php
function shortcodeFunction_get_remote_news( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '10',
    'class' => '',
    'post_type' => 'post',
    'posts_per_page' => '6',
    'random' => 'menu_order title',
	'paged' => true,
  ), $atts ) );
  $args = array(
    'posts_per_page' => $posts_per_page,
    'post_type' => $post_type,
    'cat' => $cat,
    'orderby' => $random,
    'order' => 'DESC',
  );
  $posts = get_posts($args);
  $return = '';
  //var_dump($posts);
  if ($class) {
    $return .= '<div class="'.$class.'">';
  }
  foreach($posts as $post){
    $thePost = get_post($post);
    $date = $thePost->post_date;
    $the_content = $thePost->post_content;
    $subline = get_post_meta( $thePost->ID, 'subline', true );
    //var_dump($thePost);
    // Char LimitIterator
    $char_limit = 200;
    $date = strtotime($date);
    $date = gmdate('jS F Y',$date);
    // $return .= '<div class="col-md-8" style="padding-left: 0;">';
    $return .= '<div class="row" style="padding-left: 0;">';
    $return .= '<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">';
    if (get_the_post_thumbnail( $thePost->ID )) {
      $return .= get_the_post_thumbnail( $thePost->ID, 'news-thumb', array( 'class' => 'img-responsive' ) );
    } else {
      $return .= '<img style="height: auto;" src="https://placeholdit.imgix.net/~text?txtsize=16&txt=noch+kein+Bild&w=247&h=274" class="img-responsive full-height">';
    }
    $return .= '</div>';
    $return .= '<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">';
    if ($subline) {
      // $return .= '<h5>'.$subline.'</h5>';
      $return .= '<h5>'.$thePost->post_short.'</h5>';
    }
    if (is_singular('post')) {
      $return .= '<h5>'.$thePost->post_short.'</h5>';
      $return .= '<h2 style="margin-bottom: 15px; margin-top: 20px;">'.$thePost->post_title.'</h2>';
    } else {
      $return .= '<h5>'.$thePost->post_short.'</h5>';
      $return .= '<h2 style="margin-bottom: 15px; margin-top: 20px;">'.$thePost->post_title.'</h2>';
    }
    $return .= '<p style="margin-bottom: 15px;">'.strip_tags(substr($the_content,0,$char_limit)).' ...</p>';
    $return .= '<a href="'.get_the_permalink($thePost->ID).'" class="btn btn-default red">Weiterlesen</a>';
    //$return .= '</div>';
    // $return .= '</div>';
    $return .= '</div>';
    $return .= '</div>';
    $return .= '<hr class="between_line">';
  }
  if ($class) {
    $return .= '</div>';
  }
  wp_reset_postdata();
  return $return;
}
add_shortcode( 'get_remote_news', 'shortcodeFunction_get_remote_news' );
function shortcodeFunction_get_remote_news_2( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '10',
    'class' => '',
    'post_type' => 'post',
    'posts_per_page' => '-1',
    'random' => 'menu_order title',
	'paged' => true,
  ), $atts ) );
  $currentPage = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
  $args = array(
    'posts_per_page' => 5,
    'category_name' => 'news',
    'paged' => $currentPage
  );
  // $posts = get_posts($args);
  $query = new WP_Query($args);
  $return = '';
  if ($query->have_posts()):
    foreach($query->posts as $post){
      $thePost = get_post($post);
      $char_limit = 200;
      $return .= '<div class="row" style="padding-left: 0;">';
      $return .= '<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">';
      $return .= get_the_post_thumbnail($thePost->{'ID'});
      $return .= '</div>';
      $return .= '<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 post_content">';
      if (is_singular('post')) {
        $return .= '<h2 style="margin-bottom: 15px; margin-top: 20px;">'. $thePost->{"post_title"} .'</h2>';
      } else {
        $return .= '<h2 style="margin-bottom: 15px; margin-top: 20px;">'. $thePost->{"post_title"} .'</h2>';
      }
      $return .= '<p style="margin-bottom: 15px;">'. substr($thePost->{"post_content"},0,$char_limit) .' ...</p>';
      $return .= '<a href="'. get_permalink($thePost->ID) . '" class="btn btn-default red">Weiterlesen</a>';
      $return .= '</div>';
      $return .= '</div>';
      $return .= '<hr class="between_line">';
    }
endif;
    // $total_pages = $args->max_num_pages;
    $return .= '<div class="row">';
    $return .= '<div id="pagination" class="col-md-12">';
    $pages =  paginate_links(array(
        'base' => get_pagenum_link(1) . '%_%',
        'format' => '/page/%#%',
        'current' => $currentPage,
        'total' => $query->max_num_pages,
        'prev_text'    => __('<'),
        'next_text'    => __('>'),
    ));
    $return .= $pages;
    $return .= '</div>';
    $return .= '</div>';
  wp_reset_postdata();
  return $return;
}
add_shortcode( 'get_remote_news_2', 'shortcodeFunction_get_remote_news_2' );
function shortcodeFunction_get_post( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '10',
    'class' => '',
    'post_type' => 'post',
    'posts_per_page' => '6',
    'random' => 'menu_order title',
  ), $atts ) );
  $args = array(
    'posts_per_page' => $posts_per_page,
    'post_type' => $post_type,
    'cat' => $cat,
    'orderby' => $random,
    'order' => 'DESC',
  );
  $posts = get_posts($args);
  $return = '';
  //var_dump($posts);
  if ($class) {
    $return .= '<div class="'.$class.'">';
  }
  foreach($posts as $post){
    $thePost = get_post($post);
    $date = $thePost->post_date;
    $the_content = $thePost->post_content;
    $subline = get_post_meta( $thePost->ID, 'subline', true );
    //var_dump($thePost);
    // Char LimitIterator
    $char_limit = 150;
    $date = strtotime($date);
    $date = gmdate('jS F Y',$date);
    $return .= '<div class="col-md-12 single-news" style="padding-left: 0;">';
    $return .= '<div class="row">';
    $return .= '<div class="col-xl-6 col-lg-7 col-md-12 col-sm-12">';
    if (get_the_post_thumbnail( $thePost->ID )) {
      $return .= get_the_post_thumbnail( $thePost->ID, 'full', array( 'class' => 'img-responsive news_image' ) );
    } else {
      $return .= '<img class="img-responsive" src="https://placeholdit.imgix.net/~text?txtsize=16&txt=noch+kein+Bild&w=247&h=274">';
    }
    $return .= '</div>';
    $return .= '<div class="col-xl-6 col-lg-5 col-md-12 col-sm-12">';
    $return .= '<div class="text">';
    if ($subline) {
      $return .= '<h5>'.$subline.'</h5>';
    }
    if (is_singular('post')) {
      $return .= '<h2 style="margin-bottom: 15px; margin-top: 20px;">'.$thePost->post_title.'</h2>';
    } else {
      $return .= '<h2 style="margin-bottom: 15px; margin-top: 20px;">'.$thePost->post_title.'</h2>';
    }
    $return .= '<p>'.strip_tags(substr($the_content,0,$char_limit)).' ...</p>';
    $return .= '<a href="'.get_the_permalink($thePost->ID).'" class="btn btn-default red">Weiterlesen</a>';
    //$return .= '<hr class="between_line">';
    //$return .= '</div>';
    $return .= '</div>';
    $return .= '</div>';
    $return .= '</div>';
    $return .= '</div>';
  }
  if ($class) {
    $return .= '</div>';
  }
  wp_reset_postdata();
  return $return;
}
add_shortcode( 'get_news_posts', 'shortcodeFunction_get_post' );
function shortcodeFunction_get_stories( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '8',
    'class' => '',
    'post_type' => 'post',
    'posts_per_page' => '6',
    'random' => 'menu_order title',
  ), $atts ) );
  $currentPage = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
  $args = array(
    'posts_per_page' => 4,
    'category_name' => 'stories',
    'paged' => $currentPage
  );
  // $args = array(
  //   'posts_per_page' => 4,
  //   'post_type' => 'post',
  //   'cat' => $cat,
  //   'orderby' => $random,
  //   'order' => 'DESC',
  // );
  // $posts = get_posts($args);
  $query = new WP_Query($args);
  $return = '';
  if ($query->have_posts()) {
    foreach($query->posts as $post) {
      $thePost = get_post($post);
      $date = $thePost->post_date;
      $the_content = $thePost->post_content;
      $subline = get_post_meta( $thePost->ID, 'subline', true );
      $char_limit = 200;
      $date = strtotime($date);
      $date = gmdate('jS F Y',$date);
      $return .= '<div class="col-md-12 single-news" style="padding-left: 0;">';
      $return .= '<h5>'.get_the_author().'</h5>';
      $return .= '<h2 style="margin-bottom: 15px; margin-top: 20px;">'.$thePost->post_title.'</h2>';
      $return .= '<p>'.strip_tags(substr($the_content,0,$char_limit)).' ...</p>';
      $return .= '<a href="'.get_the_permalink($thePost->ID).'" class="btn btn-default red">Weiterlesen</a>';
      $return .= '<hr class="between_line">';
      $return .= '</div>';
    }
  }
  // $total_pages = $args->max_num_pages;
    $return .= '<div class="row">';
    $return .= '<div id="pagination" class="col-md-12">';
    $pages =  paginate_links(array(
        'base' => get_pagenum_link(1) . '%_%',
        'format' => '/page/%#%',
        'current' => $currentPage,
        'total' => $query->max_num_pages,
        'prev_text'    => __('<'),
        'next_text'    => __('>'),
    ));
    $return .= $pages;
    $return .= '</div>';
    $return .= '</div>';
  wp_reset_postdata();
  return $return;
}
add_shortcode( 'get_stories', 'shortcodeFunction_get_stories' );
function shortcodeFunction_get_team_member_tipp( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '0',
    'class' => '',
    'post_type' => 'team_member',
    'posts_per_page' => '1',
    'random' => 'rand',
  ), $atts ) );  
  $args = array(
    'posts_per_page' => $posts_per_page,
    'post_type' => $post_type,
    'cat' => $cat,
    'orderby' => $random,
    'order' => 'DESC',
    'meta_query' => array(
      array(
        'key' => 'team_member_tipp'
      )
    )
  );
  $posts = get_posts($args);
  $return = '';
  //var_dump($posts);
  foreach($posts as $post){
    $thePost = get_post($post);
    $team_member_tipp = get_post_meta( $thePost->ID, 'team_member_tipp', true );
    if (is_page_template('template-home.php')) {
      $return .= '
      <div  class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
      <div class="text">
      <h3>Mitarbeiter-Tipps</h3>';
      if ( ! empty( $team_member_tipp ) ) {
        $return .= '<p>'.strip_tags(substr($team_member_tipp,0, 100)).'</p>';
      }
      $return .= '<a class="btn btn-default red" href="mitarbeiter-tipps">Zu den Tipps</a>
      </div>
      </div>
      <div class="col-xl-6 col-lg-4 col-md-4 col-sm-12">
      <div id="Mitarbeiter_image">
      <div class="text">';
      if (get_the_post_thumbnail( $thePost->ID )) {
        $return .= get_the_post_thumbnail( $thePost->ID, 'news-thumb', array( 'class' => 'img-responsive' ) );
      } else {
        $return .= '<img src="https://placeholdit.imgix.net/~text?txtsize=16&txt=noch+kein+Bild&w=247&h=274" class="img-responsive full-height">';
      }
      $return .= '</div>';
      $return .= '</div>';
      $return .= '</div>';
    } else {
      $return .= '<div class="row">';
      $return .= '<div class="col-md-12">';
      if (get_the_post_thumbnail( $thePost->ID )) {
        $return .= get_the_post_thumbnail( $thePost->ID, 'news-thumb', array( 'class' => 'img-responsive' ) );
      } else {
        $return .= '<img src="https://placeholdit.imgix.net/~text?txtsize=16&txt=noch+kein+Bild&w=247&h=274" class="img-responsive">';
      }
      $return .= '</div>';
      $return .= '</div>';
      $return .= '<div class="row">';
      $return .= '<div class="col-md-12" style="padding-left: 30px; padding-right: 30px;">';
      $return .= '<h3>'.__('Mitarbeiter-Tipp', 'klintwort-theme').'</h3>';
      if ( ! empty( $team_member_tipp ) ) {
        $return .= '<p style="margin-bottom: 0;">'.$team_member_tipp.'</p>';
      }
      $return .= '</div>';
      $return .= '</div>';
    }
  }
  return $return;
}
add_shortcode( 'get_team_member_tipp', 'shortcodeFunction_get_team_member_tipp' );
function shortcodeFunction_get_jobs( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '0',
    'class' => '',
    'post_type' => 'job_offers',
    'posts_per_page' => '1',
    'random' => 'rand',
    'is_widget' => false,
  ), $atts ) );
  $args = array(
    'posts_per_page' => $posts_per_page,
    'post_type' => $post_type,
    'cat' => $cat,
    'orderby' => $random,
    'order' => 'DESC',
  );
  $posts = get_posts($args);
  $return = '';
  foreach($posts as $post){
    $thePost = get_post($post);
    $the_content = $thePost->post_content;
    $the_post_title = get_the_title( $thePost->ID );
    // Char LimitIterator
    $char_limit = 200;
    $return .= '<div class="row job_section">';
    if ($is_widget == true) {
      $return .= '<div class="col-md-12">';
    } 
    else {
      $return .= '<div class="col-md-12">';
    }
    if (get_the_post_thumbnail( $thePost->ID )) {
      $return .= get_the_post_thumbnail( $thePost->ID, 'news-thumb', array( 'class' => 'img-responsive' ) );
    } else {
      $return .= '<img src="https://placeholdit.imgix.net/~text?txtsize=16&txt=noch+kein+Bild&w=247&h=274" class="img-responsive">';
    }
    $return .= '</div>';
    if ($is_widget == true) {
      $return .= '</div>';
      $return .= '<div class="row">';
      $return .= '<div class="col-md-12">';
    } else {
      $return .= '<div class="col-md-12">';
    }
    //$return .= '<h3>'.__('Jobs', 'klintwort-theme').'</h3>';
    if ( ! empty( $the_post_title ) ) {
      $return .= '<h3>'.$the_post_title.'</h3>';
    }
    $return .= '<p>'.strip_tags(substr($the_content,0,$char_limit)).' ...</p>';
    $return .= '<a href="http://dev.klindwort-apotheken.de/meine-apotheke/jobangebote/" class="btn btn-default red">Weiterlesen</a>';
	  $return .= '<hr class="between_line">';
    $return .= '</div>';
    $return .= '</div>';
    //if ($is_widget != true) {
    //  $return .= '<div class="sep-30"></div>';
    //}
  }
  // $return .= '</div>';
  return $return;
}
add_shortcode( 'get_jobs', 'shortcodeFunction_get_jobs' );
// ###########################
function shortcodeFunction_get_jobs_content( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '0',
    'class' => '',
    'post_type' => 'job_offers',
    'posts_per_page' => '1',
    'random' => 'rand',
    'is_widget' => false,
  ), $atts ) );
  $args = array(
    'posts_per_page' => $posts_per_page,
    'post_type' => $post_type,
    'cat' => $cat,
    'orderby' => $random,
    'order' => 'DESC',
  );
  $posts = get_posts($args);
  $counter = 0;
  $return = '';
  $return .= '<div class="row job_section">';
  $return .= '<div class="col-md-12">';
  $return .= '<div id="accordion" role="tablist" aria-multiselectable="true">';
  foreach($posts as $post){
    $thePost = get_post($post);
    $the_content = $thePost->post_content;
    $the_post_title = get_the_title( $thePost->ID );
    $char_limit = 200;
    if ( ! empty( $the_post_title ) ) {
      $return .= '<div class="card" style="background-color: transparent;">';
      $return .= '<div class="card-header" role="tab" id="heading'. $counter .'">';
      $return .= '<h3 class="mb-0" style="margin-bottom: 0;">';
      $return .= '<a data-toggle="collapse" data-parent="#accordion" href="#collapse'. $counter .'" aria-expanded="false" aria-controls="collapse'. $counter .'">'.$the_post_title.'</a>';
      $return .= '</h3>';
      $return .= '</div>';
      $return .= '<div id="collapse'. $counter .'" class="collapse" role="tabpanel" aria-labelledby="heading'. $counter .'">';
      $return .= '<div class="card-block">';
      $return .= '<p>'.strip_tags(substr($the_content,0,$char_limit)).' ...</p>';
      // $return .= '<a href="http://dev.klindwort-apotheken.de/meine-apotheke/jobangebote/" class="btn btn-default red">Weiterlesen</a>';
      $return .= '</div>';
      $return .= '</div>';
      $return .= '</div>';
      $counter++;
    }
  }
  $return .= '</div>';//end accordion
  $return .= '</div>';
  $return .= '</div>';
  return $return;
}
add_shortcode( 'get_jobs_content', 'shortcodeFunction_get_jobs_content' );
// ###########################
function shortcodeFunction_get_team( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '0',
    'class' => '',
    'post_type' => 'team_member',
    'posts_per_page' => '-1',
    'random' => 'rand',
    'standort' => ''
  ), $atts ) );
  if ($standort) {
    $args = array(
      'posts_per_page' => $posts_per_page,
      'post_type' => $post_type,
      'cat' => $cat,
      'orderby' => $random,
      'order' => 'DESC',
      'meta_query' => array(
        array(
          'key' => 'standort_id',
          'value' => $standort
        )
      )
    );
  } else {
    $args = array(
      'posts_per_page' => $posts_per_page,
      'post_type' => $post_type,
      'cat' => $cat,
      'orderby' => $random,
      'order' => 'DESC',
    );
  }
  $posts = get_posts($args);
  $return = '';
  $return .= '<div class="'.$class.'">';
  $return .= '<div class="row team">';
  $key_counter = 1;
  foreach($posts as $post){
    //$key = 1;
    $thePost = get_post($post);
    $posturl = get_post_permalink($thePost->ID);
    $the_content = $thePost->post_content;
    $the_post_title = get_the_title( $thePost->ID );
    $team_member_tipp = get_post_meta( $thePost->ID, 'team_member_tipp', true );
    $team_member_tel = get_post_meta( $thePost->ID, 'team_member_tel', true );
    $team_member_email = get_post_meta( $thePost->ID, 'team_member_email', true );
    $return .= '<div class="col-md-4 '.$key_counter.'">';
    $return .=  '<a href="#modaal-id-'.$key_counter.'" class="image-post-link inline">';
    $return .= '<div class="mask"><button class="btn btn-default open-modaal">'.__('Mehr über mich', 'klintwort-theme').'</button></div>';
    if (get_the_post_thumbnail( $thePost->ID )) {
      $return .= get_the_post_thumbnail( $thePost->ID, 'team-thumb', array( 'class' => 'img-responsive' ) );
    } else {
      $return .= '<img src="https://placeholdit.imgix.net/~text?txtsize=16&txt=noch+kein+Bild&w=247&h=274" class="img-responsive">';
    }
    $return .= '</a>';
    if ( ! empty( $the_post_title ) ) {
      $return .= '<div class="sep-15"></div>';
      $return .= '<h4>'.$the_post_title.'</h4>';
      $terms = wp_get_post_terms($thePost->ID, 'team_cat' );
      if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        $return .= '<span class="team-title">';
        foreach ( $terms as $term ) {
          $return .= $term->name;
        }
        $return .= '</span>';
      } else {
        $return .= '<span class="team-title">Keine Angabe</span>';
      }
    }
    $return .= '<div id="modaal-id-'.$key_counter.'" class="modalDialog">
    <div>
    <div class="row">
    <div class="col-md-12">
    <h3>Wer ist eigentlich...?</h3>
    <h2>'.$the_post_title.'</h2>
    </div>
    </div>
    <div class="sep-30"></div>
    <div class="row">
    <div class="col-md-6">
    <h4>Meine Aufgabe bei Klindwort:</h4>
    <p>';
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
      $return .= '<span>';
      foreach ( $terms as $term ) {
        $return .= $term->name;
      }
      $return .= '</span>';
    } else {
      $return .= '<span class="team-title">Keine Angabe</span>';
    }
    $return .='</p>
    <div class="sep-30"></div>
    <h4>Kontakt:</h4>';
    if ($team_member_tel) {
      $return .='Telefon: '.$team_member_tel.' <br>';
    } else {
      $return .='Telefon: (noch keine Nummer hinterlegt) <br>';
    }
    if ($team_member_email) {
      $return .='<a href="mailto:'.$team_member_email.'">'.$team_member_email.'</a>';
    } else {
      $return .= 'Noch keine E-Mail-Adresse hinterlegt.';
    }
    $return .='<blockquote>'.$team_member_tipp.'</blockquote>
    </div>
    <div class="col-md-6">
    <div class="modal-image-holder">
    '.get_the_post_thumbnail( $thePost->ID, 'team-thumb-big', array( 'class' => 'img-responsive' ) ).'
    </div>
    </div>
    </div>
    <div class="sep-30"></div>
    <div class="row">
    <div class="col-md-12">
    <a href="#close" title="Close" class="btn btn-default red pull-left">Fenster schließen</a>
    </div>
    </div>
    </div>
    </div>';
    $return .= '</div>';
    if ($key_counter % 4 === 0 ) {
      $return .= '</div>';
      $return .= '<div class="row text team">';
    }
    $key_counter++;
  }
  $return .= '</div>';
  $return .= '</div>';
  return $return;
}
add_shortcode( 'get_team', 'shortcodeFunction_get_team' );
// #######################################################################################################################
function shortcodeFunction_get_team_members( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '0',
    'class' => '',
    'post_type' => 'team_member',
    'posts_per_page' => '-1',
    'random' => 'rand',
    'standort' => ''
  ), $atts ) );
  if ($standort) {
    $args = array(
      'posts_per_page' => $posts_per_page,
      'post_type' => $post_type,
      'cat' => $cat,
      'orderby' => $random,
      'order' => 'DESC',
      'meta_query' => array(
        array(
          'key' => 'standort_id',
          'value' => $standort
        )
      )
    );
  } else {
    $args = array(
      'posts_per_page' => $posts_per_page,
      'post_type' => $post_type,
      'cat' => $cat,
      'orderby' => $random,
      'order' => 'DESC',
    );
  }
  $posts = get_posts($args);
  $return = '';
  foreach($posts as $post){
    $thePost = get_post($post);
    $posturl = get_post_permalink($thePost->ID);
    $the_content = $thePost->post_content;
    $the_post_title = get_the_title( $thePost->ID );
    $team_member_tipp = get_post_meta( $thePost->ID, 'team_member_tipp', true );
    $team_member_tel = get_post_meta( $thePost->ID, 'team_member_tel', true );
    $team_member_email = get_post_meta( $thePost->ID, 'team_member_email', true );
    $team_member_standort = get_post_meta( $thePost->ID, 'standort_id', true );
    $return .= '<div class="row">';
    $return .= '<div class="col-xl-3 col-lg-4 col-md-4 col-sm-12">';
    if (get_the_post_thumbnail( $thePost->ID )) {
      $return .= get_the_post_thumbnail( $thePost->ID, 'team-thumb', array( 'class' => 'img-responsive' ) );
    } else {
      $return .= '<img src="https://placeholdit.imgix.net/~text?txtsize=16&txt=noch+kein+Bild&w=270&h=190" class="img-responsive">';
    }
    $return .= '</div>';
    $return .= '<div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">';
    $terms = wp_get_post_terms($thePost->ID, 'team_cat' );
    $return .= '<h5>';
      if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        $return .= '<span>';
        foreach ( $terms as $term ) {
          $return .= $term->name . '. ';
        }
        $return .= '</span>';
      } else {
        $return .= '<span class="team-title">Keine Angabe</span>';
      }
    $return .= '</h5>';
    $return .= '<h3>' . $team_member_standort . '</h3>';
    $return .= '<h2 style="margin-bottom: 15px; margin-top: 20px;">'. $the_post_title .'</h2>';
    $return .= '<p style="margin-bottom: 15px;">'. $team_member_tipp .'</p>';
    // $return .= '<a href="'.get_the_permalink($thePost->ID).'" class="btn btn-default red">Weiterlesen</a>';
    $return .= '</div>';
    $return .= '</div>';
    $return .= '<hr>';
  }
  return $return;
}
add_shortcode( 'get_team_members', 'shortcodeFunction_get_team_members' );
// #######################################################################################################################
function shortcodeFunction_get_notfall_apos( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '0',
    'class' => '',
    'post_type' => 'job_offers',
    'posts_per_page' => '1',
    'random' => 'rand',
  ), $atts ) );
  $result = '';
  //$json = file_get_contents('https://www.aksh-notdienst.de/notdienste/exporte/ndk.php?f=json&c=utf8&m=ort&w=364');
  //$json = file_get_contents('https://www.aksh-notdienst.de/notdienste/exporte/ndk.php?f=json&c=utf8&m=ort&w=297');
  $json = loadFile('https://www.aksh-notdienst.de/notdienste/exporte/ndk.php?f=json&c=iso&m=koord&w=53.865886;10.687096&adr=Die%20n%26auml%3Bchsten%204%20Notdienstapotheken%20%28Luftlinie%29%20f%26uuml%3Br%20den%20Ortsmittelpunkt%20von%20L%26uuml%3Bbeck&a=4');
  $data = json_decode($json);
  $apo_coords = array();
  $result .='
  <div class="row" id="notfall_apos">
  <div class="col-md-6">
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
  <div class="sep-15"></div>
  <div class="row">';
  foreach ((array)$data as $key => $item) {
    $item_counter = 1;
    @$apotheken = $item->apotheken;
    foreach ((array)$apotheken as $k => $value) {
      $result .= '<div class="col-md-6">';
      $result .= '<b>'.$value->apo . '</b></br>';
      $result .= '<p>'.$value->str . '<br>';
      $result .= $value->plz .' ' . $value->ort . '<br>';
      $result .= $value->tel . '</p></div>';
      $apo_coords[$k]['title'] = $value->apo;
      $apo_coords[$k]['lat'] = $value->lat;
      $apo_coords[$k]['lng'] = $value->lon;
      $item_counter++;
      if ($item_counter % 3 == 0) {
        $result .= '</div><div class="sep-15"></div><div class="row">';
      }
    }
  }
  wp_localize_script( 'sage/js', 'apo_coords', $apo_coords );
  $result .='
  </div>
  </div>
  <div class="col-md-6">
  <div id="gmap-top-bar"></div>
  </div>
  </div>
  ';
  return $result;
}
add_shortcode( 'get_notfall_apos', 'shortcodeFunction_get_notfall_apos' );
function shortcodeFunction_get_products( $atts ) {
  extract( shortcode_atts( array(
    'cat' => '0',
    'class' => '',
    'post_type' => 'products',
    'posts_per_page' => '1',
    'random' => 'rand',
    'is_widget' => false,
  ), $atts ) );
  $args = array(
    'posts_per_page' => $posts_per_page,
    'post_type' => $post_type,
    'cat' => $cat,
    'orderby' => $random,
    'order' => 'DESC',
  );
  $posts = get_posts($args);
  $return = '';
  	$xmlstr = file_get_contents('https://shop.klindwort.de/rest/category/show?parentCategoryId=65200&productStoreId=eKlindwort');
    $xml = new SimpleXMLElement($xmlstr);
	echo '<div class="row">';
    foreach ($xml as $element) {
        if ($element->availability_message) {
            echo '<div class="col-sm-3half shopbox">';
            echo '<div class="img-container-shopbox">';
            echo '<img class="img img-responsive shopimage" style="max-height: 150px;" src="https://shop.klindwort.de'.$element->large_image_path.'">';
            echo '</div>';
            echo '<p class="shopproductname">'.$element->name.'</p>';
            echo '<p class="shopmanu">'.$element->manufacturer.'</p>';
            echo '<p class="shopamount">'.$element->quantity.' '.$element->uom.'</p>';
			echo '<p class="shopprice">'.$element->price.'€</p>';
			echo '<p class="shopsave">Sie sparen '.$element->discount_percent.'%</p>';
            echo '</div>';
        }
    }
    echo '</div>';
}
add_shortcode( 'get_products', 'shortcodeFunction_get_products' );
function shortcodeFunction_get_news( $atts ) {
    extract( shortcode_atts( array(
      'cat' => '0',
      'class' => '',
      'post_type' => 'news',
      'posts_per_page' => '1',
      'random' => 'rand',
      'is_widget' => false,
    ), $atts ) );
    $args = array(
      'posts_per_page' => $posts_per_page,
      'post_type' => $post_type,
      'cat' => $cat,
      'orderby' => $random,
      'order' => 'DESC',
    );
    $posts = get_posts($args);
    $return = '';
    $remoteJson = file_get_contents('https://v4.api.apotheken.de/api/58a2af65-d6e1-9754-3189-593a8a6aedf0/news.json');
    $json = json_decode($remoteJson);
    echo '<div class="row news-container">';
    foreach($json->response->news as $mydata) {
		echo '<div class="col-md-12" style="padding-right: 50px;padding-left: 0;">';
        echo '<div class="col-md-4 newsbox" style="display: inline-block;">';
        foreach($mydata->media as $imagedata) {
            $big = 'gross';
            if (strpos($imagedata->href, $big, 1)) {
                echo '<img class="media-object newsimage" src="'. $imagedata->href .'" alt="'. $mydata->title .'">';
            }
        }
        echo '</div>';
        echo '<div class="col-md-8" style="display: inline-block; padding-left: 30px; vertical-align: top;">';
        echo '<h3 class="newssubtitle">' . $mydata->short . '</h3>';
        echo '<p class="newstitle">' . $mydata->title . '</p>';
        echo '<p class="newstext">' . limit_text($mydata->bodytext, 20) . '</p>';
  		  echo '<a class="btn btn-default red" data-toggle="modal" data-target="#exampleModalLong">Weiterlesen</a>';
        echo '</div>';
		    echo '<div class="col-md-12">';
        echo '<hr class="between_line">';
        echo '</div>';
		echo '</div>';
    }
    echo '</div>';
}
add_shortcode( 'get_news', 'shortcodeFunction_get_news' );
// ##############################################################
// function shortcodeFunction_get_articles_all( $atts ) {
//   $postslist = get_posts( 'cat=10&posts_per_page=-1&post_type=post' );  
//   foreach ($postslist as $post) :  setup_postdata($post);
//     wp_delete_post( $post->ID, true );
//   endforeach;
//   wp_reset_postdata();
// }
add_shortcode( 'get_articles_all', 'shortcodeFunction_get_articles_all' );
// ##############################################################
function shortcodeFunction_get_videos( $attr ) {
  $postslist = get_posts( 'cat=11&posts_per_page=-1&post_type=post' );
  foreach ($postslist as $post) :  setup_postdata($post);
    echo '<div class="col-md-12" style="padding-left: 0; padding-right: 0;">';
    echo '<div style="display: flex; justify-content: center; flex-direction: row; flex-wrap: wrap;">';
    echo '<div id="video_page_img" class="col-lg-4 col-md-12 col-sm-12" style="padding-left: 0;">';
    if (has_post_thumbnail($post->ID)) {
      echo get_the_post_thumbnail($post->ID);
    }
    else {
      echo '<img src="http://placehold.it/350x220" style="width: 230px; height: auto; margin-bottom: 25px;" class="img-responsive full-height">';
    }
    echo '</div>';
    echo '<div id="video_page_content" class="col-lg-8 col-md-12 col-sm-12">';
    echo '<h2 style="margin-bottom: 15px;">' . get_the_title($post->ID) . '</h2>';
    echo '<p>' . get_the_content() . '</p>';
    echo '<a href="#" class="btn btn-default red" data-toggle="modal" data-target="#' . $post->ID . '">Video ansehen</a>';
    echo '</div>';
    echo '</div>';
    echo '<hr class="between_line">';
    echo '</div>';
    echo '<div class="modal fade" id="' . $post->ID . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header" style="border-bottom: 5px solid #c31824; padding: 0;"></div>';
    echo '<div class="modal-body" style="padding: 0;">';
    $url = get_post_meta($post->ID, 'url', true);
    $url = str_replace('560', '100%', $url);
    $url = str_replace('315', '500', $url);
    echo $url;
    echo '</div>';
    echo '<div class="modal-footer" style="border-top: none;">';
    echo '<button type="button" class="btn btn-primary" data-dismiss="modal">Schließen</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  endforeach;
  // wp_reset_postdata();
}
add_shortcode( 'get_videos', 'shortcodeFunction_get_videos');
// ##############################################################
function shortcodeFunction_get_videos_home( $attr ) {
  $posts = get_posts( 'cat=11&posts_per_page=1&post_type=post' );
  foreach ($posts as $post) :  setup_postdata($post);
    echo '<div class="col-xl-6 col-lg-7 col-md-7 col-sm-12 col-xs-12">';
    echo '<div class="text">';
    echo '<h3>Erklärvideos</h3>';
    // echo '<h5>' . get_the_title($post->ID) . '</h5>';
    echo '<p>' . substr(get_the_content(), 0, 80) . ' ...</p>';
    echo '<a class="btn btn-default red" href="erklaervideos">Zu den Videos</a>';
    echo '</div>';
    echo '</div>';
    echo '<div id="videos_home" style="padding-left: 0;" class="col-xl-6 col-lg-5 col-md-5 col-sm-12 col-xs-12">';
    echo '<div class="text" style="padding-left: 0;">';
    echo get_the_post_thumbnail($post->ID, 'medium');
    echo '</div>';
    echo '</div>';
  endforeach;
  wp_reset_postdata();
}
add_shortcode( 'get_videos_home', 'shortcodeFunction_get_videos_home');
// ##############################################################
function shortcodeFunction_get_whatsapp_home( $attr ) {
  // $posts = get_posts( 'cat=11&posts_per_page=1&post_type=post' );
  // foreach ($posts as $post) :  setup_postdata($post);
  echo '<div class="col-xl-6 col-lg-7 col-md-7 col-sm-12 col-xs-12">';
  echo '<div class="text">';
  echo '<h3>WhatsApp-Bestellung</h3>';
  // echo '<p>' . substr(get_the_content(), 0, 80) . ' ...</p>';
  echo '<p>Bei uns können Sie Ihre Arzneimittel einfach und bequem per WhatsApp bestellen.</p>';
  echo '<a class="btn btn-default red" href="bestellung-per-whatsapp">Weitere Informationen</a>';
  echo '</div>';
  echo '</div>';
  echo '<div id="whatsapp_home" style="padding-left: 0;" class="col-xl-6 col-lg-5 col-md-5 col-sm-12 col-xs-12">';
  // echo get_the_post_thumbnail($post->ID, 'medium');
  echo '<div class="text" style="padding-left: 0;">';
  echo '<img class="img-responsive" src="http://placehold.it/300x200" />';
  echo '</div>';
  echo '</div>';
  // endforeach;
  // wp_reset_postdata();
}
add_shortcode( 'get_whatsapp_home', 'shortcodeFunction_get_whatsapp_home');
// ##############################################################
function shortcodeFunction_get_articles( $atts ) {
    $postslist = get_posts( 'cat=10&posts_per_page=-1&post_type=post' );  
    foreach ($postslist as $post) :  setup_postdata($post);
      wp_delete_attachment( get_post_thumbnail_id($post->ID) );
      wp_delete_post( $post->ID, true );
    endforeach;
    wp_reset_postdata();
    global $user_ID;
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    // $remoteJson = file_get_contents('https://v4.api.apotheken.de/api/77d604c6-1710-5093-43a6-593a8ae36424/artikel.json');
    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    ); 
    $remoteJson = file_get_contents('https://v4.api.apotheken.de/api/58a2af65-d6e1-9754-3189-593a8a6aedf0/news.json', false, stream_context_create($arrContextOptions));
    $json = json_decode($remoteJson, true);
    $category = get_category_by_slug( 'news' );
    foreach(array_reverse($json['response']['news']) as $mydata) {
        $new_post = array(
          'post_title' => $mydata['title'],
          'post_content' => '<h4 style="margin-bottom: 10px;">' . $mydata['short'] . '.</h4>' . $mydata['bodytext'],
          'post_status' => 'publish',
          'post_date' => date('Y-m-d H:i:s'),
          'post_author' => $user_ID,
          'post_type' => 'post',
          'post_category' => array($category->term_id)
        );
        $post_id = wp_insert_post($new_post);
        $image_url        = $mydata['media']['1']['href'];
        $image_name       = $mydata['title'].'.jpg';
        $upload_dir       = wp_upload_dir();
        $image_data       = file_get_contents($image_url);
        $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
        $filename         = basename( $unique_file_name ); // Create image file name
        if( wp_mkdir_p( $upload_dir['path'] ) ) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }
        // Create the image  file on the server
        file_put_contents( $file, $image_data );
        // Check image file type
        $wp_filetype = wp_check_filetype( $filename, null );
        // Set attachment data
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title'     => sanitize_file_name( $filename ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        // Create the attachment
        $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
        // Define attachment metadata
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        // Assign metadata to attachment
        wp_update_attachment_metadata( $attach_id, $attach_data );
        // And finally assign featured image to post
        set_post_thumbnail( $post_id, $attach_id );
    }
}
add_shortcode( 'get_articles', 'shortcodeFunction_get_articles' );
// ##############################################################
function limit_text($text, $limit) {
  if (str_word_count($text, 0) > $limit) {
      $words = str_word_count($text, 2);
      $pos = array_keys($words);
      $text = substr($text, 0, $pos[$limit]) . '...';
  }
  return $text;
}
?>