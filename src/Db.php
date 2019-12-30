<?php 
/**
 * A Singleton class that handles creation of a database table.
**/
class DB extends Singleton 
{

	protected $table;

	function __construct() 
	{
		$this->setTable();
		$this->create();
	}


	function getTable()
	{
		return $this->table;
	}


	function setTable()
	{
		global $wpdb;

		$this->table = $wpdb->prefix . 'orbit_editor_comments';
	}




	/**
	 * Funtion to create table in database. This table is responsible for holding all 
	 * user submitted data through a custom form
	 *
	 * @return boolean indicating success or failure of sql query
	 *
	 **/
	function create() 
	{
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$table = $this->getTable();

		$sql = "CREATE TABLE IF NOT EXISTS ". $table ." ( 
	    			ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	    			post_id bigint(20) unsigned NOT NULL DEFAULT 0,
					commented_by bigint(20) unsigned NOT NULL DEFAULT 0,
					comment text,
					commented_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY ( ID )
				)$charset_collate;";
		
		return $wpdb->query( $sql );
	}

	/**
	 * Retrieves comment records for given postID
	 *
	 **/
	function getComments($postID)
	{
		global $wpdb;
		
		$sql = "SELECT * FROM " . $this->getTable() . " WHERE post_id=". $postID;

		return $wpdb->get_results($sql, ARRAY_A);
	}


	/**
	 * delete comment
	 *
	 * @return void
	 * @author 
	 **/
	function deleteComment($cid, $commented_by)
	{
		global $wpdb;

		$result = $wpdb->delete( 
			$this->getTable(), 
			array( 
				'ID' => $cid, 
				'commented_by' => $commented_by 
			) 
		);

		return $result;
	}


	/**
	 * Retrieves distinct users who have made comment on the given postID
	 *
	 **/
	function commentedBy( $postID )
	{
		global $wpdb;

		$sql = "SELECT DISTINCT commented_by FROM " . $this->getTable() . " WHERE post_id=". $postID;

		return $wpdb->get_results($sql, ARRAY_N);
	}


	/**
	 * Retrieve distinct moderator ids who have commented on a given post
	 *
	 **/
	function moderatorsId( $postID, $post_author )
	{
		global $wpdb;

		$sql = "SELECT DISTINCT commented_by FROM " . $this->getTable() . " WHERE post_id=". $postID ." AND commented_by!=". $post_author;

		return $wpdb->get_results($sql, ARRAY_N);	
	}


	/**
	 * retrieves total number of comments made by editorial team on given postID
	 *
	 **/
	function editorsCommentCount( $postID )
	{
		global $wpdb;
		$post_author_id = get_post_field( 'post_author', $postID );

		$sql = "SELECT COUNT(*) FROM " . $this->getTable() . " WHERE post_id=". $postID ." AND commented_by!=". $post_author_id;

		return $wpdb->get_results($sql, ARRAY_N);
			
	}



	/**
	 * saves comment in database
	 *
	 **/
	function saveComment( $postID, $userID, $comment )
	{
		global $wpdb;

		$wpdb->insert( 
			$this->getTable(), 
			array( 
				'post_id' 		=> $postID, 
				'commented_by' 	=> $userID,
				'comment'		=> $comment	 
			), 
			array( '%d', '%d','%s' ) 
		);

		return $wpdb->insert_id;	
	}

} // End OF Class

DB::getInstance();
