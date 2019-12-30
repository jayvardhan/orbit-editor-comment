<?php

class OecEmail extends Singleton
{
	function __construct()
	{
		//action hook to be used by wp_schedule_single_event
		//add_action( 'oec_cron_mail', array($this, 'oec_cron_mail'), 10, 4 );
	}

	/**
	 * action hook callback function
	 *
	 **/
	function oec_cron_mail($to, $subject, $body, $header)
	{
		wp_mail($to, $subject, $body, $header);
	}
	
	/**
	 * 
	 * Use this function to schedule email. 
	 *
	 **/
	/*function scheduleEmail($to, $subject, $body, $header)
	{
		$args = array(
				'to'		=> $to,
				'subject'	=> $subject,
				'body'		=> $body,
				'header'	=> $header	
			);
			
		if(!wp_next_scheduled( 'oec_cron_mail' )){
			wp_schedule_single_event( time(), 'oec_cron_mail', $args );
		}
	}*/

	
	function emailNotification($recipients, $postID, $comment) 
	{
		$postTitle   = ucwords(get_the_title($postID)); 
		$authorID 	 = get_post_field( 'post_author', $postID );
		$authorEmail = get_the_author_meta('user_email', $authorID);

		$text_fragment = ":";
		$url = get_permalink( get_page_by_path( 'editors-comment' ) ) . "?pid=". $postID;

		if( in_array($authorID, $recipients) ){
			$to 			= $authorEmail;
			$name 			= get_the_author_meta('display_name', $authorID);
			$text_fragment 	= "from a Youth Ki Awaaz Editor, " . get_the_author_meta('display_name', $userID) . " :";
		} else {
			
			$to = "";
			foreach ($recipients as $id) {
				$to .=  get_the_author_meta('user_email', $id) . ", ";
			}

			$to 	= rtrim($to, ", ");
			$name 	= "Admin";
		}


		$subject = "[Editor's Comment] $postTitle";
		$body 	 = "<h4>Hi User,</h4>".
				   "<p>Your post on Youth Ki Awaaz:  <span style='font-weight:700;'>$postTitle</span> has recieved following comment $text_fragment</p>".
				   "<div style='border:5px solid #e6e6e6; padding: 10px;'>".$comment."</div>".
				   "<p>To respond to this feedback, click <a href='".$url."'>here</a>.</p>";
		$headers = array('Content-Type: text/html; charset=UTF-8');

		//$this->scheduleEmail( $to, $subject, $body, $headers );

		if(function_exists('yka_mail')) {
			yka_mail( $to, $subject, $body, $headers );
		} else {
			wp_mail( $to, $subject, $body, $headers );
		}
	}

}

//global instance variable for OecMain class
global $oecMail;

$oecMail = OecEmail::getInstance();

