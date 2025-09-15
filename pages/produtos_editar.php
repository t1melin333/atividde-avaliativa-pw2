<?php
    require_once __DIR__ . '/../data/connection.php';
    require_once __DIR__ . '/../model/Produtos.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? '';
        $loja = $_POST['loja'] ?? '';
        $status = $_POST['status'] ?? '';

        $produto = new Produtos($conn);
        $produto->id = $id;
        $produto->titulo = $titulo;
        $produto->descricao = trim($descricao);
        $produto->preco = $preco;
        $produto->loja = $loja;
        $produto->status = $status;
        $resultado = $produto->editar();
    }

    if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo '<p style="color: red; text-align: center;">ID de produto inválido.</p>';
        echo '<p style="text-align: center;"><a href="/">Voltar para a lista de produtos</a></p>';
        exit;
    } 


    $id = $_GET['id'];

    $produto = new Produtos($conn);
    $produto_atual = $produto->consultarPorId( $id);

    if (!$produto_atual) {
        echo '<p style="color: red; text-align: center;">produto não encontrada.</p>';
        echo '<p style="text-align: center;"><a href="/">Voltar para a lista de ptodutos</a></p>';
        exit;
    }
    
?>
    
    <div class="form-container">
        <h1>Cadastrar Novo Produto</h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($produto_atual['id']); ?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($produto_atual['titulo']) ?>" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($produto_atual['descricao']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="inicio">Preço:</label>
                <input type="float" id="preco" name="preco" value="<?php echo htmlspecialchars($produto_atual['preco']) ?>" required>
            </div>
            <div class="form-group">
                <label for="fim">Loja:</label>
                <input type="text" id="preco" name="preco" value="<?php echo htmlspecialchars($produto_atual['loja']) ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="desejado" <?php echo ($produto_atual['status']==='desejado') ? 'selected' : ''; ?>>Desejado</option>
                    <option value="no carrinho"  <?php echo ($produto_atual['status']==='no carrinho') ? 'selected' : ''; ?>>No carrinho</option>
                    <option value="concluida"  <?php echo ($produto_atual['status']==='comprado') ? 'selected' : ''; ?>>Comprada</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Editar Produto</button>
            </div>
            <?php
            if (isset($resultado)) {
                if ($resultado) {
                    echo '<p style="color: green; text-align: center;">Prouto alterado com sucesso!</p>';
                } else {
                    echo '<p style="color: red; text-align: center;">Erro ao alterar Produto. Tente novamente.</p>';
                }
            }  
            ?>
        </form>
    </div>
