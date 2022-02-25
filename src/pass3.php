<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";

include_once("header.php");
$pasta = createFolder($_POST['table']);
?>