<?php

    // Check if PHP is not 5
    if (phpversion()[0] != '5') {
        include_once('sql_driver.php');
    }

    include_once("common.php");

    $PATIENT = 'patient';
    $OPERATOR = 'operator';
    $FACILITY = 'facility';

    $nome = $_POST['nome'];
    $cognome = @$_POST['cognome'];
    $cf = $_POST['cf'];
    $pw = hash('sha256', $_POST['password']);
    $role = $_POST['role'];

    if ($role == 'patient') {
        $query = "SELECT * FROM Paziente
        WHERE CF='$cf'";
        if (mysql_fetch_array(query($query))) {
            header("Location: signin.html?msg=exist");
            die();
        }
        $query = "INSERT INTO Paziente
        VALUES (Null, '$cf', '$pw', '$nome', '$cognome')";
        query($query);
    } elseif ($role == 'facility') {
        $query = "SELECT * FROM Struttura
        WHERE CF='$cf'";
        if (mysql_fetch_array(query($query))) {
            header("Location: signin.html?msg=exist");
            die();
        }
        $query = "INSERT INTO Struttura
        VALUES (Null, '$cf', '$pw', '$nome')";
        query($query);
    }

    header('Location: index.html');

?>

