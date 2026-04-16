<?php
/* Content timeline support functions
------------------------------------------------------------------------------- */

// Check if Content timeline installed and activated
if ( !function_exists( 'themerex_exists_timeline' ) ) {
	function themerex_exists_timeline() {
        return class_exists( 'ContentTimelineAdmin' );
	}
}
?>