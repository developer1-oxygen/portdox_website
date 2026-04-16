<?php 
/*
Plugin Name:  Custom Plugin 
Plugin URI:   https://www.oxygensoft.ae 
Description:  Custom Plugin For Custom functionality
Version:      1.0
Author:       WPBeginner 
Author URI:   https://www.oxygensoft.ae
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpb-tutorial
Domain Path:  /languages
*/
function my_custom_roles() {
    
    add_role( 'employee_11', __( 'Employee Level 1' ), array(
        'read' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'edit_published_pages' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'delete_posts' => true,
        'delete_pages' => true,
        'manage_categories' => true,
        'manage_tags' => true,
        'upload_files' => true,
    ) );


     add_role( 'employee_22', __( 'Employee Level 2' ), array(
        'read' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'edit_published_pages' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'delete_posts' => true,
        'delete_pages' => true,
        'manage_categories' => true,
        'manage_tags' => true,
        'upload_files' => true,
    ) );

    add_role( 'employee_33', __( 'Employee Level 3' ), array(
        'read' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'edit_published_pages' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'delete_posts' => true,
        'delete_pages' => true,
        'manage_categories' => true,
        'manage_tags' => true,
        'upload_files' => true,
    ) );

    add_role( 'driver', __( 'Driver' ), array(
        'read' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'edit_published_pages' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'delete_posts' => true,
        'delete_pages' => true,
        'manage_categories' => true,
        'manage_tags' => true,
        'upload_files' => true,
    ) );



    add_role( 'customer', __( 'Customer' ), array(
        'read' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'edit_published_p ages' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'delete_posts' => true,
        'delete_pages' => true,
        'manage_categories' => true,
        'manage_tags' => true,
        'upload_files' => true,
    ) );


     add_role( 'supplier', __( 'Supplier' ), array(
        'read' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'edit_published_pages' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'delete_posts' => true,
        'delete_pages' => true,
        'manage_categories' => true,
        'manage_tags' => true,
        'upload_files' => true,
    ) );



     add_role( 'broker', __( 'Broker' ), array(
        'read' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'edit_published_pages' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'delete_posts' => true,
        'delete_pages' => true,
        'manage_categories' => true,
        'manage_tags' => true,
        'upload_files' => true,
    ) );


     add_role( 'carrier', __( 'Carrier' ), array(
        'read' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'edit_published_pages' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'delete_posts' => true,
        'delete_pages' => true,
        'manage_categories' => true,
        'manage_tags' => true,
        'upload_files' => true,
    ) );

    
    add_role( 'company', __( 'Company' ), array(
        'read' => true,
        'edit_posts' => true,
        'edit_pages' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'edit_published_pages' => true,
        'publish_posts' => true,
        'publish_pages' => true,
        'delete_posts' => true,
        'delete_pages' => true,
        'manage_categories' => true,
        'manage_tags' => true,
        'upload_files' => true,
        'create_users' => true,
        'promote_users'=>true,

    ) );
    
 


    
}
add_action( 'init', 'my_custom_roles' );


function custom_login_redirect() {
    if ( ( str_contains($_SERVER['REQUEST_URI'] , '/wp-login.php?loggedout=true') ) && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
        wp_redirect( 'http://woocommerce-457959-1434031.cloudwaysapps.com/login_new/' );
        exit();
    }
}
add_action( 'login_init', 'custom_login_redirect' );


function get_list_of_company($user_id22)
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
         
         $employee_list = get_user_meta( $user_id, 'employee_list', true ); 
       
         if(in_array($user_id22,$employee_list))
         {
             $company_list[] = $user_id;
         }
        
    }
    return $company_list;
}


function my_pre_get_posts2( $query ) {
    if ( ! is_admin() ) {
        return;
    }

    if ( !isset($_GET['page']) || ($_GET['page'] !== 'wpforms-overview' and $_GET['page'] !== 'wpforms-entries') ) {
        return;
    }
    
    
    $current_user = wp_get_current_user();
    $user_roles = $current_user->roles;
    
   if ( 
    in_array( 'employee_2', $user_roles, true ) 
    or in_array( 'driver', $user_roles, true ) 
    or in_array( 'customer', $user_roles, true ) 
    or in_array( 'supplier', $user_roles, true ) 
    or in_array( 'broker', $user_roles, true ) 
    or in_array( 'carrier', $user_roles, true ) 
    or in_array( 'company', $user_roles, true ) 



    ) {
  
       
        
        $comp_ids =  get_list_of_company($current_user->ID);
        //print_r($comp_ids );
       
      
        if( count($comp_ids)>0 )
        {
            $query->set('author', $comp_ids[0]);
        }
        else
        {
            $query->set('author', $current_user->ID);
        }
    }

    
}
add_action( 'pre_get_posts', 'my_pre_get_posts2' );



/*function custom_admin_url() {
    return site_url().'/dashboard';
}
add_filter( 'admin_url', 'custom_admin_url' );*/


/*-------------------------------------------------------------*/

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo site_url(); ?>/wp-content/uploads/2015/07/logo_2.png);
		height:65px;
		width:320px;
		background-size: 320px 65px;
		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );





include_once("vin_page.php");
?>