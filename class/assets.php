<?php

class frontAssets {
    
    
    public function __construct() {           	
        add_action('wp_enqueue_scripts', array($this, 'addCSS'));
    }
    
    public function addCSS () {
        echo '<link rel="stylesheet" href="'.WS_URL.'/assets/css/woo-style.css" type="text/css" media="all" />';        
    }
        
}

$frontAssets = new frontAssets();
