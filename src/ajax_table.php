<?php
include_once("functions.php");
session_start();
include_once("conexão.php");
$tabelas = listTable($conn, $_POST['base']);

?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="tables">Selecione as tabelas: </label>
            <select multiple name="tables[]" class="form-control" id="tables" required>
                <?php
                foreach ($tabelas as $tabela) {
                ?>
                    <option value="<?=$tabela['TABLE_NAME']?>"><?=$tabela['TABLE_NAME']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
            <label for="tables">Selecione a tabela principal: </label>
            <select name="table" class="form-control" id="tables" required>
                <?php
                foreach ($tabelas as $tabela) {
                ?>
                    <option value="<?=$tabela['TABLE_NAME']?>"><?=$tabela['TABLE_NAME']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<div class="text-right">
    <button class="btn btn-primary" type="submit">Avançar</button>
</div>