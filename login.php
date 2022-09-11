<?php

    // Check if PHP is not 5
    if (phpversion()[0] != '5') {
        include_once('sql_driver.php');
    }

    session_start();

    $PATIENT = 'patient';
    $OPERATOR = 'operator';
    $FACILITY = 'facility';

    $cf = $_POST['cf'];
    $pw = hash('sha256', $_POST['password']);
    $rl = $_POST['role'];

    $s = 'localhost';
	$u = 'enricociciriello';
	$db = 'my_'.$u;

    if ($rl == $PATIENT)
    {
        $_SESSION['role'] = $PATIENT;
        $query = 'SELECT ID, CF, PW FROM Paziente';
    }

    if ($rl == $OPERATOR)
    {
        $_SESSION['role'] = $OPERATOR;
        $query = 'SELECT ID, CF, PW FROM Operatore';
    }

    if ($rl == $FACILITY)
    {
        $_SESSION['role'] = $FACILITY;
        $query = 'SELECT ID, CF, PW FROM Struttura';
    }

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

    if($risultato)
    {
        while($row = mysql_fetch_array($risultato))
        {
            $db_id = $row['ID'];
            $db_cf = $row['CF'];
            $db_pw = $row['PW'];

            if (strcmp($db_cf, $cf) == 0)
            {
                if (strcmp($db_pw, $pw) == 0)
                {
                    $_SESSION['UID'] = $db_id;
                    echo 'Login avvenuto con successo!';
                    header('Location: home.php');
                    die();
                }
            }
        }
        header('Location: index.html?login=failed');
        die();
    }
    else
    {
    	exit('Errore nella query al DB');
    }

    header('Location: index.html');
    die();

?>