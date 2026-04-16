<?php
add_action("pdf_builder_block","pdf_builder_block_break_point",100);
function pdf_builder_block_break_point(){
    ?>
    <li>
        <div class="momongaDraggable" data-type="break">
            <i class="emailbuilder-icon icon-divide"></i>
            <div class="pdfbuilder-tool-text"><?php esc_html_e("Page Break","pdfcreator") ?></div>
        </div>
    </li>
    <?php
}
add_filter( 'pdf_builder_block_html', "pdf_builder_block_break_point_load" );
function pdf_builder_block_break_point_load($type){
   $type["block"]["break"]["builder"] = '
   <div class="builder-elements">
        <div class="builder-elements-content" data-type="break" style="padding: 15px 0;">
            <div class="page_break"></div>
        </div>
    </div>';
   //Show editor
    $type["block"]["break"]["editor"]["container"]["show"]= [];
    $padding = pdfbuilder_email_global_data::$padding;
    $type["block"]["break"]["editor"]["container"]["style"]= [];
    $type["block"]["break"]["editor"]["inner"]["style"]=[];
   return $type;
}
