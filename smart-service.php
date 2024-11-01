<?php
/*
Plugin Name: Smart Service
Plugin URI: 
Description: Service box is totally responsive. It’s beautifully manage your website service showcase. Based on Bootstrap and implemented with latest Font Awesome library.
Version: 1.0
Author: Faisal Khan
Author URI: https://www.facebook.com/Faisal.01716
License: GPLv2 or later
Text Domain: smart-service
Domain Path: /languages/
*/

// Exit if accessed directly
if( ! defined( 'ABSPATH' )){
	exit;
}

// Define
define( 'SMART_SERVICE_ACC_URL', WP_PLUGIN_URL . '/' . plugin_basename(dirname( __FILE__ )) . '/' );
define( 'SMART_SERVICE_ACC_PATH', plugin_dir_path( __FILE__ ) );

function smart_service_load_textdomain() {
	load_plugin_textdomain( 'smart-service', false, dirname( __FILE__ ) . "/languages" );
}
add_action( 'plugins_loaded', 'smart_service_load_textdomain' );

function smart_service_load_load_front_assets() {

    wp_enqueue_style('smart-main-css', plugin_dir_url( __FILE__ ) . 'assets/public/css/main.css',null,time() );

    wp_enqueue_style('smart-bootstrap', plugin_dir_url( __FILE__ ) . 'assets/public/css/bootstrap.min.css',null,time() );

    wp_enqueue_style('fontawsome', plugin_dir_url( __FILE__ ) . 'assets/public/css/font-awesome/css/font-awesome.min.css',null,time() );

    wp_enqueue_script( 'smart-boostrap-js', plugin_dir_url( __FILE__ ) . 'assets/public/js/bootstrap.min.js', array( 'jquery' ), '3.0', true );

	wp_enqueue_script( 'smart-main-js', plugin_dir_url( __FILE__ ) . 'assets/public/js/min.js', array( 'jquery' ), time(), true );
	
           
}
add_action( 'wp_enqueue_scripts','smart_service_load_load_front_assets' );

function smart_service_add_color_picker() {
	wp_enqueue_style('smart-main-css', plugin_dir_url( __FILE__ ) . 'assets/admin/css/main.css',null,time() );
    wp_enqueue_style( 'wp-color-picker' ); 
    wp_enqueue_script( 'custom-script-handle', plugins_url( 'assets/admin/js/main.js', __FILE__ ), array( 'wp-color-picker' ), false, true );    
}
add_action( 'admin_enqueue_scripts', 'smart_service_add_color_picker' );

	
    // Register Custom Post Type
function smart_service_register_cpt() {

	$labels = array(
		'name'                  => _x( 'Service', 'Post Type General Name', 'mark-componian' ),
		'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'mark-componian' ),
		'menu_name'             => __( 'Service', 'mark-componian' ),
		'name_admin_bar'        => __( 'Service', 'mark-componian' ),
		'archives'              => __( 'Item Archives', 'mark-componian' ),
		'attributes'            => __( 'Item Attributes', 'mark-componian' ),
		'parent_item_colon'     => __( 'Parent Item:', 'mark-componian' ),
		'all_items'             => __( 'All Service', 'mark-componian' ),
		'add_new_item'          => __( 'Add New Service', 'mark-componian' ),
		'add_new'               => __( 'Add New', 'mark-componian' ),
		'new_item'              => __( 'New Service', 'mark-componian' ),
		'edit_item'             => __( 'Edit Service', 'mark-componian' ),
		'update_item'           => __( 'Update Service', 'mark-componian' ),
		'view_item'             => __( 'View Service', 'mark-componian' ),
		'view_items'            => __( 'View Service', 'mark-componian' ),
		'search_items'          => __( 'Search Service', 'mark-componian' ),
		'not_found'             => __( 'Not found', 'mark-componian' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'mark-componian' ),
		'featured_image'        => __( 'Service Image', 'mark-componian' ),
		'set_featured_image'    => __( 'Set Service image', 'mark-componian' ),
		'remove_featured_image' => __( 'Remove Service image', 'mark-componian' ),
		'use_featured_image'    => __( 'Use as Service image', 'mark-componian' ),
		'insert_into_item'      => __( 'Insert into item', 'mark-componian' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'mark-componian' ),
		'items_list'            => __( 'Items list', 'mark-componian' ),
		'items_list_navigation' => __( 'Items list navigation', 'mark-componian' ),
		'filter_items_list'     => __( 'Filter items list', 'mark-componian' ),
	);
	$args = array(
		'label'                 => __( 'Service', 'mark-componian' ),
		'description'           => __( 'Service Description', 'mark-componian' ),
		'labels'                => $labels,
		'supports'              => array( 'title','editor' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'service', $args );

}
add_action( 'init', 'smart_service_register_cpt', 0 );


// Theme shortcode
require_once( SMART_SERVICE_ACC_PATH . 'plugin-shortcode/service-shortcode.php' );
require_once( SMART_SERVICE_ACC_PATH . 'inc/smart-metabox.php' );
//require_once( SMART_SERVICE_ACC_PATH . 'inc/custom-style.php' );

function smart_service_coldemo_post_columns( $columns ) {
	print_r( $columns );
	unset( $columns['tags'] );
	unset( $columns['comments'] );
	/*unset($columns['author']);
	unset($columns['date']);
	$columns['author']="Author";
	$columns['date']="Date";*/
	$columns['id']        = __( 'Post ID', 'column-demo' );
	$columns['wordcount'] = __( 'Word Count', 'column-demo' );

	return $columns;
}

add_filter( 'manage_service_posts_columns', 'smart_service_coldemo_post_columns' );

function smart_service_coldemo_post_column_data( $column, $post_id ) {
	if ( 'id' == $column ) {
		echo $post_id;
	} elseif ( 'wordcount' == $column ) {
		/*$_post = get_post($post_id);
		$content = $_post->post_content;
		$wordn = str_word_count(strip_tags($content));*/
		$wordn = get_post_meta( $post_id, 'wordn', true );
		echo $wordn;
	}
}

add_action( 'manage_service_posts_custom_column', 'smart_service_coldemo_post_column_data', 10, 2 );

function smart_service_coldemo_sortable_column( $columns ) {
	$columns['wordcount'] = 'wordn';

	return $columns;
}

add_filter( 'manage_edit-service_sortable_columns', 'smart_service_coldemo_sortable_column' );

/*function coldemo_set_word_count() {
	$_posts = get_posts( array(
		'posts_per_page' => - 1,
		'post_type'      => 'post',
		'post_status'    => 'any'
	) );

	foreach ( $_posts as $p ) {
		$content = $p->post_content;
		$wordn   = str_word_count( strip_tags( $content ) );
		update_post_meta( $p->ID, 'wordn', $wordn );
	}
}

add_action( 'init', 'coldemo_set_word_count' );*/

function smart_service_coldemo_sort_column_data( $wpquery ) {
	if ( ! is_admin() ) {
		return;
	}

	$orderby = $wpquery->get( 'orderby' );
	if ( 'wordn' == $orderby ) {
		$wpquery->set( 'meta_key', 'wordn' );
		$wpquery->set( 'orderby', 'meta_value_num' );
	}
}

add_action( 'pre_get_posts', 'smart_service_coldemo_sort_column_data' );

function smart_service_coldemo_update_wordcount_on_post_save($post_id){
	$p = get_post($post_id);
	$content = $p->post_content;
	$wordn   = str_word_count( strip_tags( $content ) );
	update_post_meta( $p->ID, 'wordn', $wordn );
}
add_action('save_post','smart_service_coldemo_update_wordcount_on_post_save');


function smart_service_register_my_custom_submenu_page() {
  add_submenu_page( 'edit.php?post_type=service', __('Service Shortcode','smart-service'), __('Service Shortcode','smart-service'), 'manage_options', 'my-custom-submenu-page', 'smart_service_submenu_page_callback' ); 
}
function smart_service_submenu_page_callback() {
    echo '<div class="wrap smart"><div id="icon-tools" class="icon32"></div>';
        echo __('<h2>Service Shortcode<h2>','smart-service');
        echo __('<p>Use below shortcode in any Page/Post to publish your FAQ<p>','smart-service');
		echo '<h2 class="smart-scode"><input readonly="readonly" type="text" value="[smart-service]"/></h2>';
	echo '</div>';
}

add_action('admin_menu', 'smart_service_register_my_custom_submenu_page');