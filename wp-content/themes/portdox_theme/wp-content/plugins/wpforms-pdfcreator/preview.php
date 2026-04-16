<?php 
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
if( isset($_GET['id'])) {
   $id_template = sanitize_text_field( $_GET['id'] );
   $type = "preview";
   if( isset($_GET["download"]) ){
       $type = "download";
   }
   if( isset($_GET["html"]) ){
       $type = "html";
   }
   $user = wp_get_current_user();
   $allowed_roles = array('editor', 'administrator', 'author',"shop_manager");
   $check = false;
    if ( isset( $_REQUEST['_wpnonce']) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'pdf_creator' ) ) {
        $check = true;
    }
    if( array_intersect($allowed_roles, $user->roles ) ) {
        $check = true;  
    }
    if( $check ){
        $order_id = "";
        if( isset($_GET["woo_order"]) ) {
              $order_id = sanitize_text_field( $_GET['woo_order'] );
        }
        $packing_slip = false;
        if( isset($_GET["packing_slip"]) ) {
              $packing_slip = true;
        }
        FDF_Create_frontend::pdf_creator_preview($id_template,$type,"pdf_data","",$order_id,$packing_slip);
    }
}
