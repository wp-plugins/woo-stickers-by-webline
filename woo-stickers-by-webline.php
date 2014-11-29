<?php
/**
 * Plugin Name: Woo Stickers by Webline
 * URI: http://www.weblineindia.com
 * Description: Product sticker extension to improve customer experience while shopping by providing stickers for New products, On Sale products, Soldout Products which is easily configure from admin panel without any extra developer efforts.
 * Author: Weblineindia
 * Version: 1.0.2
 * Author URI: http://www.weblineindia.com
 * Network: false
 * 
 */

/**
 * Check if WooCommerce is active.
 */
if (in_array ( 'woocommerce/woocommerce.php', apply_filters ( 'active_plugins', get_option ( 'active_plugins' ) ) )) {
	define ( 'WS_VERSION', '1.0.2' );
	define ( 'WS_DEBUG', TRUE );
	define ( 'WS_PATH', plugin_dir_path ( __FILE__ ) );
	define ( 'WS_URL', plugins_url ( '', __FILE__ ) );
	define ( 'WS_PLUGIN_FILE', basename ( __FILE__ ) );
	define ( 'WS_PLUGIN_DIR', plugin_basename ( dirname ( __FILE__ ) ) );
	define ( 'WS_OPTION_NAME', 'WS_settings' );
	define ( 'WS_ADMIN_DIR', WS_PATH . '/admin' );
	define ( 'WS_CLASS_DIR', 'class' );
	define ( 'WS_CLASS', WS_PATH . WS_CLASS_DIR );
	
	// Adding Hook Class
	require_once (WS_CLASS . '/hook.php');
	require_once (WS_ADMIN_DIR . '/class/menu.php');
	
	if (! is_admin ()) {
		require_once (WS_CLASS . '/assets.php');
		require_once (WS_CLASS . '/show-view.php');
	}
}