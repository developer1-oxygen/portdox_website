<?php

function tr_photo_task_menu() {
    add_menu_page(
        __('Photo Tasks', 'textdomain'), // Page title
        __('Photo Tasks', 'textdomain'), // Menu title
        'manage_options', // Capability
        'tr-photo-tasks', // Menu slug
        'tr_photo_tasks_page', // Callback function
        'dashicons-format-gallery', // Icon
        6 // Position
    );
}

add_action('admin_menu', 'tr_photo_task_menu');



function tr_photo_tasks_page() {

    global $wpdb;
    ?>
     <h1><?php _e('Assigned Photo Tasks', 'textdomain'); ?></h1>
    <input type="text" id="tr-search-input" placeholder="<?php _e('Search...', 'textdomain'); ?>">
    <div id="tr-task-table">
        <!-- Task data will be loaded via AJAX here -->
    </div>
    <script type="text/javascript">
      
    jQuery(document).ready(function($) {
        function loadTasks(page = 1, search = '') {
            $.ajax({
                url: "<?php echo admin_url('admin-ajax.php');?>",
                type: 'POST',
                data: {
                    action: 'tr_load_tasks',
                    page: page,
                    search: search
                },
                success: function(response) {
                    $('#tr-task-table').html(response);
                }
            });
        }

        loadTasks();

        $('#tr-search-input').on('keyup', function() {
            loadTasks(1, $(this).val());
        });

        $(document).on('click', '.tr-pagination a', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            loadTasks(page, $('#tr-search-input').val());
        });
    });

    </script>

    <?php
}




function tr_load_tasks_callback() {
    global $wpdb;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $per_page = 10;
    $offset = ($page - 1) * $per_page;

    // Modify the query to use search and pagination
    $query = $wpdb->prepare(
        "SELECT b.post_id, c.user_login, a.vin 
        FROM tr_photo_task b 
        LEFT JOIN tr_commodities a ON b.post_id = a.post_id  
        LEFT JOIN tr_users c ON b.user_id = c.ID 
        WHERE c.user_login LIKE %s
        LIMIT %d, %d",
        '%' . $wpdb->esc_like($search) . '%',
        $offset, $per_page
    );

    $tasks = $wpdb->get_results($query);

    echo '<table>';
    echo '<tr><th>Post ID</th><th>User Login</th><th>VIN</th></tr>';
    foreach ($tasks as $task) {
        echo '<tr>';
        echo '<td>' . esc_html($task->post_id) . '</td>';
        echo '<td>' . esc_html($task->user_login) . '</td>';
        echo '<td>' . esc_html($task->vin) . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    // Count total tasks for pagination
    $total_query = "SELECT COUNT(*) FROM tr_photo_task";
    $total = $wpdb->get_var($total_query);
    $total_pages = ceil($total / $per_page);

    // Output pagination links
    echo '<div class="tr-pagination">';
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<a href="#" data-page="' . $i . '">' . $i . '</a> ';
    }
    echo '</div>';
    ?>
    <style type="text/css">
      /* Style for the tasks table */
    #tr-task-table table {
        width: 100%;
        border-collapse: collapse;
    }

    #tr-task-table th, #tr-task-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #tr-task-table th {
        background-color: #f7f7f7;
    }

    #tr-task-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Style for the search input */
    #tr-search-input {
        margin-bottom: 10px;
        padding: 8px;
        width: 300px;
        border: 1px solid #ddd;
    }

    /* Style for the pagination */
    .tr-pagination {
        margin-top: 20px;
        text-align: center;
    }

    .tr-pagination a {
        display: inline-block;
        margin-right: 5px;
        padding: 8px 12px;
        background-color: #007cba;
        color: #ffffff;
        text-decoration: none;
        border-radius: 4px;
    }

    .tr-pagination a:hover {
        background-color: #005f8d;
    }

    .tr-pagination a:active {
        background-color: #004c68;
    }

    </style>
    <?php
    wp_die();

}

add_action('wp_ajax_tr_load_tasks', 'tr_load_tasks_callback');




?>