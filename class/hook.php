<?php

class wooStickerHooks {
    
    public function __construct() {      
        register_activation_hook( WS_PATH.WS_PLUGIN_FILE, array($this, 'activate') );

        // Future use for Upgrade of plugin
        /* if(version_compare(get_option(WS_OPTION_NAME), '1.1.0') == '-1') {
            $this->upgradeTo110();
        } */
        
    }
    
    private function update_version() {
        update_option(WS_OPTION_NAME, WS_VERSION);
    }
    
    public function activate() {
        $this->update_version();                        
    }
    
}

new wooStickerHooks();

