<?php
    require_once("../functions.php");

    $activity_id = isset( $_POST[ "activity_id" ] ) && !empty( $_POST[ "activity_id" ] ) ? $_POST[ "activity_id" ] : null;

    if ( $activity_id ) {
        $respond = $database->delete_activity_by_id( $activity_id );
    }

    echo json_encode(array("respond" => $respond));