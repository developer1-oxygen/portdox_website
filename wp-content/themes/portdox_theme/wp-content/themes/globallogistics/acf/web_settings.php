<?php 
function web_settings_register_settings() {
  add_option( 'web_settings_holidays', 'Holiday dates.');
  register_setting( 'web_settings_options_group', 'web_settings_holidays', 'web_settings_callback' );

  add_option( 'web_settings_company_view_assign_partner_only', 'web_settings_company_view_assign_partner_only');
  register_setting( 'web_settings_options_group', 'web_settings_company_view_assign_partner_only', 'web_settings_callback' );

  add_option( 'web_settings_partner_view_assign_company_only', 'web_settings_partner_view_assign_company_only.');
  register_setting( 'web_settings_options_group', 'web_settings_partner_view_assign_company_only', 'web_settings_callback' );

}
add_action( 'admin_init', 'web_settings_register_settings' );



function web_settings_register_options_page() {
  add_options_page('Web settings', 'Web Settings', 'manage_options', 'web_settings', 'web_settings_options_page');
}
add_action('admin_menu', 'web_settings_register_options_page');



function web_settings_options_page()
{
?>
  <div>
  <?php screen_icon(); ?>
  <h2>Web Settings </h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'web_settings_options_group' ); ?>
  
  <style type="text/css">
    .web_setting_table td,.web_setting_table th{ padding:10px }
  </style>
  <table class="web_setting_table">
    <tr valign="top">
    
      <th scope="row">
          <label for="web_settings_holidays">Holidays</label>
      </th>
      <td>
        <textarea  name="web_settings_holidays" style="width:400px; height: 100px;"  ><?php echo get_option('web_settings_holidays'); ?></textarea>
      </td>

    </tr>
    <tr valign="top">
    
      <th scope="row">
          <label for="web_settings_company_view_assign_partner_only">Company Can view assign partner</label>
      </th>
      <td>
        <input type="checkbox" name="web_settings_company_view_assign_partner_only" value="1"  <?php if(get_option('web_settings_company_view_assign_partner_only')=="1"){echo 'checked';} ?>>
      </td>
      
    </tr>

    <tr valign="top">
    
      <th scope="row">
          <label for="web_settings_partner_view_assign_company_only">Partner Can view assign company</label>
      </th>
      <td>
        <input type="checkbox" name="web_settings_partner_view_assign_company_only" value="1"  <?php if(get_option('web_settings_partner_view_assign_company_only')=="1"){echo 'checked';} ?>>
      </td>
      
    </tr>


  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
}

?>