<?php

    session_start();
    include_once("common.php");

    $id = $_SESSION['UID'];
    $rl = $_SESSION['role'];

    if ($rl == "") {
        header('Location: index.html?login=none');
        die();
    }

    if ($rl != 'patient') {
        header('Location: home.php');
        die();
    }

    if (!$_POST['operatore']) {
        header('Location: home.php');
        die();
    }

    $operatore = $_POST['operatore'];

    if ($operatore == -1) {
        header('Location: referti.php');
    }

    if ($_GET['rid']) {
        $value = $_GET['rid'];
        $table = 'lettura_referto';

        $report = report(@$_GET['rid']);

        if(!has_access($report, $id, $rl)) {
            header('Location: home.php');
            die();
        }

    } else {
        $value = $id;
        $table = 'lettura_paziente';
        
        query("DELETE FROM lettura_referto WHERE OID = $operatore");
    }

    query("INSERT INTO $table VALUES ($value, $operatore)");

    header('Location: referti.php');

?>