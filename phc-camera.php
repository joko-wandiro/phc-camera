<?php
/*
Plugin Name: Camera Slider
Plugin URI: https://github.com/joko-wandiro/wp-camera
Description: jQuery slideshow with many effects, transitions, easy to customize, using canvas and mobile ready, based on jQuery 1.4+. You can add it into post / page / widget Wordpress.
Version: 1.0.0
Author: Joko Wandiro
Author URI: http://www.phantasmacode.com
*/
define("PHC_CAMERA_VERSION", "1.0");
define('PHC_CAMERA_NAME', "Camera");
define('PHC_CAMERA_IDENTIFIER', "phc-camera");
define('PHC_CAMERA_ID_SCRIPT', "phc_camera");

load_plugin_textdomain(PHC_CAMERA_IDENTIFIER, FALSE, PHC_CAMERA_IDENTIFIER . "/languages");

define('PHC_CAMERA_PATH', plugin_dir_path(__FILE__));
define('PHC_CAMERA_INCLUDE_PATH', PHC_CAMERA_PATH . "inc/");
define('PHC_CAMERA_THEME_PATH', PHC_CAMERA_PATH . "theme/");
define('PHC_CAMERA_PATH_URL', plugin_dir_url(__FILE__));
define('PHC_CAMERA_THEME_URL', PHC_CAMERA_PATH_URL . "theme/");
define('PHC_CAMERA_PATH_URL_CSS', PHC_CAMERA_PATH_URL . "css/");
define('PHC_CAMERA_PATH_URL_JS', PHC_CAMERA_PATH_URL . "js/");
define('PHC_CAMERA_IMG_URL', PHC_CAMERA_PATH_URL . "img/");
define('PHC_CAMERA_IMAGES_BANNER', PHC_CAMERA_IMG_URL . "banner/");
define('PHC_CAMERA_IMG_DOCUMENTATION_BOW_TO_USE_URL', PHC_CAMERA_PATH_URL . 
"img/documentation/how-to-use/");
define('PHC_CAMERA_IMG_DOCUMENTATION_THEMES_URL', PHC_CAMERA_PATH_URL . 
"img/documentation/themes/");
define('PHC_CAMERA_IMG_DOCUMENTATION_NEW_THEMES_URL', PHC_CAMERA_PATH_URL . 
"img/documentation/new-themes/");
define("PHC_CAMERA_POST_TYPE", "camera");
define("PHC_CAMERA_SUBMENU_CAPABILITY", "manage_options");
define("PHC_CAMERA_MENU_SLUG_SETTINGS", PHC_CAMERA_ID_SCRIPT . 
"_settings");
define("PHC_CAMERA_PAGE_TITLE_SETTINGS", __("Settings", PHC_CAMERA_IDENTIFIER));
define("PHC_CAMERA_MENU_TITLE_SETTINGS", 
PHC_CAMERA_PAGE_TITLE_SETTINGS);
define("PHC_CAMERA_MENU_SLUG_DOCUMENTATION", PHC_CAMERA_ID_SCRIPT . 
"_documentation");
define("PHC_CAMERA_PAGE_TITLE_DOCUMENTATION", __("Documentation", PHC_CAMERA_IDENTIFIER));
define("PHC_CAMERA_MENU_TITLE_DOCUMENTATION", PHC_CAMERA_PAGE_TITLE_DOCUMENTATION);

require_once(PHC_CAMERA_INCLUDE_PATH . "backend_ajax.php");
require_once(PHC_CAMERA_INCLUDE_PATH . "post_type.php");
require_once(PHC_CAMERA_INCLUDE_PATH . "meta_boxes.php");
require_once(PHC_CAMERA_INCLUDE_PATH . "manage_columns.php");
require_once(PHC_CAMERA_INCLUDE_PATH . "shortcode.php");
require_once(PHC_CAMERA_INCLUDE_PATH . "admin_scripts.php");
require_once(PHC_CAMERA_INCLUDE_PATH . "pages/settings.php");
require_once(PHC_CAMERA_INCLUDE_PATH . "pages/documentation.php");
?>