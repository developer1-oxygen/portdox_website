<?php
class pdfbuilder_email_editor {
    function __construct(){
      add_action("builder_email_tab__editor",array($this,"builder_email_tab__editor"),100);  
    }
    public static function get_color_pick($text = "Color Pick"){
        return '<div class="builder__editor--color">
                <label>'.$text.'</label>
                <div class="">
                    <input type="text" value="#e7e7e7" class="builder__editor_color">
                </div>
            </div>';
    }
    public static function get_padding() {
        return '<div class="builder__editor--padding">
                <div>
                    <label>'.esc_html__("Top","pdfcreator").'</label>
                    <input data-after_value="px" class="builder__editor--padding-top touchspin" type="text" placeholder="px" />
                </div>
                <div>
                    <label>'. esc_html__("Bottom","pdfcreator").'</label>
                    <input data-after_value="px" class="builder__editor--padding-bottom touchspin" type="text" placeholder="px" />
                </div>
                <div>
                    <label>'.esc_html__("Left","pdfcreator").'</label>
                    <input data-after_value="px" class="builder__editor--padding-left touchspin" type="text" placeholder="px" />
                </div>
                <div>
                    <label>'.esc_html__("Right","pdfcreator").'</label>
                    <input data-after_value="px" class="builder__editor--padding-right touchspin" type="text" placeholder="px" />
                </div>
            </div>';
    }
    function builder_email_tab__editor(){
    ?>
        <div class="builder__editor--item builder__editor--item-html">
            <div class="builder__editor--html">
                <label><?php esc_html_e("Content","pdfcreator") ?></label>
                <textarea id="builder__editor--js" class="builder__editor--js"></textarea>
            </div>
        </div>
        <div class="builder__editor--item builder__editor--item-video">
            <div class="builder__editor--video">
                <label><?php esc_html_e("Youtube","pdfcreator") ?></label>
                <input type="text" class="video_url">
            </div>
        </div>
        <div class="builder__editor--item builder__editor--item-image">
            <label><?php esc_html_e("Image","pdfcreator") ?></label>
            <div class="builder__editor--button-url">
                <select class="pdfcreator-image-type-editor">
                        <option value="0"><?php esc_html_e("Upload Image","pdfcreator") ?></option>
                        <option value="1"><?php esc_html_e("Use Field","pdfcreator") ?></option>
                </select>
                <div class="pdfcreator-image-type-upload">
                    <label><?php esc_html_e("Source URL","pdfcreator") ?></label>
                    <input type="text" class="image_url" placeholder="Source url">
                    <input type="button" class="upload-editor--image button button-primary" value="Upload">
                </div>
                <div class="pdfcreator-image-type-field">
                    <select class="pdfcreator-image-type-editor-field">
                        <option value="0"><?php esc_html_e("Choose Field","pdfcreator") ?></option>
                        <?php 
                        $lists = apply_filters("wp_builder_pdf_shortcode",array());
                        foreach( $lists as $shortcode ){
                            if( $shortcode["value"] != ""){
                            ?>
                            <option value="<?php echo esc_html($shortcode["value"]) ?>"><?php echo esc_html($shortcode["text"]) ?></option>
                            <?php }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="builder__editor--button-url">
                <label><?php esc_html_e("Alt","pdfcreator") ?></label>
                <input type="text" class="image_alt" placeholder="Image alt" >
            </div>
        </div>
        <div class="builder__editor--item builder__editor--item-button">
            <div class="builder__editor--button">
                <label><?php esc_html_e("Button","pdfcreator") ?></label>
                <div class="builder__editor--button-text">
                    <label><?php esc_html_e("Button text","pdfcreator") ?></label>
                    <input type="text" class="button_text" value="Button text">
                </div>
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("Button url","pdfcreator") ?></label>
                    <input type="text" class="button_url" placeholder="Button url" >
                </div>
                <div class="builder__editor--button-range">
                    <label><?php esc_html_e("Font size","pdfcreator") ?></label>
                    <input data-after_value="px" type="text" value="16" class="font_size touchspin" min="10" max="30">
                </div>
            </div>
        </div>
        <div class="builder__editor--item builder__editor--item-background">
            <?php echo pdfbuilder_email_editor::get_color_pick(esc_html__("Background color","pdfcreator")) ?>
            <div class="builder__editor--button-url">
                <label><?php esc_html_e("Background Image","pdfcreator") ?></label>
                <input type="text" class="image_url" placeholder="Source url">
                <input type="button" class="upload-editor--image button button-primary" value="Upload">
            </div>
        </div>
        <div class="builder__editor--item builder__editor--item-background_full">
            <label><?php esc_html_e("Background Full Width","pdfcreator") ?></label>
                    <input type="checkbox" class="background_full_width" >
        </div>
        <div class="builder__editor--item builder__editor--item-color">
            <?php echo pdfbuilder_email_editor::get_color_pick(esc_html__("Color","pdfcreator")) ?>
        </div>
        <div class="builder__editor--item builder__editor--item-menu">
            <div class="builder__editor--item-menu-hidden hidden">
                <ul>
                    <li>
                        <label><?php esc_html_e("Text","pdfcreator") ?></label>
                        <input type="text" class="text"> 
                    </li>
                    <li>
                        <label><?php esc_html_e("Url","pdfcreator") ?></label>
                        <input type="text" class="text_url">
                    </li>
                    <li>
                        <label><?php esc_html_e("Background","pdfcreator") ?></label>
                        <input type="text" class="text_background" value="transparent">
                    </li>
                    <li>
                         <label><?php esc_html_e("Color","pdfcreator") ?></label>
                            <input type="text" value="#fff" class="text_color"> 
                    </li>
                </ul>
            </div>
           <div class="menu-content-tool">
           </div>
            <a class="pdfbuilder_email_add_menu button button-primary" href="#"><?php esc_html_e("Add menu","pdfcreator") ?></a>
        </div>
        <div class="builder__editor--item builder__editor--item-social">
            <label><?php esc_html_e("Social","pdfcreator") ?></label>
            <div class="builder__editor--social-facebook">
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("URL Facebook","pdfcreator") ?></label>
                    <input type="text" class="social_url" placeholder="URl" >
                </div>
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("Show/ hide","pdfcreator") ?></label>
                    <input type="checkbox" class="social_show" >
                </div>
            </div>
            <div class="builder__editor--social-twitter">
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("URL Twitter","pdfcreator") ?></label>
                    <input type="text" class="social_url" placeholder="URl" >
                </div>
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("Show/ hide","pdfcreator") ?></label>
                    <input type="checkbox" class="social_show" >
                </div>
            </div>
            <div class="builder__editor--social-instagram">
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("URL Instagram","pdfcreator") ?></label>
                    <input type="text" class="social_url" placeholder="URl" >
                </div>
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("Show/ hide","pdfcreator") ?></label>
                    <input type="checkbox" class="social_show" >
                </div>
            </div>
            <div class="builder__editor--social-linkedin">
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("URL Linkedin","pdfcreator") ?></label>
                    <input type="text" class="social_url" placeholder="URl" >
                </div>
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("Show/ hide","pdfcreator") ?></label>
                    <input type="checkbox" class="social_show" >
                </div>
            </div>
            <div class="builder__editor--social-whatsapp">
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("URL Whatsapp","pdfcreator") ?></label>
                    <input type="text" class="social_url" placeholder="URl" >
                </div>
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("Show/ hide","pdfcreator") ?></label>
                    <input type="checkbox" class="social_show" >
                </div>
            </div>
            <div class="builder__editor--social-youtube">
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("URL Whatsapp","pdfcreator") ?></label>
                    <input type="text" class="social_url" placeholder="URl" >
                </div>
                <div class="builder__editor--button-url">
                    <label><?php esc_html_e("Show/ hide","pdfcreator") ?></label>
                    <input type="checkbox" class="social_show" >
                </div>
            </div>
        </div>
        <div class="builder__editor--item builder__editor--item-text-align">
            <label><?php esc_html_e("Text align","pdfcreator") ?></label>
            <div class="builder__editor--align">
                <a class="button__align builder__editor--align-left" data-value="left"><i class="emailbuilder-icon icon-align-left"></i></a>
                <a class="button__align builder__editor--align-center" data-value="center"><i class="emailbuilder-icon icon-align-justify"></i></a>
                <a class="button__align builder__editor--align-right" data-value="right"><i class="emailbuilder-icon icon-align-right"></i></a>
                <input type="text" value="left" class="text_align hidden">
            </div>
        </div>
        <div class="builder__editor--item builder__editor--item-width">
            <label><?php esc_html_e("Width","pdfcreator") ?></label>
            <input data-after_value="px" type="text" class="text_width touchspin">
        </div>
        <div class="builder__editor--item builder__editor--item-height">
            <label><?php esc_html_e("Height","pdfcreator") ?></label>
            <input data-after_value="px" type="text" class="text_height touchspin">
        </div>
        <div class="builder__editor--item builder__editor--item-padding">
            <label><?php esc_html_e("Padding","pdfcreator") ?></label>
            <?php echo pdfbuilder_email_editor::get_padding() ?>
        </div>
        <div class="builder__editor--item builder__editor--item-margin">
            <label><?php esc_html_e("Margin","pdfcreator") ?></label>
            <?php echo pdfbuilder_email_editor::get_padding() ?>
        </div>
        <div class="builder__editor--item builder__editor--item-border">
            <label><?php esc_html_e("Border","pdfcreator") ?></label>
            <label><?php esc_html_e("Border Width","pdfcreator") ?></label>
            <div class="builder__editor--item-border-width">
                <?php echo pdfbuilder_email_editor::get_padding() ?>
                <label class="hidden"><?php esc_html_e("Border Style","pdfcreator") ?></label>
                <input type="text" value="solid" class="border_style hidden">
                <?php echo pdfbuilder_email_editor::get_color_pick(esc_html__("Border color","pdfcreator")) ?> 
            </div>
            <label><?php esc_html_e("Border radius","pdfcreator") ?></label>
            <div class="builder__editor--item-border-radius">
                <?php echo pdfbuilder_email_editor::get_padding() ?>
            </div>
        </div>
        <div class="builder__editor--item builder__editor--item-condition">
            <label><?php esc_html_e("Condition","pdfcreator") ?></label>
            <textarea class="builder__editor--condition hidden"></textarea>
            <a href="#" class="manager_condition button"><?php esc_html_e("Manager Condition","pdfcreator") ?></a>
            <?php add_thickbox(); ?>
            <div id="pdfbuilder-popup-content" style="display:none;">
                 <div class="pdfbuilder-popup-content">
                    <select name="" id="pdfcreator-logic-type">
                        <option value="show"><?php esc_html_e("Show","pdfcreator") ?></option>
                        <option value="hide"><?php esc_html_e("Hide","pdfcreator") ?></option>
                    </select>
                    <?php esc_html_e(" this field if","pdfcreator") ?>
                    <select name="" id="pdfcreator-logic-logic">
                        <option value="all"><?php esc_html_e("All","pdfcreator") ?></option>
                        <option value="any"><?php esc_html_e("Any","pdfcreator") ?></option>
                    </select>
                    <?php esc_html_e("of the following match:","pdfcreator") ?>
                    <div class="text-center">
                        <a href="#" class="pdfbuilder_condition_add button"><?php esc_html_e("Add Condition","pdfcreator") ?></a>
                    </div>
                    <div class="pdfbuilder-popup-layout" >
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
new pdfbuilder_email_editor();