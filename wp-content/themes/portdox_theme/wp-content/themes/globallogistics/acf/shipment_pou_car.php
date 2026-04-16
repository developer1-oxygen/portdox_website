<?php

//ocean_export_booking_entry_type

function custom_shipping_status() {
    register_post_status( 'submit-to-process', array(
        'label'                     => _x( 'Submit To Process', 'shipment' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Submit To Process <span class="count">(%s)</span>', 'Submit To Process <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'custom_shipping_status' );

function change_shipping_status_labels( $args ) {
    $args['labels']['publish'] = 'Personal';
    return $args;
}
add_filter( 'register_post_type_args', 'change_shipping_status_labels' );



function custom_acf_admin_voyage_dates2() {
  echo '<style>.group-col {width: 45%; float: left;}</style>';


  $permission_style	=	'';

  if(is_user_logged_in())
  {
  	$user = wp_get_current_user();
  	if(in_array('partner', $user->roles)) 
  	{
  		$permission_style .= '[data-name=partner]{ display:none}';
  		$permission_style .= '[user_dd_name=partner]{ display:none}';
  	}
  }


  ?>
  <style type="text/css">
  	<?php echo $permission_style ;?>
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

  	function abc()
	{
		
	
	
		var pol = jQuery('[data-label="POL"]').val();
		var pod = jQuery('[data-label="pou ( POD = POU )"]').val();
		var partner22 = jQuery('[data-name="partner"]  select').val();

		var post_id2   = '<?php echo get_the_ID();?>';
	    jQuery.ajax({
	        url: ajax_url,
	        type: 'POST',
	        data: {
	            action: 'get_avaliable_car',
	            pol: pol,
	            pod: pod,
	            partner2:partner22,
	            post_id2: post_id2,
	        },
	        success: function(response) {
	            // update the available dates radio buttons with the new values
	            jQuery('.avaliable_cars').html(response);
	          

	            //jQuery('[data-name="selected_cars"] input').val('');
	            var selectedCars = [];
				jQuery('.available-car:checked').each(function() {
					selectedCars.push(jQuery(this).val());
				});
				jQuery('[data-name="selected_cars"] input').val(selectedCars.join(','));


	            jQuery(document).on('change', '.available-car' , function() {
		          var selectedCars = [];
		          jQuery('.available-car:checked').each(function() {
		            selectedCars.push(jQuery(this).val());
		          });
		          jQuery('[data-name="selected_cars"] input').val(selectedCars.join(','));
		        });
	           
	        }
	    });
	}

	function abc2()
	{
		

	
		var pol = jQuery('[data-label="POL"]').val();
		var pod = jQuery('[data-label="pou ( POD = POU )"]').val();

		

		var post_id2   = '<?php echo get_the_ID();?>';
	    jQuery.ajax({
		  url: ajax_url, 
		  type: 'POST',
		  data: {
		    action: 'get_avaliable_booking',
		    pol: pol,
		    pod: pod,
		    post_id2: post_id2,
		  },
		  success: function(response) {
		    var select2Dropdown = jQuery("#acf-field_63e9dd603c675-field_63e9dd7d3c676");
		    select2Dropdown.html(response);
		  }
		});
	}

	jQuery(document).ready(function (){
		
		jQuery('[data-name="pol"]').on("change",function (){
			//alert('aa');
			var pou = jQuery('[data-name="pol"] option:selected').attr('value');
			//alert(pou);
		});

		jQuery('[data-name="pou"]').append("<div class='avaliable_cars'></div>");
	
		jQuery('.field_63f088083f478').on('change', function() {

			abc();
			abc2();
		 
		});

		jQuery('.field_63f088263f479').on('change', function() {

			abc();
			abc2();
	
		});

		jQuery(document).ready(function() {
		  	jQuery('#acf-field_64459807126c9').on('change', function() {
			    if (jQuery(this).val() == 'Ready to process') {
			      var confirmed = confirm('Are you sure you want to change the entry status to "Ready to Process"?');
			      if (!confirmed) {
			        // Revert back to the previous option selected
			        jQuery(this).val(jQuery(this).data('previous'));
			        return false;
			      }
			    }
			    // Save the previous option selected
			    jQuery(this).data('previous', jQuery(this).val());
			  });
			});

	});
	jQuery(window).on("load",function (){
		
		setTimeout(function(){

			abc();
			
			abc2();

		},2000);

	});
  </script>
  <?php
}

add_action('acf/input/admin_head', 'custom_acf_admin_voyage_dates2');


add_action('wp_ajax_get_avaliable_car', 'get_avaliable_car');
add_action('wp_ajax_nopriv_get_avaliable_car', 'get_avaliable_car');

function get_avaliable_car() {
   




    $post_id2 	= 	$_POST['post_id2'];
    $pol_i  	= 	$_POST['pol'][0];
    $pod_i 		= 	$_POST['pod'][0];
    $partner_i 	= 	$_POST['partner2'];




    $post_type = get_post_type($post_id2);
    if($post_type!="shipment")
    {
    	exit;
    }
    

    $already_selected_car = get_field_new('ocean_export_booking_selected_cars', $post_id2 , 'tr_shipment_info' );
   
    $already_selected_car = explode(",",$already_selected_car);

    global $wpdb;
   
    $query  			=    " select * from tr_commodities where pol like '%".$pol_i."%' and pod like '%".$pod_i."%'  ";

    $res 				=	  $wpdb->get_results($query,ARRAY_A);

    $cars_cond 			=	  '';
    
    $cars_cond_main 	=	  '';
    
    foreach($res as $val)
    {
    	$cars_cond .= " '".$val['post_id']."',";
    }


    if ($cars_cond!="") {

    	$product_info_str = trim($cars_cond,",");
        
    

		$query  	=   "select * from tr_commodities where post_id in(".$product_info_str.")  and ready_to_export='1' ";

		$res3 		=	$wpdb->get_results($query,ARRAY_A);

        $vin_values = array();
      	
      	if(count($res3)>0)
      	{
      		?>
      		<style> 
      			
      			.border_1px_solid{border-collapse: collapse;margin-top:10px; width: 100%;}
      			
      			.border_1px_solid td,
      			.border_1px_solid th{ border:1px dotted #ccc; cellpadding:0px;  padding:5px ; font-size:12px }
      			
      		</style>
      		<table  class="border_1px_solid" style="display: none;" > 
      			<!-- <tr>
      				<td colspan="6"><?php echo $query ;?></td>

      			</tr> -->
      			<tr> 
      				<th> </th>
      				<th>Vin</th> 
      				<th>Make</th> 
      				<th>Model</th> 
      				<th>Year</th> 
      				<th>Selected In Shipment</th> 

      			</tr>
      		
      		<?php
		    foreach ($res3 as $product2) 
		    {
	            
	            $vin 		= $product2['vin'];

	            $post_id 	= $product2['post_id'];
	           	

	           	$checked='';
	           	$seleced_in_shipment='<b style="color:Red">No</b>';
 				if(in_array($post_id,$already_selected_car))
 				{
 					$checked='checked';
 					$seleced_in_shipment='<b style="color:green">Yes</b>';
 				}	
	            ?>
	            <tr>
	            	<td><?php echo '<input type="checkbox" class="available-car" name="available_car[]" value="'.$post_id.'" '.$checked.'>';?></td>
	            	<td><?php echo $product2['vin'] ?></td>
	            	<td><?php echo $product2['make'] ?></td>
	            	<td><?php  echo $product2['model'] ?></td>
	            	<td><?php echo $product2['year'] ?></td>

	            	<td style="text-align:center;"><?php echo $seleced_in_shipment; ?></td>

	            </tr>
	            <?php
	           	
	        }
	        ?>
	        </table>

	        <button class="btn genrate_shipment" style="margin-top: 10px;" >Genrate House</button>
	        <?php
    
        } 
        else 
        {
           // echo 'No available cars';
        }
    } else {
        //echo 'No available cars';
    }

    wp_reset_postdata();
    wp_die();/**/
}




/*function get_avaliable_car() {
   




    $post_id2 	= 	$_POST['post_id2'];
    $pol_i  	= 	$_POST['pol'][0];
    $pod_i 		= 	$_POST['pod'][0];
    $partner_i 	= 	$_POST['partner2'];




    $post_type = get_post_type($post_id2);
    if($post_type!="shipment")
    {
    	exit;
    }
    

    $already_selected_car = get_field_new('ocean_export_booking_selected_cars', $post_id2 , 'tr_shipment_info' );
   
    $already_selected_car = explode(",",$already_selected_car);

    global $wpdb;
   
    $query  			=    " select * from tr_commodities where pol like '%".$pol_i."%' and pod like '%".$pod_i."%'  ";

    $res 				=	  $wpdb->get_results($query,ARRAY_A);

    $cars_cond 			=	  '';
    
    $cars_cond_main 	=	  '';
    
    foreach($res as $val)
    {
    	$cars_cond .= " product_info like '%".$val['post_id']."%' OR ";
    }


    if($cars_cond!="")
    {
    	$cars_cond_main = " and ( ".trim($cars_cond,"OR "). " ) ";	
    }
    
    $query  	=   "select * from tr_cases_info where partners_details_partner like  '%".$partner_i."%'  ".$cars_cond_main;

	#echo  $query;

	$res2 		=	$wpdb->get_results($query,ARRAY_A);

	$product_info_str = '';
   
 	foreach($res2 as $val2)
    {
   	 	$product_info = json_decode($val2['product_info']);
   	 	foreach($product_info as $val3)
   	 	{
   	 		$product_info_str .= "'".$val3."',";
   	 	}
    }
    
    if ($product_info_str!="") {

    	$product_info_str = trim($product_info_str,",");
        
    	
		#echo $product_info_str;

		$query  	=   "select * from tr_commodities where post_id in(".$product_info_str.")  and ready_to_export='1' ";

		$res3 		=	$wpdb->get_results($query,ARRAY_A);

        $vin_values = array();
      	
      	if(count($res3)>0)
      	{
      		?>
      		<style> 
      			
      			.border_1px_solid{border-collapse: collapse;margin-top:10px; width: 100%;}
      			
      			.border_1px_solid td,
      			.border_1px_solid th{ border:1px dotted #ccc; cellpadding:0px;  padding:5px ; font-size:12px }
      			
      		</style>
      		<table  class="border_1px_solid" > 
      			<tr> 
      				<th> </th>
      				<th>Vin</th> 
      				<th>Make</th> 
      				<th>Model</th> 
      				<th>Year</th> 
      				<th>Selected In Shipment</th> 

      			</tr>
      		
      		<?php
		    foreach ($res3 as $product2) 
		    {
	            
	            $vin 		= $product2['vin'];

	            $post_id 	= $product2['post_id'];
	           	

	           	$checked='';
	           	$seleced_in_shipment='<b style="color:Red">No</b>';
 				if(in_array($post_id,$already_selected_car))
 				{
 					$checked='checked';
 					$seleced_in_shipment='<b style="color:green">Yes</b>';
 				}	
	            ?>
	            <tr>
	            	<td><?php echo '<input type="checkbox" class="available-car" name="available_car[]" value="'.$post_id.'" '.$checked.'>';?></td>
	            	<td><?php echo $product2['vin'] ?></td>
	            	<td><?php echo $product2['make'] ?></td>
	            	<td><?php  echo $product2['model'] ?></td>
	            	<td><?php echo $product2['year'] ?></td>

	            	<td style="text-align:center;"><?php echo $seleced_in_shipment; ?></td>

	            </tr>
	            <?php
	           	
	        }
	        ?>
	        </table>

	        <button class="btn genrate_shipment" style="margin-top: 10px;" >Genrate House</button>
	        <?php
    
        } 
        else 
        {
           // echo 'No available cars';
        }
    } else {
        //echo 'No available cars';
    }

    wp_reset_postdata();
    wp_die();
}



*/

add_action("init",function (){

	if(@$_GET['iamdev667']=="ok")
	{
		
		global $wpdb;

		$post_id = '18671';
		$res     = $wpdb->get_results("select * from tr_shipment_info where post_id ='".$post_id."'",ARRAY_A);

		$ocean_export_booking_ultimate_consignee 	 	=	$res[0]['ocean_export_booking_ultimate_consignee'];
		$ocean_export_booking_intermediate_consignee 	=	$res[0]['ocean_export_booking_intermediate_consignee'];
		$ocean_export_booking_notify_party 	 			=	$res[0]['ocean_export_booking_notify_party'];
		$ocean_export_booking_freight_forwarder 	 	=	$res[0]['ocean_export_booking_freight_forwarder'];
		
		$select_shipment_type 	 						=	$res[0]['select_shipment_type'];
		$ocean_export_booking_pol 	 					=	$res[0]['ocean_export_booking_pol'];
		$ocean_export_booking_pou 	 					=	$res[0]['ocean_export_booking_pou'];



		$ocean_export_booking_selected_cars 			=	$res[0]['ocean_export_booking_selected_cars'];
		$ocean_export_booking_prducts 	 				=	$res[0]['ocean_export_booking_prducts'];
		$ocean_export_booking_booking 	 				=	$res[0]['ocean_export_booking_booking'];
		$entry_type 	 								=	$res[0]['entry_type'];

		$ocean_export_booking_shipper					=	$res[0]['ocean_export_booking_shipper'];
	

		$number 	 									=	$res[0]['number'];
		

		if($number!="")
		{

		}
		exit;

		
		//$wpdb->query("update tr_postmeta set meta_value='zzz' where meta_key='shipper_shipper_address' and post_id='18587' ");
		
	}
});

add_action('wp_ajax_create_house', 'create_house_fn');
add_action('wp_ajax_nopriv_create_house', 'create_house_fn');


function create_house_fn() {


	global $wpdb;

    $selected_car_for_house = $_POST['selected_car_for_house'];
    $shipment_id = $_POST['shipment_id'];
    $house_buyer = $_POST['house_buyer'];
    $house_seller = $_POST['house_seller'];
    $house_buyer_address = $_POST['house_buyer_address'];
    $house_seller_address = $_POST['house_seller_address'];

    // Insert a new post of type "house"
    $post_id = wp_insert_post(array(
        'post_type' => 'house',
        'post_title' => '', // random
        'post_status' => 'publish'
    ));

    // Add meta data to the post
    update_post_meta($post_id, 'selected_cars2', $selected_car_for_house);
    update_post_meta($post_id, 'shipment', $shipment_id);

    update_post_meta($post_id, 'shipper_name', $house_buyer);
    update_post_meta($post_id, 'shipper_address', $house_buyer_address);


    update_post_meta($post_id, 'consignee_name', $house_seller);
    update_post_meta($post_id, 'consignee_address', $house_seller_address);

    global $wpdb;

    // Check if the row already exists in the custom table
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}house_info WHERE post_id = %d", $post_id
    ), ARRAY_A);

    if ($row) {
       

        $wpdb->query("update tr_postmeta set meta_value='".$house_seller_address."' 
        									where meta_key='shipper_shipper_address' and post_id='".$post_id."' ");

        $wpdb->query("update tr_postmeta set meta_value='".$house_buyer_address."' 
        									where meta_key='consignee_consignee_address' and post_id='".$post_id."' ");


        $wpdb->query("update tr_postmeta set meta_value='".$house_seller."' 
        									where meta_key='shipper_shipper_name' and post_id='".$post_id."' ");

        $wpdb->query("update tr_postmeta set meta_value='".$house_buyer."' 
        									where meta_key='consignee_consignee_name' and post_id='".$post_id."' ");
		

        $wpdb->update(
            "{$wpdb->prefix}house_info",
            array(
                'selected_cars2' => $selected_car_for_house,
                'shipment' => $shipment_id,
                'shipper_shipper_name' => $house_buyer,
                'shipper_shipper_address' => $house_buyer_address,
                'consignee_consignee_name' => $house_seller,
                'consignee_consignee_address' => $house_seller_address
            ),
            array('post_id' => $post_id),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ),
            array('%d')
        );
    } else {
       
        $wpdb->insert(
            "{$wpdb->prefix}house_info",
            array(
                'post_id' => $post_id,
                'selected_cars2' => $selected_car_for_house,
                'shipment' => $shipment_id,
                'shipper_shipper_name' => $house_buyer,
                'shipper_shipper_address' => $house_buyer_address,
                'consignee_consignee_name' => $house_seller,
                'consignee_consignee_address' => $house_seller_address
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );

		$wpdb->query("insert into tr_postmeta set meta_value='".$house_seller_address."', meta_key='shipper_shipper_address', post_id='".$post_id."' ");
		$wpdb->query("insert into tr_postmeta set meta_value='".$house_buyer_address."', meta_key='consignee_consignee_address', post_id='".$post_id."' ");

		$wpdb->query("insert into tr_postmeta set meta_value='".$house_seller."', meta_key='shipper_shipper_name', post_id='".$post_id."' ");
		$wpdb->query("insert into tr_postmeta set meta_value='".$house_buyer."', meta_key='consignee_consignee_name', post_id='".$post_id."' ");



    }

    // Return a success message
    echo 'Post created with ID: ' . $post_id;

    exit;
}







add_action('wp_ajax_get_avaliable_booking', 'get_avaliable_booking');
add_action('wp_ajax_nopriv_get_avaliable_booking', 'get_avaliable_booking');

function get_avaliable_booking() {


    $post_id2 		= 	$_POST['post_id2'];
	$selected_str  	=  get_field_new("ocean_export_booking_booking",$post_id2,"tr_shipment_info");
	if ( is_serialized( $selected_str ) ) {
	    $selected_ar = unserialize( $selected_str );
	} else {
	    $selected_ar[] = $selected_str;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'booking_info';
	$pol_i = $_POST['pol'][0];
	$pod_i = $_POST['pod'][0];
	
	
	$sql = $wpdb->prepare(
	    "SELECT post_id FROM {$table_name} WHERE vessel_information_pol LIKE %s AND vessel_information_pod LIKE %s",
	    "%{$wpdb->esc_like($pol_i)}%",
	    "%{$wpdb->esc_like($pod_i)}%"
	);
	$results = $wpdb->get_results($sql);


	$post_ids[] = "<option value='0' >Select Booking</option>";
	foreach ($results as $result) {
	    
		$sel = (in_array($result->post_id,$selected_ar))?'selected':'';

	    $post_ids[] = '<option '.$sel.' value="'.$result->post_id.'">'.get_the_title($result->post_id)."</option>";
	}
	$post_ids_csv = implode('', $post_ids);
	echo $post_ids_csv;
	exit;


    
}



function restrict_user_dropdown_choices($field) {
    // Check if the field is the desired dropdown field
    if ($field['type'] == 'select' && $field['name'] == 'field_63e8b7ca9aa9a') {
      
        $user_ids = array(990001);
        
        // Query users with the specified IDs
        $users = get_users(array(
            'include' => $user_ids,
            'orderby' => 'include',
        ));
        
        // Generate the choices array for the dropdown
        $choices = array();
        foreach ($users as $user) {
            $choices[$user->ID] = $user->display_name;
        }
        
        // Update the choices for the dropdown field
        $field['choices'] = $choices;
    }
    
    return $field;
}
add_filter('acf/load_field', 'restrict_user_dropdown_choices');


function get_all_child_user()
{
	$currentUserId = get_current_user_id();
	global $wpdb;
	$query2  = "SELECT user_id FROM $wpdb->usermeta WHERE  meta_key = 'parent_user_id' AND meta_value = '".$currentUserId."' ";
	$userIds = $wpdb->get_col($query2);
	
	if(empty($userIds))
	{
		$userIds = array('0');
	}

	return $userIds;
}

function get_shipment_post_user($post_id)
{
	$currentUserId = get_current_user_id();
	global $wpdb;
	$query2  = "SELECT * FROM tr_shipment_info WHERE  post_id  = '".$post_id."' ";

	$res = $wpdb->get_results($query2,ARRAY_A);
	//ocean_export_booking_shipper
	//ocean_export_booking_ultimate_consignee
	//ocean_export_booking_intermediate_consignee
	//ocean_export_booking_notify_party
	//ocean_export_booking_freight_forwarder
	//ocean_export_booking_partner
	$return = array();
	if(isset($res[0]['ocean_export_booking_shipper']) and $res[0]['ocean_export_booking_shipper']!="")
	{
		$return[] = $res[0]['ocean_export_booking_shipper']; 
	}

	if(isset($res[0]['ocean_export_booking_ultimate_consignee']) and $res[0]['ocean_export_booking_ultimate_consignee']!="")
	{
		$return[] = $res[0]['ocean_export_booking_ultimate_consignee']; 
	}

	if(isset($res[0]['ocean_export_booking_intermediate_consignee']) and $res[0]['ocean_export_booking_intermediate_consignee']!="")
	{
		$return[] = $res[0]['ocean_export_booking_intermediate_consignee']; 
	}
	
	if(isset($res[0]['ocean_export_booking_notify_party']) and $res[0]['ocean_export_booking_notify_party']!="")
	{
		$return[] = $res[0]['ocean_export_booking_notify_party']; 
	}
	
	if(isset($res[0]['ocean_export_booking_freight_forwarder']) and $res[0]['ocean_export_booking_freight_forwarder']!="")
	{
		$return[] = $res[0]['ocean_export_booking_freight_forwarder']; 
	}

	if(isset($res[0]['ocean_export_booking_partner']) and $res[0]['ocean_export_booking_partner']!="")
	{
		$return[] = $res[0]['ocean_export_booking_partner']; 
	}

	return $return;
}


function filter_user_dropdown_options($args, $field, $request) {
    
   
	
    if ($field['key'] === 'field_63e8b7ca9aa9a') {
	
		$post_id 		= 	$_REQUEST['post_id'];

		$child_user 	= 	get_all_child_user();   	
	
		$shipment_ids 	= 	get_shipment_post_user($post_id);
	
		$total_ar 		=	array_merge($child_user,$shipment_ids);	

		$total_ar = array_unique($total_ar);
		
    	$args['include'] = 	$total_ar;
    }


    /*----Ultimate Consignee-----*/
    if ($field['key'] === 'field_63e8b85c9aa9b') {
		
		$post_id 		= 	$_REQUEST['post_id'];

		$child_user 	= 	get_all_child_user();   	
	
		$shipment_ids 	= 	get_shipment_post_user($post_id);
	
		$total_ar 		=	array_merge($child_user,$shipment_ids);	

		$total_ar 		= 	array_unique($total_ar);
		
    	$args['include'] = 	$total_ar;
    }

    /*----Intermediate Consignee-----*/
    if ($field['key'] === 'field_63e8b8919aa9c') {
		
		$post_id 		= 	$_REQUEST['post_id'];

		$child_user 	= 	get_all_child_user();   	
	
		$shipment_ids 	= 	get_shipment_post_user($post_id);
	
		$total_ar 		=	array_merge($child_user,$shipment_ids);	

		$total_ar 		= 	array_unique($total_ar);
		
    	$args['include'] = 	$total_ar;
    }

    /*----Notify Party-----*/
    if ($field['key'] === 'field_63e8b8b29aa9d') {
		
		$post_id 		= 	$_REQUEST['post_id'];

		$child_user 	= 	get_all_child_user();   	
	
		$shipment_ids 	= 	get_shipment_post_user($post_id);
	
		$total_ar 		=	array_merge($child_user,$shipment_ids);	

		$total_ar 		= 	array_unique($total_ar);
		
    	$args['include'] = 	$total_ar;
    } 

    /*----Freight Forwarder-----*/
  	if ($field['key'] === 'field_63e8b8de9aa9e') {
		
		$post_id 		= 	$_REQUEST['post_id'];

		$child_user 	= 	get_all_child_user();   	
	
		$shipment_ids 	= 	get_shipment_post_user($post_id);
	
		$total_ar 		=	array_merge($child_user,$shipment_ids);	

		$total_ar 		= 	array_unique($total_ar);
		
    	$args['include'] = 	$total_ar;
    } 
    


    return $args;
}
add_filter('acf/fields/user/query', 'filter_user_dropdown_options', 10, 3);


/*-------------------------------shipment notes-----------------------------------------*/

add_action('wp_ajax_save_addresses', 'ajax_save_addresses'); // If called from the admin panel
add_action('wp_ajax_nopriv_save_addresses', 'ajax_save_addresses'); // If called from elsewhere

function ajax_save_addresses() {
    // Make sure to validate and sanitize your data before saving
    $user_id = get_current_user_id(); // Get the current logged-in user ID

    // You might have to adjust this logic to fit how you're sending the data.
    $addresses = isset($_POST['addresses']) ? $_POST['addresses'] : [];

    $parsed_addresses = [];
   
    
    $acf_addresses = [];
    
    $index = 0;

    while( isset($addresses[$index]) ) {
        $acf_addresses[] = [
            'main' => sanitize_text_field($addresses[$index]["main"]),
            'country' => sanitize_text_field($addresses[$index]["country"]),
            'address_line_1' => sanitize_text_field($addresses[$index]["address_line_1"]),
            'address_line_2' => sanitize_text_field($addresses[$index]["address_line_2"]),
            'city' => sanitize_text_field($addresses[$index]["city"]),
            'state' => sanitize_text_field($addresses[$index]["state"]),
            'post_code' => sanitize_text_field($addresses[$index]["post_code"]),
        ];
        $index++;
    }
    
    // Update the ACF repeater field with the new data
    if(function_exists('update_field')) {
        update_field('address', $acf_addresses, 'user_' . $user_id);
    }
    
    wp_send_json_success('Addresses updated successfully.');
    die();
}


function ajax_load_form() {
?>


	<script>
	jQuery(document).ready(function() {
	    jQuery('#save_addresses').click(function(e) {
	        e.preventDefault();
	        let addresses = [];
	        jQuery('.address').each(function() {
	            let address = {
	                
	                country: jQuery(this).find('.country').val(),
	                address_line_1: jQuery(this).find('.address_line_1').val(),
	                address_line_2: jQuery(this).find('.address_line_2').val(),
	                city: jQuery(this).find('.city').val(),
	                state: jQuery(this).find('.state').val(),
	                post_code: jQuery(this).find('.post_code').val(),
	            };
	            addresses.push(address);
	        });
	        console.log(addresses);
	        jQuery.ajax({
	            url: ajaxurl,  // Assuming you're using WordPress, otherwise use the URL to your PHP file
	            type: 'POST',
	            data: {
	                action: 'save_addresses',  // The PHP function to run
	                addresses: addresses
	            },
	            success: function(response) {
	                alert('Addresses saved successfully');
	            },
	            error: function(error) {
	                alert('Failed to save addresses');
	            }
	        });
	    });
	});
	</script>

    <div style="width: 500px; min-height: 500px;">
        <h2>Addresses</h2>
         <button id="save_addresses">Save Addresses</button>
        <div id="addresses">
            <?php
            $user_id 	= get_current_user_id();

           
			   
		    $acf_addresses = get_field('address', 'user_' . $user_id); // Retrieve the repeater field for the user
		    ?>
		    <div style="width: 500px; min-height: 500px;">
		        <h2>Addresses</h2>
		        <div id="addresses">
		            <?php
		            if(is_array($acf_addresses)) {
		                $index = 0;
		                foreach($acf_addresses as $acf_address) {
		                    ?>
		                    <div class="address">
		                        <input type="text" name="address_<?php echo $index; ?>_main" class="address_line_1" value="<?php echo esc_attr($acf_address['main']); ?>"/>
		                        <input type="text" name="address_<?php echo $index; ?>_country"  class="country" value="<?php echo esc_attr($acf_address['country']); ?>"/>
		                        <input type="text" name="address_<?php echo $index; ?>_address_line_1"  class="address_line_1" value="<?php echo esc_attr($acf_address['address_line_1']); ?>"/>
		                        <input type="text" name="address_<?php echo $index; ?>_address_line_2"  class="address_line_1" class="address_line_1" value="<?php echo esc_attr($acf_address['address_line_2']); ?>"/>
		                        <input type="text" name="address_<?php echo $index; ?>_city" value="<?php echo esc_attr($acf_address['city']); ?>"  class="address_line_1" />
		                        <input type="text" name="address_<?php echo $index; ?>_state"  class="state" value="<?php echo esc_attr($acf_address['state']); ?>"/>
		                        <input type="text" name="address_<?php echo $index; ?>_post_code" class="post_code" value="<?php echo esc_attr($acf_address['post_code']); ?>"/>
		                        <button class="remove_address">Remove</button>
		                    </div>
		                    <?php
		                    $index++;
		                }
		            }
		            ?>
		        </div>
		       
		        <button id="save_address">Save Address</button>
		        <!-- Your JavaScript here, or it could be placed elsewhere in your document -->
		    </div>
		    <?php
		    
			


            ?>
        </div>
        <button id="add_address">Add Address</button>
        

        <script type="text/javascript">
        jQuery(document).ready(function() {
		    	let index = 0;
    
			    // Add a new address block
			    jQuery('#add_address').click(function(e) {
			        e.preventDefault();
			        jQuery('#addresses').append(`
			            <div class="address">
			                <input type="text" name="address_${index}_main" placeholder="Main" class="aa" />
			                <input type="text" name="address_${index}_country" class="country"  placeholder="Country" />
			                <input type="text" name="address_${index}_address_line_1" class="address_line_1"  placeholder="Address Line 1" />
			                <input type="text" name="address_${index}_address_line_2" class="address_line_2"  placeholder="Address Line 2" />
			                <input type="text" name="address_${index}_city" class="city"   placeholder="City" />
			                <input type="text" name="address_${index}_state" class="state"  placeholder="State" />
			                <input type="text" name="address_${index}_post_code" class="post_code"  placeholder="Post Code" />
			                <button class="remove_address">Remove</button>
			            </div>
			        `);
			        index++;
			    });
			    
			    // Remove an address block
			    jQuery(document).on('click', '.remove_address', function(e) {
			        e.preventDefault();
			        jQuery(this).closest('.address').remove();
			    });

			    // Save addresses using AJAX
			    jQuery('#save_address').click(function(e) {
			        e.preventDefault();
			        let formData = jQuery('#address_form').serialize();
			        jQuery.ajax({
			            type: 'POST',
			            url: ajaxurl,
			            data: {
			                action: 'save_addresses',
			                formData: formData,
			            },
			            success: function(response) {
			                alert('Addresses saved successfully.');
			            },
			            error: function() {
			                alert('Failed to save addresses.');
			            }
			        });
			    });
		});
		</script>
    </div>
<?php
    die();
}
add_action('wp_ajax_load_form', 'ajax_load_form'); // If called from the admin panel
add_action('wp_ajax_nopriv_load_form', 'ajax_load_form');



// Add the meta box
function shipment_notes_meta_box() {
    add_meta_box(
        'shipment_notes',
        'Shipment Notes',
        'render_shipment_notes_meta_box',
        'shipment',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'shipment_notes_meta_box');

// Render the meta box content
function render_shipment_notes_meta_box($post) {
    $notes = get_post_meta($post->ID, 'shipment_notes', true);
    wp_nonce_field('save_shipment_notes', 'shipment_notes_nonce');
    ?>
    <style>
    #shipment-notes-container {
	    padding: 20px;
	    background-color: #f5f5f5;
	}

	.shipment-note {
	    background-color: #ffffff;
	    border: 1px solid #e0e0e0;
	    padding: 10px;
	    margin-bottom: 10px;
	    position: relative;
	}

	.shipment-note p {
	    margin: 0;
	}

	.delete-shipment-note {
	    position: absolute;
	    top: 5px;
	    right: 5px;
	    color: #ff0000;
	    font-size: 12px;
	    text-decoration: none;
	    top: 17px;
		right: -22px;
	}

	#new-shipment-note {
	    margin-top: 10px;
	}

	#add-shipment-note {
	    margin-top: 10px;
	}
	

    </style>
    <div id="shipment-notes-container">
        <div id="shipment-notes-list">
            <?php if (!empty($notes)) : ?>
                <?php foreach ($notes as $note) : ?>
                    <div class="shipment-note">
                        <p><?php echo html_entity_decode($note['message']); ?></p>
                        <a href="#" delete_id="<?php echo $note['id'];?>" class="delete-shipment-note"><span class="dashicons dashicons-trash"></span></a><!--  -->
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <textarea id="new-shipment-note" name="new_shipment_note" rows="3" style="width:100%;"></textarea>
        <button id="add-shipment-note" class="button">Add Note</button>
    </div>
    
 

    <script>
			jQuery(document).ready(function($) { 
			    $(document).on("click", '.add_pol_address', function(e) {
			       
			        $.ajax({
			            type: 'POST',
			            url: '<?php echo admin_url('admin-ajax.php'); ?>',
			            data: {
			                action: 'load_form'
			            },
			            success: function(response) {
			                $.colorbox({html: response});
			            },
			            error: function() {
			                alert("Something went wrong!");
			            }
			        });
			    });
			});
	</script>


    <script>
        (function ($) {
            $(document).ready(function () {
            	
            	jQuery('[data-name="pol_address"] label').append("<a class='add_pol_address'  href='#' style='float:right'>Add Pol Address</a>");


            	

                $('#add-shipment-note').on('click', function (e) {
                    e.preventDefault();
                    var note = $('#new-shipment-note').val();
                    if (note !== '') {
                        $.ajax({
                            url: ajaxurl, // AJAX endpoint set by WordPress
                            type: 'POST',
                            data: {
                                action: 'save_shipment_note',
                                note: note,
                                post_id: '<?php echo $post->ID; ?>',
                                nonce: '<?php echo wp_create_nonce("save_shipment_note"); ?>'
                            },
                            success: function (response) {
                                if (response.success) {
                                    $('#shipment-notes-list').append('<div class="shipment-note" ><p>' + response.note + '</p><a href="#" class="delete-shipment-note" delete_id="'+ response.id +'"><span class="dashicons dashicons-trash"></span></a></div>');
                                    $('#new-shipment-note').val('');
                                } else {
                                    console.log(response.message);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log('AJAX error: ' + textStatus + ' - ' + errorThrown);
                            }
                        });
                    }
                });

                /*$('#shipment-notes-list').on('click', '.delete-shipment-note', function (e) {
                    e.preventDefault();
                    $(this).closest('.shipment-note').remove();
                });*/
            });

            $(document).ready(function () {
		       
		        $('#shipment-notes-list').on('click', '.delete-shipment-note', function (e) {
		            e.preventDefault();
		            var noteContainer = $(this).closest('.shipment-note');
		            var note = noteContainer.find('p').text();
		            var delete_id = $(this).attr('delete_id');
		            $.ajax({
		                url: ajaxurl,
		                type: 'POST',
		                data: {
		                    action: 'delete_shipment_note',
		                    note: note,
		                    post_id: '<?php echo $post->ID; ?>',
		                    nonce: '<?php echo wp_create_nonce("delete_shipment_note"); ?>',
		                    delete_id:delete_id
		                },
		                success: function (response) {
		                    if (response.success) {
		                        noteContainer.remove();
		                    } else {
		                        console.log(response.message);
		                    }
		                },
		                error: function (jqXHR, textStatus, errorThrown) {
		                    console.log('AJAX error: ' + textStatus + ' - ' + errorThrown);
		                }
		            });
		        });
		    });
        })(jQuery);
    </script>

    <script>
	(function ($) {
		$(document).ready(function() {
			// Listen for changes in the first dropdown
			function pol_fn()
			{
				var selectedText = $("[data-name=pol]").find('option:selected').text();
			    var matches = selectedText.match(/\((.*?)\)/);
			    if (matches) {
			        var countryName = matches[1];
			        jQuery('[data-name=pol_address] option').show();
			        jQuery('[data-name=pol_address] option').each(function() {
			            
			            if (!jQuery(this).text().includes(countryName)) 
			            {
			            	jQuery(this).prop('selected', false);
			            	jQuery(this).hide();
			            }
			        });
			        
			    }
			}
			pol_fn();
			setTimeout(function (){pol_fn();},3000);
			$('[data-name=pol]').change(function() {
			   pol_fn();
			});
			function pou_fn()
			{
				var selectedText = $("[data-name=pou]").find('option:selected').text();
			    var matches = selectedText.match(/\((.*?)\)/);
			    if (matches) {
			        var countryName = matches[1];
			        
			        jQuery('[data-name=pou_address] option').show();
			        jQuery('[data-name=pou_address] option').each(function() {
			           
			            if (!jQuery(this).text().includes(countryName)) 
			            {
			            	jQuery(this).prop('selected', false);
			            	jQuery(this).hide();
			            }

			        });
			        
			    }
			}
			pou_fn();
			setTimeout(function (){pou_fn();},3000);

			$('[data-name=pou]').change(function() {
			   
			    pou_fn();
			});

		});
	})(jQuery);
	</script>

    <?php
}

// Save the shipment note
function save_shipment_note() {
    $response = array(
        'success' => false,
        'message' => 'Error saving shipment note.'
    );

    if (isset($_POST['note']) && isset($_POST['post_id']) && isset($_POST['nonce'])) {
        $note = sanitize_textarea_field($_POST['note']);
        $post_id = intval($_POST['post_id']);
        $nonce = $_POST['nonce'];

        // Verify the nonce
                // Verify the nonce
        if (wp_verify_nonce($nonce, 'save_shipment_note')) {
          
            $notes = get_post_meta($post_id, 'shipment_notes', true);
            if(!is_array($notes))
            {
            	$notes = array();	
            }
           
            $id     	= time();

            $notes[$id] = array('id'=>$id,'message'=>$note,'can_delete'=>'yes');

           
            update_post_meta($post_id, 'shipment_notes', $notes);

            $response['success'] = true;
            $response['note'] = $note;
            $response['message'] = 'Shipment note saved successfully.';
            $response['id'] = $id ;
        } else {
            $response['message'] = 'Invalid nonce.';
        }
    } else {
        $response['message'] = 'Invalid request.';
    }

    // Return the JSON response
    wp_send_json($response);
}

// Register the AJAX action
add_action('wp_ajax_save_shipment_note', 'save_shipment_note');
add_action('wp_ajax_nopriv_save_shipment_note', 'save_shipment_note');






function delete_shipment_note() {
    $response = array(
        'success' => false,
        'message' => 'Error deleting shipment note.'
    );

    if (isset($_POST['note']) && isset($_POST['post_id']) && isset($_POST['nonce'])) {
        $note = sanitize_textarea_field($_POST['note']);
        $post_id = intval($_POST['post_id']);
        $delete_id= $_POST['delete_id'];

        $nonce = $_POST['nonce'];

        // Verify the nonce
        if (wp_verify_nonce($nonce, 'delete_shipment_note')) {
            // Get the existing shipment notes
            $notes = get_post_meta($post_id, 'shipment_notes', true);

            // Find and remove the note from the array
            if (!empty($notes)) {
                
                unset($notes[$delete_id]);
              
            
            }
           # $notes = array();

            // Update the shipment notes meta field
            update_post_meta($post_id, 'shipment_notes', $notes);

            $response['success'] = true;
            $response['message'] = 'Shipment note deleted successfully.';
        } else {
            $response['message'] = 'Invalid nonce.';
        }
    } else {
        $response['message'] = 'Invalid request.';
    }

    // Return the JSON response
    wp_send_json($response);
}

// Register the AJAX action
add_action('wp_ajax_delete_shipment_note', 'delete_shipment_note');
add_action('wp_ajax_nopriv_delete_shipment_note', 'delete_shipment_note');





function send_email_shipment($email_message,$shipment_id,$creator_user_id )
{

	
	$user_info = get_userdata($creator_user_id);
	
	if ($user_info) {
	    
	    $email 	= 	$user_info->user_email;

		#$to 	 = 	"zeeshangill11@gmail.com";
	    $to    	 =	$email;

		$subject = 	"Shipment status changes.";

		$message = "
		<html>
			<head>
				<title>Shipment status changes.</title>
			</head>
			<body>
				<p>Hi, Shipment#".$shipment_id." status changes.".$email_message."</p>			
			</body>
		</html>
		";

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <info@oxygensoft.com>' . "\r\n";
		

		wp_mail($to,$subject,$message,$headers);

	}
}





function add_update_note2($post_id) {
    // Check if it's a shipping post type
    global $wpdb;
    if (get_post_type($post_id) === 'shipment') {
        // Check if the current user can edit the post
        if (current_user_can('edit_post', $post_id)) {
           
            $res     = $wpdb->get_results("select * from tr_shipment_info where post_id ='".$post_id."'",ARRAY_A);
			
			$select_shipment_type 	 						=	$res[0]['select_shipment_type'];
		
			$ocean_export_booking_prducts 	 				=	$res[0]['ocean_export_booking_prducts'];
			
			$ocean_export_booking_booking 	 				=	$res[0]['ocean_export_booking_booking'];
			
			$entry_type 	 								=	$res[0]['entry_type'];

			$creator_user_id 								=	$res[0]['creator_user_id'];

			
			$notes=get_post_meta($post_id, 'shipment_notes', true);
			

			if(!is_array($notes))
            {
            	$notes = array();	
            }

			$notes2=update_notes_if_value_change($res[0]['number'],$_POST['acf']['field_64007c90f251c'],"Number",$notes,'');
			
			$notes3=update_notes_if_value_change($res[0]['ocean_export_booking_shipper'],$_POST['acf']['field_63e9dd603c675']['field_63e8b7ca9aa9a'],"Shipper",$notes2,'user');

			$notes4=update_notes_if_value_change($res[0]['ocean_export_booking_ultimate_consignee'],$_POST['acf']['field_63e9dd603c675']['field_63e8b85c9aa9b'],"Ultimate Consignee",$notes3,'user');

			$notes5=update_notes_if_value_change($res[0]['ocean_export_booking_intermediate_consignee'],$_POST['acf']['field_63e9dd603c675']['field_63e8b8919aa9c'],"Intermediate Consignee",$notes4,'user');

			$notes6=update_notes_if_value_change($res[0]['ocean_export_booking_notify_party'],$_POST['acf']['field_63e9dd603c675']['field_63e8b8b29aa9d'],"Notify Party",$notes5,'user');

			$notes7=update_notes_if_value_change($res[0]['ocean_export_booking_freight_forwarder'],$_POST['acf']['field_63e9dd603c675']['field_63e8b8de9aa9e'],"Freight Forwarder",$notes6,'user');


			$notes8=update_notes_if_value_change($res[0]['ocean_export_booking_pol'],$_POST['acf']['field_63e9dd603c675']['field_63f088083f478'][0],"POL",$notes7,'pol_pod');

			$notes9=update_notes_if_value_change($res[0]['ocean_export_booking_pou'],$_POST['acf']['field_63e9dd603c675']['field_63f088263f479'][0],"POU",$notes8,'pol_pod');

			$notes10=update_notes_if_value_change($res[0]['ocean_export_booking_selected_cars'],$_POST['acf']['field_63e9dd603c675']['field_63f0ea62bf092'],"Selected Cars",$notes9,'');

			$notes11=update_notes_if_value_change($res[0]['entry_type'],$_POST['acf']['field_64459807126c9'],"Entry Type",$notes10,'');

			$is_email  =  array();
			$is_email  =  update_notes_if_value_change($res[0]['entry_type'],$_POST['acf']['field_64459807126c9'],"Entry Type",array(),'');
			if(is_array($is_email) and !empty($is_email) )
			{
				$email_message2 = 	'';
				foreach($is_email as $val22)
				{
					$email_message2 .= $val22['message'];	
				}
				

				send_email_shipment($email_message2,get_the_title($post_id),$creator_user_id );
			}
			#$notes=update_notes_if_value_change($res[0]['ocean_export_booking_booking'],$_POST['acf']['field_63e9dd603c675']['field_63e9dd7d3c676'][0],"Booking",$notes,'booking_array');


			
			update_post_meta($post_id, 'shipment_notes', $notes11);

          
           
        }
    }
}
add_action('pre_post_update', 'add_update_note2');

function populate_address_dropdown_choices($field) {
    // Check if the current user is logged in.
    if (is_user_logged_in()) {
        // Get the current user's ID.
        $user_id = get_current_user_id();
        
        // Get the repeater field values from the user's profile.
        $user_addresses = get_field('address', 'user_' . $user_id);
        
        // Initialize an empty array to store choices.
        $choices = array();
        
        // Loop through user addresses and add them as choices.
        if ($user_addresses) {
        	
        	$choices[""] = "Select Address";

            foreach ($user_addresses as $address) {
                // Customize the choice format as per your requirements.
                $choice_value = $address['address_line_1'] . ', ' . $address['city'] . ', ' . $address['state'];
                
                // Include the country name in the data-country attribute.
                $country_name = $address['country']; // Replace 'country' with the actual field name for the country.
                
                // Add the option with the data-country attribute.
                $choices[$choice_value] = $choice_value." (".$country_name.")";
                //$choices[$choice_value]['my_country'] =   ;
            }
        }
        
        // Set the choices for the dropdown field.

        $field['choices'] = $choices;
    }

    return $field;
}

// Hook into the ACF field to populate choices.
add_filter('acf/load_field/name=pol_address', 'populate_address_dropdown_choices');

add_filter('acf/load_field/name=pou_address', 'populate_address_dropdown_choices');



function populate_pol_dropdown_field_choices($field) {
    // Modify this query to get the values you want for your dropdown
    $args = array(
        'post_type' => 'pol', // Replace with your custom post type
        'posts_per_page' => -1,
    );
    $posts = get_posts($args);
    
    global $wpdb;
    $field['choices'][""] = "Select POL";
    if ($posts) {
        foreach ($posts as $post) {
        	
        	$temp 		  = $wpdb->get_results("select country from ".$wpdb->prefix."pol_pod where post_id='".$post->ID."' ",ARRAY_A );
        	$country_name = @$temp[0]['country'];

        	#$country_name = get_option($post->ID,"country");

            $field['choices'][$post->ID] = $post->post_title." (".$country_name.")";
        }
    }

    return $field;
}

add_filter('acf/load_field/name=pol', 'populate_pol_dropdown_field_choices');


function populate_pod_dropdown_field_choices($field) {
    // Modify this query to get the values you want for your dropdown
    $args = array(
        'post_type' => 'pou', // Replace with your custom post type
        'posts_per_page' => -1,
    );
    $posts = get_posts($args);
    global $wpdb;
    $field['choices'][""] = "Select POU";
    if ($posts) {
        foreach ($posts as $post) {
        	

        	$temp 		  = $wpdb->get_results("select country from ".$wpdb->prefix."pol_pod where post_id='".$post->ID."' ",ARRAY_A );
        	$country_name = @$temp[0]['country'];


            $field['choices'][$post->ID] = $post->post_title." (".$country_name.")";
        }
    }

    return $field;
}

add_filter('acf/load_field/name=pou', 'populate_pod_dropdown_field_choices');



?>