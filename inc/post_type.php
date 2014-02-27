<?php
add_action('init', 'phc_camera_post_type');
// Registers post types. 
function phc_camera_post_type(){
	// Set Up Arguments
	$args= array(
	'public'=>TRUE,
	'exclude_from_search'=>FALSE,
	'publicly_queryable'=>FALSE,
	'show_ui'=>TRUE,
	'query_var'=>PHC_CAMERA_POST_TYPE,
	'rewrite'=>array(
		'slug'=>PHC_CAMERA_POST_TYPE,
		'with_front'=>false,
	),
	'supports'=>array(
		'title',
	),
	'menu_icon'=>PHC_CAMERA_IMG_URL . "icon_menu.png",
	'labels'=>array(
		'name'=>__('Camera', PHC_CAMERA_IDENTIFIER),
		'singular_name'=>__('Camera', PHC_CAMERA_IDENTIFIER),
		'add_new'=>__('Add New Slideshow', PHC_CAMERA_IDENTIFIER),
		'add_new_item'=>__('Add New Slideshow', PHC_CAMERA_IDENTIFIER),
		'edit_item'=>__('Edit Slideshow', PHC_CAMERA_IDENTIFIER),
		'new_item'=>__('New Slideshow', PHC_CAMERA_IDENTIFIER),
		'view_item'=>__('View Slideshow', PHC_CAMERA_IDENTIFIER),
		'search_items'=>__('Search Slideshow', PHC_CAMERA_IDENTIFIER),
		'not_found'=>__('No Slideshow Found', PHC_CAMERA_IDENTIFIER),
		'not_found_in_trash'=>__('No Slideshow Found In Trash', PHC_CAMERA_IDENTIFIER)
	),
	);
	
	// Register It
	register_post_type(PHC_CAMERA_POST_TYPE, $args);
}
?>