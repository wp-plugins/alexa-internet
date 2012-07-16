<?php
/*
Plugin Name: Alexa Claim and Certify
Plugin URI: http://www.alexa.com/
Description: The official Alexa plugin for WordPress.
Version: 1.0 
Author: Alexa Internet
Author URI: http://www.alexa.com/
*/

function alexacertify_install() {
	global $wpdb;
}


function alexacertify_meta() {
    $verifyId = get_option("alexacertify_verify");

    if ($verifyId) {
        echo "<meta name=\"alexaVerifyID\" content=\"$verifyId\" />\n";
    }
}


function alexacertify_footer() {
    $certifyCode = get_option("alexacertify_certify");

    if ($certifyCode) {
        echo $certifyCode . "\n";
    }
}


function alexacertify_menu() {
    include('alexacertify_admin.php');
}


function alexacertify_admin_actions() {
    $pageTitle = "Alexa Internet";
    $menuTitle = "Alexa Internet";
    $capability = 'manage_options'; 
    $menuUID = "Alexa-Internet";
    $callback = "alexacertify_menu";    
    add_options_page($pageTitle, $menuTitle, $capability, $menuUID, $callback);
}


function alexacertify_plugin_action_links( $links, $file ) {

    static $this_plugin;
    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }
    $links[] = '<a href="options-general.php?page=Alexa-Internet">Settings</a>';
    return $links;
}

add_filter( 'plugin_action_links', 'alexacertify_plugin_action_links', 10, 2 );
add_action('wp_head', 'alexacertify_meta');
add_action('admin_menu', 'alexacertify_admin_actions');
add_action('wp_footer', 'alexacertify_footer');

?>
