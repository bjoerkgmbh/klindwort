<?php function cptui_register_my_cpts() {

  /**
  * Post Type: Team-Mitglieder.
  */

  $labels = array(
    "name" => __( 'Team-Mitglieder', 'sage' ),
    "singular_name" => __( 'Team-Mitglied', 'sage' ),
    "menu_name" => __( 'Team', 'sage' ),
  );

  $args = array(
    "label" => __( 'Team-Mitglieder', 'sage' ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => false,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "team_member", "with_front" => true ),
    "query_var" => true,
    "supports" => array( "title", "editor", "thumbnail" ),
  );

  register_post_type( "team_member", $args );

  /**
  * Post Type: Jobs.
  */

  $labels = array(
    "name" => __( 'Jobs', 'sage' ),
    "singular_name" => __( 'Job', 'sage' ),
  );

  $args = array(
    "label" => __( 'Jobs', 'sage' ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => false,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "job_offers", "with_front" => true ),
    "query_var" => true,
    "supports" => array( "title", "editor", "thumbnail" ),
  );

  register_post_type( "job_offers", $args );

  /**
  * Post Type: Filialen.
  */

  $labels = array(
    "name" => __( 'Filialen', 'sage' ),
    "singular_name" => __( 'Filiale', 'sage' ),
  );

  $args = array(
    "label" => __( 'Filialen', 'sage' ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => false,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "filiale", "with_front" => true ),
    "query_var" => true,
    "supports" => array( "title", "editor", "thumbnail" ),
  );

  register_post_type( "locations", $args );

  /**
  * Post Type: Topbar.
  */

  $labels = array(
    "name" => __( 'Topbar', 'sage' ),
    "singular_name" => __( 'Topbar', 'sage' ),
    "menu_name" => __( 'TopBar', 'sage' ),
  );

  $args = array(
    "label" => __( 'Topbar', 'sage' ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => false,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "page",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "topbar", "with_front" => true ),
    "query_var" => true,
    "menu_position" => 5,
    "supports" => array( "title", "editor", "thumbnail" ),
  );

  register_post_type( "topbar", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );

function cptui_register_my_cpts_tipps() {

	/**
	 * Post Type: Tipps.
	 */

	$labels = array(
		"name" => __( 'Tipps', 'sage' ),
		"singular_name" => __( 'Tipp', 'sage' ),
	);

	$args = array(
		"label" => __( 'Tipps', 'sage' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "tipps", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "editor", "thumbnail" ),
		"taxonomies" => array( "tipp" ),
	);

	register_post_type( "tipps", $args );
}

add_action( 'init', 'cptui_register_my_cpts_tipps' );

?>
