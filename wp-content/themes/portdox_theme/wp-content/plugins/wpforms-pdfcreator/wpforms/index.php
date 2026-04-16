<?php
class PDF_Creator_WPFroms_Backend {
	function __construct(){
		add_filter("wp_builder_pdf_shortcode",array($this,"add_shortcode"));
		add_action("pdfcreator_head_settings",array($this,"add_head_settings"));
		add_action( 'save_post_pdf_template',array( $this, 'save_metabox' ), 10, 2 );
		add_action("pdf_builder_block",array($this,"block_gravity"),200);
        add_filter( 'pdf_builder_block_html', array($this,"block_builder") );
        add_action("wpforms_form_settings_notifications_single_after",array($this,"add_settings_notif"),10,2);
        add_filter("wpforms_entry_email_atts",array($this,"add_email"),9999,5);
        add_filter("wpforms_entry_details_sidebar_actions_link",array($this,"add_link_download"),10,3);
        add_filter("wpforms_entry_save_fields",array($this,"wpforms_entry_save_fields"),10,3);
        //add_filter("wpforms_smarttags_process_value",array($this,"wpforms_process_smart_tags"),10,6);
	}
	function wpforms_process_smart_tags($value,
				$tag_name,
				$form_data,
				$fields,
				$entry_id,
				$smart_tag_object){
		$lists = preg_split('/\r\n|[\r\n]/', $value);
		$datas = array();
		foreach(  $lists as $image ){
			$image = trim($image);
			if( preg_match('/^(http|https):\/\/(.*?)\.(png|JPEG|jpeg|jpg|gif|PNG|JPG|GIF)$/i',$image) ) {
				$datas[] = '<img style="width:150px;height:39px" src="'.$image.'" />';
			}
		}
		if( count($datas) > 0  ){
			return implode("</br>",$datas);
		}
		return $value;
	}
	function wpforms_entry_save_fields($field, $form_data, $entry_id ){
		update_option("wpforms_entry_id_pdf",$entry_id);
		return $field;
	}
	function search_file($file_to_search){
		$upload_dir = wp_upload_dir();
		$path_main = $upload_dir['basedir'] . "/pdfs";
		$files = scandir($path_main);
		foreach ($files as $file) {
		    if (str_contains($file,"-".$file_to_search) !== false) {
		         return $file;
		    }
		}
		return "wpform-".$file_to_search.".pdf";
	}
	function add_link_download($action_links, $entry, $form_data){
		$upload_dir = wp_upload_dir();
		$path_main = $this->search_file($entry->entry_id);
		$path_main = $upload_dir['baseurl'] . "/pdfs/".$path_main;
		$action_links["pdf"] = array(
			'url'   => $path_main,
			'target' => 'blank',
			'icon'   => 'dashicons-media-text',
			'label' =>  esc_html__("Download PDF","crm-marketing"),
		);
		return $action_links;
	}
	function add_email($email, $fields, $entry, $form_data, $notification_id ){
		if( isset($form_data["settings"]["notifications"][$notification_id]["pdf_template"]) && $form_data["settings"]["notifications"][$notification_id]["pdf_template"] > 0) {
			if( isset($_GET["entry_id"])) {
				$user_uuid  = sanitize_text_field( $_GET["entry_id"] );
			}else{
				$user_uuid  = get_option("wpforms_entry_id_pdf","");
			}
			$emails = new WPForms_WP_Emails();
			$emails->__set( 'form_data', $form_data );
			$emails->__set( 'fields', $fields );
			$emails->__set( 'notification_id', $notification_id );
			$emails->__set( 'entry_id', $user_uuid );
			$emails->__set( 'from_name', $email['sender_name'] );
			$emails->__set( 'from_address', $email['sender_address'] );
			$emails->__set( 'reply_to', $email['replyto'] );
			$emails->__set( 'reply_to', $email['replyto'] );
			$emails = apply_filters( 'wpforms_entry_email_before_send', $emails );
			$message = "";
			$attachments = array();
			$datas = array("{entry_id}"=>$user_uuid);
			$entry_form = array();
			foreach( $entry["fields"] as $id => $name ){
				$entry_form[ "{field_id='".$id."'}" ] = $name;
			}
			$datas = array_merge($datas,$entry_form);
			$pdf_template = $form_data["settings"]["notifications"][$notification_id]["pdf_template"];
			if( isset($form_data["settings"]["notifications"][$notification_id]["pdf_template_name"]) ){
				$name = $emails->process_tag( $form_data["settings"]["notifications"][$notification_id]["pdf_template_name"] ) . "-".$user_uuid;
			}else{
				$name= "wpform-".$user_uuid;
			}
			$name = sanitize_title($name);
			$message =FDF_Create_frontend::pdf_creator_preview($pdf_template,"upload",$name,"","","",$datas,true);
			$message = $emails->process_tag( $message );
			$message = str_replace( '{all_fields}', $emails->wpforms_html_field_value( false ), $message );
			$message = apply_filters( 'wpforms_email_message', ( $message ), $emails );
			$path =FDF_Create_frontend::pdf_creator_preview($pdf_template,"upload",$name,$message);
			$attachments[] = $path;
			foreach ( $email['address'] as $address ) {
				$emails->send( trim( $address ), $email['subject'], $email['message'],$attachments );
			}
			$email['address'] = array();
		}
		return $email;
	}
	function add_settings_notif($settings,$id){
		$templates = array();
		$orders = new WP_Query( array( 'post_type' => 'pdf_template','post_status' => 'publish','posts_per_page'=>-1 ) );
	    if( $orders->have_posts() ):
	    	$templates[0] = esc_html__("No Template",'wpforms-pdfcreator');
	         while ( $orders->have_posts() ) : $orders->the_post();
	        	$id_template = get_the_id();
	        	$templates[esc_html($id_template)] = "(". esc_html($id_template) .") ". get_the_title();
	        ?>
	        <?php
	         endwhile;
	    else:
	    	$templates[0] = esc_html__("No Template",'wpforms-pdfcreator');
	    endif;
		wpforms_panel_field(
					'select',
					'notifications',
					'pdf_template',
					$settings->form_data,
					esc_html__( 'PDF Template', 'wpforms-pdfcreator' ),
					[
						'rows'       => 6,
						'default'    => 0,
						'options'     =>$templates,
						'parent'     => 'settings',
						'subsection' => $id,
						'class'      => 'email-msg',
						'after'      => '<p class="note">' .
										sprintf(
											/* translators: %s - {all_fields} Smart Tag. */
											esc_html__( 'Choose PDF template.', 'wpforms-pdfcreator' ),
											''
										) .
										'</p>',
					]
				);
		wpforms_panel_field(
					'text',
					'notifications',
					'pdf_template_name',
					$settings->form_data,
					esc_html__( 'PDF Template Custom Name', 'wpforms-pdfcreator' ),
					[
						'rows'       => 6,
						'default'    => "wpform",
						'smarttags'  => [
							'type' => 'all',
						],
						'parent'     => 'settings',
						'subsection' => $id,
						'class'      => 'email-msg',
						'after'      => '<p class="note">' .
										sprintf(
											/* translators: %s - {all_fields} Smart Tag. */
											esc_html__( '{name}-id.pdf', 'wpforms-pdfcreator' ),
											''
										) .
										'</p>',
					]
				);
	}
	function block_builder($type){ 
		$container_show = array("text-align","padding","margin","background","html","condition");
		$padding = pdfbuilder_email_global_data::$padding;
		$margin = pdfbuilder_email_global_data::$margin;
        $text_align = pdfbuilder_email_global_data::$text_align;
        $container_style = array(
                ".builder__editor--item-background .builder__editor_color"=>"background-color",
                ".builder__editor--item-background .image_url"=>"background-image",
            );
        $inner_attr = array(".text-content"=>array(".builder__editor--html .builder__editor--js"=>"html"),".text-content-data"=>array(".builder__editor--html .builder__editor--js"=>"html_hide"));
        $type["block"]["wpforms_data"]["builder"] = '
           <div class="builder-elements">
                <div class="builder-elements-content" data-type="wpforms_data" >
                    <div class="text-content-data hidden"></div>
                    <div class="text-content">'.esc_attr__("Choose data shortcode","wpforms-pdfcreator").'</div>
                </div>
            </div>';
        $type["block"]["wpforms_data"]["editor"]["container"]["show"]= $container_show;
        $type["block"]["wpforms_data"]["editor"]["container"]["style"]= array_merge($padding,$container_style,$text_align,$margin);
        $type["block"]["wpforms_data"]["editor"]["inner"]["style"]= array();
        $type["block"]["wpforms_data"]["editor"]["inner"]["attr"] = $inner_attr;
        return $type; 
	}
	function block_gravity(){
        ?>
        <li>
            <div class="momongaDraggable" data-type="wpforms_data">
                <i class="dashicons-email-alt dashicons"></i>
                <div class="wpbuilder-tool-text"><?php esc_html_e("WPForms datas","wpforms-pdfcreator") ?></div>
            </div>
        </li>
        <?php
    }
	function add_head_settings($post){
		global $wpdb;
        $post_id= $post->ID;
       $data = get_post_meta( $post_id,'_pdfcreator_wpforms',true);
        ?>
        <div class="wp-builder-testting-order">
           <?php 
           esc_html_e("Fields WPForms:","wpforms-pdfcreator");
            ?>
            <select name="pdfcreator_wpforms" class="builder_pdf_woo_testing">
                <?php
                	$the_query = new WP_Query( array("post_type"=>"wpforms","posts_per_page"=>-1) );
                	if( $the_query->have_posts()  ){
                		    while ( $the_query->have_posts() ) {
                		    	$the_query->the_post();
                			$form_id = get_the_ID();
                			$form_title = get_the_title();
						    ?>
						     <option <?php selected($data,$form_id) ?> value="<?php echo esc_attr($form_id) ?>"><?php echo esc_html($form_title) ?></option>
						    <?php
						}
                	}else{
                		printf( "<option value='0'>%s</option>",esc_html__("No Form",'wpforms-pdfcreator'));
                	}
                	wp_reset_postdata();
                 ?>
            </select>
        </div>
        <?php
    }
    function save_metabox($post_id, $post){
        if( isset($_POST['pdfcreator_wpforms'])) {
            $id = sanitize_text_field($_POST['pdfcreator_wpforms']);
            update_post_meta($post_id,'_pdfcreator_wpforms',$id);
        }
    }
	function add_shortcode($shortcode) {
		global $post, $wpdb;
		$shortcode[] = array("text"=>"WPForms","value"=>"");
		if( isset($_GET["post"]) ){
			$post_id = sanitize_text_field($_GET["post"]);
		}
		if( isset( $post_id) && $post_id > 0){
		}else{
			if( isset( $post->ID )){
				$post_id = $post->ID;
			}
		}
		if( isset($post->ID) && $post->ID > 0 ){
			$form_id = get_post_meta( $post_id,'_pdfcreator_wpforms',true);
			if(!$form_id){
				$templates = $wpdb->get_results( 
				    "
				        SELECT ID, post_title 
				        FROM $wpdb->posts
				        WHERE post_status = 'publish'
				        AND post_type = 'wpforms'
				        LIMIT 1
				    "
				);
				foreach ( $templates as $template ) {
					$form_id = $template->ID;
					break;
				}
			}
			$form = wpforms()->form->get( absint( $form_id) );
			// If the form doesn't exists, abort.
			if ( empty( $form ) ) {
				return $shortcode;
			}
			// Pull and format the form data out of the form object.
		    $form_data = ! empty( $form->post_content ) ? wpforms_decode( $form->post_content ) : '';
		    // Check to see if we are showing all allowed fields, or only specific ones.
		    $form_field_ids = isset( $atts['fields'] ) && $atts['fields'] !== '' ? explode( ',', str_replace( ' ', '', $atts['fields'] ) ) : [];
		    // Setup the form fields.
		    $form_fields = array();
		    if ( empty( $form_field_ids ) ) {
		    	if( isset($form_data['fields']) ) {
		    		$form_fields = $form_data['fields'];
		    	}
		    } else {
		        $form_fields = [];
		        foreach ( $form_field_ids as $field_id ) {
		            if ( isset( $form_data['fields'][ $field_id ] ) ) {
		                $form_fields[ $field_id ] = $form_data['fields'][ $field_id ];
		            }
		        }
		    }
			 if( is_array($form_fields)) {
			 	foreach( $form_fields as $id => $datas){
				 	$shortcode[] = array("text"=>$datas["label"],"value"=>"{field_id='".$id."'}");
				 }
			 }
		 } 
		$shortcode[] = array("text"=>"Entry Id","value"=>"{entry_id}");
		return $shortcode;
	}
}
new PDF_Creator_WPFroms_Backend;