<?php

require_once __DIR__ . '/../config/db.php';

class Usuario
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($nome, $senha)
    {

        $checkSql = "SELECT COUNT(*) FROM usuario WHERE nome = :nome";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':nome', $nome);
        $checkStmt->execute();


        if ($checkStmt->fetchColumn() > 0) {
            return false;
        }

        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (nome, senha) VALUES (:nome, :senha)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':senha', $hashedPassword);
        return $stmt->execute();
    }

    public function login($nome, $senha)
    {
        $sql = "SELECT id, senha FROM usuario WHERE nome = :nome";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();


        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && password_verify($senha, $user['senha'])) {
            return $user['id'];
        } else {
            return false;
        }
    }

    public function update($id ,$nome, $senha)
    {

        $query = "UPDATE usuario SET nome = :nome, senha = :senha WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);

            $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
            $stmt->bindParam(':senha', $hashedPassword, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM usuario WHERE id = :id";
        
        try {
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
            return false;
        }
    }
    

    public function findById($id) {
        $sql = "SELECT id, nome FROM usuario WHERE id = :id";
        
        try {
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $user ? $user : null;
            
        } catch (PDOException $e) {
            echo "Error finding user: " . $e->getMessage();
            return null;
        }
    }
    
}
