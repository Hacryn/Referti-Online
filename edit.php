<?php

    session_start();
    include_once("common.php");

    $id = $_SESSION['UID'];
    $rl = $_SESSION['role'];

    if ($rl == "") {
        header('Location: index.html?login=none');
        die();
    }

    $paziente = $_POST['patient'];
    $titolo = $_POST['titolo'];

    $rid = $_GET['rid'];

    query("UPDATE Referto SET PID = $paziente, Titolo = '$titolo' WHERE ID = $rid");

    header("Location: referto.php?rid=$rid&action=look");
    
?>