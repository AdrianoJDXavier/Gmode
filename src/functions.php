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
                    AND c.TABLE_NAME = '$table'
                    AND (COLUMN_KEY <> 'PRI'
                    AND EXTRA <> 'auto_increment')";
              
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

function getFK($conn, $base, $table, $column){
    $sql = "SELECT 
                CONSTRAINT_NAME,
                COLUMN_NAME,
                REFERENCED_TABLE_NAME,
                REFERENCED_COLUMN_NAME
            FROM
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE
                TABLE_SCHEMA = '$base'
                    AND TABLE_NAME = '$table'
                    AND REFERENCED_TABLE_NAME <> ''
                    AND COLUMN_NAME = '$column'";
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

function createHeader($pasta, $tables){
    if(count($tables) > 4){
        $array1 = array_slice($tables, 0, 4);
        $array2 = array_slice($tables, 4);
    }else{
        $array1 = $tables;
    }


    $header = "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">\n
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>\n
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">\n
    <script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>\n
    <link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css\">\n
    <link rel=\"stylesheet\" href=\"../css/style.css\">\n\n
    
    <nav class=\"navbar navbar-expand-lg navbar-light bg-light\">
  <a class=\"navbar-brand\" href=\"#\">Navbar</a>
  <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarNavDropdown\" aria-controls=\"navbarNavDropdown\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
    <span class=\"navbar-toggler-icon\"></span>
  </button>
  <div class=\"collapse navbar-collapse\" id=\"navbarNavDropdown\">
    <ul class=\"navbar-nav\">";
    foreach($array1 as $array){
      $header .= "<li class=\"nav-item\">
        <a class=\"nav-link\" href=\"../".$array."/view.php\">".ucfirst($array)."<span class=\"sr-only\">(current)</span></a>
      </li>";
    }
    if(isset($array2) && !empty($array2)){
        $header .= "<li class=\"nav-item dropdown\">
        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
          Dropdown link
        </a>
        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">";
        foreach($array2 as $array){
            $header .= "<a class=\"dropdown-item\" href=\"../".$array."/view.php\">".ucfirst($array)."</a>";
        }
        $header .= "</div>";  
    }
      $header .= "
      </li>
    </ul>
  </div>
</nav>
<div class=\"container\">
    <?php
    include_once('../conexao.php');
    ?>";
    
        createFile($pasta, 'header.php', $header);
}

function CreateFooter($pasta){
    $footer = "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js\" integrity=\"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q\" crossorigin=\"anonymous\"></script>
    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js\" integrity=\"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl\" crossorigin=\"anonymous\"></script>
    
    </div>";

    createFile($pasta, 'footer.php', $footer);
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
if(!empty(\$_GET['msg'])){
    echo retornaMensagem(\$_GET['msg']);
}
?>
<a href=\"form_insert.php\"><button class=\"btn btn-primary\">Inserir</button><br></a>
<div class=\"card\">
    <div class=\"card-header text-center bg-default font-weight-bold\">
        ".strtoupper($table)."
    </div>
    <div class=\"item_card table-responsive\">
        <table id=\"example\" class=\"table text-center\" style=\"width:100%\">
            <thead class=\"font-weight-bold\">
                <tr>\n";
foreach($colunas as $coluna){
    $conteudo .= "\t\t\t\t\t<td>".strtoupper($coluna['COLUMN_NAME'])."</td>\n";
}
$conteudo .= "\t\t\t\t</tr>
            </thead>
            </body>
            <?php
                if (!empty($$lista)) {				
                    foreach($$lista as $$list){
                ?>
                <tr>\n";
    foreach($colunas as $coluna){
        $conteudo .= "\t\t\t\t\t<td><?=$".$list."['".$coluna['COLUMN_NAME']."']?></td>\n";
    }
$conteudo .= "\t\t\t\t</tr>\n\t\t\t\t<?php }
\t\t\t\t} else { ?>
\t\t\t\t\t<td>Nenhum dado encontrado</td>
\t\t\t\t<?php } ?>
\t\t\t</tbody>
\t\t</table>
\t</div>
</div>
<div id=\"getModal\"></div>
</div>
<?php
include_once '../footer.php';
?>";
createFile($pasta, 'view.php', $conteudo);
}

function createForms($conn, $pasta, $table, $base){
$colunas = listColumns($conn, $base, $table);

$lista = 'lista';
$conn = 'conn';
$list = 'list';
$conteudo = "<?php
include_once '../header.php';
include_once '../conexao.php';
include_once 'function.php';
?>\n";

$conteudo .= "<div class=\"card\">
    <div class=\"card-header text-center bg-default\">
        $table
    </div>
    <div class=\"item_card\">
        <form action=\"data.php\" method=\"post\">
            <input type=\"hidden\" name=\"enviar\" value=\"enviar\">\n";
            foreach($colunas as $coluna){
            $isFK = '' /* getFK($conn, $base, $table, $coluna['COLUMN_NAME']) */;
            if(empty($isFK)){
                $conteudo .= "\t\t\t<div class=\"form-group row\">
                    <label for=\"".$coluna['COLUMN_NAME']."\" class=\"col-sm-2 col-form-label\">".$coluna['COLUMN_NAME'].":</label>
                    <div class=\"col-sm-10\">
                        <input type=\"text\" class=\"form-control\" name=\"".$coluna['COLUMN_NAME']."\" required>
                    </div>
                </div>\n";
            }else{
                $conteudo .= "\t\t\t<div class=\"form-group row\">
                    <label for=\"".$coluna['COLUMN_NAME']."\" class=\"col-sm-2 col-form-label\">".$coluna['COLUMN_NAME'].":</label>
                    <div class=\"col-sm-10\">
                        <select class=\"form-control\" name=\"".$coluna['COLUMN_NAME']."\" required>
                        <option>-----</option>
                        </select>
                    </div>
                </div>\n";
            }
            }
            $conteudo .= "\t\t\t<div>
                <button class=\"btn btn-primary\" type=\"submit\">Enviar</button>
            </div>
        </form>
    </div>
    </div>
</div>
<?php
include_once '../footer.php';
?>";
createFile($pasta, 'form_insert.php', $conteudo);
}

function createData($conn, $pasta, $table, $base){
$colunas = listColumns($conn, $base, $table);
$array = array();
foreach($colunas as $coluna){
    $array[] = $coluna['COLUMN_NAME'].',';
}

$lista = 'lista';
$conn = 'conn';
$list = 'list';
$conteudo = "<?php
include_once '../conexao.php';
include_once 'function.php';

if(!empty(\$_POST['enviar'])){
    insert_".$table."(\$conn, \$_POST['".str_replace(",", "'], \$_POST['", substr(implode('', $array), 0, -1))."']);
    \$location = 'view';
    \$msg = 'Dados inseridos com sucesso!';
}
header(\"Location: \".\$location.\".php?msg=\".\$msg.\"\");
die();
?>";
createFile($pasta, 'data.php', $conteudo);
}

function createFunctions($conn, $pasta, $table, $base){
$colunas = listColumns($conn, $base, $table);
$array = array();
    foreach($colunas as $coluna){
        $array[] = $coluna['COLUMN_NAME'].',';
    }
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

function insert_'.$table.'($conn, $'.substr(implode(' $', $array), 0, -1).'){
    $sql = "INSERT INTO '.$table.'(';
    $conteudo .= str_replace(",", ",", str_replace("$", "$", substr(implode('', $array), 0, -1)));
    $conteudo .= ") VALUES('$".str_replace(",", "','$", substr(implode('', $array), 0, -1))."')\";\n\t";
           
    $conteudo .= '$query = $conn->query($sql);
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

function retornaMensagem($mensagem, $tipo = \'info\', $largura = \'50%\', $close = true){
	/* Tipos:
		- info = Retorna box azul, usado para exibir informações genéricas (Default)
		- warning = Retorna box amarelo, usado para avisos que precisam de atenção do usuário
		- success = Retorna box verde, indica que a ação requerida pelo usuário foi realizada com sucesso
		- danger = Retorna box vermelho, indica que a ação requerida pelo usuário não foi realizada e/ou ocorreu algum erro
	  Largura:
	  	- Largura pode ser definida em pixels ou porcentagem, caso venha como vazia "" será usado 100% como padrão
		
	  Close: Pode ou não ser fechado pelo usuário
	*/
	if($largura == ""){$largura = "50%";}
	if(is_numeric($tipo)){
		if($tipo == 1){ $tipo = "danger";}else{$tipo = "info";}
	}

	$out = "<div id=\'close\' class=\'alert alert-".$tipo." text-center\' role=\'alert\' style=\'width:".$largura."; margin:0 auto 20px;\'>";
	if($close==true){
	  	$out .= "<button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\' data-target=\'#close><span aria-hidden=\'true\'>&times;</span></button>";
	}
	$out .=$mensagem."</div>";
	return $out;
}

?>';   
createFile($pasta, 'function.php', $conteudo);
}

function echoPre($valor){
    echo "<pre>";
    print_r($valor);
    echo "</pre>";
}
?>