<?php 

class Table {

    /**
	 * Constructor.
	 */
    public function __construct() {}

    /**
	 * Create thead.
	 *
	 * @param 	array 	$titles     Array of table titles.
     * @return  string  Returns thead of the table.
	 */
    public function do_thead( $titles ) {

        if ( !is_array( $titles ) ) {
            return "";
        }

        $table_head = "";
        $table_head .= $this->do_th( "#" );
        
        foreach ( $titles as $title ) {
            $table_head .= $this->do_th( $title, str_replace( " ", "-", strtolower($title) ) );
        }

        $table_head = $this->do_tr( $table_head );
        $table_head = "<thead>" . $table_head . "</thead>";

        return $table_head;
    }

    /**
	 * Create table.
	 *
	 * @param 	array 	$content    Optional. Content of table. Default null.
     * @param 	string 	$class      Optional. Table class. Default null.
     * @param 	string 	$id         Optional. Table id. Default null.
     * @return  string  Returns table.
	 */
    public function do_table( $content = null, $class = null, $id = null ) {

        if ( empty( $content ) ) {
            return "";
        }

        $out = "<table";
        $out .= $class ? " class=\"" . $class . "\"" : "";
        $out .= $id ? " id=\"" . $id . "\"" : "";
        $out .= ">" . $content . "</table>";

        return $out;
    }

    /**
	 * Create body of table.
	 *
	 * @param 	array 	$values     All content to add into table.
     * @return  string  Returns body of the table.
	 */
    public function do_tbody( $values ) {

        if ( !is_array( $values ) ) {
            return "";
        }

        $tbody  = "";
        $i      = 0;

        foreach($values as $row) {
            $i++;

            $line           = "";
            $id_activity    = "";
            $line           .= $this->do_td( $i, "act_no" );

            foreach( $row as $key => $colval ) {

                if ( $key == "id" ) {
                    // get id of activity
                    $id_activity = $colval;
                    continue;
                }

                $line .= $this->do_td($colval);
            }

            $tbody .= $this->do_tr( $line, null, ( !empty( $id_activity ) ? ( "data-idactivity=" . $id_activity ) : null ) );
        }

        $tbody = "<tbody>" . $tbody . "</tbody>";

        return $tbody;
    }

    /**
	 * Create header cell.
	 *
	 * @param 	array 	$content    Optional. Content of th. Default null.
     * @param 	string 	$class      Optional. Table class. Default null.
     * @param 	string 	$attr       Optional. Table attributes. Default null.
     * @return  string  Returns header cell.
	 */
    public function do_th($content = null, $class = null, $attr = null) {
        return "<th" . ($class ? " class=\"" . $class . "\"" : "") . ($attr ? " " . $attr : "") . ">" . $content . "</th>";
    }

    /**
	 * Create table row.
	 *
	 * @param 	array 	$content    Optional. Content of table row. Default null.
     * @param 	string 	$class      Optional. Table row class. Default null.
     * @param 	string 	$attr       Optional. Table row attributes. Default null.
     * @return  string  Returns table row.
	 */
    public function do_tr($content = null, $class = null, $attr = null) {
        return "<tr" . ($class ? " class=\"" . $class . "\"" : "") . ($attr ? " " . $attr : "") . ">" . $content . "</tr>";
    }

    /**
	 * Create table cell.
	 *
	 * @param 	array 	$content    Optional. Content of table cell. Default null.
     * @param 	string 	$class      Optional. Table cell class. Default null.
     * @param 	string 	$attr       Optional. Table cecll attributes. Default null.
     * @return  string  Returns table cell.
	 */
    public function do_td($content = null, $class = null, $attr = null) {
        return "<td" . ($class ? " class=\"" . $class . "\"" : "") . ($attr ? " " . $attr : "") . ">" . $content . "</td>";
    }
}