jQuery(document).ready(function($) {
    // AJAX call when the submit button is clicked
    $('#partner-submit-button').on('click', function(e) {
        e.preventDefault();

        var user_id = $('input[name="user_id"]').val();
        var partner_submitted = 'true'; // Set this value as needed

        // AJAX call to update user meta
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'update_user_meta',
                user_id: user_id,
                partner_submitted: partner_submitted
            },
            success: function(response) {
                // Update the submit status on the screen
                $('#partner-submit-status').text('Submitted by partner');
            },
            error: function() {
                // Handle error
            }
        });
    });
});

function passport_upload_fn() 
{    

    var user_id = jQuery('input[name="user_id"]').val();
   
    jQuery("#passport_upload_btn").html("Please wait...");
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'passport_upload_copy',
            user_id: user_id
        },
        success: function(response) {
            alert(response);
            jQuery("#passport_upload_btn").hide();
        },
        error: function() {
          jQuery("#passport_upload_btn").html("Approve Passport");
        }
    });
}

function license_copy_fn() 
{    

	var user_id = jQuery('input[name="user_id"]').val();
   
    jQuery("#license_copy_btn").html("Please wait...");
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'approve_license_copy',
            user_id: user_id
        },
        success: function(response) {
        	alert(response);
            jQuery("#license_copy_btn").hide();
        },
        error: function() {
          jQuery("#license_copy_btn").html("Approve Passport");
        }
    });

}



function poa_fn() 
{    

	var user_id = jQuery('input[name="user_id"]').val();
   
    jQuery("#poa_btn").html("Please wait...");
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'poa_copy',
            user_id: user_id
        },
        success: function(response) {
        	alert(response);
            jQuery("#poa_btn").hide();
        },
        error: function() {
          jQuery("#poa_btn").html("Approve Passport");
        }
    });

}

function poa_expire_fn() 
{    

	var user_id = jQuery('input[name="user_id"]').val();
   
    jQuery("#poa_expire_btn").html("Please wait...");
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'poa_expire_copy',
            user_id: user_id
        },
        success: function(response) {
        	alert(response);
            jQuery("#poa_expire_btn").hide();
        },
        error: function() {
          jQuery("#poa_expire_btn").html("Approve Passport");
        }
    });

}

function license_expire_fn() 
{    

    var user_id = jQuery('input[name="user_id"]').val();
   
    jQuery("#license_expire_btn").html("Please wait...");
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'license_expire_copy',
            user_id: user_id
        },
        success: function(response) {
            alert(response);
            jQuery("#license_expire_btn").hide();
        },
        error: function() {
          jQuery("#license_expire_btn").html("Approve Expire Date");
        }
    });

}


function passport_expire_date_fn() 
{    

    var user_id = jQuery('input[name="user_id"]').val();
   
    jQuery("#passport_expire_date_btn").html("Please wait...");
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'passport_expire_date_copy',
            user_id: user_id
        },
        success: function(response) {
            alert(response);
            jQuery("#passport_expire_date_btn").hide();
        },
        error: function() {
          jQuery("#passport_expire_date_btn").html("Approve Expire Date");
        }
    });

}
