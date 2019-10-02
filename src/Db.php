<?php 


/**
 * A Singleton class that handles creation of a database table.
 **/
class DB extends Singleton 
{

	protected $table;

	function __construct() 
	{
		$this->create();
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

		$this->table = $wpdb->prefix . 'orbit_editor_comments';

		$sql = "CREATE TABLE IF NOT EXISTS ". $this->table ." ( 
	    			ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	    			post_id bigint(20) unsigned NOT NULL DEFAULT 0,
					commented_by bigint(20) unsigned NOT NULL DEFAULT 0,
					comment varchar(255),
					commented_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY ( ID )
				)$charset_collate;";
		
		return $wpdb->query( $sql );
	}

} // End OF Class

DB::getInstance();
