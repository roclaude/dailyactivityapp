<?php require_once(dirname(__FILE__) . "/functions.php"); 

    if ($user->is_loggedin()) {
        header( "Location: dashboard.php?uid=" . $user->__get( "id" ) );
        exit();
    } else {
        header( "Location: login.php" );
        exit();
    }
