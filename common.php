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
    return "<a href='$link' class='btn btn-$attribute space'> $text </a>";
}

function actions($report, $role) {
    $rid = $report['ID'];
    $base = "referto?=$rid";
    $filepath = $report['Filepath'];
    $result = "<div class='container-fluid'>";
    $result = $result = $result . button("Visualizza", "$base", "primary");

    if ($role == 'patient') {
        $result = $result . button("Condividi", "$base&action=share", "warning");
    }

    if ($role == 'operator' && $_SESSION['UID'] == $report['OID']) {
        if ($report['Filepath'] == NULL) {
            $result = $result . button("Carica", "$base&action=upload", "success");
        }
        $result = $result . button("Modifica", "$base&action=edit", "warning");
        $result = $result . button("Elimina", "$base&action=delete", "danger");
    }

    $result = $result . button("Scarica", $filepath, "secondary");
    $result = $result . "</div>";
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