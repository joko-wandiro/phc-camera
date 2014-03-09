<?php
// Start Add Meta Box
add_action("do_meta_boxes", "phc_camera_add_meta");
function phc_camera_add_meta(){
	global $wp_meta_boxes;

	add_meta_box(PHC_CAMERA_IDENTIFIER . "meta", 
	PHC_CAMERA_NAME . " Slideshow", "phc_camera_meta_options", 
	PHC_CAMERA_POST_TYPE, "normal", "high");
	
	add_meta_box(PHC_CAMERA_IDENTIFIER . "meta_extra", 
	PHC_CAMERA_NAME . " Properties", "phc_camera_side_options", 
	PHC_CAMERA_POST_TYPE, "normal", "high");
	
//	add_meta_box(PHC_CAMERA_IDENTIFIER . "side", 
//	PHC_CAMERA_NAME . " Properties", "phc_camera_side_options", 
//	PHC_CAMERA_POST_TYPE, "side", "low");
}

function phc_camera_meta_options($post, $metabox){
	global $post, $wp_scripts, $wp_meta_boxes, $hook_suffix;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	
	$custom= get_post_custom($post->ID);
	$meta_fields= array("image_url", "camera_caption", "camera_caption_effects");
	$datas= array();
	foreach( $meta_fields as $field ){
		if( isset($custom[$field][0]) ){
			if( $field == "camera_caption" ){
				$phc_camera_obj= new PHC_Camera();
				$custom[$field][0]= $phc_camera_obj->escape_camera_caption_for_form($custom[$field][0]);
			}
			$$field= json_decode($custom[$field][0], TRUE);
			$datas[$field]= json_decode($custom[$field][0], TRUE);
		}
	}
	
	$num_section= isset($image_url) ? count($image_url) : "";
	wp_enqueue_style(PHC_CAMERA_ID_SCRIPT . '_post_css', 
	PHC_CAMERA_PATH_URL_CSS . "post.css");
	
	$caption_effects= array('moveFromLeft', 'moveFomRight', 'moveFromTop', 'moveFromBottom', 'fadeIn', 'fadeFromLeft', 
	'fadeFromRight', 'fadeFromTop', 'fadeFromBottom');
?>
<div id="camera-extras" class="meta-box-wrapper" data-post-id="<?php echo $post->ID; ?>">
	<div>
	<button type="button" id="btn-new-image" class="button-primary">
	<?php _e("New Image", PHC_CAMERA_IDENTIFIER); ?></button>
	</div>
	<!-- Start Camera Element -->
	<div class="group widget template-camera-form">
	<div class="btn-icon-header phc-icon-delete" 
	title="<?php _e("Delete", PHC_CAMERA_IDENTIFIER); ?>">
	<button class="button-secondary btn-remove-image" type="button">
	<?php _e("Remove", PHC_CAMERA_IDENTIFIER); ?></button>
	</div>
	<h3 class="hndle">
	<span><?php _e("Image", PHC_CAMERA_IDENTIFIER); ?> {image_number}</span>
	</h3>
	<div class="camera-section">
		<div class="camera-image">
		<img src="<?php echo PHC_CAMERA_IMG_URL . "no_image.jpg"; ?>" alt="No Image" />
		</div>	
		<div>
		<input type="hidden" name="image_url[]" value="" disabled="" />
		<input type="button" 
		value="<?php esc_attr_e("Select Image", PHC_CAMERA_IDENTIFIER); ?>" 
		class="upload_image_button button-secondary" disabled="" />
		</div>
		<div>
		<label for="camera_caption[]"><?php _e("Caption Text / HTML / Videos", PHC_CAMERA_IDENTIFIER); ?>: </label>
		<textarea id="camera_caption[]" name="camera_caption[]" cols="10" rows="10" disabled=""></textarea>
		</div>
		<div>
		<label for="camera_caption_effects[]"><?php _e("Caption Effects", PHC_CAMERA_IDENTIFIER); ?>: </label>
		<select name="camera_caption_effects[]" id="camera_caption_effects[]" disabled="">
		<?php
		foreach( $caption_effects as $item ){
		?>
		<option value="<?php echo $item; ?>"><?php echo $item; ?></option>
		<?php
		}
		?>
		</select>
		</div>
	</div>
	</div>
	<!-- End Camera Element -->
	
	<div id="camera-accordion">
	<?php
	if( !empty($num_section) ){
	for( $ct=0; $ct<$num_section; $ct++ ){
		$image_number= $ct+1;
		
	?>
		<div class="group widget" data-image-number="<?php echo $image_number; ?>">
		<div class="btn-icon-header phc-icon-delete" 
		title="<?php _e("Delete", PHC_CAMERA_IDENTIFIER); ?>">
		<button class="button-secondary btn-remove-image" type="button">
		<?php _e("Remove", PHC_CAMERA_IDENTIFIER); ?></button>
		</div>
		<h3 class="hndle">
		<span><?php _e("Image", PHC_CAMERA_IDENTIFIER); ?>
		<?php echo $image_number; ?></span>
		</h3>
		<div class="camera-section">
			<div class="camera-image">
			<?php
			$image_src= wp_get_attachment_image_src($image_url[$ct], 'post-large');
			if( $image_src ){
			?>
			<img src="<?php echo $image_src[0]; ?>" alt="" />
			<?php
			}else{
			?>
			<img src="<?php echo PHC_CAMERA_IMG_URL . "no_image.jpg"; ?>" alt="No Image" />
			<?php
			}
			?>
			</div>	
			<div>
			<input type="hidden" name="image_url[]" value="<?php echo $image_url[$ct]; ?>" />
			<input type="button" 
			value="<?php esc_attr_e("Select Image", PHC_CAMERA_IDENTIFIER); ?>" 
			class="upload_image_button button-secondary" />
			</div>
			<div>
			<label for="camera_caption[]"><?php _e("Caption Text / HTML / Videos", PHC_CAMERA_IDENTIFIER); ?>: </label>
			<textarea id="camera_caption[]" name="camera_caption[]" cols="10" rows="10"><?php echo esc_html(urldecode($camera_caption[$ct])); ?></textarea>
			</div>
			<div>
			<label for="camera_caption_effects[]"><?php _e("Caption Effects", PHC_CAMERA_IDENTIFIER); ?>: </label>
			<select name="camera_caption_effects[]" id="camera_caption_effects[]">
			<?php
			foreach( $caption_effects as $item ){
				$selected= "";
				if( $item == $camera_caption_effects[$ct] ){
					$selected= " selected=\"selected\"";
				}
			?>
			<option value="<?php echo $item; ?>"<?php echo $selected; ?>><?php echo $item; ?></option>
			<?php
			}
			?>
			</select>
			</div>
		</div>
		</div>
	<?php
	}
	}
	?>
	</div>
</div>
<?php
}
// End Add Meta Box

// Start Save Post Camera Meta Options
add_action('save_post', 'phc_camera_meta_save_extras');
function phc_camera_meta_save_extras(){
	global $post;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	else{
		$meta_fields= array("image_url", "camera_caption", "camera_caption_effects");
		// Validate Data
		
		// Save Data
		foreach( $meta_fields as $field ){
			if( isset($_POST[$field]) ){
				$camera_obj= new PHC_Camera();
				foreach( $_POST[$field] as $key=>$item ){
					if( $field == "image_url" ){
						$camera_obj->regenerate_image($item);
					}else if( $field == "camera_caption" ){
						$phc_camera_obj= new PHC_Camera();
						$item= $phc_camera_obj->encode_camera_caption($item);
					}
					$_POST[$field][$key]= $item;
				}
				update_post_meta($post->ID, $field, json_encode($_POST[$field]));
			}
		}
//	header('content-type: text/plain');
//	print_r($_POST);
//	exit;
		
	}
}
// End Save Post Camera Meta Options

// Start Add Camera Side Meta Box
function phc_camera_side_options($post, $metabox){
	global $post, $wp_scripts, $wp_meta_boxes, $hook_suffix;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	
	$custom= get_post_custom($post->ID);
	$meta_fields= array("camera_properties");
	$properties= array("fullScreenEnabled");
	
	$datas= array();
	foreach( $meta_fields as $field ){
		
		if( isset($custom[$field]) ){
			$$field= json_decode($custom[$field][0], TRUE);
			extract($$field);
//			$datas[$field]= json_decode($custom[$field][0], TRUE);
		}
	}
	
//	header('content-type: text/plain');
//	echo "<pre>";
//	print_r($alignment);
//	echo "</pre>";
//	exit;
?>
	<div id="camera-extras" class="meta-box-side-wrapper" 
	data-post-id="<?php echo $post->ID; ?>">
		<?php
		$fullScreenEnabled_stat= "";
		if( isset($fullScreenEnabled) ){
			$fullScreenEnabled_stat= " checked=\"checked\"";
		}
		$boolean_values= explode(",", str_replace(" ", "", 'true, false'));
		
		$alignment_values= explode(",", str_replace(" ", "", 'topLeft, topCenter, topRight, centerLeft, center, centerRight, bottomLeft, bottomCenter, bottomRight'));
		$autoadvance_values= $boolean_values;
		$bardirection_values= array('leftToRight', 'rightToLeft', 'topToBottom', 'bottomToTop');
		$barposition_values= array('left', 'right', 'top', 'bottom');
		$easing_values= explode(",", str_replace(" ", "", 'linear,swing,easeInQuad,easeOutQuad,easeInOutQuad,easeInCubic,easeOutCubic,easeInOutCubic,easeInQuart,easeOutQuart,easeInOutQuart,easeInQuint,easeOutQuint,easeInOutQuint,easeInExpo,easeOutExpo,easeInOutExpo,easeInSine,easeOutSine,easeInOutSine,easeInCirc,easeOutCirc,easeInOutCirc,easeInElastic,easeOutElastic,easeInOutElastic,easeInBack,easeOutBack,easeInOutBack,easeInBounce,easeOutBounce,easeInOutBounce'));
		$fx_values= array('random','simpleFade', 'curtainTopLeft', 'curtainTopRight', 'curtainBottomLeft', 'curtainBottomRight', 'curtainSliceLeft', 'curtainSliceRight', 'blindCurtainTopLeft', 'blindCurtainTopRight', 'blindCurtainBottomLeft', 'blindCurtainBottomRight', 'blindCurtainSliceBottom', 'blindCurtainSliceTop', 'stampede', 'mosaic', 'mosaicReverse', 'mosaicRandom', 'mosaicSpiral', 'mosaicSpiralReverse', 'topLeftBottomRight', 'bottomRightTopLeft', 'bottomLeftTopRight', 'bottomLeftTopRight', 'scrollLeft', 'scrollRight', 'scrollHorz', 'scrollBottom', 'scrollTop');
		
		$hover_values= $boolean_values;
		$loader_values= explode(",", str_replace(" ", "", 'pie, bar, none'));
		$mobileautoadvance_values= $boolean_values;
		$mobileeasing_values= $easing_values;
		$mobilefx_values= $fx_values;
		$mobilenavhover_values= $boolean_values;
		$navigation_values= $boolean_values;
		$navigationhover_values= $boolean_values;
		$opacityongrid_values= $boolean_values;
		$overlayer_values= $boolean_values;
		$pagination_values= $boolean_values;
		$pauseonclick_values= $boolean_values;
		$pieposition_values= array('rightTop', 'leftTop', 'leftBottom', 'rightBottom');
		$playpause_values= $boolean_values;
		$portrait_values= $boolean_values;
		$slideon_values= explode(",", str_replace(" ", "", 'next, prev, random'));
		$thumbnails_values= $boolean_values;
		?>
		<div>
		<label for="camera_properties[alignment]">
		<?php _e("alignment", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $alignment_values as $value ){
			$checked= "";
			$default= ( isset($alignment) ) ? $alignment : "center";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[alignment][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[alignment]" 
			id="camera_properties[alignment][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[autoAdvance]">
		<?php _e("autoAdvance", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $autoadvance_values as $value ){
			$checked= "";
			$default= ( isset($autoAdvance) ) ? $autoAdvance : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[autoAdvance][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[autoAdvance]" 
			id="camera_properties[autoAdvance][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[barDirection]">
		<?php _e("barDirection", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $bardirection_values as $value ){
			$checked= "";
			$default= ( isset($barDirection) ) ? $barDirection : "leftToRight";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[barDirection][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[barDirection]" 
			id="camera_properties[barDirection][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>		
		</div>
		<div>
		<label for="camera_properties[barPosition]">
		<?php _e("barPosition", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $barposition_values as $value ){
			$checked= "";
			$default= ( isset($barPosition) ) ? $barPosition : "bottom";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[barPosition][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[barPosition]" 
			id="camera_properties[barPosition][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[cols]">
		<?php _e("cols", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($cols) ) ? $cols : 6;
		?>
		<input type="text" name="camera_properties[cols]" id="camera_properties[cols]" value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[easing]">
		<?php _e("easing", PHC_CAMERA_IDENTIFIER); ?></label>
		<select name="camera_properties[easing]" id="camera_properties[easing]">
		<?php
		foreach( $easing_values as $value ){
			$selected= "";
			$default= ( isset($easing) ) ? $easing : "easeInOutExpo";
			if( $value == $default ){
				$selected= "selected=\"selected\"";
			}
		?>
			<option value="<?php echo $value; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>
		<?php
		}
		?>
		</select>
		</div>		
		<div>
		<label for="camera_properties[fx]">
		<?php _e("fx", PHC_CAMERA_IDENTIFIER); ?></label>
		<select name="camera_properties[fx][]" id="camera_properties[fx]" multiple="">
		<?php
		foreach( $fx_values as $value ){
			$selected= "";
			$default= ( isset($fx) ) ? $fx : "random";
			if( $value == $default ){
				$selected= "selected=\"selected\"";
			}
		?>
			<option value="<?php echo $value; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>
		<?php
		}
		?>
		</select>
		</div>
		<div>
		<label for="camera_properties[gridDifference]">
		<?php _e("gridDifference", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($gridDifference) ) ? $gridDifference : 250;
		?>		
		<input type="text" name="camera_properties[gridDifference]" id="camera_properties[gridDifference]" 
		value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[height]">
		<?php _e("height ( in %)", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($height) ) ? $height : 50;
		?>
		<input type="text" name="camera_properties[height]" id="camera_properties[height]" value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[hover]">
		<?php _e("hover", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $hover_values as $value ){
			$checked= "";
			$default= ( isset($hover) ) ? $hover : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[hover][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[hover]" 
			id="camera_properties[hover][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[loader]">
		<?php _e("loader", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $loader_values as $value ){
			$checked= "";
			$default= ( isset($loader) ) ? $loader : "pie";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[loader][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[loader]" 
			id="camera_properties[loader][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[loaderBgColor]">
		<?php _e("loaderBgColor", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($loaderBgColor) ) ? $loaderBgColor : "#222222";
		?>
		<input type="text" name="camera_properties[loaderBgColor]" id="camera_properties[loaderBgColor]" 
		value="<?php echo $default; ?>" />
		</div>	
		<div>
		<label for="camera_properties[loaderColor]">
		<?php _e("loaderColor", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($loaderColor) ) ? $loaderColor : "#eeeeee";
		?>
		<input type="text" name="camera_properties[loaderColor]" id="camera_properties[loaderColor]" 
		value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[loaderOpacity]">
		<?php _e("loaderOpacity", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($loaderOpacity) ) ? $loaderOpacity : ".8";
		?>
		<input type="text" name="camera_properties[loaderOpacity]" id="camera_properties[loaderOpacity]" 
		value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[loaderPadding]">
		<?php _e("loaderPadding", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($loaderPadding) ) ? $loaderPadding : "2";
		?>
		<input type="text" name="camera_properties[loaderPadding]" id="camera_properties[loaderPadding]" 
		value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[loaderStroke]">
		<?php _e("loaderStroke", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($loaderStroke) ) ? $loaderStroke : "7";
		?>
		<input type="text" name="camera_properties[loaderStroke]" id="camera_properties[loaderStroke]" 
		value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[minHeight]">
		<?php _e("minHeight ( in pixel )", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($minHeight) ) ? $minHeight : "200";
		?>
		<input type="text" name="camera_properties[minHeight]" id="camera_properties[minHeight]" 
		value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[mobileAutoAdvance]">
		<?php _e("mobileAutoAdvance", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $mobileautoadvance_values as $value ){
			$checked= "";
			$default= ( isset($mobileAutoAdvance) ) ? $mobileAutoAdvance : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[mobileAutoAdvance][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[mobileAutoAdvance]" 
			id="camera_properties[mobileAutoAdvance][<?php echo $value; ?>]" 
			value="<?php echo $value; ?>"<?php echo $checked; ?> /><?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[mobileEasing]">
		<?php _e("mobileEasing", PHC_CAMERA_IDENTIFIER); ?></label>
		<select name="camera_properties[mobileEasing]" id="camera_properties[mobileEasing]">
		<?php
		foreach( $mobileeasing_values as $value ){
			$selected= "";
			$default= ( isset($mobileEasing) ) ? $mobileEasing : "easeInOutExpo";
			if( $value == $default ){
				$selected= "selected=\"selected\"";
			}
		?>
			<option value="<?php echo $value; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>
		<?php
		}
		?>
		</select>
		</div>
		<div>
		<label for="camera_properties[mobileFx]">
		<?php _e("mobileFx", PHC_CAMERA_IDENTIFIER); ?></label>
		<select name="camera_properties[mobileFx][]" id="camera_properties[mobileFx]" multiple="">
		<?php
		foreach( $mobilefx_values as $value ){
			$selected= "";
			$default= ( isset($mobileFx) ) ? $mobileFx : "random";
			if( $value == $default ){
				$selected= "selected=\"selected\"";
			}
		?>
			<option value="<?php echo $value; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>
		<?php
		}
		?>
		</select>
		</div>
		<div>
		<label for="camera_properties[mobileNavHover]">
		<?php _e("mobileNavHover", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $mobilenavhover_values as $value ){
			$checked= "";
			$default= ( isset($mobileNavHover) ) ? $mobileNavHover : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[mobileNavHover][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[mobileNavHover]" 
			id="camera_properties[mobileNavHover][<?php echo $value; ?>]" 
			value="<?php echo $value; ?>"<?php echo $checked; ?> /><?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[navigation]">
		<?php _e("navigation", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $navigation_values as $value ){
			$checked= "";
			$default= ( isset($navigation) ) ? $navigation : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[navigation][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[navigation]" 
			id="camera_properties[navigation][<?php echo $value; ?>]" 
			value="<?php echo $value; ?>"<?php echo $checked; ?> /><?php echo $value; ?>
			</label>
		<?php
		}
		?>		
		</div>
		<div>
		<label for="camera_properties[navigationHover]">
		<?php _e("navigationHover", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $navigationhover_values as $value ){
			$checked= "";
			$default= ( isset($navigationHover) ) ? $navigationHover : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[navigationHover][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[navigationHover]" 
			id="camera_properties[navigationHover][<?php echo $value; ?>]" 
			value="<?php echo $value; ?>"<?php echo $checked; ?> /><?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[opacityOnGrid]">
		<?php _e("opacityOnGrid", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $opacityongrid_values as $value ){
			$checked= "";
			$default= ( isset($opacityOnGrid) ) ? $opacityOnGrid : "false";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[opacityOnGrid][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[opacityOnGrid]" 
			id="camera_properties[opacityOnGrid][<?php echo $value; ?>]" 
			value="<?php echo $value; ?>"<?php echo $checked; ?> /><?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[overlayer]">
		<?php _e("overlayer", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $overlayer_values as $value ){
			$checked= "";
			$default= ( isset($overlayer) ) ? $overlayer : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[overlayer][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[overlayer]" 
			id="camera_properties[overlayer][<?php echo $value; ?>]" 
			value="<?php echo $value; ?>"<?php echo $checked; ?> /><?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[pagination]">
		<?php _e("pagination", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $pagination_values as $value ){
			$checked= "";
			$default= ( isset($pagination) ) ? $pagination : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[pagination][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[pagination]" 
			id="camera_properties[pagination][<?php echo $value; ?>]" 
			value="<?php echo $value; ?>"<?php echo $checked; ?> /><?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[pauseOnClick]">
		<?php _e("pauseOnClick", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $pauseonclick_values as $value ){
			$checked= "";
			$default= ( isset($pauseOnClick) ) ? $pauseOnClick : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[pauseOnClick][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[pauseOnClick]" 
			id="camera_properties[pauseOnClick][<?php echo $value; ?>]" 
			value="<?php echo $value; ?>"<?php echo $checked; ?> /><?php echo $value; ?>
			</label>
		<?php
		}
		?>		
		</div>
		<div>
		<label for="camera_properties[pieDiameter]">
		<?php _e("pieDiameter", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($pieDiameter) ) ? $pieDiameter : "38";
		?>
		<input type="text" name="camera_properties[pieDiameter]" id="camera_properties[pieDiameter]" 
		value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[piePosition]">
		<?php _e("piePosition", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $pieposition_values as $value ){
			$checked= "";
			$default= ( isset($piePosition) ) ? $piePosition : "rightTop";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[piePosition][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[piePosition]" 
			id="camera_properties[piePosition][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>		
		</div>
		<div>
		<label for="camera_properties[playPause]">
		<?php _e("playPause", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $playpause_values as $value ){
			$checked= "";
			$default= ( isset($playPause) ) ? $playPause : "true";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[playPause][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[playPause]" 
			id="camera_properties[playPause][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[portrait]">
		<?php _e("portrait", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $portrait_values as $value ){
			$checked= "";
			$default= ( isset($portrait) ) ? $portrait : "false";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[portrait][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[portrait]" 
			id="camera_properties[portrait][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[rows]">
		<?php _e("rows", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($rows) ) ? $rows : "38";
		?>		
		<input type="text" name="camera_properties[rows]" id="camera_properties[rows]" value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[slicedCols]">
		<?php _e("slicedCols", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($slicedCols) ) ? $slicedCols : "12";
		?>
		<input type="text" name="camera_properties[slicedCols]" id="camera_properties[slicedCols]" 
		value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[slicedRows]">
		<?php _e("slicedRows", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($slicedRows) ) ? $slicedRows : "8";
		?>
		<input type="text" name="camera_properties[slicedRows]" id="camera_properties[slicedRows]" 
		value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[slideOn]">
		<?php _e("slideOn", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $slideon_values as $value ){
			$checked= "";
			$default= ( isset($slideOn) ) ? $slideOn : "random";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[slideOn][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[slideOn]" 
			id="camera_properties[slideOn][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[thumbnails]">
		<?php _e("thumbnails", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		foreach( $thumbnails_values as $value ){
			$checked= "";
			$default= ( isset($thumbnails) ) ? $thumbnails : "false";
			if( $value == $default ){
				$checked= "checked=\"checked\"";
			}
		?>
			<label for="camera_properties[thumbnails][<?php echo $value; ?>]">
			<input type="radio" name="camera_properties[thumbnails]" 
			id="camera_properties[thumbnails][<?php echo $value; ?>]" value="<?php echo $value; ?>"<?php echo $checked; ?> />
			<?php echo $value; ?>
			</label>
		<?php
		}
		?>
		</div>
		<div>
		<label for="camera_properties[time]">
		<?php _e("time", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($time) ) ? $time : "7000";
		?>
		<input type="text" name="camera_properties[time]" id="camera_properties[time]" value="<?php echo $default; ?>" />
		</div>
		<div>
		<label for="camera_properties[transPeriod]">
		<?php _e("transPeriod", PHC_CAMERA_IDENTIFIER); ?></label>
		<?php
		$default= ( isset($transPeriod) ) ? $transPeriod : "1500";
		?>
		<input type="text" name="camera_properties[transPeriod]" id="camera_properties[transPeriod]" 
		value="<?php echo $default; ?>" />
		</div>
	</div>
<?php
}
// End Add Camera Side Meta Box

// Start Save Post Camera Side Options
add_action('save_post', 'phc_camera_side_save_extras');
function phc_camera_side_save_extras(){
	global $post;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	else{
		// Validate Data
//		header('content-type: text/plain');
//		print_r($_POST);
//		exit;
		
		// Save Data
		if( isset($post->ID) ){
			update_post_meta($post->ID, 'camera_properties', 
			json_encode($_POST['camera_properties']));
		}
	}
}
// End Save Post Camera Side Options
?>