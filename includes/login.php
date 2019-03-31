<?php
    require_once("../functions.php");

    $login = $user->login();


    if ($login) {
        header("Location: " . BASE_URL . "/index.php");
    } else {
        header("Location: " . BASE_URL . "/login.php?error=true");
    }
    exit();