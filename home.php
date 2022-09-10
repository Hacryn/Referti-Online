<!doctype html>

<?php

    session_start();

    $rl = $_SESSION['role'];

    if ($rl == "") {
        header('Location: index.html?login=none');
        die();
    }

?>