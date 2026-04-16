<?php


// Add menu item in WordPress admin dashboard
add_action( 'admin_menu', 'register_email_settings_page' );

function register_email_settings_page() {
    add_options_page(
        'Email Settings',
        'Email Settings',
        'manage_options',
        'email-settings',
        'render_email_settings_page'
    );
}

// Render the email settings page
function render_email_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // Output security fields
            settings_fields( 'email-settings-group' );
            // Output setting sections
            do_settings_sections( 'email-settings' );
            // Submit button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register email settings
add_action( 'admin_init', 'register_email_settings' );

function register_email_settings() {
    // Register settings
    register_setting(
        'email-settings-group',
        'email_subject',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '',
            'autoload' => 'no', // Set autoload to 'no'
        )
    );
    register_setting(
        'email-settings-group',
        'email_content',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_textarea_field',
            'default' => '',
            'autoload' => 'no', // Set autoload to 'no'
        )
    );
    
    // Add settings section
    add_settings_section(
        'email-settings-section',
        'Email Settings',
        'render_email_settings_section_1',
        'email-settings'
    );
    
    // Add settings fields
    add_settings_field(
        'email_subject',
        'Email Subject',
        'render_email_subject_field_1',
        'email-settings',
        'email-settings-section'
    );
    add_settings_field(
        'email_content',
        'Email Content',
        'render_email_content_field_1',
        'email-settings',
        'email-settings-section'
    );


}

// Render email settings section and fields
function render_email_settings_section_1() {
    echo '<hr><h4 style="color:red">Case Number Assign To Commodity (Seller Email)</h4>';
}

function render_email_subject_field_1() {
    $email_subject = get_option( 'email_subject' );
    echo '<input type="text" name="email_subject" value="' . esc_attr( $email_subject ) . '" />';
}

function render_email_content_field_1() {
    $email_content = get_option( 'email_content' );
    ?> <div style="padding-bottom: 10px;"> You can user follow shortcode and it will be replace with dynamic data %user_name% </div>  <?php
    wp_editor( $email_content, 'email_content' );


}


?>