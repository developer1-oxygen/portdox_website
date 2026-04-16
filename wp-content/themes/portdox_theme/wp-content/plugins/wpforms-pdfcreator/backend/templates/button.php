<?php
add_action("pdf_builder_block","pdf_builder_block_button",30);
function pdf_builder_block_button(){
    ?>
    <li>
        <div class="momongaDraggable" data-type="button">
            <i class="emailbuilder-icon icon-doc-landscape"></i>
            <div class="pdfbuilder-tool-text"><?php esc_html_e("Button","pdfcreator") ?></div>
        </div>
    </li>
    <?php
}
add_filter( 'pdf_builder_block_html', "pdf_builder_block_button_load" );
function pdf_builder_block_button_load($type){
   $type["block"]["button"]["builder"] = '
   <div class="builder-elements">
        <div class="builder-elements-content" data-type="button" style="text-align: center;">
            <a class="pdfbuilder_button" href="#">Button</a>
        </div>
    </div>';
    //Show editor
    $type["block"]["button"]["editor"]["container"]["show"]= ["text-align","padding","border","button","background","color","condition"];
    //Style container
    $type["block"]["button"]["editor"]["container"]["style"]= pdfbuilder_email_global_data::$text_align;
    //Style inner
    $padding = pdfbuilder_email_global_data::$padding;
    $border = pdfbuilder_email_global_data::$border;
    $a = array(
            ".builder__editor--item-button .font_size"=>"font-size",
            ".builder__editor--item-background .builder__editor_color"=>"background-color",
            ".builder__editor--item-color .builder__editor_color"=>"color",
            ".builder__editor--item-background .image_url"=>"background-image",
        );
    $type["block"]["button"]["editor"]["inner"]["style"]=["a" => array_merge($padding,$border,$a)];
    // Data Attr
    $type["block"]["button"]["editor"]["inner"]["attr"]=["a"=>[".builder__editor--item-button .button_text"=>"text",
        ".builder__editor--item-button .button_url"=>"href"]];
   return $type;
}
