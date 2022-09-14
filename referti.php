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

?>

<!-- Funzioni della pagina -->
<?php
    function report_rows($result, $rl) {
        while ($row = mysql_fetch_array($result)) {
            if ($row['PID'] == 0) {
                $paziente = $row['CF'];
            } else {
                $paziente = patient($row['PID']);
            }
            $titolo = $row['Titolo'];
            $creazione = $row['Creazione'];
            $caricamento = $row['Caricamento'];
            if($caricamento) {
                $caricamento = "✔️";
            } else {
                $caricamento = "❌";
            }
            $operator = operator($row['OID']);
            $struttura = facility_from_operator($row['OID']);
            $struttura = $struttura['Denominazione'];
            $actions = actions($row, $rl, FALSE);

            echo("<tr>");
            echo("<td>$paziente</td>");
            echo("<td>$titolo</td>");
            echo("<td>$creazione</td>");
            echo("<td>$caricamento</td>");
            //echo("<td>$operator</td>");
            echo("<td>$struttura</td>");
            echo("<td>$actions</td>");
            echo("</tr>");
        }
    }
    
    function reports($id, $rl) {

        if ($rl == 'patient')
        {
            $query = reports_query_patient($id);
            report_rows(query($query), $rl);
        }

        if ($rl == 'operator')
        {
            $query = reports_query_operator_owner($id);
            report_rows(query($query), $rl);
            $query = reports_query_operator_viewer1($id);
            report_rows(query($query), $rl);
            $query = reports_query_operator_viewer2($id);
            report_rows(query($query), $rl);
        }

        if ($rl == 'facility')
        {
            $query = reports_query_facility($id);
            report_rows(query($query), $rl);
        }

    }
?>

<html lang="it">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>Referti Online</title>
	
	<style>
        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none;
        }
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
    <br>
    <div class="row justify-content-center">
    <div class="col-auto">
    <table class="table table-dark">
        <tr>
            <th scope="col">Paziente</th>    
            <th scope="col">Titolo</th>
            <th scope="col">Data esame</th>
            <th scope="col">Scaricabile</th>
             <!--<th scope="col">Operatore</th>-->
            <th scope="col">Struttura</th>
            <th scope="col">Azioni</th>
        </tr>
        <?php
        echo(reports($id, $rl));
        ?>
    </table>
    </div>
    </div>     
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>

