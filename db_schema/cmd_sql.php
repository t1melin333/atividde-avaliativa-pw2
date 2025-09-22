<?php
require_once __DIR__.'/../data/db_config.php';

$deleteDB = 'DROP DATABASE IF EXISTS '.DB_NAME.';';
$criarDB  = 'CREATE DATABASE IF NOT EXISTS '.DB_NAME.';';
$usarDB = 'USE '.DB_NAME.';';

$criarTabela = "
CREATE TABLE IF NOT EXISTS Produtos (
id INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(155) NOT NULL,
descricao VARCHAR(255),
preco int,
loja VARCHAR(20),
`status` ENUM('desejado', 'no carrinho', 'comprado') DEFAULT 'desejado',
createAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updateAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
";

$insertDados = "
INSERT INTO Produtos (titulo, descricao, preco, loja, `status`) VALUES
('Camiseta macaquinho', 'camiseta engraçada do macaco', '20', 'shein' ,'desejado');
";

try {
    $pdo = new PDO(
        dsn: 'mysql:host='.DB_HOST,
        username: DB_USER,
        password: DB_PASS
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec(statement: $deleteDB);

    $pdo->exec(statement: $criarDB);
    $pdo->exec(statement: $usarDB);
    $pdo->exec($criarTabela);
    $pdo->exec(statement: $insertDados);

    echo "Banco de dados, tabela e dados criados com sucessw!";
} catch (PDOException $e) {
    die ("Erro: ".$e->getMessage());
}