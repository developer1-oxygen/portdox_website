<?php
/* Universal Services support functions
------------------------------------------------------------------------------- */

// Check if Universal Services Plugin installed and activated
if ( !function_exists( 'themerex_exists_universal_services_plugin' ) ) {
    function themerex_exists_universal_services_plugin() {
        return function_exists('themerex_universal_services_plugin');
    }
}
?>