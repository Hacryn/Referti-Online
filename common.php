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
        exit("Errore: query");
    }

}

?>