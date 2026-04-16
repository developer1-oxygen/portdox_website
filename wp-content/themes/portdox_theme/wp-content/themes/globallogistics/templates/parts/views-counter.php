<?php
if (themerex_get_theme_option('use_ajax_views_counter')=='no') {
    themerex_set_post_views(get_the_ID());
}
