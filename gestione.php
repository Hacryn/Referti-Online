<!doctype html>

<!-- Gestione della sessione -->
<?php

    session_start();
    include_once("common.php");

    $id = $_SESSION['UID'];
    $rl = $_SESSION['role'];

    if ($rl == "") {
        header('Location: index.html?login=none');
        die();
    }

    if ($rl != "facility") {
        header('Location: home.php');
        die();
    }

    $cf = $_POST['cf'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $password = $_POST['password'];

    if (strlen($cf) != 16) {
        header('Location: operatori.php?result=nocf');
        die();
    }

    if (@$_GET['flag'] = 'delete' and @$_GET['id']) {
        /*$oid = $_GET['id'];
        $query = "DELETE FROM Operatore
        WHERE ID = $oid AND FID = $id";*/
    } elseif (@$_GET['id']) {
        $oid = $_GET['id'];
        if ($password == '') {
            $query = "UPDATE Operatore
            SET CF='$cf', Nome='$nome', Cognome='$cognome'
            WHERE ID = $oid AND FID = $id";
        } else {
            $password = hash('sha256', $password);
            $query = "UPDATE Operatore
            SET CF='$cf', Nome='$nome', Cognome='$cognome', PW='$password'
            WHERE ID = $oid AND FID = $id";
        }
        $check = "SELECT * FROM Operatore
        WHERE ID <> $oid AND CF = '$cf'";
        if(mysql_fetch_array(query($check))) {
            header('Location: operatori.php?result=exist');
            die();
        }
    } else {
        $password = hash('sha256', $password);
        $query = "INSERT INTO Operatore
        VALUES (NULL, '$cf',  '$password', '$nome', '$cognome', $id)";
        $check = "SELECT * FROM Operatore
        WHERE CF = '$cf'";
        if(mysql_fetch_array(query($check))) {
            header('Location: operatori.php?result=exist');
            die();
        }
    }

    query($query);

    header('Location: operatori.php');

?>