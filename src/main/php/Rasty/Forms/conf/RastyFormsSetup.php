<?php

namespace Rasty\Forms\conf;

use Rasty\app\LoadRasty;

class RastyFormsSetup {
	
    
    /**
     * inicializamos phprasty_forms
     */
    static public function initialize( $sourcesPath="", $rastyHome="" ){

    	$rastyLoader = LoadRasty::getInstance();
    	$rastyLoader->loadXml(dirname(__DIR__) . '/conf/rasty.xml',  $sourcesPath, $rastyHome );
    	    	
    }
}