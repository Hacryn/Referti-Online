<?php

    session_start();
    include_once("common.php");

    $id = $_SESSION['UID'];
    $rl = $_SESSION['role'];

    if ($rl == "") {
        header('Location: index.html?login=none');
        die();
    }

    if ($rl != 'operator') {
        header('Location: home.php');
        die();
    }

    $titolo = $_POST['titolo'];

    $rid = $_GET['rid'];

    $report = report(@$_GET['rid']);

    if(!has_access($report, $id, $rl)) {
        header('Location: home.php');
        die();
    }

    query("UPDATE Referto SET Titolo = '$titolo' WHERE ID = $rid");

    header("Location: referto.php?rid=$rid&action=look");
    
?>