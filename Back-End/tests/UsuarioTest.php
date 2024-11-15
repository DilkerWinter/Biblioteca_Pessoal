<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/controllers/UsuarioController.php';

use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase{
    private $conn;
    private $usuario;

    protected function setUp(): void
    {
        $this->conn = new PDO('pgsql:host=localhost;dbname=phpprova', 'postgres', '123');  // Substitua pelos dados corretos
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->usuario = new Usuario($this->conn);
    }

    public function testCreateUsuario()
    {
        $nome = "usuario_teste";
        $senha = "senha123";

        $resultado = $this->usuario->create($nome, $senha);

        $this->assertTrue($resultado, "Erro ao criar usuário.");

        $checkSql = "SELECT COUNT(*) FROM usuario WHERE nome = :nome";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':nome', $nome);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        $this->assertEquals(1, $count, "Usuário não foi inserido no banco de dados.");
    }



    public function testCreateUsuarioNomeRepetido()
{
    $nome = "usuario_repetido";
    $senha = "senha123";
    $this->usuario->create($nome, $senha);

    $resultado = $this->usuario->create($nome, $senha);

    $this->assertFalse($resultado, "Usuário com nome repetido foi criado.");
}

public function testLoginSucesso()
{
    $nome = "usuario_teste_login";
    $senha = "senha123";
    
    $this->usuario->create($nome, $senha);

    $usuarioId = $this->usuario->login($nome, $senha);
    
    $this->assertNotFalse($usuarioId, "Login falhou com credenciais corretas.");
}


public function testLoginSenhaIncorreta()
{
    $nome = "usuario_teste_incorreto";
    $senha = "senha123";
    
    $this->usuario->create($nome, $senha);

    $usuarioId = $this->usuario->login($nome, "senhaErrada");

    $this->assertFalse($usuarioId, "Login com senha incorreta não falhou.");
}

public function testLoginUsuarioInexistente()
{
    $usuarioId = $this->usuario->login("usuario_inexistente", "qualquerSenha");

    $this->assertFalse($usuarioId, "Login com usuário inexistente não falhou.");
}



public function testDeleteUsuario()
{
    $nome = "usuario_teste_delete";
    $senha = "senha123";
    
    $this->usuario->create($nome, $senha);
    
    $usuarioId = $this->usuario->login($nome, $senha);

    $resultado = $this->usuario->delete($usuarioId);

    $this->assertTrue($resultado, "Erro ao deletar o usuário.");

    $usuarioDeletado = $this->usuario->findById($usuarioId);
    $this->assertNull($usuarioDeletado, "Usuário não foi deletado.");
}



public function testUsuarioNaoExiste()
{
    $nome = "usuario_inexistente";
    
    $existe = $this->usuario->usuarioJaExiste($nome);

    $this->assertFalse($existe, "O usuário não deveria existir.");
}


public function testUsuarioJaExiste()
{
    $nome = "usuario_existe";
    $senha = "senha123";
    
    $this->usuario->create($nome, $senha);
    
    $existe = $this->usuario->usuarioJaExiste($nome);

    $this->assertTrue($existe, "O usuário deveria existir.");
}

protected function tearDown(): void
{
    $this->conn->exec("DELETE FROM usuario WHERE nome = 'usuario_teste'");
}



}