<?php
/**
 * This class exposes all shortcodes available for this plugin
 **/
class Shortcode extends Singleton 
{

	function __construct()
	{
		add_shortcode( 'orbit_ec_form_loader', array( $this, 'formLoader') );
		add_shortcode( 'orbit_ec_post_list', array($this, 'postList') );
		add_shortcode( 'orbit_ec_hidden_email_recipient', array($this, 'hiddenEmailRecipient') );	
	}


	/**
	 * Callback function for shortcode 'orbit_editor_comment_form_loader'
	 *
	 * @return html container for triggering ajax request to load form
	 **/	
	function formLoader( $atts ) 
	{
		if( isset($atts['post_id']) ){

			wp_enqueue_media();	
			wp_enqueue_editor();

			$post_id = $atts['post_id'];
			$user_id = get_current_user_id();

			echo "<div class='orbit-editor-comment' data-behaviour='orbit-oec-form' data-pid='" .$post_id. "' data-uid='". $user_id ."' data-url='". admin_url("admin-ajax.php") ."?action=orbit_oec_load_form'></div>";
		} else {
			echo "Insufficient Parameters!";
		}
		
	}

	/**
	 * Return Paginated Post List with link to make comment
	 *  
	 **/
	function postList($atts)
	{
		ob_start();

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		
		$args = array(
			'post_type' 	 => 'post',
			'post_status' 	 => 'publish',
			'posts_per_page' => 10,
			'paged'          => $paged,
		);

		$query = new WP_Query($args);
		
		$db = DB::getInstance();
		$url = get_permalink( get_page_by_path( 'editors-comment' ) ) . "?pid=";
		
		if($query->have_posts()){
			include  ORBIT_EC_TEMPLATE_DIR . "post-list.php";
		}
		 
		return ob_get_clean();

	}

	/**
	 * return hidden form field of user_id for email notification 
	 * 
	 **/
	function hiddenEmailRecipient($atts)
	{
		$pid = $atts['pid'];
		$post_author = $atts['post_author'];
		$logged_in_user = $atts['logged_in_user'];

		$app = APP::getInstance();

		$moderator_id = $app->getEmailRecipient( $pid, $post_author, $logged_in_user );
		
		
		echo '<input type="hidden" name="oec-recipient" value="'.$moderator_id.'"/ >';
	}


} // End Of Class

Shortcode::getInstance();