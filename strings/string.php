<?php
$conexao = '<?php
define(\'HOST\', \''.$_POST['host'].'\');
define(\'USER\', \''.$_POST['user'].'\');
define(\'PASS\', \''.$_POST['senha'].'\');
define(\'DBNAME\',\''.$_POST['base'].'\');

try {
    $conn = new pdo(\'mysql:host=\' . HOST . \';dbname=\' . DBNAME, USER, PASS);
     //echo "Conexão com banco de dados realizada com sucesso."; 
} catch (PDOException $e) {
    echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $e->getMessage();
}
?>';

$style =".btn-grupo{
    margin: 10px !important;
}

.btn-success{
    margin-right: 10px !important;
}

.card{
    -webkit-box-shadow: 5px 5px 10px 1px rgba(1,6,23,0.62); 
    box-shadow: 5px 5px 10px 1px rgba(1,6,23,0.62);
    border-radius: 10px;
    padding-bottom: 1%;
}

.item_card{
    width: 95% !important; 
    align-self: center;
    margin-top: 10px;
}

.container{
    margin-bottom: 15px !important;
    margin-top: 5% !important;
    width: 95% !important;
    max-width: 95%;
}

.link_solicitacao {
    color: black;
    text-decoration: none;
  }

.link_solicitacao:hover {
    color: black;
    text-decoration: none;
    font-size: x-large;
    font-weight: bold;
  }

  .btn-filter{
      margin-top: 8% !important;
  }

  .td-acao{
    width: 15% !important;
  }

  .img-logo{
    max-width: 70%;
    text-align: center;
}

  .img-logo img{
      max-width: 40%;
      height: auto;
      padding: 10% 0% 10% 0%;
  }

  
  ";

$header = "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">\n
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>\n
<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">\n
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>\n
<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css\">\n
<link rel=\"stylesheet\" href=\"../css/style.css\">\n\n
<div class=\"container\">
<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);
include_once('../conexao.php');
?>";

?>