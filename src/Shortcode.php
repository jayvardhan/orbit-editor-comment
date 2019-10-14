<?php
/**
 * This class exposes all shortcodes available for this plugin
 **/
class Shortcode extends Singleton 
{

	function __construct()
	{
		add_shortcode( 'orbit_ec_form_loader', array( $this, 'formLoader') );	
	}


	/**
	 * Callback function for shortcode 'orbit_editor_comment_form_loader'
	 *
	 * @return html container for triggering ajax request to load form
	 **/	
	function formLoader( $atts ) 
	{
		if( isset($atts['post_id']) && isset($atts['user_id']) ){
			$post_id = $atts['post_id'];
			$user_id = get_current_user_id();

			echo "<div class='orbit-editor-comment' data-behaviour='orbit-oec-form' data-pid='" .$post_id. "' data-uid='". $user_id ."' data-url='". admin_url("admin-ajax.php") ."?action=orbit_oec_load_form'></div>";
		} else {
			echo "Insufficient Parameters!";
		}
		
	}

} // End Of Class

Shortcode::getInstance();