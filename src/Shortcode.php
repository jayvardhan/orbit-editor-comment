<?php


/**
 * This class exposes all shortcodes available for this plugin
 **/
class Shortcode extends Singleton 
{

	function __construct()
	{
		add_shortcode( 'orbit_editor_comment_form_loader', array( $this, 'commentFormLoader') );	
	}


	/**
	 * Callback function for shortcode 'orbit_editor_comment_form_loader'
	 *
	 * @return html container for triggering ajax request
	 **/	
	function commentFormLoader( $atts ) 
	{
		if( isset($atts['post_id']) && isset($atts['user_id']) ){
			$post_id = $atts['post_id'];
			$user_id = $atts['user_id'];

			echo "<div class='orbit-editor-comment' data-behaviour='orbit-editor-comment' data-pid='" .$post_id. "' data-uid='". $user_id ."' ></div>";
		} else {
			echo "Insufficient Parameters!";
		}
		
	}

} // End Of Class

Shortcode::getInstance();