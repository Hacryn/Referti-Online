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

    $rid = $_GET['rid'];

    $pid = mysql_fetch_array(query("SELECT PID FROM Referto WHERE ID = $rid"));
    $pid = $pid['PID'];

    $basename = basename($_FILES['report']['name']);
    $filename = hash('sha256', $basename);
    $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
    $target = "files/$pid/$filename.$ext";

    if (!is_dir("files/$pid/")) {
        mkdir("files/$pid/");
    }

    if ($ext != 'pdf' and  
        $ext != 'zip' and 
        $ext != 'rar' and 
        $ext != '7zip' and 
        $ext != 'jpeg' and 
        $ext != 'jpg' and 
        $ext != 'png' and 
        $ext != 'gif') {
        header("Location: referto.php?rid=$rid&action=look&result=wrong_ext");
        die();
    }

    $check = move_uploaded_file($_FILES['report']['tmp_name'], $target);

    if (!$check) {
        header("Location: referto.php?rid=$rid&action=look&result=failed");
        die();
    }

    query("UPDATE Referto SET Caricamento = current_timestamp() WHERE ID = $rid");
    query("UPDATE Referto SET Filepath = '$target' WHERE ID = $rid");

    header("Location: referto.php?rid=$rid&action=look");

?>