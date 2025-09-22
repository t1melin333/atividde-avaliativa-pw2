<?php
    require_once __DIR__ . '/../data/connection.php';
    require_once __DIR__ . '/../model/Produtos.php';

    
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo '<p style="color: red; text-align: center;">ID do produto inválido.</p>';
        echo '<p style="text-align: center;"><a href="/">Voltar para a lista de produtos</a></p>';
        exit;
    } 


    $id = $_GET['id'];

    $produto = new Produtos($conn);
    $produto_atual = $produto->consultarPorId( $id);

    if (!$produto_atual) {
        echo '<p style="color: red; text-align: center;">Produto não encontrado.</p>';
        echo '<p style="text-align: center;"><a href="/">Voltar para a lista de produtos</a></p>';
        exit;
    }

    $resultado = $produto->deletar($id);

    if ($resultado) {               
        header('Location: /?deleted=true');
    } else {
        echo '<p style="color: red; text-align: center;">Erro ao deletar produto. Tente novamente.</p>';
         echo '<p style="text-align: center;"><a href="/">Voltar para a lista de produtos</a></p>';
    }