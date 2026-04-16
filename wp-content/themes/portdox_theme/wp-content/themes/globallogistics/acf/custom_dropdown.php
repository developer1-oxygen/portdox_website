<?php 

$state_posts = get_posts(array(
    'post_type' => 'shipment',
    'posts_per_page' => -1,
));

// Convert the state posts into an array
$states = array();
foreach ($state_posts as $post) {
    $states[$post->post_title] = $post->post_title;
}

// Add the field to the desired location in ACF
/*acf_add_local_field(array(
    'parent' => 'group_64060af42a09b', 
    'key' => 'field_641ebce250d57', 
    'label' => 'shipment2',
    'type' => 'select',
    'choices' => $states,
    'default_value' => '',
    'allow_null' => 0,
    'multiple' => 0,
    'ui' => 1,
    'ajax' => 0,
    'placeholder' => '',
));*/



?>