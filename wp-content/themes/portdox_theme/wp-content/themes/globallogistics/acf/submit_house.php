<?php



add_action("init",function (){


	if (@$_GET['iamdev8']=="ok") 
	{
		

		global $wpdb;

		$res = $wpdb->get_results("select * from tr_posts where post_type='pol' limit 0,1000000 ",ARRAY_A);
		
		foreach ($res as $key => $value) {
		
			
			$id = $value['ID'];
			$port_code = get_post_meta($id,"port_code",true);
			$query = "update tr_pol_pod set port_code='".$port_code."' where post_id='".$id."' ";

			echo "<pre>".$query."</pre>";

			#$wpdb->query($query);

			echo "<pre>";echo $id."===";print_r($port_code); echo "</pre>";
		
		} 
		exit;
	}


});

function getCountryCode($countryName)
{
    // Define an array mapping country names to country codes
    $countryCodes = [
        'Afghanistan' => 'AF',
        'Albania' => 'AL',
        'Algeria' => 'DZ',
        'Andorra' => 'AD',
        'Angola' => 'AO',
        'Antigua and Barbuda' => 'AG',
        'Argentina' => 'AR',
        'Armenia' => 'AM',
        'Australia' => 'AU',
        'Austria' => 'AT',
        'Azerbaijan' => 'AZ',
        'Bahamas' => 'BS',
        'Bahrain' => 'BH',
        'Bangladesh' => 'BD',
        'Barbados' => 'BB',
        'Belarus' => 'BY',
        'Belgium' => 'BE',
        'Belize' => 'BZ',
        'Benin' => 'BJ',
        'Bhutan' => 'BT',
        'Bolivia' => 'BO',
        'Bosnia and Herzegovina' => 'BA',
        'Botswana' => 'BW',
        'Brazil' => 'BR',
        'Brunei' => 'BN',
        'Bulgaria' => 'BG',
        'Burkina Faso' => 'BF',
        'Burundi' => 'BI',
        'Cambodia' => 'KH',
        'Cameroon' => 'CM',
        'Canada' => 'CA',
        'Cape Verde' => 'CV',
        'Central African Republic' => 'CF',
        'Chad' => 'TD',
        'Chile' => 'CL',
        'China' => 'CN',
        'Colombia' => 'CO',
        'Comoros' => 'KM',
        'Congo, Democratic Republic of the' => 'CD',
        'Congo, Republic of the' => 'CG',
        'Costa Rica' => 'CR',
        'Croatia' => 'HR',
        'Cuba' => 'CU',
        'Cyprus' => 'CY',
        'Czech Republic' => 'CZ',
        'Denmark' => 'DK',
        'Djibouti' => 'DJ',
        'Dominica' => 'DM',
        'Dominican Republic' => 'DO',
        'East Timor (Timor-Leste)' => 'TL',
        'Ecuador' => 'EC',
        'Egypt' => 'EG',
        'El Salvador' => 'SV',
        'Equatorial Guinea' => 'GQ',
        'Eritrea' => 'ER',
        'Estonia' => 'EE',
        'Eswatini' => 'SZ',
        'Ethiopia' => 'ET',
        'Fiji' => 'FJ',
        'Finland' => 'FI',
        'France' => 'FR',
        'Gabon' => 'GA',
        'Gambia' => 'GM',
        'Georgia' => 'GE',
        'Germany' => 'DE',
        'Ghana' => 'GH',
        'Greece' => 'GR',
        'Grenada' => 'GD',
        'Guatemala' => 'GT',
        'Guinea' => 'GN',
        'Guinea-Bissau' => 'GW',
        'Guyana' => 'GY',
        'Haiti' => 'HT',
        'Honduras' => 'HN',
        'Hungary' => 'HU',
        'Iceland' => 'IS',
        'India' => 'IN',
        'Indonesia' => 'ID',
        'Iran' => 'IR',
        'Iraq' => 'IQ',
        'Ireland' => 'IE',
        'Israel' => 'IL',
        'Italy' => 'IT',
        'Jamaica' => 'JM',
        'Japan' => 'JP',
        'Jordan' => 'JO',
        'Kazakhstan' => 'KZ',
        'Kenya' => 'KE',
        'Kiribati' => 'KI',
        'Korea, North' => 'KP',
        'Korea, South' => 'KR',
        'Kosovo' => 'XK',
        'Kuwait' => 'KW',
        'Kyrgyzstan' => 'KG',
        'Laos' => 'LA',
        'Latvia' => 'LV',
        'Lebanon' => 'LB',
        'Lesotho' => 'LS',
        'Liberia' => 'LR',
        'Libya' => 'LY',
        'Liechtenstein' => 'LI',
        'Lithuania' => 'LT',
        'Luxembourg' => 'LU',
        'Madagascar' => 'MG',
        'Malawi' => 'MW',
        'Malaysia' => 'MY',
        'Maldives' => 'MV',
        'Mali' => 'ML',
        'Malta' => 'MT',
        'Marshall Islands' => 'MH',
        'Mauritania' => 'MR',
        'Mauritius' => 'MU',
        'Mexico' => 'MX',
        'Micronesia' => 'FM',
        'Moldova' => 'MD',
        'Monaco' => 'MC',
        'Mongolia' => 'MN',
        'Montenegro' => 'ME',
        'Morocco' => 'MA',
        'Mozambique' => 'MZ',
        'Myanmar (Burma)' => 'MM',
        'Namibia' => 'NA',
        'Nauru' => 'NR',
        'Nepal' => 'NP',
        'Netherlands' => 'NL',
        'New Zealand' => 'NZ',
        'Nicaragua' => 'NI',
        'Niger' => 'NE',
        'Nigeria' => 'NG',
        'North Macedonia' => 'MK',
        'Norway' => 'NO',
        'Oman' => 'OM',
        'Pakistan' => 'PK',
        'Palau' => 'PW',
        'Palestine' => 'PS',
        'Panama' => 'PA',
        'Papua New Guinea' => 'PG',
        'Paraguay' => 'PY',
        'Peru' => 'PE',
        'Philippines' => 'PH',
        'Poland' => 'PL',
        'Portugal' => 'PT',
        'Qatar' => 'QA',
        'Romania' => 'RO',
        'Russia' => 'RU',
        'Rwanda' => 'RW',
        'Saint Kitts and Nevis' => 'KN',
        'Saint Lucia' => 'LC',
        'Saint Vincent and the Grenadines' => 'VC',
        'Samoa' => 'WS',
        'San Marino' => 'SM',
        'Sao Tome and Principe' => 'ST',
        'Saudi Arabia' => 'SA',
        'Senegal' => 'SN',
        'Serbia' => 'RS',
        'Seychelles' => 'SC',
        'Sierra Leone' => 'SL',
        'Singapore' => 'SG',
        'Slovakia' => 'SK',
        'Slovenia' => 'SI',
        'Solomon Islands' => 'SB',
        'Somalia' => 'SO',
        'South Africa' => 'ZA',
        'South Sudan' => 'SS',
        'Spain' => 'ES',
        'Sri Lanka' => 'LK',
        'Sudan' => 'SD',
        'Suriname' => 'SR',
        'Sweden' => 'SE',
        'Switzerland' => 'CH',
        'Syria' => 'SY',
        'Taiwan' => 'TW',
        'Tajikistan' => 'TJ',
        'Tanzania' => 'TZ',
        'Thailand' => 'TH',
        'Togo' => 'TG',
        'Tonga' => 'TO',
        'Trinidad and Tobago' => 'TT',
        'Tunisia' => 'TN',
        'Turkey' => 'TR',
        'Turkmenistan' => 'TM',
        'Tuvalu' => 'TV',
        'Uganda' => 'UG',
        'Ukraine' => 'UA',
        'United Arab Emirates' => 'AE',
        'United Kingdom' => 'GB',
        'United States' => 'US',
        'Uruguay' => 'UY',
        'Uzbekistan' => 'UZ',
        'Vanuatu' => 'VU',
        'Vatican City' => 'VA',
        'Venezuela' => 'VE',
        'Vietnam' => 'VN',
        'Yemen' => 'YE',
        'Zambia' => 'ZM',
        'Zimbabwe' => 'ZW'
    ];

     return isset($countryCodes[$countryName]) ? $countryCodes[$countryName] : null;
}




function convert_date_format($date_str) {
    // Create a DateTime object from the input date string
    $datetime = DateTime::createFromFormat('Y-m-d', $date_str);

    // Check if the conversion was successful
    if ($datetime instanceof DateTime) {
        // Format the DateTime object to the desired output format
        $formatted_date = $datetime->format('D M d Y');

        return $formatted_date;
    } else {
        // Handle the case where the conversion fails
        return 'Invalid date format';
    }
}

function convert_date_format_val($date_str) {
    // Create a DateTime object from the input date string
    $datetime = DateTime::createFromFormat('Y-m-d', $date_str);

    // Check if the conversion was successful
    if ($datetime instanceof DateTime) {
        // Format the DateTime object to the desired output format
        $formatted_date = $datetime->format('ymd');

        return $formatted_date;
    } else {
        // Handle the case where the conversion fails
        return 'Invalid date format';
    }
}


function get_post_title_or_default($post_id, $default = 'No port found') {
    // Get post title by post ID
    $post_title = get_the_title($post_id);

    // Check if the post title exists
    if ($post_title && !is_wp_error($post_title)) {
        return $post_title;
    } else {
        return $default;
    }
}


function get_port_code($post_id, $default = 'No port found')
{
	$port_code = get_field_new('port_code', $post_id , 'tr_pol_pod' );
	return $port_code;
}


function get_acf_field_or_default($post_id, $field_name, $default = 'No data found') {
    // Get ACF field value
    $field_value = get_field($field_name, $post_id);

    // Check if the field value exists and is not empty
    if (!empty($field_value)) {
        return $field_value;
    } else {
        return $default;
    }
}


function _old_get_user_info_by_my_id($user_id) {
  
    if (have_rows('address', 'user_' . $user_id)) {
        // Loop through the rows of data
        while (have_rows('address', 'user_' . $user_id)) {
            the_row();

            // Retrieve address sub-field values
            $country = get_sub_field('country');
            $address_line_1 = get_sub_field('address_line_1');
            $address_line_2 = get_sub_field('address_line_2');
            $city = get_sub_field('city');
            $state = get_sub_field('state');
            $post_code = get_sub_field('post_code');

            $id_type =  get_field('id_type', 'user_' . $user_id);
            $id_number = get_field('id_number', 'user_' . $user_id);
            $contact_phone = get_field('contact_phone', 'user_' . $user_id);
            $contact_name = get_field('contact_name', 'user_' . $user_id);

            // Retrieve simple fields
            $company_name = get_field('company_name', 'user_' . $user_id);
            $first_name = get_field('first_name', 'user_' . $user_id);
            $last_name = get_field('last_name', 'user_' . $user_id);

            // Return user info as an associative array
            return [
                'company_name' => $company_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'address' => [
                    'country' => $country,
                    'country_code'=> getCountryCode($country),
                    'address_line_1' => $address_line_1,
                    'address_line_2' => $address_line_2,
                    'city' => $city,
                    'state' => $state,
                    'post_code' => $post_code
                ]
                ,
                'id_type'=>$id_type,
                'id_number'=>$id_number,
                'contact_phone'=>$contact_phone,
                'contact_name'=>$contact_name

            ];
        }
    }

    return null;
}


function get_user_info_by_my_id($user_id) {
    
    global $wpdb;

    $res  =$wpdb->get_results("SELECT * FROM tr_user_data WHERE user_id='".$user_id."' ", ARRAY_A);
    $resD =$wpdb->get_results("SELECT * FROM tr_users WHERE ID='".$user_id."' ", ARRAY_A);
   // $country =  $wpdb->get_results("SELECT * FROM `tr_country` where country_name='' ", ARRAY_A); 
    
    $id_type = '';
    $id_number = '';
    $contact_name = '';
    $contact_phone = '';
    $address = '';
    $company_name = '';
    $tax_id = '';
    $phone_number = '';
    $address_0_country = '';
    $address_0_address_line_1 = '';
    $address_0_address_line_2 = '';
    $address_0_city = '';
    $address_0_state = '';
    $address_0_post_code = '';

    // Populate variables if data exists
    if ($res && isset($res[0])) {
        $row  = $res[0];
        $rowD = $resD[0]; 
        
        $id_type = $row['id_type'];
        $id_number = $row['id_number'];
        $contact_name = $rowD['first_name']." ".$rowD['last_name'];
        
        $address = $row['address'];
      

        $tax_id = $row['tax_id'];
        $phone_number = $row['phone_number'];
        $address_0_country = $row['address_0_country'];
        $address_0_address_line_1 = $row['address_0_address_line_1'];
        $address_0_address_line_2 = $row['address_0_address_line_2'];
        $address_0_city = $row['address_0_city'];
        $address_0_state = $row['address_0_state'];
        $address_0_post_code = $row['address_0_post_code'];


        $first_name     = $rowD['first_name'];
        $last_name      = $rowD['last_name'];

        $company_name   = $rowD['company_name'];


        return [
            'company_name' => $company_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address' => [
                'country' => $address_0_country,
                'country_code'=> getCountryCode($address_0_country),
                'address_line_1' => $address_0_address_line_1,
                'address_line_2' => $address_0_address_line_2,
                'city' => $address_0_city,
                'state' => $address_0_state,
                'post_code' => $address_0_post_code
            ]
            ,
            'id_type'=>$id_type,
            'id_number'=>$id_number,
            'contact_phone'=>$phone_number,
            'contact_name'=>$contact_name

        ];
    }


 
    return null;
}





if (isset($_GET['submit_house']) and $_GET['submit_house'] == "ok") {




    $house_id = intval($_GET['house_id']); 
    $house_id_encrypt='';
    if ($house_id > 0) {
        global $wpdb;
        // If you want to get a specific house by ID
        $query = $wpdb->prepare( "SELECT a.*, b.* FROM tr_posts a LEFT JOIN tr_house_info b ON a.ID = b.post_id WHERE a.ID = %d",  $house_id );
        $house_data = $wpdb->get_results($query, ARRAY_A);

        if (!empty($house_data)) 
        {
			
			
			$hazmat 			= (@$house_data[0]['hazmat']=="1")?"Yes":"No";
			$routed_transaction = (@$house_data[0]['is_this_a_routed_transaction']=="1")?"Yes":"No";
			$hazmat = (@$house_data[0]['hazmat']=="1")?"Yes":"No";

            $house_id_encrypt    =  $house_data[0]['house_id_encrypt'];
      
 
		    #echo "<pre>" ;print_r($house_data); echo '</pre>';
            $shipment_id_json 	= 	$house_data[0]['shipment'];
			$shipment_id_array 	= 	json_decode($shipment_id_json);
			$shipment_id  		=	$shipment_id_array[0];

            $itn_number = $house_data[0]['itn_number'];
            #echo $itn_number ."<<<-----";exit;
			$query = $wpdb->prepare( "SELECT a.*, b.* FROM tr_posts a LEFT JOIN tr_shipment_info b ON a.ID = b.post_id WHERE a.ID = %d",  $shipment_id );
			$shipment_data = $wpdb->get_results($query, ARRAY_A);
            
           
            
            $booking_id 	= 	$shipment_data[0]['ocean_export_booking_booking'];
		
		    
          

            $query = $wpdb->prepare( "SELECT * FROM tr_booking_info WHERE id = %d",  $booking_id );
			$booking_data = $wpdb->get_results($query, ARRAY_A);
			if(!count($booking_data)>0)
           	{
           		die("No booking found please select booking in shipment!"); exit;
           	}

           	#echo "===Booking ID>>".$booking_id;
           	#echo "<pre>" ;print_r($booking_data); echo '</pre>';


           	$voyage_id 	 = $booking_data[0]['vessel_information_voyage_details'];
            
            #print "<pre>";
            $booking_pol = $booking_data[0]['vessel_information_pol'];
            $booking_pod = $booking_data[0]['vessel_information_pod'];
            #print_r($booking_data);exit;



           	$query 		 = $wpdb->prepare( "SELECT * FROM tr_voyage_info  WHERE id = %d",  $voyage_id );
			
			$voyage_data = $wpdb->get_results($query, ARRAY_A);
			
			if(!count($voyage_data)>0)
           	{
           		die("Voyage not found please select booking in shipment!"); exit;
           	}



            $shipment_number 	= 	$house_data[0]['post_title'];
            


            $query = $wpdb->prepare("
                SELECT post_id, house_id, shipment_id
                FROM tr_commodities 
                WHERE house_id = %d
            ", $house_id);

            $results = $wpdb->get_results($query);

         
            $house_shipments = array();
            $selected_cars_ar = array();

         
            foreach ($results as $result) {
                $selected_cars_ar[] = $result->post_id;
                if (!isset($house_shipments[$result->house_id])) {
                    $house_shipments[$result->house_id] = array();
                }
                if (!in_array($result->shipment_id, $house_shipments[$result->house_id])) {
                    $house_shipments[$result->house_id][] = $result->shipment_id;
                }
            }

            // Check for any house_id with more than one distinct shipment_id
            foreach ($house_shipments as $house_id => $shipments) {
                if (count($shipments) > 1) {
                    $alert_message = 'Alert: House ID ' . $house_id . ' is associated with ' . count($shipments) . ' different shipments.';
                    echo '<script>alert("' . esc_js($alert_message) . '");</script>';
                    break; // Since we only need to alert once, break after the first alert
                }
            }



			$query = $wpdb->prepare("
			    SELECT post_id , house_id , shipment_id
			    FROM tr_commodities 
			    WHERE house_id = %d
			", $house_id);

			
			$results = $wpdb->get_results($query);

			
			$selected_cars_ar = array();
			foreach ($results as $result) {
			    $selected_cars_ar[] = $result->post_id;
			}


			            
           	$voyage_etd     	=   $voyage_data[0]['voyage_etd'];
           	$voyage_etd2 		=   convert_date_format($voyage_etd);
           	$voyage_etd3 		=   convert_date_format_val($voyage_etd);
            
            $vessel_name        =   $voyage_data[0]['vessel_name'];

           	$vessel_name 		=	str_replace('["','',$vessel_name);
           	$vessel_name        =   str_replace('"]','',$vessel_name);

            #print_r($voyage_data);

			

			


           	$query 		 = $wpdb->prepare( "SELECT * FROM tr_vessel_name_info  WHERE id = %d",  $vessel_name );
			
			$vessel_data = $wpdb->get_results($query, ARRAY_A);


			#echo "<pre>-->>>>>>>"; print_r($vessel_data);exit;
			$conveyance_name = $voyage_data[0]['post_title'];

			if(!count($vessel_data)>0)
           	{
           		die("No Vessel Name !"); 
           	}
           	$vessels_ocean_carrier = $vessel_data[0]['vessels_ocean_carrier'];

			//$vessels_ocean_carrier = get_post_title_or_default($vessels_ocean_carrier,'no vessels ocean carrier');           	

			$ocean_carrier = ($booking_data[0]['ocean_carrier']);

			$ocean_carrier = str_replace(['[', ']'], '', $ocean_carrier);
			$ocean_carrier = str_replace('"', '', $ocean_carrier);


			$ocean_carrier = get_field('scac',$ocean_carrier);           	


			//$ocean_carrier_c = (int)$ocean_carrier_c;
			$vessels_ocean_carrier = $ocean_carrier ;
			



           	$vessel_flag		=	$vessel_data[0]['vessel_flag'];
           	#echo "======>>zzz";print_r($vessels_ocean_carrier);exit;






           	// if(isset($selected_cars_ar) and is_array($selected_cars_ar) and !count($selected_cars_ar)>0)
           	// {
           	// 	die("No car found in shipment please select car first !"); exit;
           	// }
           	
           	if(is_array($selected_cars_ar))
           	{
           		$selected_cars_str = ' "'.implode('","', 	$selected_cars_ar).'" ';
           	}
           	
           	



            #echo $selected_cars_str."<<-------";exit;


           $product_data=$wpdb->get_results('SELECT a.*, b.* FROM tr_posts a LEFT JOIN tr_commodities b ON a.ID = b.post_id WHERE a.ID IN('.$selected_cars_str.') ', ARRAY_A);


           	
			$pol 			= $shipment_data[0]['ocean_export_booking_pol'];
			$pod 		 	= $shipment_data[0]['ocean_export_booking_pou'];
			$mode_of_trans 	= $product_data[0]['eei_mode_of_transportation'];

			$pod_country 	= get_acf_field_or_default($pod, 'country');

			$pol_title 		= get_post_title_or_default($booking_pol);
			$pod_title 		= get_post_title_or_default($booking_pod);
        	
        	$POE_Code 		= get_port_code($booking_pol);
        	$POU_Code		= get_port_code($booking_pod);
        
           
            $booking_id_str = $booking_data[0]['post_title'];;

            $booking_meta   = get_post_meta($booking_id);
			
            $container_id   = $shipment_data[0]['container_id'];

            $container_info = $wpdb->get_results("select * from tr_container_info where id ='".$container_id."'",ARRAY_A);


            


            $container_number = @$container_info[0]['container_number'];
            $container_qty    = "1";

            $container_seal   = @$container_info[0]['seal_no_1'];
            
            
            #echo "<pre>"; print_r($product_data); "</pre>";
           	#echo $product_data[0]['eei_state_of_origin'];

            $state_of_origin = ""; 



			$FO = "2";  
			$BN = $booking_id_str;  // Booking Number
			#print "<pre>";print_r($product_data);exit;

			$ST = $product_data[0]['title_state'];  // State of Origin
			$FTZ = "";  // Foreign Trade Zone
			$POE = $pol_title;  // Port of Export
			
            $booking_country = '';
            $res_r = $wpdb->get_results("SELECT country FROM `tr_pol_pod` where post_id='".$booking_pod."';" ,ARRAY_A);

            $booking_country = $res_r[0]['country'];

			$COD = $booking_country;

			$COD_V = getCountryCode($booking_country);  // Country of Destination
			$EDA = $voyage_etd2;  // Departure Date
			$EDA_v = $voyage_etd3;
			
			$POU = $pod_title;  // Port of Unlading
			
			$mot_temp = $mode_of_trans;
			$mot_temp = explode("Ocean",$mot_temp);

			$MOT  =  'Vessel, Containerized';//@$mot_temp[1]  // Mode of Transport
			$MOT_V = '11';
			$SCAC = $vessels_ocean_carrier;  // Carrier
			$VN   = $conveyance_name;  // Conveyance Name

			$VF   = $vessel_flag;  // Vessel Flag
			$RCC  = "No";  // Related Companies
			$WPN  = "No";  // Waiver of Prior Notice
			$HAZ  = $hazmat;  // Hazardous Cargo
			$RT   = $routed_transaction;  // Routed Transaction Flag
			$IBT  = "70";  // Inbond Type


			
			$seller_name =   $product_data[0]['us_seller'];
			                 

			$consignee2  = 	 $house_data[0]['ultimate_consignee'];

			$shipment2   = 	 $house_data[0]['us_ppi'];

			$ic_id     	 =   $product_data[0]['ocean_export_booking_intermediate_consignee'];
			
			$ff_id       =	 $shipment_data[0]['ocean_export_booking_us_custom_agent'];
			



			$us_seller_info = get_user_info_by_my_id($shipment2);

			$uc_info = get_user_info_by_my_id($consignee2);

					

			$ic_info = get_user_info_by_my_id($ic_id);

			
			


			$us_p_id  		= $shipment2;
			$us_p_name 		= $us_seller_info['company_name'];
			$us_p_id_number = $us_seller_info['id_number'];
			$us_p_id_type = $us_seller_info['id_type'];

			$us_p_address_line_1 = $us_seller_info['address']['address_line_1'];
			$us_p_address_line_2 = $us_seller_info['address']['address_line_2'];  // Assuming empty, as in your original HTML
			$us_p_city =  $us_seller_info['address']['city'];
			$us_p_state = $us_seller_info['address']['state'];
			$us_p_zip_code = $us_seller_info['address']['post_code'];

			$us_p_contact_first_name = $us_seller_info['first_name'];
			$us_p_contact_last_name = $us_seller_info['last_name'];
			$us_p_contact_phone = $us_seller_info['contact_phone'];



			// UC Info
			$uc_id 			 = $consignee2;
			$uc_company_name = $uc_info['company_name'];
			$uc_contact_name = $uc_info['contact_name'];
			$uc_contact_phone = $uc_info['contact_phone'];
			$uc_address_line_1 = $uc_info['address']['address_line_1'];
			$uc_address_line_2 = $uc_info['address']['address_line_2'];
			$uc_city = $uc_info['address']['city'];
			$uc_state = $uc_info['address']['state'];
			$uc_country = $uc_info['address']['country'];
			$uc_country_code = $uc_info['address']['country_code'];
			$uc_postal_code = $uc_info['address']['post_code'];
			$uc_consignee_type = $uc_info['consignee_type'];
			$uc_sold_en_route = $uc_info['sold_en_route'];

			// IC Info
			$ic_name = $ic_info['company_name'];
			$ic_contact_name = $ic_info['contact_name'];
			$ic_contact_phone = $ic_info['contact_phone'];
			$ic_address_line_1 = $ic_info['address']['address_line_1'];
			$ic_address_line_2 = $ic_info['address']['address_line_2'];
			$ic_city = $ic_info['address']['city'];
			$ic_state = $ic_info['address']['state'];
			$ic_country = $ic_info['address']['country'];
			$ic_postal_code = $ic_info['address']['post_code'];

			// FF Info

            $buyer_partner  =   $product_data[0]['buyer_partner'];
            $res            = $wpdb->get_results("select * from tr_users where ID='".$buyer_partner."' " ,ARRAY_A);
            $permissions    =   [];
            if($res[0]['permissions']!="")
            {
                
                $permissions = explode(",",$res[0]['permissions']);

            }
            
            #print "<pre>"; print_r($permissions);exit;
            $show_ff_info ='0';

            if(in_array('allow_file_aes',$permissions))
            {
                $show_ff_info = '1'; 
                $ff_id   = $buyer_partner;
                $ff_info = get_user_info_by_my_id($buyer_partner);

                $ff_name = $ff_info['company_name'];
                $ff_id_number = $ff_info['id_number'];
                $ff_id_type = $ff_info['id_type'];
                $ff_contact_name = $ff_info['contact_name'];
                $ff_contact_phone = $ff_info['contact_phone'];
                $ff_address_line_1 = $ff_info['address']['address_line_1'];
                $ff_address_line_2 = $ff_info['address']['address_line_2'];
                $ff_city = $ff_info['address']['city'];
                $ff_state = $ff_info['address']['state'];
                $ff_country = $ff_info['address']['country'];
                $ff_postal_code = $ff_info['address']['post_code'];
            }

            





            include_once(dirname(__FILE__)."/submit_form_html.php");

        } 
        else 
        {
            echo "No results found or query failed.";
        }

        echo $house_id;
    }

    exit;
}

?>