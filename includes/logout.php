<?php
    require_once("../functions.php");

    $user->logout();

    header("Location:" . BASE_URL . "/index.php");
    exit();