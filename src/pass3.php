<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";

include_once("header.php");
session_start();
$_SESSION['host'] = $_POST['host'];
$_SESSION['user'] = $_POST['user'];
$_SESSION['senha'] = $_POST['senha'];
include_once("conexão.php");
include_once("../strings/string.php");
$pasta = createFolder($_POST['table']);
$css = createSubFolder($pasta, 'css');
echo $conexao;
createFile($pasta, 'conexao.php', $conexao);
createFile($pasta, 'header.php', $header);
$index = "<?php
header(\"Location:".$_POST['table']."/view.php\");
?>";
createFile($pasta, 'index.php', $index);
createFile($css, 'style.css', $style);
foreach($_POST['tables'] as $table){
    $subPasta = createSubFolder($pasta, $table);
    createView($conn, $subPasta, $table, $_POST['base']);
    createFunctions($subPasta, $table);
}
?>