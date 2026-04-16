<?php 
include_once("simple_html_dom.php");


function my_admin_menu() {
	add_menu_page(
		__( 'VIN Finder', 'my-textdomain' ),
		__( 'VIN Finder', 'my-textdomain' ),
		'manage_options',
		'vin-finder',
		'vin_finder_page_contents',
		'dashicons-schedule',
		3
	);
}

add_action( 'admin_menu', 'my_admin_menu' );


add_action('wp_ajax_search_vin', 'search_vin_fn');
add_action('wp_ajax_nopriv_search_vin', 'search_vin_fn');
function search_vin_fn() {
    global $wpdb;
   
    $vin_no = $_REQUEST['vin_no'];
  
    if($vin_no!="")
    {

    /*
	 <style>
   .content-table {
	  border-collapse: collapse;
	  margin: 25px 0;
	  font-size: 0.9em;
	  min-width: 400px;
	  border-radius: 5px 5px 0 0;
	  overflow: hidden;
	  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
	}

	.content-table thead tr {
	  background-color: #009879;
	  color: #ffffff;
	  text-align: left;
	  font-weight: bold;
	}

	.content-table th,
	.content-table td {
	  padding: 12px 15px;
	}

	.content-table tbody tr {
	  border-bottom: 1px solid #dddddd;
	}

	.content-table tbody tr:nth-of-type(even) {
	  background-color: #f3f3f3;
	}

	.content-table tbody tr:last-of-type {
	  border-bottom: 2px solid #009879;
	}

	.content-table tbody tr.active-row {
	  font-weight: bold;
	  color: #009879;
	}
	.footer-thankyou{ display:none }
	.show_log_div {max-width: 500px !important}
	.show_log_div li { list-style:none !important }
	.list-group-item{list-style:none !important}
    </style>

    <table class="wp-list-table  fixed striped table-view-list posts content-table">
        <thead>
            
            
        </thead>
        <tbody>

        */
   
              


             /*  $curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://www.decodethis.com/vin/".$vin_no,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_SSL_VERIFYPEER => false,
				  CURLOPT_SSL_VERIFYHOST => 2,
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				  echo "cURL Error #:" . $err;
				} else {
				 // echo $response;
				}

               
				$html = new simple_html_dom();
				#echo $response;
				$html->load($response);

				$ul = $html->find('#vehicle-data .list-group');

				$make = $series = $trim_level = $origin = $body_type = $wheelbase = $track_front = $track_rear = $height = $width = $length = $engine_type = $transmission = $msrp = '';
				foreach($html->find('#vehicle-data .list-group') as $list_group) {
				    foreach($list_group->find('.list-group-item') as $list_item) {
				        
				        foreach($list_item->find('table td') as $td) {
				            $td_html = $td->outertext;
				            $td_text = strip_tags($td_html);
				             if(strpos($td_text, 'Model Year') !== false) {
				                $model_year = str_replace('Model Year', '', $td_text);
				                // do something with $model_year
				            }
				            else if(strpos($td_text, 'Make') !== false) {
				                $make = str_replace('Make', '', $td_text);
				            } elseif(strpos($td_text, 'Series') !== false) {
				                $series = str_replace('Series', '', $td_text);
				            } elseif(strpos($td_text, 'Trim Level') !== false) {
				                $trim_level = str_replace('Trim Level', '', $td_text);
				            } elseif(strpos($td_text, 'Origin') !== false) {
				                $origin = str_replace('Origin', '', $td_text);
				            } elseif(strpos($td_text, 'Body Type') !== false) {
				                $body_type = str_replace('Body Type', '', $td_text);
				            } elseif(strpos($td_text, 'Wheelbase') !== false) {
				                $wheelbase = str_replace('Wheelbase', '', $td_text);
				            } elseif(strpos($td_text, 'Track Front') !== false) {
				                $track_front = str_replace('Track Front', '', $td_text);
				            } elseif(strpos($td_text, 'Track Rear') !== false) {
				                $track_rear = str_replace('Track Rear', '', $td_text);
				            } elseif(strpos($td_text, 'Height') !== false) {
				                $height = str_replace('Height', '', $td_text);
				            } elseif(strpos($td_text, 'Width') !== false) {
				                $width = str_replace('Width', '', $td_text);
				            } elseif(strpos($td_text, 'Length') !== false) {
				                $length = str_replace('Length', '', $td_text);
				            } elseif(strpos($td_text, 'Engine Type') !== false) {
				                $engine_type = str_replace('Engine Type', '', $td_text);
				            } elseif(strpos($td_text, 'Transmission') !== false) {
				                $transmission = str_replace('Transmission', '', $td_text);
				            } elseif(strpos($td_text, 'MSRP') !== false) {
				                $msrp = str_replace('MSRP', '', $td_text);
				            }
				        }
				        // do something with the extracted data
				    }
				}

				$data = array(
				    'model_year' => trim($model_year),
				    'make' => trim($make),
				    'series' => trim($series),
				    'trim_level' => trim($trim_level),
				    'origin' => trim($origin),
				    'body_type' => trim($body_type),
				    'wheelbase' => trim($wheelbase),
				    'track_front' => trim($track_front),
				    'track_rear' => trim($track_rear),
				    'height' => trim($height),
				    'width' => trim($width),
				    'engine_type' => trim($engine_type),
				    'transmission' => trim($transmission),
				    
				);
				echo json_encode($data);*/




				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/".$vin_no."&?format=json",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_SSL_VERIFYPEER => false,
				  CURLOPT_SSL_VERIFYHOST => 2,
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				$resp = json_decode($response);

				$resp = (array)$resp; 
				

				$make = $model = $model_year = $series = $trim_level = $origin = $body_type = $wheelbase = $track_front = $track_rear = $height = $width = $length = $engine_type = $transmission = $msrp = $weight  = $possible_value='';
				

				if(count($resp['Results'])>0)
				{

					foreach($resp['Results'] as $val2)
					{
						
						$val_ar = (array)$val2;
						
						#print_r($val_ar);

						if($val_ar['Variable']=="Make")
						{
							$make = $val_ar['Value'];
						}
						 if($val_ar['Variable']=="Model")
						{
							$model = $val_ar['Value'];
						}

						if($val_ar['Variable']=="Model Year")
						{
							$model_year = $val_ar['Value'];
						}

						if($val_ar['Variable']=="Possible Values")
						{
							$possible_value = $val_ar['Value'];
						}

						#$possible_value = "777";

						if ( str_contains($val_ar['Variable'],'Gross Vehicle Weight Rating From') ) 
						{
							

							$string = str_replace(",","",$val_ar['Value']);
							$parts = explode("(", $string); // split the string at the "(" character
							$last_part = end($parts); // get the last element of the resulting array
							$number = substr($last_part, 0, strpos($last_part, " ")); // extract the number before the space character
							$weight = str_replace(",", "", $number); // remove commas from the number
							//$weight = $string;
							
						}

						
						 if($val_ar['Variable']=="Series")
						{
							$series = $val_ar['Value'];
						}
						
						
						 if($val_ar['Variable']=="Trailer Body Type")
						{
							$body_type = $val_ar['Value'];
						}
						
						
						
						 if($val_ar['Variable']=="Track Width (inches)")
						{
							$width = $val_ar['Value'];
						}
						 if($val_ar['Variable']=="Trailer Length (feet)")
						{
							$length = $val_ar['Value'];
						}
						 if($val_ar['Variable']=="Engine Model")
						{
							$engine_type = $val_ar['Value'];
						}
						 if($val_ar['Variable']=="Transmission Style")
						{
							$transmission = $val_ar['Value'];
						}

					}
					


				}
				else
				{
					//echo json_decode(array('message'=>'no record found'));
				}
				


				
				

				$data = array(
				    'model_year' => trim($model_year),
				    'make' => trim($make),
				    'model'=>trim($model),
				    'series' => trim($series),
				    'trim_level' => trim($trim_level),
				    'origin' => trim($origin),
				    'body_type' => trim($body_type),
				    'wheelbase' => trim($wheelbase),
				    'track_front' => trim($track_front),
				    'track_rear' => trim($track_rear),
				    'height' => trim($height),
				    'width' => trim($width),
				    'engine_type' => trim($engine_type),
				    'transmission' => trim($transmission),
				    'weight'=>trim($weight),
				    'possible_value'=>trim($possible_value)
				    
				);
				echo json_encode($data);

				
				exit;
				
           
        
            
          
	}
	else
	{
		echo "please enter vin number";
	}
    die();
}

function vin_finder_page_contents() {
	?>
		<h1>
			<?php esc_html_e( 'Welcome to my VIN Finder Pager.', 'my-plugin-textdomain' ); ?>
		</h1>

		




		   <script type="text/javascript">
          

            function search_vin_fnn() {
            	
                jQuery('.search_vin').prop('disabled', true);
                jQuery('.search_vin').html('please wait..');
                var vin_no2 = jQuery('#vin').val();
                jQuery.ajax({
                    type:"POST",
                    url:"<?php echo admin_url( 'admin-ajax.php' ); ?>",
                    data:{
                        action: "search_vin",
                        vin_no:vin_no2
                    },
                    success: function(data)
                    {
                       
                      jQuery('.show_log_div').html(data);
                      jQuery('.show_log').html('Show Logs');
                    },
                    complete:function(data) {
                        jQuery('.search_vin').prop('disabled', false);
                        jQuery('.search_vin').html('Search VIN');
                    }
                })
            }
           
        </script>
    </div>

    <br><br><br> 
    

    <form >
    	
    	<input name="vin" id="vin" class="vin" value="JH4NA1264MT003044">
    	<button type="button" class="search_vin" onclick="search_vin_fnn();" >Search VIN</button>

    </form>

    

    <div class="show_log_div" > 
         
    </div>
	<?php
}

	?>