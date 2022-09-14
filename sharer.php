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

    $report = report(@$_GET['rid']);

    if(!$report) {
        $report['OID'] = -1;
    }

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
	</style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
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
    <div class="h-flex container">
    <?php
        echo(sharer($report['OID'], $id, 'patient'));
    ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>