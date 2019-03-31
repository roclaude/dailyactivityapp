<?php 
    require_once(dirname(__FILE__) . "/config.php");

    if ( session_status() == PHP_SESSION_NONE ) {
        session_start();
    }

    require_once(dirname(__FILE__) . "/includes/User.class.php");
    require_once(dirname(__FILE__) . "/includes/Database.class.php");
    require_once(dirname(__FILE__) . "/includes/ActivityTable.class.php");

    $db_servername 	= DB_HOST;
	$db_username 	= DB_USER;
	$db_password 	= DB_PASSWORD;
	$db_dbname		= DB_NAME;

    $database = new Database( DB_HOST, DB_NAME, DB_USER, DB_PASSWORD );

    $user = new User( $database );

