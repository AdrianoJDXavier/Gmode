<?php
function listDatabase($conn){
    $query = $conn->query("show databases");
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}
?>