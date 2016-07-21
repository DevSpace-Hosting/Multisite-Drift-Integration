<?php
/*
Plugin Name: UserReport & Drift for Multisite
Plugin URI: https://marcwoodyard.com
Description: Enables network admins to enable UserReport and Drift on their multisite network.
Version: 2.0
Author: Marc Woodyard
Author URI: https://marcwoodyard.com
*/

add_action('muplugins_loaded', 'admin_dashboard_or_nah');
//Are we on the frontend or backend?
function admin_dashboard_or_nah()
{
    if(is_admin())
    {
        //We're on the backend.
        add_action('admin_menu', 'admin_load_drift');
    
        function admin_load_drift() 
        {
            //Get current site info.
            $blog_id = get_current_blog_id();
            //If we're in a subsite's admin panel and the user is a subsite admimn, display Drift.
            if($blog_id >= 2 && current_user_can('administrator'))
            {
                add_action('admin_enqueue_scripts', 'enqueue_drift_script');
                add_action('admin_enqueue_scripts', 'enqueue_user_report_script');
            }
            //If we're in the main site's admin panel, display to all users.
            else if($blog_id == 1)
            {
                add_action('admin_enqueue_scripts', 'enqueue_drift_script');
                add_action('admin_enqueue_scripts', 'enqueue_user_report_script');
            }
        } 
    }
    else if(!is_admin())
    {
        //We're on the front end.
        add_action('plugins_loaded', 'frontend_load_drift');
        
        function frontend_load_drift()
        {
            //Get current site info.
            $blog_id = get_current_blog_id();
            //If we're on the front end of the main site or another site, show drift to all users.
            if($blog_id == 1)
            {
                add_action('wp_enqueue_scripts', 'enqueue_drift_script');
            }
        }
    }
}
//Register the script with WordPress.
function enqueue_drift_script() 
{
    //Enqueue the script.
    wp_enqueue_script('drift-script', plugins_url('drift-script.js', __FILE__), array('jquery'),'0.1', true);
}

function enqueue_user_report_script()
{
    wp_enqueue_script('user-report-script', plugins_url('user-report-script.js', __FILE__), array('jquery'),'0.1', true);
}
//End of plugin.
?>
