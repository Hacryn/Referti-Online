<?php
session_start();
$_SESSION['UID'] = 0;
$_SESSION['role'] = '';
session_destroy();
header('Location: index.html'); 
die();
?>