<?php
add_action('admin_menu', 'phc_camera_create_menu_documentation');
function phc_camera_create_menu_documentation(){
	global $wp_scripts;
	
	$function= "phc_camera_documentation_page";
	add_submenu_page('edit.php?post_type=' . PHC_CAMERA_POST_TYPE, 
	PHC_CAMERA_PAGE_TITLE_DOCUMENTATION, PHC_CAMERA_MENU_TITLE_DOCUMENTATION, 
	PHC_CAMERA_SUBMENU_CAPABILITY, PHC_CAMERA_MENU_SLUG_DOCUMENTATION, $function);
}

function phc_camera_documentation_page(){
	wp_enqueue_style(PHC_CAMERA_ID_SCRIPT . '_documentation_css', 
	PHC_CAMERA_PATH_URL_CSS . "documentation.css");
	wp_enqueue_script(PHC_CAMERA_ID_SCRIPT . '_documentation_js', 
	PHC_CAMERA_PATH_URL . "js/documentation/documentation.js", array("jquery-ui-tabs"));
?>
	<div class="wrap" id="<?php echo PHC_CAMERA_IDENTIFIER; ?>">
	<!-- Start Banner -->
	<ul id="banners">
	<li><a href="#url"><img src="<?php echo PHC_CAMERA_IMAGES_BANNER . "banner_donation.png"; ?>" /></a></li>
	<li class="or"><img src="<?php echo PHC_CAMERA_IMAGES_BANNER . "banner_or.png"; ?>" /></li>
	<li><a href="#url"><img src="<?php echo PHC_CAMERA_IMAGES_BANNER . "banner_opencart.png"; ?>" /></a></li>
	</ul>
	<!-- End Banner -->
	
	<?php screen_icon('page'); ?>
	<h2><?php _e("Documentation", PHC_CAMERA_IDENTIFIER); ?></h2>
	<div id="tabs">
	<ul>
	<li><a href="#tabs-how-to-use"><?php _e("How to Use", PHC_CAMERA_IDENTIFIER); ?></a></li>
	<li><a href="#tabs-settings-page"><?php _e("Settings Page", PHC_CAMERA_IDENTIFIER); ?></a></li>	
	<li><a href="#tabs-available-hooks"><?php _e("Available Hooks", PHC_CAMERA_IDENTIFIER); ?></a></li>
	<li><a href="#tabs-translation"><?php _e("Translation", PHC_CAMERA_IDENTIFIER); ?></a></li>
	</ul>
	<div id="tabs-how-to-use">
	<h2><?php _e("Add Camera into post/page.", PHC_CAMERA_IDENTIFIER); ?></h2>
	<ul>
	<li>
	<p><?php _e("Goto Camera &gt; Add New Slideshow.", PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><?php _e("Enter Title. Ex: Camera Slider.", PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step1.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Click Camera Slideshow Accordion to set images for slideshow. Click New Image to add image for Camera.", PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step2.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Click Image 1 to display content. Click Select Image to show Media Uploader.", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step3.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Upload images on Upload Files Tab. Then click Select Files button. Select images which you want to upload. If you've already upload your images. Click on Media Library Tab then select the image", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step4.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Set Caption for the image, you can input it with Text, HTML, also Video. See the following images:", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step5.png"; ?>" class="auto" />
	</p>
	</li>
	<li>
	<p><?php _e("Set caption effects for the caption from the selectbox.", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	</p>
	</li>	
	<li>
	<p><?php _e("Do step 3 - step 7 to add image for the Slideshow.", PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><?php _e("Set Camera Properties for the Slideshow. For Example change thumbnail to true so the thumbnail is shown.", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step6.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Click Publish Button.", PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><?php _e("Goto Camera to view all of your Slideshow. You can add it into your post or page, just copy shortcode syntax for post / page on Shortcode column. Then you will get your Camera on your post / page.", PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step7.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Goto Posts &gt; All Posts. Then click edit on specific post. You can create new post / page later, I use edit post just for example.", PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step8.png"; ?>" />
	</p>
	</li>	
	<li>
	<p><?php _e("Add Camera shortcode like the following image.", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step9.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Click Update. Then click View Post button to check Camera Slider is shown on your post. You should see display of the post like the following image.", PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step10.png"; ?>" />
	</p>	
	</li>
	</ul>
	<h2><?php _e("Add Camera into widget.", PHC_CAMERA_IDENTIFIER); ?></h2>
	<ul>
	<li>
	<p><?php _e("Goto Appearance &gt; Widgets.", PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><?php _e("Use Widget Text. Enter Title. Ex: Camera Widget. Then add shortcode for widget into content / textarea.", PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step11.png"; ?>" 
	class="step11" />
	</p>
	</li>
	<li>
	<p><?php _e("Click Save Button.", PHC_CAMERA_IDENTIFIER); ?></p>
	</li>	
	<li>
	<p><?php _e("You will see the following display on your Homepage now.", PHC_CAMERA_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step12.png"; ?>" 
	class="step11" />
	</p>
	</li>
	</ul>
	<h2><?php _e("Add Camera into PHP file.", PHC_CAMERA_IDENTIFIER); ?></h2>
	<ul>
	<li>
	<p><?php _e("You can do it with do_shortcode syntax.", PHC_CAMERA_IDENTIFIER); ?></p>
	<?php
	$shortcode_syntax= ": <code>&lt;?php echo do_shortcode('shortcode_syntax'); ?&gt;</code>";
	?>
	<p><?php printf(__('Syntax %1$s. You can get shortcode syntax on Camera Slider Page.', PHC_CAMERA_IDENTIFIER), 
	$shortcode_syntax); ?></p>
	<p><?php _e("Example", PHC_CAMERA_IDENTIFIER); ?>:</p>
	<p><code>&lt;?php echo do_shortcode('[phc_camera id="110"]'); ?&gt;</code></p>
	<p><code>&lt;?php echo do_shortcode('[phc_camera id="110" type="widget"]'); ?&gt;</code></p>
	</li>
	</ul>
	</div>
	<div id="tabs-settings-page">
	<ul>
	<li>
	<p><?php _e("Goto Camera &gt; Settings.", PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><?php _e("You can set image size for Camera on Post / Page and Widget. It make performance better. Set it with numeric value for small and large image.", PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	</ul>
	</div>
	<div id="tabs-available-hooks">
	<h2><?php _e("Hooks Action", PHC_CAMERA_IDENTIFIER); ?></h2>
	<ul>
	<li>
	<p><code>phc_camera_widget_load_scripts_and_styles</code></p>
	<p><?php _e("You can use it to load more javascripts and styles for Camera Slider on Widget.", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><code>phc_camera_load_scripts_and_styles</code></p>
	<p><?php _e("You can use it to load more javascripts and styles for Camera Slider on Post / Page.", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	</li>	
	<li>
	<p><code>phc_camera_before_init</code></p>
	<p><?php _e("You can use it to do any functionality before Camera Slider sripts run", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><code>phc_camera_after_init</code></p>
	<p><?php _e("You can use it to do any functionality after Camera Slider sripts run", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	</ul>
	<h2><?php _e("Hooks Filter", PHC_CAMERA_IDENTIFIER); ?></h2>
	<ul>
	<li>
	<p><code>phc_camera_properties</code></p>
	<p><?php _e("You can use it to modify Camera Properties. Parameter contain Camera Properties", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><?php _e("Example", PHC_CAMERA_IDENTIFIER); ?>:</p>
	<p><code>&lt;?php<br />
    // Start Sample Hooks Action and Filter for Camera Jquery Plugin <br />
    add_action("phc_camera_load_scripts_and_styles", "custom_phc_camera_load_scripts_and_styles"); <br />
    function custom_phc_camera_load_scripts_and_styles(){ <br />
            wp_enqueue_style('style_css', PHANTASMACODE_MARIANIAC_THEME_TEMP_URL.'camera_new_skin_for_widget.css', FALSE); <br />
    }<br />
	<br />
    add_action("phc_camera_widget_load_scripts_and_styles", "custom_phc_camera_widget_load_scripts_and_styles");<br />
    function custom_phc_camera_widget_load_scripts_and_styles(){<br />
            wp_enqueue_style('style_css', PHANTASMACODE_MARIANIAC_THEME_TEMP_URL.'camera_new_skin.css', FALSE);<br />
    }<br />
   <br />
    add_action("phc_camera_before_init", "custom_phc_camera_before_init");<br />
    function custom_phc_camera_before_init(){<br />
			echo "&lt;p&gt;custom_phc_camera_before_init&lt;/p&gt;";<br />
    }<br />
	<br />
    add_action("phc_camera_after_init", "custom_phc_camera_after_init");<br />
    function custom_phc_camera_after_init(){<br />
            echo "&lt;p&gt;custom_phc_camera_after_init&lt;/p&gt;";<br />
    }<br />
	<br />
    add_filter("phc_camera_properties", "custom_phc_camera_properties", 10, 3);<br />
    function custom_phc_camera_properties($camera_properties, $post, $type){<br />
            if( $type == "widget" ){<br />
                    $camera_properties['thumbnails']= 'false';<br />
            }<br />
            return $camera_properties;<br />
    }<br />
    // End Sample Hooks Action and Filter for Camera Jquery Plugin<br />
	?&gt;</code></p>
	</li>
	</ul>
	</div>
	<div id="tabs-translation">
	<ul>
	<li>
	<p><?php _e("Help me to Translate it. I provide POT file on languages folder. You can use translation application such as POEdit and translate it to your locale language and save it into PO file and MO file", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	<p><?php _e("You can contribute to make it bigger with your support guys !", 
	PHC_CAMERA_IDENTIFIER); ?></p>
	</li>
	</ul>
	</div>	
	</div>
	</div>
<?php
}
?>