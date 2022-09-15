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

        if(@$_GET['flag'] == 'delete') {
            query("DELETE FROM lettura_referto
            WHERE OID = $operatore AND RID = $value");
            header('Location: referti.php');
            die();
        }

    } else {
        $value = $id;
        $table = 'lettura_paziente';

        if(@$_GET['flag'] == 'delete') {
            query("DELETE FROM lettura_paziente
            WHERE OID = $operatore AND PID = $value");
            header('Location: referti.php');
            die();
        }
        
        $set = query("SELECT ID FROM Referto
        INNER JOIN lettura_referto ON Referto.ID = lettura_referto.RID
        WHERE Referto.PID = $value");

        $rid = "-1";
        while($row = mysql_fetch_array($set)) {
            $info = $row['ID'];
            $rid =  $rid . ", $info";
        }

        query("DELETE FROM lettura_referto WHERE OID = $operatore AND
        RID IN ($rid)");
    }

    query("INSERT INTO $table VALUES ($value, $operatore)");

    header('Location: referti.php');

?>