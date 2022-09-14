<!-- Gestione della sessione -->
<?php

    session_start();
    include_once("common.php");

    $id = $_SESSION['UID'];
    $rl = $_SESSION['role'];

    if ($rl == "" or !$_GET['rid']) {
        header('Location: index.html?login=none');
        die();
    }

    if ($rl != 'operator') {
        header('Location: home.php');
        die();
    }

    $rid = @$_GET['rid'];
    $report = report(@$_GET['rid']);

    if(!has_access($report, $id, $rl)) {
        header('Location: home.php');
        die();
    }

    $file = mysql_fetch_array(query("SELECT ID, Filepath FROM Referto WHERE ID = $rid"));

    @unlink($file['Filepath']);

    query("DELETE FROM Referto WHERE ID = $rid");

    header('Location: referti.php');

?>