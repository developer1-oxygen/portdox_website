<?php
add_action("pdf_builder_block","pdf_builder_block_text",10);
function pdf_builder_block_text(){
    ?>
    <li>
        <div class="momongaDraggable" data-type="text">
            <i class="emailbuilder-icon icon-text-height"></i>
            <div class="pdfbuilder-tool-text"><?php esc_html_e("Text","pdfcreator") ?></div>
        </div>
    </li>
    <?php
}
add_filter( 'pdf_builder_block_html', "pdf_builder_block_text_load" );
function pdf_builder_block_text_load($type){
    $type["block"]["text"]["builder"] = '
<div class="builder-elements">
    <div class="builder-elements-content" data-type="text">
        <div class="text-content-data hidden">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
        <div class="text-content">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
    </div>
</div>';
    $type["block"]["text"]["editor"]["container"]["show"]= ["text-align","padding","background","html","margin","condition"];
    $padding = pdfbuilder_email_global_data::$padding;
    $margin = pdfbuilder_email_global_data::$margin;
    $text_align = pdfbuilder_email_global_data::$text_align;
    $container_style = array(
            ".builder__editor--item-background .builder__editor_color"=>"background-color",
            ".builder__editor--item-background .image_url"=>"background-image",
        );
    $type["block"]["text"]["editor"]["container"]["style"]= array_merge($padding,$container_style,$text_align,$margin);
    $type["block"]["text"]["editor"]["inner"]["style"]= array();
    $type["block"]["text"]["editor"]["inner"]["attr"] = array(".text-content"=>array(".builder__editor--html .builder__editor--js"=>"html"),
                                                              ".text-content-data"=>array(".builder__editor--html .builder__editor--js"=>"html_hide"));
    return $type; 
}