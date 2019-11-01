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
	 * Retrieves comments for given postID
	 *
	 **/
	function getComments($postID)
	{
		global $wpdb;
		
		$sql = "SELECT * FROM " . $this->getTable() . " WHERE post_id=". $postID;

		return $wpdb->get_results($sql, ARRAY_A);
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
