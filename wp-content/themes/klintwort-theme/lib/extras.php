<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
* Add <body> classes.
*/
function body_class($classes)
{
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__.'\\body_class');

/**
* Clean up the_excerpt().
*/
function excerpt_more()
{
  return ' &hellip; <a href="'.get_permalink().'">'.__('Continued', 'sage').'</a>';
}
add_filter('excerpt_more', __NAMESPACE__.'\\excerpt_more');

//Adding widget areas
/**
* Add SVG capabilities.
*/
function wpcontent_svg_mime_type($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';

  return $mimes;
}
add_filter('upload_mimes', __NAMESPACE__.'\\wpcontent_svg_mime_type');

//Adding widget areas
if (function_exists('register_sidebar')) {
  register_sidebar(array(
    'name' => 'Home Aktuelle News',
    'id' => 'home_news',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => 'Home Aktuelle Aktionen',
    'id' => 'home_events',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => 'Home Facebook',
    'id' => 'home_facebook',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => 'Home Videos',
    'id' => 'home_videos',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => 'Home Content Teaser',
    'id' => 'home_teaser',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => 'Home Jobs',
    'id' => 'home_jobs',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => 'Home Jobs2',
    'id' => 'home_jobs2',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => 'Home Mitarbeiter-Tipps',
    'id' => 'home_team_tipps',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => 'Adressinformationen (Footer)',
    'id' => 'footer_left3',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'name' => 'Footer Social-Media',
    'id' => 'footer_right2',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'name' => 'Weitere Navigation im Footer',
    'id' => 'footer_right3',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
  ));
}

//Add Some JS

function add_slider()
{
  wp_register_script('slider-init', get_template_directory_uri().'/assets/scripts/jquery.slider.js', array('jquery'), true);
  wp_enqueue_script('slider-init');
}
add_action('wp_enqueue_scripts', __NAMESPACE__.'\\add_slider', 95);

function add_facebook()
{
  wp_register_script('facebook-init', get_template_directory_uri().'/assets/scripts/facebook.all.js', true);
  wp_enqueue_script('facebook-init');
}
add_action('wp_enqueue_scripts', __NAMESPACE__.'\\add_facebook', 95);

function add_googlemaps_scripts()
{
  wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBuU_0_uLMnFM-2oWod_fzC0atPZj7dHlU');
  wp_enqueue_script('google-jsapi', 'https://www.google.com/jsapi');
}
add_action('wp_enqueue_scripts', __NAMESPACE__.'\\add_googlemaps_scripts');

function add_button_to_location_admin_page($hook)
{
  # Not our screen, bail out
  if( 'post.php' !== $hook )
  return;

  # Not our post type, bail out
  global $typenow;
  if( 'locations' !== $typenow )
  return;

  wp_register_script('add_button_script', get_template_directory_uri().'/assets/scripts/add_button_script.js', array('jquery'), true);
  wp_enqueue_script('add_button_script');
}
add_action('admin_enqueue_scripts', __NAMESPACE__.'\\add_button_to_location_admin_page', 99);

//This function converts german umlaute for better handling
function umlautepas($string)
{
  $upas = array('ä' => 'ae', 'ü' => 'ue', 'ö' => 'oe', 'Ä' => 'Ae', 'Ü' => 'Ue', 'Ö' => 'Oe');

  return strtr($string, $upas);
}

//This activates Shortcodes in Widgets
add_filter('widget_text', 'do_shortcode');

//This handles the CPT Dropdowns
function generate_post_select($select_id, $post_type, $selected = 0)
{
  $post_type_object = get_post_type_object($post_type);
  $label = $post_type_object->label;
  $posts = get_posts(array('post_type' => $post_type, 'post_status' => 'publish', 'suppress_filters' => false, 'posts_per_page' => -1));
  echo '<select name="'.$select_id.'" id="'.$select_id.'">';
  echo '<option value = "" >All '.$label.' </option>';
  foreach ($posts as $post) {
    echo '<option value="', $post->ID, '"', $selected == $post->ID ? ' selected="selected"' : '', '>', $post->post_title, '</option>';
  }
  echo '</select>';
}

//This adds some custom image sizes
add_image_size('home-top-teaser', 270, 210, true);
add_image_size('home-down-teaser', 370, 240, true);
add_image_size('team-contact-picture', 150, 185, true);
add_image_size('featured-image', 1110, 500, true);
add_image_size('team-thumb', 270, 190, true);
add_image_size('team-thumb-big', 400, 280, true);
add_image_size('news-thumb', 245, 245, true);

/**
* Filter the except length to 23 characters.
*
* @param int $length Excerpt length.
*
* @return int (Maybe) modified excerpt length.
*/
function wpdocs_custom_excerpt_length($length)
{
  return 23;
}
add_filter('excerpt_length', __NAMESPACE__.'\\wpdocs_custom_excerpt_length', 999);

/**
* Filter the excerpt "read more" string.
*
* @param string $more "Read more" excerpt string.
*
* @return string (Maybe) modified "read more" excerpt string.
*/
function wpdocs_excerpt_more($more)
{
  return ' ...';
}
add_filter('excerpt_more', __NAMESPACE__.'\\wpdocs_excerpt_more');

//This removes some unwanted Admin-Things
function remove_menus()
{
  remove_menu_page('edit.php');                   //Posts
  remove_menu_page('edit-comments.php');          //Comments
}
//add_action( 'admin_menu', __NAMESPACE__.'\\remove_menus' );

//crude browser detection
function browser_body_class($classes)
{
  global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

  if ($is_lynx) {
    $classes[] = 'lynx';
  } elseif ($is_gecko) {
    $classes[] = 'gecko';
  } elseif ($is_opera) {
    $classes[] = 'opera';
  } elseif ($is_NS4) {
    $classes[] = 'ns4';
  } elseif ($is_safari) {
    $classes[] = 'safari';
  } elseif ($is_chrome) {
    $classes[] = 'chrome';
  } elseif ($is_IE) {
    $classes[] = 'ie';
  } else {
    $classes[] = 'unknown';
  }

  if ($is_iphone) {
    $classes[] = 'iphone';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__.'\\browser_body_class');

// Add Metaboxs
add_filter('rwmb_meta_boxes', __NAMESPACE__.'\\posts_meta_boxes');
function posts_meta_boxes($meta_boxes)
{
  $meta_boxes[] = array(
    'title' => __('Zusätzliche Felder', 'klintwort-theme'),
    'post_types' => array(
      'page', 'post'
    ),
    'fields' => array(

      array(
        'id' => 'slider_gallery',
        'name' => __('Bilder', 'klintwort-theme'),
        'post_types' => array(
          'page', 'team_member',
        ),
        'type' => 'image_advanced',
        // Delete image from Media Library when remove it from post meta?
        // Note: it might affect other posts if you use same image for multiple posts
        'force_delete' => false,
        'clone' => false,
        'multiple' => true,

      ),

      array(
        'id' => 'subline',
        'name' => __('Subline', 'klintwort-theme'),
        'type' => 'text',
        'title' => __('Subline', 'klintwort-theme'),
        'post_types' => array(
          'page', 'post',
        ),
      ),
    ),
  );

  return $meta_boxes;
}

add_filter('rwmb_meta_boxes', __NAMESPACE__.'\\posts_meta_boxes_locations');
function posts_meta_boxes_locations($meta_boxes_locations)
{
  $meta_boxes_locations[] = array(
    'title' => __('Zusätzliche Felder', 'klintwort-theme'),
    'post_types' => array(
      'locations',
    ),
    'fields' => array(

      array(
        'id' => 'subline',
        'name' => __('Subline', 'klintwort-theme'),
        'type' => 'text',
        'title' => __('Subline', 'klintwort-theme'),
        'post_types' => array(
          'page', 'post',
        ),
      ),
      array(
        'id' => 'contactform_id',
        'name' => __('Kontakt-Formular', 'klintwort-theme'),
        'type' => 'post',
        // Post type
        'post_type' => 'wpcf7_contact_form',
        // Field type, either 'select' or 'select_advanced' (default)
        'field_type' => 'select_advanced',
        'placeholder' => esc_html__('Bitte wählen', 'klintwort-theme'),
        // Query arguments (optional). No settings means get all published posts
        'query_args' => array(
          'post_status' => 'publish',
          'posts_per_page' => -1,
        ),

      ),
      array(
        'id' => 'place_id',
        'name' => __('Google Place ID', 'klintwort-theme'),
        'type' => 'text',
        // Post type
        'post_type' => 'locations',
      ),
    ),
  );

  return $meta_boxes_locations;
}

add_filter('rwmb_meta_boxes', __NAMESPACE__.'\\meta_boxes_team');
function meta_boxes_team($meta_boxes_team)
{
  $meta_boxes_team[] = array(
    'title' => __('Zusätzliche Felder', 'klintwort-theme'),
    'post_types' => array(
      'team_member'
    ),
    'fields' => array(

      array(
        'id' => 'team_member_tipp',
        'name' => __('Mitarbeiter-Tipp', 'klintwort-theme'),
        'type' => 'textarea',
        'title' => __('Mitarbeiter-Tipp', 'klintwort-theme'),
        'post_types' => array(
          'team_member',
        ),

      ),
      array(
        'id' => 'team_member_tel',
        'name' => __('Mitarbeiter-Telefon-Nummer', 'klintwort-theme'),
        'type' => 'text',
        'title' => __('Mitarbeiter-Telefon-Nummer', 'klintwort-theme'),
        'post_types' => array(
          'team_member',
        ),

      ),
      array(
        'id' => 'team_member_email',
        'name' => __('Mitarbeiter-Email-Adresse', 'klintwort-theme'),
        'type' => 'text',
        'title' => __('Mitarbeiter-Email-Adresse', 'klintwort-theme'),
        'post_types' => array(
          'team_member',
        ),

      ),
      array(
        'id' => 'standort_id',
        'name' => __('Standort', 'klintwort-theme'),
        'type' => 'post',
        // Post type
        'post_type' => 'locations',
        // Field type, either 'select' or 'select_advanced' (default)
        'field_type' => 'select_advanced',
        'placeholder' => esc_html__('Bitte wählen', 'klintwort-theme'),
        // Query arguments (optional). No settings means get all published posts
        'query_args' => array(
          'post_status' => 'publish',
          'posts_per_page' => -1,
        ),

        )
        )
      );

      return $meta_boxes_team;
    }

    // Add Google Fonts
    function wpb_add_google_fonts()
    {
      wp_enqueue_style('wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,700,300', false);
    }
    add_action('wp_enqueue_scripts', __NAMESPACE__.'\\wpb_add_google_fonts');

    // Add the FaceBook

    function og_metatags()
    {
      global $post;
      if (!is_single()) {
        return;
      }

      /* Make necessary edits here **/
      $og_type_homepage = 'website'; //Content type of the homepage.
      $og_type = 'article'; //You can change this to use a different a content type if needed. Eg: profile.
      $fb_admin = 'ommo'; //Add your facebook ID between quotes.
      $app_id = '528817807262989'; //Enter your App ID here.
      ?>

      <meta property="og:url" content="<?php the_permalink();
      ?>"/>
      <meta property="og:title" content="<?php single_post_title('');
      ?>" />
      <meta property="og:type" content="<?php echo $og_type;
      ?>" />
      <meta property="og:site_name" content="<?php bloginfo();
      ?>" />
      <meta property="fb:admin" content="<?php echo trim($fb_admin);
      ?>" />
      <meta property="fb:app_id" content="<?php echo trim($app_id);
      ?>" />

      <?php

    }
    add_action('wp_head',  __NAMESPACE__.'\\og_metatags', 4);

    function the_slug($echo=true){
      $slug = basename(get_permalink());
      do_action('before_slug', $slug);
      $slug = apply_filters('slug_filter', $slug);
      if( $echo ) echo $slug;
      do_action('after_slug', $slug);
      return $slug;
    }
