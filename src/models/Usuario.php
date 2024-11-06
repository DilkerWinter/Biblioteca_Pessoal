<?php 

require_once __DIR__ . '/../config/db.php';

class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($nome, $senha) {
        
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
    
    public function login($nome, $senha) {
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
    
    
    
}