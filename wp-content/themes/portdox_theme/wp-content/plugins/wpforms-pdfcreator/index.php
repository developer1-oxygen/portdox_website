<?php
/**
 * Plugin Name: WPForms PDF Customizer
 * Plugin URI: https://codecanyon.net/user/rednumber/portfolio
 * Description:  Gravity Forms PDF Customizer is a helpful tool that helps you build and customize the PDF Templates for WPforms.
 * Version: 2.0.3
 * Core Builder: 1.6.1
 * Requires PHP: 7.1
 * Author: Rednumber
 * Author URI: https://codecanyon.net/user/rednumber/portfolio
*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
define( 'BUIDER_PDF_WPFORMS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BUIDER_PDF_WPFORMS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
require 'vendor/autoload.php';
if(!class_exists('PDF_Creator_Builder')) {
    if(!defined('PDF_CREATOR_BUILDER_VERSION')) {
        define( 'PDF_CREATOR_BUILDER_VERSION', "1.6.0" );
    }
    if(!defined('PDF_CREATOR_BUILDER_PATH')) {
        define( 'PDF_CREATOR_BUILDER_PATH', plugin_dir_path( __FILE__ ) );
    }
    if(!defined('PDF_CREATOR_BUILDER_URL')) {
        define( 'PDF_CREATOR_BUILDER_URL', plugin_dir_url( __FILE__ ) );
    }
     class PDF_Creator_Builder {
        function __construct(){
                foreach (glob(PDF_CREATOR_BUILDER_PATH."backend/*.php") as $filename){
                    include $filename;
                }
                foreach (glob(PDF_CREATOR_BUILDER_PATH."backend/templates/*.php") as $filename){
                    include $filename;
                }
                include PDF_CREATOR_BUILDER_PATH."backend/demo/templates_demo.php";
                include PDF_CREATOR_BUILDER_PATH."frontend/index.php";
        }
    }
    new PDF_Creator_Builder;
}
class PDF_Creator_WPForms_Builder { 
    function __construct(){
        include BUIDER_PDF_WPFORMS_PLUGIN_PATH."wpforms/index.php";
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this,'add_link') );
    }
    function add_link( $actions ) {
       $actions[] = '<a target="_blank" href="https://pdf.add-ons.org/document/" target="_blank">'.esc_html__( "Document", "gravityforms-pdfcreator" ).'</a>';
       return $actions;
    }
}
new  PDF_Creator_WPForms_Builder;
