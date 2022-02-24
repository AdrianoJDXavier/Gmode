<?php
include_once("functions.php");
session_start();
include_once("conexão.php");
$tabelas = listTable($conn, $_POST['base']);

print_r($tabelas);
?>