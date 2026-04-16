
<style type="text/css">
	.image_cont{ max-width:135px; float: left; position: relative; margin-left: 10px; margin-top:5px;   }
	.image_cont img{ width: 100%; }
	.image_cont .delete_image_button{ position: absolute; left:10px; top: 5px; }
	.image_cont .delete_image_button{border: 0px !important; background-color: transparent; color:red; padding: 0px}
	.image_cont .delete_image_button:hover{border: 0px !important; background-color: transparent; padding: 0px}
	.image_cont .delete_image_button span{
		-webkit-box-shadow: 1px 2px 5px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 1px 2px 5px 0px rgba(0,0,0,0.75);
		box-shadow: 1px 2px 5px 0px rgba(0,0,0,0.75);
	}	
</style>

<?php
$admin_roles = get_users(array('role' => 'photo_maker'));

global $wpdb; 

$user_id =  get_current_user_id();
$post_id =  $post->ID;

$res =  $wpdb->get_results("select * from tr_photo_task a  left join tr_users b on a.user_id=b.ID where  a.post_id='$post_id' ",ARRAY_A);
if(isset($res[0]['user_login']) and $res[0]['user_login']!="")
{
	echo '<h3>Already Assign To '.$res[0]['user_login']."</h3>";
}


?>
<label for="admin_roles">Assign Task to:</label>
<select id="admin_roles" name="admin_roles">
	<option value="">Select Photo Maker</option>
    <?php foreach ($admin_roles as $admin) : ?>
        <option value="<?php echo esc_attr($admin->ID); ?>"><?php echo esc_html($admin->display_name); ?></option>
    <?php endforeach; ?>
</select>
<button id="assign_task_button" type="button" class="button">Assign Task</button>
<script>
jQuery(document).ready(function ($) {
    $('#assign_task_button').on('click', function () {
        var userId = $('#admin_roles').val();
        var postId = <?php echo esc_js($post->ID); ?>;
        if(userId=="")
        {
        	alert("Please select photo maker");
        	return false;
        }
        // AJAX request
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'assign_commodity_task',
                nonce: '<?php echo wp_create_nonce('commodity_assign_nonce'); ?>',
                user_id: userId,
                post_id: postId,
            },
            success: function (response) {
                $('#assign_result').html(response);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
</script>



<div id="assign_result"></div>


<hr style="margin-top: 10px; margin-bottom:10px ">

<form id="upload-image-form" enctype="multipart/form-data" style="padding: 10px; border: 1px dotted #ccc; border-radius: 5px; "> 
	<input type="file" id="image" name="image" accept="image/*" > 
	<button type="button" id="upload_btn"> Upload </button>
</form>
<div id="progress_bar"></div>

<div id="upload_content" style="margin-top:10px; overflow: hidden;">
	<?php  display_existing_images(get_the_ID()); ?>
</div>

<input type="hidden" id="post_id" value="<?php echo get_the_ID();?>">


<script type="text/javascript">
	jQuery(document).ready(function ($){

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




		function upload_image()
	    {
	    	
		    var postId = $('#post_id').val();
		    
		    var imageData = new FormData();
		    imageData.append('action', 'upload_image');
		   
		    imageData.append('image', $('#image')[0].files[0]);
		    imageData.append('post_id', postId);

		    
		    var progressBar = $('<div class="progress"><div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>');
		    $('#progress_bar').append(progressBar);

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


	});
</script>


<?php














?>