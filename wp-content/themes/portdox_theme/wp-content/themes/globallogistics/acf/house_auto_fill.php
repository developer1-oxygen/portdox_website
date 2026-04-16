<?php


function custom_house_meta_box() {
    add_meta_box(
        'house_meta_box', // Meta box ID
        'House Details', // Title of the meta box
        'display_house_meta_box', // Callback function to display the meta box content
        'house', // Post type to which the meta box should be added
        'normal', // Context (normal, side, advanced)
        'high' // Priority (high, core, default, low)
    );
}
add_action('add_meta_boxes', 'custom_house_meta_box');

function save_house_meta_data($post_id) {
    // Check if this is an autosave

    // if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    //     return;
    // }

    // Check post type
    if ('house' !== get_post_type($post_id)) {
        return;
    }

    // Check if the necessary fields are set and not empty
    if (isset($_POST['us_ppi']) && isset($_POST['ultimate_consignee'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'house_info';

      

      	global $wpdb;
		$table_name = $wpdb->prefix . 'house_info';

		$post_id = intval($post_id); // Sanitize the post ID as an integer

		$us_ppi = isset($_POST['us_ppi']) ? sanitize_text_field($_POST['us_ppi']) : '';
		$ultimate_consignee = isset($_POST['ultimate_consignee']) ? sanitize_text_field($_POST['ultimate_consignee']) : '';

		// Define the data to be updated
		$data = array(
		    'us_ppi' => $us_ppi,
		    'ultimate_consignee' => $ultimate_consignee,
		);

		// Define the WHERE condition
		$where = array(
		    'post_id' => $post_id,
		);

		// Define the format of the data and the WHERE condition
		$data_format = array('%s', '%s');
		$where_format = array('%d');

		// Execute the update query
		$wpdb->update($table_name, $data, $where, $data_format, $where_format);
    }
}
add_action('save_post', 'save_house_meta_data');

function display_house_meta_box($post) {
    $house_id = $post->ID;
    global $wpdb;
    $table_name = $wpdb->prefix . 'house_info';

    $house_info = $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM $table_name WHERE post_id = %d", $house_id )
    );

    // Get all users
    $users = get_users();

    // Output fields
    ?>
    <p>
        <label for="us_ppi">US PPI:</label>
        <select id="us_ppi" name="us_ppi" readonly>
            
            <?php 
            if($house_info->us_ppi!="")
            {

            	foreach ($users as $user)
            	{
            		if($user->ID==$house_info->us_ppi)
            		{
		            	?>
		                <option value="<?php echo esc_attr($user->ID); ?>" <?php selected($user->ID, $house_info->us_ppi); ?>>
		                     <?php echo esc_html($user->display_name); ?>
		                </option>
		            	<?php
            		} 
            	} 
            }
            else
            {
            	foreach ($users as $user)
            	{
            	?>
            	<option value="">Select US PPI</option>
                <option value="<?php echo esc_attr($user->ID); ?>" <?php selected($user->ID, $house_info->us_ppi); ?>>
                    <?php echo esc_html($user->display_name); ?>
                </option>
            	<?php 
            	} 
            }
            ?>

            
        </select>
    </p>
    <p>
        <label for="ultimate_consignee">Ultimate Consignee:</label>
        <select id="ultimate_consignee" name="ultimate_consignee" readonly>
            

        	
            <?php 
            if($house_info->ultimate_consignee!="")
            {

            	foreach ($users as $user)
            	{
            		if($user->ID==$house_info->ultimate_consignee)
            		{
		            	?>
		                <option value="<?php echo esc_attr($user->ID); ?>" <?php selected($user->ID, $house_info->ultimate_consignee); ?>>
		                     <?php echo esc_html($user->display_name); ?>
		                </option>
		            	<?php
            		} 
            	} 
            }
            else
            {
            	foreach ($users as $user)
            	{
            	?>
            	<option value="">Select Ultimate Consignee</option>
                <option value="<?php echo esc_attr($user->ID); ?>" <?php selected($user->ID, $house_info->ultimate_consignee); ?>>
                    <?php echo esc_html($user->display_name); ?>
                </option>
            	<?php 
            	} 
            }
            ?>
            
           
        </select>
    </p>
    <?php
}



function custom_acf_admin_house() {
  echo '<style>.group-col {width: 45%; float: left;}</style>';
  ?>
  <style type="text/css">

  	.avaliable_cars label{
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
	
		jQuery('[data-name="shipment"]').append("<div class='avaliable_cars2'></div>");

		

		function house_1()
		{
			
			
	
			var shipment = jQuery('[data-label="Shipment"]').val();
			
			var post_id2   = '<?php echo get_the_ID();?>';
		    jQuery.ajax({
		        url: ajax_url,
		        type: 'POST',
		        data: {
		            'action': 'get_avaliable_car_for_house',
		            'shipment': shipment,
		            'main_post_id':post_id2
		           
		        },
		        success: function(response) {
		            // update the available dates radio buttons with the new values
		            jQuery('.avaliable_cars2').html(response);
		           	
		            var selectedCars2 = [];
		           	setTimeout(function (){
						jQuery('.available-car:checked').each(function() {
							selectedCars2.push(jQuery(this).val());
						});
				        jQuery('[data-name="selected_cars2"] input').val(selectedCars2.join(','));
		           	},500);
		           

		            jQuery(document).on('change', '.available-car' , function() {
			          var selectedCars = [];
			          jQuery('.available-car:checked').each(function() {
			            selectedCars.push(jQuery(this).val());
			          });
			          jQuery('[data-name="selected_cars2"] input').val(selectedCars.join(','));
			        });
		           
		        }
		    });
		}


		
		jQuery(window).on("load",function (){
			
			setTimeout(function(){

				//house_1()
					

			},1000);
			
		});

		jQuery(document).on('change', '[data-label="Shipment"]', function() {
			//house_1()
		});
		

		

	

	});



  </script>
  <?php
}

add_action('acf/input/admin_head', 'custom_acf_admin_house');




add_action('wp_ajax_check_commdity_exist_in_other_house', 'check_commdity_exist_in_other_house');
add_action('wp_ajax_nopriv_check_commdity_exist_in_other_house', 'check_commdity_exist_in_other_house');
function check_commdity_exist_in_other_house() {
    global $wpdb;
    $post_id = $_POST['post_id'];
    $checkbox_value = $_POST['checkbox_value'];
  
    
    $results = $wpdb->get_results($wpdb->prepare("
        SELECT *
        FROM tr_house_info
        WHERE selected_cars2 LIKE %s
        AND post_id != %d
    ", '%'.$checkbox_value.'%', $post_id));
    
    if ($results) {
        echo 'Exists';
    } else {
       
        echo 'Does not exist';
    }
    wp_die();
}

add_action('wp_ajax_get_avaliable_car_for_house', 'get_avaliable_car_for_house');
add_action('wp_ajax_nopriv_get_avaliable_car_for_house', 'get_avaliable_car_for_house');

function get_avaliable_car_for_house() {
   



	$main_post_id = $_POST['main_post_id'];
    $shipment     = $_POST['shipment'][0];

	global $wpdb;
	

	$car_in_shipment = get_field_new('ocean_export_booking_selected_cars', $shipment , 'tr_shipment_info' );
   
    if($car_in_shipment!="")
    {

    	$already_selected_car = get_field_new('selected_cars2', $main_post_id , 'tr_house_info' );
    	$already_selected_car = explode(",",$already_selected_car);

	   	$car_in_shipment_str  = ''.implode('","', explode(",",$car_in_shipment) ).'';



	   	$houses = $wpdb->get_results(" SELECT * FROM tr_house_info WHERE post_id <> '".$main_post_id."' ", ARRAY_A);

	   	$commodity_not_include_cond  	= '';
	   	$commodity_not_include_ar 		= [];

	   	foreach($houses as $h)
	   	{
	   		
	   		$selected_cars2 =explode(",",$h['selected_cars2']);
	   		foreach($selected_cars2 as $cc)
	   		{
	   			$commodity_not_include_ar[] = $cc;
	   		}
	   		
	   	}
	   	
	  
	   	if(count($commodity_not_include_ar)>0)
	   	{
	   		$commodity_not_include_cond  	= ' and post_id not in("'.implode(",",$commodity_not_include_ar).'")';
	   	}
	   	

		$query  	=   'select * from tr_commodities where post_id in("'.$car_in_shipment_str.'")  '.$commodity_not_include_cond;
		
		$res3 		=	$wpdb->get_results($query,ARRAY_A);

	    $vin_values = array();
	  	
	  	if(count($res3)>0)
	  	{


	  		

	  		?>
	  		<script>
	  		jQuery(document).ready(function() {
			  // Listen for change events on the checkboxes
			  	
			  	jQuery('input[type=checkbox]').change(function() {
			    	
			    	var pre_pol='';
				  	var pre_pod='';
				  	var pre_buyer='';
				  	var pre_seller='';

			  		var my_this = jQuery(this);
					jQuery('input[name="available_car[]"]:checked').each(function() {

						var data_pol 	= jQuery(this).attr('data_pol');
						var data_pod 	= jQuery(this).attr('data_pod');
						var data_buyer 	= jQuery(this).attr('data-buyer');
						var data_seller = jQuery(this).attr('data-seller');
						if(pre_pol=="")
						{
							pre_pol = data_pol;

						}
						else
						{
							if(pre_pol!=data_pol)
							{
								my_this.prop("checked",false);
								alert("In the same one house POL should be same");
								return false;
							}
						}


						if(pre_pod=="")
						{
							pre_pod = data_pod;

						}
						else
						{
							if(pre_pod!=data_pod)
							{
								my_this.prop("checked",false);
								alert("In the same one house POD should be same");
								return false;
							}
						}

						if(pre_buyer=="")
						{
							pre_buyer = data_buyer;

						}
						else
						{
							if(pre_buyer!=data_buyer)
							{
								my_this.prop("checked",false);
								alert("In the same one house Buyer should be same");
								return false;
							}
						}


						if(pre_seller=="")
						{
							pre_seller = data_seller;

						}
						else
						{
							if(pre_seller!=data_seller)
							{
								my_this.prop("checked",false);
								alert("In the same one house seller should be same");
								return false;
							}
						}

						
					
					});

			  	});



			  	jQuery('input[type=checkbox]').change(function() {
				    	

				    	var my_this = jQuery(this);


				        var post_id = '<?php echo $main_post_id; ?>'; // Assuming this is inside a WordPress loop
				        var checkbox_value = this.value;
				      
				        jQuery.ajax({
				            url: '<?php echo admin_url('admin-ajax.php'); ?>',
				            type: 'POST',
				            data: {
				                action: 'check_commdity_exist_in_other_house',
				                post_id: post_id,
				                checkbox_value: checkbox_value
				            },
				            success: function(response) {
				            	
				            	if(response=="Exists")
				            	{
				            		alert(checkbox_value+" already exist in other house");
				            		my_this.prop("checked",false);
				            		  
									var selectedCars = [];
									jQuery('.available-car:checked').each(function() {
										selectedCars.push(jQuery(this).val());
									});
									jQuery('[data-name="selected_cars2"] input').val(selectedCars.join(','));

				            	}
				                console.log(response);
				            },
				            error: function(jqXHR, textStatus, errorThrown) {
				                console.log(errorThrown);
				            }
				        });
				    
				});
			
			});

	  		</script>
	  		<style> 
	  			
	  			.border_1px_solid{border-collapse: collapse;margin-top:10px; width: 78%; float: right; margin-right: 10px}
	  			
	  			.border_1px_solid td,
	  			.border_1px_solid th{ border:1px dotted #ccc; cellpadding:0px;  padding:5px ; font-size:12px !important;  }
	  			.border_1px_solid td{ font-size:10px !important }
	  			
	  		</style>
	  		<table  class="border_1px_solid" > 
	  			<tr> 
	  				<th> </th>
	  				<th>Vin</th> 
	  				<th>Make</th> 
	  				<th>Model</th> 
	  				<th>Year</th> 
	  				<th>Case</th> 
	  				<th>POL</th> 

	  				<th>POD</th> 
	  				
	  				<th>Buyer</th> 
	  				<th>Seller</th> 
	  			</tr>
	  		
	  		<?php
		    foreach ($res3 as $product2) 
		    {
	            
	            $vin 		= $product2['vin'];

	            $post_id 	= $product2['post_id'];

	            /*-----------------------------------------------*/
	            global $wpdb;
				$field_name = 'product_info';
				$commodity_id =  $post_id;
				$results = $wpdb->get_results(
				    $wpdb->prepare(
				        "SELECT * FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value LIKE %s",
				        $field_name,
				        '%"'.$commodity_id.'"%'
				    )
				);

				$buyer_name  = '';
 				$seller_name = '';

				
				$titles = array();
				
				foreach ($results as $result) {
				    $post = get_post($result->post_id);
				    if ($post) {
				        $titles[]    = $post->post_title;
				        $buyer_name  = $post->buyer_name;
				        $seller_name = $post->seller_name;
				    }
				}
				
				$cases_string = implode(', ', $titles);
	           	
				$pol = json_decode($product2['pol']);
				$pod = json_decode($product2['pod']); 
 	

 				$inline_data_string  = ' data_pol="'.$pol[0].'"   data_pod="'.$pod[0].'" ';


 				$checked='';
 				if(in_array($commodity_id,$already_selected_car))
 				{
 					$checked = 'checked';
 				}	

 				
	            ?>
	            <tr >
	            	<td><?php echo '<input type="checkbox" class="available-car" name="available_car[]" value="'.$post_id.'"  '.$inline_data_string .' '.$checked.'  data-buyer="'.$buyer_name.'" data-seller="'.$seller_name.'"  >';?></td>
	            	<td><?php echo $product2['vin'] ?></td>
	            	<td><?php echo $product2['make'] ?></td>
	            	<td><?php  echo $product2['model'] ?></td>
	            	<td><?php echo $product2['year'] ?></td>
	            	<td><?php echo $cases_string; ?></td>
	            	<td><?php echo get_the_title($pol[0]); echo "(".$pol[0].")"; ?></td>
	            	<td><?php echo get_the_title($pod[0]); echo "(".$pod[0].")";?></td>
	            	<td class="buyer" user_id="<?php echo $buyer_name; ?>" >
	            		<?php 

						$user = get_user_by( 'id', $buyer_name );
						echo $user->display_name;

	            		?>
	            	</td>
	            	<td class="seller" user_id="<?php echo $seller_name; ?>" >
	            		
	            		<?php 

	            		$user2 = get_user_by( 'id', $seller_name );
						echo $user2->display_name;
	            		
	            		?>
	            			
	            	</td>

	            </tr>
	            <?php
            
	           
	           	
	        }
	        ?>
	        </table>
	        <?php

	    } 
	    else 
	    {
	        echo 'No available cars';
	    }
    }
    else
    {
    	 echo 'No available cars';
    }



    wp_die();/**/
}


function house_cars_select($field) {
    global $post, $wpdb;

    // Ensure the correct field is being modified
    if ($field['name'] != 'field_64074275e42cf') {
        return $field;
    }

    $post_id = isset($post->ID) ? $post->ID : null;
    if (!$post_id) {
        // Handle the case for new posts or where post ID is not available
        return $field;
    }

    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM tr_shipment_info WHERE post_id = %d", $post_id), ARRAY_A);

    if (!empty($results) && isset($results[0]['ocean_export_booking_selected_cars'])) {
        $shipment_cars = $results[0]['ocean_export_booking_selected_cars'];
        $car_ids = explode(',', $shipment_cars);
        $car_ids = array_map('intval', $car_ids);

        if (!empty($car_ids)) {
            $car_ids = implode(',', $car_ids);
            $commodities = $wpdb->get_results("SELECT * FROM tr_commodities WHERE post_id IN ($car_ids)", ARRAY_A);

            foreach ($commodities as $commodity) {
                $vin_number = esc_html($commodity['vin']);
                $commodity_post_id = intval($commodity['post_id']);
                $field['choices'][$commodity_post_id] = $vin_number;
            }
        }
    }

    return $field;
}

add_filter('acf/load_field', 'house_cars_select');



add_action("init",function(){

	if(@$_GET['iamdev7']=="ok")
	{
		$post_id = '18602';
		global $post, $wpdb;



    	$shipment_in_house 		= 	get_field_new('shipment', $post_id , 'tr_house_info' );
   		$shipment_in_house_ar	=	json_decode($shipment_in_house);
   		$shipment_in_house 		=   @$shipment_in_house_ar[0];
   		

		$results = $wpdb->get_results("SELECT * FROM tr_shipment_info WHERE post_id ='".$shipment_in_house."' ", ARRAY_A);


        if (!empty($results) && isset($results[0]['ocean_export_booking_selected_cars'])) {
            
            $shipment_cars = $results[0]['ocean_export_booking_selected_cars'];

            $car_ids = explode(',', $shipment_cars);
            $car_ids = array_map('intval', $car_ids);


             $field['choices'][''] ='Select Car';

            if (!empty($car_ids)) {
                $car_ids = implode(',', $car_ids);
               

                $commodities = $wpdb->get_results("SELECT * FROM tr_commodities WHERE post_id IN ($car_ids)", ARRAY_A);

                foreach ($commodities as $commodity) {
                    $vin_number = esc_html($commodity['vin']);
                    $commodity_post_id = intval($commodity['post_id']);
                    $field['choices'][$commodity_post_id] = $vin_number;
                }
            }
        }

		exit;
	}

});


function house_cars_select2($field) {
    // Make sure this is the correct field
    if ($field['_name'] == 'selected_cars2') {
        global $post, $wpdb;

        $post_id = $post->ID ?? null;
        if (!$post_id) {
            return $field;
        }


    	$shipment_in_house 		= 	get_field_new('shipment', $post_id , 'tr_house_info' );
   		$shipment_in_house_ar	=	json_decode($shipment_in_house);
   		$shipment_in_house 		=   @$shipment_in_house_ar[0];
   		

		$results = $wpdb->get_results("SELECT * FROM tr_shipment_info WHERE post_id ='".$shipment_in_house."' ", ARRAY_A);


        if (!empty($results) && isset($results[0]['ocean_export_booking_selected_cars'])) {
            
            $shipment_cars = $results[0]['ocean_export_booking_selected_cars'];

            $car_ids = explode(',', $shipment_cars);
            $car_ids = array_map('intval', $car_ids);


             $field['choices'][''] ='Select Car';

            if (!empty($car_ids)) {
                $car_ids = implode(',', $car_ids);
               

                $commodities = $wpdb->get_results("SELECT * FROM tr_commodities WHERE post_id IN ($car_ids)", ARRAY_A);

                foreach ($commodities as $commodity) {
                    $vin_number = esc_html($commodity['vin']);
                    $commodity_post_id = intval($commodity['post_id']);
                    $field['choices'][$commodity_post_id] = $vin_number;
                }
            }
        }

        
    }

    // Return the modified field
    return $field;
}

add_filter('acf/load_field/name=selected_cars2', 'house_cars_select2');



function my_custom_admin_script() {
    $screen = get_current_screen();
    
    // Check if we are on the 'house' post type add/edit screen
    if ( $screen->id == 'house' || $screen->id == 'edit-house' ) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
            
                $('[post_type=shipment]').on("change",function() {

                    var shipmentValue = $(this).val();
                    var post_id2   = '<?php echo get_the_ID();?>';
                    $.ajax({
                        url: ajaxurl, // 'ajaxurl' is automatically defined in the admin
                        type: 'POST',
                        data: {
                            action: 'load_cars_by_shipment',
                            shipment: shipmentValue,
                            'post_id':post_id2,
                        },
                        success: function(response) {
                            $('#acf-field_64074275e42cf').html(response);
                        }
                    });
                });
            });
        </script>
        <?php
    }
}
add_action('admin_head', 'my_custom_admin_script');



