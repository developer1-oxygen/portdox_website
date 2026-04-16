<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
add_action( 'pdf_builder_block_html', "pdf_builder_block_main_load" );
function pdf_builder_block_main_load($type) {
    $type["block"]["main"]["editor"]["container"]["show"]= ["background","padding","settings"];
    $padding = pdfbuilder_email_global_data::$padding;
    $type["block"]["main"]["editor"]["container"]["style"]= array_merge($padding,array(
                ".builder__editor--item-background .builder__editor_color"=>"background-color",
                ".builder__editor--item-background .image_url"=>"background-image",
                ".builder__editor--item-settings .font_family"=>"font-family",
                ".builder__editor--item-settings .font-size-main"=>"font-size",
                ".builder__editor--item-settings .builder__editor_color"=>"color",
            ));
    return $type;
}
class pdfbuilder_email_global_data {
    public static $padding = array(
        ".builder__editor--item-padding .builder__editor--padding-top"=>"padding-top",
        ".builder__editor--item-padding .builder__editor--padding-bottom"=>"padding-bottom",
        ".builder__editor--item-padding .builder__editor--padding-left"=>"padding-left",
        ".builder__editor--item-padding .builder__editor--padding-right"=>"padding-right",
    );
    public static $margin = array(
        ".builder__editor--item-margin .builder__editor--padding-top"=>"margin-top",
        ".builder__editor--item-margin .builder__editor--padding-bottom"=>"margin-bottom",
        ".builder__editor--item-margin .builder__editor--padding-left"=>"margin-left",
        ".builder__editor--item-margin .builder__editor--padding-right"=>"margin-right",
    );
    public static $text_align = array(
        ".builder__editor--item-text-align .text_align"=>"text-align"
    );
    public static $border = array(
        ".builder__editor--item-border-width .builder__editor--padding-top"=>"border-top-width",
        ".builder__editor--item-border-width .builder__editor--padding-bottom"=>"border-bottom-width",
        ".builder__editor--item-border-width .builder__editor--padding-left"=>"border-left-width",
        ".builder__editor--item-border-width .builder__editor--padding-right"=>"border-right-width",
        ".builder__editor--item-border-width .border_style"=>"border-style",
        ".builder__editor--item-border-width .builder__editor_color"=>"border-color",
        ".builder__editor--item-border-radius .builder__editor--padding-top"=>"border-top-left-radius",
        ".builder__editor--item-border-radius .builder__editor--padding-bottom"=>"border-bottom-right-radius",
        ".builder__editor--item-border-radius .builder__editor--padding-left"=>"border-bottom-left-radius",
        ".builder__editor--item-border-radius .builder__editor--padding-right"=>"border-top-right-radius",
    );
}