<?php
class PDF_Shortcode_Qrcode {
    function __construct(){ 
        add_filter( 'pdf_builder_block_html', array($this,"barcode_qrcode_builder") );
        add_action("pdf_builder_block",array($this,"add_barcode_qrcode"),200)
;   }
    function add_barcode_qrcode(){
        ?>
             <li>
                <div class="momongaDraggable" data-type="barcode">
                    <i class="emailbuilder-icon icon-barcode"></i>
                    <div class="pdfbuilder-tool-text"><?php esc_html_e("Barcode","pdfcreator") ?></div>
                </div>
            </li>
            <li>
                <div class="momongaDraggable" data-type="qrcode">
                    <i class="emailbuilder-icon icon-qrcode"></i>
                    <div class="pdfbuilder-tool-text"><?php esc_html_e("Qrcode","pdfcreator") ?></div>
                </div>
            </li>
            <?php
    }
    function barcode_qrcode_builder($type){
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            $img = base64_encode($generator->getBarcode("barcode", $generator::TYPE_CODE_128));
        $type["block"]["barcode"]["builder"] = '
           <div class="builder-elements">
                <div class="builder-elements-content" data-type="barcode" data-detail_type="vertical">
                    <div class="text-content-data hidden">barcode</div>
                    <div class="text-content"><img class="barcode" src="data:image/png;base64,'.$img.'"></div>
                </div>
            </div>';
            $type["block"]["qrcode"]["builder"] = '
           <div class="builder-elements">
                <div class="builder-elements-content" data-type="qrcode" >
                    <div class="text-content-data hidden">qrcode</div>
                    <div class="text-content"><img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=qrcode" /></div>
                </div>
            </div>';
            $padding = pdfbuilder_email_global_data::$padding;
            $text_align = pdfbuilder_email_global_data::$text_align;
            $container_show = array("text-align","padding","background","html","condition");
            $container_style = array(
                    ".builder__editor--item-background .builder__editor_color"=>"background-color",
                    ".builder__editor--item-background .image_url"=>"background-image",
                );
            $inner_style = array(
                    ".builder__editor--item-width .text_width"=>"width",
                    ".builder__editor--item-height .text_height"=>"height",
                );
            $inner_attr = array(".text-content"=>array(".builder__editor--html .builder__editor--js"=>"html"),".text-content-data"=>array(".builder__editor--html .builder__editor--js"=>"html_hide"));
            $type["block"]["barcode"]["editor"]["container"]["show"]= array_merge(array("width","height"),$container_show);
            $type["block"]["barcode"]["editor"]["container"]["style"]= array_merge($padding,$container_style,$text_align);
            $type["block"]["barcode"]["editor"]["inner"]["style"]= ["img" => $inner_style];
             $type["block"]["barcode"]["editor"]["inner"]["attr"] = $inner_attr;
            $type["block"]["qrcode"]["editor"]["container"]["show"]= array_merge(array("width","height"),$container_show);
            $type["block"]["qrcode"]["editor"]["container"]["style"]= array_merge($padding,$container_style,$text_align);
            $type["block"]["qrcode"]["editor"]["inner"]["style"]= ["img" => $inner_style];
             $type["block"]["qrcode"]["editor"]["inner"]["attr"] = $inner_attr;
        return $type; 
    }
}
new PDF_Shortcode_Qrcode;