
<?php
function get_s_code($keyowrd)
{
    global $wpdb;
    $query = "SELECT * FROM tr_posts as p
              INNER JOIN tr_postmeta as pm
              ON p.ID = pm.post_id
              WHERE pm.meta_key = 'descrip_1'
              AND pm.meta_value LIKE '%".$keyowrd."%'
              AND p.post_type = 'htc_code'
              AND p.post_status = 'publish'";
    $results = $wpdb->get_results($query,ARRAY_A);
  
    if($results[0]['post_title']!="" )
    {
        return $results[0]['post_title'];
    }
    else
    {
        return '';
    }
}

?>
<html><head>
        <title>Portdox Web EEI</title>
    </head>

    <body bgcolor="FFFFFF">

        <font face="verdana,arial,helvetica" size="1">
            <a href="https://ace.cbp.dhs.gov/" target="_blank">ACE Portal&nbsp;Homepage</a>&nbsp;
        </font>
        <font face="MS Sans Serif">
            <table align="center" width="100%" cellpadding="3" style="empty-cells: show;">
                <form name="SEDForm" id="SEDForm" method="POST" onsubmit="return true;" action="https://trade.cbp.dhs.gov/ace/aes/aesdirect-ui/secured/createWeblinkFiling" target="_blank">
                    <input type="submit" target="_blank">
                    <!--<form name="SEDForm" method="POST" onsubmit="return true;" action="https://aesdirect.census.gov/weblink/weblink.cgi">-->
                    <!-- AESDirect required tags -->
                    <tbody><tr>
                        <td>
                         
                            <input type="hidden" name="wl_app_ident" value="wlmgcs01"> 
               
                            <input type="hidden" name="wl_app_name" value="Portdox">
                            <input type="hidden" name="wl_nologin_url" value="https://">
                            <input type="hidden" name="wl_nosed_url" value="https://">
                            <input type="hidden" name="wl_success_url" value="https://login.portdox.com/aes_success?house_id=<?php echo @$house_id_encrypt;?>">
                            <input type="hidden" name="EMAIL" value="autoadventures@gmail.com,itn@portdox.com">
                            <input type="hidden" name="var_type" value="new">


                        </td>
                    </tr>
               
				<tr>
                    <td bgcolor="#002b46">
                        <font color="#ffffff" size="3"><b>&nbsp;General Information</b> - Required By AES</font>
                    </td>
				</tr>
				<tr>
					<td>
					<span id="generalspan" style="display: ">
                        <table align="center" width="100%" cellpadding="3" style="empty-cells: show;">
                            <tbody>

                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">ITN Number:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $itn_number;?><input type="hidden" name="ITNN" value="<?php echo $itn_number;?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Shipment Number:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $shipment_number; ?><input type="hidden" name="SRN" value="<?php echo $shipment_number; ?>">&nbsp;</font></td>
                                </tr>

                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Filing Option:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $FO; ?><input type="hidden" name="FO" value="<?php echo $FO; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Booking Number:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $BN; ?><input type="hidden" name="BN" value="<?php echo $BN; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">State of Origin:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $ST; ?><input type="hidden" name="ST" value="<?php echo $ST; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Foreign Trade Zone:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><input type="hidden" name="FTZ" value="">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Port of Export:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $POE; ?> <input type="hidden" name="POE" value="<?php echo $POE_Code; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Country of Destination:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $COD; ?><input type="hidden" name="COD" value="<?php echo $COD_V; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Departure Date:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2">
                                        <?php
                                        
                                        $timestamp = strtotime($EDA);
                                        $newDateFormat = date("ymd", $timestamp);
                                        
                                        echo $EDA; ?><input type="hidden" name="EDA" value="<?php echo $newDateFormat; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Port of Unlading:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $POU; ?> <input type="hidden" name="POU" value="<?php echo $POU_Code; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Mode of Transport:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $MOT; ?><input type="hidden" name="MOT" value="<?php echo $MOT_V; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Carrier:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $SCAC; ?><input type="hidden" name="SCAC" value="<?php echo $SCAC; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Conveyance Name:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $VN; ?><input type="hidden" name="VN" value="<?php echo $VN; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Vessel Flag:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><input type="hidden" name="VF" value="">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Related Companies:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $RCC; ?><input type="hidden" name="RCC" value="<?php echo $RCC; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Waiver of Prior Notice:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $WPN; ?><input type="hidden" name="WPN" value="<?php echo $WPN; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Hazardous Cargo:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2">No<input type="hidden" name="HAZ" value="No">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Routed Transaction Flag:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $RT; ?><input type="hidden" name="RT" value="<?php echo $RT; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Inbond Type:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $IBT; ?><input type="hidden" name="IBT" value="<?php echo $IBT; ?>">&nbsp;</font></td>
                                </tr>
                            </tbody>
                        </table>
					
					</span>
					</td>
				</tr>
			<!-- End // GENERAL INFORMATION -->			<!-- US PRINCIPAL PARTY IN INTEREST -->
				<tr>
					<td bgcolor="#002b46">
						<font color="#ffffff" size="3"><b>&nbsp;U.S. Principal Party in Interest</b> - Required By AES</font>
					</td>
				</tr>
				<tr>
					<td>
                    


					<span id="us_principal_span" style="display: ">
                        <table align="center" width="100%" cellpadding="3" style="empty-cells: show;">
                            <tbody>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Name:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_name; ?><input type="hidden" name="AD0_1" value="<?php echo $us_p_name; ?>">&nbsp;</font> 

                                        <a href="<?php echo site_url();?>/wp-admin/user-edit.php?user_id=<?php echo $us_p_id;?>&wp_http_referer=%2Fwp-admin%2Fusers.php" target="_blank"> Edit </a>

                                    </td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">ID Number:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_id_number; ?><input type="hidden" name="AD0_2" value="<?php echo $us_p_id_number; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">ID Type:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_id_type; ?><input type="hidden" name="AD0_3" value="<?php echo $us_p_id_type; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Address Line 1:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_address_line_1; ?><input type="hidden" name="AD0_4" value="<?php echo $us_p_address_line_1; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Address Line 2:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_address_line_2; ?><input type="hidden" name="AD0_5" value="<?php echo $us_p_address_line_2; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">City:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_city; ?><input type="hidden" name="AD0_6" value="<?php echo $us_p_city; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">State:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_state; ?><input type="hidden" name="AD0_7" value="<?php echo $us_p_state; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Zip Code:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_zip_code; ?><input type="hidden" name="AD0_8" value="<?php echo $us_p_zip_code; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Contact First Name:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_contact_first_name; ?><input type="hidden" name="AD0_9" value="<?php echo $us_p_contact_first_name; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Contact Last Name:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_contact_last_name; ?><input type="hidden" name="AD0_11" value="<?php echo $us_p_contact_last_name; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Contact Phone:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $us_p_contact_phone; ?><input type="hidden" name="AD0_12" value="<?php echo $us_p_contact_phone; ?>">&nbsp;</font></td>
                                </tr>
                            </tbody>
                        </table>
					</span>
					</td>
				</tr>
			<!-- End // US PRINCIPAL PARTY IN INTEREST -->			<!-- ULTIMATE CONSIGNEE -->
				<tr>
					<td bgcolor="#002b46">
						<font color="#ffffff" size="3"><b>&nbsp;Ultimate Consignee</b> - Required By AES</font>
					</td>
				</tr>
				<tr>
					<td>


					<span id="ult_consignee_span" style="display: ">
                       <table align="center" width="100%" cellpadding="3" style="empty-cells: show;">
                            <tbody>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Name:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_company_name; ?><input type="hidden" name="AD1_3" value="<?php echo $uc_company_name; ?>">&nbsp;</font>

                                         <a href="<?php echo site_url();?>/wp-admin/user-edit.php?user_id=<?php echo $uc_id;?>&wp_http_referer=%2Fwp-admin%2Fusers.php" target="_blank"> Edit </a>

                                    </td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Contact Name:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_contact_name; ?><input type="hidden" name="AD1_5" value="<?php echo $uc_contact_name; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Contact Phone:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_contact_phone; ?><input type="hidden" name="AD1_7" value="<?php echo $uc_contact_phone; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Address Line 1:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_address_line_1; ?> <?php echo $uc_city; ?> <?php echo $uc_state; ?> <?php echo $uc_country; ?><input type="hidden" name="AD1_8" value="<?php echo $uc_address_line_1; ?> <?php echo $uc_city; ?> <?php echo $uc_state; ?> <?php echo $uc_country; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Address Line 2:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_address_line_2; ?><input type="hidden" name="AD1_9" value="<?php echo $uc_address_line_2; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">City:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_city; ?><input type="hidden" name="AD1_10" value="<?php echo $uc_city; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">State:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_state; ?><input type="hidden" name="AD1_11" value="<?php echo $uc_state; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Country:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_country; ?><input type="hidden" name="AD1_12" value="<?php echo $uc_country_code; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Postal Code:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_postal_code; ?><input type="hidden" name="AD1_13" value="<?php echo $uc_postal_code; ?>">&nbsp;</font></td>
                                </tr>
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Ultimate Consignee Type:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_consignee_type; ?><input type="hidden" name="AD1_14" value="<?php //echo $uc_consignee_type; ?>O">O&nbsp;</font></td>
                                </tr>

                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Sold En Route:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2">N<input type="hidden" name="AD1_6" value="N">&nbsp;No</font></td>
                                </tr>
                                <!-- 
                                <tr>
                                    <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Sold En Route:</font></td>
                                    <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo $uc_sold_en_route; ?><input type="hidden" name="AD1_6" value="<?php echo $uc_sold_en_route; ?>">&nbsp;<?php echo ($uc_sold_en_route == 'N') ? 'No' : 'Yes'; ?></font></td>
                                </tr> -->
                            </tbody>
                        </table>

					</span>
					</td>
				</tr>
			<!-- End // ULTIMATE CONSIGNEE -->			<!-- INTERMEDIATE CONSIGNEE -->
				<tr>
					<td bgcolor="#002b46">
						<font color="#ffffff" size="3"><b>&nbsp;Intermediate Consignee</b></font>
					</td>
				</tr>
				<tr>
					<td>


					<span id="int_consignee_span" style="display: ">
                        <table align="center" width="100%" cellpadding="3" style="empty-cells: show;">
                        <tbody>
                            <tr>
                                <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Name:</font></td>
                                <td bgcolor="#ededed">&nbsp;<font size="2"><?php //echo ($ic_name); ?><input type="hidden" name="AD4_3" value="<?php //echo ($ic_name); ?>">&nbsp;</font>


                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#d9edf7" align="right"><font size="2">Contact Name:</font></td>
                                <td bgcolor="#ededed">&nbsp;<font size="2"><?php //echo ($ic_contact_name); ?><input type="hidden" name="AD4_5" value="<?php //echo ($ic_contact_name); ?>">&nbsp;</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#d9edf7" align="right"><font size="2">Contact Phone:</font></td>
                                <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo ($ic_contact_phone); ?><input type="hidden" name="AD4_7" value="<?php echo ($ic_contact_phone); ?>">&nbsp;</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#d9edf7" align="right"><font size="2">Address Line 1:</font></td>
                                <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo ($ic_address_line_1); ?><input type="hidden" name="AD4_8" value="<?php echo ($ic_address_line_1); ?>">&nbsp;</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#d9edf7" align="right"><font size="2">Address Line 2:</font></td>
                                <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo ($ic_address_line_2); ?><input type="hidden" name="AD4_9" value="<?php echo ($ic_address_line_2); ?>">&nbsp;</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#d9edf7" align="right"><font size="2">City:</font></td>
                                <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo ($ic_city); ?><input type="hidden" name="AD4_10" value="<?php echo ($ic_city); ?>">&nbsp;</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#d9edf7" align="right"><font size="2">State:</font></td>
                                <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo ($ic_state); ?><input type="hidden" name="AD4_11" value="<?php echo ($ic_state); ?>">&nbsp;</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#d9edf7" align="right"><font size="2">Country:</font></td>
                                <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo ($ic_country); ?><input type="hidden" name="AD4_12" value="<?php echo ($ic_country); ?>">&nbsp;</font></td>
                            </tr>
                            <tr>
                                <td bgcolor="#d9edf7" align="right"><font size="2">Postal Code:</font></td>
                                <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo ($ic_postal_code); ?><input type="hidden" name="AD4_13" value="<?php echo ($ic_postal_code); ?>">&nbsp;</font></td>
                            </tr>
                        </tbody>
                        </table>

					</span>
					</td>
				</tr>
			<!-- End // INTERMEDIATE CONSIGNEE -->			<!-- FREIGHT FORWARDER -->
				<tr>
					<td bgcolor="#002b46">
						<font color="#ffffff" size="3"><b>&nbsp;Freight Forwarder</b></font>
					</td>
				</tr>
				<tr>
					<td>
					<span id="freight_forw_span" style="display: ">
                       <?php 
                       if($show_ff_info=="1")
                       {
                            ?>
                            <table align="center" width="100%" cellpadding="3" style="empty-cells: show;">
                                <tbody>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Name:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_name); ?><input type="hidden" name="AD3_3" value="<?php echo htmlspecialchars($ff_name); ?>">&nbsp;</font>
                                              <a href="<?php echo site_url();?>/wp-admin/user-edit.php?user_id=<?php echo $ff_id;?>&wp_http_referer=%2Fwp-admin%2Fusers.php" target="_blank"> Edit </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">ID Number:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_id_number); ?><input type="hidden" name="AD3_4" value="<?php echo htmlspecialchars($ff_id_number); ?>">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">ID Type:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_id_type); ?><input type="hidden" name="AD3_2" value="<?php echo htmlspecialchars($ff_id_type); ?>">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">Contact Name:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_contact_name); ?><input type="hidden" name="AD3_5" value="<?php echo htmlspecialchars($ff_contact_name); ?>">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">Contact Phone:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_contact_phone); ?><input type="hidden" name="AD3_7" value="<?php echo htmlspecialchars($ff_contact_phone); ?>">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">Address Line 1:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_address_line_1); ?><input type="hidden" name="AD3_8" value="<?php echo htmlspecialchars($ff_address_line_1); ?>">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">Address Line 2:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_address_line_2); ?><input type="hidden" name="AD3_9" value="<?php echo htmlspecialchars($ff_address_line_2); ?>">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">City:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_city); ?><input type="hidden" name="AD3_10" value="<?php echo htmlspecialchars($ff_city); ?>">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">State:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_state); ?><input type="hidden" name="AD3_11" value="<?php echo htmlspecialchars($ff_state); ?>">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">Country:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_country); ?><input type="hidden" name="AD3_12" value="<?php echo htmlspecialchars($ff_country); ?>">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#d9edf7" align="right"><font size="2">Postal Code:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><?php echo htmlspecialchars($ff_postal_code); ?><input type="hidden" name="AD3_13" value="<?php echo htmlspecialchars($ff_postal_code); ?>">&nbsp;</font></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php 
                       }
                       else
                       {
                            $admin = $wpdb->get_results("select * from tr_users where ID='1' " , ARRAY_A);
                            $adminD = $wpdb->get_results("select * from tr_user_data where ID='1' " , ARRAY_A);
                            # print "<pre>";print_r( $adminD ); print "</pre>";
                           # print "<pre>";print_r( $admin ); print "</pre>";
                            ?>
                            <table align="center" width="100%" cellpadding="3" style="empty-cells: show;">
                                <tbody>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Name:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">Auto Adventure<input type="hidden" name="AD3_3" value="Auto Adventure">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">ID Number:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">264079983<input type="hidden" name="AD3_4" value="264079983">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">ID Type:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">EIN<input type="hidden" name="AD3_2" value="E">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Contact Name:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">ILYAS ALJOULANI<input type="hidden" name="AD3_5" value="ILYAS ALJOULANI">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Contact Phone:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">2532387390<input type="hidden" name="AD3_7" value="2532387390">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Address Line 1:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">6316 128th E<input type="hidden" name="AD3_8" value="6316 128th E">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Address Line 2:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2"><input type="hidden" name="AD3_9" value="">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">City:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">Puyallup<input type="hidden" name="AD3_10" value="Puyallup">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">State:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">WA<input type="hidden" name="AD3_11" value="WA">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Country:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">UNITED STATES OF AMERICA<input type="hidden" name="AD3_12" value="US">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" bgcolor="#d9edf7" align="right"><font size="2">Postal Code:</font></td>
                                        <td bgcolor="#ededed">&nbsp;<font size="2">98373<input type="hidden" name="AD3_13" value="98373">&nbsp;</font></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                       }
                       ?>

                          <!---->



                    

					</span>
					</td>
				</tr>
			<!-- End // FREIGHT FORWARDER -->			<!-- LINE ITEMS -->
				<tr>
					<td bgcolor="#002b46">
						<font color="#ffffff" size="3"><b>&nbsp;Line Items</b></font>
					</td>
				</tr>
				<tr>
					<td>
					<span id="line_items_span" style="display: ">
                        <table align="center" width="100%" cellpadding="3" style="empty-cells: show;">
                            <tbody><tr>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Number</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Export Code</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">US Dollars</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">First Unit</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">First Quantity</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Second Unit</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Second Quantity</font></th>
                            </tr>
                            <tr>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Gross Weight (Kg)</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">License Type</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">License Number</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">License Value</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Description</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Commodity Code</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Marks and Numbers</font></th>
                            </tr>
                            <tr>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Vehicle</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Vehicle ID Type</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Vehicle ID</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Vehicle Title</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Vehicle Title State</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">ECCN</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">Origin</font></th>
                            </tr>
                            <tr>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">DDTC Exemption Code</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">DDTC Registration Number</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">DDTC Is Military Equipment</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">DDTC Is Elegible Party</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">DDTC USML</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">DDTC Unit of Measure</font></th>
                                <th width="14%" bgcolor="#d9edf7" align="center"><font size="2">DDTC Quantity</font></th>
                            </tr>
                            						




                       <!--  <tr>
                            <td colspan="7"> 
                                <?php #echo "<pre>"; print_r($product_data); print "</pre>"; ?>
                            </td>
                        </tr> 
 -->

                        <?php 

                        $s = 1;

                        foreach ($product_data as $key => $value) {

                            $id       =   $value['ID'];
                           # $os      =   $value['eei_export_code:'];
                            $os       =   "OS";
                            #$nlr     =   $value['eei_license_number'];
                            $nlr      =   "NLR";
                            
                            $vin      =   $value['vin'];
                            $c_value  =   $value['value'];
                            $weight   =   $value['weight'];
                            $year     =   $value['year'];
                           

                            $desc        =   $value['year']." ".$value['make']." ".$value['model'];
                            $licese_type = 'C33';


                            $state_of_origin =  $value['eei_state_of_origin'];
                            $license_number  =  $value['eei_license_number'];
                            $license_value   =  $value['eei_license_value_'];
                            #$eei_origin      =  $value['eei_origin'];
                            $eei_origin      =  "DOMESTIC";

                            $type2           =  $value['type2'];

                            $title_number    =  $value['title_number'];
                            $title_state     =  $value['title_state'];

                            
                            $commodity_type_vehical = "No";
                            $commodity_type_vehical_value = "N";
                            if($type2=="Vehicle")
                            {
                                $commodity_type_vehical = "Yes";
                                $commodity_type_vehical_value = "Y";
                            }


                            $commodity_code      = $value['eei_schedual_b_code'];
                            $commodity_code_desc = $value['eei_schedule_b_description_'];

                            $schedule_code       = get_s_code($commodity_code_desc);
                            $tag_number          = $value['tag_number'];
                           # $schedule_code= '123';
                           # echo $commodity_code_desc."<=====================";


                        ?>



                        <tr>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $s;?><input type="hidden" name="isLine<?php echo $s;?>" value="Y"></font></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $os;?></font><font size="2" color="#ff0000"><font size="2" color="#ff0000"><i>&nbsp;</i></font></font><input type="hidden" name="IT<?php echo $s;?>_1" value="<?php echo $os;?>"></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2">$ <?php echo $c_value;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_2" value="<?php echo $c_value;?>"></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2">NO</font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_3" value="NO"></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2">1</font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_4" value="1"></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_5" value=""></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_6" value=""></td>
						</tr> 
						<tr>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $weight;?> Kg</font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_7" value="<?php echo $weight;?>"></td>
                            
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $licese_type?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_8" value="<?php echo $licese_type?>"></td>
                            
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $nlr;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_9" value="<?php echo $nlr;?>"></td>
                            
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $license_value;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_10" value="<?php echo $license_value;?>"></td>
                            
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php  echo $desc;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_12" value="<?php echo $desc;?>"></td>

                            <td width="14%" align="center" style="background-color:#ededed"><font size="2">8703600070</font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_13" value="8703600070"></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $tag_number ; ?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_14" value="<?php echo $tag_number ; ?>"></td>
						</tr>
						<tr>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $commodity_type_vehical;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_15" value="<?php echo $commodity_type_vehical_value;?>"></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2">VIN</font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_16" value="V"></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $vin;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_17" value="<?php echo $vin;?>"></td>
                            
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $title_number;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_18" value="<?php echo $title_number;?>"></td>
                            
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $title_state;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_19" value="<?php echo $title_state;?>"></td>
                            
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_20" value=""></td>

                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"><?php echo $eei_origin;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="IT<?php echo $s;?>_21" value="D"></td>
						</tr>
						<tr>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="ODTC1_1" value=""></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="ODTC1_2" value=""></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="ODTC1_3" value=""></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="ODTC1_4" value=""></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="ODTC1_5" value=""></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="ODTC1_6" value=""></td>
                            <td width="14%" align="center" style="background-color:#ededed"><font size="2"></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="ODTC1_7" value=""></td>
						</tr>
						

                        <tr>
                            <td colspan="7" style="background-color:#ededed">
                                <a href="<?php echo site_url();?>/wp-admin/post.php?post=<?php echo $id;?>&action=edit" target="_blank">Edit Product</a>
                                <hr>
                            </td>
						</tr>

                        
                        <?php
                            
                            $s++;
                        }
                        ?>







                        </tbody>

                    </table>
					

                    </span>
					</td>
				</tr>
			<!-- End // LINE ITEMS -->			<!-- LINE CONTAINERS -->
				<tr>
					<td bgcolor="#002b46">
						<font color="#ffffff" size="3"><b>&nbsp;Line Containers</b></font>
					</td>
				</tr>
				<tr>
					<td>
					<span id="line_containers_span" style="display: ">
                        <table align="center" width="100%" cellpadding="3" style="empty-cells: show;">
                            <tbody><tr>
                                <th width="33%" bgcolor="#d9edf7" align="center"><font size="2">Number</font></th>
                                <th width="33%" bgcolor="#d9edf7" align="center"><font size="2">Container Number</font></th>
                                <th width="33%" bgcolor="#d9edf7" align="center"><font size="2">Seal Number</font></th>
                            </tr>
                                                    
                            <?php if($container_number!=""){ ?>

                            <tr>
                            <td width="33%" align="center" style="background-color:#ededed"><font size="2"><?php echo $container_qty;?><input type="hidden" name="isLine1" value="Y"></font></td>
                            <td width="33%" align="center" style="background-color:#ededed"><font size="2"><?php echo $container_number;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="EQ1" value="<?php echo $container_number;?>"></td>
                            <td width="33%" align="center" style="background-color:#ededed"><font size="2"><?php echo $container_seal;?></font><font size="2" color="#ff0000"><i>&nbsp;</i></font><input type="hidden" name="SN1" value="<?php echo $container_seal;?>"></td>
                            </tr>

                            <?php } ?>
                        <tr>
                            <td colspan="3" style="background-color:#ededed"><hr></td>
                        </tr>
                        </tbody></table>


					</span>
					</td>
				</tr>
                <!----
             


                    ----->
			<!-- End // LINE CONTAINERS -->			<!-- BUTTONS -->
			<!-- 	<tr>
					<td>
						&#160;<button type="submit"><font size="-2">Send EEI</font></button>
					</td>
				</tr>
            -->

			<!-- End // BUTTONS -->

			<!-- AESDirect required tags -->
			<tr>
				<td>
					<font face="verdana,arial,helvetica" size="1">
                        <a href="https://ace.cbp.dhs.gov/" target="_blank">ACE Portal&nbsp;Homepage</a>&nbsp;
					</font>
				</td>
			</tr>
            <input type="hidden" name="FAC" value="R">
			
			</tbody></table>
		</font>

        </form>
	
