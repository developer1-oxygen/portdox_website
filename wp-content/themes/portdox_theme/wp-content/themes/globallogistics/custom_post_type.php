<?php 

// function create_posttype() {
//   register_post_type( 'case',
//     array(
//       'labels' => array(
//         'name' => __( 'Cases' ),
//         'singular_name' => __( 'Case' )
//       ),
//       'public' => true,
//       'has_archive' => true,
//       'rewrite' => array('slug' => 'cases'),
//     )
//   );
// }
// add_action( 'init', 'create_posttype' );

/*====================================HTC Code===========================================================*/
function create_posttype2() {
  register_post_type( 'htc_code',
    array(
      'labels' => array(
        'name' => __( 'HTC Code' ),
        'singular_name' => __( 'htc_code' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'htc_code'),
    )
  );
}
add_action( 'init', 'create_posttype2' );


function add_htc_code_columns($columns) {
    $columns['commodity'] = 'Commodity';
    $columns['descrip_1'] = 'Descrip_1';
    $columns['end_use'] = 'End Use';
    $columns['usda'] = 'USDA';
    $columns['naics'] = 'NAICS';
    $columns['hitech'] = 'HiTech';
    return $columns;
}
add_filter('manage_htc_code_posts_columns', 'add_htc_code_columns');


function show_htc_code_columns($name) {
    global $post;

    switch ($name) {
        case 'commodity':
            $commodity = get_post_meta($post->ID, 'commodity', true);
            echo $commodity;
            break;
        case 'descrip_1':
            $descrip_1 = get_post_meta($post->ID, 'descrip_1', true);
            echo $descrip_1;
            break;
        case 'end_use':
            $end_use = get_post_meta($post->ID, 'end_use', true);
            echo $end_use;
            break;
        case 'usda':
            $usda = get_post_meta($post->ID, 'usda', true);
            echo $usda;
            break;
        case 'naics':
            $naics = get_post_meta($post->ID, 'naics', true);
            echo $naics;
            break;
        case 'hitech':
            $hitech = get_post_meta($post->ID, 'hitech', true);
            echo $hitech;
            break;
    }
}
add_action('manage_htc_code_posts_custom_column', 'show_htc_code_columns');




/*====================================HTC commodities===========================================================*/
function create_posttype13() {
  register_post_type( 'commodities',
    array(
      'labels' => array(
        'name' => __( 'Commodities' ),
        'singular_name' => __( 'commodities' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'commodities'),
    )
  );
}
add_action( 'init', 'create_posttype13' );




/*====================================HTC commodities===========================================================*/
function create_posttype15() {
  register_post_type( 'country_of_dist',
    array(
      'labels' => array(
        'name' => __( 'Country Of Dist' ),
        'singular_name' => __( 'country of dist' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'country_of_dist'),
    )
  );
}
add_action( 'init', 'create_posttype15' );



/*====================================HTC Shipment===========================================================*/
function create_posttype3() {
  register_post_type( 'shipment',
    array(
      'labels' => array(
        'name' => __( 'Shipment' ),
        'singular_name' => __( 'shipment' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'shipment'),
    )
  );
}
add_action( 'init', 'create_posttype3' );


/*====================================Shipment===========================================================*/
function create_shipment() {
  register_post_type( 'House',
    array(
      'labels' => array(
        'name' => __( 'House' ),
        'singular_name' => __( 'house' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'house'),
    )
  );
}

add_action( 'init', 'create_shipment' );

/*====================================booking ===========================================================*/
function create_posttype4() {
  register_post_type( 'booking',
    array(
      'labels' => array(
        'name' => __( 'Booking' ),
        'singular_name' => __( 'Booking' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'booking'),
    )
  );
}
add_action( 'init', 'create_posttype4' );

/*====================================Freight Forwarder===========================================================*/
function create_posttype5() {
  register_post_type( 'freight_forwarder',
    array(
      'labels' => array(
        'name' => __( 'Freight Forwarder' ),
        'singular_name' => __( 'Freight_Forwarder' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'freigh_forwarder'),
    )
  );
}
add_action( 'init', 'create_posttype5' );


/*====================================OceanCarriers===========================================================*/
function create_posttype6() {
  register_post_type( 'ocean_carriers',
    array(
      'labels' => array(
        'name' => __( 'Ocean Carriers' ),
        'singular_name' => __( 'ocean_carriers' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'ocean_carriers'),
    )
  );
}
add_action( 'init', 'create_posttype6' );



/*====================================Voyage information ===========================================================*/
function create_posttype9() {
  register_post_type( 'voyage',
    array(
      'labels' => array(
        'name' => __( 'Voyage' ),
        'singular_name' => __( 'voyage' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'voyage'),
    )
  );
}
add_action( 'init', 'create_posttype9' );


/*====================================Vessel name===========================================================*/
function create_posttype8() {
  register_post_type( 'vessel_name',
    array(
      'labels' => array(
        'name' => __( 'Vessel Name' ),
        'singular_name' => __( 'Vessel_Name' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'vessel_name'),
    )
  );
}
add_action( 'init', 'create_posttype8' );

/*====================================POL===========================================================*/
function create_posttype11() {
  register_post_type( 'pol',
    array(
      'labels' => array(
        'name' => __( 'POL' ),
        'singular_name' => __( 'pol' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'pol'),
    )
  );

 


}
add_action( 'init', 'create_posttype11' );

/*====================================POL===========================================================*/
function create_posttype12() {
  register_post_type( 'pou',
    array(
      'labels' => array(
        'name' => __( 'POU' ),
        'singular_name' => __( 'pou' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'pou'),
    )
  );


  //  $args = array(
  //     'post_type' => 'pou',
  //     'posts_per_page' => -1 // retrieve all posts
  // );

  // $query = new WP_Query($args);

  // if ($query->have_posts()) {
  //     while ($query->have_posts()) {
  //         $query->the_post();
  //         $content = get_the_content();
  //         update_post_meta(get_the_ID(), 'port_code', $content);
  //     }
  // }

  // wp_reset_postdata();

  
}

add_action( 'init', 'create_posttype12' );

/*====================================Email Notification===========================================================*/
function create_posttype14() {
  
  register_post_type( 'email_notification',
    array(
      'labels' => array(
        'name' => __( 'Email Notification' ),
        'singular_name' => __( 'email_notification' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'email_notification'),
    )
  );

}
add_action( 'init', 'create_posttype14' );



function remove_texteditor_from_case() {
    remove_post_type_support( 'case', 'editor' );
    remove_post_type_support( 'htc_code', 'editor' );
    remove_post_type_support( 'shipment', 'editor' );

  //  remove_post_type_support( 'pol', 'editor' );
 //   remove_post_type_support( 'pou', 'editor' );
    remove_post_type_support( 'voyage', 'editor' );
    remove_post_type_support( 'ocean_carriers', 'editor' );
    remove_post_type_support( 'freigh_forwarder', 'editor' );

    remove_post_type_support( 'commodities', 'editor' );
    remove_post_type_support( 'house', 'editor' );

    

}
add_action( 'init', 'remove_texteditor_from_case' );


function remove_revslider_metabox() {
    remove_meta_box( 'slider_revolution_metabox', 'case', 'normal' );
}
add_action( 'do_meta_boxes', 'remove_revslider_metabox' );




/*====================================HTC Code===========================================================*/




?>