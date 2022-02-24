<?php
function listDatabase($conn){
    $query = $conn->query("show databases");
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

function listTable($conn, $base){
    $sql = "SELECT 
                TABLE_NAME
            FROM
                information_schema.tables
            WHERE
                table_schema = '$base'";
               
    $query = $conn->query($sql);
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

function listColumns($conn, $base, $table){
    $sql = "SELECT 
                *
            FROM
                INFORMATION_SCHEMA.COLUMNS AS c
            WHERE
                c.TABLE_SCHEMA = '$base'
                    AND c.TABLE_NAME = '$table'";
               
    $query = $conn->query($sql);
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

function listColunsUsage($conn, $base, $table){
    $sql = "SELECT 
                *
            FROM
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE
                table_schema = '$base'
                    AND table_name = '$table'";
               
    $query = $conn->query($sql);
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

function createFolder($nome_pasta)
{
    $root = $_SERVER["DOCUMENT_ROOT"];
    $dir = $root . '/'.$nome_pasta.'/';

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    chmod($dir, 0777);
}

function createFile($pasta, $nome_arquivo, $conteudo)
{
    $arquivo = fopen($pasta . '/' . $nome_arquivo, 'w');
    fwrite($arquivo, $conteudo);
    fclose($arquivo);
}
?>