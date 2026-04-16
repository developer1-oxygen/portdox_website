<?php
/* Calculator (calculated-fields-form) support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('themerex_calculated_theme_setup')) {
	add_action( 'themerex_action_before_init_theme', 'themerex_calculated_theme_setup' );
	function themerex_calculated_theme_setup() {
		if (themerex_exists_calculated()) {
			add_action( 'themerex_action_add_scripts', 'themerex_calculated_frontend_scripts' );
		}
	}
}

// Check if Calculator installed and activated
if ( !function_exists( 'themerex_exists_calculated' ) ) {
	function themerex_exists_calculated() {
		return defined('CP_CALCULATEDFIELDSF_DEFAULT_DEFER_SCRIPTS_LOADING');
	}
}

// Enqueue scripts
if ( !function_exists( 'themerex_calculated_frontend_scripts' ) ) {
	//Handler of add_action( 'themerex_action_add_scripts', 'themerex_calculated_frontend_scripts' );
	function themerex_calculated_frontend_scripts() {
		themerex_enqueue_formstyler();
	}
}
?>