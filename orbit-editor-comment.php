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
define('ORBIT_EC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('ORBIT_EC_TEMPLATE_DIR', ORBIT_EC_PLUGIN_DIR . 'templates/' );


$inc_files = array(
	'Singleton.php',
	'src/Bootstrap.php',
);


foreach ( $inc_files as $file ) {
	require_once( $file );
}
