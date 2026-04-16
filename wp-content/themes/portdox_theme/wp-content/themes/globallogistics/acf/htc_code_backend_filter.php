<?php 

// Add filter dropdown to htc_code admin page
add_action('restrict_manage_posts', 'add_commodity_filter');
function add_commodity_filter() {
    global $typenow, $wpdb;
    if ($typenow == 'htc_code') {
        $current_commodity = isset($_GET['commodity']) ? $_GET['commodity'] : '';
        
        echo '<input name="commodity" value="'.$current_commodity.'" placeholder="search via commodity" style="float: left;margin-right: 6px;max-width: 12.5rem;height: 29px;">';
           
        
    }
}

// Filter the htc_code query based on the selected commodity
add_filter('pre_get_posts', 'filter_htc_code_by_commodity');
function filter_htc_code_by_commodity($query) {
    global $pagenow, $typenow, $wpdb;
    $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : '';
    $commodity = isset($_GET['commodity']) ? $_GET['commodity'] : '';

    if ($query->is_admin && $pagenow == 'edit.php' && $post_type == 'htc_code' && !empty($commodity)) {
        $meta_query = array(
            array(
                'key' => 'commodity',
                'value' => $commodity,
                'compare' => 'LIKE'
            )
        );
        $query->set('meta_query', $meta_query);
    }
    return $query;
}
?>