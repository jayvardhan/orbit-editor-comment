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
		add_action( 'wp_ajax_orbit_oec_comment_count', array( $this, 'editorsCommentCount' ) );
		add_action( 'wp_ajax_orbit_oec_load_form', array( $this, 'loadForm' ) );
		add_action( 'wp_ajax_orbit_oec_post_comment', array( $this, 'saveComment' ) );
		add_action( 'wp_ajax_orbit_oec_delete_comment', array( $this, 'deleteComment' ) );
		
		add_filter( 'template_include', array( $this, 'pageTemplates' ) );

	}

	
	/**
	 * Callback Function to load Comments Snippet form on single.php
	 *
	 **/
	function snippetForm()
	{
		ob_start();

		if( $this->hasEditorCommented( $_GET['pid'] ) ) {
			
			$comments = $this->getComments($_GET['pid']);
	 		include  ORBIT_EC_TEMPLATE_DIR . "snippet-box.php";
	 	
	 	} else {
	 		echo "<div></div>";
	 	}
	 	
	 	echo ob_get_clean();
	 	
	 	wp_die();

	}

	/**
	 * Checks whether editor's team has made comment or not
	 *
	 **/
	function hasEditorCommented( $postID )
	{
		$db = DB::getInstance();

		$records = $db->commentedBy($postID);
		
		if( is_array($records) && count($records) ) {
			
			$post_author_id = get_post_field( 'post_author', $postID );
			$temp = array();	
			
			foreach ($records as $key => $value) {
				if( $post_author_id != $value[0] ) {
					$temp[] = $value[0];
				} 
			}

			if( count($temp) ) {
				return true;
			}
		}

		return false;
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
	 	
	 	include  ORBIT_EC_TEMPLATE_DIR . "form-tmpl.php";
	 	
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
	 * Returns total number of comments made by editorial members on given postID
	 *
	 **/
	function editorsCommentCount()
	{
		ob_start();

		$db = DB::getInstance();

		$count = $db->editorsCommentCount($_GET['pid']);

		$count = $count[0][0];

		if($count) {

			$oec_page_url = get_permalink( get_page_by_path( 'editors-comment' ) ) . "?pid=".$_GET['pid'];

			if( $count > 1) {
				echo "<a href='". $oec_page_url ."'>" .$count. " editor Comments </a>";
			} else {
				echo $count . " editor Comment";
			}
		}
		
		echo ob_get_clean();		

		wp_die();
	}

	/**
	 * Posts Comment
	 *
	 **/
	function saveComment()
	{
		$postID = (int) sanitize_text_field($_POST['pid']);
		$userID = (int) sanitize_text_field($_POST['uid']);
		//$comment = sanitize_text_field($_POST['comment']);
		$comment = $_POST['comment'];
		
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
	 * callback function for deleting comment
	 *
	 **/
	function deleteComment()
	{
		$db = DB::getInstance();
		$result = $db->deleteComment($_GET['cid'], $_GET['uid']);

		if( $result ) {
			echo "success";
		} else {
			echo "fail";
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
	 * checks if current user is among moderators
	 *
	 * @return true|false
	 **/
	function is_moderator()
	{
		return ( current_user_can('editor') || current_user_can('administrator') );
	}


	/**
	 * returns delete link for moderators
	 * 
	 * 
	 **/
	function delete_link($obj)
	{
		$post_author = get_post_field('post_author', $obj['post_id']);

		if($post_author != $obj['commented_by'] && $this->is_moderator() ) {
			echo "<span class='oec-comment-delete' data-url='". admin_url('admin-ajax.php') ."?action=orbit_oec_delete_comment&cid=".$obj['ID']."&uid=".get_current_user_id()."' >delete</span>";
		}
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
			$new_template = ORBIT_EC_TEMPLATE_DIR . 'tmpl-editors-comment.php';
		
			if(file_exists($new_template)) {
				//echo "file exits";
				return $new_template;
			}	
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