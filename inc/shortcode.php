<?php
add_action('init', 'phc_camera_add_image_size');
function phc_camera_add_image_size(){
	if (function_exists('add_theme_support')) {
		$phc_camera_settings_vars= get_option('phc_camera_settings_vars');
	    add_theme_support('post-thumbnails');
		$default_image_size= array("post_small_width"=>"100", "post_small_height"=>"75", 
		"post_large_width"=>"960", "post_large_height"=>"480", "widget_small_width"=>"50", 
		"widget_small_height"=>"30", "widget_large_width"=>"240", "widget_large_height"=>"120");
		$phc_camera_settings_vars= (is_array($phc_camera_settings_vars)) ? 
		array_merge($default_image_size, $phc_camera_settings_vars) : $default_image_size;
		
		extract($phc_camera_settings_vars);
		add_image_size('phc-camera-post-small', $post_small_width, $post_small_height, 
		FALSE);
		add_image_size('phc-camera-post-large', $post_large_width, $post_large_height, 
		FALSE);
		add_image_size('phc-camera-widget-small', $widget_small_width, 
		$widget_small_height, FALSE);
		add_image_size('phc-camera-widget-large', $widget_large_width, 
		$widget_large_height, FALSE);
	}
}

add_shortcode('phc_camera', 'phc_camera_display');
function phc_camera_display($atts, $content=null){
	$default= array('id'=>"", 'type'=>"post");
	extract(shortcode_atts($default, $atts));
	$html= "";
	if( ! empty($id) ){
		$args= array();
		$args['post_id']= $id;
		$args['type']= $type;
		$camera_obj= new PHC_Camera($args);
		$html= $camera_obj->display();
	}
	
	return $html;
}

// Support Shortcode on Widget Text
add_filter('widget_text', 'phc_camera_widget_frontend_js');
function phc_camera_widget_frontend_js($text) {
    $pattern= get_shortcode_regex();
    if( isset($text) && preg_match_all( '/'. $pattern .'/s', $text, $matches )
        && array_key_exists( 2, $matches )
        && in_array( 'phc_camera', $matches[2] ) ){
		
		wp_enqueue_camera_scripts_for_frontend();
		
		// Hook Action to load javascripts and styles
		do_action('phc_camera_widget_load_scripts_and_styles');
		return do_shortcode($text);
    }else{
		return $text;
	}
}

// Enqueue the script, in the footer
add_action('wp', 'phc_camera_frontend_js');
function phc_camera_frontend_js() {
    global $post;
    $pattern= get_shortcode_regex();
    if( isset($post->post_content) && preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
        && array_key_exists( 2, $matches )
        && in_array( 'phc_camera', $matches[2] ) ){
		
		wp_enqueue_camera_scripts_for_frontend();
		
		// Hook Action to load javascripts and styles
		do_action('phc_camera_load_scripts_and_styles');
    }
}

// Load Required Script and Styles for Camera Jquery Plugin
function wp_enqueue_camera_scripts_for_frontend(){
	// Enqueue the Camera Scripts and Styles
	wp_enqueue_style(PHC_CAMERA_ID_SCRIPT . '_camera_css', 
	PHC_CAMERA_PATH_URL_CSS . "camera/camera.css");
	
	wp_enqueue_script(PHC_CAMERA_ID_SCRIPT . '_mobile_js', 
	PHC_CAMERA_PATH_URL_JS . "camera/jquery.mobile.customized.min.js", 
	array("jquery"), '', FALSE);
	wp_enqueue_script(PHC_CAMERA_ID_SCRIPT . '_easing_js', 
	PHC_CAMERA_PATH_URL_JS . "camera/jquery.easing.1.3.js", 
	array("jquery"), '', FALSE);
	wp_enqueue_script(PHC_CAMERA_ID_SCRIPT . '_camera_js', 
	PHC_CAMERA_PATH_URL_JS . "camera/camera.min.js", 
	array("jquery"), '', FALSE);
}

final class PHC_Camera {
	private $small_width;
	private $small_height;
	private $large_width;
	private $large_height;
	private $post_id;
	private $type;
	
	function __construct($args=array()){
		extract($args);
		foreach( $args as $key=>$item ){
			$this->$key= $item;
		}
	}
	
	function display(){
		ob_start();
		// Hook Action before init
		do_action('phc_camera_before_init');
		
		$args= array(
		'post_type'=>PHC_CAMERA_POST_TYPE,
		'p'=>$this->post_id
		);
		
		$query= new WP_Query($args);
		while( $query->have_posts() ){
			$query->the_post();
			$post= get_post();
			$custom= get_post_custom($post->ID);
			
			$meta_fields= array("image_url", "camera_caption", "camera_caption_effects", "camera_properties");
			$datas= array();
			foreach( $meta_fields as $field ){
				if( isset($custom[$field][0]) ){
				$$field= json_decode($custom[$field][0], TRUE);
				$datas[$field]= json_decode($custom[$field][0], TRUE);
				}
			}
			require(PHC_CAMERA_INCLUDE_PATH . "/theme.php");
		}
		wp_reset_postdata();
		// Hook Action after init
		do_action('phc_camera_after_init');
		$html = ob_get_contents();
		ob_clean();
		
		return $html;
	}
	
	function fetch_and_regenerate_image(){
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$args= array(
		'post_type'=>PHC_CAMERA_POST_TYPE,
		'posts_per_page'=>-1
		);
		$query= new WP_Query($args);
		while( $query->have_posts() ){
			$query->the_post();
			$post= get_post();
			$custom= get_post_custom($post->ID);
			$meta_fields= array("image_url", "camera_properties");
			$datas= array();
			foreach( $meta_fields as $field ){
				if( isset($custom[$field][0]) ){
				$$field= json_decode($custom[$field][0], TRUE);
				$datas[$field]= json_decode($custom[$field][0], TRUE);
				}
			}
			foreach( $image_url as $attachment_id ){
				$this->regenerate_image($attachment_id);
			}
		}
		wp_reset_postdata();
	}
	
	function regenerate_image($attachment_id=""){
		if( ! empty($attachment_id ) ){
			$attachment_path= get_attached_file($attachment_id);
			$metadata_attachment= wp_generate_attachment_metadata($attachment_id, $attachment_path);
			$msg= wp_update_attachment_metadata($attachment_id, $metadata_attachment);			
			return $msg;
		}		
	}
	
	function encode_camera_caption($str){
		$str= urlencode(htmlspecialchars($str, ENT_QUOTES));
		return $str;
	}
	
	function escape_camera_caption($str){
		$str= htmlspecialchars_decode(urldecode($str), ENT_QUOTES);
		$str= stripslashes($str);
		return $str;
	}
	
	function escape_camera_caption_for_form($str){
		$str= stripslashes(urldecode($str));
		return $str;
	}	
	
}

function stripslashes_if_gpc_magic_quotes( $string ) {
    if(get_magic_quotes_gpc()) {
        return stripslashes($string);
    } else {
        return $string;
    }
}
?>