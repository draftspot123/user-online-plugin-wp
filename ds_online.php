<?php
/**
 * Plugin Name:       DS Online Now
 * Plugin URI:        https://github.com/draftspot123/user-online-plugin-wp
 * Description:       An simple plugin that will display logged users real time
 * Version:           0.1.0
 * Author:            flashrad
 * Author URI:        
 * Text Domain:       ds-online-now
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

function ds_login_function( $user_login, $user ) {
    update_user_meta($user->ID,'login_state',1);
}
add_action('wp_login', 'ds_login_function', 10, 2);

function ds_logout_function( $user_id ) {
    update_user_meta($user_id,'login_state',0);
    wp_redirect( bloginfo('url') );
}
add_action('wp_logout', 'ds_logout_function', 10, 2);

function ds_check_function() {
    $args=array(
        'meta_key' => 'login_state',
        'meta_value' => '1'
    );
    $logged_users=get_users($args);
    return $logged_users;
}
function ds_view_function() {
    $logged_users=ds_check_function();
    ob_start();
    foreach($logged_users as $item){
        echo "<span>".$item->display_name."</span>";
        /*var_dump($item);*/
    }
    return ob_get_clean()/**/;
}
add_shortcode( 'ds_online_now', 'ds_view_function' );

