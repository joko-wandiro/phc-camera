<div id="camera-<?php echo $post->ID; ?>" class="camera-<?php echo $post->type; ?>">
<div class="camera_wrap camera_azure_skin" id="camera-wrap-<?php echo $this->type . "-" . $post->ID; ?>">
<?php
foreach( $image_url as $key=>$item ){
	if( $this->type == "post" ){
		$image_src_small= wp_get_attachment_image_src($item, 'phc-camera-post-small');
		$image_src_large= wp_get_attachment_image_src($item, 'phc-camera-post-large');
	}elseif( $this->type == "widget" ){
		$image_src_small= wp_get_attachment_image_src($item, 'phc-camera-widget-small');
		$image_src_large= wp_get_attachment_image_src($item, 'phc-camera-widget-large');
	}
?>	
    <div data-thumb="<?php echo $image_src_small[0]; ?>" data-src="<?php echo $image_src_large[0]; ?>">
        <div class="camera_caption <?php echo $camera_caption_effects[$key]; ?>">
		<?php echo $this->escape_camera_caption($camera_caption[$key]); ?>
        </div>
    </div>
<?php
}
?>
</div>
</div>
<?php
// Add Hook Filter to modify Properties
$camera_properties= apply_filters('phc_camera_properties', $camera_properties, $post, $this->type);
$camera_properties['imagePath']= PHC_CAMERA_IMG_URL;
$csv_properties= array("fx", "mobileFx");
$properties= "";
$string_vars= array('alignment','barDirection','barPosition','easing','fx','height','loader','loaderColor','loaderBgColor','minHeight','piePosition','slideOn','mobileEasing','mobileFx','imagePath');
foreach( $camera_properties as $key=>$item ){
	if( in_array($key, $csv_properties) ){
		$item= implode(",", $item);
	}
	
	if( $key == "height" ){
		$item= (string)$item . "%";
	}
	
	if( $key == "minHeight" ){
		$item= $item . "px";
	}
	
	if( in_array($key, $string_vars) ){
		$item= "'" . $item . "'";
	}
	
	$properties.= $key . ": " . $item . ",";
}
$properties = substr($properties, 0, -1);
//echo "<pre>";
//print_r($properties);
//echo "</pre>";
?>
<script>
jQuery(document).ready(function($){
	console.log({<?php echo $properties; ?>});
	$('#camera-wrap-<?php echo $this->type . "-" . $post->ID; ?>').camera({<?php echo $properties; ?>});
});
</script>	  