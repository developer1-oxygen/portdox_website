<?php
add_action("pdf_builder_block","pdf_builder_block_image",20);
function pdf_builder_block_image(){
    ?>
    <li>
        <div class="momongaDraggable" data-type="image">
            <i class="emailbuilder-icon icon-picture"></i>
            <div class="pdfbuilder-tool-text"><?php esc_html_e("Image","pdfcreator") ?></div>
        </div>
    </li>
    <?php
}
add_action( 'pdf_builder_block_html', "pdf_builder_block_image_load" );
function pdf_builder_block_image_load($type){
    $type["block"]["image"]["builder"] = '
<div class="builder-elements" >
    <div class="builder-elements-content" data-type="image">
        <img data-type="0" data-field="0" style="width:150px;height:39px;" src="'.PDF_CREATOR_BUILDER_URL.'images/your-image.png"" alt="">
    </div>
</div>';
    //Show editor
    $type["block"]["image"]["editor"]["container"]["show"]= ["padding","image","text-align","width","height","condition"];
    //Style container
    $container_style = array(
            ".builder__editor--item-background .builder__editor_color"=>"background-color",
            ".builder__editor--item-background .image_url"=>"background-image",
        );
    $text_align = pdfbuilder_email_global_data::$text_align;
    $padding = pdfbuilder_email_global_data::$padding;
    $border = pdfbuilder_email_global_data::$border;
    $inner_style = array(
            ".builder__editor--item-background .builder__editor_color"=>"background-color",
            ".builder__editor--item-width .text_width"=>"width",
            ".builder__editor--item-height .text_height"=>"height",
        );
    $type["block"]["image"]["editor"]["container"]["style"]= array_merge($padding,$text_align);
    $type["block"]["image"]["editor"]["inner"]["style"]=["img" => array_merge($border,$inner_style)];
    $type["block"]["image"]["editor"]["inner"]["attr"]= ["img"=>[
        ".builder__editor--item-image .image_url"=>"src",
        ".builder__editor--item-image .pdfcreator-image-type-editor"=>"data-type",
        ".builder__editor--item-image .pdfcreator-image-type-editor-field"=>"data-field",
        ".builder__editor--item-image .image_url"=>"src",
        ".builder__editor--item-image .image_alt"=>"alt"]];
    return $type;
}