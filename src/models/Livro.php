<?php

require_once __DIR__ . '/../config/db.php';

class Livro{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($titulo, $autor, $usuario_id, $urlimagem , $comentario , $nota , $status ) {
        $query = "INSERT INTO livro (titulo, autor, usuario_id, urlimagem, comentario, nota, status) 
                  VALUES (:titulo, :autor, :usuario_id, :urlimagem, :comentario, :nota, :status)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':urlimagem', $urlimagem);
        $stmt->bindParam(':comentario', $comentario);
        $stmt->bindParam(':nota', $nota);
        $stmt->bindParam(':status', $status);
    
        return $stmt->execute();
    }
    

    public function update($id, $titulo, $autor, $urlimagem , $comentario , $nota , $status ) {
        $query = "UPDATE livro 
                  SET titulo = :titulo, autor = :autor, urlimagem = :urlimagem, 
                      comentario = :comentario, nota = :nota, status = :status 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':urlimagem', $urlimagem);
        $stmt->bindParam(':comentario', $comentario);
        $stmt->bindParam(':nota', $nota);
        $stmt->bindParam(':status', $status);
    
        return $stmt->execute();
    }
    

    public function delete($id) {
        $query = "DELETE FROM livro WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':id', $id);
    
        return $stmt->execute();
    }
    

    public function getAllByUserId($userId) {
        $query = "SELECT * FROM livro WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':usuario_id', $userId);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}