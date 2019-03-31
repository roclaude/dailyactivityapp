<?php
    require_once("../functions.php");

    $values[ "userid" ]     = isset( $_POST[ "userid" ] ) && !empty( $_POST[ "userid" ] ) ? $_POST[ "userid" ] : null;
    $values[ "title" ]      = isset( $_POST[ "activity_title" ] ) && !empty( $_POST[ "activity_title" ] ) ? $_POST[ "activity_title" ] : null;
    $values[ "priority" ]   = isset( $_POST[ "activity_priority" ] ) && !empty( $_POST[ "activity_priority" ] ) ? $_POST[ "activity_priority" ] : null;
    $values[ "due_date" ]   = isset( $_POST[ "activity_due_date" ] ) && !empty( $_POST[ "activity_due_date" ] ) ? $_POST[ "activity_due_date" ] : null;
    $activity_member        = isset( $_POST[ "activity_member" ] ) && !empty( $_POST[ "activity_member" ] ) ? $_POST[ "activity_member" ] : null;
    $activity_tags          = isset( $_POST[ "activity_tags" ] ) && !empty( $_POST[ "activity_tags" ] ) ? $_POST[ "activity_tags" ] : null;

    $values[ "userid" ] = $activity_member ? $activity_member : $values[ "userid" ];
    
    $userid = $values[ "userid" ];

    if ( $userid ) {
        $activity_id = $database->add_new_activity( $values );
        $respons_tags = $database->add_new_tags( $activity_id, $activity_tags );
    }

    var_dump( $user->__get( "id" ) );
    var_dump( $user->__get( "account_type" ) );

    new ActivityTable( $database, $user->__get( "id" ), $user->__get( "account_type" ), $activity_member ? null : $userid );