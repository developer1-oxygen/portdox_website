<?php

function custom_acf_admin_voyage_dates() {
  echo '<style>.group-col {width: 45%; float: left;}</style>';
  ?>
  <style type="text/css">

  	.avaliable_dates label{
	  	border: 1px solid green;
	    padding: 5px;
	    margin: 2px;
	    border-radius: 9px;
		margin-top: 5px;
		display: inline-block;
	}
  </style>
  <script type="text/javascript">
  	var ajax_url = '<?php echo  admin_url( 'admin-ajax.php' );?>';
	jQuery(document).ready(function (){
		
		
		
		jQuery(window).on("load",function (){
			
			setTimeout(function(){

				jQuery('[data-name="voyage_details"]').append("<div class='avaliable_dates'></div>");
			
				var voyage_id = jQuery('[data-name="voyage_details"] .acf-input .acf-relationship .selection ul li input').val();
				var post_id2   = '<?php echo get_the_ID();?>';
			    jQuery.ajax({
			        url: ajax_url,
			        type: 'POST',
			        data: {
			            action: 'get_available_dates',
			            voyage_id: voyage_id,
			            post_id2: post_id2,
			            
			        },
			        success: function(response) {
			            // update the available dates radio buttons with the new values
			            jQuery('.avaliable_dates').html(response);
			           
			        }
			    });

			},2000);
			
		});

		jQuery(document).on('click', '[data-name="voyage_details"] .acf-input .acf-relationship .selection ul li , [data-name="voyage_details"] [data-name="remove_item"]', function() {
			var voyage_id = jQuery('[data-name="voyage_details"] .acf-input .acf-relationship .selection ul li input').val();
			var post_id2   = '<?php echo get_the_ID();?>';
		    jQuery.ajax({
		        url: ajax_url,
		        type: 'POST',
		        data: {
		            action: 'get_available_dates',
		            voyage_id: voyage_id,
		              post_id2: post_id2,
		        },
		        success: function(response) {
		            // update the available dates radio buttons with the new values
		            jQuery('.avaliable_dates').html(response);
		           
		        }
		    });
		});

		jQuery(document).on('click', ' [data-name="voyage_details"] [data-name="remove_item"]', function() {
			var voyage_id = jQuery('[data-name="voyage_details"] .acf-input .acf-relationship .selection ul li input').val();
			var post_id2   = '<?php echo get_the_ID();?>';
		    jQuery.ajax({
		        url: ajax_url,
		        type: 'POST',
		        data: {
		            action: 'get_available_dates',
		            voyage_id: voyage_id,
		              post_id2: post_id2,
		        },
		        success: function(response) {
		            // update the available dates radio buttons with the new values
		            jQuery('.avaliable_dates').html(response);
		           
		        }
		    });
		});

		jQuery(document).on('change', 'input[name="booking_date"]', function() {
	    	var selectedDate = jQuery(this).val();
		    jQuery('[data-name="voyage_date"] input').attr('value', selectedDate);
		});

	});
  </script>
  <?php
}

add_action('acf/input/admin_head', 'custom_acf_admin_voyage_dates');


add_action('wp_ajax_get_available_dates', 'get_available_dates');
add_action('wp_ajax_nopriv_get_available_dates', 'get_available_dates');

function get_available_dates() {
    $voyage_id 	= $_POST['voyage_id'];
    $post_id2 	= $_POST['post_id2'];



	$voyage_etd 			= 	get_post_meta($voyage_id, 'voyage_etd', true);
	$cbp_validation_date 	= 	get_post_meta($voyage_id, 'cbp_validation_date', true);

	$voyage_date2  			=	get_post_meta($post_id2,"ocean_export_booking_vessel_information_voyage_date",true);


	$public_holidays 		= 	get_option('web_settings_holidays');
	$public_holidays        =   explode(",",  $public_holidays);


	$public_holidays 		= 	array_map('trim', $public_holidays);
	 

	if(!empty($voyage_etd) && !empty($cbp_validation_date)) {
	    $start_date = strtotime($voyage_etd);
	    $end_date = strtotime($cbp_validation_date);
	    
	    $dates = array();
	    
	    for($i = $start_date; $i <= $end_date; $i += 86400) {
	        //$dates[] = date('Y-m-d', $i);

	        $current_day = date('N', $i); // get the day of the week for the current date (1 = Monday, 7 = Sunday)
	        if ($current_day < 6) { // exclude Saturday and Sunday (6 and 7)
	           	$dd = date('Y-m-d', $i);;
	        	if (!in_array($dd, $public_holidays)) {
	            	$dates[] = $dd;
	        	}
	        }
	    }
	    
	}




	
    // output the available dates as radio buttons
    if($dates) 
    {
        
        foreach($dates as $date) 
        {
        	
        	$selected = ($voyage_date2==$date)?'checked':'';

            echo '<label><input type="radio" name="booking_date" value="' . $date . '" data-date="' . $date . '" '.$selected.' >' . $date. '</label>    ';
     	}
    } 
    else 
    {
        echo 'No available dates found.';
    }

    wp_die();
}

?>