<?php 
require_once "Table.class.php";

/**
 * Activity table.
 */
class ActivityTable extends Table {
    private $my_activities  = false;
    private $activity_user_id;
    private $user_id;
    private $account_type;
    private $database;
    private $titles_my_activity = ["Title", "Tags", "Priority", "Due date"];
    private $titles             = ["Title", "Tags", "Priority", "Due date", "User"];

    /**
	 * Constructor.
	 *
	 * @param 	object 	$database	        Database object.
     * @param 	int 	$user_id	        User id.
     * @param 	int 	$account_type	    User acount type. Values: 0 - normal user, 1 - user with privileges; 
     * @param   bool    $activity_user_id   Optional. Display activities table for the user with this id. Default null.
	 */
    public function __construct( $database, $user_id, $account_type, $activity_user_id = null ) {

        $this->database         = $database;
        $this->activity_user_id = $activity_user_id == null || $activity_user_id == 0 ? null : $activity_user_id;
        $this->account_type     = $account_type;
        $this->user_id          = $user_id;

        $this->my_activities = $activity_user_id == $user_id ? true : false;

        if ( $this->activity_user_id ) {
            $values = $this->database->get_activities_by_userid( $this->activity_user_id );
        } else {
            $values = $this->database->get_activities();
        }

        // put values into input fields
        $values = array_map( array( $this, "format_cells" ), $values );

        // add action buttons if activities are mine or I have privileges
        if ( $this->account_type == 1 || $this->activity_user_id ) {
            $values = array_map( array( $this, "add_actions_buttons"), $values );

            if ( $this->my_activities ) {
                array_push( $this->titles_my_activity, "" );
            } else {
                array_push( $this->titles, "" );
            }
        }

        $thead = $this->do_thead( $this->my_activities ? $this->titles_my_activity : $this->titles );
        $tbody = $this->do_tbody( $values );

        echo $this->do_table( $thead . $tbody, "table" );
    }

	/**
	 * Put all values into input fields.
	 *
	 * @param   string 	$entries		Tag name.
     * 
	 * @return 	array 	Returns array with new values.
	 */
    private function format_cells( $entries ) {

        if ( !is_array( $entries ) ) {
            return array();
        }

        foreach ( $entries as $key => $value ) {

            // ignore id filed
            if ( $key == "id" ) {
                continue;
            } 

            $input_type = "text";

            if ( $key == "priority" ) { 
                $input_type = "number";
            } else if ( $key == "due_date" ) {
                $input_type = "date";
            } else if ( $key == "user" ) {
                continue;
            }

            $entries[ $key ] = $this->do_input( $input_type, $value, $key, true ); 
        }

        return $entries;
    }

	/**
	 * Create input field.
	 *
	 * @param 	string 	$type		Input type.
     * @param 	string 	$value		Value of input field.
     * @param 	string 	$name		Value of name attribute.
     * @param 	bool 	$readonly	Read-only attribute.
     * 
	 * @return 	string 	Input field.
	 */
    private function do_input( $type, $value, $name, $readonly = false ) {
        return "<input type=\"" . $type . "\" name=\"" . $name .  "\" value=\"" . $value . "\"" . ($readonly ? " readonly" : "" ) . ">";
    }

    /**
	 * Adds a new column in array with actions buttons.
	 *
	 * @param 	array 	$$entries   Array of activities.
     * 
	 * @return 	array 	The array with a new column named "buttons".
	 */
    private function add_actions_buttons( $entries ) {
        
        $button = '<button type="button" class="btn btn-warning edit-activity" title="Edit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
        $button .= '<button type="button" class="btn btn-danger delete-activity" title="Delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
        $button .= '<button type="button" class="btn btn-success save-activity" title="Save"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>';
        $button .= '<button type="button" class="btn btn-secondary cancel-activity" title="Cancel"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>';

        $entries[ "buttons" ] = $button;
        return $entries ;
    }
}
