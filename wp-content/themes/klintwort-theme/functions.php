<?php
/**
* Sage includes
*
* The $sage_includes array determines the code library included in your theme.
* Add or remove files to the array as needed. Supports child theme overrides.
*
* Please note that missing files will produce a fatal error.
*
* @link https://github.com/roots/sage/pull/1042
*/
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/breadtrumb.php',// Adds the Breadtrump
  'lib/cpt.php',// Adds the Theme CPTs
  'lib/shortcodes.php',// Adds the Shortcodes
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

remove_filter( 'the_content', 'wpautop' );

// Get the custom tax cat name func
function get_the_category_custompost( $id = false, $tcat = 'category' ) {
  $categories = get_the_terms( $id, $tcat );
  if ( ! $categories )
  $categories = array();

  $categories = array_values( $categories );

  foreach ( array_keys( $categories ) as $key ) {
    _make_cat_compat( $categories[$key] );
  }

  return apply_filters( 'get_the_categories', $categories );
}

add_theme_support('html5', array('search-form'));

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');


add_action( 'widgets_init', 'register_my_widgets' );

function register_my_widgets() {
  register_widget( 'My_Text_Widget' );
}

class My_Text_Widget extends WP_Widget_Text {
  function widget( $args, $instance ) {
    extract($args);
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
    $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
    echo $before_widget;
    if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
    <?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
    <?php
    echo $after_widget;
  }
}

function add_image_attachment_fields_to_edit( $form_fields, $post ) {


  // Add a Credit field
  $form_fields["advert_link"] = array(
    "label" => __("Zielt auf welche URL?"),
    "input" => "text", // this is default if "input" is omitted
    "value" => esc_url( get_post_meta($post->ID, "_advert_link", true) )
  );

  return $form_fields;
}
add_filter("attachment_fields_to_edit", "add_image_attachment_fields_to_edit", null, 2);

function add_image_attachment_fields_to_save( $post, $attachment ) {

  if ( isset( $attachment['advert_link'] ) )
  update_post_meta( $post['ID'], '_advert_link', esc_url($attachment['advert_link']) );

  return $post;
}
add_filter("attachment_fields_to_save", "add_image_attachment_fields_to_save", null , 2);

function pagination($pages = '', $range = 4)
{  
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}


/**
* Get an URL via cURL
*
* @param string      $url  The URL to fetch
*
* @return string  The shortend text.
*/

function loadFile($url) {
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);

  $data = curl_exec($ch);
  curl_close($ch);

  return $data;
}