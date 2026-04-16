<?php






function save_post_user_id($post_id) {
    
    global $wpdb;

    if (get_post_type($post_id) === 'shipment' ) {
      
        $user_id = get_current_user_id();

        

        
        $query2 = $wpdb->prepare( "SELECT creator_user_id FROM {$wpdb->prefix}shipment_info WHERE post_id = %d ", $post_id);
		
		$creator_user_id = $wpdb->get_col($query2);
	
	
		if(isset($creator_user_id[0]) and $creator_user_id[0]!="" ) 
		{
			
		}	
		else
		{
			update_field('creator_user_id', $user_id, $post_id);
			$wpdb->update("tr_shipment_info" ,array( 'creator_user_id' =>  $user_id) , array('post_id'=>$post_id) );		
		}

       

    }

    if (get_post_type($post_id) === 'commodities' ) {
      
        $user_id = get_current_user_id();

        

        
        $query2 = $wpdb->prepare( "SELECT creator_user_id FROM {$wpdb->prefix}commodities WHERE post_id = %d ", $post_id);
		
		$creator_user_id = $wpdb->get_col($query2);
	
	
		if(isset($creator_user_id[0]) and $creator_user_id[0]!="" ) 
		{
			
		}	
		else
		{
			update_field('creator_user_id', $user_id, $post_id);
			$wpdb->update("tr_commodities" ,array( 'creator_user_id' =>  $user_id) , array('post_id'=>$post_id) );		
		}

       

    }


    



}
add_action('acf/save_post', 'save_post_user_id', 20);




function restrict_user_creation($user_id) {
   

    global $wpdb;
       
    $current_user = wp_get_current_user();

	if ( $current_user instanceof WP_User ) {
	    

		$parent_user_id = $current_user->ID;


		$user 	 		= get_user_by('ID', $parent_user_id);


		if (in_array('company', $user->roles) or in_array('partner', $user->roles)) {
			 
			$wpdb->insert($wpdb->usermeta ,array( 'meta_key' => 'parent_user_id' , 'meta_value' => $parent_user_id , 'user_id'=>$user_id));
		}
	}




}
add_action('user_register', 'restrict_user_creation', 10, 1);







function admin_users_filter($query)
{
	global $pagenow;
	global $wpdb;
	if ( $pagenow == 'users.php' && (current_user_can('company') or current_user_can('partner') )  ) 
	{
		$current_user = wp_get_current_user();
		$company_user_id = $current_user->ID;

		$query->query_where .= " AND EXISTS (SELECT 1 FROM $wpdb->usermeta WHERE user_id = {$wpdb->users}.ID AND meta_key = 'parent_user_id' AND meta_value = $company_user_id)";
	}
}

//add_action( 'pre_user_query', 'admin_users_filter' );


// add_action('pre_user_query', 'modify_user_query');

// function modify_user_query($user_query) {
//     global $wpdb;

//     // Get the current user's ID
//     $current_user = wp_get_current_user();
//     $current_user_id = $current_user->ID;

//     // Create a custom SQL query
//     $custom_query = "SELECT DISTINCT u.ID, u.user_login, u.user_email
//                     FROM {$wpdb->users} u
                    
//                     WHERE 1";

//     $prepared_query = $wpdb->prepare($custom_query, $current_user_id);

//     // Replace the default user query with the custom query
//     $user_query->query_where = $prepared_query;
// }




//add_action('pre_user_query', 'restrict_user_list');

function restrict_user_list($user_query) {
    // Set the user ID you want to display

    global $wpdb;

    // Get the current user's ID
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;

    // Query to get the comma-separated list of r_user_id for the current user
    $query = $wpdb->prepare(
        "SELECT GROUP_CONCAT(CONCAT('''', r_user_id, '''')) AS r_user_list 
        FROM tr_users_relation 
        WHERE user_id = %d",
        $current_user_id
    );
    $result = $wpdb->get_var($query);

    // Storing the result in a PHP variable
    $r_user_list = $result;

    
   // $user_query->query_where = "WHERE ID in(".$r_user_list.")" ;
}





//ocean_export_booking_partner


// add_filter( 'editable_roles', 'filter_company_editable_roles' );
// function filter_company_editable_roles( $roles ) {
//     // Define the allowed roles for the company user
//     $allowed_roles = array(
//         'broker',
//         'supplier',
//         'freight_forwarder',
//     );

//     // Filter the roles based on the allowed roles for the company user
//     foreach ( $roles as $role_key => $role_data ) {
//         if ( ! in_array( $role_key, $allowed_roles ) ) {
//             unset( $roles[ $role_key ] );
//         }
//     }

//     return $roles;
// }



function custom_company_role_dropdown( $roles ) {
    $current_user = wp_get_current_user();
    $allowed_roles = array( 'company','partner' );

    if ( array_intersect( $allowed_roles, $current_user->roles ) ) {
        
        $allowed_roles = array(
            'broker' => $roles['broker'],
            'supplier' => $roles['supplier'],
            'freightforwarder' => $roles['freightforwarder'],
            'carrier' => $roles['carrier'],

        );
        return $allowed_roles;
    }

    return $roles;
}
add_filter( 'editable_roles', 'custom_company_role_dropdown' );



/************************ Hidden creator user dropdown*********************************/
function hide_acf_field_64459807126c9($field) {
    if ($field['key'] === 'field_64459807126c9') {
        $field['wrapper']['class'] .= ' hidden';
    }
    return $field;
}
add_filter('acf/render_field', 'hide_acf_field_64459807126c9');



function get_list_of_company_new2($user_id22)
{
    $role = 'company';
    $args = array(
        'role' => $role,
    );
    $user_query = new WP_User_Query( $args );
    
    $company_list = array();
    $users = $user_query->get_results();
    
    foreach ( $users as $user ) {
         $user_id = $user->ID;
         
        #$employee_list = get_user_meta( $user_id, 'employee_list', true );
        $employee_list = get_user_meta( $user_id, 'company_employee', true );

        if(in_array($user_id22,$employee_list))
        {
            $company_list[] = $user_id;
        }
        
    }
    return $company_list;
}


function filter_admin_post_list_by_role($query) {
  
    if (is_admin() && $query->is_main_query() && $query->get('post_type') == 'shipment') {
        
        $user = wp_get_current_user();
        
        if (is_user_logged_in() && (in_array('company', $user->roles) or in_array('partner', $user->roles)) ) {
          
            if (!current_user_can('administrator')) {
                
                //$query->set('post__in', array(18665));
            	$currentUserId = get_current_user_id();
				global $wpdb;
				$query2 = $wpdb->prepare(
				    "SELECT post_id FROM {$wpdb->prefix}shipment_info WHERE creator_user_id = %d or ocean_export_booking_partner= %d",
				    $currentUserId,$currentUserId
				);
				$postIds = $wpdb->get_col($query2);

				if(empty($postIds))
				{
					$postIds = array('000');
				}


				$query->set('post__in',  $postIds);

            }
        }


        if (is_user_logged_in() && (in_array('employee_11', $user->roles) or in_array('employee_22', $user->roles) or in_array('employee_33', $user->roles)) ) {
        	// #$_SESSION['ac']='1';
        	// echo "===================================";
        	
        	// $_SESSION['comp_id']='990008';
        	$currentUserId 	=	get_current_user_id();
        	
        	$comp_ids   	= 	get_list_of_company_new2($currentUserId);
        	
        

        	if(!empty($comp_ids))
        	{
        		$comp_ids_str = "'".implode("','", $comp_ids)."','".$currentUserId."' "; 
        	}
        	else
        	{
        		$comp_ids_str =  " '".$currentUserId."' "; 
        	}
        	
        	#echo $comp_ids_str;exit;

          
            if (!current_user_can('administrator')) {
                
                //$query->set('post__in', array(18665));
            	$currentUserId = $comp_id;
				global $wpdb;
				$query2 =  "SELECT post_id FROM {$wpdb->prefix}shipment_info WHERE creator_user_id in(". $comp_ids_str.")  
				    or ocean_export_booking_partner='".get_current_user_id()."' ";
				
				$postIds_ar = $wpdb->get_results($query2,ARRAY_A);
				$postIds = array();
				foreach($postIds_ar as $val)
				{
					$postIds[] = $val['post_id'];
				}
				
				
				if(empty($postIds))
				{
					$postIds = array('000');
				}


				$query->set('post__in',  $postIds);

            }
        }

    }
}
add_action('pre_get_posts', 'filter_admin_post_list_by_role');


add_action('wp_logout', 'unset_comp_id_session');

function unset_comp_id_session() {
    // Check if the session variable is set
    if (isset($_SESSION['comp_id'])) {
        // Unset the session variable
        unset($_SESSION['comp_id']);
    }
}



function validate_employee_company_relationship($valid, $value, $field, $input_name)
{
    global $wpdb;
    
    // Only perform the validation if the field key matches the ACF field key
    if ($field['key'] === 'field_648d6e9662f79') {
        // Retrieve the submitted employee IDs
        $employee_ids = $value;
        
        $user_id =  (str_replace("user_","",$_REQUEST['post_id']));


        $cond = '';
        foreach ($employee_ids as $employee_id) {
            $cond .= "  meta_value like '%" . $employee_id . "%' or ";
        }
        $cond = trim($cond, " or ");
        if ($cond != "") {
            $cond = " (" . $cond . ") ";
        }
        
        if ($cond != "" and $user_id!="") {

            
            
            $res     =  $wpdb->get_results(" SELECT * FROM `tr_usermeta` WHERE 
                                        user_id <> '" . $user_id . "' AND 
                                        meta_key='company_employee' AND 
                                        " . $cond . " LIMIT 50", ARRAY_A);
    
            if(count($res)>0) 
            {	
               $valid = ' The selected employee is already associated with another company.';
               return $valid;


            }
        }
    }
    return $valid;

  
}
add_filter('acf/validate_value', 'validate_employee_company_relationship', 10, 4);


add_action('wp_dashboard_setup', 'remove_wpforms_dashboard_widget');

function remove_wpforms_dashboard_widget() {
    remove_meta_box('wpforms_reports_widget_pro', 'dashboard', 'normal'); 
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); 
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); 
    remove_meta_box('dashboard_primary', 'dashboard', 'side'); 
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); 
    
}

//remove wpforms for company
// add_action('admin_menu', 'remove_wpforms_for_company_users');
// function remove_wpforms_for_company_users() {
//     $current_user = wp_get_current_user();
//     // Check if the user has the 'company' role
//     if (in_array('company', $current_user->roles)) {
//         // Remove the WPForms menu
//         remove_menu_page('wpforms-overview');
//     }
// }

function custom_admin_head_script2() {
    // Enqueue jQuery from WordPress
    if(is_admin())
    {


        wp_enqueue_script('jquery');

        // Add custom jQuery code to hide the table based on the child element's id
        echo '<style type="text/css">.user-admin-color-wrap, .user-rich-editing-wrap, .user-comment-shortcuts-wrap , .show-admin-bar, #contextual-help-link-wrap, #application-passwords-section{ display:none;}</style><script>
            jQuery(document).ready(function($) {
                $("#user_behance").closest("table").hide();
            });
        </script>';
    }
}
add_action('admin_head', 'custom_admin_head_script2');
/*-----------------------------------------------*/

function create_membership_assignment_page() {
    add_menu_page(
        'Membership Assignment',
        'Membership Assignment',
        'manage_options',
        'membership-assignment',
        'membership_assignment_page_content',
        'dashicons-id',
        20
    );
}
add_action('admin_menu', 'create_membership_assignment_page');

// Callback function for the membership assignment page content
function membership_assignment_page_content() {
    // Add your HTML/PHP content for the membership assignment page here
     echo '<h1>Membership Assignment Page</h1>';
    global $wpdb;
    // $users_query = $wpdb->prepare(
    //     "SELECT user_id, meta_value FROM {$wpdb->usermeta} WHERE meta_key = %s AND (meta_value = %s OR meta_value = %s)",
    //     'wp_capabilities',
    //     'shipper',
    //     'partner'
    // );

    // $users = $wpdb->get_results($users_query);

    $users_query = $wpdb->prepare(
        "SELECT *
        FROM {$wpdb->users} u
        LEFT JOIN tr_users_relation r ON u.ID = r.user_id
        WHERE r.user_id IS NULL "
    );
    $users = $wpdb->get_results($users_query);

  

    echo '<form method="post" action="">';
   
    echo '<label for="user">Select User:</label>';
   
        echo '<select name="user">';
            foreach ($users as $user2) {
                $user_meta = get_userdata($user2->ID);
                $user_roles = $user_meta->roles;
                if(in_array("shipper", $user_roles))
                {

                    echo '<option value="' . $user2->ID . '">' . $user2->display_name .'=>'.$user_roles[0]. ' ('.$user2->user_email.') ' . '</option>';    
                }

                
            }
        echo '</select>';

    echo '<br><br>';

    echo '<input type="submit" name="submit" value="Assign Membership">';
    echo '</form>';

    // Process form submission here
    if (isset($_POST['submit'])) {
        if (isset($_POST['user'])) {
            $new_assigned_user = $_POST['user'];
            $current_user = wp_get_current_user();
            $selected_user_id = $current_user->ID;

            $new_assigned_user = $_POST['user'];

            global $wpdb;
            
            $wpdb->delete('tr_users_relation', array('r_user_id' => $new_assigned_user));

            $wpdb->insert('tr_users_relation', array('user_id' => $selected_user_id, 'r_user_id' => $new_assigned_user));

        }
    }


    global $wpdb;
    $current_user = wp_get_current_user();
    $selected_user_id = $current_user->ID;
    $assigned_users_query = $wpdb->prepare(
        "SELECT r_user_id FROM tr_users_relation WHERE user_id = %d",
        $selected_user_id
    );
    $assigned_users = $wpdb->get_results($assigned_users_query);

    echo "<h2>Assigned Users for User ID: $selected_user_id</h2>";
    if ($assigned_users) {
        echo '<table style="border: 1px solid #000; border-collapse: collapse;">';
        echo '<tr><th>User ID</th><th>Assigned User ID</th><th>Username</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Delete</th></tr>';
        foreach ($assigned_users as $assigned_user) {
            $user_info = get_userdata($assigned_user->r_user_id);
            if ($user_info) {
                echo '<tr>';
                echo '<td style="border: 1px solid #000;">' . $selected_user_id . '</td>';
                echo '<td style="border: 1px solid #000;">' . $assigned_user->r_user_id . '</td>';
                echo '<td style="border: 1px solid #000;">' . $user_info->user_login . '</td>';
                echo '<td style="border: 1px solid #000;">' . $user_info->first_name . '</td>';
                echo '<td style="border: 1px solid #000;">' . $user_info->last_name . '</td>';
                echo '<td style="border: 1px solid #000;">' . $user_info->user_email . '</td>';
                echo '<td style="border: 1px solid #000;"><button type="button" class="deleteBtn" data-user="' . $assigned_user->r_user_id . '">Delete</button></td>';
                echo '</tr>';
            }
        }
        echo '</table>';
    } else {
        echo "No assigned users found for User ID: $selected_user_id";
    }
    
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.deleteBtn').click(function() {
                var userId = $(this).data('user');
                var selectedUserId = <?php echo $selected_user_id; ?>;

                // AJAX request to delete the user assignment
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'delete_assigned_user',
                        user_id: selectedUserId,
                        assigned_user_id: userId,
                        security: '<?php echo wp_create_nonce('delete_assigned_user_nonce'); ?>'
                    },
                    success: function(response) {
                        location.reload(); // Reload the page after successful delete
                    }
                });
            });
        });
    </script>
    <?php
    // You can include forms, tables, or any content relevant to membership assignments here
}

add_action('wp_ajax_delete_assigned_user', 'delete_assigned_user');
function delete_assigned_user() {
    if (isset($_POST['assigned_user_id']) ) {
        $user_id = $_POST['user_id'];
        $assigned_user_id = $_POST['assigned_user_id'];
        check_ajax_referer('delete_assigned_user_nonce', 'security');

        global $wpdb;
        $wpdb->delete(
            'tr_users_relation',array( 'r_user_id' => $assigned_user_id),array( '%d')
        );
        echo 'ok';
    }
    wp_die(); // Required to terminate the script
}




function custom_user_edit_filter23($allcaps, $caps, $args, $user) {
    // Check if the user is trying to edit another user
    if (isset($args[0]) && $args[0] == 'edit_user') {
       

        // Check if the current user has the "company" role
        $current_user = get_userdata(get_current_user_id());
        
        if ($current_user && in_array('company', $current_user->roles)) {
            // die("Permission Not allowed");
            // If the current user has the "company" role, check the user being edited

            $edited_user_id = $_GET['user_id'];
            $edited_user = get_userdata($edited_user_id);
        
            if ($edited_user && in_array('shipper', $edited_user->roles)) {
                
                global $wpdb;

                $s_user_id = $current_user->ID;
                
                $qq = " SELECT * FROM tr_users_relation WHERE user_id ='".$s_user_id."' and r_user_id = '".$edited_user_id."' ";
               

                $assigned_users = $wpdb->get_results($qq,ARRAY_A);
                
                if(count($assigned_users)>0)
                {
                   
                }
                else
                {
                     $allcaps['edit_users'] = false;  
                }

                
            }
        }
    }

    return $allcaps;
}

add_filter('user_has_cap', 'custom_user_edit_filter23', 10, 4);
?>