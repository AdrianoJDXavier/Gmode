<?php
include_once("../strings/string.php");
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
    return $dir;
}

function createSubFolder($caminho, $nome_pasta)
{
    $dir = $caminho . '/'.$nome_pasta.'/';

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    chmod($dir, 0777);
    return $dir;
}

function createFile($pasta, $nome_arquivo, $conteudo)
{
    $arquivo = fopen($pasta . '/' . $nome_arquivo, 'w');
    fwrite($arquivo, $conteudo);
    fclose($arquivo);
}

function createView($conn, $pasta, $table, $base){
$colunas = listColumns($conn, $base, $table);
$lista = 'lista';
$conn = 'conn';
$list = 'list';
$conteudo = "<?php
include_once '../header.php';
include_once '../conexao.php';
include_once 'function.php';
$$lista = list_".$table."($$conn);
?>
<div class=\"card\">
    <div class=\"card-header text-center bg-default\">
        ".strtoupper($table)."
    </div>
    <div class=\"item_card table-responsive\">
        <table id=\"example\" class=\"display\" style=\"width:100%\">
            <thead>
                <tr>\n";
foreach($colunas as $coluna){
    $conteudo .= "\t\t\t\t\t<td>".$coluna['COLUMN_NAME']."</td>\n";
}
$conteudo .= "\t\t\t\t</tr>
\t\t\t</thead>
\t\t\t</body>
\t\t\t\t<tr>

<?php
					if (!empty($$lista)) {
						
\t\t\t\t\tforeach($$lista as $$list){
\t\t\t\t?>\n";
    foreach($colunas as $coluna){
        $conteudo .= "\t\t\t\t\t<td><?=$".$list."['".$coluna['COLUMN_NAME']."']?></td>\n";
    }
$conteudo .= "<?php }
} else { ?>
    <td>Nenhum dado encontrado</td>
<?php } ?>
\t\t\t\t</tr>
\t\t\t</tbody>
\t\t</table>
\t</div>
</div>
<div id=\"getModal\"></div>
</div>";
createFile($pasta, 'view.php', $conteudo);
}

function createFunctions($pasta, $table){
$conteudo = '<?php
function list_'.$table.'($conn){
   $sql = "SELECT 
               *
           FROM
               '.$table.'";
              
   $query = $conn->query($sql);
   $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
   return $resultado;
}
?>';   
createFile($pasta, 'function.php', $conteudo);
}
?>