<?php

class Database {
	private $host;
	private $dbname;
	private $dbusername;
	private $dbpassword;
	public $conn;

    /**
	 * Constructor.
	 *
	 * @param 	string 	$host			Database object.
     * @param 	string 	$dbname			User id.
     * @param 	string 	$dbusername		User acount type. Values: 0 - normal user, 1 - user with privileges; 
     * @param   string	$dbpassword		Optional. Display activities table for the user with this id. Default null.
	 */
	public function __construct( $host, $dbname, $dbusername, $dbpassword ) {

		$this->host 		= $host;
		$this->dbname		= $dbname;
		$this->dbusername	= $dbusername;
		$this->dbpassword	= $dbpassword;

		$this->connect();
	}

    /**
	 * Connect to database.
	 */
	public function connect() {

		$db_servername 	= $this->host;
		$db_dbname 		= $this->dbname;
		$db_username 	= $this->dbusername;
		$db_password 	= $this->dbpassword;

		try {
			$conn = new PDO( "mysql:host=$db_servername;dbname=$db_dbname", $db_username, $db_password );
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//echo "Connected successfully";
			
			$this->conn = $conn;
		}
		catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}

	/**
	 * Get activities by user id.
	 *
	 * @param 	int 	$user_id	User id.
	 * 
	 * @return 	array 	An array containing all activities of a certain user.
	 */
	public function get_activities_by_userid( $user_id ) {

        $sql = "SELECT a.id, a.title, group_concat(t.tag_name SEPARATOR ', ') tags, a.priority, a.due_date
                    FROM activities a
                    LEFT JOIN activities_tags at
                        ON a.id = at.activity_id
                    LEFT JOIN tags t
                        ON at.tag_id = t.id
                    WHERE a.user_id = :id
					GROUP BY a.id
					ORDER BY a.due_date ASC";
        $sth = $this->conn->prepare( $sql );
        $sth->execute(
            array(
                ':id'  => $user_id
                )
			);
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	
		return $result;
	}

	/**
	 * Get all activities.
	 *
	 * @return 	array 	An array containing all activities.
	 */
	public function get_activities() {

        $sql = "SELECT a.id, a.title, group_concat(t.tag_name SEPARATOR ', ') tags, a.priority, a.due_date, CONCAT(ui.firstname, ' ', ui.lastname) as user
                    FROM activities a
                    LEFT JOIN activities_tags at
                        ON a.id = at.activity_id
                    LEFT JOIN tags t
                        ON at.tag_id = t.id
					LEFT JOIN users_info ui
						ON ui.user_id = a.user_id
					GROUP BY a.id, ui.id
					ORDER BY a.due_date ASC";
        $sth = $this->conn->prepare( $sql );
        $sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	
		return $result;
	}

	/**
	 * Delete an activity by id.
	 *
	 * @param 	int 	$activity_id	Activity id.
	 * 
	 * @return 	int		Number of affected rows.
	 */
	public function delete_activity_by_id( $activity_id ) {

		$sql = "DELETE FROM activities WHERE id = :id";
		$sth = $this->conn->prepare( $sql) ;
		$sth->execute(
			array(
				':id'  => $activity_id,
				)
			);
		$row_count = $sth->rowCount();

		return $row_count > 0 ? true : false;
	}


	/**
	 * Add new activity.
	 *
	 * @param 	array 	$activity	Array of a new activity information.
	 * @return 	int 	The id of the new activity added.
	 */
	public function add_new_activity( $activity ) {

		if ( empty( $activity ) 
			|| empty( $activity["userid"] ) 
			|| empty( $activity["title"] ) 
			|| empty( $activity["priority"] ) 
			|| empty( $activity["due_date"] ) ) {
			return false;
		} 

		$sql = "INSERT INTO activities (user_id, title, priority, due_date)
				VALUES (:user_id, :title, :priority, :due_date)";
		$sth = $this->conn->prepare( $sql );
		$sth->execute(
			array(
				':user_id'	=> $activity[ "userid" ],
				':title'	=> $activity[ "title" ],
				':priority'	=> $activity[ "priority" ],
				':due_date'	=> $activity[ "due_date" ]
				)
			);
		
		$last_id = $this->conn->lastInsertId( "activities" );

		return $last_id;
	}

	/**
	 * Update activity.
	 *
	 * @param 	array 	$values		Activity informations.
	 * 
	 * @return 	int		Returns the number of affected rows.
	 */
	public function update_activity( $values ) {

		$sql = "UPDATE activities SET title=:title, priority=:priority, due_date=:due_date
				WHERE id = :id";
		$sth = $this->conn->prepare( $sql );
		$sth->execute(
			array(
				':id'		=> $values[0],
				':title'	=> $values[1],
				':priority'	=> $values[2],
				':due_date'	=> $values[3]
				)
			);
		
		$affected = $sth->rowCount();

		return $affected;
	}

	/**
	 * Updates tags of an activity.
	 *
	 * @param 	int 	$activity_id	Activity id.
	 * @param 	int 	$tag_id			Tag id.
	 * 
	 * @return 	int		Returns the id of link between activity and tag.
	 */
	public function add_users_tags( $activity_id, $tag_id ) {

		$sql = "INSERT INTO activities_tags (activity_id, tag_id)
				VALUES (:activity_id, :tag_id)";
		$sth = $this->conn->prepare( $sql );
		$sth->execute(
			array(
				':activity_id'	=> $activity_id,
				':tag_id'		=> $tag_id
				)
			);
		
		$last_id = $this->conn->lastInsertId( "activities_tags" );

		return $last_id;
	}

	/**
	 * Removes tags of an activity.
	 *
	 * @param 	int 	$activity_id	Activity id.
	 * 
	 * @return 	bool	Returns true if activity tag was deleted or otherwise false.
	 */
	public function delete_activities_tags( $activity_id ) {

		$sql = "DELETE FROM activities_tags 
				WHERE $activity_id = :activity_id";
		$sth = $this->conn->prepare( $sql );
		$sth->execute(
			array(
				':id'  => $activity_id,
				)
			);
		$row_count = $sth->rowCount();

		return $row_count > 0 ? true : false;
	}

	/**
	 * Adds new tags to an activity.
	 *
	 * @param 	int 			$activity_id	Activity id.
	 * @param 	array|string  	$activity_tags	Tags.
	 */
	public function add_new_tags( $activity_id, $activity_tags ) {

		if ( !is_array( $activity_tags ) ) {
			$tags_arr = explode( ",", $activity_tags );
			$tags_arr = array_map( "trim", $tags_arr );
		} else {
			$tags_arr = $activity_tags;
		}

		$tags_arr = array_unique( $tags_arr );
		$tags_arr = array_filter( $tags_arr );

		$existing_tags 	= array();
		$new_tags		= array();

		foreach ( $tags_arr as $t ) {
			$tag = $this->get_tag_by_tagname( $t );

			if ( !$tag ) {
				array_push( $new_tags, $t );
			} else {
				array_push( $existing_tags, $tag[ "id" ] );
			}
		}

		array_map( array( $this, "input_validation"), $new_tags );

		foreach( $new_tags as $new_tag ) {
			$tag_id = $this->add_tag( $new_tag );
			array_push( $existing_tags, $tag_id );
		}

		foreach( $existing_tags as $tag_id ) {
			$this->add_users_tags( $activity_id, $tag_id );
		}
	}

	/**
	 * Update tags of an activity.
	 *
	 * @param 	int 			$activity_id	Activity id.
	 * @param 	array|string  	$activity_tags	Tags.
	 */
	public function update_tags( $activity_id, $activity_tags ) {

		if ( !is_array( $activity_tags ) ) {
			$tags = explode( ",", $activity_tags );
			$tags = array_map( "trim", $tags );
		} else {
			$tags = $activity_tags;
		}	

		$old_tags = $this->get_tags_by_activity_id( $activity_id );

		$old_tags = array_column( $old_tags, "tag_name" );

		$tags_to_delete = array_diff( $old_tags, $tags );
		$tags_to_add 	= array_diff( $tags, $old_tags );

		foreach( $tags_to_delete as $tag ) {
			$this->delete_tag_by_tagname( $activity_id, $tag );
		}

		foreach( $tags_to_add as $tag ) {
			$this->add_new_tags( $activity_id, $tag ); 
		}
	}

	/**
	 * Gets tags of an activity.
	 *
	 * @param 	int 	$activity_id	Activity id.
	 * 
	 * @return 	array	Returns activity tags.
	 */
	public function get_tags_by_activity_id( $activity_id ) {

		$sql = "SELECT t.id, t.tag_name
				FROM tags t
				INNER JOIN activities_tags at
					ON at.tag_id = t.id
				WHERE at.activity_id = :activity_id";
		$sth = $this->conn->prepare( $sql );
		$sth->execute(
			array(
				':activity_id'  => $activity_id
				)
			);
		return $sth->fetchAll( PDO::FETCH_ASSOC );
	}

	/**
	 * Delete tag by tag name.
	 *
	 * @param 	int 	$activity_id	Activity id.
	 * @param 	string 	$tag_name		Tag name.
	 * 
	 * @return 	bool 	True on success, false on failure.
	 */
	public function delete_tag_by_tagname( $activity_id, $tag_name ) {

		$tag_info = $this->get_tag_by_tagname( $tag_name );

		$sql 	= "DELETE FROM activities_tags
							WHERE tag_id = :tag_id";
		$sth = $this->conn->prepare( $sql );
		$sth->execute(
			array(
				':tag_id'  => $tag_info[ "id" ],
				)
			);
		$row_count = $sth->rowCount();

		return $row_count > 0 ? true : false;
	}

	/**
	 * Get tag by tag name.
	 *
	 * @param 	string 	$tag_name	The tag name.
	 * 
	 * @return 	array 	Array that contains tag information.
	 */
	public function get_tag_by_tagname( $tag_name ) {

		if ( empty( $tag_name ) ) {
			return array();
		}

        $sql = "SELECT *
                FROM tags
                WHERE tag_name = :tag_name";
        $entry = $this->conn->prepare( $sql );
        $entry->execute(
            array(
                ':tag_name'  => $tag_name
                )
            );
		$tag = $entry->fetch( PDO::FETCH_ASSOC );
		
		return $tag ? $tag : array();
	}

	/**
	 * Add new tag.
	 *
	 * @param 	string 	$tag_name	The name of the new tag.
	 * 
	 * @return 	int 	Tag id on success, false on failure.
	 */
	public function add_tag( $tag_name ) {

		if ( empty( $tag_name ) ) {
			return false;
		}

		$sql = "INSERT INTO tags (tag_name)
				VALUES (:tag_name)";
		$sth = $this->conn->prepare( $sql );
		$sth->execute(
			array(
				':tag_name'	=> $tag_name,
				)
			);
		
		$tag_id = $this->conn->lastInsertId( "tags" );

		return $tag_id;
	}

    /**
     * Prepares values ​​to be added to the database.
     * 
     * @param   string   $value		Value to be added to database.
	 * 
     * @return  string   Returns a value ready to be added to database;
	 */
	private function input_validation( $value ) {
        $value = trim( $value );
        $value = stripslashes( $value );
        $value = htmlspecialchars( $value );
        return $value;
	}
	
    /**
     * Get user information by user id.
     * 
     * @param   int   	$user_id	User id.
	 * 
     * @return  array	Returns a value ready to be added to database;
	 */
	public function get_user_by_id( $user_id ) {

        $sql = "SELECT u.id, u.email, ui.firstname, ui.lastname, u.account_type 
                    FROM users u
                    INNER JOIN users_info ui
						ON u.id = ui.user_id
					WHERE u.id = :user_id";
        $sth = $this->conn->prepare( $sql );
        $sth->execute(
			array(
				":user_id" => $user_id
			)
		);
		return $sth->fetch( PDO::FETCH_ASSOC );
	}

	/**
     * Gets all users but withot a specific user.
     * 
     * @param   int   	$user_id	User id.
	 * 
     * @return  array	Returns users;
	 */
	public function get_all_members_wo_me( $user_id ) {

        $sql = "SELECT u.id, u.email, ui.firstname, ui.lastname, u.account_type 
                    FROM users u
                    INNER JOIN users_info ui
						ON u.id = ui.user_id
					WHERE u.id != :id";
        $sth = $this->conn->prepare( $sql );
        $sth->execute(
			array(
				":id" => $user_id
			)
		);
		return $sth->fetchAll( PDO::FETCH_ASSOC );
	}

	/**
     * Gets user information by email and password.
     * 
     * @param   string   	$useremail		User email.
	 * @param   string   	$userpass		User password.
	 * 
     * @return  array	Returns user information;
	 */
	public function get_user_info_by_email_pass( $useremail, $userpass ) {
        $userpass = md5( $userpass );

        $sql = "SELECT u.id, firstname, lastname, account_type 
                    FROM users u
                    INNER JOIN users_info ui
                        ON u.id = ui.user_id
                    WHERE u.email = :email AND u.password = :pass";
        $sth = $this->conn->prepare( $sql) ;
        $sth->execute(
            array(
                ':email'  => $useremail,
                ':pass'   => $userpass
                )
            );
        return $sth->fetch( PDO::FETCH_ASSOC );
    }
}