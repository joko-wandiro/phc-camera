<?php
add_action('admin_menu', 'phc_camera_create_menu_settings');
function phc_camera_create_menu_settings(){
	$function= "phc_camera_settings_page";
	add_submenu_page('edit.php?post_type=' . PHC_CAMERA_POST_TYPE, 
	PHC_CAMERA_PAGE_TITLE_SETTINGS, PHC_CAMERA_MENU_TITLE_SETTINGS, 
	PHC_CAMERA_SUBMENU_CAPABILITY, PHC_CAMERA_MENU_SLUG_SETTINGS, 
	$function);
	
	add_action('admin_init', 'phc_camera_register_settings');
}

function phc_camera_register_settings(){
	register_setting('phc_camera_settings_page_vars', 
	'phc_camera_settings_vars');
}

function phc_camera_settings_page(){
	wp_enqueue_style(PHC_CAMERA_ID_SCRIPT . '_settings_css', 
	PHC_CAMERA_PATH_URL_CSS . "settings.css");
	wp_enqueue_script(PHC_CAMERA_ID_SCRIPT . '_settings_js', 
	PHC_CAMERA_PATH_URL . "js/settings/settings.js", array("jquery-ui-tabs"));
		
	if( !empty($_POST) ){
		update_option('phc_camera_settings_vars', 
		$_POST['phc_camera_settings_vars']);
		$camera= new PHC_Camera();
		$camera->fetch_and_regenerate_image();
	}
	$phc_camera_settings_vars= get_option('phc_camera_settings_vars');
	if( ! empty($phc_camera_settings_vars) ){
		extract($phc_camera_settings_vars);
	}
?>
	<div class="wrap" id="<?php echo PHC_CAMERA_IDENTIFIER; ?>">
	<?php screen_icon('generic'); ?>
	<h2><?php _e('Settings', PHC_CAMERA_IDENTIFIER); ?></h2>
	<form method="POST" action="">
	<div id="tabs">
	<ul>
	<li><a href="#tabs-image-size-post"><?php _ex("Image Size On Post / Page", "settings tab", 
	PHC_CAMERA_IDENTIFIER); ?></a></li>
	<li><a href="#tabs-image-size-widget"><?php _ex("Image Size On Widget", "settings tab", 
	PHC_CAMERA_IDENTIFIER); ?></a></li>
	</ul>
	<div id="tabs-image-size-post">
	<table class="form-table">
	<tr valign="top">
	    <th scope="row">
		<div>
		<?php _e("Small Image", PHC_CAMERA_IDENTIFIER); ?>
		</div>
		<div class="info">
		<?php echo "Default 100 x 75"; ?>
		</div>
		</th>
	    <td>
		<input type="text" name="phc_camera_settings_vars[post_small_width]" 
		value="<?php echo (isset($post_small_width)) ? $post_small_width : ""; ?>" 
		placeholder="<?php echo esc_attr_x("width", "placeholder", PHC_CAMERA_IDENTIFIER); ?>" />
		<span>x</span>
		<input type="text" name="phc_camera_settings_vars[post_small_height]" 
		value="<?php echo (isset($post_small_height)) ? $post_small_height : ""; ?>" 
		placeholder="<?php echo esc_attr_x("height", "placeholder", PHC_CAMERA_IDENTIFIER); ?>" />		
	   	</td>
   	</tr>
	<tr valign="top">
	    <th scope="row">
		<div>
		<?php _e("Large Image", PHC_CAMERA_IDENTIFIER); ?>
		</div>
		<div class="info">
		<?php echo "Default 960 x 480"; ?>
		</div>
		</th>
	    <td>
		<input type="text" name="phc_camera_settings_vars[post_large_width]" 
		value="<?php echo (isset($post_large_width)) ? $post_large_width : ""; ?>" 
		placeholder="<?php echo esc_attr_x("width", "placeholder", PHC_CAMERA_IDENTIFIER); ?>" />
		<span>x</span>
		<input type="text" name="phc_camera_settings_vars[post_large_height]" 
		value="<?php echo (isset($post_large_height)) ? $post_large_height : ""; ?>" 
		placeholder="<?php echo esc_attr_x("height", "placeholder", PHC_CAMERA_IDENTIFIER); ?>" />
	   	</td>
   	</tr>
	</table>	
	</div>
	<div id="tabs-image-size-widget">
	<table class="form-table">
	<tr valign="top">
	    <th scope="row">
		<div>
		<?php _e("Small Image", PHC_CAMERA_IDENTIFIER); ?>
		</div>
		<div class="info">
		<?php echo "Default 50 x 30"; ?>
		</div>
		</th>
	    <td>
		<input type="text" name="phc_camera_settings_vars[widget_small_width]" 
		value="<?php echo (isset($widget_small_width)) ? $widget_small_width : ""; ?>" 
		placeholder="<?php echo esc_attr_x("width", "placeholder", PHC_CAMERA_IDENTIFIER); ?>" />
		<span>x</span>
		<input type="text" name="phc_camera_settings_vars[widget_small_height]" 
		value="<?php echo (isset($widget_small_height)) ? $widget_small_height : ""; ?>" 
		placeholder="<?php echo esc_attr_x("height", "placeholder", PHC_CAMERA_IDENTIFIER); ?>" />
	   	</td>
   	</tr>
	<tr valign="top">
	    <th scope="row">
		<div>
		<?php _e("Large Image", PHC_CAMERA_IDENTIFIER); ?>
		</div>
		<div class="info">
		<?php echo "Default 240 x 120"; ?>
		</div>
		</th>
	    <td>
		<input type="text" name="phc_camera_settings_vars[widget_large_width]" 
		value="<?php echo (isset($widget_large_width)) ? $widget_large_width : ""; ?>" 
		placeholder="<?php echo esc_attr_x("width", "placeholder", PHC_CAMERA_IDENTIFIER); ?>" />
		<span>x</span>
		<input type="text" name="phc_camera_settings_vars[widget_large_height]" 
		value="<?php echo (isset($widget_large_height)) ? $widget_large_height : ""; ?>" 
		placeholder="<?php echo esc_attr_x("height", "placeholder", PHC_CAMERA_IDENTIFIER); ?>" />
	   	</td>
   	</tr>
	</table>
	</div>
	</div>
	<div class="btn-group-controls">
	<input type="submit" name="save" 
	value="<?php esc_attr_e("Save", PHC_CAMERA_IDENTIFIER); ?>" class="button-primary" />
	</div>
	</form>
	</div>
<?php
}
?>