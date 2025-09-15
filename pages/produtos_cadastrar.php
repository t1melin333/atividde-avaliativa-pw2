<?php

    require_once __DIR__ . '/../data/connection.php';
    require_once __DIR__ . '/../model/Produtos.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? '';
        $loja = $_POST['loja'] ?? '';
        $status = $_POST['status'] ?? '';

        $produto = new Produtos($conn);
        $produto->titulo = $titulo;
        $produto->descricao = $descricao;
        $produto->preco = $preco;
        $produto->loja = $loja;
        $produto->status = $status;
        $resultado = $produto->cadastrar();
    }
?>
    <div class="form-container">
        <h1>Cadastrar Novo Produto</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="inicio">Preço:</label>
                <input type="float" id="preco" name="preco" required>
            </div>
            <div class="form-group">
                <label for="fim">Loja:</label>
                <input type="text" id="loja" name="loja" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="desejado">Desejado</option>
                    <option value="no carrinho">No carrinho</option>
                    <option value="comprada">Comprada</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Cadastrar Produto</button>
            </div>
            <?php
            if (isset($resultado)) {
                if ($resultado) {
                    echo '<p style="color: green; text-align: center;">Produto cadastrado com sucesso!</p>';
                } else {
                    echo '<p style="color: red; text-align: center;">Erro ao cadastrar produto. Tente novamente.</p>';
                }
            }  
            ?>
        </form>
    </div>
