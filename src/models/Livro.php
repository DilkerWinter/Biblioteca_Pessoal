<?php

require_once __DIR__ . '/../config/db.php';

class Livro{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($titulo, $autor, $urlImagem){

    }
}