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

?>

<!-- Funzioni della pagina -->
<?php
    function operator_action($text, $link) {
        $link = "";
        $result = "<input class='btn btn-primary space'type='submit' name='go' value='$text'>";
        $result = $result . "<input class='btn btn-secondary space' type='reset' name='go' value='Pulisci'>";
        /*if ($link) {
            $result = $result . "<a class='btn btn-danger space' href='$link'>Elimina</a>";
        }*/
        return $result;
    }
    
    function get_operator_line($operator) {
        if ($operator) {
            $id = $operator['ID'];
            $cf = $operator['CF'];
            $nome = $operator['Nome'];
            $cognome = $operator['Cognome'];
            $required = "";
            $link = "gestione.php?id=$id";
            $azioni = operator_action("Modifica", "$link&flag=delete");
        } else {
            $id = "";
            $cf = "";
            $nome = "";
            $cognome = "";
            $required = "required";
            $link = "gestione.php";
            $azioni = operator_action("Registra", NULL);
        }

        $result = "<tr> <form method='POST' action='$link'>";
        $result = $result . "<td> <input class='form-control' type='text' name='nome' id='nome' value='$nome' $required> </td>";
        $result = $result . "<td> <input class='form-control' type='text' name='cognome' id='cognome' value='$cognome' $required> </td>";
        $result = $result . "<td> <input class='form-control' type='text' name='cf' id='cf' value='$cf' $required> </td>";
        $result = $result . "<td> <input class='form-control' type='text' name='password' id='password' value='' $required> </td>";
        $result = $result . "<td> $azioni </td>";
        $result = $result . "</form> </tr>";

        return $result;
    }
    
    function operators($id) {
        $operators = query("SELECT Operatore.* FROM Operatore
        WHERE Operatore.FID = $id");
        $result = "";
        while ($operator = mysql_fetch_array($operators)) {
            $result = $result . get_operator_line($operator);
        }
        $result = $result . get_operator_line(NULL);
        return $result;
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
        .space{margin: 1px};
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
            <th scope="col">Nome</th>    
            <th scope="col">Cognome</th>
            <th scope="col">Codice Fiscale</th>
            <th scope="col">Password</th>
            <th scope="col">Azioni</th>
        </tr>
        <?php
        echo(operators($id));
        ?>
    </table>
    </div>
    </div>
    <div id="InfoBox" class="h-flex container">
        <?php 
            if (@$_GET['result'] == 'nocf') {
                echo "Il codice fiscale inserito non è valido";
            }
            if (@$_GET['result'] == 'exist') {
                echo "Questo operatore è già inserito";
            }
        ?>
    </div>  
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
