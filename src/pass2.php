<?php
include_once("header.php");
define('HOST', $_POST['host']);
define('USER', $_POST['user']);
define('PASS', $_POST['senha']);
define('DBNAME', '');

try {
    $conn = new pdo('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS);
    /* echo "Conexão com banco de dados realizada com sucesso."; */
} catch (PDOException $e) {
    echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $e->getMessage();
}

$databases = listDatabase($conn);


?>

<div class="card">
    <div class="card-header text-center bg-default">
        G-mode
    </div>
    <div class="item_card">
        <h4 style="text-align: center;">Passo 2: Selecione a Base</h4>
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="form-group row">
                        <label for="base" class="col-sm-2 col-form-label">Base:</label>
                        <div class="col-sm-10">
                            <select name="base" id="base" class="form-control" onchange="returnTable(this.value)">
                                <option>-----</option>
                                <?php
                                foreach ($databases as $item) {
                                ?>
                                    <option value="<?= $item['Database'] ?>"><?= $item['Database'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6" id="table"></div>
        </div>
    </div>
</div>
</div>
<script>
    function returnTable(base) {
        console.log(base)
        $.ajax({
                url: "ajax_table.php",
                type: 'post',
                data: {
                    base: base
                },
                beforeSend: function() {
                    $("#table").html("ENVIANDO...");
                }
            })
            .done(function(msg) {
                $("#table").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg) {
                alert(msg);
            });
    }
</script>
<?php
require_once 'footer.php';
