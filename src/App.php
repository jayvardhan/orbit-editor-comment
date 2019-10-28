<?php
/**
 * Handles Form And Comments
 *
 **/
class App extends Singleton
{
	function __construct()
	{
		add_action( 'wp_ajax_orbit_oec_snippet_form', array( $this, 'snippetForm' ) );
		add_action( 'wp_ajax_orbit_oec_load_form', array( $this, 'loadForm' ) );
		add_action( 'wp_ajax_orbit_oec_post_comment', array( $this, 'saveComment' ) );
		
		add_filter( 'template_include', array( $this, 'pageTemplates' ) );

	}

	
	/**
	 * Callback Function to load Comments Snippet form typically on single.php
	 *
	 **/
	function snippetForm()
	{
		ob_start();

	 	$comments = $this->getComments($_GET['pid']);
	 	
	 	include  ORBIT_EC_TEMPLATE_DIR . "snippet-box.php";
	 	
	 	echo ob_get_clean();
	 	
	 	wp_die();

	}


	/**
	  * Ajax Callback to handle loading of form 
	  *
	  **/
	function loadForm()
	{
	 	ob_start();

	 	$comments = $this->getComments($_GET['pid']);
	 	//$user = get_userdata($_GET['uid'])->data;
	 	
	 	include  ORBIT_EC_TEMPLATE_DIR . "comment-box.php";
	 	
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
		$insertId = $db->saveComment( $postID, $userID, $comment );

		//if insert successful schedule email notification
		if($insertId) {
			global $oecMail;
			$oecMail->emailNotification( $userID, $postID, $comment );
		}

		wp_die();
	}

	/**
	 * Heplper function to check if comment author and logged-in user are same or not 
	 *
	 * @param integer ID of user who has made comment
	 *
	 * @return boolean true|false 
	 **/
	function is_me($commented_by)
	{
		$current_logged_in_user = get_current_user_id();
		return $current_logged_in_user == $commented_by;
	}

	/**
	 * callback function to include page template from plugin
	 *
	 * @return templates
	 * @author 
	 **/
	function pageTemplates( $template )
	{
		$new_template = '';

		if(is_page('editors-comment')) {
			$template = ORBIT_EC_TEMPLATE_DIR . 'tmpl-editors-comment.php';
		}
		
		if(file_exists($new_template)) {
			//echo "file exits";
			return $new_template;
		}

		return $template;

	}

	/**
	 * Function takes string and optional number of character for its substring
	 *
	 * @return String substring of the given string
	 * @author 
	 **/
	function excerpt( $message, $len=50 )
	{
		if( strlen($message) <= $len ) {
			return $message;
		}

		return substr($message, 0, $len) . '...';
	}

} 

App::getInstance();