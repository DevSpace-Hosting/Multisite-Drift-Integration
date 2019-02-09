<?php
/*
Plugin Name: WordPress Drift Integration
Plugin URI: https://github.com/DevSpace-Hosting/WordPress-Drift-Integration
Description: Displays the Drift chat button in a WordPress website or multisite network.
Version: 2-9-2019
Author: DevSpace Hosting
Author URI: https://github.com/DevSpace-Hosting
*/

// Load Drift in /wp-admin (Recommended for multisite networks).
add_action('admin_menu', 'admin_load_drift');

// Load Drift on the main website's front end.
add_action('plugins_loaded', 'frontend_load_drift');

/*
// Load Drift in /wp-admin & main website's front end.
function admin_dashboard_or_nah() {
    if(is_admin() == true)
        add_action('admin_menu', 'admin_load_drift');

    // Load Drift on the main website's frontend.
    else if(is_admin() == false)
        add_action('plugins_loaded', 'frontend_load_drift');
}
*/

function admin_load_drift() {	            
    //If we're in a subsite's admin panel and the user is a subsite admin, display Drift.
    if(get_current_blog_id() >= 2 && current_user_can('administrator'))
        add_action('admin_enqueue_scripts', 'enqueue_drift_script');

    //If we're in the main site's admin panel, display to all users.
    else if(get_current_blog_id() == 1)
        add_action('admin_enqueue_scripts', 'enqueue_drift_script');
}

function frontend_load_drift() {
    //If we're on the front end of the main site or another site, show drift to all users.
    if(get_current_blog_id() == 1)
        add_action('wp_enqueue_scripts', 'enqueue_drift_script');
}

function enqueue_drift_script() {
    wp_enqueue_script('drift-script', plugins_url('js/drift.js', __FILE__), array('jquery'),'0.1', true);
}

?>
