<?php

/** minimal template **/

/**
 * Set the content width.
 *
 * @since Watford Palace 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 730;
}

if ( ! function_exists( 'watfordpalace_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Watford Palace 1.0
 */
function watfordpalace_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		// 'primary'	=> __( 'Primary Menu',      'watfordpalace' ),
		'primary'	=> __( 'Primary Menu',    'watfordpalace' ),
		'secondary'	=> __( 'Footer Menu',	'watfordpalace' ),
		'social'	=> __( 'Social Links Menu', 'watfordpalace' ),
		'sitemap'	=> __( 'Sitemap Page', 'watfordpalace' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	// add_theme_support( 'post-formats', array(
		// 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	// ) );
}
endif; // watfordpalace_setup

add_action( 'after_setup_theme', 'watfordpalace_setup' );

function watfordpalace_scripts() {

	// Load our main stylesheet.
	// wp_enqueue_style( 'watfordpalace-style', get_stylesheet_uri() );
	wp_enqueue_style( 'watfordpalace-style', get_stylesheet_directory_uri() .'/style.css', array(), '20210609-1' );

//	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
//		wp_enqueue_script( 'comment-reply' );
//	}

}
add_action( 'wp_enqueue_scripts', 'watfordpalace_scripts' );


add_filter('default_page_template_title', function() {
    return __('Default (2 Column page)', 'your_text_domain');
});


/**
 * Custom template tags for this theme.
 *
 * @since Watford Palace 1.0
 */
require get_template_directory() . '/inc/template-tags.php';


/* kriesi pagination */

function kriesi_pagination($pages = '', $range = 2){
	$range = 3;
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == ''){
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)	{
			$pages = 1;
		}
	}

	if(1 != $pages){
		echo '<div class="pagination">';
		if($paged > 2 && $paged > $range+1 && $showitems < $pages){
			echo '<a href="'.get_pagenum_link(1).'" class="pagepn page-first">&laquo;</a>';
		}else{
			echo '<a href="'.get_pagenum_link(1).'" class="pagepn page-first inactive">&laquo;</a>';
		}
		if($paged > 1 && $showitems < $pages){
			echo '<a href="'.get_pagenum_link($paged - 1).'" class="pagepn page-prev">&lsaquo;</a>';
		}else{
			echo '<a href="'.get_pagenum_link($paged - 1).'" class="pagepn page-prev inactive">&lsaquo;</a>';
		}

		for ($i=1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
				echo ($paged == $i)? '<span class="page-numbers current">'.$i.'</span>':'<a href="'.get_pagenum_link($i).'" class="page-numbers">'.$i.'</a>';
			}
		}

		if ($paged < $pages && $showitems < $pages){
			echo '<a href="'.get_pagenum_link($paged + 1).'" class="pagepn page-next">&rsaquo;</a>';
		}else{
			echo '<a href="'.get_pagenum_link($paged + 1).'" class="pagepn page-next inactive">&rsaquo;</a>';
		}
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages){
			echo '<a href="'.get_pagenum_link($pages).'" class="pagepn page-last">&raquo;</a>';
		}else{
			echo '<a href="'.get_pagenum_link($pages).'" class="pagepn page-last inactive">&raquo;</a>';
		}
		echo '</div>';
		echo "\n";
	}
}

add_action( 'init', 'create_post_type' );

function create_post_type() {
	register_post_type( 'wpt_event',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' ),
				'add_new' => _x('Add New', 'Event'),
				'add_new_item' => __('Add New Event'),
				'edit_item' => __('Edit Event'),
				'new_item' => __('New Event'),
				'all_items' => __('All Events'),
				'view_item' => __('View Event'),
				'search_items' => __('Search Events'),
				'not_found' =>  __('No Events found'),
				'not_found_in_trash' => __('No Events found in Trash'),
				'parent_item_colon' => '',
				'menu_name' => 'Events'
			),
		'public' => true,
		// 'has_archive' => 'whats-on',
		'has_archive' => false,
		'menu_position' => 5,
		'supports' => array('title','author'),
		'taxonomies' => array('wpt_event_category'),
		'rewrite' => array('slug' => 'events','ep_mask' => EP_YEAR)
		)
	);
}

register_taxonomy(
	'wpt_event_category',
	array(
		'wpt_event'
	),
	array(
		// for category format:
		'hierarchical' => true,
		// for tag format:
		// 'hierarchical' => false,
		// 'update_count_callback' => '_update_post_term_count',
		// for all:
		'labels' => array(
			'name' => _x( 'Event Category', 'taxonomy general name' ),
			'singular_name' => _x( 'Event Category', 'taxonomy singular name' ),
			'add_new_item' => __( 'Add New Event Category' ),
		),
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => Array('slug' => 'event_category'),
	)
);

/*
add_filter( 'manage_edit-wpt_event_columns', 'my_edit_wpt_event_columns' ) ;

function my_edit_wpt_event_columns( $columns ) {

	//$columns = array(
	//	'cb' => '<input type="checkbox" />',
	//	'title' => __( 'Title' ),
	//	'my_column'	=> __( 'My Column' ),
	//	'date' => __( 'Date added' )
	//);

	// OR:
	// to only add rather than replace:
	$columns['my_column'] = 'My Column';


	return $columns;
}

// add_action( 'manage_wpt_event_posts_custom_column', 'my_manage_wpt_event_columns', 10, 2 );
add_action( 'manage_wpt_event_posts_custom_column', 'my_manage_wpt_event_columns', 1, 2 );

function my_manage_wpt_event_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'my_column' :
			$mycolumn = get_field('my_column',$post_id);
			if ( empty( $mycolumn ) ){
				echo __( '--' );
			}else{
				echo $mycolumn;
			}
			break;
		default :
			break;
	}
}
*/


/*-----------------
change excerpt size
-------------------*/
function custom_excerpt_length( $length ) {
    $newLength = 16;
    return $newLength;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function the_excerpt_more($more) {
// removing the read more link, as the whole block will be linked
    global $post;
    return ' &hellip;';
}
add_filter('excerpt_more', 'the_excerpt_more');


/*-------------------------------------
  Move Yoast to the Bottom
---------------------------------------*/
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');


if ( function_exists( 'add_image_size' ) ) {
	// based on 2560 window width with 28px paddings all around and in between
	// 28 + 1238 + 28 + 605 + 28 + 605 + 28 = 2560
	// 28 + 816 + 28 + 816 + 28 + 816 + 28 = 2560
	add_image_size( 'full-width-free-height', 2504, 9999, false);
	add_image_size( 'half-width-free-height', 1238, 9999, false);
	add_image_size( 'full-width-horizontal', 2504, 1390, true);
	add_image_size( 'half-width-square', 1238, 1238 , true);
	add_image_size( 'third-width-vertical', 816, 1156, true);
	add_image_size( 'quarter-width-horizontal', 605, 425, true);
	add_image_size( 'quarter-width-square', 605, 605, true);
	add_image_size( 'bio-portrait', 413, 650, true);
	add_image_size( 'footer-logo', 300, 64, false);
}


/*---------------
  remove the 2560 scaling thing (because it means we can't pick the 2880px wide image from the media library, even though it works when uploading it)
-----------------*/
add_filter( 'big_image_size_threshold', '__return_false' );

/**
 * Functions for Spektrix Integration
 */
require get_template_directory() . '/inc/spektrix.php';


/* testing something */

function my_acf_settings_capability( $path ) {
    return 'administrator';
}
add_filter('acf/settings/capability', 'my_acf_settings_capability');
