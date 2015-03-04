<?php

class wooStickerHooks {
    
    public function __construct() {          	    	
        register_activation_hook( WS_PATH.WS_PLUGIN_FILE, array($this, 'activate') );
        register_uninstall_hook( WS_PATH.WS_PLUGIN_FILE, array( __CLASS__, 'wooStickerHooks_deactivate' ) );      
        add_filter('plugin_action_links', array($this, 'woostickers_add_settings_link'), 10, 2);
        // Future use for Upgrade of plugin        
        if(version_compare(get_option(WS_OPTION_NAME), '1.0.2') == '-1') {
            $this->upgradeTo102();
        }
        if(version_compare(get_option(WS_OPTION_NAME), '1.0.3') == '-1') {
        	$this->upgradeTo103();
        }
    }
    
    private function update_version($version = '') {
    	
    	if($version == '') {
    		$version = WS_VERSION;
    	}

    	update_option(WS_OPTION_NAME, $version);
    }
    
    public function activate() {
        $this->update_version();                        
    }
    public function woostickers_add_settings_link($links, $file)
    {    
    	$wooStickerFile = WS_PLUGIN_FILE;    	 
        if (basename($file) == $wooStickerFile) {
        	
            $linkSettings = '<a href="' . admin_url("options-general.php?page=wli-stickers") . '">Settings</a>';
            array_unshift($links, $linkSettings);
        }
        return $links;
    }
    public static function wooStickerHooks_deactivate() {
    	delete_option( 'general_settings' );
    	delete_option( 'new_product_settings' );
    	delete_option( 'sale_product_settings' );
    	delete_option( 'sold_product_settings' );
    }
    
    public function upgradeTo102() {
    	
    	$new_product_settings = ( array ) get_option ( 'new_product_settings' );
    	
    	$new_product_settings['new_product_sticker_days'] = '10';
    	
    	update_option('new_product_settings', $new_product_settings);
    	
    	$this->update_version('1.0.2');
    	
    }
    
    public function upgradeTo103() {
    	 
    	$new_product_settings = ( array ) get_option ( 'new_product_settings' );    	     	
    	$new_product_settings['new_product_position'] = 'left';
    	$new_product_settings['new_product_custom_sticker'] = '';    	 
    	update_option('new_product_settings', $new_product_settings);
    	 
    	$sale_product_settings = ( array ) get_option ( 'sale_product_settings' );
    	$sale_product_settings['sale_product_position'] = 'right';
    	$sale_product_settings['sale_product_custom_sticker'] = '';
    	update_option('sale_product_settings', $sale_product_settings);
    	
    	$sold_product_settings = ( array ) get_option ( 'sold_product_settings' );
    	$sold_product_settings['sold_product_position'] = 'left';
    	$sold_product_settings['sold_product_custom_sticker'] = '';
    	update_option('sold_product_settings', $sold_product_settings);
    	
    	$this->update_version('1.0.3');
    	 
    }
    
}

new wooStickerHooks();