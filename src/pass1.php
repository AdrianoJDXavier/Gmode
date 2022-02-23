<?php
require_once 'header.php';
?>
<div class="card">
    <div class="card-header text-center bg-default">
        G-mode
    </div>
    <div class="item_card">
        <h4 style="text-align: center;">Passo 1: Conexão</h4>

        <form action="pass2.php" method="post">
            <div class="form-group row">
                <label for="host" class="col-sm-2 col-form-label">Host:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="host" placeholder="localhost">
                </div>
            </div>
            <div class="form-group row">
                <label for="user" class="col-sm-2 col-form-label">Password:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="user" placeholder="User">
                </div>
            </div>
            <div class="form-group row">
                <label for="senha" class="col-sm-2 col-form-label">Senha:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="senha" placeholder="Senha">
                </div>
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Avançar</button>
            </div>
        </form>
    </div>
</div>
</div>
<script>
    <?php
    require_once 'footer.php';
