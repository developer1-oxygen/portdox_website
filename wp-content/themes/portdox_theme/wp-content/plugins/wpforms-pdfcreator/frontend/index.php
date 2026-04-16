<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
use Dompdf\Dompdf;
class FDF_Create_frontend {
	function __construct(){
       add_filter( 'wp_mail_content_type',array($this,'set_content_type') );
       add_filter('upload_mimes', array($this,'mime_types'));
       add_action('init',array($this,'load_custom_template_woo'));
    }
    public static function cover_array_to_css($array){
    	$result = implode(PHP_EOL, array_map(
				    function ($v, $k) { 
				    	return sprintf("%s: %s;", $k, $v); },
				    $array,
				    array_keys($array)
				));
    	return $result;
    }
    function load_custom_template_woo(){
    	 add_filter( 'template_include',array($this,'template_include'),99);
    }
    function template_include($template) {
	    if( isset($_GET['pdf_preview']) ){
	        if( $_GET['pdf_preview'] == "preview") {
	             $template = PDF_CREATOR_BUILDER_PATH."preview.php";   
	        }
	        if ( file_exists( $template ) ) { 
	            return $template;
	        }
	    }else{
	     	return $template;
	    }
	}
	function set_content_type(){
	    return "text/html";
	}
	function mime_types($mimes) {
	    $mimes['json'] = 'text/plain';
	    return $mimes;
	}
	public static function pdf_creator_preview( $id_template, $type ="preview", $name="pdf_data",$html="",$woo_order_id = "",$packing_slip = false,$datas = array(),$return_html = null){
		if (!function_exists('str_get_html')) { 
			include PDF_CREATOR_BUILDER_PATH."frontend/simple_html_dom.php";
		}
		$upload_dir = wp_upload_dir();
	    $dompdf = new Dompdf();
	    $data_orders = array();
	    if( $woo_order_id !="" && $woo_order_id != 0){
	    	if( $id_template == -1 ){ 
	    		if($packing_slip){
		    		$options_woo = get_option( "woocommerce_pdf_packing");
		    	}else{
		    		$options_woo = get_option( "woocommerce_pdf");
		    	}
		    	$id_template = $options_woo["new_order"];
	    	}
	    	$data_orders = explode(",",$woo_order_id);
			$order_shortcode = new PDF_Woocommerce_Shortcode();
			$order_shortcode->set_order_id($data_orders[0]);
		}
		$id = FDF_Create_frontend::get_html($id_template,$datas);
		if( $return_html ){
			return $id;
		}
		ob_start();
	    include PDF_CREATOR_BUILDER_PATH."email-templates/header.php";
	    $settings = get_post_meta( $id_template,'_builder_pdf_settings',true); 
	    //Start page number
	    if( isset($settings["show_page"]) && $settings["show_page"] =="yes" ) {
	    	?>
	    	<footer>
		       <div class="page-number"></div>
		  </footer>
	    	<?php
	    }
	    if( count($data_orders) > 1 ) {
	    	$i=1;
	    	foreach( $data_orders as $order_id ){
	    		$order_shortcode->set_order_id($order_id);
	    		$id = FDF_Create_frontend::get_html($id_template,$datas);
	    		printf("%s", do_shortcode($id));
	    		if( $i < count($data_orders) ) {
	    			printf('<div class="page_break"></div>');
	    		}
	    		$i++;
	    	}
	    }else{
	    	if($html == ""){
    			printf("%s", do_shortcode($id));
    		}else{
    			printf("%s", do_shortcode($html));
    		}
	    }
	    include PDF_CREATOR_BUILDER_PATH."email-templates/footer.php";
	    $html= ob_get_clean();
		$pattern = '/([^"\/]*\/?[^".]*\.[^"]*)/';
		$imgExt = ['.png', '.gif', '.jpg', '.jpeg'];	    
		$wp_upload_dir = wp_upload_dir();
		$html = preg_replace_callback($pattern,
			function ($m) use ($imgExt ,$wp_upload_dir ) {
			    if ( false === $extension = parse_url($m[0], PHP_URL_PATH) )
			        return $m[0];
			    $extension = strtolower(strrchr($extension, '.'));
			    if ( in_array($extension, $imgExt) ){
			    	$links = explode("wp-content/uploads",$m[0] );
			    	if( isset($links[1]) ){
			    		return $path_main = WP_CONTENT_DIR . '/uploads' . $links[1];
			    	}
			        return $m[0];
			    }
			    return $m[0];
			},
    		$html
    	);
    	if( is_rtl() ){
    		require_once PDF_CREATOR_BUILDER_PATH.'rtl/arabic.php';
    		$Arabic = new ArPHP\I18N\Arabic();
			$p = $Arabic->arIdentify($html);
			for ($i = count($p)-1; $i >= 0; $i-=2) {
			    $utf8ar = $Arabic->utf8Glyphs(substr($html, $p[$i-1], $p[$i] - $p[$i-1]));
			    $html   = substr_replace($html, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
			}
    	}
	    $dompdf->loadHtml($html);
	    $size = $settings["size"];
	    $sizes = explode(",",$size);
	    if( count($sizes) > 1 ){
	    	$height = 2.838 * $sizes[0]; 
	    	$width = 2.838 * $sizes[1];  
	    	$size = array(0,0,$height,$width);
	    }
	    $dompdf->setPaper($size,$settings["orientation"] );
	    $dompdf->set_option("dpi", $settings["dpi"]);
	    $dompdf->set_option('isRemoteEnabled', true);
	    $dompdf->set_option('chroot', WP_CONTENT_DIR);
	    $dompdf->render();
	    switch( $type ){
	      case "download":
	        $dompdf->stream($name.".pdf", array("Attachment" => true));
	        break;
	      case "upload":
	          $path_main = $upload_dir['basedir'] . '/pdfs/';  
	          if ( ! file_exists( $path_main ) ) {
	              wp_mkdir_p( $path_main );
	          }
	          $output = $dompdf->output();
	          file_put_contents($path_main.$name.".pdf", $output);
	          return $path_main.$name.".pdf";
	        break;
	      case "html":
	        printf("%s",$html);
	        break;
	      default:
	        $dompdf->stream($name.".pdf", array("Attachment" => false));
	        break;
	    }
	}
	public static function get_html( $id_template, $datas="", $order_id = null ){
		$html ="";
		$data_json = get_post_meta( $id_template,'data_email',true);
		$data_json = json_decode($data_json,true);
		$container = $data_json["container"];
		$data_contents = $data_json["rows"];
		$datas_builder = apply_filters("pdf_builder_block_html",array());
		$html = "";
		ob_start();
		?>
		<style>
			body {background-color: <?php echo esc_attr( $container["background-color"] ) ?> !important;}
            @page{margin: <?php echo esc_attr( $container["padding-top"] ) ?> <?php echo esc_attr( $container["padding-right"] ) ?> <?php echo esc_attr( $container["padding-bottom"] ) ?> <?php echo esc_attr( $container["padding-left"] ) ?>;}
            .container {
            	<?php 
            	$container_css = FDF_Create_frontend::cover_array_to_css($container);
				 printf("%s",$container_css);
				?>
            }
       </style>
		<div class="wap" width="100%" style="margin: 0 auto;">
			<div class="container" style="margin: 0 auto;" >
		<?php
		foreach( $data_contents as $row){
			$row_columns = $row["columns"];
			$row_condition = $row["condition"];
			$show_row = FDF_Create_frontend::is_logic($row_condition,$datas);
			$row_style = FDF_Create_frontend::cover_array_to_css($row["style"]);
			if( $show_row ) {
			?>
			<div class="container-row" style="width:100%;">
				<div class="row" style="<?php printf("%s",$row_style);  ?>">
					<?php 
					$i=0;
					foreach( $row_columns as $column ){
						switch ($row["type"]){
							case "row2":
								$col_width = "50%";
								break;
							case "row3":
								if( $i == 0 ){
									$col_width = "65%";
								}else{
									$col_width = "35%";
								}
								break;
							case "row4":
								if( $i == 0 ){
									$col_width = "35%";
								}else{
									$col_width = "35%";
								}
								break;
							case "row5":
								$col_width = "33.33%";
								break;
							case "row6":
								$col_width = "25%";
								break;
							default:
								$col_width = "100%";
								break;
						}
						$column_css = FDF_Create_frontend::cover_array_to_css($container);
						?>
						<div class="col" style="width: <?php echo esc_attr( $col_width ); ?>">
							<div class="col-container">
								<?php 
								$elements = $column["elements"];
								foreach( $elements as $element ){
									$element_html = FDF_Create_frontend::cover_type_element_to_html($element,$datas_builder,$datas);
						             printf("%s",$element_html); 
								}
								?>
							</div>
						</div>
						<?php
						$i++;
					} ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php
			}
		}
		?>
			</div>
		</div>
		<?php
		$html= ob_get_clean();
		return $html;
	}
	public static function cover_type_element_to_html($element,$datas_builder, $datas=array()){
    	$result = "";
    	$html = "";
    	$datas_builder = $datas_builder["block"];
    	$type = $element["type"];
    	$inner_attr = $element["inner_attr"];
    	$container_style = FDF_Create_frontend::cover_array_to_css($element["container_style"]);
    	$inner_style = $element["inner_style"];
    	$element_condition = $element["condition"];
    	$html_el = str_get_html($datas_builder[ $type ]["builder"]);
    	$show = FDF_Create_frontend::is_logic($element_condition,$datas);
    	 if( $show ){
	    	 $html_el->find('.builder-elements-content',0)->setAttribute("style",$container_style);
	    	 foreach( $inner_attr as $key => $attrs ){
	    	 	foreach( $attrs as $k => $v ){
	    	 		$v = do_shortcode($v);
	    	 		switch( $type ){
	    	 			case "qrcode":
	    	 				if( $k == "html_hide"){
			    	 			$html_el->find( $key ,0)->removeClass('hidden');
			    	 			$html_el->find( $key ,0)->innertext = do_shortcode('[wp_builder_pdf_qrcode]'.$v.'[/wp_builder_pdf_qrcode]');
			    	 		}elseif( $k == "html"){
			    	 			$html_el->find( $key ,0)->remove();
			    	 		}else{
			    	 			$html_el->find( $key ,0)->setAttribute($k,$v);
			    	 		}
	    	 				break;
	    	 			case "barcode":
	    	 				if( $k == "html_hide"){
			    	 			$html_el->find( $key ,0)->removeClass('hidden');
			    	 			$html_el->find( $key ,0)->innertext = do_shortcode('[wp_builder_pdf_barcode]'.$v.'[/wp_builder_pdf_barcode]');
			    	 		}elseif( $k == "html"){
			    	 			$html_el->find( $key ,0)->remove();
			    	 		}else{
			    	 			$html_el->find( $key ,0)->setAttribute($k,$v);
			    	 		}
	    	 				break;
	    	 			case "image":
	    	 				if( $attrs["data-type"] == 1){
			    	 			$html_el->find( "img" ,0)->setAttribute("src",$attrs["data-field"]);
			    	 		}else{
			    	 			if( $v != ""){
			    	 				$html_el->find( $key ,0)->setAttribute($k,$v);
			    	 			}
			    	 		}
	    	 				break;
	    	 			default:
	    	 				//text
	    	 				if( $k == "html_hide"){
			    	 			$html_el->find( $key ,0)->removeClass('hidden');
			    	 			$html_el->find( $key ,0)->innertext = $v;
			    	 		}elseif( $k == "html"){
			    	 			$html_el->find( $key ,0)->remove();
			    	 		}
			    	 		else{
			    	 			$html_el->find( $key ,0)->setAttribute($k,$v);
			    	 		}
	    	 				break;
	    	 		}
	    	 	}
	    	 }
	    	 $html_el = str_get_html($html_el);
	    	 foreach( $inner_style as $key => $style ){
	    	 	$in_style = FDF_Create_frontend::cover_array_to_css($style);
	    	 	$html_el->find( $key ,0)->setAttribute("style",$in_style);
	    	 }
	    	return $html_el;
    	 }
    	 return $html;
    }
    public static function is_logic($conditional, $datas = null, $test = false){
    	if( isset($_GET["preview"] )){
    		return true;
    	}
    	if( $conditional != "" ){
	    	$conditional = rawurldecode($conditional);
			$conditional = json_decode($conditional,true);
	    	if( isset($conditional["conditional"]) && count($conditional["conditional"])> 0 ){
	    		$check = array();
	    		foreach( $conditional["conditional"] as $condition ){
	    			$name = $condition["name"];
	    			$rule = $condition["rule"];
	    			$value = $condition["value"];
	    			if( isset( $datas[ $name] )){
	    				$data_value = $datas[$name];
	    			}else{
	    				$data_value = do_shortcode($name);
	    			}
	    			switch( $rule ){
		 				case "is":
		 					if( $value == $data_value){
		 						$check[] = true;
		 					}
		 					break;
		 				case "isnot":
		 					if( $value != $datas[$name]){
		 						if( $element_condition["logic"] == "any"){
		 							$check[] = true;
		 							break;
		 						}
		 					}
		 					break;
		 				case 'greater_than':
		 					if( $datas[$name] > $value ){
		 						if( $element_condition["logic"] == "any"){
		 							$check[] = true;
		 							break;
		 						}
		 					}
		 					break;
		 				case 'less_than':
		 					if( $datas[$name] < $value ){
		 						if( $element_condition["logic"] == "any"){
		 							$check[] = true;
		 							break;
		 						}
		 					}
		 					break;
		 				case 'contains':
		 					if( str_contains($datas[$name],$value) ){
		 						if( $element_condition["logic"] == "any"){
		 							$check[] = true;
		 							break;
		 						}
		 					}
		 					break;
		 				case 'starts_with':
		 					if( str_starts_with($datas[$name],$value) ){
		 						if( $element_condition["logic"] == "any"){
		 							$check[] = true;
		 							break;
		 						}
		 					}
		 					break;
		 				case 'ends_with':
		 					if( str_ends_with($datas[$name],$value) ){
		 						if( $element_condition["logic"] == "any"){
		 							$check[] = true;
		 							break;
		 						}
		 					}
		 					break;
	    	 			}
	    		}
	    		if( $conditional["logic"] == "all" ){
	    			if(count($check) == count($conditional["conditional"]) ){
	    				if( $conditional["type"] == "show" ){ 
	    					return true;
	    				}else{
	    					return false;
	    				}
	    			}else{
	    				if( $conditional["type"] == "show" ){ 
	    					return false;
	    				}else{
	    					return true;
	    				}
	    			}
	    		}else{
	    			if( count($check) >0 ){ 
	    				if( $conditional["type"] == "show" ){ 
	    					return true;
	    				}else{
	    					return false;
	    				}
	    			}else{
	    				if( $conditional["type"] == "show" ){ 
	    					return false;
	    				}else{
	    					return true;
	    				}
	    			}
	    		}
	    	}
	    }
    	return true;
    }
}
new FDF_Create_frontend;