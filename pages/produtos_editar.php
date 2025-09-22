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
        $produto->descricao = $descricao;
        $produto->preco = $preco;
        $produto->loja = $loja;
        $produto->status = $status;
        $resultado = $produto->editar();
    }

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo '<p style="color: red; text-align: center;">ID de produto inválido.</p>';
        echo '<p style="text-align: center;"><a href="/pages/produtos_listar.php">Voltar para a lista de produtos</a></p>';
        exit;
    }

    $id = $_GET['id'];

    $produto = new Produtos($conn);
    $produto_atual = $produto->consultarPorId($id);

    if (!$produto_atual) {
        echo '<p style="color: red; text-align: center;">Produto não encontrado.</p>';
        echo '<p style="text-align: center;"><a href="/pages/produtos_listar.php">Voltar para a lista de produtos</a></p>';
        exit;
    }
?>

<div class="form-container">
    <h1>Editar Produto</h1>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($produto_atual['id']); ?>">
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($produto_atual['titulo']); ?>" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($produto_atual['descricao']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" value="<?php echo htmlspecialchars($produto_atual['preco']); ?>" required>
        </div>
        <div class="form-group">
            <label for="loja">Loja:</label>
            <input type="text" id="loja" name="loja" value="<?php echo htmlspecialchars($produto_atual['loja']); ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="desejado" <?php echo ($produto_atual['status'] === 'desejado') ? 'selected' : ''; ?>>Desejado</option>
                <option value="no carrinho" <?php echo ($produto_atual['status'] === 'no carrinho') ? 'selected' : ''; ?>>No carrinho</option>
                <option value="comprado" <?php echo ($produto_atual['status'] === 'comprado') ? 'selected' : ''; ?>>Comprado</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit">Salvar Alterações</button>
        </div>
        <?php
        if (isset($resultado)) {
            if ($resultado) {
                echo '<p style="color: green; text-align: center;">Produto alterado com sucesso!</p>';
            } else {
                echo '<p style="color: red; text-align: center;">Erro ao alterar produto. Tente novamente.</p>';
            }
        }
        ?>
    </form>
</div>