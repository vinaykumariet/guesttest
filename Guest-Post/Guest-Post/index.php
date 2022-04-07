<?php
/*
Plugin Name: Guest Post
Plugin URI: https://www.google.com/
Description: Guest Post Pages.
Author: Bluevintech
Version: 1.0
Author URI: https://bluevintech.com/
*/
define('GUEST_VERSION', '1.0');
define('GUEST_URL', plugin_dir_url( __FILE__ ));
include_once( dirname(__FILE__) . '/shortcodes.php');

/* Create Guest Post type in admin*/
add_action( 'init', 'register_guest_posttype' );
function register_guest_posttype() {
	$labels = array(
		'name'               => _x( 'Guest Post', 'post type general name', 'guest-Guest' ),
		'singular_name'      => _x( 'Guest Post', 'post type singular name', 'guest-Guest' ),
		'menu_name'          => _x( 'Guest Post', 'admin menu', 'guest-Guest' ),
		'name_admin_bar'     => _x( 'Guest Post', 'add new on admin bar', 'guest-Guest' ),
		'add_new'            => _x( 'Add New', 'Guest', 'guest-Guest' ),
		'add_new_item'       => __( 'Add New Guest', 'guest-Guest' ),
		'new_item'           => __( 'New Post', 'guest-Guest' ),
		'edit_item'          => __( 'Edit Post', 'guest-Guest' ),
		'view_item'          => __( 'View Post', 'guest-Guest' ),
		'all_items'          => __( 'Posts', 'guest-Guest' ),
		'search_items'       => __( 'Search Post', 'guest-Guest' ),
		'parent_item_colon'  => __( 'Parent Post:', 'guest-Guest' ),
		'not_found'          => __( 'No Post found.', 'guest-Guest' ),
		'not_found_in_trash' => __( 'No Post found in Trash.', 'guest-Guest' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Add Post here.', 'guest-Guest' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => 20,
		'rewrite'            => array('slug' => 'Guest'),
		'supports'           => array( 'title','thumbnail','editor' )
	);

	register_post_type( 'Guest', $args );
}


/* Save Guest post in DB*/
add_action('init', 'save_data');
function save_data(){
	$user_ID = get_current_user_id(); 
	if(isset( $_POST['my_image_upload_nonce'])){
		global $wbdb;
		$post_id = wp_insert_post(array (
		'post_type' => 'guest',
		'post_title' => $_POST['title'],
		'post_content' => $_POST['descriptioon'],
		 'post_author' => $user_ID,
		'post_status' => 'pending',
	));
		
if(!empty($_FILES["test"]["name"])){
$uploaddir = wp_upload_dir();
$file = $_FILES["test"]["name"];
$uploadfile = $uploaddir['path'] . '/' . basename( $file );
move_uploaded_file( $_FILES["test"]["tmp_name"] , $uploadfile );
$filename = basename( $uploadfile );
$wp_filetype = wp_check_filetype(basename($filename), null );
$attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
    'post_content' => '',
    'post_status' => 'inherit',
    'menu_order' => $_i + 1000
);
$attach_id = wp_insert_attachment( $attachment, $uploadfile );
set_post_thumbnail( $post_id, $attach_id ); 
}		

}
}





