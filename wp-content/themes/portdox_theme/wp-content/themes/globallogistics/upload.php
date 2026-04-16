<?php
/*
Template Name: Upload
*/
get_header(); // include the header
?>


<style type="text/css">
	.sidebar { display: none }
	.footer_wrap { display: none; } 
	.copyright_wrap{ display: none; }
	header{ display: none !important; }
	#wpadminbar{ display: none }
	body.custom-background{ background: #fff; }
	.existing_images{ margin-top:15px; }
	.image_cont{ max-width:135px; float: left; position: relative; margin-left: 10px; margin-top:5px;   }
	.image_cont .delete_image_button{ position: absolute; right:0px; top: 5px; }
	.image_cont .delete_image_button{border: 0px !important; background-color: transparent; color:red; padding: 0px}
	.image_cont .delete_image_button:hover{border: 0px !important; background-color: transparent; padding: 0px}
	.image_cont .delete_image_button span{
		-webkit-box-shadow: 1px 2px 5px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 1px 2px 5px 0px rgba(0,0,0,0.75);
		box-shadow: 1px 2px 5px 0px rgba(0,0,0,0.75);
	}	
	#tag_number { min-height: 30px; padding:5px; font-size: 17px;  width: 70%; }
	#tag_number_lab{ font-size: 17px; }
	#commodity-info-container h3{ margin-top:10px; }
	#fetch_commodity_button{height: 33px;
    padding-top: 6px;}
</style>
 
<!-- Your custom page content goes here -->

<div id="custom-template-container">
    <form id="fetch-commodity-form">
        <label for="tag_number" id="tag_number_lab">Tag Number:</label>
        <input type="text" id="tag_number" name="tag_number" required >
        <button type="button" id="fetch_commodity_button">Fetch </button>
    </form>

    <div id="commodity-info-container"></div>


</div>


<script type="text/javascript">
jQuery(document).ready(function($) {
    
    $('#fetch_commodity_button').on('click', function() {
        var tagNumber = $('#tag_number').val();

        // Make an AJAX request
        $.ajax({
            type: 'POST',
            url: "<?php echo admin_url('admin-ajax.php');?>",
            data: {
                action: 'fetch_commodity',
                tag_number: tagNumber
            },
            success: function(response) {
                // Update UI with fetched commodity information
                $('#commodity-info-container').html(response);
            }
        });
    });

    function upload_image()
    {
    	
	    var postId = $('#post_id').val();
	    
	    var imageData = new FormData();
	    imageData.append('action', 'upload_image');
	    
	    imageData.append('image', $('#image')[0].files[0]);
	    imageData.append('post_id', postId);

	    // Create a Bootstrap progress bar dynamically
	    var progressBar = $('<div class="progress"><div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>');
	    $('#progress_bar').append(progressBar);

	    // Make an AJAX request for image upload
	    $.ajax({
	        type: 'POST',
	        url: "<?php echo admin_url('admin-ajax.php');?>",
	        data: imageData,
	        contentType: false,
	        processData: false,
	        xhr: function() {
	            var xhr = new window.XMLHttpRequest();
	            // Listen for progress events
	            xhr.upload.addEventListener('progress', function(event) {


	                if (event.lengthComputable) {
	                    var percentComplete = (event.loaded / event.total) * 100;
	                    // Update the progress bar
	                    progressBar.find('.progress-bar').css('width', percentComplete + '%');
	                    progressBar.find('.progress-bar').attr('aria-valuenow', percentComplete);
	                }
	            }, false);
	            return xhr;
	        },
	        success: function(response) {
	            // Update UI with fetched commodity information
	            $('#upload_content').html(response);
	            $('#image').val('');
	        },
	        complete: function() {
	            // Remove the progress bar when the upload is complete
	            progressBar.remove();
	        }
	    });

    }
    $(document).on("click","#upload_btn",function (){
    	if($("#image").val()=="")
    	{
    		alert("Please Select Image");
    		return false;
    	}
    	upload_image();
    });
	$(document).on('change', '#image', function() {
	   upload_image();
	});



	$(document).on('click', '.delete_image_button', function() {
	    var imageId = $(this).data('imageid');
	    var postId = $('#post_id').val();

	    // Make an AJAX request to delete the image
	    $.ajax({
	        type: 'POST',
	        url: "<?php echo admin_url('admin-ajax.php');?>",
	        data: {
	            action: 'delete_image',
	            image_id: imageId,
	            post_id: postId
	        },
	        success: function(response) {
	         
	            if(response!="")
	            {
	            	
	            	$('#upload_content').html(response);	
	            }
	            else
	            {
	            	$('#existing_images').html("");
	            }
	            
	        }
	    });
	});

  



});
</script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
