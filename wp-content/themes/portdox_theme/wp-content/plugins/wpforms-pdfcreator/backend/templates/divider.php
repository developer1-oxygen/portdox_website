<?php
add_action("pdf_builder_block","pdf_builder_block_divider",40);
function pdf_builder_block_divider(){
    ?>
    <li>
        <div class="momongaDraggable" data-type="divider">
            <i class="emailbuilder-icon icon-divide"></i>
            <div class="pdfbuilder-tool-text"><?php esc_html_e("Divider","pdfcreator") ?></div>
        </div>
    </li>
    <?php
}
add_filter( 'pdf_builder_block_html', "pdf_builder_block_divider_load" );
function pdf_builder_block_divider_load($type){
   $type["block"]["divider"]["builder"] = '
   <div class="builder-elements">
        <div class="builder-elements-content" data-type="divider" style="padding: 15px 0;">
            <div class="builder-hr"></div>
        </div>
    </div>';
   //Show editor
    $type["block"]["divider"]["editor"]["container"]["show"]= ["padding","background","height","condition"];
    
    $inner_style = array(
            ".builder__editor--item-background .builder__editor_color"=>"background-color",
            ".builder__editor--item-height .text_height"=>"height",
            ".builder__editor--item-background .image_url"=>"background-image",
        );
    $padding = pdfbuilder_email_global_data::$padding;
    $type["block"]["divider"]["editor"]["container"]["style"]= array_merge($padding);

    $type["block"]["divider"]["editor"]["inner"]["style"]=[".builder-hr" => $inner_style];
   return $type;
}

