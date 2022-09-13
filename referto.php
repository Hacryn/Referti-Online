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

    if ($_GET['action'] == NULL) {
        $rid = $_GET['rid'];
        header("Location: referto.php?rid=$rid&action=look");
        die();
    }

    $report = report(@$_GET['rid']);

?>

<html lang="it">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>Referti Online</title>
	
	<style>
		body{background-color: #212529; color: white}
        form{margin:50px}
        .display-1{color: white; text-align: center;}
        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none;
        }
	</style>
</head>
<body>
    <nav id="NavBar" class="navbar navbar-dark bg-dark">
        <ul class="nav">
            <li class="nav-item">
			    <a class="nav-link active" href="home.php"><b>Home</b></a>
		    </li> 
            <!-- Menù personalizzato -->
            <?php
                echo(nav_menu($rl));
            ?>
            <li class="nav-item">
			    <a class="nav-link" href="exit.php">Esci</a>
		    </li>
        </ul>
    </nav>
    <br>
    <div id="ReportBox" class="h-flex container">
    <?php
        if ($_GET['action'] == 'new') {
            echo(report_form($report));
        }
        elseif ($_GET['action'] == 'edit') {
            echo(report_form($report));
            echo(actions($report, $rl, TRUE));
        }
        else {
            echo(report_table($report));

            if ($_GET['action'] == 'upload') {
                echo(uploader($_GET['rid']));//to upload?rid=<rid>
            }
            if ($_GET['action'] == 'delete') {
                echo(deleter($_GET['rid'])); //to delete?rid=<rid>
            }
            if ($_GET['action'] == 'look') {
                echo(actions($report, $rl, TRUE));
            }
        }
    ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
