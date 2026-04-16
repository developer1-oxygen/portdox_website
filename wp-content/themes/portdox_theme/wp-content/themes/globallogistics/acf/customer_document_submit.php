<?php

/*------------------Customer Fields------------------------*/
function enqueue_custom_scripts() {
  
    
   	global $pagenow;

    // Check if the current screen is user-edit.php and the user role is customer
    if ($pagenow === 'user-edit.php' or $pagenow === 'profile.php' ) {
     	



     	$user_id = $_GET['user_id'];
     	if(!$user_id>0)
     	{
     		$user_id = get_current_user_id();
     	}
		
		$user 	= 	get_user_by('ID', $user_id);
		$license_copy_approved='';
		$passport_upload_approved='';

		#update_user_meta('990007','license_copy_approved','4117');
		
		
		if ($user && (in_array('customer', $user->roles) or in_array('shipper', $user->roles))) 
		{


			
			$license_copy_approved2 = get_user_meta($user_id, 'license_copy_approved', true);

			if (!empty($license_copy_approved2)) {
			     
			    
			    $image_url_full = wp_get_attachment_image_url($license_copy_approved2, 'full');

			    if ($image_url_full) {
			        $license_copy_approved = 'Approved Image: <a href="' . esc_url($image_url_full) . '" target="_blank"><div  style=" background-image:url(' . esc_url($image_url_full) . '); display: inline-block;" class="image_div_f" ></div></a>';
			    } 
			}

			$poa_approved = get_user_meta($user_id, 'poa_approved', true);

			if (!empty($poa_approved)) {
			      
			    $image_url_full2 = wp_get_attachment_image_url($poa_approved, 'full');

			    if ($image_url_full2) {
			        $poa_approved = 'Approved Image: <a href="' . esc_url($image_url_full2) . '" target="_blank"><div  style=" background-image:url(' . esc_url($image_url_full2) . '); display: inline-block;" class="image_div_f" ></div></a>';
			    } 
			}


			$poa_expire_approved = get_user_meta($user_id, 'poa_expire_approved', true);

			if (!empty($poa_expire_approved)) {

			        $poa_expire_approved = 'Approved Date:  '. ($poa_expire_approved) . '';
			     
			}

			$license_expire_approved = get_user_meta($user_id, 'license_expire_approved', true);

			if (!empty($license_expire_approved)) {

			        $license_expire_approved = 'Approved Date:  '. ($license_expire_approved) . '';
			     
			}


			$passport_expire_date_approved	=	get_user_meta($user_id, 'passport_expire_date_approved', true);

			if (!empty($passport_expire_date_approved)) 
			{
			    $passport_expire_date_approved = 'Approved Date:  '. ($passport_expire_date_approved) . '';     
			}

			$passport_upload_approved2	=	get_user_meta($user_id, 'passport_upload_approved', true);

			if (!empty($passport_upload_approved2)) 
			{
			  

			    $image_url_full3 = wp_get_attachment_image_url($passport_upload_approved2, 'full');

			    if ($image_url_full3) {
			        $passport_upload_approved = 'Approved Image: <a href="' . esc_url($image_url_full3) . '" target="_blank"><div  style=" background-image:url(' . esc_url($image_url_full3) . '); display: inline-block;" class="image_div_f" ></div></a>';
			    }     
			}

			/*----------------------------------------------------------------------------*/
			
			$license_copy_btn 	= 	'';
			$license_copy 		= 	get_user_meta($user_id, 'license_copy', true);
			if($license_copy!="")
			{
				$license_copy_btn 	= 	'<button type="button" id="license_copy_btn" onclick="license_copy_fn();" class="button button-primary"> Approve License Copy</button>';
			}
			

			$license_expire_btn 	= 	'';
			$license_expire 		= 	get_user_meta($user_id, 'license_expire', true);
			if($license_expire!="")
			{
				$license_expire_btn 	= 	'<button type="button" id="license_expire_btn" onclick="license_expire_fn();" class="button button-primary"> Approve Expire Date</button> ';
			}


			$poa_btn 	= 	'';
			$poa 		= 	get_user_meta($user_id, 'poa', true);
			if($poa!="")
			{
				$poa_btn 	= 	'<button type="button" id="poa_btn" onclick="poa_fn();" class="button button-primary"> Approve POA</button> ';
			}


			$poa_expire_btn 	= 	'';
			$poa_expire 		= 	get_user_meta($user_id, 'poa_expire', true);
			if($poa_expire!="")
			{
				$poa_expire_btn 	= 	'<button type="button" id="poa_expire_btn" onclick="poa_expire_fn();" class="button button-primary">  Approve Expire POA</button> ';
			}
			
			$passport_expire_date_btn 	= 	'';
			$passport_expire_date 		= 	get_user_meta($user_id, 'passport_expire_date', true);
			if($passport_expire_date!="")
			{
				$passport_expire_date_btn 	= 	'<button type="button" id="passport_expire_date_btn" onclick="passport_expire_date_fn();" class="button button-primary"> Approve Date</button> ';
			}


			$passport_upload_btn 	= 	'';
			$passport_upload 		= 	get_user_meta($user_id, 'passport_upload', true);
			if($passport_upload!="")
			{
				$passport_upload_btn 	= 	'<button type="button" id="passport_upload_btn" onclick="passport_upload_fn();" class="button button-primary"> Approve Passport</button> ';
			}

		    ?>
		    <style type="text/css">
		    	.image_div_f{ width:150px; min-height:120px !important; background-size:cover; background-repeat:no-repeat;  }
		    	#license_copy_btn{ margin-top:10px }
		    	
		    </style>
	        <script type="text/javascript">
	        (function($) {
			    $(document).ready(function() {
				
				   
			    	jQuery("[data-name='poa_expire'] .acf-input .acf-input-wrap").append('<?php echo $poa_expire_approved;?>');
			    	jQuery("[data-name='license_expire'] .acf-input .acf-input-wrap").append('<?php echo $license_expire_approved;?>');
			    	jQuery("[data-name='passport_expire_date'] .acf-input .acf-input-wrap").append('<?php echo $passport_expire_date_approved;?>');


			    	
			        <?php  

					$current_user = wp_get_current_user();

					if ( current_user_can( 'administrator' ) or in_array( 'company', $current_user->roles )  ) {
						?>
						

					      jQuery("[data-name='license_copy'] .acf-input").prepend(' <hr> <?php echo $license_copy_btn; ?>');

					      jQuery("[data-name='license_expire'] .acf-input .acf-input-wrap").prepend('<?php echo $license_expire_btn;?>');


					      jQuery("[data-name='poa'] .acf-input").prepend(' <hr> <?php echo $poa_btn ;?>');

					      jQuery("[data-name='poa_expire'] .acf-input .acf-input-wrap").prepend('<?php echo $poa_expire_btn ;?>');


					      jQuery("[data-name='passport_expire_date'] .acf-input .acf-input-wrap").prepend('<?php echo $passport_expire_date_btn;?> ');


					      


					      jQuery("[data-name='passport_upload'] .acf-input").prepend(' <hr> <?php echo $passport_upload_btn;?> ');




						
						<?php
						
					} 

					?>
					
					jQuery("[data-name='passport_upload'] .acf-input").prepend('<?php echo $passport_upload_approved;?>');
					jQuery("[data-name='license_copy'] .acf-input").prepend('<?php echo $license_copy_approved;?>');
					jQuery("[data-name='poa'] .acf-input").prepend('<?php echo $poa_approved;?>');
						
						

			    });
			})(jQuery);
	        </script>
	        <?php
    	}
    }
}
add_action('admin_head', 'enqueue_custom_scripts');






function enqueue_document_scripts() {
    wp_enqueue_script( 'customer_document', get_template_directory_uri() . '/js/customer_document.js', array( 'jquery' ), '1.0', true );
}
add_action( 'admin_enqueue_scripts', 'enqueue_document_scripts' );

// Register AJAX action hook
function register_document_ajax_action() {
    add_action( 'wp_ajax_update_user_meta', 'update_document_user_meta_callback' );

}
add_action( 'admin_init', 'register_document_ajax_action' );

add_action( 'wp_ajax_approve_license_copy', 'approve_license_copy_fn' );
add_action( 'wp_ajax_poa_copy', 'approve_poa_fn' );

add_action( 'wp_ajax_poa_expire_copy', 'approve_poa_expire_fn' );

add_action( 'wp_ajax_license_expire_copy', 'approve_license_expire_fn' );
add_action( 'wp_ajax_passport_expire_date_copy', 'approve_passport_expire_date_fn' );

add_action( 'wp_ajax_passport_upload_copy', 'passport_upload_copy_fn' );





function update_document_user_meta_callback() {
    $user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : 0;
    $partner_submitted = isset( $_POST['partner_submitted'] ) ? sanitize_text_field( $_POST['partner_submitted'] ) : '';

    // Update user meta
    update_user_meta( $user_id, 'submitted_by_partner', $partner_submitted );

    // Return a response (optional)
    wp_send_json_success( 'User meta updated successfully.' );
}


function approve_license_copy_fn()
{	

	$user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : 0;
    $license_copy = get_user_meta( $user_id, 'license_copy', true );
	if($license_copy!="")
	{
		update_user_meta( $user_id, 'license_copy_approved', $license_copy ); 
		update_user_meta( $user_id, 'license_copy', "" ); 
		echo "Document approved please refresh page";
		
	}
	else
	{
		echo "Document Not Uploaded";
	}
	die();     
}

function approve_poa_fn()
{	

	$user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : 0;
    $license_copy = get_user_meta( $user_id, 'poa', true );
	if($license_copy!="")
	{
		update_user_meta( $user_id, 'poa_approved', $license_copy ); 
		update_user_meta( $user_id, 'poa', "" ); 
		echo "Document approved please refresh page";
		
	}
	else
	{
		echo "Document Not Uploaded";
	}
	die();     
}


function approve_poa_expire_fn()
{	

	$user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : 0;
    $poa_expire = get_user_meta( $user_id, 'poa_expire', true );
	if($poa_expire!="")
	{
		$poa_expire2 = substr($poa_expire,0,4)."-".substr($poa_expire,4,2)."-".substr($poa_expire,6,2);
		update_user_meta( $user_id, 'poa_expire_approved', $poa_expire2 ); 
		update_user_meta( $user_id, 'poa_expire', "" ); 
		echo "POA expire update please refresh page";
		
	}
	else
	{
		echo "POA Expire Not Uploaded";
	}
	die();     
}



function approve_license_expire_fn()
{	

	$user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : 0;
    $license_expire = get_user_meta( $user_id, 'license_expire', true );
	if($license_expire!="")
	{
		$license_expire2 = substr($license_expire,0,4)."-".substr($license_expire,4,2)."-".substr($license_expire,6,2);
		update_user_meta( $user_id, 'license_expire_approved', $license_expire2 ); 
		update_user_meta( $user_id, 'license_expire', "" ); 
		echo "Date Updated please refresh page";
		
	}
	else
	{
		echo "Date Not Updated";
	}
	die();     
}




function approve_passport_expire_date_fn()
{	

	$user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : 0;
    $passport_expire_date = get_user_meta( $user_id, 'passport_expire_date', true );
	if($passport_expire_date!="")
	{
		$passport_expire_date2 = substr($passport_expire_date,0,4)."-".substr($passport_expire_date,4,2)."-".substr($passport_expire_date,6,2);
		update_user_meta( $user_id, 'passport_expire_date_approved', $passport_expire_date2 ); 
		update_user_meta( $user_id, 'passport_expire_date', "" ); 
		echo "Date approved please refresh page";
		
	}
	else
	{
		echo "Date Not Updated";
	}
	die();     
}

function  passport_upload_copy_fn()
{	

	$user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : 0;
    $passport_upload = get_user_meta( $user_id, 'passport_upload', true );
	if($passport_upload!="")
	{
		
		update_user_meta( $user_id, 'passport_upload_approved', $passport_upload ); 
		update_user_meta( $user_id, 'passport_upload', "" ); 
		echo "Date approved please refresh page";
		
	}
	else
	{
		echo "Date Not Updated";
	}
	die();     
}




// Add custom submit button to user edit screen
function add_document_submit_button() {
    global $pagenow;
    
    // Only add the button on the user edit screen
    if ( $pagenow === 'user-edit.php' ) {
        $user_id = isset( $_GET['user_id'] ) ? intval( $_GET['user_id'] ) : 0;
        $partner_submitted = get_user_meta( $user_id, 'submitted_by_partner', true );


       
        // Get previous meta values
        $previous_license_copy = get_user_meta( $user_id, 'license_copy', true );
        $previous_license_expire = get_user_meta( $user_id, 'license_expire', true );
        $previous_passport_upload = get_user_meta( $user_id, 'passport_upload', true );
        $previous_passport_expire = get_user_meta( $user_id, 'passport_expire_date', true );
        $previous_poa = get_user_meta( $user_id, 'poa', true );

        // Get current meta values
        $current_license_copy = get_user_meta( $user_id, 'license_copy', true );
        $current_license_expire = get_user_meta( $user_id, 'license_expire', true );
        $current_passport_upload = get_user_meta( $user_id, 'passport_upload', true );
        $current_passport_expire = get_user_meta( $user_id, 'passport_expire_date', true );
        $current_poa = get_user_meta( $user_id, 'poa', true );

        // Check if any of the specified fields are updated
        if (
            (
                $current_license_copy !== $previous_license_copy ||
                $current_license_expire !== $previous_license_expire ||
                $current_passport_upload !== $previous_passport_upload ||
                $current_passport_expire !== $previous_passport_expire ||
                $current_poa !== $previous_poa
            )
        ) {
            
            $partner_submitted = false; // Set submitted_by_partner to false
            update_user_meta( $user_id, 'submitted_by_partner', $partner_submitted );

        }

        ?>

        <div id="custom-submit-button">

        

        	<?php 
        	
        	$current_screen = get_current_screen();
			if ($current_screen && $current_screen->base === 'profile') 
			{
		    	echo '<button class="button button-primary" id="partner-submit-button">Submit to company for approval</button>';
			}
			
			?>

            
        		<?php
        	//}
        	
        	?>
            <span id="partner-submit-status" style="font-weight:bold; ">
            	<?php //echo $partner_submitted ? 'Submitted to company for approval' : 'Not submitted'; ?>
            </span>

        </div>
        <?php
    }
}
add_action( 'edit_user_profile', 'add_document_submit_button' );



if ( current_user_can( 'customer' ) ) {
    add_action( 'pre_get_posts', 'restrict_media_visibility' );
    function restrict_media_visibility( $query ) {
        if (  $query->is_main_query() ) {
            $query->set( 'author', get_current_user_id() );
        }
    }
}


?>