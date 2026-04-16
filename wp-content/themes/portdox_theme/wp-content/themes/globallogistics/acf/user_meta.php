<?php
/*add_action("init",function (){


	if(@$_GET['update_user_record']=="ok")
	{




		global $wpdb;

		// Custom table name
		$table_name = 'tr_user_data';

		// Get all users from wp_users table
		$users = $wpdb->get_results("SELECT ID, user_login FROM {$wpdb->users}");

		// Loop through each user
		foreach ($users as $user) {
		    $user_id = $user->ID;
		    $user_login = $user->user_login;

		    // Get user meta data from wp_usermeta
		    $user_meta = $wpdb->get_results($wpdb->prepare("SELECT meta_key, meta_value FROM {$wpdb->usermeta} WHERE user_id = %d", $user_id));

		    // Prepare data to be inserted or updated in tr_user_data table
		    $data = array(
		        'user_id' => $user_id,
		        'user_login' => $user_login // Include any other relevant user data you want to store
		    );

		    // Process user meta data
		    if ($user_meta) {
		        foreach ($user_meta as $meta) {
		            $meta_key = $meta->meta_key;
		            $meta_value = $meta->meta_value;

		            // Map user meta key to corresponding column in tr_user_data (if necessary)
		            switch ($meta_key) {
		                case 'id_type':
		                case 'id_number':
		                case 'contact_name':
		                case 'contact_phone':
		                case 'address':
		                case 'company_name':
		                case 'tax_id':
		                case 'phone_number':
		                case 'address_0_country':
		                case 'address_0_address_line_1':
		                case 'address_0_address_line_2':
		                case 'address_0_city':
		                case 'address_0_state':
		                case 'address_0_post_code':
		                    // Add or update data based on meta key
		                    $data[$meta_key] = $meta_value;
		                    break;
		                // Add more cases for other meta keys if needed
		            }
		        }
		    }

		    // Check if user data already exists in tr_user_data table
		    $existing_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_name} WHERE user_id = %d", $user_id));

		    print "<pre>";print_r($data);print "</pre>";
		     unset($data['user_login']);
		    if ($existing_data) {
		        // Update existing record
		        echo $wpdb->update($table_name, $data, array('user_id' => $user_id));
		    } else {
		        // Insert new record
		       
		        $result = $wpdb->insert($table_name, $data);
		        if ($result === false) {
		            // Display error message from last database operation
		            echo "Failed to insert user data for user ID: {$user_id}. Error: " . esc_html($wpdb->last_error);
		        } else {
		            echo "User data inserted successfully for user ID: {$user_id}";
		        }
		    }
		}
		exit;
	}



});*/
add_action('edit_user_profile', 'tr_render_user_data_metabox');

// Render the user data metabox
function tr_render_user_data_metabox($user) {
    
    global $wpdb;
    $table_name =  'tr_user_data';
    $user_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user->ID));

    // Set default values if no data found
    $id_type = '';
    $id_number = '';
    $contact_name = '';
    $contact_phone = '';
    $address = '';
    $company_name = '';
    
    $phone_number = '';
    $address_0_country = '';
    $address_0_address_line_1 = '';
    $address_0_address_line_2 = '';
    $address_0_city = '';
    $address_0_state = '';
    $address_0_post_code = '';

    // Populate values from database if data exists
    if ($user_data) {
        $id_type = $user_data->id_type;
        $id_number = $user_data->id_number;
        $contact_name = $user_data->contact_name;
        $contact_phone = $user_data->contact_phone;
        $address = $user_data->address;
        $company_name = $user_data->company_name;
        
        $phone_number = $user_data->phone_number;
        $address_0_country = $user_data->address_0_country;
        $address_0_address_line_1 = $user_data->address_0_address_line_1;
        $address_0_address_line_2 = $user_data->address_0_address_line_2;
        $address_0_city = $user_data->address_0_city;
        $address_0_state = $user_data->address_0_state;
        $address_0_post_code = $user_data->address_0_post_code;
    }

    // Output field HTML with populated values
    ?>
    <style type="text/css">
    	/* Form container */
		#user-data-form {
	        max-width: 500px;
	        margin: 20px auto;
	        padding: 20px;
	        background-color: #f9f9f9;
	        border: 1px solid #ddd;
	        border-radius: 5px;
	        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
	        margin-left:215px ;
	    }

	    /* Form group styling */
	    .form-group {
	        display: flex;
	        align-items: center;
	        margin-bottom: 15px;
	    }

	    /* Label styling */
	    .form-group label {
	        flex: 0 0 30%; /* 30% width for labels */
	        font-weight: bold;
	        margin-right: 10px;
	        text-align: right;
	    }

	    /* Input field styling */
	    .form-group input[type="text"],
	    .form-group select {
	        flex: 1; /* Remaining width for input fields */
	        padding: 10px;
	        border: 1px solid #ddd;
	        border-radius: 4px;
	        box-sizing: border-box;
	    }

	    /* Optional: Hover and focus styles for input fields */
	    .form-group input[type="text"]:hover,
	    .form-group input[type="text"]:focus {
	        border-color: #007bff;
	    }

	    /* Separate section for address fields */
	    #address-section {
	        margin-top: 20px; /* Add some space above address section */
	        padding: 15px;
	        background-color: #fff;
	        border: 1px solid #ddd;
	        border-radius: 5px;
	        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
	    }

    </style>
    <div id="user-data-form">
	    <div class="form-group">
	        <label for="id_type">ID Type:</label>
	        <select id="id_type" name="id_type">
	            <option value="Passport" <?php selected($id_type, 'Passport'); ?>>Passport</option>
	            <option value="EIN" <?php selected($id_type, 'EIN'); ?>>EIN</option>
	        </select>
	    </div>


	    <div class="form-group">
	        <label for="id_number">ID Number:</label>
	        <input type="text" id="id_number" name="id_number" value="<?php echo esc_attr($id_number); ?>">
	    </div>

	    <div class="form-group">
	        <label for="contact_name">Contact Name:</label>
	        <input type="text" id="contact_name" name="contact_name" value="<?php echo esc_attr($contact_name); ?>">
	    </div>

	    <div class="form-group">
	        <label for="contact_phone">Contact Phone:</label>
	        <input type="text" id="contact_phone" name="contact_phone" value="<?php echo esc_attr($contact_phone); ?>">
	    </div>

	   

	    <div class="form-group">
	        <label for="company_name">Company Name:</label>
	        <input type="text" id="company_name" name="company_name" value="<?php echo esc_attr($company_name); ?>">
	    </div>


	    <div class="form-group">
	        <label for="phone_number">Phone Number:</label>
	        <input type="text" id="phone_number" name="phone_number" value="<?php echo esc_attr($phone_number); ?>">
	    </div>
		<div id="address-section">


		    <div class="form-group">
		        <label for="address_0_country">Address Country:</label>
		        <select id="address_0_country" name="address_0_country">
		            <?php
		            // Define array with country names
		            $countries = array(
		                'Albania', 'Algeria', 'American Samoa', 'Angola', 'Anguilla', 'Antigua', 'Argentina', 'Aruba',
		                'Australia', 'Azores', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belgium', 'Belize',
		                'Benin', 'Bermuda', 'Brazil', 'British Indian Ocean Territory', 'British Virgin Islands', 'Brunei',
		                'Bulgaria', 'Burma (Myanmar)', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands',
		                'Chile', 'China (Mainland)', 'China (Taiwan)', 'Colombia', 'Comoros', 'Congo (Brazzaville)',
		                'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Denmark', 'Djibouti', 'Dominca Island', 'Dominican Republic',
		                'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Falkland Islands', 'Faroe',
		                'Fiji Islands', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern & Antarctic Lands',
		                'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe',
		                'Guam', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hong Kong', 'Iceland', 'India',
		                'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Ivory Coast', 'Jamaica', 'Japan', 'Jordan', 'Kenya',
		                'Kiribati', 'Kuwait', 'Latvia', 'Lebanon', 'Liberia', 'Libya', 'Lithuania', 'Macau', 'Madagascar (Malagasy)',
		                'Malaysia', 'Maldives Islands', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mexico',
		                'Micronesia', 'Monaco', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nauru Island', 'Netherland Antilles',
		                'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Nigeria', 'Niue', 'North Korea', 'Northern Mariana Islands',
		                'Norway', 'Oman', 'Other Pacific Islands N.E.C.', 'Pakistan', 'Palau (Pelew) Islands', 'Panama', 'Papua New Guinea',
		                'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Qatar', 'Reunion', 'Romania', 'Russia',
		                'Sao Tome & Principe', 'Saudi Arabia', 'Senegal', 'SerbiaMontenegro', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovenia',
		                'Solomon Islands', 'Somalia', 'South Africa', 'South Korea', 'Southern Asia', 'Southern Pacific Islands', 'Spain', 'Sri Lanka',
		                'St. Helena', 'St. Kitts & Nevis', 'St. Lucia', 'St. Pierre & Miquelon', 'St. Vincent & the Grenadines', 'Sudan', 'Suriname',
		                'Sweden', 'Syria', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad', 'Tunisia', 'Turkey', 'Turks and Caicos Islands',
		                'Tuvalu', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'Uruguay', 'US', 'Vanuatu', 'Venezuela', 'Vietnam', 'Virgin Islands',
		                'Wallis & Futuna', 'Western Sahara', 'Yemen'
		            );

		            // Loop through countries to generate <option> elements
		            foreach ($countries as $country) {
		                $selected = ($address_0_country === $country) ? 'selected="selected"' : '';
		                echo '<option value="' . esc_attr($country) . '" ' . $selected . '>' . esc_html($country) . '</option>';
		            }
		            ?>
		        </select>
		    </div>

		   <div class="form-group">
		        <label for="address_0_address_line_1">Address Line 1:</label>
		        <input type="text" id="address_0_address_line_1" name="address_0_address_line_1" value="<?php echo esc_attr($address_0_address_line_1); ?>">
		    </div>

		    <div class="form-group">
		        <label for="address_0_address_line_2">Address Line 2:</label>
		        <input type="text" id="address_0_address_line_2" name="address_0_address_line_2" value="<?php echo esc_attr($address_0_address_line_2); ?>">
		    </div>

		    <div class="form-group">
		        <label for="address_0_city">Address City:</label>
		        <input type="text" id="address_0_city" name="address_0_city" value="<?php echo esc_attr($address_0_city); ?>">
		    </div>

		    <div class="form-group">
		        <label for="address_0_state">Address State:</label>
		        <input type="text" id="address_0_state" name="address_0_state" value="<?php echo esc_attr($address_0_state); ?>">
		    </div>

		    <div class="form-group">
		        <label for="address_0_post_code">Address Post Code:</label>
		        <input type="text" id="address_0_post_code" name="address_0_post_code" value="<?php echo esc_attr($address_0_post_code); ?>">
		    </div>
		</div>
	    <!-- Add submit button if needed -->
	    <!-- <button type="submit">Save</button> -->
	</div>

    <?php
}


function tr_save_user_data($user_id) {
    global $wpdb;
    $table_name =  'tr_user_data';

    //if (current_user_can('edit_user', $user_id)) {
        $data = array(
            'user_id' => $user_id,
            'id_type' => sanitize_text_field($_POST['id_type']),
            'id_number' => sanitize_text_field($_POST['id_number']),
            'contact_name' => sanitize_text_field($_POST['contact_name']),
            'contact_phone' => sanitize_text_field($_POST['contact_phone']),
            'address' => sanitize_text_field($_POST['address']),
            'company_name' => sanitize_text_field($_POST['company_name']),
            
            'phone_number' => sanitize_text_field($_POST['phone_number']),
            'address_0_country' => sanitize_text_field($_POST['address_0_country']),
            'address_0_address_line_1' => sanitize_text_field($_POST['address_0_address_line_1']),
            'address_0_address_line_2' => sanitize_text_field($_POST['address_0_address_line_2']),
            'address_0_city' => sanitize_text_field($_POST['address_0_city']),
            'address_0_state' => sanitize_text_field($_POST['address_0_state']),
            'address_0_post_code' => sanitize_text_field($_POST['address_0_post_code'])
        );

        
        $existing_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id));
        if ($existing_data) {
            $wpdb->update($table_name, $data, array('user_id' => $user_id));
        } else {
            $wpdb->insert($table_name, $data);
        }
    //}
}
add_action('personal_options_update', 'tr_save_user_data');
add_action('edit_user_profile_update', 'tr_save_user_data');
