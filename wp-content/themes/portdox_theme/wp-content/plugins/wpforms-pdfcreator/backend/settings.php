<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
use Dompdf\Dompdf;
use Dompdf\CanvasFactory;
use Dompdf\Exception;
use Dompdf\FontMetrics;
use Dompdf\Options;
use FontLib\Font;
class pdfbuilder_PDF_Settings {
		function __construct() { 
		 add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		 add_action( 'wp_ajax_pdfceator_remove_font', array($this,"remove_font"));
		 add_action( 'pdfcreator_custom_sizes', array($this,"add_sizes"));
	}
	function add_sizes($sizes){
		$settings = get_option("pdf_creator_papers","201,297");
		$datas = explode("\n",$settings);
		if( is_array($datas) ){
			foreach($datas as $data){
				$pages = explode(",",$data);
				$sizes[$data] =	"(".$pages[0]." x ".$pages[1]."mm)";
			}
		}
		return $sizes;
	}
	function remove_font(){
		$fontname = sanitize_text_field($_POST["font_name"]);
		$dompdf = new Dompdf();
		$fontMetrics = $dompdf->getFontMetrics();
		$get_fonts = $fontMetrics->get_family($fontname);
		foreach( $get_fonts as $part ){
			unlink($part.".ttf");
			unlink($part.".otf");
			unlink($part.".woff2");
			unlink($part.".ufm");
		}
		unlink($part.".ufm");
		unlink($dompdf->getOptions()->get('fontDir') ."/dompdf_font_family_cache.php");
		die();
	}
	function add_plugin_page(){
		add_submenu_page('edit.php?post_type=pdf_template','Settings', 'Settings', 'manage_options','pdfbuilder-email-settings', array($this,'settings_page')  );
		add_action( 'admin_init', array($this,'register_settings') );
	}
	function register_settings(){
		register_setting( 'pdf_creator_font', 'pdf_creator_font' );
		
		$fonts = array("regular"=>null,"bold"=>null,"italic"=>null,"bold_italic"=>null);
		if( isset($_POST['pdf_creator_papers'])) { 
			register_setting( 'pdf_creator_font', 'pdf_creator_papers' );
		}
		if( isset($_FILES['pdf_creator_font_upload_regular'])) {
				$upload_dir = wp_upload_dir(); 
				$files = $_FILES['pdf_creator_font_upload_regular'];
				$file = $files["tmp_name"];
				if( $file !="" ) {
					$part = $upload_dir["path"]."/".$files['name'];
					move_uploaded_file($file,$part);
					$fonts["regular"] = $part;
				}
		}
		if( isset($_FILES['pdf_creator_font_upload_bold'])) {
				$upload_dir = wp_upload_dir(); 
				$files = $_FILES['pdf_creator_font_upload_bold'];
				$file = $files["tmp_name"];
				if( $file !="" ) {
					$part = $upload_dir["path"]."/".$files['name'];
					move_uploaded_file($file,$part);
					$fonts["bold"] = $part;
				}
		}
		if( isset($_FILES['pdf_creator_font_upload_italic'])) {
				$upload_dir = wp_upload_dir(); 
				$files = $_FILES['pdf_creator_font_upload_italic'];
				$file = $files["tmp_name"];
				if( $file !="" ) {
					$part = $upload_dir["path"]."/".$files['name'];
					move_uploaded_file($file,$part);
					$fonts["italic"] = $part;
				}
		}
		if( isset($_FILES['pdf_creator_font_upload_bold_italic'])) {
				$upload_dir = wp_upload_dir(); 
				$files = $_FILES['pdf_creator_font_upload_bold_italic'];
				$file = $files["tmp_name"];
				if( $file !="" ) {
					$part = $upload_dir["path"]."/".$files['name'];
					move_uploaded_file($file,$part);
					$fonts["bold_italic"] = $part;
				}
		}
		if( $fonts["regular"] && $_POST['pdf_creator_font_name'] != "" ) {
			$dompdf = new Dompdf();
			if (isset($fontDir) && realpath($fontDir) !== false) {
			  $dompdf->getOptions()->set('fontDir', $fontDir);
			}
			$name = sanitize_text_field($_POST['pdf_creator_font_name']);
			$this->install_font_family($dompdf,$name,$fonts["regular"],$fonts["bold"],$fonts["italic"],$fonts["bold_italic"]);
		}
	}
	function install_font_family($dompdf, $fontname, $normal, $bold = null, $italic = null, $bold_italic = null) {
	  $fontMetrics = $dompdf->getFontMetrics();
	  // Check if the base filename is readable
	  $dir = dirname($normal);
	  $basename = basename($normal);
	  $last_dot = strrpos($basename, '.');
	  if ($last_dot !== false) {
	    $file = substr($basename, 0, $last_dot);
	    $ext = strtolower(substr($basename, $last_dot));
	  } else {
	    $file = $basename;
	    $ext = '';
	  }
	  // Try $file_Bold.$ext etc.
	  $path = "$dir/$file";
	  $patterns = array(
	    "bold"        => array("_Bold", "b", "B", "bd", "BD"),
	    "italic"      => array("_Italic", "i", "I"),
	    "bold_italic" => array("_Bold_Italic", "bi", "BI", "ib", "IB"),
	  );
	  foreach ($patterns as $type => $_patterns) {
	    if ( !isset($$type) || !is_readable($$type) ) {
	      foreach($_patterns as $_pattern) {
	        if ( is_readable("$path$_pattern$ext") ) {
	          $$type = "$path$_pattern$ext";
	          break;
	        }
	      }
	    }
	  }
	  $fonts = compact("normal", "bold", "italic", "bold_italic");
	  $entry = array();
	  // Copy the files to the font directory.
	  foreach ($fonts as $var => $src) {
	    if ( is_null($src) ) {
	      $entry[$var] = $dompdf->getOptions()->get('fontDir') . '/' . mb_substr(basename($normal), 0, -4);
	      continue;
	    }
	    // Verify that the fonts exist and are readable
	    $dest = $dompdf->getOptions()->get('fontDir') . '/' . basename($src);
	    if ( !copy($src, $dest) )
	      throw new Exception("Unable to copy '$src' to '$dest'");
	    $entry_name = mb_substr($dest, 0, -4);
	    $font_obj = Font::load($dest);
	    $font_obj->saveAdobeFontMetrics("$entry_name.ufm");
	    $font_obj->close();
	    $entry[$var] = $entry_name;
	  }
	  // Store the fonts in the lookup table
	  $fontMetrics->setFontFamily($fontname, $entry);
	  // Save the changes
	  $fontMetrics->saveFontFamilies();
	}
	function settings_page(){
		$dompdf = new Dompdf();
		$fontMetrics = $dompdf->getFontMetrics();
		$fonts = $fontMetrics->get_font_families();
		?>
		<div class="wrap">
		<h1><?php esc_html_e("PDF Creator Settings","pdfcreator") ?></h1>
		<h3><?php esc_html_e("Font Manage","pdfcreator") ?></h3>
		<div class="list-fonts">
			<div class="header-list-fonts">
				<div><?php esc_html_e("Installed Fonts","pdfcreator") ?></div>
				<div><?php esc_html_e("Regular","pdfcreator") ?></div>
				<div><?php esc_html_e("Italics","pdfcreator") ?></div>
				<div><?php esc_html_e("Bold","pdfcreator") ?></div>
				<div><?php esc_html_e("Bold Italics","pdfcreator") ?></div>
				<div><?php esc_html_e("Remove","pdfcreator") ?></div>
			</div>
			<?php foreach($fonts as $key => $font){ ?>
			<div class="container-list-fonts">
				<div class="pdf-font-name" style="font-family: '<?php echo esc_attr($key) ?>'"><?php echo esc_html($key); ?> </div>
				<?php 
					$i = 0;
					$normal ="";
					foreach( $font as $k =>$vl ){
						if($i==0){
							$normal = $vl;
							$class = "yes";
						}else{
							if( $normal == $vl ) {
								$class = "no";
							}else{
								$class = "yes";	
							}
						}
						printf('<div><span class="dashicons dashicons-%s"></span></div>',$class);
						?>
						<?php
						$i++;
					}
					if( $key != "sans-serif" && $key != "helvetica" ){
				?>
				<div><a href="#" class="pdf-remove-font"><span class="dashicons dashicons-trash"></span></a></div>
					<?php
				}
				 ?>
			</div>
		<?php } ?>
		</div>
		<h3><?php esc_html_e("Add Font","pdfcreator") ?></h3>
		<form method="post" action="options.php" enctype="multipart/form-data">
		    <?php settings_fields( 'pdf_creator_font' ); ?>
		    <?php do_settings_sections( 'pdf_creator_font' ); ?>
		   <table class="form-table">
				        <tr valign="top">
					        <th scope="row"><?php esc_html_e("Font Name *","pdfcreator") ?>
					        </th>
					        <td>
					        	 <input type="text" name="pdf_creator_font_name" class="pdf_creator_font_name">
					        	 <p><?php esc_html_e("The font name can only contain letters, numbers and spaces.","pdfcreator") ?></p>
					        </td>
				        </tr>
				    	<tr valign="top">
					        <th scope="row"><?php esc_html_e("Regular *","pdfcreator") ?>
					        </th>
					        <td>
					        	 <input class="pdf_creator_font_files" type="file" name="pdf_creator_font_upload_regular">
					        </td>
				        </tr>
				        <tr valign="top">
					        <th scope="row"><?php esc_html_e("Italics","pdfcreator") ?>
					        </th>
					        <td>
					        	 <input class="pdf_creator_font_files" type="file" name="pdf_creator_font_upload_italic">
					        </td>
				        </tr>
				        <tr valign="top">
					        <th scope="row"><?php esc_html_e("Bold","pdfcreator") ?>
					        </th>
					        <td>
					        	 <input class="pdf_creator_font_files" type="file" name="pdf_creator_font_upload_bold">
					        </td>
				        </tr>
				        <tr valign="top">
					        <th scope="row"><?php esc_html_e("Bold Italics","pdfcreator") ?>
					        </th>
					        <td>
					        	 <input class="pdf_creator_font_files" type="file" name="pdf_creator_font_upload_bold_italic">
					        </td>
				        </tr>
				    </table>
		    <?php submit_button("Add Font"); ?>
		</form>
		<form method="post" action="options.php">
		    <?php settings_fields( 'pdf_creator_font' ); ?>
		    <?php do_settings_sections( 'pdf_creator_font' ); ?>
		   <table class="form-table">
				        <tr valign="top">
					        <th scope="row"><?php esc_html_e("Custom PDF Paper (mm)","pdfcreator") ?>
					        </th>
					        <td>
					        	 <textarea class="large-text code" row="4" name="pdf_creator_papers"><?php echo esc_textarea(get_option("pdf_creator_papers","201,297")) ?></textarea>
					        	 <p><?php esc_html_e("One size per line. E.g 1 line: 210,297","pdfcreator") ?></p>
					        </td>
				        </tr>
				    	
				    </table>
		    <?php submit_button(); ?>
		</form>
		</div>
		<?php
	}
}
new pdfbuilder_PDF_Settings;