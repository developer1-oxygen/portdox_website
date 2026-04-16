<?php 
add_action("admin_head",function (){

    ?>
    <script>
    jQuery(document).ready(function($) {
        // Attach a click event to the link that opens the popup
       $(document).on("click",'.house-popup',function(e) {

            e.preventDefault(); 
            var house_id = $(this).attr('house-id'); 
            var data22 = {
                'action': 'load_house_popup_content',
                'house_id': house_id
            };

            $.ajax({
                type: 'POST',
                url: ajaxurl,
               
                data: data22,
                beforeSend: function() {
                    $('#cboxLoadedContent').empty();
                    $('#cboxLoadingGraphic').show();
                },
                complete: function() {
                    $('#cboxLoadingGraphic').hide();
                },
                success: function(data) {                  
                    

                    jQuery.colorbox({
                        html:data,
                        width:"80%", height:"80%"
                    });
                    
                    setTimeout(function(){
                        jQuery("#cboxLoadingGraphic").hide();
                    },1000);

                    jQuery('#cboxLoadedContent').html(data);
                    jQuery('#cboxLoadedContent').css('visibility','visible');

                }
            });


        });
        $(document).on("click",'.car-popup',function(e) {

            e.preventDefault(); 
            var car_id = $(this).attr('car-id'); 
            var data22 = {
                'action': 'load_car_popup_content',
                'car_id': car_id
            };

            $.ajax({
                type: 'POST',
                url: ajaxurl,
               
                data: data22,
                beforeSend: function() {
                    $('#cboxLoadedContent').empty();
                    $('#cboxLoadingGraphic').show();
                },
                complete: function() {
                    $('#cboxLoadingGraphic').hide();
                },
                success: function(data) {                  
                    

                    jQuery.colorbox({
                        html:data,
                        width:"80%", height:"80%"
                    });
                    
                    setTimeout(function(){
                        jQuery("#cboxLoadingGraphic").hide();
                    },1000);

                    jQuery('#cboxLoadedContent').html(data);
                    jQuery('#cboxLoadedContent').css('visibility','visible');

                }
            });


        });

       

        $(document).on("click",'.genrate_shipment',function(e) {

            e.preventDefault(); 
            var car_id = $(this).attr('car-id'); 
            var data22 = {
                'action': 'load_genrate_shipment',
                'shipment_id':'<?php echo get_the_ID();?>'
                
            };

            $.ajax({
                type: 'POST',
                url: ajaxurl,
               
                data: data22,
                beforeSend: function() {
                    $('#cboxLoadedContent').empty();
                    $('#cboxLoadingGraphic').show();
                },
                complete: function() {
                    $('#cboxLoadingGraphic').hide();
                },
                success: function(data) {                  
                    

                    jQuery.colorbox({
                        html:data,
                        width:"80%", height:"80%"
                    });
                    
                    setTimeout(function(){
                        jQuery("#cboxLoadingGraphic").hide();
                    },1000);

                    jQuery('#cboxLoadedContent').html(data);
                    jQuery('#cboxLoadedContent').css('visibility','visible');

                }
            });


        });




      

       
    });
    </script>


    <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.colorbox-min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/colorbox.css">
  <!--   <script>
        jQuery(document).ready(function(){
            //Examples of how to assign the Colorbox event to elements
            jQuery(".group1").colorbox({rel:'group1'});
            jQuery(".group2").colorbox({rel:'group2', transition:"fade"});
            jQuery(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
            jQuery(".group4").colorbox({rel:'group4', slideshow:true});
            jQuery(".ajax").colorbox();
            jQuery(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
            jQuery(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
            jQuery(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
            jQuery(".inline").colorbox({inline:true, width:"50%"});
            jQuery(".callbacks").colorbox({
                onOpen:function(){ alert('onOpen: colorbox is about to open'); },
                onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
                onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
                onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
                onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
            });

            jQuery('.non-retina').colorbox({rel:'group5', transition:'none'})
            jQuery('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
            
            //Example of preserving a JavaScript event for inline calls.
            jQuery("#click").click(function(){ 
                jQuery('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                return false;
            });
        });
    </script> -->
    <?php
});
add_filter( 'manage_shipment_posts_columns', 'add_shipment_house_column_header' );
function add_shipment_house_column_header( $columns ) {
    $columns['house'] = 'House';
    return $columns;
}

// Populate the column with data
add_action( 'manage_shipment_posts_custom_column', 'add_shipment_house_column_data', 10, 2 );
function add_shipment_house_column_data( $column_name, $post_id ) {
     if ( $column_name === 'house' ) {
        global $wpdb;
        $results = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT post_id FROM tr_house_info WHERE shipment LIKE %s",
                '%' . $post_id . '%'
            )
        );
    
        if ( ! empty( $results ) ) {
            
            foreach($results  as $val2)
            {
                echo '<a href="#" class="house-popup" house-id="' . $val2 . '">'.get_the_title($val2).'</a> | ';
            }
            
        } else {
            echo '<p>No House Found.</p>';
        }
    }
}

add_action( 'add_meta_boxes', 'add_shipment_metabox' );


add_action( 'admin_enqueue_scripts', 'add_shipment_popup_scripts' );
function add_shipment_popup_scripts( $hook_suffix ) {
    global $post_type;
      
    wp_enqueue_script( 'shipment-popup-script', '', array( 'jquery' ), '', true );
    wp_add_inline_script( 'shipment-popup-script', "" );
    
}



add_action( 'wp_ajax_load_house_popup_content', 'load_house_popup_content' );
function load_house_popup_content() {
    // Retrieve the post IDs from the AJAX request
    $house_id = isset( $_POST['house_id'] ) ? sanitize_text_field( $_POST['house_id'] ) : '';

    // Output the popup content
    echo '<div class="house-popup-content">';
    if ( ! empty( $house_id ) ) {
   
            global $wpdb;   
            $house_title = get_the_title( $house_id );
            $house_content = get_the_content( $house_id );
            echo '<h2>Title: ' . $house_title . '</h2>';
            echo '<div>' ;

            $already_selected_car = get_field_new('selected_cars2', $house_id , 'tr_house_info' );
            $already_selected_car = explode(",",$already_selected_car);

            $car_in_shipment_str  = implode('","',$already_selected_car);


            $query      =   'select * from tr_commodities where post_id in("'.$car_in_shipment_str.'")  ';
                  
            $res3       =   $wpdb->get_results($query,ARRAY_A);

            $vin_values = array();

            if(count($res3)>0)
            {
                ?>
                <h3>Product Info</h3>
                <style> 
                            
                    .border_1px_solid2{border-collapse: collapse;margin-top:10px; width: 100%;  }
                    
                    .border_1px_solid2 td,
                    .border_1px_solid2 th{ border:1px dotted #ccc; cellpadding:0px;  padding:5px  }
                    
                </style>
                <table  class="border_1px_solid2"  > 
                    <tr> 
                       
                        <th>Vin</th> 
                        <th>Make</th> 
                        <th>Model</th> 
                        <th>Year</th> 
                        <th>Case</th> 
                        <th>POL</th> 
                        <th>POD</th> 
                    </tr>
                
                <?php
                foreach ($res3 as $product2) 
                {
                    
                    $vin        = $product2['vin'];

                    $post_id    = $product2['post_id'];

                    
                    $field_name = 'product_info';
                    $commodity_id =  $post_id;
                    $results = $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value LIKE %s",
                            $field_name,
                            '%"'.$commodity_id.'"%'
                        )
                    );
                    $titles = array();
                    foreach ($results as $result) {
                        $post = get_post($result->post_id);
                        if ($post) {
                            $titles[] = $post->post_title;
                        }
                    }
                    $cases_string = implode(', ', $titles);
                    
                    $pol = json_decode($product2['pol']);
                    $pod = json_decode($product2['pod']); 


                    $inline_data_string  = ' data_pol="'.$pol[0].'"   data_pod="'.$pod[0].'" ';



                    ?>
                    <tr >
                       
                        <td><?php echo $product2['vin'] ?></td>
                        <td><?php echo $product2['make'] ?></td>
                        <td><?php  echo $product2['model'] ?></td>
                        <td><?php echo $product2['year'] ?></td>
                        <td><?php echo $cases_string; ?></td>
                        <td><?php echo get_the_title($pol[0]); echo "(".$pol[0].")"; ?></td>
                        <td><?php echo get_the_title($pod[0]); echo "(".$pod[0].")";?></td>

                    </tr>
                    <?php

                   
                    
                }
                ?>
                </table>

                <?php


            }
            echo  '</div>';
            
            $shipper_name       = get_field_new('shipper_shipper_name', $house_id , 'tr_house_info' );
            $shipper_address    = get_field_new('shipper_shipper_address', $house_id , 'tr_house_info' );

            $consignee_name     = get_field_new('consignee_consignee', $house_id , 'tr_house_info' );
            $consignee_address  = get_field_new('consignee_consignee_address', $house_id , 'tr_house_info' );

            $shipper_detail     = get_user_by( 'id', $shipper_name );
            $consignee_detail   = get_user_by( 'id', $consignee_name );
            //print_r($shipper_detail);
            $aa = $shipper_detail->data->display_name;
            $bb = $consignee_detail->data->display_name;

            ?>
            <h3><?php if($aa!=""){echo "Shipper Name: ".($aa);}?></h3>
            <h3><?php if($shipper_address!=""){echo "Shipper Address: ".$shipper_address;}?></h3>
            <h3><?php if($bb!=""){echo "Consignee Name: ".$bb;} ?></h3>
            <h3><?php if($consignee_address!=""){echo "Consignee Address: ".$consignee_address;}?></h3>
            <?php


    } else {
        echo '<p>No House Found.</p>';
    }
    echo '</div>';

    wp_die(); // This is required to terminate immediately and return a proper response
}





add_action( 'wp_ajax_load_car_popup_content', 'load_car_popup_content' );
function load_car_popup_content() {
    // Retrieve the post IDs from the AJAX request
    $car_id = isset( $_POST['car_id'] ) ? sanitize_text_field( $_POST['car_id'] ) : '';

    // Output the popup content
    echo '<div class="car-popup-content">';
    if ( ! empty( $car_id ) ) {
   
            global $wpdb;   
            $car_title = get_the_title( $car_id );
            
            echo '<h2>Title: ' . $car_title . '</h2>';
            echo '<div>' ;

            

            $query      =   "select * from tr_commodities where post_id in(".$car_id.")  and ready_to_export='1' ";

            $res3       =   $wpdb->get_results($query,ARRAY_A);

            $vin_values = array();
            
            if(count($res3)>0)
            {
                ?>
                <style> 
                    
                    .border_1px_solid{border-collapse: collapse;margin-top:10px; width: 100%;}
                    
                    .border_1px_solid td,
                    .border_1px_solid th{ border:1px dotted #ccc; cellpadding:0px;  padding:5px  }
                    
                </style>
                <table  class="border_1px_solid" > 
                
                
                <?php
                foreach ($res3 as $product2) 
                {
                    
                    $vin        = $product2['vin'];

                    $post_id    = $product2['post_id'];
                    

                    $checked='';
                    if(in_array($post_id,$already_selected_car))
                    {
                        $checked='checked';
                    }   
                    ?>
                    <tr >
                        <th>Vin Number</th>
                        <td><?php echo $product2['vin'] ?></td>
                    </tr>
                    <tr>
                        <th>Maker</th>
                        <td><?php echo $product2['make'] ?></td>
                    </tr>
                    <tr>
                        <th>Model</th>
                        <td><?php  echo $product2['model'] ?></td>
                    </tr>
                    <tr>
                        <th>Year</th>
                        <td><?php echo $product2['year'] ?></td>
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
            echo  '</div>';
            
            
           


    } else {
        echo '<p>No Car Found.</p>';
    }
    echo '</div>';

    wp_die(); // This is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_load_genrate_shipment', 'load_genrate_shipment' );
function load_genrate_shipment() {
    // Retrieve the post IDs from the AJAX request
    
    $car_id = isset( $_POST['car_id'] ) ? sanitize_text_field( $_POST['car_id'] ) : '';
    
    
    #$main_post_id = $_POST['main_post_id'];
    #$shipment     = $_POST['shipment'];

    $main_post_id = "";
    
    $shipment     = $_POST['shipment_id'];

    global $wpdb;
    

    $car_in_shipment = get_field_new('ocean_export_booking_selected_cars', $shipment , 'tr_shipment_info' );

   
    if($car_in_shipment!="")
    {

        
        $car_in_shipment_str  = ''.implode('","', explode(",",$car_in_shipment) ).'';

      


        $houses = $wpdb->get_results(" SELECT * FROM tr_house_info WHERE 1 ", ARRAY_A);

        $commodity_not_include_cond     = '';
        $commodity_not_include_ar       = [];

        foreach($houses as $h)
        {
            
            $selected_cars2 =explode(",",$h['selected_cars2']);
            foreach($selected_cars2 as $cc)
            {
                $commodity_not_include_ar[] = $cc;
            }
            
        }
        array_unique($commodity_not_include_ar);
        #print_r($commodity_not_include_ar);
        if(count($commodity_not_include_ar)>0)
        {
            $commodity_not_include_cond     = ' and post_id not in("'.implode('","',$commodity_not_include_ar).'")';
        }

        #echo $commodity_not_include_cond ."<<<=====";

        

        $query      =   'select * from tr_commodities where post_id in("'.$car_in_shipment_str.'")   '.$commodity_not_include_cond ;
        
        $res3       =   $wpdb->get_results($query,ARRAY_A);

        $vin_values = array();
        
    


        $grouped_rows = array();

        foreach ($res3 as $product2) {
            // Get the buyer and seller values for the current row



            $post_id   = $product2['post_id'];

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


         

            // Create a key for the associative array using the buyer and seller values
            $key = $buyer_name . '-' . $seller_name;

            // If the key does not exist in the array, initialize it with an empty array
            if (!isset($grouped_rows[$key])) {
                $grouped_rows[$key] = array();
            }

            // Add the current row to the array with the appropriate key
            $grouped_rows[$key][] = $product2;
        }

        if (count($grouped_rows) > 0) {
            ?>
            <table class="border_1px_solid">
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
                foreach ($grouped_rows as $key=>$rows) {
                    // Get the buyer and seller values from the first row of the group
                    //echo "<pre>";print_r(); echo '</pre>';
                    $temp           =   explode("-",$key);
                    $buyer_name2    =   ($temp[0]);
                    $seller_name2   =   ($temp[1]);
                    
                    $buyer_name2    =   get_user_by( 'id', $buyer_name2 );
                    $seller_name2    =   get_user_by( 'id', $seller_name2 );
                    

                    foreach ($rows as $product2) {
                       
                        $cases_string = ''; 
                       
                        $vin        = $product2['vin'];

                        $post_id    = $product2['post_id'];

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
                        <tr>
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
                    

                    <tr>
                        <td colspan="10">

                            <?php
                            $seleced_cars_ar    =   array();
                            $house_buyer        =   '';
                            $house_seller       =   '';

                            foreach ($rows as $product2) 
                            {
                                $selected_car_ar[]  =   $product2['post_id'];
                                
                            }
                            
                            $house_buyer          =   $buyer_name;
                            
                            $house_seller         =   $seller_name;


                            $value1 = get_user_meta( $house_buyer, 'address', true );
                            $value2 = get_user_meta( $seller_name, 'address', true );
   

                            $house_buyer_address  = $value1;
                            $house_seller_address = $value2;

                         

                            $selected_cars_str    =    implode(",",$selected_car_ar);
                            ?>
                            <strong>Buyer:</strong> <?php echo $buyer_name2->display_name; ?>, 
                            <strong>Seller:</strong> <?php echo $seller_name2->display_name; ?>
                            <form >
                                <input type="hidden" name="action" value="create_house">
                                <button href="#" class="create_house" style="">Create House</button>
                                <div style="display:none">
                                    <br>selected_car_for_house<input name="selected_car_for_house" value="<?php echo $selected_cars_str;?>">
                                   <br> shipment_id<input name="shipment_id" value="<?php echo $shipment ;?>">
                                    <br>house_buyer<input name="house_buyer" value="<?php echo $house_buyer;?>">
                                    <br>house_seller<input name="house_seller" value="<?php echo $house_seller;?>">

                                    <br>house_buyer_address<input name="house_buyer_address" value="<?php echo $house_buyer_address;?>">
                                    <br>house_seller_address<input name="house_seller_address" value="<?php echo $house_seller_address;?>">
                                </div>
                            </form>
                        </td>
                        
                        
                      

                    </tr>
                    <?php

                }
                ?>
            </table>
            <?php
        } else {
            echo 'No available cars might house already genrated ';
        }






    }
    else
    {
         echo 'No available cars';
    }
    exit;
}



// Add the metabox function
function add_shipment_metabox() {
    add_meta_box(
        'shipment_metabox',
        'Shipment Details',
        'shipment_metabox_callback',
        'shipment',
        'normal',
        'high'
    );
}

// The callback function that displays the metabox content
function shipment_metabox_callback( $post ) {
    // Retrieve the meta data value if it exists
    $shipment_tracking_number = get_post_meta( $post->ID, 'shipment_tracking_number', true );

 
    wp_nonce_field( 'shipment_metabox_nonce', 'shipment_metabox_nonce' );

    // Retrieve the list of post IDs from tr_house_info table
    global $wpdb;
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT post_id, selected_cars FROM tr_house_info WHERE shipment LIKE %s",
            '%' . $post->ID. '%'
        )
    );

    // Display the list of post IDs in a table
    if ( ! empty( $results ) ) {
        ?>
        <style>
        table.shipment-houses {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table.shipment-houses td,table.shipment-houses th {
            padding: 3px;
            border: 1px solid black;
        }
        </style>
        <?php
        echo '<table class="shipment-houses" >
                    <thead><tr>
                                <th>House ID</th>
                                <th>House Title</th>
                                <th>Selected Cars</th>
                            </tr>
                    </thead>

                    <tbody>';
        foreach ( $results as $result ) {
            echo '  <tr> 
                        <td>' . $result->post_id . '</td>
                        <td>'.'<a href="#" class="house-popup" house-id="' .$result->post_id . '">' . get_the_title($result->post_id) . '</a></td>
                        <td>';
                        if($result->selected_cars!="")
                        {
                            echo '<a href="#" class="car-popup" car-id="' .$result->selected_cars . '">' . get_the_title($result->selected_cars).'</a>' ;
                        }
                        
                        echo '</td>
                    </tr>';
        }
        echo '</tbody></table><br>';
    } else {
        echo '<p>No House found.</p>';
    }

 	?>
 	<script type="text/javascript">

	jQuery(document).ready(function($) {
	    $('#download-pdf-button').click(function(e) {
	   
	      
	        $.ajax({
	            "type": 'post',
	            "url": '<?php echo admin_url( 'admin-ajax.php' ) ;?>',

	            "data": {
	                "action": 'download_pdf',
                    "post_id":"<?php echo $post->ID;?>"
	            },
	            success: function(data2) {
	                var url = $(data2).attr('href');
                    if(url)
                    {
                      window.open(url, '_blank');
                    }
	                else
                    {
                        alert("no pdf link");
                    }
                }
	        });
	    });


        jQuery(document).on('click','.create_house', function(event) {

            event.preventDefault(); // Prevent the default form submission
            jQuery(this).prop("disabled",true);
            jQuery(this).html("Please wait");
            var form = jQuery(this).parents('form'); // Get the form element
            var formData = form.serialize(); // Serialize the form data
            jQuery.ajax({
            url: '<?php echo admin_url( 'admin-ajax.php' ) ;?>', // Specify the server-side script URL here
            type: 'POST',
            data: formData, // Send the serialized form data to the server
            success: function(response) {
                // Handle the server response here
                jQuery(this).html("Create House");
                jQuery(this).prop("disabled",false);
                alert("House Created");
                jQuery(".genrate_shipment").click();
                console.log(response);
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle any AJAX errors here
                console.log(errorThrown);
            }
            });
        });
	});
 	</script>
 	<?php
    echo '<button type="button" id="download-pdf-button">Download PDF</button>';
    echo '<div class="resp" style="display:none1"></div>';
}

// Hook into the save post action
add_action( 'save_post', 'save_shipment_metabox' );

// Save the metabox data
function save_shipment_metabox( $post_id ) {
    // Verify the nonce
    if ( !isset( $_POST['shipment_metabox_nonce'] ) || !wp_verify_nonce( $_POST['shipment_metabox_nonce'], 'shipment_metabox_nonce' ) ) {
        return;
    }

    // Save the meta data
    if ( isset( $_POST['shipment_tracking_number'] ) ) {
        update_post_meta( $post_id, 'shipment_tracking_number', sanitize_text_field( $_POST['shipment_tracking_number'] ) );
    }
}




// Handle the AJAX request
function download_pdf() {
  
    $post_id = $_REQUEST['post_id'];


    echo do_shortcode('[e2pdf-download id="5" dataset="'.$post_id.'"]');

    exit;
}
add_action( 'wp_ajax_download_pdf', 'download_pdf' );
add_action( 'wp_ajax_nopriv_download_pdf', 'download_pdf' );


?>