<?php

include_once("sql_driver.php");

function nav_menu($role) {

    if ($role == 'patient') {
        $menu = '<li class="nav-item">';
        $menu = $menu . '<a class="nav-link active" href="referti.php">Referti</a>';
        $menu = $menu . '</li>';
    }

    if ($role == 'operator') {
        $menu = '<li class="nav-item dropdown">';
        $menu = $menu . '<a class="nav-link dropdown-toggle" href="home.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Referti</a>';
        $menu = $menu . '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $menu = $menu . '<a class="dropdown-item" href="referto.php?action=new">Crea nuovo referto</a>';
        $menu = $menu . '<a class="dropdown-item" href="referti.php">Gestici referti</a>';
        $menu = $menu . '</div> </li>';
    }

    if ($role == 'facility') {
        $menu = '<li class="nav-item dropdown">';
        $menu = $menu . '<a class="nav-link active" href="referti.php">Referti</a>';
        $menu = $menu . '</li>';
        $menu = $menu . '<li class="nav-item dropdown">';
        $menu = $menu . '<a class="nav-link active" href="operatori.php">Operatori</a>';
        $menu = $menu . '</li>';
    }

    return $menu;
}

function user_name($id, $rl) {

    if ($rl == 'patient')
    {
        $query = 'SELECT Nome, Cognome FROM Paziente WHERE ID = ' . $id;
        $result = mysql_fetch_array(query($query));
        $result = $result['Nome'] . " " .$result['Cognome'];
    }

    if ($rl == 'operator')
    {
        $query = 'SELECT Nome, Cognome FROM Operatore WHERE ID = ' . $id;
        $result = mysql_fetch_array(query($query));
        $result = $result['Nome'] . " " .$result['Cognome'];
    }

    if ($rl == 'facility')
    {
        $query = 'SELECT Denominazione FROM Struttura WHERE ID = ' . $id;
        $result = mysql_fetch_array(query($query));
        $result = $result['Denominazione'];
    }

    return $result;
}

function patient($patient) {
    $query = "SELECT Nome, Cognome FROM Paziente WHERE ID = $patient";
    $result = mysql_fetch_array(query($query));
    return $result['Nome'] . " " . $result['Cognome'];
}

function operator($operator) {
    $query = "SELECT Nome, Cognome FROM Operatore WHERE ID = $operator";
    $result = mysql_fetch_array(query($query));
    return $result['Nome'] . " " . $result['Cognome'];
}

function button($text, $link, $attribute) {
    return "<td> <a href='$link' class='btn btn-$attribute space'> $text </a> </td>";
}

function actions($report, $role, $upload) {
    $rid = $report['ID'];
    $base = "referto.php?rid=$rid";
    $filepath = $report['Filepath'];
    $result = "<table class='table table-borderless' style='background-color: transparent'> <tr>";
    $result = $result = $result . button("Visualizza", "$base&action=look", "primary");

    if ($role == 'patient') {
        $result = $result . button("Condividi", "$base&action=share", "primary");
    }

    if ($role == 'operator' && $_SESSION['UID'] == $report['OID']) {
        if ($report['Filepath'] == NULL or $upload) {
            $result = $result . button("Carica", "$base&action=upload", "primary");
        }
        $result = $result . button("Modifica", "$base&action=edit", "primary");
        $result = $result . button("Elimina", "$base&action=delete", "danger");
    }

    $result = $result . button("Scarica", $filepath, "secondary");
    $result = $result . "</tr> </table>";
    return $result;
}

function reports_query_patient($id) {
    return "SELECT Referto.* FROM Referto WHERE PID = $id";
}

function reports_query_operator_owner($id) {
    return "SELECT Referto.* FROM Referto WHERE Referto.OID = $id";
}

function reports_query_operator_viewer1($id) {
    return "SELECT Referto.* FROM Referto
    INNER JOIN lettura_referto ON lettura_referto.RID = Referto.ID 
    INNER JOIN Operatore ON lettura_referto.OID = Operatore.ID 
    AND Operatore.ID = $id";
}

function reports_query_operator_viewer2($id) {
    return "SELECT Referto.* FROM Referto
    INNER JOIN lettura_paziente ON lettura_paziente.PID = Referto.PID 
    INNER JOIN Operatore ON lettura_paziente.OID = Operatore.ID 
    AND Operatore.ID = $id";
}

function reports_query_facility($id) {
    return "SELECT * FROM Referto
    INNER JOIN Operatore ON Referto.OID = Operatore.ID
    INNER JOIN Struttura ON Operatore.FID = Struttura.ID
    WHERE Struttura.ID = $id";
}

function facility_from_operator($oid) {
    $query = "SELECT * FROM Struttura
    INNER JOIN Operatore ON Struttura.ID = Operatore.FID
    WHERE Operatore.ID = $oid";

    return mysql_fetch_array(query($query));
}

function report($id) {
    if ($id != NULL) {
        $query = "SELECT * FROM Referto WHERE ID = $id";
        return mysql_fetch_array(query($query));
    } else {
        return NULL;
    }
}

function select_operator() {
    $query = "SELECT Operatore.ID, Nome, Cognome, Denominazione FROM Operatore 
    INNER JOIN Struttura ON Operatore.FID = Struttura.ID";
    $result = "<select name='operatore' class='form-control'>";
    while($row = mysql_fetch_array(query($query))) {
        $id = $row['ID'];
        $nome = $row['Nome'];
        $cognome = $row['Cognome'];
        $struttura = $row['Denominazione'];
        $result = $result . "<option value='$id'> $nome $cognome ($struttura) </option>";
    }
    return $result . "</select>";
}

function select_patient($patient) {
    $query = "SELECT ID, CF, Nome, Cognome FROM Paziente";
    $result = "<label for='patient'> Seleziona Paziente: </label>
    <select name='patient' class='form-control'>" ;
    $set = query($query);
    while($row = mysql_fetch_array($set)) {
        $id = $row['ID'];
        $cf = $row['CF'];
        $nome = $row['Nome'];
        $cognome = $row['Cognome'];
        if ($patient == $id) {
            $result = $result . "<option selected value='$id'> $nome $cognome ($cf) </option> ";
        } else {
            $result = $result . "<option value='$id'> $nome $cognome ($cf) </option> ";
        }
    }
    $result = $result . "</select>";
    return $result;
}

function report_form($report) {
    if ($report == NULL) { 
        $report['ID'] = NULL;
        $report['Titolo'] = NULL;
        $page = "add.php";
    } else { 
        $rid = $report['ID'];
        $page = "edit.php?rid=$rid";
    }

    $titolo = $report['Titolo'];
    
    $result = "<form method='POST' action='$page'>";
    $result = $result . select_patient($report['ID']) . "<br>";
    $result = $result . "<label for='titolo'> Titolo Esame: </label> 
    <input type='text' name='titolo' class='form-control' value='$titolo'>" . "<br>";
    $result = $result . "<button type='submit' class='btn btn-primary'>Conferma</button>";
    $result = $result . "</form>";
    return $result;
}

function report_table($report) {
    $titolo = $report['Titolo'];
    $paziente = patient($report['PID']);
    $operatore = operator($report['OID']);
    $creazione = $report['Creazione'];
    $caricamento = $report['Caricamento'];
    $struttura = facility_from_operator($report['OID']);
    $struttura = $struttura['Denominazione'];
    if ($report['Filepath']) {
        $file = "✔️";
    } else {
        $file = "❌";
    }
    
    $result = "<table class='table table-borderless'>";
    $result = $result . "<tr> <td> <b> Titolo Esame: </b> </td> <td> $titolo </td> </tr>";
    $result = $result . "<tr> <td> <b> Paziente: </b> </td> <td>  $paziente </td> </tr>";
    $result = $result . "<tr> <td> <b> Operatore: </b> </td> <td> $operatore </td> </tr>";
    $result = $result . "<tr> <td> <b> Struttura: </b> </td> <td> $struttura </td> </tr>";
    $result = $result . "<tr> <td> <b> Data Esame: </b> </td> <td> $creazione </td> </tr>";
    $result = $result . "<tr> <td> <b> Data Referto: </b> </td> <td> $caricamento </td> </tr>";
    $result = $result . "<tr> <td> <b> Referto precedentemente caricato? </b> </td> <td> $file </td> </tr>";
    $result = $result . "</table>";
    return $result;
}

function uploader($rid) {
    $result = "<table class='table table-borderless'> <form method='post' enctype='multipart/form-data' action='upload.php?rid=$rid'>";
    $result = $result .  "<tr> <td> <input type='file' class='form-control' name='report' id='report'> </td>";
    $result = $result .  "<td> <input type='reset' class='form-control btn btn-secondary' name='submit' value='Pulisci'> </td>";
    $result = $result .  "<td> <input type='submit' class='form-control btn btn-primary' name='submit' value='Carica'> </td> </tr>";
    $result = $result . "</form> </table>";
    return $result;
}

function deleter($rid) {
    $link = "delete.php?rid=$rid";
    $result = "<table class='table table-borderless'>";
    $result = $result .  "<tr> <td> <b> Sei sicuro di voler eliminare il report? </b> </td>";
    $result = $result .  "<td> <a href=$link class='btn btn-danger'> Elimina </a> </tr>";
    $result = $result . "</table>";
    return $result;
}

function query($query) {
    $s = 'localhost';
	$u = 'enricociciriello';
	$db = 'my_'.$u;

    $connessione = mysql_connect($s, $u, '');
	
	if(!$connessione)
	{
		exit('Errore nella connessesione con il database');
	}
	
	$database = mysql_select_db($db, $connessione);
	
	$risultato = mysql_query($query);

    if(!$database)
	{
		exit('Errore del databse');
	}

    if ($risultato) {
        return $risultato;
    } else {
        exit(mysql_error($risultato));
    }

}

?>