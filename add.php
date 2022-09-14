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

    $cf = $_POST['patient'];
    $paziente = get_id_patient_from_cf($cf);
    $titolo = $_POST['titolo'];

    if ($paziente == -1) {
        header('Location: referto.php?action=new&result=nocf');
        die();
    }

    if ($paziente == 0) {
        $codice = generateRandomString(12);
        query("INSERT INTO Referto VALUES (NULL, $id, $paziente, '$cf','$titolo', '', current_timestamp(), null, '$codice')");
    } else {
        query("INSERT INTO Referto VALUES (NULL, $id, $paziente, '$cf','$titolo', '', current_timestamp(), null, NULL)");
    }

    $report = mysql_fetch_array(query("SELECT ID FROM Referto WHERE OID = $id AND PID = $paziente AND Titolo = '$titolo' ORDER BY ID DESC, Creazione DESC LIMIT 1"));
    $rid = $report['ID'];

    header("Location: referto.php?rid=$rid&action=look");

?>