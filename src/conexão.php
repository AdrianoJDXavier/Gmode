<?php
define('HOST', $_SESSION['host']);
define('USER', $_SESSION['user']);
define('PASS', $_SESSION['senha']);
define('DBNAME', '');

try {
    $conn = new pdo('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS);
     echo "Conexão com banco de dados realizada com sucesso."; 
} catch (PDOException $e) {
    echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $e->getMessage();
}
?>