<?php

/*
* Plugin Name: Editor Comment
* Plugin URI: https://sputznik.com/
* Description: Enables bi-directional communication on Article between Post Author and Editorial Team.
* Version: 1.0.0
* Author: Jay Vardhan
* Author URI: https://sputznik.com/
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


define('ORBIT_EC_VERSION', '1.0.0');


$inc_files = array(
	'Singleton.php',
	'src/Bootstrap.php',
);


foreach ( $inc_files as $file ) {
	require_once( $file );
}


/**
 * action hook callback function
 **/
function oec_cron_mail($to, $subject, $body, $header)
{
	wp_mail($to, $subject, $body, $header);
}


function oec_on_activation()
{
	//action hook to be used by wp_schedule_single_event
	add_action( 'oec_cron_mail', 'oec_cron_mail', 10, 4 );
}

function oec_on_deactivation() 
{
	remove_action('oec_cron_mail', 'oec_cron_mail', 10, 4 );
}

register_activation_hook(   __FILE__, 'oec_on_activation' );
register_deactivation_hook( __FILE__, 'oec_on_deactivation' );
