<?php

/**
 * This class handles loading, enqueuing and scafolding plugin functionality
 **/
class Bootstrap extends Singleton 
{

	public function __construct() 
	{
		$this->loadFiles();

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueAssets' ) );
	}


	/**
	 * Loads core files
	 **/
	public function loadFiles()
	{
		$inc_files = array(
			'Db.php',
			'Shortcode.php'
		);

		foreach ($inc_files as $file) {
			require_once( $file );
		}
	}


	/**
	 * Enqueue Styles and Scripts
	 **/
	public function enqueueAssets()
	{
		$plugin_assets_folder = "orbit-editor-comment/assets/";

		wp_enqueue_style(
	    	'orbit-ec-css',
	    	plugins_url( $plugin_assets_folder. 'oec.css' ),
	    	array(), 
	    	ORBIT_EC_VERSION
	    );

	    wp_enqueue_script(
			'orbit-ec-js',
			plugins_url( $plugin_assets_folder.'oec.js' ),
			array( 'jquery'),
			ORBIT_EC_VERSION,
			true
		);
	}

} //End Of Class

Bootstrap::getInstance();