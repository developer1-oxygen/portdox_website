<?php
if ( ! session_id() ) {
  session_start();
}






add_action('add_meta_boxes', 'add_booking_meta_box');

function add_booking_meta_box() {
   
    add_meta_box(
        'booking_details_meta_box', 
        'Booking Details', 
        'render_booking_meta_box',
        'booking', 
        'normal', 
        'high'
    );
}

// Callback function to render the contents of the custom meta box
function render_booking_meta_box($post) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'booking_info';

    // Retrieve booking data from custom table based on post ID
    $booking_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d", $post->ID), ARRAY_A);

    // Get options for Ocean Carrier dropdown from 'ocean_carrier' custom post type
    $ocean_carriers = get_posts(array(
        'post_type' => 'ocean_carrier',
        'posts_per_page' => -1,
    ));

    // Get options for POL dropdown from 'pol' custom post type
    $pols = get_posts(array(
        'post_type' => 'pol',
        'posts_per_page' => -1,
    ));

    // Get options for POD dropdown from 'pod' custom post type
    $pods = get_posts(array(
        'post_type' => 'pou',
        'posts_per_page' => -1,
    ));

    // Get options for Freight Forwarder dropdown from 'freight_forwarder' custom post type
    $freight_forwarders = get_posts(array(
        'post_type' => 'freight_forwarder',
        'posts_per_page' => -1,
    ));

    // Output fields for the meta box
    ?>
    <div>
        <!-- 
        <label for="ocean_carrier_field">Ocean Carrier:</label>
        <select id="ocean_carrier_field" name="ocean_carrier_field">
            <option value="">Select Ocean Carrier</option>
            <?php foreach ($ocean_carriers as $carrier) : ?>
                <option value="<?php echo esc_attr($carrier->ID); ?>" <?php selected($booking_data['ocean_carrier'], $carrier->ID); ?>><?php echo esc_html($carrier->post_title); ?></option>
            <?php endforeach; ?>
        </select><br> 
        -->

        <label for="pol_field">POL:</label>
        <select id="pol_field" name="pol_field">
            <option value="">Select POL</option>
            <?php foreach ($pols as $pol) : ?>
                <option value="<?php echo esc_attr($pol->ID); ?>" <?php selected($booking_data['vessel_information_pol'], $pol->ID); ?>><?php echo esc_html($pol->post_title); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="pod_field">POD:</label>
        <select id="pod_field" name="pod_field">
            <option value="">Select POD</option>
            <?php foreach ($pods as $pod) : ?>
                <option value="<?php echo esc_attr($pod->ID); ?>" <?php selected($booking_data['vessel_information_pod'], $pod->ID); ?>><?php echo esc_html($pod->post_title); ?></option>
            <?php endforeach; ?>
        </select><br>

       <!--  
        <label for="freight_forwarder_field">Freight Forwarder:</label>
        <select id="freight_forwarder_field" name="freight_forwarder_field">
            <option value="">Select Freight Forwarder</option>
            <?php foreach ($freight_forwarders as $forwarder) : ?>
                <option value="<?php echo esc_attr($forwarder->ID); ?>" <?php selected($booking_data['freight_forwarder'], $forwarder->ID); ?>><?php echo esc_html($forwarder->post_title); ?></option>
            <?php endforeach; ?>
        </select><br> 
        -->
    </div>
    <?php
}



add_action('save_post', 'save_booking_meta_box_data', 20);
function save_booking_meta_box_data($post_id) {
    
    
    // if (!current_user_can('edit_post', $post_id)) {
    //     return;
    // }

    global $wpdb;
    
    $table_name = $wpdb->prefix . 'booking_info';
    
    $data = array(
//        'ocean_carrier' => sanitize_text_field($_POST['ocean_carrier_field']),
        'vessel_information_pol' => sanitize_text_field($_POST['pol_field']),
        'vessel_information_pod' => sanitize_text_field($_POST['pod_field']),
//        'freight_forwarder' => sanitize_text_field($_POST['freight_forwarder_field']),
    );

    $wpdb->update($table_name, $data, array('post_id' => $post_id));
}




function update_notes_if_value_change($old_number,$new_number,$lable,$notes,$value_type)
{
    if($old_number!="")
    {

        $user = wp_get_current_user();
        $username = $user->user_login;

        if( ($lable=="License Value" or $lable=="ECCN" or $lable=="QuantityTwo" or $lable=="QuantityOne"
            or $lable=="Filing Option") and $old_number =='0'){$old_number='';}
      
        if($new_number!=$old_number)
        {

            

            if($value_type=="user")
            {
                $old_user = get_user_by('ID', $old_number);

                // Retrieve user object for new_number
                $new_user = get_user_by('ID', $new_number);

                // Extract first name and last name from user objects
                $old_first_name = $old_user->first_name;
                $old_last_name = $old_user->last_name;

                $new_first_name = $new_user->first_name;
                $new_last_name = $new_user->last_name;

                // Create the note string
                $note = '<b>'.$username.'</b> updated '.$lable.' From <a  title="'.$old_first_name.' '.$old_last_name.'" style="color:red">'.$old_first_name.' '.$old_last_name.
                        '</a> To <a title="'.$new_first_name.' '.$new_last_name.'"  style="color:green">'.$new_first_name.' '.$new_last_name.'</a>';
            }
            elseif($value_type=="pol_pod")
            {
                $note = '<b>'.$username.'</b> update '.$lable.' From <span style="color:red">'.get_the_title($old_number).
                        '</span> To <span style="color:green">'.get_the_title($new_number).'</span>';
            }
            elseif($value_type=="pol_pod_json")
            {
                $old_number2 = json_decode($old_number);
                $new_number2 = ($new_number);
                
                if($old_number2[0]!=$new_number2[0])
                {
                    $note = '<b>'.$username.'</b> update '.$lable.' From <span style="color:red">'.get_the_title($old_number2[0]).
                        '</span> To <span style="color:green">'.get_the_title($new_number2[0]).'</span>';
                }

            }
            elseif($value_type=="true_false")
            {
                
                if($old_number!=$new_number)
                {
                    if($new_number=="1")
                    {
                        $note = '<b>'.$username.'</b> Make '.$lable.' checked From uncheck';
                    }

                    if($new_number=="0")
                    {
                      $note = '<b>'.$username.'</b> update '.$lable.' uncheck from checked';  
                    }
                    
                }

            }

            elseif($value_type=="booking_array")
            {

                $note = '<b>'.$username.'</b> update '.$lable.' From <span style="color:red">'.($old_number).
                        '</span> To <span style="color:green">'.($new_number).'</span>';
            }
            else 
            {
                $note = '<b>'.$username.'</b> update '.$lable.' From <span style="color:red">'.$old_number.
                        '</span> To <span style="color:green">'.$new_number.'</span>';
            }           
            
            if (!is_array($notes)) {
                $notes = array();
            }

            $id     =   time().rand(100,1000);
            
            if($note!="")
            {
                $notes[$id] = array('id'=>$id,'message'=>$note,'can_delete'=>'yes');    
            }


            
            
        }
    }
    return $notes;
}


function load_select2() {
   /* wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css' );
    wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array( 'jquery' ), false, true );*/
}
add_action( 'admin_enqueue_scripts', 'load_select2' );

function replace_all_relationship_dropdowns() {
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="<?php echo get_template_directory_uri();?>/js/select2.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <?php
}
add_action( 'admin_head', 'replace_all_relationship_dropdowns' );



add_action( 'admin_init', 'custom_user_roles_add_multi_select' );
function custom_user_roles_add_multi_select() {
  add_action( 'show_user_profile', 'custom_user_roles_show_multi_select' );
  add_action( 'edit_user_profile', 'custom_user_roles_show_multi_select' );
  add_action( 'personal_options_update', 'custom_user_roles_save_multi_select' );
  add_action( 'edit_user_profile_update', 'custom_user_roles_save_multi_select' );
}

function custom_user_roles_show_multi_select( $user ) {
  $roles = get_editable_roles();
  $user_roles = $user->roles;

#print_r(  $user_roles);
  ?>
 <!--  <h3><?php _e( 'Multi User Roles' ); ?></h3> -->

 <!--  <table class="form-table">
    <tr>
      <th><label for="custom_user_roles"><?php _e( 'Select user roles:' ); ?></label></th>
      <td>
        <select multiple="multiple" name="custom_user_roles[]" id="custom_user_roles">
          <?php foreach ( $roles as $role_key => $role ) : ?>
            <?php $selected = in_array( $role_key, $user_roles ) ? 'selected="selected"' : ''; ?>
            <option value="<?php echo esc_attr( $role_key ); ?>" <?php echo $selected; ?>><?php echo esc_html( $role['name'] ); ?></option>
          <?php endforeach; ?>
        </select>
      </td>
    </tr>
  </table> -->
  <?php
}

function custom_user_roles_save_multi_select( $user_id ) {
  if ( ! current_user_can( 'edit_user', $user_id ) ) {
    return false;
  }

  $custom_user_roles = isset( $_POST['custom_user_roles'] ) ? $_POST['custom_user_roles'] : array();
  $_SESSION['custom_user_roles'] = $custom_user_roles;
  $_SESSION['s_user_id'] = $user_id;

 
}

add_action("init",function(){
    $custom_user_roles = isset( $_SESSION['custom_user_roles'] ) ? $_SESSION['custom_user_roles'] : array();
    $s_user_id = isset( $_SESSION['s_user_id'] ) ? $_SESSION['s_user_id'] :'';
    if ( ! empty( $custom_user_roles ) ) {


        $roles = $custom_user_roles;

        $user = new WP_User( $s_user_id );
        
        $user->set_role( '' );
        
        foreach ( $roles as $role ) {
            $user->add_role( $role );
        }
        unset($_SESSION['custom_user_roles']);
    }
});



add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .widefat td, .widefat td ol, .widefat td p, .widefat td ul {
        font-size: 11px;
        line-height: 1em;
    }
    .row-title {
        font-size: 11px!important;
        font-weight: 600;
    }
    .row-actions a{ font-size: 11px!important; }
    .row-actions button{ font-size: 11px!important; }
    .row-actions .inline{ display:none} 
    .row-actions .hide-if-no-js{display:none}
    [data-name=creator_user_id]{ display: none1; }
  </style>';
}



function get_field_new($selector, $post_id,$table2='')
{
    global $wpdb;
    $res=$wpdb->get_results("select * from ".$table2." where post_id='".$post_id."' ",ARRAY_A);
    return (isset($res[0][$selector])?$res[0][$selector]:'');

}
function update_post_title_with_random_number($post_id, $post_type) {
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


function iam_dev()
{
    if(isset($_GET['iamdev']) and $_GET['iamdev']=="ok")
    {
       


       // $post_title = get_the_title(14093);
    

        exit;
    }
}
add_action("init",'iam_dev');


include_once( get_stylesheet_directory() . '/form_driver_template.php' );


include_once( get_stylesheet_directory() . '/custom_post_type.php' );

include_once( get_stylesheet_directory() . '/download_pdf_metabox.php' );


include_once( get_stylesheet_directory() . '/acf/house_auto_fill.php' );


include_once( get_stylesheet_directory() . '/acf/email_settings_action.php' );

include_once( get_stylesheet_directory() . '/acf/user_permission.php' );

include_once( get_stylesheet_directory() . '/acf/customer_document_submit.php' );








function update_post_title_on_save($post_id) {
    // get the post type
    $post_type = get_post_type($post_id);
   
    if ($post_type === 'case') {
       update_post_title_with_random_number($post_id, 'case');
    }
    if ($post_type === 'shipment') {
       update_post_title_with_random_number($post_id, 'shipment');
    }
    if ($post_type === 'booking') {
       update_post_title_with_random_number($post_id, 'booking');
    }

    if ($post_type === 'house') {
       update_post_title_with_random_number($post_id, 'house');
    }
    if ($post_type === 'commodities') {
       update_post_title_with_random_number($post_id, 'commodities');
    }

}

add_action('save_post', 'update_post_title_on_save');



function upload_htc_code()
{
    if(@$_GET['upload_htc_code'] && $_GET['upload_htc_code']=="ok")
    {



    $file = fopen("/home/457959.cloudwaysapps.com/fwkcspffuz/public_html/wp-content/themes/globallogistics/abc.txt", "r");

    $s=0;


    if (!$file) {
      echo "Unable to open the file.\n";
      exit;
    }


    while(!feof($file)) {
      $record = fgets($file);
        
        /*if($s>10)
        {
            break;
        }*/
   
     
       
          $commodity = trim(substr($record, 0, 10));
          $descrip_1 = trim(substr($record, 14, 51));
          $descrip_2 = trim(substr($record, 69, 150));
          $quantity_1 = trim(substr($record, 224, 3));
          $quantity_2 = trim(substr($record, 232, 4));
          $sitc = trim(substr($record, 240, 6));
          $end_use = trim(substr($record, 250, 6));
          $usda = trim(substr($record, 260, 1));
          $naics = trim(substr($record, 265, 7));
          $hitech = trim(substr($record, 276, 2));
          
        /*  echo "Commodity:====>> $commodity <=====";
          echo "Description (Short)::====>> $descrip_1 <========";
          echo "Description (Long)::====>> $descrip_2 <========";
          echo "Unit of Quantity 1::====>> $quantity_1 <========";
          echo "Unit of Quantity 2::====>> $quantity_2 <========";
          echo "SITC Code::====>> $sitc <========";
          echo "End Use Classification::====>> $end_use <========";
          echo "USDA Product Code::====>> $usda <========";
          echo "NAICS Classification::====>> $naics <========";
          echo "HiTech Classification::====>> $hitech <========";*/
        
        


          $post_id = wp_insert_post(array(
            'post_type' => 'htc_code',
            'post_title' => $commodity,
            
            'post_status' => 'publish'
          ));
          
          // Add post meta
          add_post_meta($post_id, 'commodity', $commodity);
          add_post_meta($post_id, 'descrip_1', $descrip_1);
          add_post_meta($post_id, 'descrip_2', $descrip_2);
          add_post_meta($post_id, 'quantity_1', $quantity_1);
          add_post_meta($post_id, 'quantity_2', $quantity_2);
          add_post_meta($post_id, 'sitc', $sitc);
          add_post_meta($post_id, 'end_use', $end_use);
          add_post_meta($post_id, 'usda', $usda);
          add_post_meta($post_id, 'naics', $naics);
          add_post_meta($post_id, 'hitech', $hitech);
        
        $s++;
    }

        fclose($file);
        echo "Done";
        exit;
    }

}
add_action("init","upload_htc_code");








/*-------------------Auto Fill Fields---------------------------*/
include_once("acf/auto_fill_address.php");
include_once("acf/user_meta.php");

include_once("acf/htc_code_backend_filter.php");
include_once("acf/case_backend_filter.php");
include_once("acf/on_booking_voyage_dates.php");
include_once("acf/web_settings.php");
include_once("acf/shipment_pou_car.php");
include_once("acf/commodities_auto_fill.php");
include_once("acf/custom_dropdown.php");
include_once("acf/submit_house.php");




/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'themerex_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_theme_setup', 1 );
	function themerex_theme_setup() {

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );

        // Custom header setup
        add_theme_support( 'custom-header', array('header-text'=>false));

        // Custom backgrounds setup
        add_theme_support( 'custom-background');

        // Supported posts formats
        add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') );

        // Autogenerate title tag
        add_theme_support('title-tag');

        // Add user menu
        add_theme_support('nav-menus');

        // WooCommerce Support
        add_theme_support( 'woocommerce' );

        // Add wide and full blocks support
        add_theme_support( 'align-wide' );

		// Register theme menus
		add_filter( 'themerex_filter_add_theme_menus',		'themerex_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'themerex_filter_add_theme_sidebars',	'themerex_add_theme_sidebars' );

		// Set theme name and folder (for the update notifier)
		add_filter('themerex_filter_update_notifier', 		'themerex_set_theme_names_for_updater');
	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'themerex_add_theme_menus' ) ) {
	//Handler of add_filter( 'themerex_action_add_theme_menus', 'themerex_add_theme_menus' );
	function themerex_add_theme_menus($menus) {
		if (isset($menus['menu_side'])) unset($menus['menu_side']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'themerex_add_theme_sidebars' ) ) {
	//Handler of add_filter( 'themerex_filter_add_theme_sidebars',	'themerex_add_theme_sidebars' );
	function themerex_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'globallogistics' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'globallogistics' )
			);
			if (themerex_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'globallogistics' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}

// Set theme name and folder (for the update notifier)
if ( !function_exists( 'themerex_set_theme_names_for_updater' ) ) {
	//Handler of add_filter('themerex_filter_update_notifier', 'themerex_set_theme_names_for_updater');
	function themerex_set_theme_names_for_updater($opt) {
		$opt['theme_name']   = 'globallogistics';
		$opt['theme_folder'] = 'globallogistics';
		return $opt;
	}
}

// Add page meta to the head
if (!function_exists('themerex_head_add_page_meta')) {
    add_action('wp_head', 'themerex_head_add_page_meta', 1);
    function themerex_head_add_page_meta() {
        $theme_skin = sanitize_file_name(themerex_get_custom_option('theme_skin'));
        ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <?php
        if (themerex_get_theme_option('responsive_layouts') == 'yes') {
            ?>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <?php
        }
        ?>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php
        $favicon = themerex_get_custom_option('favicon');

        if (!$favicon) {
            if ( file_exists(themerex_get_file_dir('skins/'.($theme_skin).'/images/favicon.ico')) )
                $favicon = themerex_get_file_url('skins/'.($theme_skin).'/images/favicon.ico');
            if ( !$favicon && file_exists(themerex_get_file_dir('favicon.ico')) )
                $favicon = themerex_get_file_url('favicon.ico');
        }
        if ($favicon) {
            ?>
            <link rel="icon" type="image/x-icon" href="<?php echo esc_url($favicon); ?>" />
            <?php
        }
    }
}

// Add theme required plugins
if ( !function_exists( 'themerex_add_trx_addons' ) ) {
    add_filter( 'trx_addons_active', 'themerex_add_trx_addons' );
    function themerex_add_trx_addons($enable=true) {
        return true;
    }
}

// Return text for the Privacy Policy checkbox
if ( ! function_exists('themerex_get_privacy_text' ) ) {
    function themerex_get_privacy_text() {
        $page = get_option( 'wp_page_for_privacy_policy' );
        $privacy_text = themerex_get_theme_option( 'privacy_text' );
        return apply_filters( 'themerex_filter_privacy_text', wp_kses_post(
                $privacy_text
                . ( ! empty( $page ) && ! empty( $privacy_text )
                    // Translators: Add url to the Privacy Policy page
                    ? ' ' . sprintf( __( 'For further details on handling user data, see our %s', 'globallogistics' ),
                        '<a href="' . esc_url( get_permalink( $page ) ) . '" target="_blank">'
                        . __( 'Privacy Policy', 'globallogistics' )
                        . '</a>' )
                    : ''
                )
            )
        );
    }
}

// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'themerex_trx_addons_privacy_text' ) ) {
    add_filter( 'trx_addons_filter_privacy_text', 'themerex_trx_addons_privacy_text' );
    function themerex_trx_addons_privacy_text( $text='' ) {
        return themerex_get_privacy_text();
    }
}

if (!function_exists('themerex_param_is_off')) {
    function themerex_param_is_off($prm) {
        return empty($prm) || $prm===0 || in_array(themerex_strtolower($prm), array('false', 'off', 'no', 'none', 'hide'));
    }
}


/* Include framework core files
------------------------------------------------------------------- */

require_once( get_template_directory().'/fw/loader.php' );


function add_custom_admin_styles_for_hide_social_media() {
    ?>
    <style>
        /* Your custom styles here */
    </style>
    <?php
}
add_action('admin_head', 'add_custom_admin_styles_for_hide_social_media');



// function house_cars_select( $field ) {
//     // Check if this is the correct field
//     if( $field['name'] == 'selected_cars2' ) {
//         // Add a new choice
//         $field['choices']['new_value'] = 'New Label';
//     }

//     return $field;
// }

// add_filter('acf/load_field', 'house_cars_select');

include_once("acf/photo_task.php");

include_once("acf/loader_task.php");












add_action('rest_api_init', function () {
    register_rest_route('myplugin/v1', '/get_photo_tasks', array(
        'methods' => 'GET',
        'callback' => 'get_photo_tasks',
        'args' => array(
            'user_id' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                },
                'required' => false,
            ),
        ),
        'permissions_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));
});

function get_photo_tasks(WP_REST_Request $request) {
    

    global $wpdb;
    
    $user_id = $request->get_param('user_id');

    $user_id = $request->get_param('user_id');
    
    $search = $request->get_param('search');
    
    $offset = $request->get_param('offset') ?: 0;
    
    $per_page = $request->get_param('per_page') ?: 10;

    // Base SQL query
    $sql = "SELECT b.post_id, c.user_login, a.vin , a.tag_number
            FROM tr_photo_task b 
            LEFT JOIN tr_commodities a ON b.post_id = a.post_id  
            LEFT JOIN tr_users c ON b.user_id = c.ID";

    // Conditions
    $conditions = [];

    // User ID condition
    if (!empty($user_id)) {
        $conditions[] = $wpdb->prepare("b.user_id = %d", $user_id);
    }

    // Search condition
    if (!empty($search)) {
        $conditions[] = $wpdb->prepare("c.user_login LIKE %s", '%' . $wpdb->esc_like($search) . '%');
    }

    // Append conditions to SQL query
    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    // Add LIMIT clause for pagination
    $sql .= $wpdb->prepare(" LIMIT %d, %d", $offset, $per_page);

    // Execute query
    $tasks = $wpdb->get_results($sql);

    if (empty($tasks)) {
        return new WP_REST_Response(array('message' => 'No tasks found'), 404);
    }

    return new WP_REST_Response($tasks, 200);


}


function assign_commodity_task() {
    check_ajax_referer('commodity_assign_nonce', 'nonce');

    $user_id = isset($_POST['user_id']) ? absint($_POST['user_id']) : 0;
    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;

    if ($user_id && $post_id) {
        // Perform your logic to save the assignment
        global $wpdb;
        $table_name =  'tr_photo_task';
        

        $wpdb->query("delete from $table_name where post_id='$post_id' ");

        $wpdb->insert($table_name, array(
            'post_id' => $post_id,
            'user_id' => $user_id,
        ));

        echo 'Task assigned to ' . get_userdata($user_id)->display_name;
    } else {
        echo 'Invalid request';
    }

    wp_die();
}
add_action('wp_ajax_assign_commodity_task', 'assign_commodity_task');

?>

