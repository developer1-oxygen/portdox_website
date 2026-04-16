<?php

function custom_acf_admin_styles() {
    echo '<style>.group-col {width: 45%; float: left;}    </style>';


    global $post_type;
    if ($post_type == 'case') {
        echo '<style>.field_63e8a972a4f0e > span{ width: 100%; }</style>';
    }


  ?>
  <script type="text/javascript"> 
    jQuery(document).ready(function($) {
        $(document).on('change','#pol_address select', function() {
            var pol_id = $(this).val();
            if (pol_id) {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'get_all_pol_posts',
                        pol_id: pol_id,
                    },
                    success: function(response) {
                        // Handle the response (update content, etc.)
                    }
                });
            }
        });        
        /*

		jQuery(".acf-label").each(function(){
		    var abc  = jQuery(this).find(".description").html();
		    var temp = abc.split("##");
		    if(temp.length>1)
		    {
		        
		    }
		    
		});

        */
         $(document).on('change','[data-name="shipper_name"] select', function() {
            var user_id = $(this).val();
            
            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'load_user_address',
                    user_id: user_id
                },
                type: 'post',
                success: function(data) {
                    
                    $('[data-name="shipper_address"] textarea').val(data.data);
                }
            });
        });
        
        $(document).on('change','[data-name="consignee_name"] select', function() {
            var user_id = $(this).val();
            
            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'load_user_address',
                    user_id: user_id
                },
                type: 'post',
                success: function(data) {
                    
                    $('[data-name="consignee_address"] textarea').val(data.data);
                }
            });
        });

        $(document).on('change','[data-name="s_name"] select', function() {
            var user_id = $(this).val();
            
            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'load_user_address',
                    user_id: user_id
                },
                type: 'post',
                success: function(data) {
                    
                    $('[data-name="s_address"] textarea').val(data.data);
                }
            });
        });


        $(document).on('change','[data-name="carrier"] select', function() {
            var user_id = $(this).val();
            
            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'load_carrier_data',
                    user_id: user_id
                },
                type: 'post',
                success: function(data) {
                 
                    $('[data-name="driver_name"] input').val(data.data.driver_name);
                    $('[data-name="pro_number"] input').val(data.data.pro_number);
                    $('[data-name="driver_license_number"] input').val(data.data.driver_license_number);
                    $('[data-name="tracking_number"] input').val(data.data.tracking_number);
                }
            });
        });


    });



    (function($) {

        $(document).ready(function() {
            function check_seller()
            {
                var selectedValue = jQuery('input[name="acf[field_63e008a93122a][field_643c5bbde0135]"]:checked').val();
  
                if (selectedValue== "yes") 
                { 
                  
                    var partnerval = jQuery('#acf-field_63e008a93122a-field_63ef356f1227d').val();
                    var selectedOptionText = jQuery('#acf-field_63e008a93122a-field_63ef356f1227d option:selected').text();
                    
                    var select2Dropdown = $('#acf-field_63e73109f6c81');

                    select2Dropdown.append('<option value="'+partnerval+'">'+selectedOptionText+'</option>');

                    select2Dropdown.trigger('change.select2');

                    jQuery('#acf-field_63e73109f6c81').val(partnerval).trigger('change');
                    

                    jQuery('#acf-field_63e73109f6c81').prop('disabled', true);
                
                }
                else
                {
                   jQuery('#acf-field_63e73109f6c81').prop('disabled', false);     
                }
            }
            $('input[name="acf[field_63e008a93122a][field_643c5bbde0135]"]').change(function() {
               check_seller();
            });
            jQuery('#acf-field_63e008a93122a-field_63ef356f1227d').on('change', function() {
                check_seller();
            });
            setInterval(function (){
                check_seller();
            },2000);
        });


        $(document).ready(function() {



           
            var addButton = '<button class="add-new-user button" style="margin-bottom:10px;float:right;margin-right:10px;">Add New User</button>';

            var editButton = '<button class="edit-user button" style="margin-bottom:10px;float:right;margin-right:10px;">Edit User</button>';

            $('[data-name="partner"]').after("<div user_dd_name='partner' > "+addButton+editButton+" </div>");


            
            
            $('.add-new-user').on('click', function() {
                
                
                var url = '<?php echo admin_url("user-new.php"); ?>';
                window.open(url, 'Add New User', 'width=600,height=400');
                return false;

            });

            $('.add-new-user').on('click', function() {
                
                
                var url = '<?php echo admin_url("user-new.php"); ?>';
                window.open(url, 'Add New User', 'width=800,height=500');
                return false;

            });

            $('.edit-user').on('click', function() {
                
                var user_dd_name = jQuery(this).parent().attr('user_dd_name');
                
                
                var selected_user = jQuery('[data-name="'+user_dd_name+'"] select').val();    

                if(selected_user>0)
                {
                    var url = '<?php echo site_url();?>/wp-admin/user-edit.php?user_id='+selected_user;
                    window.open(url, 'Add New User', 'width=800,height=500');

                }
                else
                {
                    alert("Please select user");

                }
                return false;

            });


        });
    })(jQuery);



  </script>
  <?php
}

add_action('acf/input/admin_head', 'custom_acf_admin_styles');




function load_user_address() {
    $user_id = $_POST['user_id'];
    #$user = get_user_by('id', $user_id);
    
   
    $value = get_user_meta( $user_id, 'address', true );
   
    $value = $value;

    wp_send_json_success($value);
   

}
add_action('wp_ajax_load_user_address', 'load_user_address');

function load_carrier_data() {
    $user_id = $_POST['user_id'];
    #$user = get_user_by('id', $user_id);
    
   
    $driver_name 			= get_user_meta( $user_id, 'driver_name', true );
    $pro_number 			= get_user_meta( $user_id, 'pro_number', true );
    $driver_license_number = get_user_meta( $user_id, 'driver_license_number', true );
    $tracking_number 		= get_user_meta( $user_id, 'tracking_number', true );

	$data['driver_name']			=	$driver_name;
	$data['pro_number']				=	$pro_number;
	$data['driver_license_number']	=	$driver_license_number;
	$data['tracking_number']		=	$tracking_number;

    wp_send_json_success($data);
   

}
add_action('wp_ajax_load_carrier_data', 'load_carrier_data');




add_filter('acf/render_field/type=user', 'acf_add_data_target', 10, 1);

function acf_add_data_target($field) {
  $field['wrapper']['data-target'] = $field['name'] . '_target222';
  return $field;
}

?>