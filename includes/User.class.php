<?php

class User {
    private $database;
    private $firstname;
    private $id;
    private $lastname;
    private $account_type;

    /**
	 * Constructor.
	 */
    public function __construct( $database) {
        $this->database = $database;

        if ( $this->is_loggedin() ) {

            $this->id = $this->get_session_value();

            $user_info = $this->database->get_user_by_id( $this->id );

            // no entry in database
            if ( !$user_info ) {
                return false;
            }

            $this->firstname    = $user_info[ "firstname" ];
            $this->lastname     = $user_info[ "lastname" ];
            $this->account_type = $user_info[ "account_type" ];
        }
    }

    /**
	 * User login.
	 */
    public function login() {

        $useremail      = isset( $_POST[ "useremail" ] ) && !empty( $_POST[ "useremail" ] ) ? $this->input_validation( $_POST[ "useremail" ]) : "";
        $userpass       = isset( $_POST[ "userpass" ] ) && !empty( $_POST[ "userpass" ] ) ? $this->input_validation( $_POST[ "userpass" ]) : "";
        $keeploggedin   = isset( $_POST[ "rememberme" ] ) && !empty( $_POST[ "rememberme" ] ) ? $this->input_validation( $_POST[ "rememberme" ]) : 0;

        if ( empty( $useremail ) || empty( $userpass ) ) {
            return false;
        }

        $user = $this->database->get_user_info_by_email_pass( $useremail, $userpass );

        // no entry in database
        if ( !$user ) {
            return false;
        }

        $this->id           = $user[ "id" ];
        $this->firstname    = $user[ "firstname" ];
        $this->lastname     = $user[ "lastname" ];
        $this->account_type = $user[ "account_type" ];

        if ( $keeploggedin == 1 ) {
            // set cookie

			$expire_time = time() + 86400*30*12;
    		setcookie( "userid", $this->id, $expire_time, "/" );
        } else {
            //set session

            $_SESSION[ "userid" ] = $this->id;
        }
    }

    /**
     * Prepares values ​​to be added to the database.
     * 
     * @param   string   Value to be added to database.
     * @return  string   Returns a value ready to be added to database;
	 */
    private function input_validation( $value ) {
        $value = trim( $value );
        $value = stripslashes( $value );
        $value = htmlspecialchars( $value );
        return $value;
    }

    /**
	 * User logout.
	 */
    public function logout() {

        // delete session
        unset( $_SESSION[ "userid" ] );

        // delete cookie
        unset( $_COOKIE[ "userid" ]);
        setcookie( "userid", "", time() - 3600, "/");

        return $this->is_loggedin() ? false : true;
    }

    /**
	 * Checks if the user is logged in.
     * 
     * @return  bool    Returns true if user is logged in, false if user not logged in.
	 */
    public function is_loggedin() {

        if ( isset( $_SESSION[ "userid" ] ) && !empty( $_SESSION[ "userid" ] ) ) {
            return true;
        }

        if ( isset( $_COOKIE[ "userid" ] ) && !empty( $_COOKIE[ "userid" ] ) ) {
            return true;
        }

        return false;
    }

    /**
	 * Get user id.
     * 
     * @return  bool    Return user id of the logged in user, or false if user is not logged in.
	 */
    public function get_session_value() {

        if ( isset( $_SESSION[ "userid" ] ) && !empty( $_SESSION[ "userid" ]) ) {
            return $_SESSION[ "userid" ];
        }

        if ( isset( $_COOKIE["userid"] ) && !empty( $_COOKIE[ "userid" ] ) ) {
            return $_COOKIE[ "userid" ];
        }

        return false;
    }

    /**
	 * Getter.
     * 
     * @return  mixed    Returns user property value.
	 */
    public function __get( $property ) {
        return property_exists( $this, $property ) ? $this->$property : null;
    }
}