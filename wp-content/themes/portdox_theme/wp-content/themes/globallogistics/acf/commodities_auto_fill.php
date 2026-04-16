<?php
function update_post_title_with_random_number2($post_id, $post_type) {
    global $wpdb;
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_number = substr(str_shuffle(str_repeat($pool, 6)), 0, 6); // generate a random number of length 6
    

    $post_title = get_the_title($post_id);
    $result = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM $wpdb->posts
             WHERE post_type = %s AND post_title = %s AND ID != %d",
             $post_type,
             $post_title,
             $post_id
        )
    );
    if (empty($post_title) || $result > 0) {
        // the post title is empty or already exists, generate a new random number until we find one that does not exist
        do {
           
            $random_number = substr(str_shuffle(str_repeat($pool, 6)), 0, 6); // generate a new random number
            $result2 = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM $wpdb->posts
                     WHERE post_type = %s AND post_title = %s ",
                     $post_type,
                     $random_number
                )
            );
        } while ($result2 > 0);
        $post_title = $random_number;
    }
    
   
    $wpdb->update(
        $wpdb->posts,
        array('post_title' => $post_title),
        array('ID' => $post_id),
        array('%s'),
        array('%d')
    );
}

add_action("init",function (){

	if(isset($_GET['zz2']) and $_GET['zz2']=="ok")
	{
		

		global $wpdb; // Access the WordPress database object

		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$random_number = substr(str_shuffle(str_repeat($pool, 6)), 0, 6); // generate a random number of length 6
		$new_post = array(
		    'post_title'   => 'Your Case Title'.$random_number,
		    'post_content' => '',
		    'post_type'    => 'case', // Replace 'case' with your custom post type slug
		    'post_status'  => 'publish'
		);

		// Insert the new post into the database
		$new_post_id = wp_insert_post($new_post);
		update_post_title_with_random_number2($new_post_id,'case');

		echo '========='.$new_post_id;

		$product_id='111';
		$wpdb->insert("tr_cases_info",array('post_id'=> $new_post_id,'product_info'=>'["'.$product_id.'"]'));



		//exit;


		$table_name = $wpdb->prefix . 'cases_info'; // Replace 'cases_info' with the actual table name
		$post_id = 4028; // Replace '1' with the ID of the specific post

		// Retrieve the existing selected post IDs from the custom database column
		$query = "SELECT product_info FROM $table_name WHERE post_id = %d LIMIT 1";
		$result = $wpdb->get_var($wpdb->prepare($query, $post_id));
		$existingPosts = json_decode($result, true);

		$newPostID = '14077'; // New post ID to append (as a string)
		//18620
		// Add the new post ID to the array of existing post IDs
		$updatedPosts = array_unique(array_merge((array) $existingPosts, array($newPostID)));

		// Convert the updated array of post IDs to a string with double quotation marks
		$updatedPostsString = '"' . implode('","', $updatedPosts) . '"';
		
		// Update the custom database column with the updated string value
		$wpdb->update($table_name, array('product_info' => '['.$updatedPostsString.']'), array('post_id' => $post_id));

		#echo "====222";
		#exit;
	}
});

function run_custom_function($product_id) {
    // Check if this is the field you want to target
    if (isset($_POST['acf']['field_64358342da32c'])) {
        // Retrieve the value of the dropdown field
        $case_id = $_POST['acf']['field_64358342da32c'];
        
	        
	    if ($case_id === 'add_new_case') {



			$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$random_number = substr(str_shuffle(str_repeat($pool, 6)), 0, 6); // generate a random number of length 6

	        $new_post = array(
			    'post_title'   => ''.$random_number,
			    'post_content' => '',
			    'post_type'    => 'case', // Replace 'case' with your custom post type slug
			    'post_status'  => 'publish'
			);

		
			$case_id = wp_insert_post($new_post);
			



			global $wpdb; 

			$table_name = $wpdb->prefix . 'cases_info'; 
			

			
			$query = "SELECT product_info FROM $table_name WHERE post_id = %d LIMIT 1";
			$result = $wpdb->get_var($wpdb->prepare($query, $case_id));
			$existingPosts = json_decode($result, true);

			$newPostID =  $product_id; 
		
	
			$updatedPosts = array_unique(array_merge((array) $existingPosts, array($newPostID)));

			
			$updatedPostsString = '"' . implode('","', $updatedPosts) . '"';
			
			$wpdb->insert("tr_cases_info",array('post_id'=> $case_id,'product_info'=>'["'.$product_id.'"]'));


			//$wpdb->update($table_name, array('product_info' => '['.$updatedPostsString.']'), array('post_id' => $case_id));


			update_post_meta($product_id,'case_attached',$case_id);
			$wpdb->update("tr_commodities",array('case_attached'=>$case_id),array('post_id'=>$product_id));


           
        } elseif ($case_id != '') {

          	global $wpdb; // Access the WordPress database object

			$table_name = $wpdb->prefix . 'cases_info'; // Replace 'cases_info' with the actual table name
			

			// Retrieve the existing selected post IDs from the custom database column
			$query = "SELECT product_info FROM $table_name WHERE post_id = %d LIMIT 1";
			$result = $wpdb->get_var($wpdb->prepare($query, $case_id));
			$existingPosts = json_decode($result, true);

			$newPostID =  $product_id; // New post ID to append (as a string)
			//18620
			// Add the new post ID to the array of existing post IDs
			$updatedPosts = array_unique(array_merge((array) $existingPosts, array($newPostID)));

			// Convert the updated array of post IDs to a string with double quotation marks
			$updatedPostsString = '"' . implode('","', $updatedPosts) . '"';
			
			// Update the custom database column with the updated string value
		
			$wpdb->update($table_name, array('product_info' => '['.$updatedPostsString.']'), array('post_id' => $case_id));

		
        }
        
       
    }
}
add_action('acf/save_post', 'run_custom_function');

function modify_dropdown_options($field) {
  
    if ($field['key'] === 'field_64358342da32c') {
      
     	
      
        $field['choices'] = array();
        $field['choices'][''] = "Select Case";
        $field['choices']['add_new_case'] = "Add New Case";
       


		global $wpdb; 

		$table_name = $wpdb->prefix . 'posts';
		$query = "SELECT * FROM $table_name WHERE post_type= 'case' LIMIT 0,19999999";
		$result = $wpdb->get_results($query,ARRAY_A);
		foreach($result as $val)
		{
			$field['choices'][ $val['ID'] ] = $val['post_title'];
		}
       
        // wp_reset_postdata();
        
    }

    
    return $field;
}
add_filter('acf/load_field', 'modify_dropdown_options');



function custom_acf_admin_htc_data_get() {
  	
  	echo '<style>.group-col {width: 45%; float: left;}</style>';

	$current_user = wp_get_current_user();

	if ( in_array( 'employee_11', $current_user->roles ) ) 
	{
		?>
		<style type="text/css">
			.acf-field-648e092c65627{ display:none !important } 
		</style>
		<?php
	}
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

		function get_description_and_qty()
		{
			var schedual_b = jQuery('.field_63e896b30d74b').val();
			var post_id2   = '<?php echo get_the_ID();?>';
		    jQuery.ajax({
		        url: ajax_url,
		        type: 'POST',
		        data: {
		            action: 'get_schedual_b',
		            schedual_b: schedual_b,
		            post_id2: post_id2,
		            
		        },
		        success: function(response) {
		            
		            
		          
		            jQuery('[data-name="quantity_1_unit"] input').val(response.data.quantity_1);

		            if(response.data.quantity_2=="")
		            {
		            	jQuery('[data-name="quantitytwo"] input').prop("disabled",true);
		            	jQuery('[data-name="quantity_2_unit"] input').prop("disabled",true);
		            }
		            else
		            {
		            	jQuery('[data-name="quantitytwo"] input').prop("disabled",false);
		            	jQuery('[data-name="quantity_2_unit"] input').prop("disabled",false);

		            	jQuery('[data-name="quantity_2_unit"] input').val(response.data.quantity_2);
		            }
		            
		            jQuery('[data-name="schedule_b_description_"] textarea').html(response.data.descrip_1);

		            

		           
		        }
		    });
		}
		jQuery(document).on('change', '.field_63e896b30d74b', function() {
			
			get_description_and_qty();

		});

		function type_vehical()
		{

			var vehical_type = jQuery('[data-name="type2"] select').val();
			
			if(vehical_type=="Vehicle")
			{
				var option = new Option('8703220100', '12781');
				jQuery('.field_63e896b30d74b').append(option);
				jQuery('.field_63e896b30d74b').trigger('change');

				jQuery('.field_63e896b30d74b').val('12781').trigger('change');
			}

		}
		//type_vehical();

		jQuery(document).on('change', '[data-name="type2"] select', function() {
			
			 type_vehical();
			
		});




		jQuery('[data-name="package"] input').parent().append('<span class="package_msg"></span>');
		jQuery('[data-name="weight"] input').parent().append('<span class="weight_msg"></span>');
		jQuery('[data-name="value"] input').parent().append('<span class="value_msg"></span>');


		function check_ready_to_export(need_to_scroll)
		{

			var error_1		=	false;	
			
			var checkbox 	= 	jQuery('[data-name="ready_to_export"] input');
			
			
			var package_n 	= 	jQuery('[data-name="package"] input');
			var weight_n 	= 	jQuery('[data-name="weight"] input');
			var value_n 	= 	jQuery('[data-name="value"] input');
			


			if(checkbox.is(':checked'))
			{


				

				if (package_n.val() === '') {
					package_n.css('border-color',"red");
					jQuery(".package_msg").html('<span style="color:red">Package should be provide to export</div>');
					error_1 = true; 
					if(need_to_scroll){jQuery('html, body').animate({scrollTop: package_n.offset().top-100 }, 2000);}
					
				}
				else
				{
					jQuery(".package_msg").html('');
					package_n.css('border-color',"#767676")
				}



				if (weight_n.val() === '') {
					weight_n.css('border-color',"red");
					jQuery(".weight_msg").html('<span style="color:red">Weight should be provide to export</div>');
					error_1 = true;	
					
					if(need_to_scroll){jQuery('html, body').animate({scrollTop: weight_n.offset().top-100 }, 2000);}
				}
				else
				{
					jQuery(".weight_msg").html('');
					weight_n.css('border-color',"#767676")
				}



				if (value_n.val() === '') {
					value_n.css('border-color',"red");
					jQuery(".value_msg").html('<span style="color:red">Value should be provide to export</div>');
					error_1 = true;
					
					if(need_to_scroll){jQuery('html, body').animate({scrollTop: value_n.offset().top-100 }, 2000);}
				}
				else
				{
					jQuery(".value_msg").html('');
					value_n.css('border-color',"#767676")
				}


				if(error_1)
				{
					checkbox.prop('checked', false);	
				}
				else
				{
					checkbox.prop('checked', true);		
				}


		  	}



		
		}

		check_ready_to_export(false);

		jQuery(document).on('change', '#acf-field_63e9f69faf12d', function() {
			
			check_ready_to_export(true);
		
		});
	
		jQuery(document).on('change', '[data-name=package] input , [data-name="weight"] input ,  [data-name="value"] input ', function() {
			
			check_ready_to_export(false);
		
		});

		jQuery(window).on("load",function (){
			
			setTimeout(function(){

				
			
				var htc_id = jQuery('[data-name="schedual_b_code"] .acf-input .acf-relationship .selection ul li input').val();
				var post_id2   = '<?php echo get_the_ID();?>';
			    jQuery.ajax({
			        url: ajax_url,
			        type: 'POST',
			        data: {
			            action: 'get_available_dates',
			            htc_id: htc_id,
			            post_id2: post_id2,
			            
			        },
			        success: function(response) {
			            // update the available dates radio buttons with the new values
			            jQuery('.avaliable_dates').html(response);
			           
			        }
			    });

			},2000);
			
		});

		jQuery(document).on('click', '[data-name="schedual_b_code"] .acf-input .acf-relationship .selection ul li , [data-name="schedual_b_code"] [data-name="remove_item"]', function() {
			var htc_id = jQuery('[data-name="schedual_b_code"] .acf-input .acf-relationship .selection ul li input').val();
			var post_id2   = '<?php echo get_the_ID();?>';
		    jQuery.ajax({
		        url: ajax_url,
		        type: 'POST',
		        data: {
		            action: 'get_htc_data',
		            htc_id: htc_id,
		            post_id2: post_id2,
		        },
		        success: function(response) {
		            
					jQuery('[data-name="quantity_1_unit"] input').val(response.data.quantity_1);
					
					jQuery('[data-name="quantity_2_unit"] input').val(response.data.quantity_2);
				
					jQuery('[data-name="schedule_b_description_"] textarea').val(response.data.descrip_1);
		           
		        }
		    });
		});

		jQuery(document).on('click', ' [data-name="schedual_b_code"] [data-name="remove_item"]', function() {
			var htc_id = jQuery('[data-name="schedual_b_code"] .acf-input .acf-relationship .selection ul li input').val();
			var post_id2   = '<?php echo get_the_ID();?>';
			if(htc_id=="")
			{	
				jQuery('[data-name="quantity_1_unit"] input').val('');
				
				jQuery('[data-name="quantity_2_unit"] input').val('');

				jQuery('[data-name="schedule_b_description_"] textarea').val('');
			}
			else
			{


			    jQuery.ajax({
			        url: ajax_url,
			        type: 'POST',
			        data: {
			            action: 'get_htc_data',
			            htc_id: htc_id,
			            post_id2: post_id2,
			        },
			        success: function(response) {
			          
			           jQuery('[data-name="quantity_1_unit"] input').val(response.data.quantity_1);
				
						jQuery('[data-name="quantity_2_unit"] input').val(response.data.quantity_2);

						jQuery('[data-name="schedule_b_description_"] textarea').val(response.data.descrip_1);
			           
			        }
			    });
		    }
		});
		/*-------------------------------------------------------*/

		function debounce(func, delay) {
		    let timer;
		    return function() {
		        const context = this;
		        const args = arguments;
		        clearTimeout(timer);
		        timer = setTimeout(() => {
		            func.apply(context, args);
		        }, delay);
		    }
		}

		// Define the search_vin function to be debounced
		const search_vin_debounced = debounce(search_vin, 500);

		// Attach the debounced search_vin function to the keyup event
		jQuery(document).on('keyup', '[data-name="vin"] input', function() {
		    // Call the debounced search_vin function
		    search_vin_debounced();
		});

		function search_vin() {
		    var vin_no2 = jQuery('[data-name="vin"] input').val();

		    jQuery.ajax({
		        type: "POST",
		        url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
		        data: {
		            action: "search_vin",
		            vin_no: vin_no2
		        },
		        success: function(data) {
		            var car_data = JSON.parse(data);

		            
		            console.log(car_data);
		            jQuery('[data-name="description"] input').val(car_data.model_year+" "+car_data.make+" "+car_data.model);
		            jQuery('[data-name="make"] input').val(car_data.make);
		            jQuery('[data-name="model"] input').val(car_data.model);
		            jQuery('[data-name="year"] input').val(car_data.model_year);
		            jQuery('[data-name="weight"] input').val(car_data.weight);
		            var possible_value = car_data.possible_value;
		        	if(possible_value!="")
		        	{
		        		jQuery('[data-name="value"] input').val(possible_value);
		        	}
		        },
		        complete: function(data) {
		            //jQuery('.search_vin').prop('disabled', false);
		            //jQuery('.search_vin').html('Search VIN');
		        }
		    });
		}

		jQuery(document).ready(function() {
		  jQuery('#acf-field_648e092c65627').on('change', function() {
		    if (jQuery(this).val() == 'ready to process') {
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
  </script>
  <?php
}

add_action('acf/input/admin_head', 'custom_acf_admin_htc_data_get');


function get_htc_data() {

    $htc_id = $_POST['htc_id'];

    if ($htc_id!="") {
    
        $htc_data = array(

            'quantity_1' => get_field('quantity_1', $htc_id),

            'quantity_2' => get_field('quantity_2', $htc_id),

            'descrip_1' => get_field('descrip_1', $htc_id)

        );

        wp_send_json_success($htc_data);
    
    } 
    else 
    {
        wp_send_json_error('No HTC data found');
    }

    wp_die();
}
add_action('wp_ajax_get_htc_data', 'get_htc_data');
add_action('wp_ajax_nopriv_get_htc_data', 'get_htc_data');


function get_schedual_b_fn() {

    $schedual_b = $_POST['schedual_b'];   

    if($schedual_b!="")
    {

        $htc_data = array(
        
            'quantity_1' => get_field('quantity_1', $schedual_b),
        
            'quantity_2' => get_field('quantity_2', $schedual_b),
        
            'descrip_1' => get_field('descrip_1', $schedual_b)
        
        );
        
        wp_send_json_success($htc_data);
    
    } 
    else 
    {
        wp_send_json_error('No HTC data found');
    }

    wp_die();
}
add_action('wp_ajax_get_schedual_b', 'get_schedual_b_fn');
add_action('wp_ajax_nopriv_get_schedual_b', 'get_schedual_b_fn');

/*-------------------------------commodities notes-----------------------------------------*/
// Add the meta box
function commodities_notes_meta_box() {
    add_meta_box(
        'commodities_notes',
        'commodities Notes',
        'render_commodities_notes_meta_box',
        'commodities',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'commodities_notes_meta_box');

// Render the meta box content
function render_commodities_notes_meta_box($post) {
    $notes = get_post_meta($post->ID, 'commodities_notes', true);
    wp_nonce_field('save_commodities_note', 'commodities_notes_nonce');
    ?>
    <style>
    #notes-container {
	    padding: 20px;
	    background-color: #f5f5f5;
	}

	.note {
	    background-color: #ffffff;
	    border: 1px solid #e0e0e0;
	    padding: 10px;
	    margin-bottom: 10px;
	    position: relative;
	}

	.note p {
	    margin: 0;
	}

	.delete-note {
	    position: absolute;
	    top: 5px;
	    right: 5px;
	    color: #ff0000;
	    font-size: 12px;
	    text-decoration: none;
	    top: 17px;
		right: -22px;
	}

	#new-note {
	    margin-top: 10px;
	}

	#add-note {
	    margin-top: 10px;
	}
	

    </style>
    <div id="notes-container">
        <div id="notes-list">
            <?php if (!empty($notes)) : ?>
                <?php foreach ($notes as $note) : ?>
                    <div class="note">
                        <p><?php echo html_entity_decode($note['message']); ?></p>
                        <a href="#" delete_id="<?php echo $note['id'];?>" class="delete-note"><span class="dashicons dashicons-trash"></span></a><!--  -->
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <textarea id="new-note" name="new_shipment_note" rows="3" style="width:100%;"></textarea>
        <button id="add-note" class="button">Add Note</button>
    </div>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('#add-note').on('click', function (e) {
                    e.preventDefault();
                    var note = $('#new-note').val();
                    if (note !== '') {
                        $.ajax({
                            url: ajaxurl, // AJAX endpoint set by WordPress
                            type: 'POST',
                            data: {
                                action: 'save_commodities_note',
                                note: note,
                                post_id: '<?php echo $post->ID; ?>',
                                nonce: '<?php echo wp_create_nonce("save_shipment_note"); ?>'
                            },
                            success: function (response) {
                                if (response.success) {
                                    $('#notes-list').append('<div class="note" ><p>' + response.note + '</p><a href="#" class="delete-note" delete_id="'+ response.id +'"><span class="dashicons dashicons-trash"></span></a></div>');
                                    $('#new-note').val('');
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

                
            });

            $(document).ready(function () {
		       
		        $(document).on('click', '.delete_auto_fill_templete', function (e) {
		            e.preventDefault();
		            var noteContainer = $(this).closest('.note');
		            var note = noteContainer.find('p').text();
		            
		            var delete_id = $(this).attr('delete_id');
		            $.ajax({
		                url: ajaxurl,
		                type: 'POST',
		                data: {
		                    action: 'delete_auto_fill_templete',
		                    note: note,
		                    post_id: '<?php echo $post->ID; ?>',
		                    nonce: '<?php echo wp_create_nonce("delete_shipment_note"); ?>',
		                    delete_id:delete_id
		                },
		                success: function (response) {
		                   $(".resp").html(response);
		                },
		                error: function (jqXHR, textStatus, errorThrown) {
		                    console.log('AJAX error: ' + textStatus + ' - ' + errorThrown);
		                }
		            });
		        });

		        $(document).on('click', '.delete-note', function (e) {
		            e.preventDefault();

		            var mythis = $(this);
		            var noteContainer = $(this).closest('.note');
		            
		            var note = noteContainer.find('p').text();
		            
		            var delete_id = $(this).attr('delete_id');
		            $.ajax({
		                url: ajaxurl,
		                type: 'POST',
		                data: {
		                    action: 'delete_commodities_note',
		                    note: note,
		                    post_id: '<?php echo $post->ID; ?>',
		                    nonce: '<?php echo wp_create_nonce("delete_shipment_note"); ?>',
		                    delete_id:delete_id
		                },
		                success: function (response) {
		                   mythis.parents('.note').remove();
		                   $(".resp").html(response);
		                },
		                error: function (jqXHR, textStatus, errorThrown) {
		                    console.log('AJAX error: ' + textStatus + ' - ' + errorThrown);
		                }
		            });
		        });
		    });
        })(jQuery);
    </script>
    <?php
}



// Save the shipment note
function save_commodities_note() {
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
        if (wp_verify_nonce($nonce, 'save_commodities_note') or 1) {
          
            $notes = get_post_meta($post_id, 'commodities_notes', true);
            if(!is_array($notes))
            {
            	$notes = array();	
            }
           
            $id     	= time();

            $notes[$id] = array('id'=>$id,'message'=>$note,'can_delete'=>'yes');

           
            update_post_meta($post_id, 'commodities_notes', $notes);

            $response['success'] = true;
            $response['note'] = $note;
            $response['message'] = 'Commodities note saved successfully.';
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
add_action('wp_ajax_save_commodities_note', 'save_commodities_note');
add_action('wp_ajax_nopriv_save_commodities_note', 'save_commodities_note');




function load_auto_fill_templete()
{
	global $wpdb;
    $table_name =  'wp_tr_commodities_template';
    $templates = $wpdb->get_results("SELECT DISTINCT template_name, id FROM $table_name");
    echo '<table class="table_border" border="1">';

    foreach ($templates as $template) {
    	if($template->template_name!="")
    	{
    		?>
    		<tr>
    			<td>
    			<?php 

    				echo '' . esc_html($template->template_name) . '';
    			?>
    				
    			</td>
    			<td class="td_center">
    				<a class="load_template_button" template_name="<?php echo esc_attr($template->template_name) ; ?>" >
    					<span class="dashicons dashicons-admin-appearance"></span>
    				</a>
    				<a delete_id="<?php echo $template->id;?>" class="delete_auto_fill_templete"><span class="dashicons dashicons-trash"></span></a>
    			</td>
    		</tr>
    		<?php
        	
    	}
    }
    echo '</table>';
}


function delete_auto_fill_templete() {
    $response = array(
        'success' => false,
        'message' => 'Error deleting shipment note.'
    );

    if (isset($_POST['note'])  && isset($_POST['nonce'])) {
        $note = sanitize_textarea_field($_POST['note']);
        $post_id = intval($_POST['post_id']);
        $delete_id= $_POST['delete_id'];

        $nonce = $_POST['nonce'];

       
        if (wp_verify_nonce($nonce, 'delete_commodities_note') or true) {
           
            global $wpdb;
            $wpdb->query("delete from wp_tr_commodities_template where id='".$delete_id."' ");
           

            $response['success'] = true;
            $response['message'] = 'commodities note deleted successfully.';
        } else {
            $response['message'] = 'Invalid nonce.';
        }
    } else {
        $response['message'] = 'Invalid request.';
    }

    
    load_auto_fill_templete();
    exit();
}

// Register the AJAX action
add_action('wp_ajax_delete_auto_fill_templete', 'delete_auto_fill_templete');
add_action('wp_ajax_nopriv_delete_auto_fill_templete', 'delete_auto_fill_templete');




function check_if_employe($user_id)
{

	$user_data = get_userdata($user_id);

	if ($user_data) {
	    $user_roles = $user_data->roles; 

	    if (!empty($user_roles)) {

	        if (in_array('employee_11', $user_roles) || in_array('employee_22', $user_roles) || in_array('employee_33', $user_roles)) {
	           

	           return true;
	        } 
	        else
	        {
	        	return false;
	        }
	    } 
	    else
	    {
	    	return false;
	    }
	}
	else
	{
		return false;
	}

}

function get_company_id($user_id)
{
	global $wpdb;
	$qry     = "SELECT user_id FROM `tr_usermeta` where meta_key='company_employee ' and meta_value like '%".$user_id."%'";
	$comp_id = $wpdb->get_col($qry);
	return $comp_id;
}
function testing_email()
{
	if(isset($_GET['iamdev9910']) and $_GET['iamdev9910']=="ok")
	{

		

		$user_id = 990029; 
		if(check_if_employe($user_id))
		{
			$comp_id = get_company_id($user_id);
			$comp_id = ($comp_id_ar[0]);
		
		}
		exit;
	}
}
add_action("init",'testing_email');






function send_email_commodity($email_message,$commodity_id,$creator_user_id )
{

	
	$user_info = get_userdata($creator_user_id);

	if ($user_info) {
	    
		if(check_if_employe($creator_user_id))
		{

	    	$comp_id_ar = get_company_id($creator_user_id);
	    	
	    	$comp_id    = ($comp_id_ar[0]);
	    	

	    	
	    	$comp_info = get_userdata($comp_id);

	    
	    	if ($comp_info) 
	    	{
	    		$email 	= 	$comp_info->data->user_email;
	    		
	    	}

	  	}
	  	else
	  	{
	  		$email 	= 	$user_info->data->user_email;
	  	}

		#$to 	 = 	"zeeshangill11@gmail.com";
	    $to    	 =	$email;

		$subject = 	"Commodity status changes.";

		$message = "
		<html>
			<head>
				<title>Commodity status changes.</title>
			</head>
			<body>
				<p>Hi, Commodity#".$commodity_id." status changes.".$email_message."</p>			
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



function add_update_note3($post_id) {
    // Check if it's a shipping post type
    global $wpdb;

    if (get_post_type($post_id) === 'commodities') {
        // Check if the current user can edit the post
        if (current_user_can('edit_post', $post_id)) {
            
            $res     						 =  $wpdb->get_results("select * from tr_commodities where post_id ='".$post_id."'",ARRAY_A);
			
			$select_shipment_type 	 		 =	$res[0]['select_shipment_type'];
		
			$ocean_export_booking_prducts 	 =	$res[0]['ocean_export_booking_prducts'];
			
			$ocean_export_booking_booking 	 =	$res[0]['ocean_export_booking_booking'];
			
			$entry_type 	 				 =	$res[0]['entry_type'];

			$creator_user_id 				 =	$res[0]['creator_user_id'];
			$notes=get_post_meta($post_id, 'commodities_notes', true);
			

			if(!is_array($notes))
            {
            	$notes = array();	
            }

			$notes=update_notes_if_value_change($res[0]['title_number'],$_POST['acf']['field_646b3a2666a3b'],"title number",$notes,'');
			
			$notes=update_notes_if_value_change($res[0]['title_state'],$_POST['acf']['field_646b3a3d66a3c'],"Title State",$notes,'');


			$notes=update_notes_if_value_change($res[0]['package'],$_POST['acf']['field_63dd70ba9d5b7'],"Package",$notes,'');

			$notes=update_notes_if_value_change($res[0]['setup_for_export_'],$_POST['acf']['field_63e89fb0d5f12'],"SETUP FOR EXPORT",$notes,'true_false');


			$notes=update_notes_if_value_change($res[0]['ready_to_export'],$_POST['acf']['field_63e9f69faf12d'],"Ready To Export",$notes,'true_false');

			$notes=update_notes_if_value_change($res[0]['description'],$_POST['acf']['field_63dd70c79d5b8'],"Description",$notes,'');
			

			$notes=update_notes_if_value_change($res[0]['make'],$_POST['acf']['field_63e888ef45a99'],"make",$notes,'');
			
			$notes=update_notes_if_value_change($res[0]['model'],$_POST['acf']['field_63e888f645a9a'],"model",$notes,'');

			$notes=update_notes_if_value_change($res[0]['year'],$_POST['acf']['field_63e2b004e0692'],"year",$notes,'');

			$notes=update_notes_if_value_change($res[0]['weight_'],$_POST['acf']['field_63e8890445a9c'],"weight_",$notes,'');

			$notes=update_notes_if_value_change($res[0]['value'],$_POST['acf']['field_63e888fb45a9b'],"value",$notes,'');

			$notes=update_notes_if_value_change($res[0]['pol'],$_POST['acf']['field_63edebf20efe7'],"pol",$notes,'pol_pod_json');	

			$notes=update_notes_if_value_change($res[0]['pod'],$_POST['acf']['field_63edec300efe8'],"pod",$notes,'pol_pod_json');	

			$notes=update_notes_if_value_change($res[0]['case_attached'],$_POST['acf']['field_64358342da32c'],"pod",$notes,'pol_pod');	

			$notes=update_notes_if_value_change($res[0]['eei_schedule_b_description_'],$_POST['acf']['field_63e894e20d74a']['field_63e9fd47dc808'],"Schedule B Description",$notes,'');

			$notes=update_notes_if_value_change($res[0]['eei_quantityone'],$_POST['acf']['field_63e894e20d74a']['field_63e89a7587349'],"QuantityOne",$notes,'');	


			$notes=update_notes_if_value_change($res[0]['eei_quantity_1_unit'],$_POST['acf']['field_63e894e20d74a']['field_63e9fcd3dc806'],"Quantity 1 unit",$notes,'');


			$notes=update_notes_if_value_change($res[0]['eei_quantitytwo'],$_POST['acf']['field_63e894e20d74a']['field_63e89aa08734a'],"QuantityTwo",$notes,'');	


			$notes=update_notes_if_value_change($res[0]['eei_quantity_2_unit'],$_POST['acf']['field_63e894e20d74a']['field_63e9fd21dc807'],"Quantity 2 unit",$notes,'');	

			$notes=update_notes_if_value_change($res[0]['eei_license_number'],$_POST['acf']['field_63e894e20d74a']['field_63e89d3163144'],"License No",$notes,'');

			$notes=update_notes_if_value_change($res[0]['eei_license_value_'],$_POST['acf']['field_63e894e20d74a']['field_63e89b448734c'],"License Value",$notes,'');

			$notes=update_notes_if_value_change($res[0]['eei_eccn'],$_POST['acf']['field_63e894e20d74a']['field_63e89caf87350'],"ECCN",$notes,'');	


			$notes=update_notes_if_value_change($res[0]['eei_origin'],$_POST['acf']['field_63e894e20d74a']['field_63e89c198734e'],"Origin",$notes,'');	

			$notes=update_notes_if_value_change($res[0]['eei_state_of_origin'],$_POST['acf']['field_63e894e20d74a']['field_63e89c4d8734f'],"State Of Origin",$notes,'');	

 			$notes=update_notes_if_value_change($res[0]['eei_filing_option'],$_POST['acf']['field_63e894e20d74a']['field_63f06b88f5eeb'],"Filing Option",$notes,'');

 			$notes=update_notes_if_value_change($res[0]['eei_mode_of_transportation'],$_POST['acf']['field_63e894e20d74a']['field_63f06cb59f53c'],"MOT",$notes,'');

 			$notes=update_notes_if_value_change($res[0]['eei_hazmat'],$_POST['acf']['field_63e894e20d74a']['field_63f0743f7855a'],"HazMat",$notes,'true_false');

 			$notes=update_notes_if_value_change($res[0]['eei_are_usppi_and_ultimate_consignee_related'],$_POST['acf']['field_63e894e20d74a']['field_63f074ac7855c'],"Are USPPI",$notes,'true_false');


 			$is_email  =  array();
			$is_email  =  update_notes_if_value_change($res[0]['product_status'],$_POST['acf']['field_648e092c65627'],"Product Status",array(),'');
			if(is_array($is_email) and !empty($is_email) )
			{
				$email_message2 = 	'';
				foreach($is_email as $val22)
				{
					$email_message2 .= $val22['message'];	
				}
				

				send_email_commodity($email_message2,get_the_title($post_id),$creator_user_id );
			}

			#echo "----------------------";echo $post_id."<<-----";echo $creator_user_id ."<=====";exit;
			

			// $notes5=update_notes_if_value_change($res[0]['ocean_export_booking_intermediate_consignee'],$_POST['acf']['field_63e9dd603c675']['field_63e8b8919aa9c'],"Intermediate Consignee",$notes4,'user');

			// $notes6=update_notes_if_value_change($res[0]['ocean_export_booking_notify_party'],$_POST['acf']['field_63e9dd603c675']['field_63e8b8b29aa9d'],"Notify Party",$notes5,'user');

			// $notes7=update_notes_if_value_change($res[0]['ocean_export_booking_freight_forwarder'],$_POST['acf']['field_63e9dd603c675']['field_63e8b8de9aa9e'],"Freight Forwarder",$notes6,'user');


			// $notes8=update_notes_if_value_change($res[0]['ocean_export_booking_pol'],$_POST['acf']['field_63e9dd603c675']['field_63f088083f478'][0],"POL",$notes7,'pol_pod');

			// $notes9=update_notes_if_value_change($res[0]['ocean_export_booking_pou'],$_POST['acf']['field_63e9dd603c675']['field_63f088263f479'][0],"POU",$notes8,'pol_pod');

			// $notes10=update_notes_if_value_change($res[0]['ocean_export_booking_selected_cars'],$_POST['acf']['field_63e9dd603c675']['field_63f0ea62bf092'],"Selected Cars",$notes9,'');

			#$notes=update_notes_if_value_change($res[0]['ocean_export_booking_booking'],$_POST['acf']['field_63e9dd603c675']['field_63e9dd7d3c676'][0],"Booking",$notes,'booking_array');


			
			update_post_meta($post_id, 'commodities_notes', $notes);

          
           
        }
    }
}
add_action('pre_post_update', 'add_update_note3');







function validate_unique_vin($valid, $value, $field, $input_name)
{
    global $wpdb;
    
    if ($field['key'] === 'field_63de101b35d32') {
        $vin = sanitize_text_field($value); // Sanitize the VIN value
        
        // Get the current post ID
        $post_id = isset($_POST['post_ID']) ? $_POST['post_ID'] : 0;

        // Check if the VIN exists in any other post type
        $query = $wpdb->get_results($wpdb->prepare(
            "SELECT post_id FROM tr_commodities WHERE vin LIKE %s AND post_id <> %d",
            '%' . $wpdb->esc_like($vin) . '%',
            $post_id
        ), ARRAY_A);

        if (count($query) > 0) {
            $valid = 'The VIN already exists in another post.';
        }
    }
    
    return $valid;
}

add_filter('acf/validate_value', 'validate_unique_vin', 10, 4);


function validate_unique_tag_number($valid, $value, $field, $input_name)
{
    global $wpdb;
    
    if ($field['key'] === 'field_656c8c95faf25') {
        $tag_number = sanitize_text_field($value); // Sanitize the VIN value
        
        // Get the current post ID
        $post_id = isset($_POST['post_ID']) ? $_POST['post_ID'] : 0;

        if($tag_number!="")
        {

	        $query = $wpdb->get_results($wpdb->prepare(
	            "SELECT post_id FROM tr_commodities WHERE tag_number LIKE %s AND post_id <> %d",
	            '%' . $wpdb->esc_like($tag_number) . '%',
	            $post_id
	        ), ARRAY_A);

	        if (count($query) > 0) {
	            $valid = 'The Tag already exists in another post.';
	        }
        }
       
    }
    
    return $valid;
}

add_filter('acf/validate_value', 'validate_unique_tag_number', 10, 4);



function filter_commodities_by_created_by($query)
{
    // if (is_admin() || !$query->is_main_query()) {
    //     return;
    // }
    
    if ($query->is_post_type_archive('commodities')) {

        $current_user_id = get_current_user_id();
        //if()
        $current_user_id = 990008;
        // Modify the query to filter by the current user's ID
        // $query->set('meta_query', array(
        //     array(
        //         'key'     => 'created_by',
        //         'value'   => $current_user_id,
        //         'compare' => '=',
        //     ),
        // ));
    }
}
add_action('pre_get_posts', 'filter_commodities_by_created_by');


add_action("init",function(){


	if(isset($_GET['iamdev77']) and $_GET['iamdev77']=="ok")
	{
		$post_id 						=  '18735';
	
		global $wpdb;
	    $res    = $wpdb->get_results("select creator_user_id from tr_commodities where post_id='".$post_id."'",ARRAY_A);
        $creator_user_id = $res[0]['creator_user_id'];  
    

        if(check_if_employe($creator_user_id)  )
        {

	        $meta_key = 'company_employee';
	        $employee_id = '%' . $creator_user_id . '%';

	        // Query to check if the selected user has the specified employee roles and retrieve the company_id
	        $query = $wpdb->prepare(
	            "SELECT user_id as company_id
	            FROM {$wpdb->prefix}usermeta
	            WHERE meta_key = %s AND meta_value LIKE %s",
	            $meta_key,
	            $employee_id
	        );

	        
	        $results = $wpdb->get_results($query,ARRAY_A);
	        
	       

	        // Check if any results were returned
	        if ($results) {
	            $company_id = $results[0]['company_id'];
	            if($company_id>0)
	            {
		           # echo "=====>>>>>".$company_id;
		            $data['creator_user_id'] = $company_id;
		            #echo "update tr_commodities set creator_user_id='".$company_id."' where post_id='".$post_id."' ";
		            $wpdb->query("update tr_commodities set creator_user_id='".$company_id."' where post_id='".$post_id."' ");
		           #	echo $company_id."<<<=====";
		            update_post_meta($post_id,"creator_user_id",$company_id);
	            }
	          

	        } else {
	            // Handle the case when the user is not an employee or no company_id is found
	        }
			echo "hello";
			exit;
		}

	}


});


add_action("save_post", "my_save_post", 10, 3); // The fourth parameter here sets the number of accepted arguments.

function my_save_post($post_id, $post, $update) {
    if ("publish" != $post->post_status){return;}
   
    global $wpdb;
    $res = $wpdb->get_results("select creator_user_id from tr_commodities where post_id='".$post_id."'", ARRAY_A);
    $creator_user_id = $res[0]['creator_user_id'];  

    if (check_if_employe($creator_user_id)) {
        $meta_key = 'company_employee';
        $employee_id = '%' . $creator_user_id . '%';

        $query = $wpdb->prepare(
            "SELECT user_id as company_id
            FROM {$wpdb->prefix}usermeta
            WHERE meta_key = %s AND meta_value LIKE %s",
            $meta_key,
            $employee_id
        );

        $results = $wpdb->get_results($query, ARRAY_A);
        
        if ($results) {
            $company_id = $results[0]['company_id'];
            if ($company_id > 0) {
                $data['creator_user_id'] = $company_id;
                $wpdb->query("update tr_commodities set creator_user_id='".$company_id."' where post_id='".$post_id."' ");
                update_post_meta($post_id, "creator_user_id", $company_id);
            }
        } 
    }
}




function filter_commodities_by_user_role($query) {
    global $pagenow;

    // Check if we are in the admin area and the query is for the 'commodities' post type
    if (is_admin() && $pagenow === 'edit.php' && isset($query->query['post_type']) && $query->query['post_type'] === 'commodities') {
        // Get the current user's role
        $user = wp_get_current_user();
        $user_roles = (array) $user->roles;

        // Define the roles that have restricted access to commodities
        $restricted_roles = array('company', 'employee_11', 'employee_22', 'employee_33');

        // Define the partner user role
        $partner_role = 'partner';

        // Define the comma-separated list of additional product IDs for partner users
       
        //18743, 18728, 18726
        $partner_additional_products = ''; // Replace with your product IDs

        // If the user role is in the restricted roles, filter posts based on user ID or company ID
        if (array_intersect($user_roles, $restricted_roles)) {
            $current_user_id = get_current_user_id();
            $current_user_company_id = get_company_id($current_user_id);

            // If the user has a company, get the current user's commodities or the commodities of their company
            if (!empty($current_user_company_id)) {
                $current_user_ids = array_merge(array($current_user_id), $current_user_company_id);

                // Get the current user's commodities or the commodities of their company
                add_filter('posts_clauses', function ($clauses) use ($current_user_ids) {
                    global $wpdb;

                    $current_user_ids_str = implode(',', $current_user_ids);
                    $clauses['join'] .= " LEFT JOIN $wpdb->postmeta AS creator_user_id_meta ON ($wpdb->posts.ID = creator_user_id_meta.post_id)";
                    $clauses['where'] .= " AND (creator_user_id_meta.meta_key = 'creator_user_id' AND creator_user_id_meta.meta_value IN ($current_user_ids_str))";

                    return $clauses;
                });
            } else {
                // If the user has no company, filter posts based on the current user's ID only
                add_filter('posts_clauses', function ($clauses) use ($current_user_id) {
                    global $wpdb;

                    $clauses['join'] .= " LEFT JOIN $wpdb->postmeta AS creator_user_id_meta ON ($wpdb->posts.ID = creator_user_id_meta.post_id)";
                    $clauses['where'] .= " AND (creator_user_id_meta.meta_key = 'creator_user_id' AND creator_user_id_meta.meta_value = '$current_user_id')";

                    return $clauses;
                });
            }
        } elseif (in_array($partner_role, $user_roles)) {
            // For partner users, display additional products in addition to their commodities

            // Get the list of additional product IDs
            $additional_product_ids = array_map('intval', explode(',', $partner_additional_products));

            // Get the partner user's commodities using custom SQL query
            global $wpdb;
            $partner_commodities_ids = $wpdb->get_col($wpdb->prepare(
                "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'creator_user_id' AND meta_value = %s",
                $current_user_id
            ));

            $all_product_ids = array_merge($additional_product_ids, $partner_commodities_ids);

            // Set the post__in parameter to include the additional products and partner commodities
            $query->set('post__in', $all_product_ids);
        } else {
            // For any other role not in the restricted roles or partner role, show all commodities
            $query->set('post__in', array());
        }
    }
}

add_action('pre_get_posts', 'filter_commodities_by_user_role');


// global $wpdb;
// $query2 =  "SELECT post_id FROM {$wpdb->prefix}shipment_info WHERE creator_user_id in(". $comp_ids_str.")  
// or ocean_export_booking_partner='".get_current_user_id()."' ";

// $postIds_ar = $wpdb->get_results($query2,ARRAY_A);
// $postIds = array();
// foreach($postIds_ar as $val)
// {
// 		$postIds[] = $val['post_id'];
// }





function add_commodities_template_meta_box() {
    add_meta_box(
        'commodities_template_meta_box',
        'Auto-fill Template',
        'render_commodities_meta_box',
        'commodities',
        'normal',
        'high'
    );
}

add_action( 'add_meta_boxes', 'add_commodities_template_meta_box' );


function render_commodities_meta_box( $post ) {
    // Retrieve the current values of the meta fields.
    // Retrieve the current values of the meta fields.
    $custom_field_value = get_post_meta( $post->ID, '_custom_field', true );

  

    ?>
    <style type="text/css">
    	.table_border{ border-collapse: collapse; width: 100%; }
    	.td_center{ text-align: center; padding: 2px; }
    </style>
    
    	
    <div class="resp">		
    
	    <?php 

	  	load_auto_fill_templete();

	    ?>
	</div>

    <br>
    <label for="template_name">Template_Name:</label>
    <input type="text" id="template_name" name="template_name" autocomplete="off">
 
    <button type="button" id="save_template_button" class="button">Save Value as Template</button>

    <script>
        jQuery(document).ready(function($) {
            //l_b_code] select").html(' <option value="4267">0101900055</option>')
            //jQuery("[data-name=schedual_b_code] select").html(' <option value="4267">0101900055</option>')
            //jQuery("[data-name=ready_to_export] input").prop('checked',true);

            $('#save_template_button').on('click', function () {
                // Collect all values from the edit screen
                var values = {};
                $('#post').find(':input').each(function () {
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    values[name] = value;
                });

              
                if(jQuery("[data-name='ready_to_export'] input[type='checkbox']").prop('checked'))
                {
                	values["ready_to_export"] = "1";
                }
                else
                {
                	values["ready_to_export"] = "0";
                }
                /*----------------------------------*/

                if(jQuery("[data-name='setup_for_export_'] input[type='checkbox']").prop('checked'))
                {
                	values["setup_for_export_"] = "1";
                }
                else
                {
                	values["setup_for_export_"] = "0";
                }

                /*----------------------------------*/

                if(jQuery("[data-name='hazmat'] input[type='checkbox']").prop('checked'))
                {
                	values["hazmat"] = "1";
                }
                else
                {
                	values["hazmat"] = "0";
                }

                /*----------------------------------*/

                if(jQuery("[data-name='is_this_a_routed_transaction'] input[type='checkbox']").prop('checked'))
                {
                	values["is_this_a_routed_transaction"] = "1";
                }
                else
                {
                	values["is_this_a_routed_transaction"] = "0";
                }

                /*----------------------------------*/

                if(jQuery("[data-name='are_usppi_and_ultimate_consignee_related'] input[type='checkbox']").prop('checked'))
                {
                	values["are_usppi_and_ultimate_consignee_related"] = "1";
                }
                else
                {
                	values["are_usppi_and_ultimate_consignee_related"] = "0";
                }

                /*----------------------------------*/

                if(jQuery("[data-name=pol] select").val())
                {
                	var option_text = jQuery("[data-name=pol] select option:selected").text();;
                	var option_val  = jQuery("[data-name=pol] select").val();
                	values['pol_value'] =  option_val;
                	values['pol_text']  =  option_text;
                }

                /*----------------------------------*/

                if(jQuery("[data-name=pod] select").val())
                {
                	var option_text = jQuery("[data-name=pod] select option:selected").text();;
                	var option_val  = jQuery("[data-name=pod] select").val();
                	values['pod_value'] =  option_val;
                	values['pod_text']  =  option_text;
                }



                if(jQuery("[data-name=schedual_b_code] select").val())
                {
                	var option_text = jQuery("[data-name=schedual_b_code] select option:selected").text();;
                	var option_val  = jQuery("[data-name=schedual_b_code] select").val();
                	values['schedual_b_code_value'] =  option_val;
                	values['schedual_b_code_text']  =   option_text;
                }




                if(jQuery("[data-name=schedule_b_description_] textarea").val())
                {
                	values['schedule_b_description_'] =  jQuery("[data-name=schedule_b_description_] textarea").val();
                }
               
                //console.log(values);



                $('#post').find('.acf-field-text').each(function () {
                    var name = $(this).attr('data-name');
                    var value = $(this).find('input').val();
                    values[name] = value;

                });
                values['template_name'] = $("#template_name").val();
                // Additional data to send
                values['action'] = 'save_commodities_template';
                values['security'] = '<?php echo wp_create_nonce("save_commodities_template_nonce"); ?>';

                // Make Ajax call to save data
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: values,
                    success: function (response) {
                        $(".resp").html(response);
                        $("#template_name").val('');
                        alert('Template saved successfully!');

                    },
                    error: function (error) {
                        console.error('Error saving template: ' + error.responseText);
                    }
                });
            });
        });
    </script>


     <script>
        jQuery(document).ready(function ($) {
            $('.load_template_button').on('click', function () {
                var selectedTemplate = $(this).attr('template_name');

               	var select_type = ['pol','pod'];
                if (selectedTemplate !== '') {
                    // Make Ajax call to retrieve template values
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'load_commodities_template',
                            template_name: selectedTemplate,
                            security: '<?php echo wp_create_nonce("load_commodities_template_nonce"); ?>'
                        },
                        success: function (response) {
                            if (response.success) {
                                // Update form fields with template values
                                var templateValues = JSON.parse(response.data.custom_field_value);
                                console.log(templateValues);
                                for (var fieldName in templateValues) {
                                    if (templateValues.hasOwnProperty(fieldName)) {
                                        
                                        var fieldValue = templateValues[fieldName];
                                        if(fieldName=="ready_to_export" || fieldName=="setup_for_export_" || fieldName=="hazmat" 
                                        	|| fieldName=="is_this_a_routed_transaction" 
                                        	|| fieldName=="are_usppi_and_ultimate_consignee_related")
                                        {
                                        	if(fieldValue=="1")
                                        	{
                                        		jQuery("[data-name='"+fieldName+"'] input[type='checkbox']").click();
                                        	}
                                        }
                                        else if(fieldName=="schedual_b_code_value")
                                        {
                                        	schedual_b_code_value = templateValues['schedual_b_code_value'];
                                        	schedual_b_code_text  = templateValues['schedual_b_code_text'];
                                        	
                                        	
                                        	jQuery("[data-name='schedual_b_code'] select").html('<option value="'+schedual_b_code_value+'">'+schedual_b_code_text+'</option>');
                                        
                                        }

                                        else if(fieldName=="pol_value")
                                        {

                                        	pol_value = templateValues['pol_value'];
                                        	pol_text  = templateValues['pol_text'];
                                        	
                                        	jQuery("[data-name='pol'] select").html('<option value="'+pol_value+'">'+pol_text+'</option>');
                                        
                                        }

                                        else if(fieldName=="pod_value")
                                        {

                                        	pod_value = templateValues['pod_value'];
                                        	pod_text  = templateValues['pod_text'];
                                        	
                                        	jQuery("[data-name='pod'] select").html('<option value="'+pod_value+'">'+pod_text+'</option>');
                                        
                                        }


                                        else if(fieldName=="schedule_b_description_")
                                        {
                                        	
                                        	jQuery("[data-name='"+fieldName+"'] textarea").html(fieldValue);

                                        }
                                        else if(select_type.indexOf(fieldValue)!==-1)
                                        {
                                        	
                                        }
                                        else
                                        {
                                        	$('[name="' + fieldName + '"]').val(fieldValue);
                                        	$('[data-name="' + fieldName + '"]').find('input').val(fieldValue);
                                        }

                                       
                                    }
                                }
                                alert('Template loaded successfully!');
                            } else {
                                alert('Failed to load template.');
                            }
                        },
                        error: function (error) {
                            console.error('Error loading template: ' + error.responseText);
                        }
                    });
                } else {
                    alert('Please select a template first.');
                }
            });
        });
    </script>


    <?php
}

function save_commodities_meta_data( $post_id ) {
    if ( isset( $_POST['custom_field'] ) ) {
        update_post_meta( $post_id, '_custom_field', sanitize_text_field( $_POST['custom_field'] ) );
    }
}

add_action( 'save_post_commodities', 'save_commodities_meta_data' );



function save_commodities_template() {
    


    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'save_commodities_template_nonce')) {
        die('Permission check failed');
    }

    // Sanitize and get values
    $post_id = intval($_POST['post_id']);
    $template_name = sanitize_text_field($_POST['template_name']);

    // Collect all values from the edit screen
    $custom_values = array();
    foreach ($_POST as $key => $value) {
        // Exclude non-relevant fields
        if ($key !== 'action' && $key !== 'security' && $key !== 'post_id' && $key !== 'template_name') {
            $custom_values[$key] = sanitize_text_field($value);
        }
    }

    // Save to custom table
    global $wpdb;
    $table_name =  'wp_tr_commodities_template';

    $wpdb->insert(
        $table_name,
        array(
            'post_id'            => $post_id,
            'template_name'      => $template_name,
            'custom_field_value' => json_encode($custom_values), // Save as serialized data
        ),
        array(
            '%d',  // post_id should be an integer
            '%s',  // template_name should be a string
            '%s'   // custom_field_value should be a string
        )
    );


    load_auto_fill_templete();

    wp_die();
}

add_action( 'wp_ajax_save_commodities_template', 'save_commodities_template' );
add_action( 'wp_ajax_nopriv_save_commodities_template', 'save_commodities_template' );




function load_commodities_template() {
    // Check nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'load_commodities_template_nonce')) {
        wp_send_json_error('Permission check failed');
    }

    // Sanitize and get values
    $template_name = sanitize_text_field($_POST['template_name']);

    // Retrieve template values from the custom table
    global $wpdb;
    $table_name = 'wp_tr_commodities_template';
    $template_values = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE template_name = %s",
            $template_name
        ),
        ARRAY_A
    );

    if ($template_values) {
        wp_send_json_success($template_values);
    } else {
        wp_send_json_error('Template not found.');
    }
}

add_action('wp_ajax_load_commodities_template', 'load_commodities_template');
add_action('wp_ajax_nopriv_load_commodities_template', 'load_commodities_template');

/*-------------------------------------------------------------------------------------*/


function car_expense_metabox() {
    add_meta_box(
        'car_expense_metabox', // Unique ID
        'Car Expense',         // Metabox Title
        'render_car_expense_metabox', // Callback function to render the content
        'commodities',         // Post type where the metabox will be displayed
        'normal',            // Context (normal, advanced, side)
        'high'               // Priority (high, core, default, low)
    );
}
add_action('add_meta_boxes', 'car_expense_metabox');

function render_car_expense_metabox($post) {
    $car_expense = get_post_meta($post->ID, '_car_expense', true);

    ?>
    <style>
       .expenses-table {
		    width: 100%;
		    border-collapse: collapse;
		    margin-top: 20px;
		}

		.expenses-table th,
		.expenses-table td {
		    border: 1px solid #ddd;
		    padding: 8px;
		    text-align: left;
		    font-size: 16px;
		}

		.expenses-table th {
		    background-color: #f2f2f2;
		}

		.expenses-table tbody tr:nth-child(even) {
		    background-color: #f9f9f9;
		}

		.expenses-table tbody tr:hover {
		    background-color: #e5e5e5;
		}
        #expenseForm {
            max-width: 300px;
            margin: 20px auto;
        }

        #expenseForm label {
            display: block;
            margin-bottom: 5px;
        }

        #expenseForm input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .swal2-title {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .swal2-content {
            padding: 0;
        }

        .swal2-actions {
            text-align: center;
        }

        .swal2-confirm {
            padding: 10px 20px;
        }
    </style>

	<button type="button" id="open_expense_modal" class="button">Add Expense</button>
	<button type="button" id="view_expenses" class="button">View Expenses</button>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
        	$(document).on('click', '.expenseFormBtn',function () {
            	
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: 'POST',
                    data: {
                        action: "save_expense",
                        post_id: "<?php echo $post->ID; ?>",
                        expense_description: $("#expense_description").val(),
                        expense_amount: $("#expense_amount").val(),
                        nonce: "<?php echo wp_create_nonce('save_expense_nonce'); ?>"
                    },
                    success: function (response) {
                        console.log(response);
                        var response_ar = JSON.parse(response);
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Expense added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            // Close the modal
                            Swal.close();
                        });
                        $("[data-name='total_expense'] input").val(response_ar.total_exp);
                    }
                });
            });

            $('#open_expense_modal').on('click', function () {
                Swal.fire({
                    title: 'Add Expense',
                    html:
                        '<form id="expenseForm">' +
                        '  <label for="expense_description">Description:</label>' +
                        '  <input type="text" name="expense_description" id="expense_description" placeholder="Enter description">' +
                        '  <label for="expense_amount">Expense Amount:</label>' +
                        '  <input type="text" name="expense_amount" id="expense_amount" placeholder="Enter amount">' +
                        '  <button type="button" class="button expenseFormBtn">Add Expense</button>' +
                        '</form>',
                    showCloseButton: true,
                    showConfirmButton: false,
                    onOpen: function () {

                    }
                });
            });

            $('#view_expenses').on('click', function () {
			    // Add code to handle the action when the "View Expenses" button is clicked
			    console.log('View Expenses clicked');

			    // Perform an AJAX request to fetch and display expenses
			    $.ajax({
			        url: "<?php echo admin_url('admin-ajax.php'); ?>",
			        type: 'POST',
			        data: {
			            action: "get_expenses",
			            post_id: "<?php echo $post->ID; ?>",
			            nonce: "<?php echo wp_create_nonce('get_expenses_nonce'); ?>"
			        },
			        success: function (response) {
			            // Handle the response, for example, display expenses in a modal
			            console.log(response);

			            // Here, you can use SweetAlert or another modal library to display the expenses
			            Swal.fire({
			                title: 'Expenses for <?php echo get_the_title($post->ID); ?>',
			                html: response,
			                width: '700px',
			                showCloseButton: true,
			                showConfirmButton: false
			            });
			        }
			    });
			});

			 $(document).on('click','.delete-expense', function () {
                var expenseId = $(this).data('expense-id');
                var postId = $(this).data('post-id');

                
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: 'POST',
                    data: {
                        action: "delete_expense",
                        expense_id: expenseId,
                        post_id: postId,
                        nonce: "<?php echo wp_create_nonce('delete_expense_nonce'); ?>"
                    },
                    success: function (deleteResponse) {
                        var response_ar = JSON.parse(deleteResponse);
                        Swal.fire({
			                title: 'Expense Deleted',
			               
			                showCloseButton: true,
			                showConfirmButton: false
			            });

			            $("[data-name='total_expense'] input").val(response_ar.total_exp);

                    }
                });
            });



        });
    </script>
   
    <?php 
   
}




function update_expense_acf($post_id)
{
	global $wpdb;
	$expenses = $wpdb->get_results($wpdb->prepare("SELECT * FROM tr_car_expenses WHERE post_id = %d", $post_id ));
    $total_expense = 0;
    foreach ($expenses as $expense) {
        $total_expense += $expense->expense_amount;
    }
   
	update_post_meta($post_id,'total_expense',$total_expense);
	$wpdb->update("tr_commodities",array('total_expense'=>$total_expense),array('post_id'=>$post_id));
	return $total_expense;
}




add_action('wp_ajax_delete_expense', 'delete_expense_callback');

function delete_expense_callback() {
    check_ajax_referer('delete_expense_nonce', 'nonce');

    $expense_id = isset($_POST['expense_id']) ? intval($_POST['expense_id']) : 0;
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    if ($expense_id > 0) {
        global $wpdb;
        $table_name =  'tr_car_expenses';

        // Perform the deletion
        $wpdb->delete($table_name, array('id' => $expense_id), array('%d'));

         $total_exp = update_expense_acf($post_id);


        echo json_encode(array('success' => true, 'message' => 'Expense deleted successfully.','total_exp'=>$total_exp));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid expense ID.'));
    }

    wp_die();
}




function get_expenses_function($post_id) {
    // Add your logic to fetch expenses based on the $post_id
    global $wpdb;
    
    $table_name =  'tr_car_expenses';

    $expenses = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE post_id = %d",
            $post_id
        )
    );

    return $expenses;
}
add_action('wp_ajax_get_expenses', 'get_expenses_callback');

function get_expenses_callback() {
    check_ajax_referer('get_expenses_nonce', 'nonce');

    $post_id = $_POST['post_id'];

    // Add your logic to fetch expenses based on the $post_id
    $expenses = get_expenses_function($post_id);

    // Generate HTML table
    $html = '<table class="expenses-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

    $totalAmount = 0;

    foreach ($expenses as $expense) {
        $html .= '<tr>
                    <td>' . date('Y-m-d H:i:s', strtotime($expense->expense_date)) . '</td>
                    <td>' . esc_html($expense->expense_description) . '</td>
                    <td>$' . number_format($expense->expense_amount, 2) . '</td>
                    <td><a class="delete-expense" data-expense-id="' . $expense->id . '" data-post-id="' . $post_id . '"><span class="dashicons dashicons-trash"></span></a></td>
                </tr>';

        $totalAmount += $expense->expense_amount;
    }

    // Add the row for displaying the total sum
    $html .= '<tr class="total-row">
                <td colspan="2"><strong>Total:</strong></td>
                <td><strong>$' . number_format($totalAmount, 2) . '</strong></td>
                <td></td>
            </tr>';

    $html .= '</tbody></table>';

    // Return the HTML content
    echo $html;

    wp_die(); // Always include this to terminate the AJAX call
}


function save_expense() {
   
   if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'save_expense_nonce')) {

        $post_id = $_POST['post_id'];
        $expense_description = sanitize_text_field($_POST['expense_description']);
        $expense_amount = floatval($_POST['expense_amount']); // Convert to float for better handling

        // Insert data into the wp_car_expenses table
        global $wpdb;
        $table_name = $wpdb->prefix . 'car_expenses';
       
        $wpdb->insert(
            $table_name,
            array(
                'post_id' => $post_id,
                'expense_description' => $expense_description,
                'expense_amount' => $expense_amount,
            ),
            array('%d', '%s', '%f')
        );

        
        $total_exp = update_expense_acf($post_id);
        
	  
        echo json_encode(array('success' => true, 'message' => 'Expense added successfully','total_exp'=>$total_exp));
        // Send a response (e.g., success message)
        
    } else {
        // Send an error response if nonce verification fails
        wp_send_json_error('Nonce verification failed');
    }
    exit;
}
add_action('wp_ajax_save_expense', 'save_expense');







/*--------------------------------------------------------------------------*/

function get_pol_fn() {
    $args = array(
        'post_type' => 'pol',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);
    $posts = $query->get_posts();

    $formatted_posts = array();
    foreach ($posts as $post) {
        $formatted_posts[] = array(
            'post_id' => $post->ID,
            'title' => get_the_title($post->ID),
        );
    }

    wp_send_json($formatted_posts);
    die();
}
add_action('wp_ajax_get_pol', 'get_pol_fn');





function get_pod_fn() {
    $args = array(
        'post_type' => 'pou',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);
    $posts = $query->get_posts();

    $formatted_posts = array();
    foreach ($posts as $post) {
        $formatted_posts[] = array(
            'post_id' => $post->ID,
            'title' => get_the_title($post->ID),
        );
    }

    wp_send_json($formatted_posts);
    die();
}
add_action('wp_ajax_get_pod', 'get_pod_fn');


function enqueue_pol_post_list_script_admin() {
    // Check if we are on the edit screen of the "commodities" post type
    global $pagenow;
    if ( isset($_GET['post_type']) && $_GET['post_type'] == 'commodities') {
        // Enqueue jQuery
        wp_enqueue_script('jquery');

        // Output the inline script
        ?>
        <script>


			function extractValueFromSerializedString(serializedString) {
			    // Extract the value between double quotes
			    var match = serializedString.match(/"([^"]+)"/);

			    // If a match is found, parse it as an integer
			    if (match && match[1]) {
			        return parseInt(match[1], 10);
			    }

			    // Return null if no match is found
			    return null;
			}



			function getTitleByPostId(postId, dataArray) {
			    const foundItem = dataArray.find(item => item.post_id === postId);

			    if (foundItem) {
			        return foundItem.title;
			    } else {
			        // Return a default value or handle the case where the post_id is not found
			        return 'Title not found';
			    }
			}

            jQuery(document).ready(function ($) {
                function getPol_PostList() {
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        method: 'POST',
                        data: { 'action': 'get_pol' },
                        success: function (response) {
                            console.log(response);
 
                            


							var dropdown = jQuery('#acp-filter-63fbc6219fbe78');
							var json_var = (response);
						
							dropdown.find('option').each(function () {
							    var optionValue = jQuery(this).val();
							   
							    var tt = extractValueFromSerializedString(optionValue);
							   
							    if(tt>0)
							    {
						        
						            var text_v = getTitleByPostId(tt,json_var);
						            console.log(text_v);

						           
						            jQuery(this).text(text_v);
							       
							    }

							});

                        },
                        error: function (error) {
                            console.error('Error fetching "pol" post type:', error);
                        }
                    });
                }


                 function getPod_PostList() {
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        method: 'POST',
                        data: { 'action': 'get_pod' },
                        success: function (response) {
                            console.log(response);

                            


							var dropdown = jQuery('#acp-filter-6415d8da15c290');
							var json_var = (response);
							console.log(json_var);
						
							dropdown.find('option').each(function () {
							    var optionValue = jQuery(this).val();
							   
							    var tt = extractValueFromSerializedString(optionValue);
							   
							    if(tt>0)
							    {
						        
						            var text_v = getTitleByPostId(tt,json_var);
						            console.log(text_v);
						            
						           
						            jQuery(this).text(text_v);
							       
							    }

							});

                        },
                        error: function (error) {
                            console.error('Error fetching "pol" post type:', error);
                        }
                    });
                }

               
                getPol_PostList();
                getPod_PostList();
              
            });
        </script>
        <?php
    }
}

add_action('admin_head', 'enqueue_pol_post_list_script_admin');








function custom_image_filter_dropdown() {
    global $typenow;

    // Check if we are on the admin panel and dealing with the 'car_photos' post type
    if (is_admin() && $typenow == 'car_photos' or 1) {
        $selected = isset($_GET['image_filter']) ? $_GET['image_filter'] : '';
        ?>
        <select name="image_filter">
            <option value="" <?php selected($selected, ''); ?>>Show All</option>
            <option value="with_image" <?php selected($selected, 'with_image'); ?>>With Image</option>
            <option value="without_image" <?php selected($selected, 'without_image'); ?>>Without Image</option>
        </select>
        <?php
    }
}
add_action('restrict_manage_posts', 'custom_image_filter_dropdown',200);

function filter_posts_by_image($query) {
    global $pagenow, $wpdb;

    // Check if we are on the admin panel and dealing with the 'car_photos' post type
    if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'car_photos' or 1)   {

        // Check if the 'image_filter' is set
        if (isset($_GET['image_filter'])) {

            $image_filter = sanitize_text_field($_GET['image_filter']);

            // Modify the query based on the selected filter
            if ($image_filter == 'with_image') {
               


            	global $wpdb;
	            $partner_commodities_ids = $wpdb->get_col($wpdb->prepare(
	                "SELECT post_id FROM tr_car_images WHERE 1"
	            ));
	            $partner_commodities_ids = array_unique($partner_commodities_ids);
	           

	            $query->set('post__in', $partner_commodities_ids);


            } elseif ($image_filter == 'without_image') {
               
                global $wpdb;
	            $partner_commodities_ids = $wpdb->get_col($wpdb->prepare(
	                "SELECT post_id FROM tr_car_images WHERE 1"
	            ));
	            $partner_commodities_ids = array_unique($partner_commodities_ids);
	           

	            $query->set('post__not_in', $partner_commodities_ids);


            }
        }
    }
}

add_action('pre_get_posts', 'filter_posts_by_image');




function delete_commodities_note() {
    $response = array(
        'success' => false,
        'message' => 'Error deleting shipment note.'
    );

    if (isset($_POST['delete_id']) && isset($_POST['post_id']) && isset($_POST['nonce'])) {
        $note_id = sanitize_text_field($_POST['delete_id']);
        $post_id = intval($_POST['post_id']);
        $nonce = $_POST['nonce'];

        // Verify the nonce
        if (wp_verify_nonce($nonce, 'delete_commodities_note') or 1) {

            $notes = get_post_meta($post_id, 'commodities_notes', true);
            #print_r($notes);
            // Check if the note exists
            if (isset($notes[$note_id])) {
                // Remove the note
                unset($notes[$note_id]);

                // Update post meta without the deleted note
                update_post_meta($post_id, 'commodities_notes', $notes);

                $response['success'] = true;
                $response['message'] = 'Commodities note deleted successfully.';
            } else {
                $response['message'] = 'Invalid note ID.';
            }
        } else {
            $response['message'] = 'Invalid nonce.';
        }
    } else {
        $response['message'] = 'Invalid request.';
    }

    // Return the JSON response
    wp_send_json($response);
}

// Register the AJAX action for deleting notes
add_action('wp_ajax_delete_commodities_note', 'delete_commodities_note');
add_action('wp_ajax_nopriv_delete_commodities_note', 'delete_commodities_note');




/*---------------------------------------------------------------------------------*/
function display_existing_images($post_id) {
    global $wpdb;
    $table_name =  'tr_car_images';

    // Get existing images for the current post
    $existing_images = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d and `type` = %d order by id desc", $post_id , "0")
    );

    if ($existing_images) {

		echo '<div id="existing_images">';
        foreach ($existing_images as $image) {
        	?>
            <div class="image_cont">
	            <img src="<?php echo esc_url(site_url().$image->file_path);?>" alt="Thumbnail">
				<button type="button" class="delete_image_button" data-imageid="<?php echo $image->id;?>">
					<span class="dashicons dashicons-trash"></span>
				</button>
        	</div>
        	<?php

        }
        echo '</div>';
    }
}
function return_existing_images($post_id) {
    global $wpdb;
    $table_name =  'tr_car_images';

    // Get existing images for the current post
    $existing_images = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d and `type`= %d   order by id desc", $post_id,"0")
    );

  	return $existing_images;
}



function display_existing_images_loader($post_id) {
    global $wpdb;
    $table_name =  'tr_car_images';

    // Get existing images for the current post
    $existing_images = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d and `type`= %s order by id desc", $post_id, "1")
    );

    if ($existing_images) {

		echo '<div id="existing_images">sss';
        foreach ($existing_images as $image) {
        	?>
            <div class="image_cont">
	            <img src="<?php echo esc_url(site_url().$image->file_path);?>" alt="Thumbnail">
				<button type="button" class="delete_image_button" data-imageid="<?php echo $image->id;?>">
					<span class="dashicons dashicons-trash"></span>
				</button>
        	</div>
        	<?php

        }
        echo '</div>';
    }
}
function return_existing_images2($post_id) {
    global $wpdb;
    $table_name =  'tr_car_images';

    // Get existing images for the current post
    $existing_images = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d and `type`= %d  order by id desc", $post_id,"1")
    );

  	return $existing_images;
}


function fetch_commodity() {
    $tag_number = $_POST['tag_number'];

    // Perform a query to get the commodity with the specified tag_number
    $commodity_query = new WP_Query(array(
        'post_type' => 'commodities',
        'meta_key' => 'tag_number',
        'meta_value' => $tag_number
    ));

    // Display the commodity information
    if ($commodity_query->have_posts()) {
        while ($commodity_query->have_posts()) {
            $commodity_query->the_post();
            echo '<h3>' . get_the_title() . '</h3>';
            echo '<p>' . get_the_content() . '</p>';
            echo '<form id="upload-image-form" enctype="multipart/form-data" style="padding: 10px; border: 1px dotted #ccc; border-radius: 5px; "> 

           	 		<input type="file" id="image" name="image" accept="image/*" > 
           	 		<button type="button" id="upload_btn"> Upload </button>
           	 	 </form>'; 
            ?>
            <div id="progress_bar"></div>

			<div id="upload_content" style="margin-top:10px">
				
				<?php  display_existing_images(get_the_ID()); ?>
			</div>
			
            <?php 
            echo '<input type="hidden" id="post_id" value="'.get_the_ID().'">';
           
        }
    } else {
        echo 'Commodity not found.';
    }

    wp_die(); // Always include this at the end to terminate the script properly
}

add_action('wp_ajax_fetch_commodity', 'fetch_commodity');
add_action('wp_ajax_nopriv_fetch_commodity', 'fetch_commodity');




function upload_image() {
    
    $post_id = absint($_POST['post_id']);

    // Get the uploaded file
    $uploaded_file = $_FILES['image'];

    // Validate file type (only allow PNG, JPG, and GIF)
    $allowed_types = array('image/png', 'image/jpeg', 'image/gif');
    if (!in_array($uploaded_file['type'], $allowed_types)) {
        echo 'Invalid file type. Please upload a PNG, JPG, or GIF image.';
        wp_die();
    }

    // Construct the target directory path
    $main_path = '/home/1163638.cloudwaysapps.com/uerxjzjsrf/public_html';
    $target_directory = '/wp-content/uploads/car_images/' . $post_id;

    // Create the target directory if it doesn't exist
    if (!file_exists($main_path . $target_directory)) {
        mkdir($main_path . $target_directory, 0755, true);
    }

    // Generate a random number and append it to the file name
    $random_number = rand(1000, 9999);
    $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
    $randomized_file_name = $random_number . '_' . basename($uploaded_file['name'], '.' . $file_extension) . '_' . time() . '.' . $file_extension;

    // Construct the destination path for the uploaded file
    $destination_path = $target_directory . '/' . $randomized_file_name;

    // Move the uploaded file to the target directory
    $moved = move_uploaded_file($uploaded_file['tmp_name'], $main_path . $destination_path);

    if ($moved) {
        // Resize and compress the image
        resize_and_compress_image($main_path . $destination_path);

        // Update the database with the new path
        global $wpdb;
        $table_name = 'tr_car_images';

        $wpdb->insert($table_name, array(
            'post_id' => $post_id,
            'file_path' => $target_directory . '/' . $randomized_file_name
        ));

        // Display existing images after successful upload
        display_existing_images($post_id);
    } else {
        echo 'Failed to move the uploaded image to the target directory.';
    }

    wp_die();
}

add_action('wp_ajax_upload_image', 'upload_image');
add_action('wp_ajax_nopriv_upload_image', 'upload_image');

/*-------------------------------------------------------------------------------*/

add_action('rest_api_init', function () {
    register_rest_route('myplugin/v1', '/upload-image/', array(
        'methods' => 'POST',
        'callback' => 'handle_image_upload',
        'permission_callback' => function() {
            return current_user_can('upload_files');
        }
    ));
});
add_action('rest_api_init', function () {
    register_rest_route('myplugin/v1', '/get-images/', array(
        'methods' => 'GET',
        'callback' => 'get_images_by_post_id',
        'permission_callback' => '__return_true' // Adjust the permission callback as needed
    ));
});
add_action('rest_api_init', function () {
    register_rest_route('myplugin/v1', '/fetch-commodity/', array(
        'methods' => 'POST',
        'callback' => 'fetch_commodity_api',
        'permission_callback' => '__return_true' // Adjust the permission callback as needed
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/update-poa/', array(
        'methods' => 'POST',
        'callback' => 'update_user_poa',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('custom/v1', '/update_document/', array(
	    'methods' => 'POST',
	    'callback' => 'update_user_document',
	    'args' => [
	        'user_id' => [
	            'required' => true,
	            'validate_callback' => function($param, $request, $key) {
	                return is_numeric($param);
	            }
	        ],
	        'type' => [
	            'required' => true,
	            'validate_callback' => function($param, $request, $key) {
	                return in_array($param, ['poa', 'passport', 'license']);
	            }
	        ]
	    ],
	    'permission_callback' => '__return_true'
	));

});


add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/update_commodities', array(
        'methods' => 'POST',
        'callback' => 'update_commodities_with_files',
        'permission_callback' => '__return_true',
        'args' => array(
            'post_id' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
    ));
});


// function update_commodities_with_files(WP_REST_Request $request) {
//     $post_id = $request['post_id'];
//     $files = $request->get_file_params();

//     // Check if files are set
//     if (isset($files['poa_file']) && isset($files['title_file'])) {
//         // Handle file upload
//         require_once(ABSPATH . 'wp-admin/includes/file.php');
//         $poa_file = wp_handle_upload($files['poa_file'], array('test_form' => false));
//         $title_file = wp_handle_upload($files['title_file'], array('test_form' => false));

//         if ($poa_file && !isset($poa_file['error']) && $title_file && !isset($title_file['error'])) {
//             // Assuming 'commodities' is a custom table or custom post meta
//             // Update the database entry for this post_id with the file paths
//             // Example for custom post meta:
//             update_post_meta($post_id, 'poa_file', $poa_file['url']);
//             update_post_meta($post_id, 'title_file', $title_file['url']);

//             return new WP_REST_Response(array('status' => 'success', 'message' => 'Files uploaded successfully.'), 200);
//         } else {
//             // Handle errors
//             $errors = array();
//             if (isset($poa_file['error'])) $errors['poa_file'] = $poa_file['error'];
//             if (isset($title_file['error'])) $errors['title_file'] = $title_file['error'];
//             return new WP_REST_Response(array('status' => 'error', 'errors' => $errors), 400);
//         }
//     } else {
//         return new WP_REST_Response(array('status' => 'error', 'message' => 'Missing files.'), 400);
//     }
// }



function update_commodities_with_files(WP_REST_Request $request) {
    $post_id = $request['post_id'];
    $files = $request->get_file_params();

    // Check if exactly one file is set
    if ((isset($files['poa_file']) ||  isset($files['title_file'])) ) {
        // Determine which file is being uploaded
        $file_key = isset($files['poa_file']) ? 'poa_file' : 'title_file';
        print_r($files[$file_key]);

        $file = wp_handle_upload($files[$file_key], array('test_form' => false));

        if ($file && !isset($file['error'])) {
            // Assuming 'commodities' is a custom table or custom post meta
            // Update the database entry for this post_id with the file path
            // Example for custom post meta:
            update_post_meta($post_id, $file_key, $file['url']);

            //return new WP_REST_Response(array('status' => 'success', 'message' => ucfirst($file_key) . ' uploaded successfully.'), 200);
        } else {
            // Handle file upload error
            return new WP_REST_Response(array('status' => 'error', 'message' => $file['error']), 400);
        }
    } else {
        return new WP_REST_Response(array('status' => 'error', 'message' => 'Please upload exactly one file.'), 400);
    }
    return new WP_REST_Response(array('status' => 'success', 'message' =>  ' uploaded successfully.'), 200);
}












add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/get_user_image/', array(
        'methods' => 'POST',
        'callback' => 'get_user_image_url',
        'args' => array(
            'user_id' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
            'field' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                }
            )
        ),
        'permission_callback' => '__return_true'
    ));



    register_rest_route('custom/v1', '/update-expiration-dates/', [
        'methods' => 'POST',
        'callback' => 'update_expiration_dates',
        'permission_callback' => '__return_true',
        'args' => [
            'user_id' => [
                'required' => true,
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ],
            'license_expire' => [
                'required' => false,
                'validate_callback' => function ($param, $request, $key) {
                    return strtotime($param) !== false;
                }
            ],
            'poa_expire' => [
                'required' => false,
                'validate_callback' => function ($param, $request, $key) {
                    return strtotime($param) !== false;
                }
            ],
            'passport_expire_date' => [
                'required' => false,
                'validate_callback' => function ($param, $request, $key) {
                    return strtotime($param) !== false;
                }
            ],
        ],
    ]);

});


function update_expiration_dates(WP_REST_Request $request) {
    $user_id = $request->get_param('user_id');
    $license_expire = $request->get_param('license_expire');
    $poa_expire = $request->get_param('poa_expire');
    $passport_expire_date = $request->get_param('passport_expire_date');

    if (!empty($license_expire)) {
        update_field('license_expire', $license_expire, 'user_' . $user_id);
    }
    if (!empty($poa_expire)) {
        update_field('poa_expire', $poa_expire, 'user_' . $user_id);
    }
    if (!empty($passport_expire_date)) {
        update_field('passport_expire_date', $passport_expire_date, 'user_' . $user_id);
    }

    return new WP_REST_Response(['message' => 'Expiration dates updated successfully'], 200);
}


function update_user_document($request) {
    $user_id = $request['user_id'];
    $type = $request['type'];
    $files = $request->get_file_params();


    // Determine the correct meta key based on the document type
    $meta_key = '';
    switch ($type) {
        case 'poa':
            $meta_key = 'poa';
            break;
        case 'passport':
            $meta_key = 'passport_upload';
            break;
        case 'license':
            $meta_key = 'license_copy';
            break;
        default:
            return new WP_Error('invalid_type', 'Invalid document type.', array('status' => 400));
    }

    if (empty($files[$type])) {
        return new WP_Error('missing_file', 'No file uploaded.', array('status' => 400));
    }

    // Proceed with file handling
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    // Use media_handle_upload to handle file upload and attachment creation
    $_FILES = array($type => $files[$type]); // Ensure the $_FILES array is structured correctly
    $attachment_id = media_handle_upload($type, 0); // 0 indicates no parent post

    if (is_wp_error($attachment_id)) {
        return $attachment_id; // Return the error if upload fails
    }

    // Update the meta field with the new attachment ID
    update_user_meta($user_id, $meta_key, $attachment_id);

    return new WP_REST_Response(['message' => ucfirst($type) . ' updated successfully', 'attachment_id' => $attachment_id], 200);
}



function get_user_image_url($request) {
    $user_id = $request['user_id'];
    $field = $request['field'];

    // Retrieve the attachment ID from the user meta
    $attachment_id2 = get_user_meta($user_id, 'poa', true);
    $attachment_id22 = get_user_meta($user_id, 'poa_approved', true);
    
    $attachment_id3 = get_user_meta($user_id, 'passport_upload', true);
    $attachment_id33 = get_user_meta($user_id, 'passport_upload_approved', true);

    $attachment_id4 = get_user_meta($user_id, 'license_copy', true);
    $attachment_id44 = get_user_meta($user_id, 'license_copy_approved', true);


    $poa_image='';
    $poa_image_approved='';


    $passport_copy='';
    $passport_copy_approved='';
    
    if($attachment_id2)
    {
    	$poa_image = wp_get_attachment_image_url($attachment_id2, 'full');
    }

    if($attachment_id22)
    {
    	$poa_image_approved = wp_get_attachment_image_url($attachment_id22, 'full');
    }



    if($attachment_id3)
    {
    	$passport_copy = wp_get_attachment_image_url($attachment_id3, 'full');
    }

    if($attachment_id33)
    {
    	$passport_copy_approved = wp_get_attachment_image_url($attachment_id33, 'full');
    }


    if($attachment_id4)
    {
    	$license_copy = wp_get_attachment_image_url($attachment_id4, 'full');
    }

    if($attachment_id44)
    {
    	$license_copy_approved = wp_get_attachment_image_url($attachment_id44, 'full');
    }


    $data = array('poa_image' => $poa_image,'poa_image_approved'=>$poa_image_approved, 'passport_copy' => $passport_copy,'passport_copy_approved'=>$passport_copy_approved
		, 'license_copy' => $license_copy,'license_copy_approved'=>$license_copy_approved
	);
    // Return the image URL
    return new WP_REST_Response( $data , 200);
}




function update_user_poa($request) {
    $user_id = $request['user_id'];
    $files = $request->get_file_params();

    // Check if user_id and file are provided
    if (!$user_id || empty($files['poa'])) {
        return new WP_Error('missing_params', 'Missing parameters', array('status' => 400));
    }

    // Ensure the user exists
    if (!get_userdata($user_id)) {
        return new WP_Error('invalid_user', 'Invalid user ID', array('status' => 404));
    }

    // Handle the image upload
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    // Fake a $_FILES structure
    $_FILES = array('poa' => $files['poa']);

    // Use media_handle_upload to handle file upload and attachment creation
    $attachment_id = media_handle_upload('poa', 0);

    if (is_wp_error($attachment_id)) {
        return $attachment_id; // Return the error
    }

    // Update the ACF field for the user
    // Replace 'your_acf_poa_field_key' with the actual field key
    update_field('poa', $attachment_id, 'user_' . $user_id);

    return new WP_REST_Response(['message' => 'POA updated successfully', 'attachment_id' => $attachment_id], 200);
}



function handle_image_upload(WP_REST_Request $request) 
{
   
    $post_id  		= absint($request['post_id']);
   
    $uploaded_file 	= $request->get_file_params()['image'];


    $allowed_types = array('image/png', 'image/jpeg', 'image/gif');

    if (!in_array($uploaded_file['type'], $allowed_types)) {
        
        return new WP_Error('upload_failed', 'Invalid file type. Please upload a PNG, JPG, or GIF image.', ['status' => 500]);
        wp_die();
    }

   
    $main_path = '/home/1163638.cloudwaysapps.com/uerxjzjsrf/public_html';

    $target_directory = '/wp-content/uploads/car_images/' . $post_id;

    if (!file_exists($main_path . $target_directory)) {
        mkdir($main_path . $target_directory, 0755, true);
    }

    $random_number = rand(1000, 9999);
    
    $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
    
    $randomized_file_name = $random_number . '_' . basename($uploaded_file['name'], '.' . $file_extension) . '_' . time() . '.' . $file_extension;

    $destination_path = $target_directory . '/' . $randomized_file_name;

    $moved = move_uploaded_file($uploaded_file['tmp_name'], $main_path . $destination_path);

    if ($moved) {

        resize_and_compress_image($main_path . $destination_path);

        global $wpdb;
    
        $table_name = 'tr_car_images';

        $wpdb->insert($table_name, array(
            'post_id' => $post_id,
            'file_path' => $target_directory . '/' . $randomized_file_name
        ));

        return new WP_REST_Response(['message' => 'Image uploaded successfully'], 200);


    } 
    else 
    {
        return new WP_Error('upload_failed', 'Failed to move the uploaded image', ['status' => 500]);
    }

}






add_action('rest_api_init', function () {
    register_rest_route('myplugin/v1', '/upload_images', array(
        'methods' => 'POST',
        'callback' => 'handle_multiple_image_upload',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));

    register_rest_route('myplugin/v1', '/update_car_info', array(
        'methods' => 'POST',
        'callback' => 'update_car_info',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));

    register_rest_route('myplugin/v1', '/add_car_info', array(
        'methods' => 'POST',
        'callback' => 'add_car_info',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
});




function update_car_info( $request ) {
    global $wpdb;
    $parameters = $request->get_json_params();
    $tagNumber = isset($parameters['tagNumber']) ? sanitize_text_field($parameters['tagNumber']) : '';
    $color = isset($parameters['color']) ? sanitize_text_field($parameters['color']) : '';
    $key_location = isset($parameters['keyLocation']) ? sanitize_text_field($parameters['keyLocation']) : '';

    if(empty($tagNumber)) {
        return new WP_REST_Response(array('error'=>'1','msg'=>'Tag Number is empty'), 400);
    }

    // Check if tagNumber starts with 'P_'
    if(strpos($tagNumber, 'P_') === 0) {
        // Use the numeric part as post_id
        $post_id = substr($tagNumber, 2);
    } else {
        // Check if the tag number exists in the database
        $query = $wpdb->prepare("SELECT post_id FROM tr_commodities WHERE tag_number = %s", $tagNumber);
        $post_id = $wpdb->get_var($query);

        if(empty($post_id)) {
            return new WP_REST_Response(array('error'=>'1','msg'=>'Post ID Not Found'), 400);
        }
    }

    // Update the database
    $result = $wpdb->update('tr_commodities', 
        array('color' => $color, 'key_location' => $key_location), // Data to update
        array('post_id' => $post_id) // Where condition
    );

    if($result === false) {
        return new WP_REST_Response(array('error'=>'1','msg'=>'Failed to update'), 500);
    }

    return new WP_REST_Response(array('success'=>'1','msg'=>'Car details updated successfully'), 200);
}













function add_car_info( $request ) {
    global $wpdb;
    $parameters = $request->get_json_params();


    $id  	 			= isset($parameters['id']) ? intval($parameters['id']) : null;
    $post_id 			= isset($parameters['post_id']) ? intval($parameters['post_id']) : null;
    $type2   			= isset($parameters['type2']) ? sanitize_text_field($parameters['type2']) : '';
    $vin  	 			= isset($parameters['vin']) ? sanitize_text_field($parameters['vin']) : '';
    $setup_for_export 	= isset($parameters['setup_for_export_']) ? intval($parameters['setup_for_export_']) : 0;
    $ready_to_export 	= isset($parameters['ready_to_export']) ? intval($parameters['ready_to_export']) : 0;
    $package 			= isset($parameters['package']) ? sanitize_text_field($parameters['package']) : '';
    $description 		= isset($parameters['description']) ? sanitize_text_field($parameters['description']) : '';
    $status 			= isset($parameters['status']) ? sanitize_text_field($parameters['status']) : '';
    $make 				= isset($parameters['make']) ? sanitize_text_field($parameters['make']) : '';
    $model 				= isset($parameters['model']) ? sanitize_text_field($parameters['model']) : '';
    $year 				= isset($parameters['year']) ? intval($parameters['year']) : null;
    $weight 			= isset($parameters['weight']) ? floatval($parameters['weight']) : null;
    $value 				= isset($parameters['value']) ? floatval($parameters['value']) : null;
    // Continuing the extraction and sanitization of fields
	$eei_schedual_b_code = isset($parameters['eei_schedual_b_code']) ? sanitize_text_field($parameters['eei_schedual_b_code']) : '';
	$eei_schedule_b_description = isset($parameters['eei_schedule_b_description_']) ? sanitize_text_field($parameters['eei_schedule_b_description_']) : '';
	$eei_quantityone = isset($parameters['eei_quantityone']) ? intval($parameters['eei_quantityone']) : 0;
	$eei_quantity_1_unit = isset($parameters['eei_quantity_1_unit']) ? sanitize_text_field($parameters['eei_quantity_1_unit']) : '';
	$eei_quantitytwo = isset($parameters['eei_quantitytwo']) ? intval($parameters['eei_quantitytwo']) : 0;
	$eei_quantity_2_unit = isset($parameters['eei_quantity_2_unit']) ? sanitize_text_field($parameters['eei_quantity_2_unit']) : '';
	$eei_licencetype = isset($parameters['eei_licencetype']) ? sanitize_text_field($parameters['eei_licencetype']) : '';
	$eei_license_number = isset($parameters['eei_license_number']) ? sanitize_text_field($parameters['eei_license_number']) : '';
	$eei_license_value = isset($parameters['eei_license_value_']) ? floatval($parameters['eei_license_value_']) : 0;
	$eei_export_code = isset($parameters['eei_export_code:']) ? sanitize_text_field($parameters['eei_export_code:']) : '';
	$eei_eccn = isset($parameters['eei_eccn']) ? sanitize_text_field($parameters['eei_eccn']) : '';
	$eei_origin = isset($parameters['eei_origin']) ? sanitize_text_field($parameters['eei_origin']) : '';
	$eei_state_of_origin = isset($parameters['eei_state_of_origin']) ? sanitize_text_field($parameters['eei_state_of_origin']) : '';
	$eei_filing_option = isset($parameters['eei_filing_option']) ? intval($parameters['eei_filing_option']) : null;
	$eei_mode_of_transportation = isset($parameters['eei_mode_of_transportation']) ? sanitize_text_field($parameters['eei_mode_of_transportation']) : '';
	$eei_hazmat = isset($parameters['eei_hazmat']) ? intval($parameters['eei_hazmat']) : 0;
	$eei_is_this_a_routed_transaction = isset($parameters['eei_is_this_a_routed_transaction']) ? intval($parameters['eei_is_this_a_routed_transaction']) : 0;
	$eei_are_usppi_and_ultimate_consignee_related = isset($parameters['eei_are_usppi_and_ultimate_consignee_related']) ? intval($parameters['eei_are_usppi_and_ultimate_consignee_related']) : 0;
	$pol = isset($parameters['pol']) ? sanitize_text_field($parameters['pol']) : ''; // Assuming pol is a string
	$pod = isset($parameters['pod']) ? sanitize_text_field($parameters['pod']) : ''; // Assuming pod is a string

	$color  	  = isset($parameters['color'])?sanitize_text_field($parameters['color']):''; 
	$key_location = isset($parameters['key_location']) ? sanitize_text_field($parameters['key_location']):''; 

	$title_number = isset($parameters['title_number']) ? sanitize_text_field($parameters['title_number']) : '';

	$post_result = $wpdb->insert('tr_posts', array(
		"post_title"=>($make." ".$model." ".$year),
        'post_type' => 'commodities', 'post_status' => 'publish', 
    ));

    if (!$post_result) {
        return new WP_REST_Response(array('success' => '0', 'msg' => 'Failed to add post'), 500);
    }
    $post_id = $wpdb->insert_id;
    

    update_field('type2','Vehicle', $post_id);
  	update_field('package','vehicle', $post_id);
	update_field('vin', $vin, $post_id);
	update_field('product_status', 'added by photo maker', $post_id);
	update_field('description', $description, $post_id);
	update_field('status', 'Received @ Warehouse', $post_id);
	update_field('make', $make, $post_id);
	update_field('model', $model, $post_id);
	update_field('year', $year, $post_id);
	update_field('weight_', $weight, $post_id);
	update_field('color', $color, $post_id);
	update_field('key_location', $key_location, $post_id);


    $data = array(
	    'post_id' => $post_id,
	    'type2' => "Vehicle",
	    'package' => "vehicle",
	    'vin' => $vin,
	    'product_status'=>'added by photo maker',
	    'description' => $description,
	    'status' => "Received @ Warehouse",
	    'make' => $make,
	    'model' => $model,
	    'year' => $year,
	    'weight_' => isset($weight)?$weight:'',
	    'color'=>$color?$color:'',
	    'key_location'=>isset($key_location)?$key_location:'',
	    

	    //'setup_for_export_' => $setup_for_export,
	    //'ready_to_export' => $ready_to_export,
	    //'package' => $package,
	    

	    //'value' => $value,
	    // 'eei_schedual_b_code' => isset($parameters['eei_schedual_b_code']) ? sanitize_text_field($parameters['eei_schedual_b_code']) : '',
	    // 'eei_schedule_b_description_' => isset($parameters['eei_schedule_b_description_']) ? sanitize_text_field($parameters['eei_schedule_b_description_']) : '',
	    // 'eei_quantityone' => isset($parameters['eei_quantityone']) ? intval($parameters['eei_quantityone']) : null,
	    // 'eei_quantity_1_unit' => isset($parameters['eei_quantity_1_unit']) ? sanitize_text_field($parameters['eei_quantity_1_unit']) : '',
	    // 'eei_quantitytwo' => isset($parameters['eei_quantitytwo']) ? intval($parameters['eei_quantitytwo']) : null,
	    // 'eei_quantity_2_unit' => isset($parameters['eei_quantity_2_unit']) ? sanitize_text_field($parameters['eei_quantity_2_unit']) : '',
	    // 'eei_licencetype' => isset($parameters['eei_licencetype']) ? sanitize_text_field($parameters['eei_licencetype']) : '',
	    // 'eei_license_number' => isset($parameters['eei_license_number']) ? sanitize_text_field($parameters['eei_license_number']) : '',
	    // 'eei_license_value_' => isset($parameters['eei_license_value_']) ? floatval($parameters['eei_license_value_']) : null,
	    // 'eei_export_code:' => isset($parameters['eei_export_code:']) ? sanitize_text_field($parameters['eei_export_code:']) : '',
	    // 'eei_eccn' => isset($parameters['eei_eccn']) ? sanitize_text_field($parameters['eei_eccn']) : '',
	    // 'eei_origin' => isset($parameters['eei_origin']) ? sanitize_text_field($parameters['eei_origin']) : '',
	    // 'eei_state_of_origin' => isset($parameters['eei_state_of_origin']) ? sanitize_text_field($parameters['eei_state_of_origin']) : '',
	    // 'eei_filing_option' => isset($parameters['eei_filing_option']) ? intval($parameters['eei_filing_option']) : null,
	    // 'eei_mode_of_transportation' => isset($parameters['eei_mode_of_transportation']) ? sanitize_text_field($parameters['eei_mode_of_transportation']) : '',
	    // 'eei_hazmat' => isset($parameters['eei_hazmat']) ? intval($parameters['eei_hazmat']) : null,
	    // 'eei_is_this_a_routed_transaction' => isset($parameters['eei_is_this_a_routed_transaction']) ? intval($parameters['eei_is_this_a_routed_transaction']) : null,
	    // 'eei_are_usppi_and_ultimate_consignee_related' => isset($parameters['eei_are_usppi_and_ultimate_consignee_related']) ? intval($parameters['eei_are_usppi_and_ultimate_consignee_related']) : null,
	    // 'pol' => isset($parameters['pol']) ? $parameters['pol'] : array(), // Assuming it's an array
	    // 'pod' => isset($parameters['pod']) ? $parameters['pod'] : array(), // Assuming it's an array
	    // 'title_number' => isset($parameters['title_number']) ? sanitize_text_field($parameters['title_number']) : '',
	  
	);

#	print_r($data);

    $result = $wpdb->insert('tr_commodities', $data);
//    if ($result === false) {
//     // Insert failed, output the error
//     echo "Error: " . $wpdb->last_error;
// } else {
//     // Insert was successful
//     echo "Success, inserted row ID: " . $wpdb->insert_id;
// }
//    exit;

    if ($result) {
        return new WP_REST_Response(array('success'=>'1','msg'=>'Car details added successfully','post_id'=>$post_id), 200);
    } else {
        return new WP_REST_Response(array('success'=>'0','msg'=>'Failed to add car details','post_id'=>"0"), 200);
    }
}


function handle_multiple_image_upload(WP_REST_Request $request) {
    $tagNumber = ($request['tagNumber']);

	global $wpdb;
    if(empty($tagNumber)) {
    	return new WP_REST_Response(array('error'=>'1','msg'=>'Tag ID Empty'), 400);
    }

    if(strpos($tagNumber, 'P_') === 0) {
        // If tagNumber starts with P_, use the numeric part as post_id
        $post_id = substr($tagNumber, 2);
    } else {
        // If tagNumber does not start with P_, find post_id using tag_number
        $query = $wpdb->get_results($wpdb->prepare(
            "SELECT post_id FROM tr_commodities WHERE tag_number LIKE %s",
            '%' . $wpdb->esc_like($tagNumber) . '%'
        ), ARRAY_A);
	
        $post_id = @$query[0]['post_id'];
        if(empty($post_id)) {
            return new WP_REST_Response(array('error'=>'1','msg'=>'Post ID Not Found'), 400);	
        }
    }

    /* ok now i wanted from you please add playload to upload make, model, year, vin only */
  
    
	if($post_id=="")
	{
		return new WP_REST_Response(array('error'=>'1','msg'=>'Post ID Not Found'), 400);exit;	
	}


    $uploaded_files = $request->get_file_params()['images'];

    $allowed_types = array('image/png', 'image/jpeg', 'image/gif');
    $upload_results = array();

    // Iterate over each file
    foreach ($uploaded_files['name'] as $index => $name) {
        $file_type = $uploaded_files['type'][$index];
        $tmp_name = $uploaded_files['tmp_name'][$index];
        $error = $uploaded_files['error'][$index];
        $size = $uploaded_files['size'][$index];

        // Check file type
        if (!in_array($file_type, $allowed_types)) {
            $upload_results[] = array(
                'name' => $name,
                'result' => new WP_Error('upload_failed', 'Invalid file type: ' . $name, ['status' => 400])
            );
            continue;
        }

        // Set up file path
        $main_path = '/home/1163638.cloudwaysapps.com/uerxjzjsrf/public_html';
        $target_directory = '/wp-content/uploads/car_images/' . $post_id;

        // Create directory if it doesn't exist
        if (!file_exists($main_path . $target_directory)) {
            mkdir($main_path . $target_directory, 0755, true);
        }

        // Create a unique file name
        $random_number = rand(1000, 9999);
        $file_extension = pathinfo($name, PATHINFO_EXTENSION);
        $randomized_file_name = $random_number . '_' . basename($name, '.' . $file_extension) . '_' . time() . '.' . $file_extension;
        $destination_path = $target_directory . '/' . $randomized_file_name;

        // Move the uploaded file
        $moved = move_uploaded_file($tmp_name, $main_path . $destination_path);

        if ($moved) {
            // Optional: resize and compress image
            resize_and_compress_image($main_path . $destination_path);

            // Insert into database (if needed)
            global $wpdb;
            $table_name = 'tr_car_images';

            $wpdb->insert($table_name, array(
                'post_id' => $post_id,
                'file_path' => $target_directory . '/' . $randomized_file_name
            ));

            $upload_results[] = array(
                'name' => $name,
                'result' => 'Image uploaded successfully'
            );

        } else {
            $upload_results[] = array(
                'name' => $name,
                'result' => new WP_Error('upload_failed', 'Failed to move the uploaded image: ' . $name, ['status' => 500])
            );
        }
    }

    return new WP_REST_Response($upload_results, 200);
}




/*-------------------------------------------------------------------------------*/

function get_images_by_post_id() {
    // Ensure 'post_id' is passed as a GET parameter
    if (!isset($_GET['post_id'])) {
        return new WP_Error('no_post_id', 'Missing post ID', array('status' => 400));
    }

    $post_id = intval($_GET['post_id']);

    // Query your database or post meta to get image URLs
    global $wpdb;
    $table_name =  'tr_car_images'; // Adjust the table name if different

    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT file_path FROM $table_name WHERE post_id = %d", 
        $post_id
    ));

    // Format the result to return only URLs
    $image_urls = array_map(function ($item) {
        // Adjust the URL format based on your server structure
        return home_url() . $item->file_path;
    }, $results);

    return new WP_REST_Response($image_urls, 200);
}



function fetch_commodity_api2(WP_REST_Request $request) {
  
    $tag_number = $request->get_param('tag_number');
 
    $commodity_query = new WP_Query(array(
        'post_type' => 'commodities',
        'meta_key' => 'tag_number',
        'meta_value' => $tag_number
    ));

    $commodities = [];

    if ($commodity_query->have_posts()) {
        while ($commodity_query->have_posts()) {
            $commodity_query->the_post();

            $commodity = [
                'title' => get_the_title(),
                'content' => '',
                'images' => return_existing_images(get_the_ID(), false), 
                'post_id' => get_the_ID()
            ];

            $commodities[] = $commodity;
        }
        return new WP_REST_Response($commodities, 200);
    } 
    else 
    {
        return new WP_REST_Response(['message' => 'Commodity not found.'], 404);
    }
}




function fetch_commodity_api(WP_REST_Request $request) {
    $tag_number = $request->get_param('tag_number');

    // Check if tag_number starts with 'P_'
    if (substr($tag_number, 0, 2) === 'P_') {
        // Extract the post ID from the tag_number
        $post_id = substr($tag_number, 2);

        // Fetch commodity by post ID
        $commodity_query = new WP_Query(array(
            'post_type' => 'commodities',
            'p' => $post_id // 'p' parameter for post ID
        ));
    } else {
        // Fetch commodity by tag number
        $commodity_query = new WP_Query(array(
            'post_type' => 'commodities',
            'meta_key' => 'tag_number',
            'meta_value' => $tag_number
        ));
    }

    $commodities = [];

    if ($commodity_query->have_posts()) {
        while ($commodity_query->have_posts()) {
            $commodity_query->the_post();

            $commodity = [
                'title' => get_the_title(),
                'content' => '',
                'images' => return_existing_images(get_the_ID(), false), 
                'post_id' => get_the_ID()
            ];

            $commodities[] = $commodity;
        }
        return new WP_REST_Response($commodities, 200);
    } else {
        return new WP_REST_Response(['message' => 'Commodity not found.'], 404);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('myplugin/v1', '/delete_commodity_image/', array(
        'methods' => 'POST',
        'callback' => 'delete_commodity_image',
        // Include permission_callback for security, e.g., only allowing admins to delete images
        'permission_callback' => function () {
            return current_user_can('manage_options');
        }
    ));

    register_rest_route('myplugin/v1', '/fetch_cars', array(
        'methods' => 'GET',
        'callback' => 'fetch_cars',
    ));
});


function fetch_cars($request) {
    global $wpdb;

    $keyword = $request->get_param('keyword');
    $page = $request->get_param('page');
    $per_page = 10; // Define how many items per page
    $offset = ($page - 1) * $per_page;

    $sql = "SELECT p.*, c.vin, c.tag_number, c.make, c.model, c.year
            FROM {$wpdb->prefix}posts p
            INNER JOIN {$wpdb->prefix}commodities c ON p.ID = c.post_id
            WHERE c.make<>'' and c.model<>'' and c.year<>''";

    if (!empty($keyword)) {
        $keyword = '%' . $wpdb->esc_like($keyword) . '%';
        $sql .= $wpdb->prepare(" AND ( c.tag_number LIKE %s or c.vin LIKE %s )", $keyword, $keyword);
    }

    $sql .= " LIMIT %d OFFSET %d ";
    $prepared_sql = $wpdb->prepare($sql, $per_page, $offset);
  
    $results = $wpdb->get_results($prepared_sql);

    if (count($results) > 0) {
        return new WP_REST_Response($results, 200);
    } else {
        return new WP_REST_Response(['message' => 'Commodity not found.'], 404);
    }
}

// function delete_commodity_image() 
// {
    
    
//     $image_id = isset($_POST['image_id']) ? absint($_POST['image_id']) : 0;
//     $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;

//     if (!$image_id || !$post_id) {
//         return new WP_Error('missing_parameters', 'Missing required parameters', array('status' => 400));
//     }

//     global $wpdb;
//     $table_name = 'tr_car_images';
//     $main_path = '/home/1163638.cloudwaysapps.com/uerxjzjsrf/public_html';

//     // Get the file path of the image
//     $image_path = $wpdb->get_var($wpdb->prepare("SELECT file_path FROM $table_name WHERE id = %d", $image_id));

//     // Delete the image file
//     if (file_exists($main_path . $image_path)) {
//         unlink($main_path . $image_path);
//     }

//     // Delete the record from the database
//     $wpdb->delete($table_name, array('id' => $image_id));

//     // Return a success response
//     return rest_ensure_response(array(
//         'success' => true,
//         'message' => 'Image deleted successfully'
//     ));


// }
//


function delete_commodity_image() {
    
    // Get the array of image IDs
    $image_ids = isset($_POST['image_ids']) ? $_POST['image_ids'] : array();
    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;

    if (empty($image_ids) || !$post_id) {
        return new WP_Error('missing_parameters', 'Missing required parameters', array('status' => 400));
    }

    global $wpdb;
    $table_name = 'tr_car_images';
    $main_path = '/home/1163638.cloudwaysapps.com/uerxjzjsrf/public_html';
    $image_ids = explode(",",$image_ids);
    foreach ($image_ids as $image_id) {
        $image_id = absint($image_id);

        // Get the file path of the image
        $image_path = $wpdb->get_var($wpdb->prepare("SELECT file_path FROM $table_name WHERE id = %d", $image_id));

        // Delete the image file
        if (file_exists($main_path . $image_path)) {
            unlink($main_path . $image_path);
        }

        // Delete the record from the database
        $wpdb->delete($table_name, array('id' => $image_id));
    }

    // Return a success response
    return rest_ensure_response(array(
        'success' => true,
        'message' => 'Images deleted successfully'
    ));
}









function resize_and_compress_image($image_path) {
    // Get the image size
    list($width, $height) = getimagesize($image_path);

    // Set the maximum width and height
    $max_width = 1000;
    $max_height = 1000;

    // Calculate the new dimensions while maintaining the aspect ratio
    $new_width = min($width, $max_width);
    $new_height = intval($height * ($new_width / $width));

    // Create a new image resource from the original image
    $image = imagecreatefromjpeg($image_path);

    // Create a new true-color image with the new dimensions
    $resized_image = imagecreatetruecolor($new_width, $new_height);

    // Preserve transparency for PNG and GIF images
    imagealphablending($resized_image, false);
    imagesavealpha($resized_image, true);

    // Resize the image
    imagecopyresampled($resized_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Compress and save the resized image
    imagejpeg($resized_image, $image_path, 80); // 80 is the quality level (adjust as needed)

    // Free up memory
    imagedestroy($image);
    imagedestroy($resized_image);
}



function delete_image() {
    $image_id = absint($_POST['image_id']);
    $post_id = absint($_POST['post_id']);

    global $wpdb;
    $table_name = 'tr_car_images';


    $image_path = $wpdb->get_var(

        $wpdb->prepare("SELECT file_path FROM $table_name WHERE id = %d", $image_id)

    );

    $main_path   	  = '/home/1163638.cloudwaysapps.com/uerxjzjsrf/public_html'; 


    if (file_exists($main_path.$image_path)) {
         unlink($main_path.$image_path);
    }

    
     $wpdb->delete($table_name, array('id' => $image_id));
    // Display updated existing images
    display_existing_images($post_id);

    wp_die();
}

add_action('wp_ajax_delete_image', 'delete_image');
add_action('wp_ajax_nopriv_delete_image', 'delete_image');



/*----------------------------------------------------------------------------------*/



function add_commodity_image_meta_box() {
    add_meta_box(
        'commodity_image_meta_box',
        'Image Upload',
        'render_commodity_image_meta_box',
        'commodities',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_commodity_image_meta_box');


function render_commodity_image_meta_box($post) {
    // Fetch existing images for the current post
    $existing_images = get_post_meta($post->ID, '_commodity_images', true);
    include_once("upload_backend.php");

}

add_action("init", function () {
    if (isset($_GET['cron_commodities_info_missing']) && $_GET['cron_commodities_info_missing'] == "ok") {
        global $wpdb;

        // Fetch records with missing info
        $res = $wpdb->get_results("SELECT * FROM tr_posts a 
                                  LEFT JOIN tr_commodities b ON a.ID = b.post_id 
                                  WHERE post_type='commodities' AND 
                                  (b.value='' OR b.title_number='' OR b.title_state='') 
                                  LIMIT 0, 10000", ARRAY_A);

        $to  	 =  'zeeshangill11@gmail.com';
        
        $subject =  'Missing Information for Your Product';
        
        $headers =   array('Content-Type: text/html; charset=UTF-8');


       # $message= "test";
       # print_r( wp_mail($to, $subject, $message, $headers) );
        #exit;

        if (!empty($res)) {
        	
            foreach ($res as $key => $value) {
                

                $buyer   = $value['buyer'];
                $post_id = $value['ID'];
                if($buyer>0)
                {

					$user_data = get_userdata($buyer);
					if($user_data) 
					{
						$user_email = $user_data->user_email;
						if($user_email!="")
						{

								
			                $email_notification_query = new WP_Query(array(
			                    'post_type' => 'email_notification',
			                    'post_parent' => $value['ID'], // Assuming 'ID' is the field containing the commodities ID
			                ));	


		                  	if (!$email_notification_query->have_posts()) 
		                  	{
			                    $message = "Hi,<br>This information is missing for your product:<br>";
			                    $message .= "Value: " . $value['value'] . "<br>";
			                    if($value['title_number']=="")
			                    {
			                    	 $message .= "Title Number: " . $value['title_number'] . "<br>";
			                    }
			                   
			                    $message .= "Title State: " . $value['title_state'] . "<br>";

			                    wp_mail($user_email, $subject, $message, $headers);

			                    $email_notification_data = array(
			                        'post_type' => 'email_notification',
			                        'post_title' => 'Email Notification',
			                        'post_status' => 'publish',
			                        'post_content' => 'Email sent for missing information.',
			                        'post_parent' => $value['ID'], // Assuming 'ID' is the field containing the commodities ID
			                    );

			                    $email_notification_id = wp_insert_post($email_notification_data);
							    if ($email_notification_id) {
							        update_field('parent_id', $value['ID'], $email_notification_id);
							        update_field('to_email_address', $user_email, $email_notification_id);
							        update_field('type', 'missing_info_commodities', $email_notification_id);
							    } else {
							        echo "Failed to insert email notification post.";
							    }
			                }		

						}
						else
						{
							//need to write the log
						}

					}
					else
					{
						//need to write the log
					}
                }
                else
                {
                	//need to write the log

                }
                

              
            }

            // Additional code if needed after sending emails

            echo "Emails sent successfully.";
        } else {
            echo "No records with missing information.";
        }

        exit;
    }
});


/**/





function run_custom_cron_job() {
    $response = wp_remote_get('https://portdox.com/?cron_commodities_info_missing=ok');
    
    if (is_wp_error($response)) {
        error_log('Error fetching URL: ' . $response->get_error_message());
    } else {
        // Success
        // You can log success or handle the response as needed
    }
}

if (!wp_next_scheduled('custom_cron_job')) {
    wp_schedule_event(time(), 'every_five_minutes', 'custom_cron_job');
}

// Hook the function to the scheduled event
add_action('custom_cron_job', 'run_custom_cron_job');

// Define the cron interval
function custom_cron_intervals($schedules) {
    $schedules['every_five_minutes'] = array(
        'interval' => 1 * 60, // 5 minutes in seconds
        'display'  => __('Every 5 Minutes'),
    );
    return $schedules;
}
add_filter('cron_schedules', 'custom_cron_intervals');









?>