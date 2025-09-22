<?php
class Produtos {
    public $id;
    public $titulo;
    public $descricao;
    public $preco;
    public $loja;
    public $status;

    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function cadastrar(): bool
    {
        try {
            $sql = "INSERT INTO Produtos (titulo, descricao, preco, loja, status) VALUES (?, ?, ?, ?, ?)";
            $dados = [
                $this->titulo,
                $this->descricao,
                $this->preco,
                $this->loja,
                $this->status
            ];
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($dados);
            return ($stmt->rowCount() > 0);
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar produto: " . $e->getMessage());
            throw new Exception("Erro ao cadastrar produto: " . $e->getMessage());
        }
    }

    public function consultarTodos($search = '')
    {
        try {
            if (!empty(trim($search))) {
                $sql = "SELECT * FROM Produtos WHERE titulo LIKE ? OR descricao LIKE ?";
                $searchParam = "%" . trim($search) . "%";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$searchParam, $searchParam]);
            } else {
                $sql = "SELECT * FROM Produtos";
                $stmt = $this->conn->query($sql);
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao consultar produtos: " . $e->getMessage());
            throw new Exception("Erro ao consultar produtos: " . $e->getMessage());
        }
    }

    public function consultarPorId($id)
    {
        try {
            $sql = "SELECT * FROM Produtos WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao consultar produto por ID: " . $e->getMessage());
            throw new Exception("Erro ao consultar produto por ID: " . $e->getMessage());
        }
    }

    public function editar(): bool
    {
        try {
            $sql = "UPDATE Produtos SET titulo = ?, descricao = ?, preco = ?, loja = ?, status = ? WHERE id = ?";
            $dados = [
                $this->titulo,
                $this->descricao,
                $this->preco,
                $this->loja,
                $this->status,
                $this->id
            ];
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($dados);
            return ($stmt->rowCount() > 0);
        } catch (PDOException $e) {
            error_log("Erro ao alterar produto: " . $e->getMessage());
            throw new Exception("Erro ao alterar produto: " . $e->getMessage());
        }
    }

    public function deletar($id): bool
    {
        try {
            $sql = "DELETE FROM Produtos WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return ($stmt->rowCount() > 0);
        } catch (PDOException $e) {
            error_log("Erro ao deletar produto: " . $e->getMessage());
            throw new Exception("Erro ao deletar produto: " . $e->getMessage());
        }
    }
}