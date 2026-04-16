<?php
class WPBuider_Email_Templates_Demo {
	function __construct() { 
		add_action("builder_pdf_templates",array($this,"builder_pdf_templates"),1);
        
	}
	function builder_pdf_templates(){
        $args = array(
            array(
            "json"=>PDF_CREATOR_BUILDER_URL."backend/demo/woocommerce-0.json",
            "img"=>PDF_CREATOR_BUILDER_URL."backend/demo/images/0.png",
            "title" => "Blank",
            "id"=> 107,
            ),
            array(
            "json"=>PDF_CREATOR_BUILDER_URL."backend/demo/form-9.json",
            "img"=>PDF_CREATOR_BUILDER_URL."backend/demo/images/form-9.png",
            "title" => "Template 9",
            "id"=> 132,
            ),
            array(
            "json"=>PDF_CREATOR_BUILDER_URL."backend/demo/form-10.json",
            "img"=>PDF_CREATOR_BUILDER_URL."backend/demo/images/form-10.png",
            "title" => "Agreement",
            "id"=> 142,
            ),
            array(
            "json"=>PDF_CREATOR_BUILDER_URL."backend/demo/form-11.json",
            "img"=>PDF_CREATOR_BUILDER_URL."backend/demo/images/form-11.png",
            "title" => "Inspection Services",
            "id"=> 143,
            ),
            array(
            "json"=>PDF_CREATOR_BUILDER_URL."backend/demo/form-12.json",
            "img"=>PDF_CREATOR_BUILDER_URL."backend/demo/images/form-12.png",
            "title" => "Inspection Services",
            "id"=> 144,
            ),
            array(
            "json"=>PDF_CREATOR_BUILDER_URL."backend/demo/form-13.json",
            "img"=>PDF_CREATOR_BUILDER_URL."backend/demo/images/form-13.png",
            "title" => "CV Template",
            "id"=> 240,
            ),
            array(
            "json"=>PDF_CREATOR_BUILDER_URL."backend/demo/form-14.json",
            "img"=>PDF_CREATOR_BUILDER_URL."backend/demo/images/form-14.png",
            "title" => "Quotation Request",
            "id"=> 243,
            )
        );
        foreach ($args as $value) {
            Settings_Builder_PDF_Backend::item_demo($value);
        }
	}
}
new WPBuider_Email_Templates_Demo;