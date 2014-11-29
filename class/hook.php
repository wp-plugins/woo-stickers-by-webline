<?php

class wooStickerHooks {
    
    public function __construct() {      
        register_activation_hook( WS_PATH.WS_PLUGIN_FILE, array($this, 'activate') );

        // Future use for Upgrade of plugin
        
        if(version_compare(get_option(WS_OPTION_NAME), '1.0.2') == '-1') {
            $this->upgradeTo102();
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
    
    
    public function upgradeTo102() {
    	
    	$new_product_settings = ( array ) get_option ( 'new_product_settings' );
    	
    	$new_product_settings['new_product_sticker_days'] = '10';
    	
    	update_option('new_product_settings', $new_product_settings);
    	
    	$this->update_version('1.0.2');
    	
    }
    
}

new wooStickerHooks();

