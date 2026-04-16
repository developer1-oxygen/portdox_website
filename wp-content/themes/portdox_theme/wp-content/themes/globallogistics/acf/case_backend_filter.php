<?php 


function filter_users_by_approval_status( $field ) {
    global $post;
    
    $users = array('' => 'Select a user'); // add empty option
    $user_query = new WP_User_Query( array( 'meta_key' => 'approve_from_admin', 'meta_value' => true ) );
    $approved_users = $user_query->get_results();
    foreach ( $approved_users as $user ) {
        $users[ $user->ID ] = $user->display_name;
    }
    $field['choices'] = $users;
   
    return $field;
}
add_filter( 'acf/load_field/name=buyer_name', 'filter_users_by_approval_status' );




add_action('restrict_manage_posts', 'add_vin_filter');
add_filter('pre_get_posts', 'process_vin_filter');

function add_vin_filter() {
    global $typenow;

    if ($typenow === 'case') {
      	$vin_filter = isset($_GET['vin_filter']) ? $_GET['vin_filter'] : '';

        if ($vin_filter or true) {
           // echo '<input type="text" name="vin_filter" placeholder="Filter by VIN number">';

        	 echo '<input name="vin_filter" value="'.$vin_filter.'" placeholder="search via vin" style="float: left;margin-right: 6px;max-width: 12.5rem;height: 29px;">';
        }
    }
}
add_action("init",function(){
	if(@$_GET['iamdev55']=="ok")
	{

		$val22 = '123';

		
		
		
		$args = array(
		    'post_type' => 'case',
		    'meta_query' => array(
		        'relation' => 'OR',
				array(
					'key' => 'product_info_0_vin', // Assumes the vin field is always the first subfield
					'value' => $val22,
					'compare' => '='
				),
				array(
					'key' => 'product_info_1_vin', // Assumes the vin field is always the first subfield
					'value' => $val22,
					'compare' => '='
				)
		        
		    )
		);


		$args = array(
		    'post_type' => 'case',
		    'meta_query' => array(
		        'relation' => 'OR',
				
		        
		    )
		);


		for($k=0; $k<10; $k++ )
		{

			$aa = array(
			            'key' => 'product_info_'.$k.'_vin',
			            'value' => $val22,
			            'compare' => '='
			        ); 
			array_push($args['meta_query'],$aa);
		}
		
		
		

		$query2 = new WP_Query($args);

		$ids = array();
		if ($query2->have_posts()) {
		    while ($query2->have_posts()) {
		        $query2->the_post();
		        $ids[] = get_the_ID();
		      
		    }
		   
		} else {
		    // No posts found
		}



	
		/*if ($ids) {
		    $query->set('post__in', $ids);
		} else {
		    $query->set('post__in', array(0));
		}*/
		exit;	
	}
	
});

function process_vin_filter($query) {
    global $pagenow;


    if (is_admin() && $pagenow === 'edit.php' && isset($_GET['vin_filter'])) 
    {
      
        if ( $query->is_search() ) {

	        $vin_filter = sanitize_text_field($_GET['vin_filter']);
	        if($vin_filter!="")
	        {
	        	$val22 = $vin_filter;

				
				

				$args = array(
				    'post_type' => 'case',
				    'meta_query' => array(
				        'relation' => 'OR',
						
				        
				    )
				);


				for($k=0; $k<1; $k++ )
				{

					$aa = array(
					            'key' => 'product_info_'.$k.'_vin',
					            'value' => $val22,
					            'compare' => '='
					        ); 
					array_push($args['meta_query'],$aa);
				}
				
				

				$query2 = new WP_Query($args);
	
				$ids = array();
				if ($query2->have_posts()) {
				    while ($query2->have_posts()) {
				        $query2->the_post();
				        $ids[] = get_the_ID();
				    }
				   
				} 

			
				
				if ($ids) {
				    $query->set('post__in', $ids);
				} else {
				    $query->set('post__in', array(0));
				}
		     
	    	}
	    }
	}

}



add_filter( 'manage_case_posts_columns', 'add_vin_column_to_case_admin' );
function add_vin_column_to_case_admin( $columns ) {
    $columns['vin'] = 'VIN';
    return $columns;
}

add_action( 'manage_case_posts_custom_column', 'display_vin_column_data', 99, 2 );
function display_vin_column_data( $column, $post_id ) {
    if ( 'vin' === $column ) {
        $vin = get_post_meta( $post_id, 'vin', true );
        echo $vin.'===';
    }
}



function my_acf_relationship_query( $args, $field, $post_id ) {
    // Change 'commodities' to the name of your related post type.
	    
	if ( $field['name'] === 'product_info' ) {

	    $args['post_type'] = 'commodities';

		global $wpdb;

		$table_name = 'tr_cases_info'; // Replace 'my_table' with the actual name of your table.
		
		$results = $wpdb->get_results("SELECT * FROM $table_name where post_id <> '".$post_id."' ",ARRAY_A);

		$already_exist_ids_ar = [];
		foreach ( $results as $result ) {
		    
		    $product_info = $result['product_info'];

		    $ids = json_decode( $product_info );
		   
		    foreach ( $ids as $id ) {
		         array_push($already_exist_ids_ar,$id) ;
		    }
		}

		
		
		//unset($already_exist_ids_ar[0]);
	    $args['post__not_in'] = $already_exist_ids_ar;
	}
	
    return $args;
}

function my_acf_relationship_query_filter( $options, $field, $the_post ) {




    if ( $field['name'] === 'product_info' ) {
        

    	global $wpdb;
    	$post_id    = $the_post->ID;

		$table_name = 'tr_cases_info'; 
		
		$results = $wpdb->get_results(" SELECT * FROM $table_name where post_id <> '".$post_id."' ",ARRAY_A);

		$already_exist_ids_ar = [];
		
		foreach ( $results as $result ) {
		    
		    $product_info = $result['product_info'];

		    $ids = json_decode( $product_info );
		   
		    foreach ( $ids as $id ) {
		        array_push($already_exist_ids_ar,$id) ;
		    }
		}

        $options['filter_by'] =  array(
            
            'key' => 'post__not_in',
            'value' =>$already_exist_ids_ar
        );
    
    }
    

    return $options;
}

add_filter( 'acf/fields/relationship/query', 'my_acf_relationship_query', 10, 3 );
add_filter( 'acf/fields/relationship/query_args', 'my_acf_relationship_query_filter', 10, 3 );


add_action("init",function (){

	if(@$_GET['dd']=="ok")
	{

		
		global $wpdb;
		$table_name = 'tr_cases_info'; // Replace 'my_table' with the actual name of your table.
		
		$results = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A);
		$already_exist_ids_ar = [];
		foreach ( $results as $result ) {
		    
		    $product_info = $result['product_info'];

		    $ids = json_decode( $product_info );
		   
		    foreach ( $ids as $id ) {
		        $already_exist_ids_ar[] = $id ;
		    }
		}
		
	
		$already_exist_ids_ar 	= array_unique($already_exist_ids_ar);
		unset($already_exist_ids_ar[0]);
		
		$already_exist_ids 		= implode('","',$already_exist_ids_ar);
		
		exit;
	}
});


add_action('acf/input/admin_head', 'custom_acf_admin_custom_backend_case');
function custom_acf_admin_custom_backend_case()
{
	?>
	<script type="text/javascript">

		function check_commdity_exist_in_other_case()
		{

			var ajax_url = '<?php echo  admin_url( 'admin-ajax.php' );?>';

			var product_infos = jQuery('[data-name="product_info"] .acf-input .acf-relationship .selection .values ul li');


			var product_info_str='';

			product_infos.each(function (){
			    product_info_str = product_info_str+jQuery(this).find('input').val()+",";
			});
				
			
			var post_id2   = '<?php echo get_the_ID();?>';
		    jQuery.ajax({
		        url: ajax_url,
		        type: 'POST',
		        data: {
		            action: 'check_commdity_exist_in_other_case',
		          
		            product_info_str: product_info_str,
		            post_id2: post_id2,
		        },
		        success: function(response) {
		           
		           //	var ids = '13976';
		           	var ids = response;
					if (ids !== "") {
					    var ids_ar = ids.split(",");
					    var bookingDropdown = jQuery('.values-list li');
					    
					    bookingDropdown.each(function() {
					        var temp = parseInt(jQuery(this).find('span').attr('data-id'));
					        var temp2 = jQuery.trim(jQuery(this).find('span').text());
					       
					        if (ids_ar.includes(temp.toString())) {
					            alert(temp2 + " exists in other case");
					            jQuery(this).find('[data-name="remove_item"]').click();
					        } else {
					            
					        }
					    });
					}
		           
		        }
		    });
		}

		jQuery(document).on('click', '[data-name="product_info"] .acf-input .acf-relationship .selection ul li', function() {
			
			check_commdity_exist_in_other_case();
			
		});
		jQuery(document).on('click', '[data-name="product_info"] .acf-input .selection .values a', function() {
			
			check_commdity_exist_in_other_case();
			
		});
		jQuery(window).on("load",function (){
					
			setTimeout(function(){

					check_commdity_exist_in_other_case();
					

			},2000);
			
		});

	</script>
	<?php	
}



add_action('wp_ajax_check_commdity_exist_in_other_case', 'check_commdity_exist_in_other_case');
add_action('wp_ajax_nopriv_check_commdity_exist_in_other_case', 'check_commdity_exist_in_other_case');

function check_commdity_exist_in_other_case() {
   



	global $wpdb;

    $post_id2 			= 	$_POST['post_id2'];
    $product_info_str  	= 	trim($_POST['product_info_str'],",");

  
	$product_info_arr = explode(',', $product_info_str);
	$matched_product_info_arr = array();

	foreach ($product_info_arr as $product_info_id) {
		
		$result22 = $wpdb->get_results(" SELECT post_id,product_info FROM tr_cases_info 

	    		WHERE product_info LIKE '%".$product_info_id."%' and post_id <> '".$post_id2."' 

	    		" ,ARRAY_A
	    );
		foreach($result22 as $val)
		{
			$temp = json_decode($val['product_info']);
			foreach($temp as $val22)
			{
				array_push($matched_product_info_arr,$val22);	
			}		
			
		}
	   
	    

	}
	
	$matched_product_info_arr = array_unique($matched_product_info_arr);


	$matched_product_info_str = implode(',', $matched_product_info_arr);
	echo $matched_product_info_str ;
    wp_die();
}






function add_custom_column_header($columns) {
    // Add a new column with the key 'custom_column'
    $columns['house'] = 'Action';
    return $columns;
}
add_filter('manage_house_posts_columns', 'add_custom_column_header');

// Step 2: Populate content for the custom column
function add_custom_column_content($column, $post_id) {
    ?><div class="wrap "><a href="<?php echo site_url();?>/?submit_house=ok&house_id=<?php echo $post_id;?>" class="page-title-action" target="_blank"> Submit Form </a></div><?php 
}
add_action('manage_house_posts_custom_column', 'add_custom_column_content', 10, 2);

?>