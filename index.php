<?php
require_once 'src/header.php';


//Criar as constantes com as credencias de acesso ao banco de dados
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', '');

/* $dsn = 'mysql:dbname=testdb;host=127.0.0.1';
$user = 'dbuser';
$password = 'dbpass';

$dbh = new PDO($dsn, $user, $password); */

//Criar a conexão com banco de dados usando o PDO e a porta do banco de dados
//Utilizar o Try/Catch para verificar a conexão.
try {
    $conn = new pdo('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS);
    echo "Conexão com banco de dados realizada com sucesso.";
} catch (PDOException $e) {
    echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $e->getMessage();
}

$query = $conn->query("show databases");
$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado as $item){
   echo $item['Database']."<br>";
}
?>
    <div class="card">
        <div class="card-header text-center bg-default">
            G-mode
        </div>
        <div class="item_card">
            <p style="text-align: center;">Sistema criado para geração de código fonte automatizado.</p>
        </div>
    </div>
</div>
<script>
<?php
require_once 'src/footer.php';
