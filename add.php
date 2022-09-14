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

    query("INSERT INTO Referto VALUES (NULL, $id, $paziente, '$titolo', '', current_timestamp(), null)");
    $report = mysql_fetch_array(query("SELECT ID FROM Referto WHERE OID = $id AND PID = $paziente AND Titolo = '$titolo' ORDER BY ID DESC, Creazione DESC LIMIT 1"));
    $rid = $report['ID'];

    header("Location: referto.php?rid=$rid&action=look");

?>