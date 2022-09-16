<?php

include_once("sql_driver.php");

function nav_menu($role) {
    $menu = "";

    if ($role == 'patient') {
        $menu = $menu . '<li class="nav-item">';
        $menu = $menu . '<a class="nav-link active" href="referti.php">Referti</a>';
        $menu = $menu . '</li> <li class="nav-item">';
        $menu = $menu . '<a class="nav-link active" href="sharer.php">Gestione Condivisione</a>';
        $menu = $menu . '</li>';
    }

    if ($role == 'operator') {
        $menu = $menu . '<li class="nav-item dropdown">';
        $menu = $menu . '<a class="nav-link dropdown-toggle" href="home.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Referti</a>';
        $menu = $menu . '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $menu = $menu . '<a class="dropdown-item" href="referto.php?action=new">Crea nuovo referto</a>';
        $menu = $menu . '<a class="dropdown-item" href="referti.php">Gestici referti</a>';
        $menu = $menu . '</div> </li>';
    }

    if ($role == 'facility') {
        $menu = $menu . '<li class="nav-item dropdown">';
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
    
    if (!$upload) {
        $result = $result = $result . button("Visualizza", "$base&action=look", "primary");
    }

    if ($role == 'patient') {
        $result = $result . button("Condivisione", "$base&action=share", "primary");
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
    INNER JOIN lettura_paziente ON lettura_paziente.PID = Referto.PID 
    INNER JOIN Operatore ON lettura_paziente.OID = Operatore.ID 
    AND Operatore.ID = $id";
}

function reports_query_operator_viewer2($id) {
    return "SELECT Referto.* FROM Referto
    INNER JOIN lettura_referto ON lettura_referto.RID = Referto.ID 
    INNER JOIN Operatore ON lettura_referto.OID = Operatore.ID 
    AND Operatore.ID = $id";
}

function reports_query_facility($id) {
    return "SELECT Referto.* FROM Referto
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

function select_operator($oid, $rid, $type) {
    $pid = $_SESSION['UID'];
    $exclude = "$oid";

    if ($type == 'report') {
        $exclude_query = query("SELECT Operatore.ID FROM Operatore 
        INNER JOIN lettura_referto ON Operatore.ID = lettura_referto.OID
        AND lettura_referto.RID = $rid");
        while($result = mysql_fetch_array($exclude_query)) {
            $id = $result['ID'];
            $exclude = $exclude . ", $id";
        }
    }

    $exclude_query = query("SELECT Operatore.ID FROM Operatore 
    INNER JOIN lettura_paziente ON Operatore.ID = lettura_paziente.OID
    AND lettura_paziente.PID = $pid");
    while($result = mysql_fetch_array($exclude_query)) {
        $id = $result['ID'];
        $exclude = $exclude . ", $id";
    }

    $query = "SELECT Operatore.ID, Nome, Cognome, Denominazione FROM Operatore
    INNER JOIN Struttura ON Operatore.FID = Struttura.ID
    WHERE Operatore.ID NOT IN ($exclude)";
    $result = "<select name='operatore' class='form-control'>";
    $result = $result . "<option value='-1'> </option>";
    $set = query($query);
    while($row = mysql_fetch_array($set)) {
        $id = $row['ID'];
        $nome = $row['Nome'];
        $cognome = $row['Cognome'];
        $struttura = $row['Denominazione'];
        $result = $result . "<option value='$id'> $nome $cognome ($struttura) </option>";
    }
    return $result . "</select>";
}

function select_shared($rid, $type) {
    $pid = $_SESSION['UID'];

    if ($type == 'report') {
        $query = "SELECT Operatore.ID, Nome, Cognome, Denominazione FROM Operatore
        INNER JOIN Struttura ON Operatore.FID = Struttura.ID
        INNER JOIN lettura_referto ON Operatore.ID = lettura_referto.OID
        WHERE lettura_referto.RID = $rid";
    } else {
        $query = "SELECT Operatore.ID, Nome, Cognome, Denominazione FROM Operatore
        INNER JOIN Struttura ON Operatore.FID = Struttura.ID
        INNER JOIN lettura_paziente ON Operatore.ID = lettura_paziente.OID
        WHERE lettura_paziente.PID = $pid";
    }
    $result = "<select name='operatore' class='form-control'>";
    $result = $result . "<option value='-1'> </option>";
    $set = query($query);
    while($row = mysql_fetch_array($set)) {
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
    //$result = $result . "<option value='0'> Non registrato </option>";
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

function get_id_patient_from_cf($cf) {
    if (strlen($cf) != 16) {return -1;}
    $query = "SELECT * FROM Paziente WHERE CF = '$cf'";
    $patient = mysql_fetch_array(query($query));
    if ($patient) {return $patient['ID'];}
    else {return 0;}
}

function report_form($report, $required) {
    if ($report == NULL) { 
        $report['ID'] = NULL;
        $report['Titolo'] = NULL;
        $report['CF'] = NULL;
        $page = "add.php";
    } else { 
        $rid = $report['ID'];
        $page = "edit.php?rid=$rid";
    }

    $cf = $report['CF'];
    $titolo = $report['Titolo'];
    
    $result = "<form method='POST' action='$page'>";
    if($required == 'required') {
        $result = $result . "<label for='patient'> Codice Fiscale Paziente: </label>
        <input class='form-control' type='text' name='patient' id='patient' value='$cf' $required><br>";
    }
    $result = $result . "<label for='titolo'> Titolo Esame: </label> 
    <input type='text' name='titolo' class='form-control' value='$titolo' required>" . "<br>";
    $result = $result . "<button type='submit' class='btn btn-primary'>Conferma</button>";
    $result = $result . "</form>";
    return $result;
}

function report_table($report) {
    $rid = $report['ID'];
    $titolo = $report['Titolo'];
    if ($report['PID'] == 0) {
        $paziente = $report['CF'];
    } else {
        $paziente = patient($report['PID']);
    }
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
    $codice = $report['Codice'];
    
    $result = "<table class='table table-borderless'>";
    if ($codice) {
        $result = $result . "<tr> <td> <b> Codice Referto: </b> </td> <td> $rid </td> </tr>";
        $result = $result . "<tr> <td> <b> Codice Accesso: </b> </td> <td> $codice </td> </tr>"; 
    }
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

function sharer($oid, $rid, $type) {
    if ($type == 'report') {
        $link = "share.php?rid=$rid&";
    } elseif ($type == 'patient') {
        $link = "share.php?";
    } else {
        return "";
    }
    $del = $link . 'flag=delete';
    $operatori = select_operator($oid, $rid, $type);
    $shared = select_shared($rid, $type);
    $result = "<table class='table table-borderless'> <form method='post' enctype='multipart/form-data' action='$link'>";
    $result = $result .  "<tr> <td> Seleziona operatore: </td>";
    $result = $result .  "<td> $operatori </td>";
    $result = $result .  "<td> <input type='submit' class='form-control btn btn-primary' name='submit' value='Condividi'> </td> </tr>";
    $result = $result . "</form> </table>";
    $result = $result .  "<table class='table table-borderless'> <form method='post' enctype='multipart/form-data' action='$del'>";
    $result = $result .  "<tr> <td> Seleziona operatore: </td>";
    $result = $result .  "<td> $shared </td>";
    $result = $result .  "<td> <input type='submit' class='form-control btn btn-danger' name='submit' value='Rimuovi'> </td> </tr>";
    $result = $result . "</form> </table>";
    return $result;
}

function has_access($report, $uid, $role) {
    
    if (!$report) {return false;}

    $rid = $report['ID'];
    $oid = $report['OID'];
    $pid = $report['PID'];

    if ($role == 'patient') {
        return $report['PID'] == $uid;
    }

    if ($role == 'operator') {
        $check = mysql_fetch_array(query("SELECT * FROM lettura_referto 
        WHERE lettura_referto.RID = $rid AND lettura_referto.OID = $uid"));

        if ($check) { return true; }

        $check = mysql_fetch_array(query("SELECT * FROM lettura_paziente 
        WHERE lettura_paziente.PID = $pid AND lettura_paziente.OID = $uid"));

        if ($check) { return true; }
        
        return $oid == $uid;
    }

    if ($role == 'facility') {
        $facility = facility_from_operator($oid);
        return $facility['ID'] == $uid;
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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