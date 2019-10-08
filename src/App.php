<?php
/**
 * Handles Form And Comments
 *
 **/
class App extends Singleton
{
	function __construct()
	{
		add_action( 'wp_ajax_orbit_oec_load_form', array( $this, 'loadForm' ) );
		add_action( 'wp_ajax_orbit_oec_post_comment', array( $this, 'saveComment' ) );

	}

	/**
	  * Ajax Callback to handle loading of form 
	  *
	  **/
	function loadForm()
	{
	 	ob_start();

	 	$comments = $this->getComments($_GET['pid']);
	 	$user = get_userdata($_GET['uid'])->data;
	 	
	 	include "templates/tmpl-comment-box.php";
	 	
	 	echo ob_get_clean();
	 	
	 	wp_die();
	}

	/**
	 * Returns comments associated with postID
	 *
	 **/
	function getComments($postID)
	{
		$db = DB::getInstance();

		return $db->getComments($postID);
	}

	/**
	 * Posts Comment
	 *
	 **/
	function saveComment()
	{
		$postID = (int) sanitize_text_field($_POST['pid']);
		$userID = (int) sanitize_text_field($_POST['uid']);
		$comment = sanitize_text_field($_POST['comment']);
		
		$db = DB::getInstance();
		$db->saveComment( $postID, $userID, $comment );

		wp_die();
	}

} 

App::getInstance();