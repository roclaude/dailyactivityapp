<?php
    require_once("../functions.php");

    $values[0]      = isset( $_POST[ "activity_id" ] ) && !empty( $_POST[ "activity_id" ] ) ? $_POST[ "activity_id" ] : null;
    $values[1]      = isset( $_POST[ "title" ] ) && !empty( $_POST[ "title" ] ) ? $_POST[ "title" ] : null;
    $values[2]      = isset( $_POST[ "priority" ] ) && !empty( $_POST[ "priority" ] ) ? $_POST[ "priority" ] : null;
    $values[3]      = isset( $_POST[ "due_date" ] ) && !empty( $_POST[ "due_date" ] ) ? $_POST[ "due_date" ] : null;
    $activity_tags  = isset( $_POST[ "tags" ] ) && !empty( $_POST[ "tags" ] ) ? $_POST[ "tags" ] : null;
    
    $respond = false;

    $activityid = $values[0];

    if ( $activityid ) {
        $activity_id = $database->update_activity( $values );
        $respons_tags = $database->update_tags( $activityid, $activity_tags );
        $respond = true;
    }

    echo json_encode(array("respond" => $respond));